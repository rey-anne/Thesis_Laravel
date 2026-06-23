@extends('layouts.admin')
@section('title', 'Fire Reports')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Fire Reports</h1>
<p style="color:var(--vf-muted);">Click a report to see its location, evidence, and AI assessment.</p>

<div class="vf-reports-grid">

    <div class="vf-report-list">
        @forelse($reports as $report)
            <div class="vf-report-item" onclick="vfShowReportDetail({{ $report->id }})">
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

    <div class="vf-card" id="vfReportDetail">
        <h3 style="margin-top:0;color:var(--vf-red);">Select a report</h3>
        <p style="color:var(--vf-muted);">Report details, location, photo evidence, and AI fire-level assessment will appear here.</p>
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

                panel.innerHTML = `
                    <h3 style="margin-top:0;color:var(--vf-red);">Report #${r.id}</h3>
                    <p><span class="vf-badge">AI Fire Level: ${r.ai_fire_level ?? 'Pending'}</span></p>
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
