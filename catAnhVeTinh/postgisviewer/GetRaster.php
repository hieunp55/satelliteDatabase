<?php
/*
include_once('config.inc.php');
header('Content-Type: image/png');

// validate parameters
foreach (array('sql', 'spatial_type', 'bvals') as $k) {
	if (!isset($_GET[$k])) $_GET[$k] = '';
	$_GET[$k] = trim($_GET[$k]);

	switch ($k) {
		case 'sql':
			if (!strlen($_GET[$k])) {
				$_GET[$k] = "ST_Buffer('MULTIPOINT((1 2),(3 4),(5 6))'::geometry,1)";
				$_GET['spatial_type'] = 'geometry';
			}
			break;
		case 'bvals':
			$_GET[$k] = explode(',', $_GET[$k]);
			$fn = create_function('&$v', '$v = intval(trim($v));$v = ($v < 0 ? 0 : ($v > 255 ? 255 : $v));');
			array_walk($_GET[$k], $fn);
			break;
		case 'spatial_type':
			$_GET[$k] = strtolower($_GET[$k]);
			if (!in_array($_GET[$k], array('raster', 'geometry')))
				$_GET[$k] = 'geometry';
			break;
	}
}

// assemble connection string
$conn_str = array();
foreach ($conn as $k => $v) {
	if (!strlen(trim($v))) continue;
	$conn_str[] = $k . '=' . trim($v);
}
$conn_str = implode(' ', $conn_str);

$dbconn = pg_connect($conn_str);
if ($dbconn === false) return;

// do query
if ($_GET['spatial_type'] != 'raster')
	$sql = "SELECT postgis_viewer_image('" . pg_escape_string($dbconn, $_GET['sql']) . "', 'geometry', ARRAY[" . implode(',', $_GET['bvals']) . "])";
else
	$sql = "SELECT postgis_viewer_image('" . pg_escape_string($dbconn, $_GET['sql']) . "', 'raster')";
$result = pg_query($sql);
if ($result === false) return;

$row = pg_fetch_row($result);
pg_free_result($result);
if ($row === false) return;

echo pg_unescape_bytea($row[0]);

$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b)) {
    // $a contains the first element of the nested array,
    // and $b contains the second element.
    echo "A: $a; B: $b\n";
}
	$a  = array("ab"=>"123", "ave"=>"ae");
	echo $a["ab"];
	test.append({})
            test[0].update({0:{} })
            test[0][0].update({'ImageName':'yellow-lily.jpg'})
            test[0][0].update({'ArquiredDate': '2013-12-23'})
            test[0][0].update({'BandName': 123})
            test[0].update({'numberImage':1})
            test[0].update({'ErrorMessage':5})
            test[0][0].update({'LinkPreview':"'http://127.0.0.1:8000/media/Crop1.TIF'"})
	*/
	$result = array(
		"ErrorCode" => 5,
		"resultList" => array(
			array(
				"ImageName" => "yellow-lily0.jpg",
				"ArquiredDate" => "2013-12-23",
				"BandName" => 123,
				"LinkPreview" => "'http://127.0.0.1:8000/media/Crop1.TIF'"
			),
			array(
				"ImageName" => "yellow-lily1.jpg",
				"ArquiredDate" => "2013-12-23",
				"BandName" => 123,
				"LinkPreview" => "'http://127.0.0.1:8000/media/Crop1.TIF'"
			)
		)
	);
	$c = array(
		"ImageName" => "yellow-lily2.jpg",
		"ArquiredDate" => "2013-12-23",
		"BandName" => 123,
		"LinkPreview" => "'http://127.0.0.1:8000/media/Crop1.TIF'"
	);
	$result["resultList"][] = $c;
	echo json_encode($result) . "</br>";	
?>
