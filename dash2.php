<!DOCTYPE html>
<html>
<head>
    <title>Conteo por categorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<style>
.container {
  background: #f0f0f0;
  border: 2px;
  border: radius 3px;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80%;
  height: 50%;
}
</style>
<body>
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

    // Consulta SQL para contar por categorías
    $query = "SELECT categoria, COUNT(*) as total FROM talleres GROUP BY categoria";
    $result = pg_query($conn, $query);

    // Recorrer los resultados y mostrar los contadores por categoría
    while ($row = pg_fetch_assoc($result)) {
        $categoria = $row['categoria'];
        $conteo = $row['total'];
        ?>
        <div class="container">
            <p style="font-size: 20px">Cantidad de  <?php echo $categoria; ?>: <?php echo $conteo; ?></p>
        </div>
        <?php
    }
    ?>
</body>
</html>
