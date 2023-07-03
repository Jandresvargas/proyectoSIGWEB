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

    // Obtener las comunas de la base de datos
    $comunasQuery = "SELECT * FROM comunas";
    $comunasResult = pg_query($conn, $comunasQuery);

    // Consulta SQL para contar los talleres que se intersectan con las comunas
    $countQuery = "SELECT COUNT(*) AS total_talleres FROM talleres t, comunas c WHERE ST_Intersects(t.geom, c.geom)";
    
    // Verificar si se ha seleccionado una comuna
    if (isset($_GET['comuna']) && !empty($_GET['comuna'])) {
        $selectedComuna = $_GET['comuna'];
        $countQuery .= " AND c.nombre = '$selectedComuna'";
    }

    $countResult = pg_query($conn, $countQuery);

    if ($countResult) {
        $row = pg_fetch_assoc($countResult);
        $totalTalleres = $row['total_talleres'];
    } else {
        echo "Error al realizar la consulta.";
        $totalTalleres = 0;
    }
    ?>

    <form action="" method="get">
        <label for="comuna">Seleccione una comuna:</label>
        <select name="comuna" id="comuna">
            <option value="">-- Todas las comunas --</option>
            <?php
            while ($comuna = pg_fetch_assoc($comunasResult)) {
                $nombreComuna = $comuna['nombre'];
                $selected = ($nombreComuna === $selectedComuna) ? 'selected' : '';
                echo "<option value='$nombreComuna' $selected>$nombreComuna</option>";
            }
            ?>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <div id="resultado">
        <p>Total de talleres que se intersectan con las comunas: <span id="total"><?php echo $totalTalleres; ?></span></p>
    </div>

    <!-- Aquí puedes trabajar con el resultado en otros contenedores o divisiones del HTML -->

</body>
</html>
