@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<section class="vf-section" style="max-width:760px;text-align:center;">

    <h1 style="color:var(--vf-ink);margin-bottom:10px;">About VeriFyre</h1>
    <p style="color:var(--vf-muted);max-width:600px;margin:0 auto 40px;">
        A secure, community-driven platform built to verify fire incidents and help the Bureau of Fire Protection respond faster.
    </p>

    <div class="vf-card" style="text-align:left;margin-bottom:24px;">
        <h3 style="color:var(--vf-ink);margin-top:0;text-align:center;">Our Objectives</h3>
        <ul style="color:var(--vf-muted);line-height:1.9;">
            <li>Authenticate fire incident reports using metadata and crowdsourced validation to reduce false alarms.</li>
            <li>Enable faster, more accurate Bureau of Fire Protection response through real-time location reporting.</li>
            <li>Apply cybersecurity best practices &mdash; role-based access, audit logging, and evidence integrity &mdash; throughout the system.</li>
            <li>Strengthen community participation through crowdsourced incident verification.</li>
            <li>Provide BFP personnel with a centralized, secure dashboard for monitoring and responding to incidents in Tondo, Manila.</li>
        </ul>
    </div>

    <div class="vf-card">
        <h3 style="color:var(--vf-ink);margin:0;">Developed by Innovision</h3>
        <p style="color:var(--vf-muted);margin:4px 0 0;">FEU Institute of Technology</p>
    </div>

</section>
@endsection
