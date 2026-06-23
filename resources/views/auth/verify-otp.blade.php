@extends('layouts.app')
@section('title', 'Verify Code')

@section('content')
<div class="vf-auth-wrap">
    <div class="vf-auth-card">
        <h1>Enter Verification Code</h1>
        <p style="text-align:center;color:var(--vf-muted);font-size:14px;margin-top:-10px;margin-bottom:20px;">
            We sent a 6-digit code to <strong>{{ $email }}</strong>. It expires in 10 minutes.
        </p>

        @if($errors->any())
            <div class="vf-error" style="text-align:center;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $verifyAction }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

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

        <form method="POST" action="{{ $resendAction }}" style="margin-top:14px;">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="vf-link-btn" style="width:100%;text-align:center;color:var(--vf-red);font-weight:600;">Resend Code</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // auto-advance between OTP boxes
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
