<?php

// Datos de conexión a la base de datos
$host = 'localhost';
$port = 5433;
$dbname = 't2p';
$user = 'postgres';
$password = '12345';

// Obtener los datos del buffer del cuerpo de la solicitud
$buffer = json_decode($_POST['buffer']);

// Crear la cadena de conexión
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    // Conectar a la base de datos
    $pdo = new PDO($dsn);

    // Establecer el esquema de búsqueda a PostGIS
    $pdo->exec("SET search_path TO public, postgis");

    // Preparar la consulta SQL para obtener los puntos dentro del área de influencia
    $sql = "
        SELECT *
        FROM sitios_interes
        WHERE ST_Within(geom, ST_SetSRID(ST_GeomFromGeoJSON(:buffer), 4326))
    ";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Asignar el valor del área de influencia (buffer) a la consulta
    $stmt->bindValue(':buffer', json_encode($buffer), PDO::PARAM_STR);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados de la consulta
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados como respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (PDOException $e) {
    // Manejar errores de la base de datos
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}
