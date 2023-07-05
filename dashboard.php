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
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <!-- Descripcion de la pagina -->
    <meta name="description" content="Esta es la biografía de Andrés Vargas">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jorge Andres Vargas">

    <!-- CDNS -->
    <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet">
    <!-- iconos redes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Ingresar</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Bootstrap -->

    <link rel="stylesheet" href="css/principal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--Plugin jQuery-->
    <script src="js/principal.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <style>
    #map {
      height: 400px;     
        }
    .resultado {
        font-size: 40px;
        text-align: center; 
    }
    .grafico{
      width: 400px;
      height: 300px;
    }
  </style>
  
  
  <body>

    <div class="app-container">
      <div class="left-area">
        <button class="btn-close-left">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-x-circle" viewBox="0 0 24 24">
            <defs/>
            <circle cx="12" cy="12" r="10"/>
            <path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </button>
        <div class="app-name">SIG</div>
        <a href="principalvisit.html" class="item-link active" >
          <img src="img/arrow-left-circle.svg" style="opacity: 0.3; height: 2rem" title="Pagina principal">
        </a>
        <a href="manualvisit.html" class="item-link active">
          <img src="img/file-text.svg" style="opacity: 0.3; height: 2rem" title="Manual">
        </a>
        <a  class="item-link active">
          <img src="img/dash.svg" style="height: 2rem" title="Tablero de control">
        </a>
        <a href="contacto.html" class="item-link active">
          <img src="img/users.svg" style="opacity: 0.3; height: 2rem" title="Contacto">
        </a>
        <a href="index.html" class="item-link active">
          <img src="img/log-out.svg" style="opacity: 0.3; height: 2rem" title="Pagina principal">
        </a>
      </div>
      <div class="main-area">
        <button class="btn-show-right-area">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="btn-show-left-area">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <section class="content-section"  style="text-align: justify" >
          <h1 class="section-header">Panel de control</h1>
          <a class="section-header-link">
          En este sitio usted encontrará información geográfica de los establecimientos que se dedican al mantenimiento y reparación de vehículos, motocicletas y bicicletas, así como servicios de montallantas y ubicación de estaciones de servicio en la ciudad. A continuación encontrará la cantidad de establecimientos registrados en la base de datos.</a>
          <br>
          <div class="resultado" style="font-size: 25;">
            <?php

              $query = "SELECT COUNT(*) AS total_talleres FROM talleres";
              $result = pg_query($conn, $query);

              if ($result) {
                  $row = pg_fetch_assoc($result);
                  $totalTalleres = $row['total_talleres'];
                  echo "" . $totalTalleres;
              } else {
                  echo "Error al realizar la consulta.";
              };
              ?>
          </div>
          <a class="section-header-link"> La distribución de establecimientos por categoría de vehículo se presenta a continuación</a>
            <div>
            <canvas id="grafico" class="grafico"></canvas>
              <?php
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
                  type: 'pie',
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
                    responsive: true, // Hacer el gráfico responsive
                    maintainAspectRatio: false, // No mantener la relación de aspecto
                    aspectRatio: 1,
                      // Opciones y configuraciones adicionales del gráfico
                  }
              });
          </script>




            </div>
        </section>
        <section class="content-section" style="text-align: justify">
          <h1 class="section-header">Talleres por comuna </h1>
          <a class="section-header-link">
              En el siguiente gráfico se presentan la cantidad de talleres por comuna en la ciudad de Cali. En el eje horizontal se encuentran las comunas y en el vertical se muestra la cantidad de talleres.
            </a>
          <div class="content-section" style="align-items: center; align-content: center;"> 
            <?php
              // Conexión a la base de datos
              

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

              <div style="width: 500px; align-items: center; align-content: center; padding-left:50px">
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
                              label: 'Cantidad',
                              data: cantidades,
                              backgroundColor: 'rgba(75, 192, 192, 0.5)', // Color de fondo de las barras
                              borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
                              borderWidth: 1
                          }]
                      },
                      options: {
                          responsive: true,
                          maintainAspectRatio: false, // No mantener la relación de aspecto
                          aspectRatio: 1,
                          scales: {
                              y: {
                                  beginAtZero: true,
                                  stepSize: 1
                              }
                          }
                      }
                  });
              </script>
          </div>
        </section>
        <section class="content-section" style="text-align: justify">
            <h1 class="section-header">Talleres por comuna </h1>
            <a class="section-header-link">
            Se sabe que como es una gran cantidad de puntos, puede resultar abrumador visualizarlos todos al mismo tiempo, especialmente en niveles de zoom alejados. En lugar de mostrar cada marcador de forma individual, se agruparon para proporcionar una representación más clara y ordenada de los datos. A continuación, se presenta un mapa que agrupa talleres cercanos en un solo marcador cuando el nivel de zoom es alto, y se expanden cuando el nivel de zoom se reduce o se hace un acercamiento.            </a>
            <div class="files-table">
              <div id="map"></div>
              <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css" />
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css" />
              <script>
                var map = L.map('map').setView([3.418853, -76.418752], 11.3);
                var mapabase = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; OpenStreetMap contributors'
                }).addTo(map);
                var leyenda = L.control.layers({mapabase}).addTo(map);
                /////////////////////////////////////Cluster Montallantas ////////////////////////////////////////
                var markers= L.markerClusterGroup();
                // Obtener los puntos de la base de datos
                fetch('php/cluster.php')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(point => {
                            var latlng = L.latLng(point.coordinates[1], point.coordinates[0]);
                            var marker = L.marker(latlng);
                            markers.addLayer(marker);
                        });
                        map.addLayer(markers);
                    })
                    .catch(error => {
                        console.error('Error al obtener los puntos:', error);
                    });
                    L.control.scale().addTo(map);
                    leyenda.addOverlay( markers, 'Establecimientos');
            </script>
            
            </div>
          </section>
      </div>
      <div class="right-area">
        <button class="btn-close-right">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-x-circle" viewBox="0 0 24 24">
            <defs/>
            <circle cx="12" cy="12" r="10"/>
            <path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </button>
        <div class="download-item-line">
            <p class="right-area-header" style="font-size: 20px;">Enlaces de interés</p>
            <div class="line-header">Presentación</div>
            <div class="download-area">
              <div class="download-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="">
                  <defs></defs>
                  <a xlink:href="presentacion.html">
                    <circle cx="256" cy="256" r="256" fill="#4b50dd"></circle>
                    <path fill="#f5f5f5" d="M192 64h176c4.4 0 8 3.6 8 8v328c0 4.4-3.6 8-8 8H120c-4.4 0-8-3.6-8-8V148l80-84z"></path>
                    <path fill="#e6e6e6" d="M184 148c4.4 0 8-3.6 8-8V64l-80 84h72z"></path>
                    <circle cx="352" cy="384" r="52" fill="#2179a6"></circle>
                    <g fill="#f5f5f5" class="g">
                      <path d="M352 416c-2.208 0-4-1.788-4-4v-56c0-2.212 1.792-4 4-4s4 1.788 4 4v56c0 2.212-1.792 4-4 4z"></path>
                      <path d="M352 416a3.989 3.989 0 01-2.828-1.172l-20-20c-1.564-1.564-1.564-4.092 0-5.656s4.092-1.564 5.656 0L352 406.344l17.172-17.172c1.564-1.564 4.092-1.564 5.656 0s1.564 4.092 0 5.656l-20 20A3.989 3.989 0 01352 416z"></path>
                    </g>
                  </a>
                </svg>
              </div>
              <div class="download-item-texts">
                <p class="download-text-header" style="font-size: 15px;">Presentación</p>
                <p class="download-text-info">Clic en el icono para ir a la presentación</p>
              </div>
  
            </div>
            <div class="line-header">Diseño base<br></div>
            <div class="download-area">
              <a href="https://codepen.io/aybukeceylan/pen/yLOxRyG" target="_blank" class="text-white mr-3"><i class="fa fa-eye fs-1"></i></a>
              <div class="download-item-texts">
                <p class="download-text-header" style="font-size: 15px;">CodePen</p>
                <p class="download-text-info">Aplicación web de uso compartido de archivos</p>
              </div>
            </div>
            
          </div>
          <div class="right-area-header-wrapper">
            <p class="right-area-header" style="font-size: 20px;">Contacto</p>
          </div>
          <div class="line-header">Camila Carmona<br></div>
          <div class="download-area">
              <a href="https://www.facebook.com/camila.carmonasalazar" target="_blank" class="text-white mr-3"><i class="fab fa-facebook fs-1"></i></a>
              <a href="https://twitter.com/scarmonacamila" target="_blank" class="text-white mr-3"><i class="fab fa-twitter fs-1"></i></a>
              <a href="https://www.instagram.com/cam.csc/" target="_blank" class="text-white"><i class="fab fa-instagram fs-1"></i></a>
          </div>
          <div class="line-header">Andrés Vargas<br></div>
          <div class="download-area">
            <a href="https://www.facebook.com/J.andres.vargas.perez" target="_blank" class="text-white mr-3"><i class="fab fa-facebook fs-1"></i></a>
            <a href="https://twitter.com/___jorge_andres" target="_blank" class="text-white mr-3"><i class="fab fa-twitter fs-1"></i></a>
            <a href="https://www.instagram.com/___andres_vargas/" target="_blank" class="text-white"><i class="fab fa-instagram fs-1"></i></a>
          </div>
      </div>
    </div>
   </body>

</html>

