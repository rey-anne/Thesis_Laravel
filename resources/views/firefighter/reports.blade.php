@extends('layouts.firefighter')
@section('title', 'Reports')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Fire Reports</h1>
<p style="color:var(--vf-muted);">View the reporter's location, route, and sent photo for each active report.</p>

<div class="vf-report-list">
    @forelse($reports as $report)
        <div class="vf-report-item">
            <span class="vf-status-dot {{ $report->status === 'extinguished' ? 'vf-status-dot--extinguished' : 'vf-status-dot--active' }}"></span>
            <div style="flex:1;">
                <strong>Report #{{ $report->id }}</strong>
                <p style="margin:2px 0;color:var(--vf-muted);font-size:13px;">
                    {{ $report->reported_at?->diffForHumans() ?? 'Just now' }} &middot; {{ ucfirst($report->status) }}
                </p>
            </div>
            @if($report->has_gps_pin)<span title="GPS pin shared">&#128205;</span>@endif
            @if($report->has_file_attachment)<span title="Photo attached">&#128206;</span>@endif
        </div>
    @empty
        <p style="color:var(--vf-muted);">No fire reports yet.</p>
    @endforelse
</div>
@endsection
