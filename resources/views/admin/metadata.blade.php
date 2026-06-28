@extends('layouts.admin')
@section('title', 'Metadata Validation')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Metadata Validation</h1>
<p style="color:var(--vf-muted);">Review GPS, timestamp, and device data submitted with each report.</p>

<table class="vf-admin-table">
    <thead>
        <tr>
            <th>Report</th>
            <th>GPS</th>
            <th>Device Metadata</th>
            <th>Auto-Check</th>
            <th>Validation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $report)
            @php($validation = $report->validationSummary())
            <tr>
                <td>#{{ $report->id }} &middot; {{ $report->reported_at?->diffForHumans() }}</td>
                <td>
                    {{ $report->has_gps_pin ? "{$report->latitude}, {$report->longitude}" : '—' }}
                    @if($report->photo_metadata['gps_accuracy_m'] ?? null)
                        <br><small style="color:var(--vf-muted);">&plusmn;{{ round($report->photo_metadata['gps_accuracy_m']) }}m accuracy</small>
                    @endif
                </td>
                <td>
                    @if($report->photo_metadata)
                        <small style="color:var(--vf-muted);">{{ \Illuminate\Support\Str::limit($report->photo_metadata['device'] ?? '—', 60) }}</small>
                        @if($report->photo_metadata['captured_at'] ?? null)
                            <br><small style="color:var(--vf-muted);">Captured {{ \Illuminate\Support\Carbon::parse($report->photo_metadata['captured_at'])->diffForHumans() }}</small>
                        @endif
                    @else
                        —
                    @endif
                    @php($exif = $report->exif_metadata)
                    @if($exif)
                        <br>
                        @if($exif['image']['is_valid'] ?? null)
                            <small style="color:var(--vf-muted);">
                                EXIF: {{ $exif['datetime_original'] ? \Illuminate\Support\Carbon::parse($exif['datetime_original'])->format('M j, g:ia') : 'none found' }}
                                &middot; {{ $exif['image']['width'] }}&times;{{ $exif['image']['height'] }}
                                @if($exif['image']['is_blurry'] ?? false)
                                    &middot; <span style="color:var(--vf-red-deep);">blurry</span>
                                @endif
                            </small>
                        @elseif(($exif['image']['is_valid'] ?? null) === false)
                            <br><small style="color:var(--vf-red-deep);">Image file could not be decoded.</small>
                        @endif
                    @endif
                </td>
                <td>
                    <div class="vf-validation-panel vf-validation-panel--compact">
                        <span class="vf-validation-icon vf-validation-icon--{{ $validation['location'] }}" title="Reporter's Location: {{ ucfirst($validation['location']) }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        </span>
                        <span class="vf-validation-icon vf-validation-icon--{{ $validation['timestamp'] }}" title="Date and Time Submitted: {{ ucfirst($validation['timestamp']) }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
                        </span>
                        <span class="vf-validation-icon vf-validation-icon--{{ $validation['metadata'] }}" title="Image's Metadata: {{ ucfirst($validation['metadata']) }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.5"/></svg>
                        </span>
                    </div>
                </td>
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
            <tr><td colspan="6">No reports yet.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:18px;">{{ $reports->links() }}</div>
@endsection
