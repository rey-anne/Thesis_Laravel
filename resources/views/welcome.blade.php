<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VeriFyre</title>

    <!-- Leaflet CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f6f6f6;
        }

        .topbar {
            height: 70px;
            background: #7b1113;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
        }

        .nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: 500;
        }

        .hero {
            padding: 40px 50px 20px;
            text-align: center;
        }

        .hero h1 {
            color: #7b1113;
            margin-bottom: 10px;
        }

        #locationStatus {
            margin-top: 10px;
            color: #444;
        }

        .map-container {
            width: 90%;
            margin: 25px auto;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        #map {
            height: 520px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="logo">VeriFyre</div>
        <div class="nav">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/report') }}">Report</a>
            <a href="{{ url('/education') }}">Education</a>
            <a href="{{ url('/cybersecurity') }}">Cybersecurity</a>
            <a href="{{ url('/login') }}">Log In</a>
        </div>
    </div>

    <section class="hero">
        <h1>Fire Incident Monitoring in Tondo, Manila</h1>
        <p>View nearby fire incident reports and allow location access for better monitoring.</p>
        <p id="locationStatus">Requesting your location...</p>
    </section>

    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const locationStatus = document.getElementById("locationStatus");

            // Default center: Tondo / Manila area
            const defaultLat = 14.6175;
            const defaultLng = 120.9670;

            // Create map
            const map = L.map("map").setView([defaultLat, defaultLng], 14);

            // Map tiles
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: "&copy; OpenStreetMap contributors"
            }).addTo(map);

            // Sample marker
            L.marker([defaultLat, defaultLng])
                .addTo(map)
                .bindPopup("Tondo, Manila monitoring area");

            // Check if browser supports location
            if (!navigator.geolocation) {
                locationStatus.textContent = "Geolocation is not supported by this browser.";
                return;
            }

            // Ask for user location
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    locationStatus.textContent = "Location detected successfully.";

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
                        locationStatus.textContent = "Location permission was denied. Please allow location access in your browser.";
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        locationStatus.textContent = "Location information is unavailable.";
                    } else if (error.code === error.TIMEOUT) {
                        locationStatus.textContent = "Location request timed out.";
                    } else {
                        locationStatus.textContent = "Unable to get your location.";
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

</body>
</html>