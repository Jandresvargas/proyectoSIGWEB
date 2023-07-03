<?php
define("PG_DB", "Proyecto_SIGWEB");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");

// Crear la cadena de conexión
$conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT);

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error al conectar a la base de datos PostgreSQL");
}

// Preparar la consulta SQL para obtener los puntos de la base de datos
$sql = "SELECT ST_AsGeoJSON(geom) AS point FROM talleres ";

// Ejecutar la consulta
$result = pg_query($conn, $sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error al obtener los puntos de la base de datos");
}

// Obtener los resultados
$results = array();
while ($row = pg_fetch_assoc($result)) {
    $results[] = json_decode($row['point']);
}

// Cerrar la conexión a la base de datos
pg_close($conn);

// Devolver los resultados como respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($results);
?>
