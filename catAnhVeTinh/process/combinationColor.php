<?php
	function createQuery($data, $listLocation){	
		//Month day year	
		$ft = convertSTN($data["fromTime"]);
		$fromTime = GregorianToJD($ft[1], $ft[2], $ft[0]);

		$tt = convertSTN($data["toTime"]);
		$toTime = GregorianToJD($tt[1], $tt[2], $tt[0]);

		$query = "SELECT oid, lowrite(lo_open(oid, 131072), png) AS num_bytes FROM ( VALUES (lo_create(0),
      				ST_AsPNG(
                        (SELECT ST_Union(ST_Clip(ldcm30.rast, ST_Transform(geom, ldcm30.rast_srid)))
                          	FROM ldcm30, " . $listLocation[$data["typeData"] - 1] . " 
                          	WHERE gid= ". $data["cwt"] . //AND date_of_data >= $fromTime AND date_of_data <= $toTime " .
                            " AND ST_Intersects(rast_geom_4326, geom)), ARRAY[6,5,3], ARRAY['ZLEVEL=1']))) AS v(oid,png);";
		return $query;
		
	}
	function createQueryPoly($data){
		//Month day year	
		$ft = convertSTN($data["fromTime"]);
		$fromTime = GregorianToJD($ft[1], $ft[2], $ft[0]);

		$tt = convertSTN($data["toTime"]);
		$toTime = GregorianToJD($tt[1], $tt[2], $tt[0]);
		//query
		$query = "SELECT oid, lowrite(lo_open(oid, 131072), png) AS num_bytes
					FROM (
			      	VALUES (lo_create(0),
			              ST_AsPNG(
			                         (SELECT ST_Union(ST_Clip(rast, ST_Transform(ST_GeomFromText('POLYGON(( ";
		$a = "";
		for($i = 0; $i < 8; $i+=2){
			$a .= $data["lg".(string)($i/2)] . " ";
			$a .= $data["lat".(string)($i/2)] . ", ";
		}
		$a .= $data["lg".(string)(0)] . " " . $data["lat".(string)(0)];
        $query .= $a . " ))', 4326) , rast_srid)), ARRAY[ROW(6, 'LAST'),ROW(5, 'LAST'),ROW(3, 'LAST')]::unionarg[]) FROM ldcm30 ";
		$query .= " WHERE ST_Intersects(ST_GeomFromText('POLYGON((" . $a . "))', 4326), rast_geom_4326)  ";
		$query .= " )))) AS v(oid,png);"; // AND date_of_data >= $fromTime AND date_of_data <= $toTime
		
		return $query;
	}

	function createQueryData($oid){
		$query = "SELECT lo_export($oid, 'E:/Working/xampp/htdocs/catAnhVeTinh/results/test.png');";
		return $query;
	}

	function getCombineColor($data){
		$listLocation = ["vnm_adm2", "vnm_adm3", "vnm_adm4", "vnm_adm1", "vnm_adm0"];
		$result = array(
			"ErrorCode" => 5,
			"resultList" => array(
				array(
					"ImageName" => "yellow-lily0.jpg",
					"ArquiredDate" => "2013-12-23",
					"BandName" => 123,
					"LinkPreview" => "http://localhost/catAnhVeTinh/results/test6.png"
				)
			)
		);

		echo json_encode($result);
		include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/dbConnect.php');
		$rs = pg_query($db, createQuery($data, $listLocation)) or die("Cannot execute query!\n");
		
		//Store in an array
		
		if($row = pg_fetch_row($rs)){
			$output = exec("E:\Working//xampp\htdocs\catAnhVeTinh\process\getData.bat $row[0] 'E:/Working/xampp/htdocs/catAnhVeTinh/results/test6.png'");
			//print_r($output);
			//$rs1 = pg_query($db, createQueryData($row[0])) or die("Cannot execute query: $query\n");
			// spatial_db -U postgres 192.168.0.190 -p 5432
		}
		

		

		pg_close($db);
	}

	function getCombineColorPolygon($data){
		$result = array(
			"ErrorCode" => 5,
			"resultList" => array(
				array(
					"ImageName" => "yellow-lily0.jpg",
					"ArquiredDate" => "2013-12-23",
					"BandName" => 123,
					"LinkPreview" => "http://localhost/catAnhVeTinh/results/test5.png"
				)
			)
		);

		echo json_encode($result);
		include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/dbConnect.php');
		$rs = pg_query($db, createQueryPoly($data)) or die("Cannot execute query!\n");

		
		//Store in an array
		
		if($row = pg_fetch_row($rs)){
			$output = exec("E:\Working//xampp\htdocs\catAnhVeTinh\process\getData.bat $row[0] 'E:/Working/xampp/htdocs/catAnhVeTinh/results/test5.png'");
			//print_r($output);
			//$rs1 = pg_query($db, createQueryData($row[0])) or die("Cannot execute query: $query\n");
			// spatial_db -U postgres 192.168.0.190 -p 5432
			//psql -d postgres -U postgres -h 127.0.0.1 -p 5433 -c"\lo_export %1 %2"
			//psql -d postgres -U postgres -h 127.0.0.1 -p 5433 -c"\lo_unlink %1 " 
		}

		pg_close($db);
	}


	/*_______________________Processing features___________________________

	*/
	//Convert string date to number array
	function convertSTN($str){
		//Date format: year - month - day
		return explode("-", $str);
	}

	//parse band 
	function parseBand($data){

	}
?>