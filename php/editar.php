<?php
define("PG_DB"  , "Proyecto_SIGWEB");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");

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
$lat = $_POST['lat'];
$long = $_POST['long'];

$conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
if (!$conn) {
   echo "Error al conectar a la base de datos.";
   exit;
}
$query = "UPDATE talleres SET nombre='$nombre',categoria='$categoria', rating='$rating', servicio1='$servicio1', servicio2='$servicio2', servicio3='$servicio3', direccion='$direccion', web='$web', telefono='$telefono', propietario='$propietario', geom=ST_SetSRID(ST_MakePoint($long, $lat), 4326) WHERE id='$id'";
$result = pg_query($conn, $query);
if (!$result) {
   echo "<script>alert('Error al actualizar el registro.');</script>";
   exit;
}
echo "<script>alert('Actualización exitosa.'); window.location.href = '../principaluser.php'</script>";
pg_close($conn);
?>
