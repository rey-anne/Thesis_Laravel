@extends('layouts.admin')
@section('title', 'Fire Reports')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Fire Reports</h1>
<p style="color:var(--vf-muted);">Click a report to see its location and evidence.</p>

<div class="vf-reports-grid">

    <div class="vf-report-list">
        @forelse($reports as $report)
            @php($validation = $report->validationSummary())
            <div class="vf-report-item" onclick="vfShowReportDetail({{ $report->id }})">
                <span class="vf-status-dot {{ $report->status === 'extinguished' ? 'vf-status-dot--extinguished' : 'vf-status-dot--active' }}"></span>
                <div style="flex:1;">
                    <strong>Report #{{ $report->id }}</strong>
                    <p style="margin:2px 0;color:var(--vf-muted);font-size:13px;">
                        {{ $report->reported_at?->diffForHumans() ?? 'Just now' }} &middot; {{ ucfirst($report->status) }}
                    </p>
                </div>
                <div class="vf-validation-panel vf-validation-panel--compact" title="Credibility check">
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
            </div>
        @empty
            <p style="color:var(--vf-muted);">No fire reports yet.</p>
        @endforelse
    </div>

    <div class="vf-card" id="vfReportDetail">
        <h3 style="margin-top:0;color:var(--vf-red);">Select a report</h3>
        <p style="color:var(--vf-muted);">Report details, location, and photo evidence will appear here.</p>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/leaflet-map.js') }}"></script>
<script>
    const vfReportShowUrl = "{{ route('admin.reports.show', ['report' => '__ID__']) }}";
    const vfReportStatusUrl = "{{ route('admin.reports.update-status', ['report' => '__ID__']) }}";
    const vfCsrfToken = "{{ csrf_token() }}";

    function vfShowReportDetail(id) {
        const panel = document.getElementById('vfReportDetail');
        panel.innerHTML = '<p style="color:var(--vf-muted);">Loading...</p>';

        fetch(vfReportShowUrl.replace('__ID__', id))
            .then(res => res.json())
            .then(r => {
                const photo = r.photo_url
                    ? `<img src="${r.photo_url}" style="width:100%;border-radius:12px;margin-bottom:12px;" alt="Reported photo">`
                    : '';
                const map = (r.latitude && r.longitude) ? `<div id="vfReportMap" class="vf-map" style="height:240px;margin-bottom:16px;"></div>` : '';
                const v = r.validation || { location: 'warning', timestamp: 'warning', metadata: 'warning' };
                const validationPanel = `
                    <div class="vf-validation-panel" style="margin-bottom:16px;">
                        <div class="vf-validation-item">
                            <span class="vf-validation-icon vf-validation-icon--${v.location}" title="${v.location}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            </span>
                            <span class="vf-validation-label">Reporter's Location</span>
                        </div>
                        <div class="vf-validation-item">
                            <span class="vf-validation-icon vf-validation-icon--${v.timestamp}" title="${v.timestamp}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
                            </span>
                            <span class="vf-validation-label">Date and Time Submitted</span>
                        </div>
                        <div class="vf-validation-item">
                            <span class="vf-validation-icon vf-validation-icon--${v.metadata}" title="${v.metadata}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.5"/></svg>
                            </span>
                            <span class="vf-validation-label">Image's Metadata</span>
                        </div>
                    </div>
                `;

                panel.innerHTML = `
                    <h3 style="margin-top:0;color:var(--vf-red);">Report #${r.id}</h3>
                    ${validationPanel}
                    ${map}
                    ${photo}
                    <div style="display:flex;gap:10px;">
                        <button class="vf-btn vf-btn--outline" onclick="vfMarkExtinguished(${r.id})" ${r.status === 'extinguished' ? 'disabled' : ''}>
                            ${r.status === 'extinguished' ? 'Extinguished' : 'Mark Extinguished'}
                        </button>
                    </div>
                `;

                if (r.latitude && r.longitude) {
                    const map = L.map('vfReportMap').setView([r.latitude, r.longitude], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    L.marker([r.latitude, r.longitude]).addTo(map);
                }
            });
    }

    function vfMarkExtinguished(id) {
        fetch(vfReportStatusUrl.replace('__ID__', id), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': vfCsrfToken },
            body: JSON.stringify({ status: 'extinguished' }),
        }).then(() => window.location.reload());
    }
</script>
@endpush
