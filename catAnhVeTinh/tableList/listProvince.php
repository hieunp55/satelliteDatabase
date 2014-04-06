<?php
	//Get list Province
	function createQueryProvince(){
		$query = "SELECT gid, name_2 FROM vnm_adm2";

		return $query;
	}

	function getResultProvince(){
		include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/dbConnect.php');
		$rs = pg_query($db, createQueryProvince()) or die("Cannot execute query: $query\n");

		$result = array();
		//Store in an array
		while ($row = pg_fetch_row($rs)){
			$result[$row[0]] = $row[1];
		}
		pg_close($db);
		return $result;
	}	
?>