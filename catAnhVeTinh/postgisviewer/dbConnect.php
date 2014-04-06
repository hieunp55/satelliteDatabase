<?php 
	//echo extension_loaded('pgsql') ? 'yes':'no';
	#$host = "host=192.168.0.190";//127.0.0.1";
	$host = "host=127.0.0.1";
	$port = "port=5433";
	$dbname ="dbname=postgres";//testdb";
	$credentials = "user=postgres password=123456";
	
	//test with testdb
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		#echo "Error : Unable to open database/n";
	} else{
		#echo "Opened database successfully\n";
	}
	
	#$query = "select tablename from pg_tables";
	#$query = "testdb";
	$query = "DROP TABLE IF EXISTS cars";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "CREATE TABLE cars (id INTEGER PRIMARY KEY, name VARCHAR(25), price INT)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO cars VALUES(1, 'Audi', 52642)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO cars VALUES(2, 'Merceds', 10000)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO cars VALUES(3, 'Skoda', 15000)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO cars VALUES(4, 'Volvo', 2642)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO cars VALUES(5, 'Bently', 45612)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "SELECT * FROM cars LIMIT 3";
	$rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
	?>
	<table border = "1">
	<?php
		while ($row = pg_fetch_row($rs)){
	?>
		<tr>
			<td>	
				<?php echo "$row[0]";	?>
			</td>
			<td>
				<?php echo "$row[1]"; 	?>
			</td>
		</tr>
		<?php } ?>
	</table>
<?php
	#$query = "CREATE SCHEMA name";
	/*$query = "CREATE TABLE name.company(id INT NOT NULL, 
	name VARCHAR(20) NOT NULL,";
	$query .= "age INT NOT NULL, address CHAR(25),";
	$query .= "salary DECIMAL(18, 2), PRIMARY KEY(id) )";
	echo "\n".$query ."\n";
	
	$query = "TRUNCATE TABLE name.company";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO name.company VALUES(1, 'FPT', 10, 'Hanoi', 1500.0)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO name.company VALUES(2, 'VNG', 11, 'Hatay', 25000.5)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO name.company VALUES(3, 'Tinh Van', 15, 'Danang', 6000)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO name.company VALUES(4, 'VTC', 4, 'Haiphong', 26420.568)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "INSERT INTO name.company VALUES(5, 'Facebook', 10, 'Quangninh', 45612.235)";
	pg_query($db, $query) or die("Cannot execute query: $query\n");
	
	$query = "SELECT * FROM name.company";
	$rs = pg_query($db, $query) or die("Cannot execute this query: $query\n");
	
	
	?>
	<table border = "1">
	<?php
		while ($row = pg_fetch_row($rs)){
	?>
		<tr>
			<td>	
				<?php echo "$row[0]";	?>
			</td>
			<td>
				<?php echo "$row[1]"; 	?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<br/>
	<table border = "1">
	<?php
	$query = "SELECT * FROM name.company";
	$rs = pg_query($db, $query) or die("Cannot execute this query: $query\n");
		while ($row = pg_fetch_assoc($rs)){
	?>
		<tr>
			<td>	
				<?php echo $row['id'];	?>
			</td>
			<td>
				<?php echo $row['name']; 	?>
			</td>
			<td>
				<?php echo $row['age']; 	?>
			</td>
			<td>
				<?php echo $row['salary']; 	?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<br/>
	<table border = "1">
	<?php
	$query = "SELECT * FROM name.company";
	$rs = pg_query($db, $query) or die("Cannot execute this query: $query\n");
		while ($row = pg_fetch_object($rs)){
	?>
		<tr>
			<td>	
				<?php echo "$row->id";	?>
			</td>
			<td>
				<?php echo "$row->name"; 	?>
			</td>
			<td>
				<?php echo "$row->age"; 	?>
			</td>
			<td>
				<?php echo "$row->salary"; 	?>
			</td>
		</tr>
		<?php } ?>
	</table>
<?php
	
	$query = "SELECT ST_AsPNG(rast,ARRAY[2,1,3],1) As rastjpg  FROM public.ldcm30 WHERE rid=2;";
	$rs = pg_query($db, $query) or die("Cannot execute this query: $query\n");
	$row = pg_fetch_row($rs);
	pg_free_result($rs);
	header('Content-Type: image/png');
	imagepng(pg_unescape_bytea($row[0]));
*/
	pg_close($db);
?>