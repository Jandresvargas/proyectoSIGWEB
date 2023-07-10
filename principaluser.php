<!-- Conexion para tabla -->
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
    <title>Visor usuario</title>
    <link rel="icon" href="img/puntos.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="css/routepanel.css">
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    

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
    #routing-control{

      background-color: green;
    }
    #form {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid black;
            border-radius: 5px;
            z-index: 9999;
        }
    #form input {
        margin-bottom: 0px;
    }

    #form button {
        margin-top: 0px;
    }
  </style>
  <script>
        $(document).ready(function() {
            // Función para enviar la solicitud de eliminación del punto
            function eliminarPunto(id2) {
                $.ajax({
                    url: 'php/eliminar.php',
                    type: 'POST',
                    data: { id: id2 },
                    success: function(response) {
                        alert(response);
                    },
                    error: function() {
                        alert('Error al eliminar el punto.');
                    }
                });
            }
            // Manejador de eventos para el botón de eliminación
            $('#btnEliminar').on('click', function() {
                var id2 = $('#id2').val();
                eliminarPunto(id2);
            });
        });
    </script>
  <body>
    <!-- optionally define the sidebar content via HTML markup -->
    <div id="sidebar" class="leaflet-sidebar collapsed">

      <!-- nav tabs -->
      <div class="leaflet-sidebar-tabs">
          <!-- top aligned tabs -->
          <ul role="tablist">
              <li><a href="#home" role="tab"><i class="fa fa-folder-open"></i></a></li>
              <li><a href="#autopan" role="tab"><i class="fa fa-plus-square-o" title="Agregar registro"></i></a></li>
          </ul>
        
          <!-- bottom aligned tabs -->
          <ul role="tablist">
              <li><a href="https://github.com/Jandresvargas/proyectoSIGWEB" target="_blank" title="Ir al código"><i class="fa fa-github"></i></a></li>
          </ul>
      </div>

      <!-- panel content -->
      <div class="leaflet-sidebar-content">
          <div class="leaflet-sidebar-pane" id="home">
              <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                  Herramientas de edición
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>
              <br>
            <a href="https://cdn-icons-png.flaticon.com/512/2255/2255354.png" target="_blank" class="item-link active" id="pageLink">
                <img src="img/data.png" style="height: 150px; padding-left:35%;" title="Pagina principal">
            </a>
              <p style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify"><br>En esta barra de herramientas usted encontrará opciones para el manejo y administración de información de la base de datos, utilidades como eliminar, editar y agregar registros según desee. </p>
              
          </div>

          <div class="leaflet-sidebar-pane" id="autopan">
            
              <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                  Agregar
                  <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
              </h1>

              <br>
              <a href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4dyqa2e7MDMjIiMxM4o8cY0VRBmd3D3uzpMJ1iW3mZjw2Zy08hKPL25J62WgDUIb3YO4&usqp=CAU" target="_blank" class="item-link active" id="pageLink">
                <img src="img/add.png" style="height: 150px; padding-left:35%;" title="Pagina principal">
            </a>
                <br>
              <p style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                  En esta sección usted podrá registrar o agregar nuevos establecimientos (talleres) a la base de datos.
              </p>
              <button class="btn btn-primary" id="btnAgregarDatos">Agregar Datos</button>
              <!-- Formulario para agregar punto a la base de datos  -->
                <div id="form" style="left: 52%; top: 120%; width: 75%; padding:10px;">
                    <form id="pointForm" method="POST" action="php/agregar.php">
                        <input class="form-control" type="text" id="id" name="id" placeholder="Identificación" required>
                        <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                        <input class="form-control" type="text" id="categoria"  name="categoria" placeholder="Categoria" required>

                        <input class="form-control" type="text" id="rating" name="rating" placeholder="Calificación">
                        <input class="form-control" type="text" id="servicio1" name="servicio1" placeholder="Servicio">
                        <input class="form-control" type="text" id="servicio2" name="servicio2" placeholder="Servicio">
                        <input class="form-control" type="text" id="servicio3" name="servicio3" placeholder="Servicio">

                        <input class="form-control" type="text" id="direccion"  name="direccion" placeholder="Dirección">
                        <input class="form-control" type="text" id="web" name="web" placeholder="Página web">
                        <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Telefono">
                        <input class="form-control" type="text" id="propietario"  name="propietario" placeholder="Propietario">

                        <input class="form-control" id="latitude" name="latitude" placeholder="Latitud" readonly>
                        <input class="form-control" id="longitude" name="longitude" placeholder="Longitud" readonly>
                        <!-- Botones -->
                        <button class="btn btn-success" type="submit">Guardar</button>
                        <button class="btn btn-danger" type="button" onclick="cancelForm()">Cancelar</button>
                    </form>
                </div>

          </div>
          <div class="leaflet-sidebar-pane" id="eliminar">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Eliminar<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <a href="https://cdn-icons-png.flaticon.com/512/970/970348.png" class="item-link active" id="pageLink" target="_blank">
                <img src="img/delete.png" style="height: 150px; padding-left:35%;" title="Pagina principal">
            </a>

            <!-- Agrega formulario de eliminar dentro del panel -->
            <div style="margin-top:20px;">
                <h1 style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Eliminar Dato</h1>
                <p style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                    En esta sección usted podrá eliminar registros de la base de datos conociendo el número de identificación del mismo 
                </p>
                <label for="idlbl" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">ID del Punto:</label>
                <input type="text" class="form-control" id="id2" required>
                <br>
                <!-- Botón de eliminar -->
                <button class="btn btn-danger" id="btnEliminar">Eliminar</button>
            </div>

          </div>
          <div class="leaflet-sidebar-pane" id="editar">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                Editar
                <span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span>
            </h1>
            <br>
            <a href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSycbMYeaQuUaEkAbaNhxK738h3FL4DRstz0_ZQy1nOlPUcLzTdD94_RW7zBSxGD32a3ho&usqp=CAU" class="item-link active" target="_blank" id="pageLink">
                <img src="img/edit.png" style="height: 150px; padding-left:35%;" title="Pagina principal">
            </a>
            <br>
            <p style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">
                En esta sección usted podrá editar información de registros de la base de datos, ingresando el identificador del punto a editar, agregando los datos nuevos que tendrá el registro y seleccionando en el mapa la nueva localización del taller. Finalmente, con el botón de guardar se realiza el envío de la información
            </p>

            <!-- Botón de iniciar edición  -->
            <button class="btn btn-primary" id="startEditingBtn">Comenzar Edición</button>
                <!-- Formulario que aparece al dar clic en el boton de editar -->
                <form id="editForm" action="php/editar.php" method="POST" style="display: none;">
                    <fieldset>
                        <br>
                        <!-- Localización -->
                        <div class="form-group">
                            <input  type="hidden" id="lat" name="lat">
                            <input type="hidden" id="long" name="long">
                        </div>
                        <!-- Información del dato -->
                        <div class="form-group">
                            <label for="id"  style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Datos generales:</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Identificador" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de establecimiento" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Tipo de taller" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="rating" name="rating" placeholder="Calificación" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo"  style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Servicios :</label>
                            <input type="text" class="form-control" id="servicio1" name="servicio1" placeholder="Servicio" required>
                            <input type="text" class="form-control" id="servicio2" name="servicio2" placeholder="Servicio" required>
                            <input type="text" class="form-control" id="servicio3" name="servicio3" placeholder="Servicio" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo"  style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Contacto:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="web" name="web" placeholder="Pagina web" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="propietario" name="propietario" placeholder="Propietario" required>
                        </div>
                        <!-- Botones del formulario -->
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Guardar">
                            <button type="button" class="btn btn-danger" id="cancelEditingBtn">Cancelar</button>
                        </div>
                    </fieldset>
                </form>
          </div>
          <div class="leaflet-sidebar-pane" id="manual">
            <h1 class="leaflet-sidebar-header" style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify">Manual<span class="leaflet-sidebar-close"><i class="fa fa-caret-right"></i></span></h1>
            <br>
            <embed src="ManualUsuario.pdf" type="application/pdf" width="100%" height="600px" />
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
        <a href="sesion.html" class="item-link active" id="pageLink">
          <img src="img/arrow-left-circle.svg" style="opacity: 0.3; height: 2rem" title="Pagina principal">
        </a>
        <a href="manualuser.html" class="item-link" id="pageLink2">
          <img src="img/file-text.svg" style="opacity: 0.3; height: 2rem" title="Manual">
        </a>
        
        <a href="index.html">
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
            <h1 class="section-header" style="font-size: 15px; text-align: center; margin-bottom: 5px; margin-top: 5px;">Visor de usuarios</h1>
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

            <link rel="stylesheet" href="SlideMenu/src/L.Control.SlideMenu.css"/>
            <script src="SlideMenu/src/L.Control.SlideMenu.js"></script>
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

                  



                   // POP UP de información de puntos  
              function info_popup(feature, layer){
                  layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Rating: </strong>"+feature.properties.rating+"<br/>"+"<strong> Servicios: </strong> <br>"+feature.properties.servicio1+"<br/>"+feature.properties.servicio2+"<br/>"+feature.properties.servicio3+"<br/>"+"<strong> Direccion: </strong>"+feature.properties.direccion+"<br/>"+"<strong> Web: </strong>"+feature.properties.web+"<br/>"+"<strong> Telefono: </strong>"+feature.properties.telefono+"<br/>");
              }
              //carga la capa Motos como geojson desde la gdb
              var talleres = L.geoJSON();
                  $.post("php/cargar_puntos.php",
                      {
                          peticion: 'cargar',
                      },function (data, status, feature)
                      {
                      if(status=='success')
                      {
                        talleres = eval('('+data+')');
                          var talleres = L.geoJSON(talleres, {
                      onEachFeature: info_popup
                          });
                          
                          talleres.eachLayer(function (layer) {
                          layer.setZIndexOffset(1000);
                          });
                  leyenda.addOverlay(talleres, 'Talleres');
                      }
                  });


                  //////////////////////////////// EDITAR //////////////////////////////////
                  var marker = L.marker([0, 0]).addTo(map);
                  var editingEnabled = false;

                  map.on('click', function(e) {
                    // Condicion de boton de edicion habilitado
                    if (editingEnabled) {
                    var lat = e.latlng.lat;
                    var long = e.latlng.lng;
                    // crear marcador en las coordenadas donde se da clic y obtener los valores de latitud y longitud
                    marker.setLatLng([lat, long]);
                    document.getElementById('lat').value = lat;
                    document.getElementById('long').value = long;
                    }
                });
                // Definición de eventos al dar clic en el boton de iniciar edición
                document.getElementById('startEditingBtn').addEventListener('click', function() {
                    editingEnabled = true;
                    document.getElementById('editForm').style.display = 'block';
                });
                // Definición de eventos al dar clic en el boton de cancelar edición
                document.getElementById('cancelEditingBtn').addEventListener('click', function() {
                    editingEnabled = false;
                    document.getElementById('editForm').style.display = 'none';
                });
                //////////////////////////////////////////// Agregar registros //////////////////////////////////
                var clickedLatLng;
                var marker;
                // Manejador de eventos para el clic en el mapa
                function onMapClick(e) {
                    if (marker){
                        map.removeLayer(marker)
                    }
                    clickedLatLng = e.latlng;
                    document.getElementById('latitude').value = clickedLatLng.lat;
                    document.getElementById('longitude').value = clickedLatLng.lng;
                    marker = L.marker(clickedLatLng).addTo(map)
                
                }
                // Agregar el evento clic al mapa
                map.on('click', onMapClick);
                // Función para abrir el formulario
                function openForm() {
                    document.getElementById('form').style.display = 'block';
                }
                // Función para cancelar el formulario
                function cancelForm() {
                    document.getElementById('form').style.display = 'none';
                    if (marker) {
                        map.removeLayer(marker);
                    }
                }
                 // Manejador de eventos para enviar el formulario
                $('#pointForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            alert(response);
                        },
                        error: function() {
                            alert('Error al guardar el punto.');
                        }
                    });
                });
                // Agregar un evento de clic al botón del sidebar
                var btnAgregarDatos = document.getElementById('btnAgregarDatos');
                // Evento al dar clic en el boton de agregar datos 
                btnAgregarDatos.addEventListener('click', openForm);

              var sidebar = L.control.sidebar({ container: 'sidebar',  position: "right" }).addTo(map);
              ///////////////////////////// TRY TO SHOW DATA TABLE /////////////////////////////////////////


                let contentsright = `<div class="content"><h6 style="font-family: 'DM Sans', sans-serif; font-size: 18px; text-align: justify"> Tabla de registros existentes en la base de datos</h6>
                    <table class="table table-striped table-bordered" id="locationsTable">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Rating</th>
                        <th>Servicio</th>
                        <th>Servicio</th>
                        <th>Servicio</th>
                        <th>Direccion</th>
                        <th>Web</th>
                        <th>Telefono</th>
                        <th>Propietario</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Consulta SQL para obtener los puntos
                        $query = "SELECT id, nombre, categoria, rating, servicio1, servicio2, servicio3, direccion, web, telefono, propietario, ST_X(geom) as lng, ST_Y(geom) as lat FROM talleres";
                        $result = pg_query($conexion, $query);
                        if (!$result) {
                            echo "Error al obtener los puntos.";
                            exit;
                        }
                        // Array para almacenar marcadores

                        // Iterar resultados, generar las filas de la tabla y marcadores
                        while ($row = pg_fetch_assoc($result)) {
                            $id = $row['id'];
                            $nombre = $row['nombre'];
                            $categoria = $row['categoria'];
                            $rating = $row['rating'];
                            $servicio1 = $row['servicio1'];
                            $servicio2 = $row['servicio2'];
                            $servicio3 = $row['servicio3'];
                            $direccion = $row['direccion'];
                            $web = $row['web'];
                            $telefono = $row['telefono'];
                            $propietario = $row['propietario'];
                            $lat = $row['lat'];
                            $lng = $row['lng'];
                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$nombre</td>";
                            echo "<td>$categoria</td>";
                            echo "<td>$rating</td>";
                            echo "<td>$servicio1</td>";
                            echo "<td>$servicio2</td>";
                            echo "<td>$servicio3</td>";
                            echo "<td>$direccion</td>";
                            echo "<td>$web</td>";
                            echo "<td>$telefono</td>";
                            echo "<td>$propietario</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                </div>`;
                
              const slideMenu = L.control.slideMenu("", {
                position: "topleft",
                menuposition: "topleft",
                title:"sdadasdsadsad",
                width: "60%",
                height: "500px",
                delay: "10",
                icon: "fa fa-table",
                }).addTo(map);
                slideMenu.setContents(contentsright);













              
        // add panels dynamically to the sidebar
        sidebar
            .addPanel({
                id:   'eliminar',
                tab:  '<i class="fa fa-trash-o"></i>',
                title: 'Eliminar registro'
            })
            // add a tab with a click callback, initially disabled
            // Panel de eliminar datos 
            .addPanel({
                id:   'editar',
                title: 'Editar registro',
                tab:  '<i class="fa fa-pencil-square-o"></i>'
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

