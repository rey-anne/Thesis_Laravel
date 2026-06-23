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

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'email' => $request->email,
            'otp_code' => $code,
            'purpose' => 'password_reset',
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new OtpMail($code, 'password_reset'));

        return redirect()->route('password.otp', ['email' => $request->email]);
    }

    public function showOtp(Request $request)
    {
        return view('auth.verify-otp', [
            'email' => $request->query('email'),
            'verifyAction' => route('password.otp.verify'),
            'resendAction' => route('password.send-otp'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $code = $request->otp_1.$request->otp_2.$request->otp_3.$request->otp_4.$request->otp_5.$request->otp_6;

        $otp = Otp::where('email', $request->email)
            ->where('purpose', 'password_reset')
            ->where('is_used', false)
            ->latest('id')
            ->first();

        if (!$otp || $otp->otp_code !== $code || $otp->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired code. Please try again or resend.']);
        }

        $otp->update(['is_used' => true]);
        Session::put('password_reset_email', $request->email);

        return redirect()->route('password.reset');
    }

    public function showReset()
    {
        $email = Session::get('password_reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', ['email' => $email]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if (Session::get('password_reset_email') !== $data['email']) {
            return redirect()->route('password.request')->withErrors(['email' => 'Session expired. Please request a new code.']);
        }

        User::where('email', $data['email'])->update(['password' => Hash::make($data['password'])]);
        Session::forget('password_reset_email');

        return redirect()->route('login')->with('status', 'Password updated. You can now log in.');
    }
}
