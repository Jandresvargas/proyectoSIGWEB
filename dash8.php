<!DOCTYPE html>
<html>
<head>
    <title>Conteo de talleres</title>
</head>
<body>
    <h1>Conteo de talleres</h1>

    <?php
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

    $query = "SELECT COUNT(*) AS total_talleres FROM talleres";
    $result = pg_query($conn, $query);

    if ($result) {
        $row = pg_fetch_assoc($result);
        $totalTalleres = $row['total_talleres'];
        echo "Cantidad de talleres: " . $totalTalleres;
    } else {
        echo "Error al realizar la consulta.";
    }

    pg_close($conn);
    ?>
</body>
</html>
