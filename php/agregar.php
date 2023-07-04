<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los datos enviados por el formulario
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $categoria = $_POST['categoria'];
  $rating = $_POST['rating'];
  $servicio1 = $_POST['servicio1'];
  $servicio2 = $_POST['servicio2'];
  $servicio3 = $_POST['servicio3'];
  $direccion = $_POST['direccion'];
  $web = $_POST['web'];
  $telefono = $_POST['telefono'];
  $propietario = $_POST['propietario'];
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];

  // Crear la conexión a la base de datos
  define("PG_DB"  , "Proyecto_SIGWEB");
  define("PG_HOST", "localhost");
  define("PG_USER", "postgres");
  define("PG_PSWD", "12345");
  define("PG_PORT", "5433");
  
  $conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
	//Verificar conexion
	if (!$conn) {
		echo "Error de conexión a la base de datos.";
		exit;
	}
  // Crear la geometría del punto
  $point = "POINT($longitude $latitude)";

  // Insertar los datos del punto en la base de datos
  $query = "INSERT INTO talleres (id, nombre, categoria, rating, servicio1, servicio2, servicio3, direccion, web, telefono, propietario, geom) VALUES ('$id','$nombre','$categoria', '$rating', '$servicio1', '$servicio2', '$servicio3', '$direccion', '$web', '$telefono', '$propietario', ST_GeomFromText('$point', 4326))";
  $result = pg_query($conn, $query);

  // Verificar el resultado de la consulta
  if ($result) {
    if (pg_affected_rows($result) > 0) {
        echo "El punto $id se agregó a la base de datos.";
    } else {
        echo "No se encontró un punto con el ID $id.";
    }
  } else {
    echo "Error al ejecutar la consulta.";
  }
}
?>
