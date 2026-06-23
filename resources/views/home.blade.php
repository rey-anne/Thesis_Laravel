@extends('layouts.app')
@section('title', 'Home')

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        .vf-map {
            height: 420px;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            margin-top: 18px;
        }

        .vf-location-status {
            margin-top: 12px;
            color: var(--vf-muted);
            font-size: 14px;
        }
    </style>
@endpush

@section('content')

<section class="vf-hero" style="background-image: url('{{ asset('images/hero-bfp-building.png') }}');">
    <div class="vf-hero__content">
        <h1>Validate. Respond. Protect.</h1>
        <p>Empowering communities through secure fire incident reporting, metadata validation, and real-time heatmap for safer Tondo, Manila.</p>
        <a href="{{ route('report.create') }}" class="vf-btn">Report a Fire</a>
    </div>
</section>

<section class="vf-section">
    <div class="vf-card">
        <h2 style="margin-top:0;">Your Location</h2>
        <p style="color:var(--vf-muted);">
            We use your shared location to pinpoint your report accurately. You'll be asked for permission by your browser.
        </p>

        <div id="vfUserMap" class="vf-map"></div>
        <p id="vfLocationStatus" class="vf-location-status">Requesting your location...</p>
    </div>
</section>

{{-- ===================== Crowdsourcing popup ===================== --}}
<div class="vf-modal-overlay" id="vfCrowdsourceOverlay">
    <div class="vf-crowdsource-modal">

        <div id="vfCrowdsourcePromptStage">
            <h2>Nearby Fire Reported</h2>
            <p>Someone near your location just reported a fire. Can you help verify it?</p>
            <button id="vfCrowdsourceVerifyBtn" class="vf-verify-btn">Verify</button>
            <p style="font-size:13px;color:var(--vf-muted);">
                Tapping Verify opens your camera to take a quick photo of what you see.
            </p>
        </div>

        <div id="vfCrowdsourceCameraStage" style="display:none;">
            <h2>Verify This Report</h2>
            <div class="vf-camera-box" style="max-width:280px;margin:0 auto 16px;">
                <video id="vfCrowdsourceVideo" autoplay playsinline></video>
                <canvas id="vfCrowdsourceCanvas" style="display:none;"></canvas>
            </div>
            <button id="vfCrowdsourceCaptureBtn" class="vf-btn">Capture Photo</button>
        </div>

        <div id="vfCrowdsourceSuccessStage" style="display:none;">
            <div class="vf-success-icon">&#10003;</div>
            <h2>Successfully submitted report</h2>
            <p>
                Thank you for helping verify this incident. Your confirmation is now with our system,
                and the report is currently being handled by the Bureau of Fire Protection.
            </p>
            <button id="vfCrowdsourceDial911" class="vf-btn">Continue</button>
        </div>

        <form id="vfCrowdsourceForm" method="POST" action="{{ route('crowdsource.verify') }}" style="display:none;">
            @csrf
            <input type="hidden" id="vfCrowdsourceReportId" name="fire_report_id">
            <input type="hidden" id="vfCrowdsourcePhotoData" name="verification_photo_data">
        </form>

    </div>
</div>

@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mapElement = document.getElementById("vfUserMap");
            const status = document.getElementById("vfLocationStatus");

            if (!mapElement) {
                console.error("Map container not found.");
                return;
            }

            // Default center: Tondo, Manila
            const defaultLat = 14.6175;
            const defaultLng = 120.9670;

            const map = L.map("vfUserMap").setView([defaultLat, defaultLng], 14);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: "&copy; OpenStreetMap contributors"
            }).addTo(map);

            L.marker([defaultLat, defaultLng])
                .addTo(map)
                .bindPopup("Tondo, Manila monitoring area");

            // Fix map not showing properly inside styled containers
            setTimeout(function () {
                map.invalidateSize();
            }, 300);

            if (!navigator.geolocation) {
                status.textContent = "Geolocation is not supported by this browser.";
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    status.textContent = "Location detected successfully.";

                    map.setView([userLat, userLng], 16);

                    L.marker([userLat, userLng])
                        .addTo(map)
                        .bindPopup("You are here")
                        .openPopup();

                    L.circle([userLat, userLng], {
                        radius: accuracy
                    }).addTo(map);
                },
                function (error) {
                    if (error.code === error.PERMISSION_DENIED) {
                        status.textContent = "Location permission was denied. Please allow location access in your browser settings.";
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        status.textContent = "Location information is unavailable.";
                    } else if (error.code === error.TIMEOUT) {
                        status.textContent = "Location request timed out.";
                    } else {
                        status.textContent = "Unable to get your location.";
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });
    </script>

    <script src="{{ asset('js/crowdsourcing.js') }}"></script>
@endpush