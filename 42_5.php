<!DOCTYPE html>
<html>
<head>
    <title>Mapa con buffer y tabla de datos - Leaflet</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #map {
            height: 400px;
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
</head>
<body>
    <div id="map"></div>
    <input type="range" id="bufferSlider" min="100" max="2000" step="100" value="1000">
    <button id="processButton">Iniciar proceso</button>
    <table id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody id="data-body">
        </tbody>
    </table>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 13);
        var OpenStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors'
        }).addTo(map);
        var leyenda = L.control.layers({OpenStreetMap}).addTo(map);
        function info_popup(feature, layer){
                  layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Rating: </strong>"+feature.properties.rating+"<br/>"+"<strong> Servicios: </strong> <br>"+feature.properties.servicio1+"<br/>"+feature.properties.servicio2+"<br/>"+feature.properties.servicio3+"<br/>"+"<strong> Direccion: </strong>"+feature.properties.direccion+"<br/>"+"<strong> Web: </strong>"+feature.properties.web+"<br/>"+"<strong> Telefono: </strong>"+feature.properties.telefono+"<br/>");
              }
        //carga la capa Motos como geojson desde la gdb
        var motos = L.geoJSON();
            $.post("php/cargar_motorbike2.php",
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

        function generateBuffer(location, bufferRadius) {
            buffer = L.circle(location, {
                radius: bufferRadius,
                color: 'blue',
                fillColor: 'lightblue',
                fillOpacity: 0.5
            }).addTo(map);

            // Ajustar la vista del mapa a la ubicación actual
            map.setView(location, 13);

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
            request.open('GET', '12.php?latitude=' + location.lat + '&longitude=' + location.lng + '&bufferRadius=' + bufferRadius, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);

                    // Mostrar los datos en la tabla
                    data.forEach(function(row) {
                        var newRow = document.createElement('tr');
                        newRow.innerHTML = '<td>' + row.id + '</td>' +
                            '<td>' + row.nombre + '</td>';
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
    </script>
</body>
</html>