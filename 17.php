<?php
define("PG_DB"  , "t2p");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");
$dbconn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");

$latitude = $_GET['lat'];
$longitude = $_GET['lng'];
$bufferRadius = $_GET['radius'];

// Consulta SQL para obtener los puntos dentro del buffer
$query = "SELECT id, nombre, rating,ST_X(geom) as lng, ST_Y(geom) as lat, ST_AsGeoJSON(geom) AS geometry FROM tabla_puntos WHERE ST_DWithin(geom, ST_MakePoint($longitude, $latitude)::geography, $bufferRadius)";

$result = pg_query($dbconn, $query);

$geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
);

while ($row = pg_fetch_assoc($result)) {
  $feature = array(
    'type' => 'Feature',
    'properties' => array(
      'id' => $row['id'],
      'nombre' => $row['nombre']
    ),
    'geometry' => json_decode($row['geometry'])
  );

  array_push($geojson['features'], $feature);
}

header('Content-type: application/json');
echo json_encode($geojson);

pg_close($dbconn);
?>
