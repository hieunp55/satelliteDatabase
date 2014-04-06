<?php 
	//echo extension_loaded('pgsql') ? 'yes':'no';
	/*
	$host = "host=192.168.0.190";//127.0.0.1";
	#$host = "host=127.0.0.1";
	$port = "port=5432";
	$dbname ="dbname=spatial_db";//testdb";
	$credentials = "user=postgres password=uet123";

	*/

	$host = "host=localhost";//127.0.0.1";
	#$host = "host=127.0.0.1";
	$port = "port=5433";
	$dbname ="dbname=postgres";//testdb";
	$credentials = "user=postgres password=123456";

	
	#header('Content-Type: image/png');
	//test with testdb
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		echo 0;
	} else{
		#echo 1;
	}
?>
	