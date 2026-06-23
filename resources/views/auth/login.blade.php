@extends('layouts.app')

@section('title', 'Log In')

@section('content')

<section class="vf-auth-wrap">
    <div class="vf-auth-card">

        <h1>Log In</h1>
        <p style="text-align:center;color:var(--vf-muted);margin-bottom:26px;">
            Access your VeriFyre account.
        </p>

        @if (session('error'))
            <div class="vf-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="vf-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <label for="email" class="vf-label">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="vf-input"
                value="{{ old('email') }}"
                required
                autofocus
            >

            <label for="password" class="vf-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="vf-input"
                required
            >

            <button type="submit" class="vf-btn vf-auth-submit">
                Log In
            </button>
        </form>

        <div class="vf-auth-links">
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

    </div>
</section>

@endsection