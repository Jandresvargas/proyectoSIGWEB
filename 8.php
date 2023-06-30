<!DOCTYPE html>
<html>
<head>
    <title>Mapa con puntos desde PostgreSQL y Leaflet Routing Machine</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors'
        }).addTo(map);

        // Obtener los puntos desde PostgreSQL usando PHP
        <?php
        // Establecer la conexión a la base de datos
        $host = 'localhost';
        $dbname = '2tp';
        $username = 'postgres';
        $password = '12345';
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);

        // Consultar los puntos desde la tabla de la base de datos
        $query = "SELECT id, nombre, ST_X(geom) AS longitude, ST_Y(geom) AS latitude FROM sitios_interes";
        $result = $db->query($query);

        // Crear una capa de marcadores para los puntos
      

        // Recorrer los resultados y añadir los marcadores al mapa y a la capa de marcadores
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];

            // Crear el marcador y añadirlo al mapa y a la capa de marcadores
            
        }
        ?>

        // Agregar la función de enrutamiento
        var control = L.Routing.control({
            waypoints: [
                L.latLng(51.5, -0.09), // Ubicación del usuario (punto de partida)
                // Aquí puedes agregar un punto específico desde la base de datos como destino
                // Ejemplo: L.latLng(51.51, -0.1) - Coordenadas fijas para el destino
            ],
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim()
        }).addTo(map);
        var markersLayer = L.layerGroup().addTo(map);
        var marker = L.marker([$latitude, $longitude]).addTo(map).bindPopup('ID: $id<br>Nombre: $nombre');
            markersLayer.addLayer(marker);
        // Evento para actualizar el enrutamiento cuando se cambian los puntos de inicio o destino
        map.on('click', function(e) {
            control.setWaypoints([
                L.Routing.waypoint(L.latLng(e.latlng.lat, e.latlng.lng)) // Nueva ubicación del usuario (punto de partida)
                // Aquí puedes agregar un punto específico desde la base de datos como destino
                // Ejemplo: L.Routing.waypoint(L.latLng(51.51, -0.1)) - Coordenadas fijas para el destino
            ]);
        });
    </script>
</body>
</html>
