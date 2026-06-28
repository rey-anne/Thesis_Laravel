@extends('layouts.app')
@section('title', 'Report a Fire')

@push('styles')
<style>
    .vf-safety-card {
        background: linear-gradient(135deg, #fff 60%, var(--vf-red-tint) 100%);
        border: 1px solid var(--vf-line);
        border-top: 5px solid var(--vf-red);
        border-radius: var(--vf-radius);
        box-shadow: var(--vf-shadow-sm);
        padding: 24px 26px;
        margin-bottom: 24px;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    .vf-safety-card:hover {
        box-shadow: 0 14px 30px rgba(229, 57, 53, 0.18);
        transform: translateY(-2px);
    }

    .vf-safety-card--modal {
        max-width: 420px;
        max-height: 85vh;
        overflow-y: auto;
        animation: vfSafetyPop 0.25s ease;
    }

    @keyframes vfSafetyPop {
        from { opacity: 0; transform: scale(0.92) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .vf-safety-card__header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .vf-safety-card__header strong {
        display: block;
        font-size: 17px;
        color: var(--vf-ink);
    }

    .vf-safety-card__subtitle {
        display: block;
        font-size: 13px;
        color: var(--vf-muted);
    }

    .vf-safety-card__list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .vf-safety-card__list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .vf-safety-card__bullet {
        width: 32px;
        height: 32px;
        padding: 7px;
    }

    .vf-safety-card__en {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: var(--vf-ink);
        line-height: 1.5;
    }

    .vf-safety-card__tl {
        margin: 2px 0 0;
        font-size: 13px;
        font-style: italic;
        color: var(--vf-muted);
        line-height: 1.5;
    }

    .vf-report-card {
        background: linear-gradient(135deg, #fff 55%, var(--vf-red-tint) 100%);
        border: 1px solid var(--vf-line);
        border-top: 5px solid var(--vf-red);
        border-radius: var(--vf-radius);
        box-shadow: var(--vf-shadow-sm);
        padding: 32px;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    .vf-report-card:hover {
        box-shadow: 0 14px 30px rgba(229, 57, 53, 0.18);
        transform: translateY(-2px);
    }

    .vf-report-step {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .vf-report-step .vf-edu-box__icon {
        width: 32px;
        height: 32px;
        padding: 7px;
    }

    .vf-camera-status {
        color: var(--vf-muted);
        font-size: 14px;
        margin: 0;
    }

    #vfCameraVideo,
    #vfPhotoPreview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: inherit;
    }

    .vf-report-actions {
        text-align: center;
        margin: 18px 0 26px;
    }

    .vf-btn .vf-edu-svg,
    .vf-btn--outline .vf-edu-svg {
        width: 16px;
        height: 16px;
    }

    .vf-btn-icon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .vf-report-divider {
        border: none;
        border-top: 1px dashed var(--vf-line);
        margin: 24px 0;
    }

    @media (max-width: 700px) {
        .vf-report-card {
            padding: 22px;
        }
    }
</style>
@endpush

@section('content')
<section class="vf-section vf-edu" style="max-width:600px;">

    <div class="vf-edu-header">
        <span class="vf-edu-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 2c1 3-3 4-3 8a3 3 0 0 0 6 0c0-1-1-2-1-2 1 0 3 2 3 5a5 5 0 0 1-10 0c0-5 4-6 5-11z"/></svg>
            Report an Incident
        </span>
        <h1>Report a Fire</h1>
        <p>Take a clear photo of the fire. Your location is shared automatically.</p>
    </div>

    <div class="vf-modal-overlay vf-modal-overlay--active" id="vfSafetyModal">
    <div class="vf-safety-card vf-safety-card--modal">
        <div class="vf-safety-card__header">
            <span class="vf-edu-box__icon vf-edu-box--crimson">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            </span>
            <div>
                <strong>Safety Reminders</strong>
                <span class="vf-safety-card__subtitle">Mga Paalala sa Kaligtasan</span>
            </div>
        </div>
        <ul class="vf-safety-card__list">
            <li>
                <span class="vf-edu-box__icon vf-edu-box--crimson vf-safety-card__bullet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M5 4h3l2 5-2 1a11 11 0 0 0 5 5l1-2 5 2v3a2 2 0 0 1-2 2A15 15 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                </span>
                <div>
                    <p class="vf-safety-card__en">Call 911 immediately if anyone is in danger.</p>
                    <p class="vf-safety-card__tl">Tumawag agad sa 911 kung may taong nasa panganib.</p>
                </div>
            </li>
            <li>
                <span class="vf-edu-box__icon vf-edu-box--gold vf-safety-card__bullet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 4l9 16H3L12 4z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg>
                </span>
                <div>
                    <p class="vf-safety-card__en">Keep a safe distance from smoke and flames.</p>
                    <p class="vf-safety-card__tl">Lumayo sa usok at apoy para sa kaligtasan mo.</p>
                </div>
            </li>
            <li>
                <span class="vf-edu-box__icon vf-edu-box--gold vf-safety-card__bullet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 4l9 16H3L12 4z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg>
                </span>
                <div>
                    <p class="vf-safety-card__en">Don't risk getting closer just to take a photo.</p>
                    <p class="vf-safety-card__tl">Huwag manganib lumapit lang para kumuha ng litrato.</p>
                </div>
            </li>
        </ul>
        <button type="button" id="vfSafetyContinueBtn" class="vf-btn" style="width:100%;margin-top:22px;">
            I Understand, Continue
        </button>
    </div>
    </div>

    <div class="vf-report-card">

        <div class="vf-report-step">
            <span class="vf-edu-box__icon vf-edu-box--ember">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.5"/></svg>
            </span>
            <p id="vfCameraStatus" class="vf-camera-status">Requesting camera permission...</p>
        </div>

        <div class="vf-camera-box" id="vfCameraBox">
            <video id="vfCameraVideo" autoplay playsinline muted></video>
            <canvas id="vfCameraCanvas" style="display:none;"></canvas>
            <img id="vfPhotoPreview" style="display:none;" alt="Captured fire photo">
        </div>

        <div class="vf-report-actions">
            <button type="button" id="vfCaptureBtn" class="vf-btn">
                <span class="vf-btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.5"/></svg>
                    Capture Photo
                </span>
            </button>
            <button type="button" id="vfRetakeBtn" class="vf-btn vf-btn--outline" style="display:none;">
                <span class="vf-btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg>
                    Retake
                </span>
            </button>
        </div>

        <hr class="vf-report-divider">

        <div class="vf-report-step">
            <span class="vf-edu-box__icon vf-edu-box--crimson">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
            </span>
            <p id="vfLocationStatus" class="vf-camera-status">Requesting location permission...</p>
        </div>

        <form id="vfReportForm" method="POST" action="{{ route('report.store') }}">
            @csrf

            <input type="hidden" id="vfLatitude" name="latitude">
            <input type="hidden" id="vfLongitude" name="longitude">
            <input type="hidden" id="vfGpsAccuracy" name="gps_accuracy">
            <input type="hidden" id="vfCapturedAt" name="captured_at">
            <input type="hidden" id="vfPhotoData" name="photo_data">

            <button type="submit" class="vf-btn" style="width:100%;">
                <span class="vf-btn-icon" style="justify-content:center;width:100%;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="vf-edu-svg"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    Submit Report
                </span>
            </button>
        </form>

    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const safetyModal = document.getElementById("vfSafetyModal");
    const safetyContinueBtn = document.getElementById("vfSafetyContinueBtn");

    if (safetyModal && safetyContinueBtn) {
        safetyContinueBtn.addEventListener("click", function () {
            safetyModal.classList.remove("vf-modal-overlay--active");
        });
    }

    const video = document.getElementById("vfCameraVideo");
    const canvas = document.getElementById("vfCameraCanvas");
    const preview = document.getElementById("vfPhotoPreview");
    const captureBtn = document.getElementById("vfCaptureBtn");
    const retakeBtn = document.getElementById("vfRetakeBtn");
    const photoData = document.getElementById("vfPhotoData");
    const cameraStatus = document.getElementById("vfCameraStatus");

    const latitudeInput = document.getElementById("vfLatitude");
    const longitudeInput = document.getElementById("vfLongitude");
    const gpsAccuracyInput = document.getElementById("vfGpsAccuracy");
    const capturedAtInput = document.getElementById("vfCapturedAt");
    const locationStatus = document.getElementById("vfLocationStatus");

    const form = document.getElementById("vfReportForm");

    let cameraStream = null;

    async function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            cameraStatus.textContent = "Camera is not supported by this browser.";
            return;
        }

        try {
            cameraStatus.textContent = "Requesting camera permission...";

            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: "environment" },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });

            video.srcObject = cameraStream;
            await video.play();

            cameraStatus.textContent = "Camera ready. Take a clear photo of the fire.";
        } catch (error) {
            console.error("Camera error:", error);

            if (error.name === "NotAllowedError") {
                cameraStatus.textContent = "Camera permission was blocked. Allow camera access in your browser settings.";
            } else if (error.name === "NotFoundError") {
                cameraStatus.textContent = "No camera device found on this device.";
            } else if (error.name === "NotReadableError") {
                cameraStatus.textContent = "Camera is being used by another app.";
            } else {
                cameraStatus.textContent = "Unable to open camera: " + error.message;
            }
        }
    }

    function stopCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
    }

    function getLocation() {
        if (!navigator.geolocation) {
            locationStatus.textContent = "Location is not supported by this browser.";
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;
                gpsAccuracyInput.value = position.coords.accuracy;
                locationStatus.textContent = "Location detected successfully.";
            },
            function (error) {
                console.error("Location error:", error);

                if (error.code === error.PERMISSION_DENIED) {
                    locationStatus.textContent = "Location permission was denied.";
                } else {
                    locationStatus.textContent = "Unable to detect location.";
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    captureBtn.addEventListener("click", async function () {
        if (!cameraStream) {
            await startCamera();
        }

        if (!video.videoWidth || !video.videoHeight) {
            alert("Camera is not ready yet. Please wait.");
            return;
        }

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL("image/jpeg", 0.9);
        photoData.value = imageData;
        capturedAtInput.value = new Date().toISOString();

        preview.src = imageData;
        preview.style.display = "block";
        video.style.display = "none";

        captureBtn.style.display = "none";
        retakeBtn.style.display = "inline-block";

        cameraStatus.textContent = "Photo captured successfully.";
        stopCamera();
    });

    retakeBtn.addEventListener("click", async function () {
        photoData.value = "";
        preview.src = "";
        preview.style.display = "none";
        video.style.display = "block";

        captureBtn.style.display = "inline-block";
        retakeBtn.style.display = "none";

        await startCamera();
    });

    form.addEventListener("submit", function (event) {
        if (!photoData.value) {
            event.preventDefault();
            alert("Please capture a photo before submitting the report.");
            return;
        }

        if (!latitudeInput.value || !longitudeInput.value) {
            const proceed = confirm("Location was not detected. Submit report anyway?");
            if (!proceed) {
                event.preventDefault();
            }
        }
    });

    startCamera();
    getLocation();
});
</script>
@endpush
