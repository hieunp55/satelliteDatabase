
<?php
$xml_post = file_get_contents('php://input');
echo $xml_post;
  
   /* XML Server.
   
  // We use php://input to get the raw $_POST results.
 xml_post = file_get_contents('php://input');
	//echo  '<iframe src="http://docs.google.com/viewer?url='.'php://input'.'&embedded=true" width="600" height="780" style="border: none;"></iframe>'."</br>";
	echo $xml_post;
	//Response json data:p*/
	$datas=array(
		'numberImage'=>'10',
		1=>array(
			'ImageName'=>'Satellite Image 1',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		2=>array(
			'ImageName'=>'Satellite Image 2',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3669/9311845181_674bd74060_s.jpg'
		),
		3=>array(
			'ImageName'=>'Satellite Image 3',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm8.staticflickr.com/7358/9316551916_3c6dd77f7c_s.jpg'
		),
		4=>array(
			'ImageName'=>'Satellite Image 4',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm8.staticflickr.com/7358/9316551916_3c6dd77f7c_s.jpg'
		),
		5=>array(
			'ImageName'=>'Satellite Image 5',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		6=>array(
			'ImageName'=>'Satellite Image 6',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		7=>array(
			'ImageName'=>'Satellite Image 7',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		8=>array(
			'ImageName'=>'Satellite Image 8',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		9=>array(
			'ImageName'=>'Satellite Image 9',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
		10=>array(
			'ImageName'=>'Satellite Image 10',
			'ArquiredDate'=>'1-4-2012',
			'BandName'=>'Band 1',
			'LinkPreview'=>'http://farm4.staticflickr.com/3767/9314211996_a561a65b05_s.jpg'
		),
	);
	
	echo json_encode($datas);
	/*
$uploaddir = realpath('./uploaded') . '/';
$uploadfile = $uploaddir.basename($_FILES['file_contents']['name']);
/*echo '<pre>';
	if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
	    echo "File is valid, and was successfully uploaded.\n";
	} else {
	    echo "Possible file upload attack!\n";
	}
	echo 'Here is some more debugging info:';
	print_r($_FILES);
	echo "\n<hr />\n";
	print_r($_POST);
print "</pr" . "e>\n";*/
//echo  '<iframe src="http://docs.google.com/viewer?url='.'php://input'.'&embedded=true" width="600" height="780" style="border: none;"></iframe>'."</br>";
?>