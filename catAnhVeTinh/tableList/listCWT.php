	<?php
		//---------Get list district---------
		function createQueryCWT($id_3){
			$query = "SELECT gid, name_4 FROM vnm_adm4 WHERE id_3 = " . $id_3;

			return $query;
		}

		function getResultCWT($id_3){
			include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/dbConnect.php');
			$rs = pg_query($db, createQueryCWT($id_3)) or die("Cannot execute query\n");

			$result = array();
			//Store in an array
			while ($row = pg_fetch_row($rs)){
				$result[$row[0]] = $row[1];
			}
			pg_close($db);
			return $result;
		}
	?>