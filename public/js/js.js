/* =========================================================
   VeriFyre Crowdsourcing Verification
   Shows popup only when vfMaybeShowCrowdsourcePopup(reportId) is called.
   ========================================================= */

let vfCrowdsourceStream = null;

document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.getElementById("vfCrowdsourceOverlay");

    const promptStage = document.getElementById("vfCrowdsourcePromptStage");
    const cameraStage = document.getElementById("vfCrowdsourceCameraStage");
    const successStage = document.getElementById("vfCrowdsourceSuccessStage");

    const verifyBtn = document.getElementById("vfCrowdsourceVerifyBtn");
    const captureBtn = document.getElementById("vfCrowdsourceCaptureBtn");
    const continueBtn = document.getElementById("vfCrowdsourceDial911");

    const video = document.getElementById("vfCrowdsourceVideo");
    const canvas = document.getElementById("vfCrowdsourceCanvas");

    const form = document.getElementById("vfCrowdsourceForm");
    const reportIdInput = document.getElementById("vfCrowdsourceReportId");
    const photoDataInput = document.getElementById("vfCrowdsourcePhotoData");

    if (!overlay) {
        return;
    }

    // Make sure hidden siya pag load ng page
    overlay.classList.remove("vf-modal-overlay--active");

    function showStage(stageName) {
        if (promptStage) promptStage.style.display = "none";
        if (cameraStage) cameraStage.style.display = "none";
        if (successStage) successStage.style.display = "none";

        if (stageName === "prompt" && promptStage) {
            promptStage.style.display = "block";
        }

        if (stageName === "camera" && cameraStage) {
            cameraStage.style.display = "block";
        }

        if (stageName === "success" && successStage) {
            successStage.style.display = "block";
        }
    }

    async function startCrowdsourceCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert("Camera is not supported by this browser.");
            return;
        }

        try {
            vfCrowdsourceStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: "environment" },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });

            video.srcObject = vfCrowdsourceStream;
            await video.play();
        } catch (error) {
            console.error("Crowdsource camera error:", error);

            if (error.name === "NotAllowedError") {
                alert("Camera permission was blocked. Please allow camera access.");
            } else if (error.name === "NotFoundError") {
                alert("No camera device found.");
            } else {
                alert("Unable to open camera: " + error.message);
            }
        }
    }

    function stopCrowdsourceCamera() {
        if (vfCrowdsourceStream) {
            vfCrowdsourceStream.getTracks().forEach(track => track.stop());
            vfCrowdsourceStream = null;
        }
    }

    function closeCrowdsourcePopup() {
        stopCrowdsourceCamera();

        overlay.classList.remove("vf-modal-overlay--active");

        if (photoDataInput) photoDataInput.value = "";
        if (reportIdInput) reportIdInput.value = "";

        showStage("prompt");
    }

    if (verifyBtn) {
        verifyBtn.addEventListener("click", async function () {
            showStage("camera");
            await startCrowdsourceCamera();
        });
    }

    if (captureBtn) {
        captureBtn.addEventListener("click", async function () {
            if (!video || !canvas || !photoDataInput || !form) {
                alert("Verification form is not ready.");
                return;
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
            photoDataInput.value = imageData;

            stopCrowdsourceCamera();

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    body: new FormData(form),
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (!response.ok) {
                    throw new Error("Verification submission failed.");
                }

                showStage("success");
            } catch (error) {
                console.error("Crowdsource submit error:", error);
                alert("Unable to submit verification. Please try again.");
                showStage("prompt");
            }
        });
    }

    if (continueBtn) {
        continueBtn.addEventListener("click", function () {
            closeCrowdsourcePopup();
        });
    }

    // Optional: close kapag click sa dark background
    overlay.addEventListener("click", function (event) {
        if (event.target === overlay) {
            closeCrowdsourcePopup();
        }
    });

    // Global function: ito tatawagin mo kapag may nearby active fire report
    window.vfMaybeShowCrowdsourcePopup = function (reportId) {
        if (!overlay) return;

        if (!reportId) {
            console.warn("No fire report ID provided.");
            return;
        }

        if (reportIdInput) {
            reportIdInput.value = reportId;
        }

        showStage("prompt");
        overlay.classList.add("vf-modal-overlay--active");
    };

    // Global close function just in case kailangan later
    window.vfCloseCrowdsourcePopup = closeCrowdsourcePopup;
});