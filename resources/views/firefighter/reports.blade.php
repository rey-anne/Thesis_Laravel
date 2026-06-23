@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<div class="vf-dash">
    @include('partials.dash-sidebar', ['role' => 'firefighter'])
    <div class="vf-dash__main">
        <h1 style="color:var(--vf-red);margin-top:0;">Fire Reports</h1>
        <p style="color:var(--vf-muted);">View the reporter's location, route, and sent photo for each active report.</p>

        <div class="vf-report-list">
            <div class="vf-report-item">
                <span class="vf-status-dot vf-status-dot--active"></span>
                <div style="flex:1;">
                    <strong>Brgy. 101, Tondo, Manila</strong>
                    <p style="margin:2px 0;color:var(--vf-muted);font-size:13px;">Reported 12 mins ago &middot; AI Level: High</p>
                </div>
                <span title="GPS pin shared">&#128205;</span>
                <span title="Photo attached">&#128206;</span>
            </div>
        </div>
    </div>
</div>
@endsection
