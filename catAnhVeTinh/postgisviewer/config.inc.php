<?php $conn = array(
	'dbname' => 'postgres',
	'host' => '127.0.0.1',
	'port' => '5433',
	'user' => 'postgres',
	'password' => '123456',
	'options' => ''
);
/** use this one if you are running PostgreSQL 9.0+ and have an older driver **/
//$bytea_output_setting = "set bytea_output='escape';" 
/** use database default **/
$bytea_output_setting = ""; 
?>