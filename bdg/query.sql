CREATE EXTENSION postgis

-- Crear tabla de puntos 

CREATE TABLE sitios_interes (
		  id VARCHAR (10) PRIMARY KEY NOT NULL,
		  nombre VARCHAR(80),
		  tipo VARCHAR (50),
		  geom GEOMETRY(point)
		);
		
SELECT * FROM sitios_interes
-- Eliminar tabla
DROP TABLE talleres
-- Eliminar registros (solo usar para pruebas)
DELETE FROM talleres WHERE id = '1544'
SELECT count FROM talleres

-- Insertar valores o puntos a la tabla 
INSERT INTO talleres VALUES (1154,'Estación Naranja Bar','Bar',ST_SetSRID(ST_MakePoint(-76.5287304,3.3665456), 4326));
