
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

  </style>
  <style>
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
    <!-- optionally define the sidebar content via HTML markup -->
    <div id="sidebar" class="leaflet-sidebar collapsed">

      <!-- nav tabs -->
      <div class="leaflet-sidebar-tabs">
          <!-- top aligned tabs -->
          <ul role="tablist">
              <li><a href="#home" role="tab"><i class="fa fa-bars active"></i></a></li>
              <li><a href="#autopan" role="tab"><i class="fa fa-map-marker" title="Acercar a taller"></i></a></li>
          </ul>

          <!-- bottom aligned tabs -->
          <ul role="tablist">
              <li><a href="https://github.com/Jandresvargas/proyectoSIGWEB" target="_blank"><i class="fa fa-github"></i></a></li>
          </ul>
      </div>

      <!-- panel content -->
      <div class="leaflet-sidebar-content">
          <div class="leaflet-sidebar-pane" id="home">
              <h1 class="leaflet-sidebar-header">
                  Motocicletas
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>

              <p>Tecxto </p>
              
          </div>

          <div class="leaflet-sidebar-pane" id="autopan">
              <h1 class="leaflet-sidebar-header">
                  Acercar a taller
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>
              
              <p>
                  Mas tecxto
              </p>
              <table class="ttable table-striped table-bordered" id="locationsTable">
                <!-- Encabezado de tabla -->
                <thead>
                    <tr>

                        <th>Nombre</th>
                        <th>Calificación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Consulta SQL para obtener los puntos
                        $query = "SELECT id, nombre, rating,ST_X(geom) as lng, ST_Y(geom) as lat FROM talleres WHERE categoria LIKE 'Taller de motos'";
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
          <div class="leaflet-sidebar-pane" id="router">
            <h1 class="leaflet-sidebar-header">Indicaciones<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <h1>Trazar Ruta</h1>
            <div id="routing-control" id="panel"></div>
            <button id="btnRoute">Trazar Ruta</button>
          </div>
          <div class="leaflet-sidebar-pane" id="eliminar">
            <h1 class="leaflet-sidebar-header">
                Eliminar
                <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
            </h1>
            
          </div>
          <div class="leaflet-sidebar-pane" id="manual">
            <h1 class="leaflet-sidebar-header">Manual<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <embed src="manual.pdf" type="application/pdf" width="100%" height="600px" />
          </div>
      </div>
  </div>


    <div class="app-container">
      <div class="left-area" style="z-index: 999">
        <button class="btn-close-left">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-x-circle" viewBox="0 0 24 24">
            <defs/>
            <circle cx="12" cy="12" r="10"/>
            <path d="M15 9l-6 6M9 9l6 6"/>
          </svg>
        </button>
        <div class="app-name">SIG</div>
        <a href="principal.html" class="item-link active" id="pageLink">
          <img src="img/arrow-left-circle.svg" style="opacity: 0.3; height: 2rem" title="Pagina principal">
        </a>
        <a href="manual.html" class="item-link" id="pageLink2">
          <img src="img/file-text.svg" style="opacity: 0.3; height: 2rem" title="Manual">
        </a>
        <a href="visorauto.html" class="item-link" id="pageLink3">
          <img src="img/car.svg" style="opacity: 0.3; height: 2rem" title="Taller automotriz" >
        </a>
        <a class="item-link" id="pageLink4">
          <img src="img/moto2.svg" style="height: 2rem" title="Taller de motocicletas" >
        </a>
        <a class="item-link" id="pageLink4">
          <img src="img/bike.svg" style="opacity: 0.3; height: 2rem" title="Taller de bicicletas" >
        </a>
        <a class="item-link" id="pageLink4">
          <img src="img/tire.svg" style="opacity: 0.3; height: 2rem" title="Montallantas" >
        </a>
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
            <h1 class="section-header" style="font-size: 15px; text-align: center; margin-bottom: 5px; margin-top: 5px;">Visor de Talleres en Santiago de Cali</h1>
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
              
            // {
              //zoomControl:true, maxZoom:19, minZoom:5
            //} Cree un objeto de mapa Leaflet en el div con id "mapid" 4.674704, -74.030091
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
                  //currentMarker.bindPopup('<?php echo $nombre?>' + nombre).openPopup();
                  map.flyTo([lat, lng], 18);
                  }
                   // POP UP de información de puntos  
              function info_popup(feature, layer){
                  layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Rating: </strong>"+feature.properties.rating+"<br/>"+"<strong> Servicios: </strong> <br>"+feature.properties.servicio1+"<br/>"+feature.properties.servicio2+"<br/>"+feature.properties.servicio3+"<br/>"+"<strong> Direccion: </strong>"+feature.properties.direccion+"<br/>"+"<strong> Web: </strong>"+feature.properties.web+"<br/>"+"<strong> Telefono: </strong>"+feature.properties.telefono+"<br/>");
              }
              //carga la capa Motos como geojson desde la gdb
              var motos = L.geoJSON();
                  $.post("php/cargar_motorbike.php",
                      {
                          peticion: 'cargar',
                      },function (data, status, feature)
                      {
                      if(status=='success')
                      {
                          motos = eval('('+data+')');
                          var motos = L.geoJSON(motos, {
                      onEachFeature: info_popup
                          });
                          
                          motos.eachLayer(function (layer) {
                          layer.setZIndexOffset(1000);
                          });
                  leyenda.addOverlay(motos, 'Talleres de motos');
                      }
                  });

              var sidebar = L.control.sidebar({ container: 'sidebar',  position: "right" }).addTo(map);
              var routingControl = null;
              var userMarker = null;
              //////////////////////////////////////////// Routing

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
        // add panels dynamically to the sidebar
        sidebar
            .addPanel({
                id:   'router',
                tab:  '<i class="fa fa-crosshairs"></i>',
                title: 'Indicaciones'
            })
            // add a tab with a click callback, initially disabled
            // Panel de eliminar datos 
            .addPanel({
                id:   'eliminar',
                title: 'Eliminar registro',
                tab:  '<i class="fa fa-trash-o"></i>'
            })
            .addPanel({
                id:   'manual',
                tab:  '<i class="fa fa-file-pdf-o"></i>',
                title: 'Manual de usuario',

            })
            // be notified when a panel is opened
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

