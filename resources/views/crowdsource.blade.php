@extends('layouts.app')
@section('title', 'Crowdsource')

@section('content')
<section class="vf-section">
    <h1 style="color:var(--vf-red);text-align:center;">Crowdsource</h1>
    <p style="text-align:center;color:var(--vf-muted);max-width:560px;margin:0 auto 32px;">
        See active fire reports near your shared location and help verify them.
    </p>

    {{-- State 1: nearby active fires found --}}
    <div id="vfCrowdsourceHasFires" style="display:none;">
        <div id="vfCrowdsourceMap" class="vf-map" style="margin-bottom:24px;"></div>
        <div class="vf-report-list" id="vfCrowdsourceList"></div>
    </div>

    {{-- State 2: no active fires nearby --}}
    <div id="vfCrowdsourceEmpty" class="vf-card" style="display:none;text-align:center;max-width:520px;margin:0 auto;">
        <h3 style="margin-top:0;color:var(--vf-ink);">There are no active fires near you!</h3>
        <p style="color:var(--vf-muted);">If you see one, make sure to report it right away.</p>
        <a href="{{ route('report.create') }}" class="vf-btn">Report a Fire</a>
    </div>

    {{-- Waiting for location permission --}}
    <div id="vfCrowdsourceLoading" class="vf-card" style="text-align:center;max-width:520px;margin:0 auto;">
        <p style="color:var(--vf-muted);margin:0;">Checking for active fires near your location...</p>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/leaflet-map.js') }}"></script>
<script>
    /**
     * DEMO DATA ONLY - mirrors the sample reports on the Admin Reports
     * page. Replace with a real API call (e.g. GET /api/reports/nearby)
     * once the backend can query fire_reports by distance.
     */
    const vfDemoActiveFires = [
        { id: 1, location: 'Brgy. 101, Tondo, Manila', lat: 14.6190, lng: 120.9706 },
        { id: 2, location: 'Brgy. 98, Tondo, Manila', lat: 14.6205, lng: 120.9690 },
    ];

    const NEARBY_RADIUS_KM = 5;

    function vfHaversineKm(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function vfRenderNearbyFires(userLat, userLng) {
        document.getElementById('vfCrowdsourceLoading').style.display = 'none';

        const nearby = vfDemoActiveFires.filter(f => vfHaversineKm(userLat, userLng, f.lat, f.lng) <= NEARBY_RADIUS_KM);

        if (nearby.length === 0) {
            document.getElementById('vfCrowdsourceEmpty').style.display = 'block';
            return;
        }

        document.getElementById('vfCrowdsourceHasFires').style.display = 'block';

        const list = document.getElementById('vfCrowdsourceList');
        list.innerHTML = nearby.map(f => `
            <div class="vf-report-item">
                <span class="vf-status-dot vf-status-dot--active"></span>
                <div style="flex:1;">
                    <strong>${f.location}</strong>
                </div>
                <span class="vf-badge">Active</span>
            </div>
        `).join('');

        const map = L.map('vfCrowdsourceMap').setView([userLat, userLng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
        L.marker([userLat, userLng]).addTo(map).bindPopup('You are here').openPopup();
        nearby.forEach(f => L.marker([f.lat, f.lng]).addTo(map).bindPopup(f.location));
    }

    document.addEventListener('vf:location', function (e) {
        vfRenderNearbyFires(e.detail.lat, e.detail.lng);
    });

    document.addEventListener('vf:location-denied', function () {
        document.getElementById('vfCrowdsourceLoading').innerHTML =
            '<p style="color:var(--vf-muted);margin:0;">We need your location to check for nearby fires. Please allow location access and reload this page.</p>';
    });
</script>
@endpush
