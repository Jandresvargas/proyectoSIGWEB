<?php
 #Archivo de configuracion de la base de datos
 
    define("PG_DB"  , "t2p");
	define("PG_HOST", "localhost");
	define("PG_USER", "postgres");
	define("PG_PSWD", "12345");
	define("PG_PORT", "5433");
	
	$dbcon = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");


	// Verificar la conexión
	if (!$dbcon) {
		echo "Error al conectar a la base de datos.";
		exit;}

		
	$sql="SELECT * from sitios_interes";
	$result=pg_query($dbcon,$sql);
?>
