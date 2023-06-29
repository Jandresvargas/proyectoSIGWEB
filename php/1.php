<?php
// Configurar la conexión a la base de datos
$host = 'localhost';
$dbname = 'Proyecto_SIGWEB';
$username = 'postgres';
$password = '12345';

try {
    $dbh = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die('Error al conectarse a la base de datos: ' . $e->getMessage());
}

// Obtener los parámetros del buffer desde la URL
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];
$bufferRadius = $_GET['bufferRadius'];

// Construir la consulta SQL para obtener los puntos dentro del buffer
$sql = "
SELECT id, nombre
FROM talleres
WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint($longitude, $latitude), 4326)::geography, $bufferRadius)
";

// Ejecutar la consulta y obtener los resultados
$stmt = $dbh->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los resultados como JSON
header('Content-Type: application/json');
echo json_encode($results);
?>

