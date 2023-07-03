<!DOCTYPE html>
<html>
<head>
    <title>Conteo de talleres por comuna</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Conteo de talleres por comuna</h1>

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

    // Consulta SQL para obtener el conteo de talleres por comuna
    $query = "SELECT c.nombre AS comuna, COUNT(t.*) AS total_talleres FROM comunas c LEFT JOIN talleres t ON ST_Intersects(t.geom, c.geom) GROUP BY c.nombre ORDER BY c.nombre";
    $result = pg_query($conn, $query);

    $comunas = array();
    $cantidades = array();

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $comunas[] = $row['comuna'];
            $cantidades[] = $row['total_talleres'];
        }
    } else {
        echo "Error al realizar la consulta.";
    }
    ?>

    <div style="width: 500px;">
        <canvas id="chart"></canvas>
    </div>

    <script>
        // Datos para el gráfico
        var comunas = <?php echo json_encode($comunas); ?>;
        var cantidades = <?php echo json_encode($cantidades); ?>;
        
        // Crear el gráfico
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: comunas,
                datasets: [{
                    label: 'Cantidad de Talleres',
                    data: cantidades,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Color de fondo de las barras
                    borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>

</body>
</html>
