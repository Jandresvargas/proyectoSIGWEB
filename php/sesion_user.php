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
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
$result = pg_query($conn, $query);

if (pg_num_rows($result) > 0) {
    // Usuario autenticado correctamente
    $_SESSION['username'] = $username;
    header("Location: ../principal.html"); // Redirige a la página de inicio después del inicio de sesión exitoso
    exit;
} else {
    // Credenciales incorrectas
    echo "Credenciales incorrectas. Por favor, intenta nuevamente.";
    header("Location: ../sesion.html");
}

?>
