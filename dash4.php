<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de talleres con mayor rating</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
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

    // Consulta SQL para obtener los talleres con mayor rating
    $query = "SELECT nombre, rating FROM talleres WHERE categoria LIKE 'Montallantas' ORDER BY rating DESC LIMIT 5";
    $result = pg_query($conn, $query);

    // Arreglos para almacenar los nombres y los ratings
    $nombres = array();
    $ratings = array();

    // Recorrer los resultados y almacenar los datos en los arreglos
    while ($row = pg_fetch_assoc($result)) {
        $nombre = $row['nombre'];
        $rating = $row['rating'];

        array_push($nombres, $nombre);
        array_push($ratings, $rating);
    }
    ?>

    <script>
        // Crear el gráfico utilizando Chart.js
        var ctx = document.getElementById('grafico').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nombres); ?>,
                datasets: [{
                    label: 'Talleres con mayor rating',
                    data: <?php echo json_encode($ratings); ?>,
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
