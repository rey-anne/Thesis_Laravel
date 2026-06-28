<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Credential/OTP attempts, keyed by email+IP so one attacker can't
        // burn through an account from many IPs, nor brute-force OTPs fast.
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email').'|'.$request->ip());
        });

        RateLimiter::for('otp', function (Request $request) {
            $key = $request->input('email') ?: $request->session()->get('pending_login_user_id');

            return Limit::perMinute(5)->by($key.'|'.$request->ip());
        });

        RateLimiter::for('otp-resend', function (Request $request) {
            $key = $request->input('email') ?: $request->session()->get('pending_login_user_id');

            return Limit::perMinute(3)->by($key.'|'.$request->ip());
        });
    }
}
