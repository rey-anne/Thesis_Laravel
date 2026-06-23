@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="vf-auth-wrap">
    <div class="vf-auth-card">
        <h1>Register</h1>
        <p style="text-align:center;color:var(--vf-muted);font-size:14px;margin-top:-10px;margin-bottom:20px;">
            For BFP Firefighter and Admin accounts. New accounts require Super Administrator approval before logging in.
        </p>

        @if($errors->any())
            <div class="vf-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.attempt') }}">
            @csrf
            <label class="vf-label">Full Name</label>
            <input type="text" name="full_name" class="vf-input" required>

            <label class="vf-label">Requested Role</label>
            <select name="role" class="vf-input" required>
                <option value="bfp_firefighter">BFP Firefighter</option>
                <option value="admin">Admin (BFP Higher Position)</option>
            </select>

            <label class="vf-label">Email</label>
            <input type="email" name="email" class="vf-input" required>

            <label class="vf-label">Contact Number</label>
            <input type="text" name="contact_number" class="vf-input" required>

            <label class="vf-label">Password</label>
            <input type="password" name="password" class="vf-input" required>

            <label class="vf-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="vf-input" required>

            <button type="submit" class="vf-btn" style="width:100%;">Send Verification Code</button>

            <div class="vf-auth-links">
                <a href="{{ route('login') }}">Back to Log In</a>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>
@endsection
