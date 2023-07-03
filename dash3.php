<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de conteo por categorías</title>
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

    // Consulta SQL para contar por categorías
    $query = "SELECT categoria, COUNT(*) as total FROM talleres GROUP BY categoria";
    $result = pg_query($conn, $query);

    // Arreglos para almacenar las categorías, los conteos y los colores
    $categorias = array();
    $conteos = array();
    $colores = array();

    // Definir un array de colores (uno por cada categoría)
    $colores = array('#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF');

    // Recorrer los resultados y almacenar los datos en los arreglos
    $i = 0;
    while ($row = pg_fetch_assoc($result)) {
        $categoria = $row['categoria'];
        $conteo = $row['total'];

        array_push($categorias, $categoria);
        array_push($conteos, $conteo);

        // Obtener el color correspondiente según el índice del arreglo
        $color = $colores[$i % count($colores)];
        array_push($colores, $color);

        $i++;
    }
    ?>

    <script>
        // Crear el gráfico utilizando Chart.js
        var ctx = document.getElementById('grafico').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categorias); ?>,
                datasets: [{
                    label: 'Conteo',
                    data: <?php echo json_encode($conteos); ?>,
                    backgroundColor: <?php echo json_encode($colores); ?>,
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
