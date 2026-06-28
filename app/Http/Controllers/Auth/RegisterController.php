<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'role' => 'required|in:bfp_firefighter,admin',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|max:30|unique:users,contact_number',
            'password' => 'required|min:8|confirmed',
        ]);

        // Stash the pending registration in the session until OTP is verified.
        // We do NOT create the user row yet, so an unverified email can't
        // squat on an address.
        Session::put('pending_registration', [
            'full_name' => $data['full_name'],
            'role' => $data['role'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);

        $this->generateAndSendOtp($data['email'], 'email_verification');

        return redirect()->route('register.otp', ['email' => $data['email']]);
    }

    public function showOtp(Request $request)
    {
        return view('auth.verify-otp', [
            'email' => $request->query('email'),
            'verifyAction' => route('register.otp.verify'),
            'resendAction' => route('register.otp.resend'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $code = $request->otp_1.$request->otp_2.$request->otp_3.$request->otp_4.$request->otp_5.$request->otp_6;

        $otp = Otp::where('email', $request->email)
            ->where('purpose', 'email_verification')
            ->where('is_used', false)
            ->latest('id')
            ->first();

        if (!$otp || $otp->otp_code !== $code || $otp->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired code. Please try again or resend.']);
        }

        $pending = Session::get('pending_registration');
        if (!$pending || $pending['email'] !== $request->email) {
            return redirect()->route('register')->withErrors(['email' => 'Your registration session expired. Please register again.']);
        }

        $otp->update(['is_used' => true]);

        // Account is created but stays "pending" until a Super Administrator
        // approves it (per the RBAC approval-trail requirement).
        User::create([
            'role' => $pending['role'],
            'full_name' => $pending['full_name'],
            'email' => $pending['email'],
            'contact_number' => $pending['contact_number'],
            'password' => $pending['password'],
            'account_status' => 'pending',
            'date_registered' => now(),
        ]);

        Session::forget('pending_registration');

        return redirect()->route('login')->with('status', 'Your email is verified. Your account is now awaiting Super Administrator approval.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $this->generateAndSendOtp($request->email, 'email_verification');

        return back()->with('status', 'A new code has been sent.');
    }

    private function generateAndSendOtp(string $email, string $purpose): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'email' => $email,
            'otp_code' => $code,
            'purpose' => $purpose,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new OtpMail($code, $purpose));
    }
}
