<?php
define("PG_DB"  , "Proyecto_SIGWEB");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");

$conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
if (!$conn) {
    echo "Error de conexión a la base de datos.";
    exit;
}

$password = $_POST['password'];
$username = $_POST['username'];


$query = "INSERT INTO usuarios (password, username) VALUES ('$password', '$username')";
$result = pg_query($conn, $query);

if ($result) {
    echo "<script>alert('Registro guardado exitosamente.');</script>";
    exit;
} else {
    echo "<script>alert('Error al guardar el registro.');</script>";
}
?>
