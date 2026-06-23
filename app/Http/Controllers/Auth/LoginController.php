<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (!Auth::attempt($credentials)) {
            ActivityLog::record('login_failed', "Failed login attempt for {$credentials['email']}");
            return back()->withErrors(['email' => 'Incorrect email or password.']);
        }

        $user = Auth::user();

        if ($user->account_status === 'pending') {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account is awaiting Super Administrator approval.']);
        }

        if (in_array($user->account_status, ['suspended', 'revoked'])) {
            Auth::logout();
            return back()->withErrors(['email' => 'This account has been '.$user->account_status.'. Contact a Super Administrator.']);
        }

        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        ActivityLog::record('login', "{$user->full_name} logged in", $user->id);

        return match ($user->role) {
            'bfp_firefighter' => redirect()->route('firefighter.home'),
            default => redirect()->route('admin.home'), // admin + superadmin
        };
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
}
