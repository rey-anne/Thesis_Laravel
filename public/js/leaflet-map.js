/* =========================================================
   VeriFyre - shared Leaflet heatmap initializer
   Renders fire incident density using the heatmap.js +
   leaflet-heatmap plugin (public/assets/heatmap/).
   ========================================================= */

function vfInitHeatmap(elementId, dataUrl) {
    const mapEl = document.getElementById(elementId);
    if (!mapEl || typeof L === 'undefined') {
        console.error('vfInitHeatmap: map container or Leaflet not found.');
        return;
    }
    if (typeof HeatmapOverlay === 'undefined') {
        console.error('vfInitHeatmap: heatmap plugin scripts not loaded.');
        return;
    }

    // Default center: Tondo, Manila
    const defaultLat = 14.6175;
    const defaultLng = 120.9670;

    const map = L.map(elementId).setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    const heatmapLayer = new HeatmapOverlay({
        radius: 0.01,
        maxOpacity: 0.8,
        scaleRadius: true,
        useLocalExtrema: true,
        latField: 'lat',
        lngField: 'lng',
        valueField: 'count',
    });
    heatmapLayer.addTo(map);

    fetch(dataUrl || '/heatmap-data')
        .then(res => res.json())
        .then(points => {
            heatmapLayer.setData({
                max: 1,
                data: points.map(p => ({ lat: p.lat, lng: p.lng, count: 1 })),
            });
        })
        .catch(err => console.error('vfInitHeatmap: failed to load heatmap data', err));

    setTimeout(() => map.invalidateSize(), 300);
}
