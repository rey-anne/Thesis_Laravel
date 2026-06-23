@extends('layouts.admin')
@section('title', 'Metadata Validation')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Metadata Validation</h1>
<p style="color:var(--vf-muted);">Review GPS, timestamp, device, and AI assessment data submitted with each report.</p>

<table class="vf-admin-table">
    <thead>
        <tr>
            <th>Report</th>
            <th>GPS</th>
            <th>AI Fire Level</th>
            <th>Authenticity</th>
            <th>Duplicate?</th>
            <th>Validation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $report)
            <tr>
                <td>#{{ $report->id }} &middot; {{ $report->reported_at?->diffForHumans() }}</td>
                <td>{{ $report->has_gps_pin ? "{$report->latitude}, {$report->longitude}" : '—' }}</td>
                <td>{{ $report->ai_fire_level ?? '—' }}</td>
                <td>{{ $report->ai_authenticity_score !== null ? $report->ai_authenticity_score.'%' : '—' }}</td>
                <td>{{ $report->ai_is_duplicate ? 'Yes' : 'No' }}</td>
                <td>
                    @if($report->verified_by_crowdsourcing)
                        <span class="vf-status--verified">Validated</span>
                    @elseif($report->status === 'rejected')
                        <span class="vf-status--unverified">Rejected</span>
                    @else
                        <span class="vf-status--pending">Pending</span>
                    @endif
                </td>
                <td>
                    <div class="vf-admin-table__actions">
                        <form method="POST" action="{{ route('admin.metadata.validate', $report) }}">
                            @csrf
                            <input type="hidden" name="decision" value="validated">
                            <button type="submit">Validate</button>
                        </form>
                        <form method="POST" action="{{ route('admin.metadata.validate', $report) }}">
                            @csrf
                            <input type="hidden" name="decision" value="rejected">
                            <button type="submit">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No reports yet.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:18px;">{{ $reports->links() }}</div>
@endsection
