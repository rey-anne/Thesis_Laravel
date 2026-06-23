@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<section class="vf-section" style="max-width:800px;">
    <h1 style="color:var(--vf-red);text-align:center;">About VeriFyre</h1>

    <div class="vf-card" style="margin-bottom:24px;">
        <h3 style="color:var(--vf-red);margin-top:0;">Our Objectives</h3>
        <ul style="color:var(--vf-muted);line-height:1.8;">
            <li>Authenticate fire incident reports using AI-assisted metadata validation to reduce false alarms.</li>
            <li>Enable faster, more accurate Bureau of Fire Protection response through real-time location reporting.</li>
            <li>Apply cybersecurity best practices - role-based access, audit logging, and evidence integrity - throughout the system.</li>
            <li>Strengthen community participation through crowdsourced incident verification.</li>
            <li>Provide BFP personnel with a centralized, secure dashboard for monitoring and responding to incidents in Tondo, Manila.</li>
        </ul>
    </div>

    <div class="vf-card" style="text-align:center;">
        <img src="{{ asset('images/logo.png') }}" alt="VeriFyre logo" style="width:90px;height:90px;border-radius:50%;margin-bottom:12px;">
        <h3 style="color:var(--vf-red);margin:0;">Developed by Innovision</h3>
        <p style="color:var(--vf-muted);">FEU Institute of Technology</p>
    </div>
</section>
@endsection
