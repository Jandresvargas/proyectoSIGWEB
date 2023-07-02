<?php
// Establecer la conexión a la base de datos
define("PG_DB"  , "t2p");
define("PG_HOST", "localhost");
define("PG_USER", "postgres");
define("PG_PSWD", "12345");
define("PG_PORT", "5433");
$dbconn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");

// Obtener los parámetros de ubicación y radio
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$buffer = $_POST['buffer'];

// Realizar la consulta para obtener los datos dentro del buffer
$query = "SELECT nombre, tipo FROM sitios_interes WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint($lng, $lat), 4326), $buffer)";

$result = pg_query($dbconn, $query);

// Crear las filas de la tabla con los datos obtenidos
while ($row = pg_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $row['nombre'] . "</td>";
  echo "<td>" . $row['tipo'] . "</td>";
  echo "</tr>";
}

// Cerrar la conexión a la base de datos
pg_close($dbconn);
?>