
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
  
  <body>
    <!-- optionally define the sidebar content via HTML markup -->
    <div id="sidebar" class="leaflet-sidebar collapsed">

      <!-- nav tabs -->
      <div class="leaflet-sidebar-tabs">
          <!-- top aligned tabs -->
          <ul role="tablist">
              <li><a href="#home" role="tab"><i class="fa fa-bars active"></i></a></li>
              <li><a href="#autopan" role="tab"><i class="fa fa-arrows"></i></a></li>
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
              <table class="ttable table-striped table-bordered" id="locationsTable">
                <!-- Encabezado de tabla -->
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Consulta SQL para obtener los puntos
                        $query = "SELECT id, nombre, categoria,ST_X(geom) as lng, ST_Y(geom) as lat FROM talleres WHERE categoria LIKE 'Taller de motos'";
                        $result = pg_query($conexion, $query);
                        if (!$result) {
                        echo "Error al obtener los puntos.";
                        exit;
                        }
                        // Array para almacenar marcadores
                        $markers = [];

                        // Iterar resultados, generar las filas de la tabla y marcadores
                        while ($row = pg_fetch_assoc($result)) {
                            $id = $row['id'];
                            $nombre = $row['nombre'];
                            $categoria = $row['categoria'];
                            $lat = $row['lat'];
                            $lng = $row['lng'];
                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$nombre</td>";
                            echo "<td>$categoria</td>";
                            echo "<td><button onclick=\"zoomToLocation($lat, $lng)\">Zoom</button></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
          </div>

          <div class="leaflet-sidebar-pane" id="autopan">
              <h1 class="leaflet-sidebar-header">
                  autopan
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>
              
              <p>
                  Mas tecxto
              </p>
              
          </div>
          <div class="leaflet-sidebar-pane" id="js-api">
            <h1 class="leaflet-sidebar-header">Agregar datos<span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
            <br>
            
          </div>
          <div class="leaflet-sidebar-pane" id="eliminar">
            <h1 class="leaflet-sidebar-header">
                Eliminar
                <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
            </h1>
            
          </div>
          <div class="leaflet-sidebar-pane" id="mail">
            <h1 class="leaflet-sidebar-header">Agregar datos<span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
            <br>
            
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
          <img src="img/file-text.svg" style="opacity: 0.3; height: 2rem" title="Dashboard">
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
            <script src="sidebar/js/leaflet-sidebar.js"></script>
            <script>
              
            // {
              //zoomControl:true, maxZoom:19, minZoom:5
            //} Cree un objeto de mapa Leaflet en el div con id "mapid" 4.674704, -74.030091
              var map = L.map('map',{
                zoomControl:true, maxZoom:19, minZoom:7
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
                  layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Id: </strong>"+feature.properties.id+"<br/>"+"<strong> Categoria: </strong>"+feature.properties.categoria+"<br/>"+"<strong> Rating: </strong>"+feature.properties.rating+"<br/>"+"<strong> Servicios: </strong> <br>"+feature.properties.servicio1+"<br/>"+feature.properties.servicio2+"<br/>"+feature.properties.servicio3+"<br/>"+"<strong> Direccion: </strong>"+feature.properties.direccion+"<br/>"+"<strong> Web: </strong>"+feature.properties.web+"<br/>"+"<strong> Telefono: </strong>"+feature.properties.telefono+"<br/>");
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
        // add panels dynamically to the sidebar
        sidebar
            .addPanel({
                id:   'js-api',
                tab:  '<i class="fa fa-gear"></i>',
                title: 'JS API'
            })
            // add a tab with a click callback, initially disabled
            // Panel de eliminar datos 
            .addPanel({
                id:   'eliminar',
                title: 'Eliminar registro',
                tab:  '<i class="fa fa-trash-o"></i>'
            })
            .addPanel({
                id:   'mail',
                tab:  '<i class="fa fa-envelope"></i>',
                title: 'Messages',

            })
            leyenda.addOverlay(comunas, 'Comuna 22');
            leyenda.addOverlay(barrios, 'Barrios y sectores');
          </script>
          </div>
        </section>
      </div>
      
    </div>
   </body>

</html>

