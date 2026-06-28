/* =========================================================
   VeriFyre - shared Leaflet heatmap initializer
   Renders fire incident density across Metro Manila (NCR)
   using heatmap.js (h337) via the HeatmapOverlay plugin,
   polling the data endpoint for near-real-time updates.
   ========================================================= */

// Bounding box covering all of Metro Manila / NCR.
const VF_NCR_BOUNDS = [
    [14.35, 120.90],
    [14.78, 121.15],
];

const VF_HEATMAP_POLL_MS = 15000;

function vfInitHeatmap(elementId, dataUrl) {
    const mapEl = document.getElementById(elementId);
    if (!mapEl || typeof L === 'undefined') {
        console.error('vfInitHeatmap: map container or Leaflet not found.');
        return;
    }
    if (typeof h337 === 'undefined') {
        console.error('vfInitHeatmap: heatmap.js not loaded.');
        return;
    }
    if (typeof HeatmapOverlay === 'undefined') {
        console.error('vfInitHeatmap: leaflet-heatmap plugin not loaded.');
        return;
    }

    const map = L.map(elementId).fitBounds(VF_NCR_BOUNDS);
    map.setMaxBounds(L.latLngBounds(VF_NCR_BOUNDS));

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    const heatmapLayer = new HeatmapOverlay({
        radius: 28,
        maxOpacity: 0.75,
        scaleRadius: false,
        useLocalExtrema: false,
        latField: 'lat',
        lngField: 'lng',
        valueField: 'count',
        gradient: {
            0.2: 'blue',
            0.4: 'lime',
            0.6: 'yellow',
            0.8: 'orange',
            1.0: 'red',
        },
    });
    heatmapLayer.addTo(map);

    const url = dataUrl || '/heatmap-data';

    function refreshHeatmap() {
        fetch(url)
            .then(res => res.json())
            .then(points => {
                heatmapLayer.setData({
                    max: 1,
                    data: points.map(p => ({ lat: p.lat, lng: p.lng, count: 1 })),
                });
            })
            .catch(err => console.error('vfInitHeatmap: failed to load heatmap data', err));
    }

    refreshHeatmap();
    setInterval(refreshHeatmap, VF_HEATMAP_POLL_MS);

    setTimeout(() => map.invalidateSize(), 300);
}
