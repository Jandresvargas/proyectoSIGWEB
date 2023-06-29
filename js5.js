const express = require('express');
const { Pool } = require('pg');

const app = express();
const pool = new Pool({
  user: 'tu_usuario',
  host: 'localhost',
  database: 'tu_base_de_datos',
  password: 'tu_contraseña',
  port: 5432,
});

app.use(express.json());

// Ruta para obtener la ruta de enrutamiento
app.post('/ruta', async (req, res) => {
  const { inicio, destino } = req.body;

  // Consulta SQL para obtener la ruta utilizando pgRouting
  const query = `
    SELECT seq, node, edge, cost, geom
    FROM pgr_dijkstra(
      'SELECT id, source, target, length AS cost FROM red_de_carreteras',
      $1, $2, false
    ) AS route
    JOIN red_de_carreteras AS rd ON route.edge = rd.id
  `;

  try {
    const result = await pool.query(query, [inicio, destino]);
    const ruta = result.rows.map(row => row.geom);

    res.json({ ruta });
  } catch (error) {
    console.error('Error al obtener la ruta:', error);
    res.status(500).json({ error: 'Error al obtener la ruta' });
  }
});

// Iniciar el servidor
app.listen(3000, () => {
  console.log('Servidor en ejecución en http://localhost:3000');
});
