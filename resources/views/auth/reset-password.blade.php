@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="vf-auth-wrap">
    <div class="vf-auth-card">
        <h1>Set a New Password</h1>

        @if($errors->any())
            <div class="vf-error" style="text-align:center;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.reset.attempt') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <label class="vf-label">New Password</label>
            <input type="password" name="password" class="vf-input" required>

            <label class="vf-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="vf-input" required>

            <button type="submit" class="vf-btn" style="width:100%;">Reset Password</button>
        </form>
    </div>
</div>
@endsection
