<?php
 #Archivo de configuracion de la base de datos
 
    define("PG_DB"  , "sigweb");
	define("PG_HOST", "localhost");
	define("PG_USER", "posgres");
	define("PG_PSWD", "12345");
	define("PG_PORT", "5433");
	
	$dbcon = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");


?>
