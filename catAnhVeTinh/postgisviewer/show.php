<?php 
	include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/process/crop.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/process/combinationColor.php');
	/*

	test=[]
            test.append({})
            test[0].update({0:{} })
            test[0][0].update({'ImageName':'yellow-lily.jpg'})
            test[0][0].update({'ArquiredDate': '2013-12-23'})
            test[0][0].update({'BandName': 123})
            test[0].update({'numberImage':1})
            test[0].update({'ErrorMessage':5})
            test[0][0].update({'LinkPreview':"'http://127.0.0.1:8000/media/Crop1.TIF'"})
	[{0: {'ImageName': 'yellow-lily.jpg', 
			'BandName': 123, 'ArquiredDate': '2013-12-23', 'LinkPreview': "'http://127.0.0.1:8000/media/Crop1.TIF'"}, 'numberImage': 1, 'ErrorMessage': 5}]
            {
    "typeData: 0 | 1"
	"fromTime":"2014-3-1",
	"toTime":"2014-3-7",
	"numBands":3,
	"band0":"1",
	"band1":"2",
	"band2":"3",
	""
	"lat0":"21.10308",
	"lg0":"105.64625",
	"lat1":"21.10308",
	"lg1":"105.88245",
	"lat2":"20.96144",
	"lg2":"105.64625",
	"lat3":"20.96144",
	"lg3":"105.88245"
	}

	*/

	$data = $_POST["data"];
	//$test = split($datas, ':');
	//$test = explode(':', $datas);
	$test = json_decode($data, TRUE);

	if($_POST){
		if ($test["typeData"] == 0){
			if($test["process"] == 2)
				getCombineColorPolygon($test);
		}else{
			if($test["process"] == 1)
				echo json_encode(getCropImage($test));
			if($test["process"] == 2)
				getCombineColor($test);
			//if($test["process"] == 3)
		}
		
		/*8
		$lat = array();
		for($i = 0; $i < 8; $i+=2){
			$lat[$i] = $test["lg".(string)($i/2)];
			$a .= $lat[$i] . " ";
			$lat[$i+1] = $test["lat".(string)($i/2)];
			$a .= $lat[$i+1] . ", ";
		}
		
		$result = array(
			"ErrorCode" => 5,
			"resultList" => array(
				array(
					"ImageName" => "yellow-lily0.jpg",
					"ArquiredDate" => "2013-12-23",
					"BandName" => 123,
					"LinkPreview" => "http://127.0.0.1:8000/media/Crop1.TIF"
				),
				array(
					"ImageName" => "yellow-lily1.jpg",
					"ArquiredDate" => "2013-12-23",
					"BandName" => 123,
					"LinkPreview" => "http://127.0.0.1:8000/media/Crop1.TIF"
				)
			)
		);
		$c = array(
			"ImageName" => "yellow-lily2.jpg",
			"ArquiredDate" => "2013-12-23",
			"BandName" => 123,
			"LinkPreview" => "http://localhost/catAnhVeTinh/images/word2013icon.png"
		);
		$result["resultList"][] = $c;
		
		echo json_encode($result);	
*/
	}else{
		echo "Error!";
	}
	/*
	$a .= $lat[0] . " " . $lat[1];
	$query="SELECT ST_PolygonFromText('POLYGON(($a))');";
	
	$rs = pg_query($db, $query) or die("Cannot execute query: $query\n");
	while ($row = pg_fetch_row($rs)) {
		# code...
		echo $row[0];
	}

	*/
?>