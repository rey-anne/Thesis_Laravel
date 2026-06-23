@extends('layouts.app')
@section('title', 'Cybersecurity')

@section('content')
<section class="vf-section">
    <h1 style="color:var(--vf-red);text-align:center;">Cybersecurity at the Core of VeriFyre</h1>
    <p style="text-align:center;max-width:700px;margin:0 auto 40px;color:var(--vf-muted);">
        VeriFyre was designed with cybersecurity compliance as a foundational requirement, not an afterthought - protecting reporters, responders, and incident data at every step.
    </p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;">

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Metadata Validation</h3>
            <p style="color:var(--vf-muted);">Every submitted photo is checked for authentic capture metadata to help flag manipulated, duplicated, or recycled images before they reach responders.</p>
        </div>

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Role-Based Access Control</h3>
            <p style="color:var(--vf-muted);">Firefighters, Admins, and the Super Administrator each have strictly scoped permissions, so no account can see or change more than its role allows.</p>
        </div>

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Audit Logging</h3>
            <p style="color:var(--vf-muted);">Sensitive actions across the system are recorded in an audit trail, supporting accountability and post-incident review.</p>
        </div>

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Secure Account Verification</h3>
            <p style="color:var(--vf-muted);">Account registration and password recovery are protected by one-time passcode (OTP) email verification.</p>
        </div>

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Evidence Integrity</h3>
            <p style="color:var(--vf-muted);">Reported evidence (photos, location data) cannot be altered by Admin accounts, preserving the chain of custody for every report.</p>
        </div>

        <div class="vf-card">
            <h3 style="color:var(--vf-red);">Crowdsourced Verification</h3>
            <p style="color:var(--vf-muted);">Nearby community members can help confirm active reports, adding an extra layer of validation against false alarms.</p>
        </div>

    </div>
</section>
@endsection
