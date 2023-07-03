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
?>
