<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\ActivityLog;
use App\Models\Otp;
use App\Models\User;
use App\Services\SemaphoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::validate($credentials)) {
            ActivityLog::record('login_failed', "Failed login attempt for {$credentials['email']}");
            return back()->withErrors(['email' => 'Incorrect email or password.']);
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user->account_status === 'pending') {
            return back()->withErrors(['email' => 'Your account is awaiting Super Administrator approval.']);
        }

        if (in_array($user->account_status, ['suspended', 'revoked'])) {
            return back()->withErrors(['email' => 'This account has been '.$user->account_status.'. Contact a Super Administrator.']);
        }

        Session::put('pending_login_user_id', $user->id);
        Session::put('pending_login_otp_channel', 'email');

        $this->generateAndSendOtp($user, 'email');

        return redirect()->route('login.otp');
    }

    public function showOtp()
    {
        $user = $this->pendingUser();
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in again.']);
        }

        return view('auth.login-otp', [
            'email' => $this->maskEmail($user->email),
            'phone' => $this->maskPhone($user->contact_number),
            'activeChannel' => Session::get('pending_login_otp_channel', 'email'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $user = $this->pendingUser();
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in again.']);
        }

        $code = $request->otp_1.$request->otp_2.$request->otp_3.$request->otp_4.$request->otp_5.$request->otp_6;

        $otp = Otp::where('email', $user->email)
            ->where('purpose', 'login')
            ->where('is_used', false)
            ->latest('id')
            ->first();

        if (!$otp || $otp->otp_code !== $code || $otp->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired code. Please try again or resend.']);
        }

        $otp->update(['is_used' => true]);

        Auth::login($user);
        $request->session()->regenerate();
        Session::forget(['pending_login_user_id', 'pending_login_otp_channel']);

        $user->update(['last_login_at' => now()]);
        ActivityLog::record('login', "{$user->full_name} logged in", $user->id);

        return match ($user->role) {
            'bfp_firefighter' => redirect()->route('firefighter.home'),
            default => redirect()->route('admin.home'), // admin + superadmin
        };
    }

    public function resendOtp(Request $request)
    {
        $user = $this->pendingUser();
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in again.']);
        }

        $channel = $request->input('channel') === 'sms' ? 'sms' : 'email';
        $sent = $this->generateAndSendOtp($user, $channel);

        if (!$sent) {
            return back()->withErrors(['otp' => 'We could not send the code via SMS right now. Please try email instead.']);
        }

        Session::put('pending_login_otp_channel', $channel);

        return back()->with('status', $channel === 'sms' ? 'A new code has been sent via SMS.' : 'A new code has been sent to your email.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::record('logout', "{$user->full_name} logged out", $user->id);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email);
        $visible = substr($name, 0, 2);

        return $visible.str_repeat('*', max(strlen($name) - 2, 1)).'@'.$domain;
    }

    private function maskPhone(string $phone): string
    {
        $last = substr($phone, -2);

        return str_repeat('*', max(strlen($phone) - 2, 1)).$last;
    }

    private function pendingUser(): ?User
    {
        $userId = Session::get('pending_login_user_id');

        return $userId ? User::find($userId) : null;
    }

    private function generateAndSendOtp(User $user, string $channel): bool
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'email' => $user->email,
            'otp_code' => $code,
            'purpose' => 'login',
            'channel' => $channel,
            'phone' => $channel === 'sms' ? $user->contact_number : null,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        if ($channel === 'sms') {
            return app(SemaphoreService::class)->sendOtp($user->contact_number, $code);
        }

        Mail::to($user->email)->send(new OtpMail($code, 'login'));

        return true;
    }
}
