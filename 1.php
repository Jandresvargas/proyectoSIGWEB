<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'Proyecto_SIGWEB';
$user = 'postgres';
$password = '12345';

// Establecer conexión a la base de datos
$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

// Consulta SQL para obtener los talleres
$query = 'SELECT id, nombre, latitud, longitud FROM talleres';
$stmt = $db->prepare($query);
$stmt->execute();
$talleres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los talleres en formato JSON
header('Content-Type: application/json');
echo json_encode($talleres);
?>
