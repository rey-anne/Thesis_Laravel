@extends('layouts.app')
@section('title', 'Verify Login')

@section('content')
<div class="vf-auth-wrap">
    <div class="vf-auth-card">
        <h1>Enter Verification Code</h1>
        <p style="text-align:center;color:var(--vf-muted);font-size:14px;margin-top:-10px;margin-bottom:20px;">
            For your security, every login requires a 6-digit code. It expires in 10 minutes.
        </p>

        @if (session('status'))
            <div class="vf-error" style="text-align:center;background:#e8f7ee;color:#1b6b3a;">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="vf-error" style="text-align:center;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.otp.verify') }}">
            @csrf

            <div class="vf-otp-inputs">
                <input type="text" name="otp_1" maxlength="1" inputmode="numeric" required>
                <input type="text" name="otp_2" maxlength="1" inputmode="numeric" required>
                <input type="text" name="otp_3" maxlength="1" inputmode="numeric" required>
                <input type="text" name="otp_4" maxlength="1" inputmode="numeric" required>
                <input type="text" name="otp_5" maxlength="1" inputmode="numeric" required>
                <input type="text" name="otp_6" maxlength="1" inputmode="numeric" required>
            </div>

            <button type="submit" class="vf-btn" style="width:100%;">Verify</button>
        </form>

        <p class="vf-otp-channels__label">Send the code to:</p>

        <div class="vf-otp-channels">
            <form method="POST" action="{{ route('login.otp.resend') }}" class="vf-otp-channel-form">
                @csrf
                <input type="hidden" name="channel" value="email">
                <button type="submit" class="vf-otp-channel {{ $activeChannel === 'email' ? 'vf-otp-channel--active' : '' }}">
                    <span class="vf-otp-channel__icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 6.5C3 5.67 3.67 5 4.5 5h15c.83 0 1.5.67 1.5 1.5v11c0 .83-.67 1.5-1.5 1.5h-15A1.5 1.5 0 0 1 3 17.5v-11Z" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M4 6.5 12 13l8-6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="vf-otp-channel__text">
                        <span class="vf-otp-channel__title">Email</span>
                        <span class="vf-otp-channel__value">{{ $email }}</span>
                    </span>
                    @if($activeChannel === 'email')
                        <span class="vf-otp-channel__badge">Sent</span>
                    @endif
                </button>
            </form>

            <form method="POST" action="{{ route('login.otp.resend') }}" class="vf-otp-channel-form">
                @csrf
                <input type="hidden" name="channel" value="sms">
                <button type="submit" class="vf-otp-channel {{ $activeChannel === 'sms' ? 'vf-otp-channel--active' : '' }}">
                    <span class="vf-otp-channel__icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 11.5c0 4.14-4.03 7.5-9 7.5-1.06 0-2.08-.15-3.02-.42L4 20l1.18-3.54C3.81 15.13 3 13.4 3 11.5 3 7.36 7.03 4 12 4s9 3.36 9 7.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="vf-otp-channel__text">
                        <span class="vf-otp-channel__title">SMS</span>
                        <span class="vf-otp-channel__value">{{ $phone }}</span>
                    </span>
                    @if($activeChannel === 'sms')
                        <span class="vf-otp-channel__badge">Sent</span>
                    @endif
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.vf-otp-inputs input').forEach(function (input, idx, all) {
        input.addEventListener('input', function () {
            if (this.value.length === 1 && all[idx + 1]) all[idx + 1].focus();
        });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && this.value === '' && all[idx - 1]) all[idx - 1].focus();
        });
    });
</script>
@endpush
