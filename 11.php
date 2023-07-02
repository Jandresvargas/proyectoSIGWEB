<!DOCTYPE html>
<html>
<head>
  <title>Mapa con buffer y tabla de datos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
  <style>
    #map {
      height: 400px;
    }
    #data-table {
      margin-top: 20px;
    }
    #data-table th, #data-table td {
      padding: 5px 10px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <form action="21.php" method="POST">
    <input type="hidden" id="lat" name="lat">
    <input type="hidden" id="lng" name="lng">
    <input type="range" id="bufferSlider" name="buffer" min="100" max="2000" step="100" value="1000">
    <input type="submit" value="Actualizar tabla">
  </form>
  <table id="data-table">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Dirección</th>
      </tr>
    </thead>
    <tbody>
    <?php
    // Mostrar los datos si se han enviado a través del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["lat"]) && isset($_POST["lng"]) && isset($_POST["buffer"])) {
      $lat = $_POST["lat"];
      $lng = $_POST["lng"];
      $buffer = $_POST["buffer"];

      // Establecer la conexión a la base de datos
      $dbconn = pg_connect("host=localhost port=5433 dbname=t2p user=postgres password=12345");

      // Realizar la consulta para obtener los datos dentro del buffer
      $query = "SELECT nombre, tipo FROM sitios_interes WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint($lng, $lat), 4326), $buffer)";

      $result = pg_query($dbconn, $query);

      // Crear las filas de la tabla con los datos obtenidos
      while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['tipo'] . "</td>";
        echo "</tr>";
      }

      // Cerrar la conexión a la base de datos
      pg_close($dbconn);
    }
    ?>
    </tbody>
  </table>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    var map = L.map('map').setView([0, 0], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; OpenStreetMap contributors'
    }).addTo(map);

    // Obtener la ubicación actual del usuario
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      var location = L.latLng(latitude, longitude);

      // Ajustar la vista del mapa a la ubicación actual
      map.setView(location, 13);

      // Mostrar la ubicación actual en los campos de latitud y longitud del formulario
      document.getElementById('lat').value = latitude;
      document.getElementById('lng').value = longitude;

      // Actualizar el buffer cuando se cambie el valor del control deslizante
      document.getElementById('bufferSlider').addEventListener('input', function(event) {
        var bufferValue = event.target.value;
        event.target.nextElementSibling.innerHTML = bufferValue + ' metros';
      });
    }, function(error) {
      console.error('Error al obtener la ubicación: ' + error.message);
    });
  </script>
</body>
</html>
