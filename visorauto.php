
<?php 
	define("PG_DB"  , "Proyecto_SIGWEB");
	define("PG_HOST", "localhost");
	define("PG_USER", "postgres");
	define("PG_PSWD", "12345");
	define("PG_PORT", "5433");
	
	$conexion = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
    if (!$conexion) {
        echo "Error de conexión con la base de datos.";
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
    <title>Visor</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="css/routepanel.css">
      <!-- Google Maps API -->
	  <script src="https://maps.googleapis.com/maps/api/js?key="></script>
    <!-- Bootstrap -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Leaflet-Pegman -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-pegman@0.1.6/leaflet-pegman.css" />
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sidebar/css/leaflet-sidebar.css" />
    <link rel="stylesheet" href="css/principal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--Plugin jQuery-->
    <script src="js/principal.js"></script>   
  </head>
  <style>
    #map {
      height:545px; 
      border-radius: 1rem;    
        }
    .lorem {
        font-style: italic;
        text-align: justify;
        color: #AAA;
    }
    #bufferSlider {
            width: 300px;
        }

    #data-table {
        margin-top: 20px;
        border-collapse: collapse;
    }

    #data-table th,
    #data-table td {
        padding: 8px;
        border: 1px solid black;
    }
  </style>
  <style>
    /* ESTILO PARA STREET VIEW
		/* Fixes Google Mutant Empty attribution */
		.leaflet-bottom.leaflet-left,
		.leaflet-bottom.leaflet-right {
			margin-bottom: initial !important;
		}

		/* Make Google Logo/ToS/Feedback links clickable */
		.leaflet-google-mutant a,
		.leaflet-google-mutant button {
			pointer-events: auto;
		}

		/* Move Google ToS/Feedback to the top */
		.leaflet-google-mutant .gmnoprint,
		.leaflet-google-mutant .gm-style-cc {
			top: 0;
			bottom: auto !important;
		}
	</style>
  <body>
    <!-- Definición de sidebar -->
    <div id="sidebar" class="leaflet-sidebar collapsed">

      <!-- divisiones de sidebar -->
      <div class="leaflet-sidebar-tabs">
          <!-- iconos superiores -->
          <ul role="tablist">
              <li><a href="#home" role="tab"><i class="fa fa-bars active"></i></a></li>
              <li><a href="#autopan" role="tab"><i class="fa fa-map-marker" title="Acercar a taller"></i></a></li>
          </ul>

          <!-- Icono inferior GitHub -->
          <ul role="tablist">
              <li><a href="https://github.com/Jandresvargas/proyectoSIGWEB" target="_blank"><i class="fa fa-github"></i></a></li>
          </ul>
      </div>

      <!-- Contenido de los paneles -->
      <div class="leaflet-sidebar-content">
          <div class="leaflet-sidebar-pane" id="home">
              <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                  Barra de utilidades
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>
              <br>
              <!-- Imagen de panel -->
              <a href="https://conecta.tec.mx/sites/default/files/inline-images/mapa_mental_interior.jpg" target="u_blank">
                <img class="img-thumbnail" style="align-content: center; margin-left: 1rem;" src="img/tools.jpg" width="350" height="350">
              </a>
              <!-- Parrafo de panel -->
              <p style="font-family: 'DM Sans', sans-serif; font-size: 15px; text-align: justify">Este visor geográfico contiene una interfaz gráfica que proporciona acceso a diversas herramientas y funcionalidades para interactuar con los datos geográficos. Estas herramientas son botones, sliders y opciones desplegables donde los usuarios pueden seleccionar y configurar diferentes operaciones relacionadas con la visualización y análisis de datos espaciales. </p>
              
          </div>
          <!-- Panel de acercamiento a punto -->
          <div class="leaflet-sidebar-pane" id="autopan">
              <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                  Acercar a taller
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>
              <br>
              <!-- Imagen de panel -->
              <a href="https://pic.clubic.com/v1/images/2057052/raw?fit=max&width=1200&hash=cec83ddbea87077ac7bcaabd89471f29178fa68b" target="u_blank">
                <img class="img-thumbnail" style="align-content: center; margin-left: 3rem;" src="img/point.jfif" width="300" height="300">
            </a>
            <!-- Parrafo de panel -->
              <p style="font-family: 'DM Sans', sans-serif; font-size: 15px; text-align: justify">
                  De clic en el botón de "Zoom" del registro al cual desea hacer un acercamiento. 
              </p>
              <!-- Tabla de datos + boton de zoom -->
              <table class="table table-striped table-bordered" id="locationsTable" style="font-family: 'DM Sans', sans-serif; font-size: 13px;">
                <!-- Encabezado de tabla -->
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Calificación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <!-- Cuerpo de tabla -->
                <tbody>
                    <?php
                        // Consulta SQL para obtener los puntos
                        $query = "SELECT id, nombre, rating,ST_X(geom) as lng, ST_Y(geom) as lat FROM talleres WHERE categoria LIKE 'Taller de automóviles'";
                        $result = pg_query($conexion, $query);
                        if (!$result) {
                        echo "Error al obtener los puntos.";
                        exit;
                        }
                        // Array para almacenar marcadores
                        $markers = [];

                        // Iterar resultados, generar las filas de la tabla y marcadores
                        while ($row = pg_fetch_assoc($result)) {
                            $nombre = $row['nombre'];
                            $rating = $row['rating'];
                            $lat = $row['lat'];
                            $lng = $row['lng'];
                            echo "<tr>";
                            echo "<td>$nombre</td>";
                            echo "<td>$rating</td>";
                            echo "<td><button onclick=\"zoomToLocation($lat, $lng)\">Zoom</button></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
          </div>
          <!-- Panel de ruteo -->
          <div class="leaflet-sidebar-pane" id="router">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Indicaciones<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <!-- Imagen de panel -->
            <a href="https://www.cotoconsulting.com/wp-content/uploads/2021/03/Delimitacion-del-area-de-influencia-1.png" target="u_blank">
                <img class="img-thumbnail" style="align-content: center; margin-left: 3rem;" src="img/buffer.png" width="250" height="250">
            </a>
            <!-- Parrafo de panel -->
            <p style="font-family: 'DM Sans', sans-serif; font-size: 15px; text-align: justify">Esta herramienta de indicaciones o ruteo en visor es una permite calcular y visualizar rutas entre dos ubicaciones específicas. Estas definen la ruta que se puede tomar entre la ubicación del usuario y un punto que se ubica moviendo el marcador de destino.</p>
            <div id="routing-control" id="panel"></div>
            <!-- Botón para activar proceso -->
            <button id="btnRoute" class="btn btn-primary">Trazar Ruta</button>
          </div>
          <!-- Panel de buffer -->
          <div class="leaflet-sidebar-pane" id="buffer">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                Cercania
                <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
            </h1>
            <br>
            <!-- Imagen de panel -->
            <a href="https://www.trinetrawireless.com/wp-content/uploads/2017/12/Efficient-Fleet-Route-Optimization-With-Trinetra-Wireless.jpg" target="u_blank">
                <img class="img-thumbnail" style="align-content: center; margin-left: 2rem;" src="img/route.jpg" width="300" height="300">
            </a>
            <!-- Parrafo de panel -->
            <p style="font-family: 'DM Sans', sans-serif; font-size: 15px; text-align: justify">Esta herramienta crea un área de influencia alrededor de la ubicación del usuario. El buffer se define estableciendo una distancia por medio del deslizador y se utiliza para encontrar talleres dentro del determinado alrededor del usuario.</p>
            <span id="minValue" style="font-family: 'DM Sans', sans-serif; font-size: 11px; text-align: justify">100m</span>
            <!-- Deslizador -->
            <input type="range" id="bufferSlider" min="100" max="2000" step="100" value="1000">
            <span id="maxValue" style="font-family: 'DM Sans', sans-serif; font-size: 11px; text-align: justify">2000m <br></span>
            <!-- Boton de iniciar proceso -->
            <button id="processButton" class="btn btn-primary">Iniciar proceso</button>
            <!-- Tabla para visualizar datos de puntos  -->
            <table class="table table-striped table-bordered" id="data-table" style="font-family: 'DM Sans', sans-serif; font-size: 13px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody id="data-body">
                </tbody>
            </table>
          </div>
          <!-- Panel de manual -->
          <div class="leaflet-sidebar-pane" id="manual">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Manual<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <!-- Insertar manual -->
            <embed src="manual.pdf" type="application/pdf" width="100%" height="600px" />
          </div>
      </div>
  </div>

    <!-- Contenedor principal -->
    <div class="app-container">
      <div class="left-area" style="z-index: 999">
        <!-- Panel al abrir en movil -->
        <button class="btn-close-left">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-x-circle" viewBox="0 0 24 24">
            <defs/>
            <circle cx="12" cy="12" r="10"/>
            <path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </button>
        <!-- Titulo -->
        <div class="app-name">SIG</div>
        <!-- Enlace a pagina principal -->
        <a href="principal.html" class="item-link active" id="pageLink">
          <img src="img/arrow-left-circle.svg" style="opacity: 0.3; height: 2rem" title="Pagina principal">
        </a>
        <!-- Enlace a bombas -->
        <a href="visorbomba.php" class="item-link" id="pageLink2">
          <img src="img/bomba.svg" style="opacity: 0.3; height: 2rem" title="Estaciones de servicio">
        </a>
        <!-- Enlace a visor talleres automotrices -->
        <a href="visorauto.html" class="item-link" id="pageLink3">
          <img src="img/car.svg" style="height: 2rem" title="Taller automotriz" >
        </a>
        <!-- Enlace a taller de motos -->
        <a href="visormotorbike.php" class="item-link" id="pageLink4">
          <img src="img/moto2.svg" style="opacity: 0.3; height: 2rem" title="Taller de motocicletas" >
        </a>
        <!-- Enlace a taller de bicicletas -->
        <a href="visorbike.php" class="item-link" id="pageLink4">
          <img src="img/bike.svg" style="opacity: 0.3; height: 2rem" title="Taller de bicicletas" >
        </a>
        <!-- Enlace a montallantas -->
        <a href="visormontallantas.php" class="item-link" id="pageLink4">
          <img src="img/tire.svg" style="opacity: 0.3; height: 2rem" title="Montallantas" >
        </a>
        <!-- SALIR -->
        <a href="principal2.html">
            <button id="btnSalir" class="btn-logout">
              <img src="img/log-out.svg" style="opacity: 0.3; height: 2rem" title="Salir">
            </button>
        </a>
        
      </div>
      <div class="main-area" style="padding-bottom: 5px;">

        <button class="btn-show-left-area">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        <section class="content-section" style="margin-top: 0px; padding: 10px;">
          <div class="section-header-wrapper">
            <h1 class="section-header" style="font-size: 15px; text-align: center; margin-bottom: 5px; margin-top: 5px;">Talleres de automóviles</h1>
          </div>
          <div class="files-table" style="padding: 5px">
            <div id="map" style="z-index: 0">
            <!-- Norte -->
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.css" /> 
                <!-- Minimapa -->
            <link rel="stylesheet" href="Leaflet-MiniMap-master/Control.MiniMap.css" />
            <script src="Leaflet-MiniMap-master/Control.MiniMap.js" type="text/javascript"></script>
            <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
            <script src="https://unpkg.com/leaflet-sidebar-v2/js/leaflet-sidebar.min.js"></script>
            <script src="sidebar/js/leaflet-sidebar.js"></script>
            <script src="https://unpkg.com/leaflet-pegman@0.1.6/leaflet-pegman.js"></script>
            <!-- interact.js -->
            <script src="https://unpkg.com/interactjs@1.2.9/dist/interact.min.js"></script>
            <!-- Leaflet-GoogleMutant -->
            <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@0.10.0/Leaflet.GoogleMutant.js"></script>
            <script>
              
           //////////////////////////////////////////// mapa///////////////////////////////////////
              var map = L.map('map',{
                zoomControl:true, maxZoom:18, minZoom:7
              } ).setView([3.418853, -76.518752], 11.5);
              // Añadir un mosaico de mapas a tu mapa
              var OpenStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
              }).addTo(map);
              var satelite = new L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                  maxZoom: 18,
                  subdomains:['mt0','mt1','mt2','mt3']});
              var miniMap = new L.Control.MiniMap(L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'), {
                  toggleDisplay: true,
                  minimized: true,
                  position: "bottomleft",
                  width: 200,
                  height: 200,
                  strings: {hideText: 'Ocultar MiniMapa', showText: 'Mostrar MiniMapa'}
              }).addTo(map);

              var pegmanControl = new L.Control.Pegman({
                position: 'bottomright', // position of control inside the map
                theme: "leaflet-pegman-v3-default", // or "leaflet-pegman-v3-small"
              });
              pegmanControl.addTo(map);
              var leyenda = L.control.layers({OpenStreetMap,satelite}).addTo(map);
              // Añadir marcadores al mapa 
              // create the sidebar instance and add it to the map
              var resetButton = L.easyButton({
                position:  'topright',
                states: [{
                    stateName: 'reset-view',
                    icon: '<img src="img/slide.png"  align="absmiddle" height="20px" >',
                    title: 'Reiniciar vista',
                    onClick: function(control) {
                    // Restablecer la vista del mapa a la posición inicial
                    map.setView([3.418853, -76.518752], 11.5);
                    }
                }]
                }).addTo(map);
                //Agregar escala 
                L.control.scale().addTo(map)
                // Agregar el botón de reseteo de vista al mapa
                resetButton.addTo(map);
              var comunas = L.tileLayer.wms('http://ws-idesc.cali.gov.co:8081/geoserver/wfs?',
                  {
                  layers: 'idesc:mc_comunas',
                  format: 'image/png',
                  transparent: true,
                  }).addTo(map);
                  // WFS de barrios, filtrado por barrios que tienen cómo atributo de comuna 22
              var barrios = L.tileLayer.wms('http://ws-idesc.cali.gov.co:8081/geoserver/wfs?',
                  {
                  layers: 'idesc:mc_barrios',
                  format: 'image/png',
                  transparent: true,
                  tms: true
                  });
                  /// Crear variable para los marcadores de visualizacion de puntos individuales
              var currentMarker;
                  // Funcion para acercamiento a puntos individuales
              function zoomToLocation(lat, lng, nombre) {
                  if (currentMarker) {
                      map.removeLayer(currentMarker);
                  }
                  // Creación de marcador en el punto 
                  currentMarker = L.marker([lat, lng]).addTo(map);

                  map.flyTo([lat, lng], 18);
                  }
                   // POP UP de información de puntos  
              function info_popup(feature, layer){
                  layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Rating: </strong>"+feature.properties.rating+"<br/>"+"<strong> Servicios: </strong> <br>"+feature.properties.servicio1+"<br/>"+feature.properties.servicio2+"<br/>"+feature.properties.servicio3+"<br/>"+"<strong> Direccion: </strong>"+feature.properties.direccion+"<br/>"+"<strong> Web: </strong>"+feature.properties.web+"<br/>"+"<strong> Telefono: </strong>"+feature.properties.telefono+"<br/>");
              }
              //carga la capa Motos como geojson desde la gdb
              var auto = L.geoJSON();
                  $.post("php/cargarauto.php",
                      {
                          peticion: 'cargar',
                      },function (data, status, feature)
                      {
                      if(status=='success')
                      {
                        auto = eval('('+data+')');
                          var auto = L.geoJSON(auto, {
                      onEachFeature: info_popup
                          });
                          
                          auto.eachLayer(function (layer) {
                          layer.setZIndexOffset(1000);
                          });
                  // Agregar capa al controlador de capas
                  leyenda.addOverlay(auto, 'Talleres de automóviles');
                      }
                  });
              /// Agregar side bar al mapa
              var sidebar = L.control.sidebar({ container: 'sidebar',  position: "right" }).addTo(map);
              var routingControl = null;
              var userMarker = null;
              //////////////////////////////////////////// Routing ///////////////////////////////////////

              document.getElementById('btnRoute').addEventListener('click', function() {
              if (routingControl) {
                // Si ya hay un control de enrutamiento activo, se cancela
                routingControl.getPlan().setWaypoints([]);
                routingControl.spliceWaypoints(0, 2);
                map.removeControl(routingControl);
                routingControl = null;

                // Se elimina el marcador del usuario si existe
                if (userMarker) {
                  map.removeLayer(userMarker);
                  userMarker = null;
                }
              } else {
                // Si no hay un control de enrutamiento activo, se inicia el proceso
                map.locate({ setView: true, maxZoom: 12 });
              }
            });
            function onLocationFound(e) {
              var userLocation = e.latlng;

              userMarker = L.marker(userLocation).addTo(map).bindPopup('¡Estás aquí!').openPopup();

              var destino = L.latLng(3.382302, -76.516218);

              var controlOptions = {
                waypoints: [
                  userLocation,
                  destino
                ],
                language: 'es', 
                routeWhileDragging: true
              };
              routingControl = L.Routing.control(controlOptions).addTo(map);
              map.fitBounds(routingControl.getPlan().getBounds());
            }
            function onLocationError(e) {
              alert('No fue posible encontrar tu ubicación');
            }
            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);

        ///////////////////////////////////////////////Buffer//////////////////////////////////////////
        var buffer;
        var request;
        var isProcessing = false;
        document.getElementById('processButton').addEventListener('click', function() {
            if (isProcessing) {
                cancelProcess();
            } else {
                startProcess();
            }
        });
        function startProcess() {
            isProcessing = true;
            document.getElementById('processButton').textContent = 'Cancelar proceso';

            // Obtener la ubicación actual del usuario
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                var location = L.latLng(latitude, longitude);
                var bufferRadius = 1000; // Valor inicial del radio del buffer en metros

                generateBuffer(location, bufferRadius);
                fetchDataFromDatabase(location, bufferRadius);
            }, function(error) {
                console.error('Error al obtener la ubicación: ' + error.message);
            });
        }
        //Cancelar Buffer 
        function cancelProcess() {
            isProcessing = false;
            document.getElementById('processButton').textContent = 'Iniciar proceso';
            if (buffer) {
                buffer.remove();
                buffer = null;
            }
            if (request) {
                request.abort();
                request = null;
            }
            var dataBody = document.getElementById('data-body');
            dataBody.innerHTML = '';
        }

        // Generador de buffer
        function generateBuffer(location, bufferRadius) {
            buffer = L.circle(location, {
                radius: bufferRadius,
                color: 'blue',
                fillColor: 'lightblue',
                fillOpacity: 0.5
            }).addTo(map);

            // Ajustar la vista del mapa a la ubicación actual
            map.setView(location, 14);
            // Actualizar el buffer cuando se cambie el valor del control deslizante
            document.getElementById('bufferSlider').addEventListener('input', function(event) {
                bufferRadius = event.target.value;
                buffer.setRadius(bufferRadius);
                fetchDataFromDatabase(location, bufferRadius);
            });
        }
        function fetchDataFromDatabase(location, bufferRadius) {
            var dataBody = document.getElementById('data-body');
            dataBody.innerHTML = ''; // Limpiar los datos anteriores

            // Realizar una petición AJAX para obtener los datos de la base de datos
            request = new XMLHttpRequest();
            request.open('GET', 'php/buffer_auto.php?latitude=' + location.lat + '&longitude=' + location.lng + '&bufferRadius=' + bufferRadius, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);

                    // Mostrar los datos en la tabla
                    data.forEach(function(row) {
                        var newRow = document.createElement('tr');
                        newRow.innerHTML = '<td>' + row.id + '</td>' + '<td>' + row.nombre + '</td>';
                        dataBody.appendChild(newRow);
                    });
                } else {
                    console.error('Error al obtener los datos de la base de datos.');
                }
            };
            request.onerror = function() {
                console.error('Error al realizar la petición AJAX.');
            };
            request.send();
        }
        // Agregar paneles al sidebar
        sidebar
            .addPanel({
                id:   'router',
                tab:  '<i class="fa fa-crosshairs"></i>',
                title: 'Indicaciones'
            })

            // Panel de buffer
            .addPanel({
                id:   'buffer',
                title: 'Cercanias',
                tab:  '<i class="fa fa-dot-circle-o"></i>'
            })
            // Panel de manual
            .addPanel({
                id:   'manual',
                tab:  '<i class="fa fa-file-pdf-o"></i>',
                title: 'Manual de usuario',

            })
            // mover mapa al abrir el panel
          sidebar.on('content', function (ev) {
              switch (ev.id) {
                  case 'autopan':
                  sidebar.options.autopan = true;
                  break;
                  default:
                  sidebar.options.autopan = false;
              }
          });
            leyenda.addOverlay(comunas, 'Comuna 22');
            leyenda.addOverlay(barrios, 'Barrios y sectores');
            
          </script>
          </div>
        </section>
      </div>
      
    </div>
   </body>

</html>

