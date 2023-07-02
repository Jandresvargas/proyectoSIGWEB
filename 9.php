<?php
// Configuración de la conexión a la base de datos
define("PG_DB"  , "t2p");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");

// Realizar la conexión a la base de datos
$dbconn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");

// Verificar la conexión
if (!$dbconn) {
    die("Error en la conexión a la base de datos.");
}

// Obtener el ID del registro a buscar (puedes obtenerlo a través de un formulario u otra fuente)
$id = $_GET['id'];

// Construir la consulta SQL para buscar el registro por su ID
$sql = "SELECT id, nombre, ST_AsGeoJSON(geom) AS geojson FROM talleres WHERE id = $id";

// Ejecutar la consulta
$result = pg_query($dbconn, $sql);

// Verificar si se encontró el registro
if (pg_num_rows($result) > 0) {
    // Obtener los datos del registro
    $row = pg_fetch_assoc($result);
    $id = $row['id'];
    $nombre = $row['nombre'];
    $geojson = $row['geojson'];

    // Mostrar el mapa de Leaflet
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Mapa con marcador</title>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
            <style>
                #map {
                    height: 400px;
                }
            </style>
        </head>
        <body>
            <div id="map"></div>

            <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
            <script>
                var map = L.map("map").setView([0, 0], 13);
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "Map data &copy; OpenStreetMap contributors"
                }).addTo(map);

                // Convertir el geojson en un objeto de geometría
                var geometry = JSON.parse(' . $geojson . ');

                // Obtener las coordenadas del punto
                var coordinates = geometry.coordinates;
                var latitude = coordinates[1];
                var longitude = coordinates[0];

                // Crear un marcador en las coordenadas del punto
                var marker = L.marker([latitude, longitude]).addTo(map);

                // Agregar un pop-up al marcador con el nombre del registro
                marker.bindPopup("' . $nombre . '").openPopup();

                // Ajustar la vista del mapa para que se muestre el marcador
                map.setView([latitude, longitude], 13);
            </script>
        </body>
        </html>
    ';
} else {
    echo "Registro no encontrado.";
}

// Cerrar la conexión a la base de datos
pg_close($dbconn);
?>
