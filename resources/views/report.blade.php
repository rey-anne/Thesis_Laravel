@extends('layouts.app')
@section('title', 'Report a Fire')

@push('styles')
<style>
    .vf-camera-status {
        text-align: center;
        color: var(--vf-muted);
        font-size: 14px;
        margin: 10px 0 18px;
    }

    #vfCameraVideo,
    #vfPhotoPreview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: inherit;
    }
</style>
@endpush

@section('content')
<section class="vf-section" style="max-width:600px;">

    <h1 style="color:var(--vf-red);text-align:center;">Report a Fire</h1>

    <p style="text-align:center;color:var(--vf-muted);">
        Take a clear photo of the fire. Your location is shared automatically.
    </p>

    <p id="vfCameraStatus" class="vf-camera-status">
        Requesting camera permission...
    </p>

    <div class="vf-camera-box" id="vfCameraBox">
        <video id="vfCameraVideo" autoplay playsinline muted></video>
        <canvas id="vfCameraCanvas" style="display:none;"></canvas>
        <img id="vfPhotoPreview" style="display:none;" alt="Captured fire photo">
    </div>

    <div style="text-align:center;margin-bottom:24px;">
        <button type="button" id="vfCaptureBtn" class="vf-btn">Capture Photo</button>
        <button type="button" id="vfRetakeBtn" class="vf-btn vf-btn--outline" style="display:none;">Retake</button>
    </div>

    <p id="vfLocationStatus" class="vf-camera-status">
        Requesting location permission...
    </p>

    <form id="vfReportForm" method="POST" action="{{ route('report.store') }}">
        @csrf

        <input type="hidden" id="vfLatitude" name="latitude">
        <input type="hidden" id="vfLongitude" name="longitude">
        <input type="hidden" id="vfPhotoData" name="photo_data">

        <button type="submit" class="vf-btn" style="width:100%;">Submit Report</button>
    </form>

</section>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const video = document.getElementById("vfCameraVideo");
    const canvas = document.getElementById("vfCameraCanvas");
    const preview = document.getElementById("vfPhotoPreview");
    const captureBtn = document.getElementById("vfCaptureBtn");
    const retakeBtn = document.getElementById("vfRetakeBtn");
    const photoData = document.getElementById("vfPhotoData");
    const cameraStatus = document.getElementById("vfCameraStatus");

    const latitudeInput = document.getElementById("vfLatitude");
    const longitudeInput = document.getElementById("vfLongitude");
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