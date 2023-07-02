<?php
    // Configuración de la conexión a la base de datos
    include('conect.php');
    session_start();

    if (!isset($_POST['peticion'])) {
        $_POST['peticion'] = "peticion";
    }

    if (!isset($_POST['parametros'])) {
        $_POST['parametros'] = 'parametros';
    }

    $peticion = $_POST['peticion'];
    $parametros = $_POST['parametros'];

    switch ($peticion) {
        case 'cargar': {
            $categoria = "Montallantas"; // Valor del tipo que deseas filtrar

            $sql = "SELECT row_to_json(fc) AS geojson
                    FROM (
                        SELECT 'FeatureCollection' AS type, array_to_json(array_agg(f)) AS features
                        FROM (
                            SELECT 'Feature' AS type,
                                ST_AsGeoJSON(lg.geom)::json AS geometry,
                                row_to_json((SELECT l FROM (SELECT id, nombre, rating, direccion, web, telefono, servicio1, servicio2, servicio3) AS l)) AS properties
                            FROM talleres AS lg
                            WHERE categoria = '$categoria' -- Filtrar por tipo
                        ) AS f
                    ) AS fc;";

            $query = pg_query($dbcon, $sql);
            $row = pg_fetch_row($query);
            echo $row[0];
            break;
        }
    }
?>