	<?php
		//---------Get list district---------
		function createQueryDistrict($id_2){
			$query = "SELECT gid, name_3 FROM vnm_adm3 WHERE id_2 = " . $id_2;

			return $query;
		}

		function getResultDistrict($id_2){
			include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/dbConnect.php');
			$rs = pg_query($db, createQueryDistrict($id_2)) or die("Cannot execute query: $query\n");

			$result = array();
			//Store in an array
			while ($row = pg_fetch_row($rs)){
				$result[$row[0]] = $row[1];
			}
			pg_close($db);
			return $result;
		}
	?>