<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karte</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
            
        }
        
    </style>
</head>
<body>
    <h1>Karte</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/proj4/dist/proj4.js"></script>
    <script>
    proj4.defs("EPSG:3059", "+proj=tmerc +lat_0=0 +lon_0=24 +k=0.9996 +x_0=500000 +y_0=-6000000 +datum=WGS84 +units=m +no_defs");
    var map = L.map('map').setView([56.946, 24.105], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    fetch('/api/locations')
        .then(response => response.json())
        .then(data => {
            console.log("Locations fetched:", data);
            data.forEach(location => {
                const lat = parseFloat(location.latitude);
                const lon = parseFloat(location.longitude);

                L.marker([lat, lon])
                    .addTo(map)
                    .bindPopup(`<b>${location.name}</b><br>${location.info}`);
            });
        })
        .catch(error => console.log('Error fetching locations:', error));
</script>
</body>
</html>