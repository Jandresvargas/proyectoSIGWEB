<!DOCTYPE html>
<html>
<head>
    <title>Conteo de talleres intersectados con comunas</title>
</head>
<body>
    <h1>Conteo de talleres intersectados con comunas</h1>

    <?php
    // Conexión a la base de datos
    define("PG_DB", "Proyecto_SIGWEB");
    define("PG_HOST", "localhost");
    define("PG_USER", "postgres");
    define("PG_PSWD", "12345");
    define("PG_PORT", "5433");

    $conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
    if (!$conn) {
        echo "Error de conexión a la base de datos.";
        exit;
    }

    // Consulta SQL para contar los talleres que se intersectan con las comunas
    $query = "SELECT COUNT(*) AS total_talleres FROM talleres t, comunas c WHERE ST_Intersects(t.geometria, c.geometria)";
    $result = pg_query($conn, $query);

    if ($result) {
        $row = pg_fetch_assoc($result);
        $totalTalleres = $row['total_talleres'];

        echo "<p>Total de talleres que se intersectan con las comunas: " . $totalTalleres . "</p>";
    } else {
        echo "Error al realizar la consulta.";
    }
    ?>
</body>
</html>
