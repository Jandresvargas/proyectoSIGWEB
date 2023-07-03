<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de barras</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<style>
    .container {
  background: #f0f0f0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100vw;
  height: 100vh;
}
</style>
<body>
    <canvas id="grafico"></canvas>

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

    // Consulta SQL para obtener los datos del gráfico
    $query = "SELECT nombre, rating FROM talleres WHERE categoria LIKE 'Montallantas'";
    $result = pg_query($conn, $query);

    // Variables para almacenar los datos del gráfico
    $labels = [];
    $valores = [];

    // Procesar los resultados de la consulta y almacenar los datos en arreglos
    while ($row = pg_fetch_assoc($result)) {
        $labels[] = $row['nombre'];
        $valores[] = $row['rating'];
    }
    ?>

    <script>
        // Obtener los datos desde PHP y almacenarlos en variables JavaScript
        var labels = <?php echo json_encode($labels); ?>;
        var valores = <?php echo json_encode($valores); ?>;

        // Crear el gráfico utilizando Chart.js
        var ctx = document.getElementById('grafico').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rating',
                    data: valores,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                // Opciones y configuraciones adicionales del gráfico
            }
        });
    </script>
</body>
</html>
