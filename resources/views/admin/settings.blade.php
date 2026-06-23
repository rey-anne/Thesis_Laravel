@extends('layouts.admin')
@section('title', 'System Settings')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">System Settings</h1>

<form method="POST" action="{{ route('admin.settings.update') }}" class="vf-card" style="max-width:520px;">
    @csrf

    <label class="vf-label">System Name</label>
    <input class="vf-input" type="text" name="system_name" value="{{ $settings['system_name'] }}">

    <label class="vf-label">Location Coverage</label>
    <input class="vf-input" type="text" name="location_coverage" value="{{ $settings['location_coverage'] }}" placeholder="e.g. Tondo, Manila">

    <label class="vf-label">Support Email</label>
    <input class="vf-input" type="email" name="support_email" value="{{ $settings['support_email'] }}">

    <label style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
        <input type="checkbox" name="otp_enabled" value="1" {{ $settings['otp_enabled'] === '1' ? 'checked' : '' }}>
        <span>Require OTP verification at registration / login</span>
    </label>

    <button type="submit" class="vf-btn">Save Settings</button>
</form>
@endsection
