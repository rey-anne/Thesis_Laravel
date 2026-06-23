@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="vf-auth-wrap">
    <div class="vf-auth-card">
        <h1>Forgot Password</h1>
        <p style="text-align:center;color:var(--vf-muted);font-size:14px;margin-top:-10px;margin-bottom:20px;">
            Enter the email linked to your account. We'll send a 6-digit code to reset your password.
        </p>

        @if($errors->any())
            <div class="vf-error" style="text-align:center;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.send-otp') }}">
            @csrf
            <label class="vf-label">Email</label>
            <input type="email" name="email" class="vf-input" required autofocus>

            <button type="submit" class="vf-btn" style="width:100%;">Send Code</button>

            <div class="vf-auth-links">
                <a href="{{ route('login') }}">Back to Log In</a>
                <a href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>
</div>
@endsection
