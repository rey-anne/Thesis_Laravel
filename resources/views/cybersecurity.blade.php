@extends('layouts.app')
@section('title', 'Cybersecurity')

@section('content')
<section class="vf-section vf-edu">
    <div class="vf-edu-header">
        <span class="vf-edu-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/></svg>
            Security &amp; Trust
        </span>
        <h1>Cybersecurity at the Core of VeriFyre</h1>
        <p>VeriFyre was designed with cybersecurity compliance as a foundational requirement, not an afterthought &mdash; protecting reporters, responders, and incident data at every step.</p>
    </div>

    <div class="vf-edu-cards">

        <div class="vf-edu-card vf-edu-box--gold">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
            </span>
            <h3>Metadata Validation</h3>
            <p>Every submitted photo is checked for authentic capture metadata to help flag manipulated, duplicated, or recycled images before they reach responders.</p>
        </div>

        <div class="vf-edu-card vf-edu-box--ember">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M21 11a2 2 0 0 0-2-2h-2V7a5 5 0 0 0-10 0v2H5a2 2 0 0 0-2 2v2a9 9 0 0 0 9 9 9 9 0 0 0 9-9v-2z"/><circle cx="12" cy="13" r="2"/></svg>
            </span>
            <h3>Role-Based Access Control</h3>
            <p>Firefighters, Admins, and the Super Administrator each have strictly scoped permissions, so no account can see or change more than its role allows.</p>
        </div>

        <div class="vf-edu-card vf-edu-box--crimson">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h3"/></svg>
            </span>
            <h3>Audit Logging</h3>
            <p>Sensitive actions across the system are recorded in an audit trail, supporting accountability and post-incident review.</p>
        </div>

        <div class="vf-edu-card vf-edu-box--maroon">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
            </span>
            <h3>Secure Account Verification</h3>
            <p>Account registration and password recovery are protected by one-time passcode (OTP) email verification.</p>
        </div>

        <div class="vf-edu-card vf-edu-box--rust">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
            </span>
            <h3>Evidence Integrity</h3>
            <p>Reported evidence (photos, location data) cannot be altered by Admin accounts, preserving the chain of custody for every report.</p>
        </div>

        <div class="vf-edu-card vf-edu-box--coral">
            <span class="vf-edu-box__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><circle cx="9" cy="8" r="3"/><path d="M3 20c0-3 2.5-5 6-5s6 2 6 5"/><circle cx="17.5" cy="9" r="2.5"/><path d="M21.5 19.5c0-2.2-1.8-3.8-4-4"/></svg>
            </span>
            <h3>Crowdsourced Verification</h3>
            <p>Nearby community members can help confirm active reports, adding an extra layer of validation against false alarms.</p>
        </div>

    </div>
</section>
@endsection

@push('styles')
<style>
    .vf-edu-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        align-items: start;
        gap: 20px;
    }

    .vf-edu-card {
        background: var(--vf-surface);
        border: 1px solid var(--vf-line);
        border-left: 5px solid var(--vf-edu-accent, var(--vf-red));
        border-radius: var(--vf-radius);
        box-shadow: var(--vf-shadow-sm);
        padding: 26px;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    .vf-edu-card:hover {
        box-shadow: 0 14px 28px color-mix(in srgb, var(--vf-edu-accent, var(--vf-red)) 30%, transparent);
        transform: translateY(-3px) scale(1.01);
    }

    .vf-edu-card .vf-edu-box__icon {
        margin-bottom: 16px;
    }

    .vf-edu-card:hover .vf-edu-box__icon {
        transform: scale(1.15) rotate(-6deg);
    }

    .vf-edu-card h3 {
        margin: 0 0 10px;
        font-size: 18px;
        color: var(--vf-ink);
    }

    .vf-edu-card p {
        margin: 0;
        color: var(--vf-muted);
        line-height: 1.6;
        font-size: 15px;
    }

    @media (max-width: 700px) {
        .vf-edu {
            padding: 40px 16px;
        }

        .vf-edu-header h1 {
            font-size: 26px;
        }

        .vf-edu-header p {
            font-size: 14px;
        }

        .vf-edu-card {
            padding: 20px;
        }

        .vf-edu-card:hover {
            transform: translateY(-1px);
        }
    }
</style>
@endpush
