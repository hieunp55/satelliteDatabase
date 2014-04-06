<?php
	session_start(); 
	
	// set the expiration date to one hour ago
	setcookie("test", "", time()-3600);
	$username = urlencode('nguoiduathu92');
	$password = "bdacd603";

	setcookie("test", $username);

	//setcookie("test", $username);
	//$test=$_COOKIE["test"];
	
	//$cookieToken=$_COOKIE["PHPSESSID"];
	$cookieToken=$_COOKIE["test"];
	//$url = 'http://localhost/catAnhVeTinh/getXML.php';
	$url = 'http://127.0.0.1:8000/replies/';
	$data = $_POST['data'];
	$post= $data;
	// Get the curl session object
	$session = curl_init($url);
	//$CsrfTest = new CsrfToken();
	// set url to post to 
	curl_setopt($session, CURLOPT_URL,$url);
	// Tell curl to use HTTP POST;
	curl_setopt ($session, CURLOPT_POST, true);	
	// Tell curl not to return headers, but do return the response
	//curl_setopt($session, CURLOPT_HEADER, true);
	curl_setopt($session, CURLOPT_HTTPHEADER, Array(
		'X-CSRFToken: '.substr($cookieToken, 0, 32),
		'Accept-Encoding: gzip,deflate,sdch',
		'Accept-Language: en-US,en;q=0.8,vi;q=0.6',
		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
	));
	curl_setopt ($session, CURLOPT_COOKIE, 'csrftoken=' .substr($cookieToken, 0, 32));
	curl_setopt ($session, CURLOPT_COOKIEJAR, substr($cookieToken, 0, 32));
	curl_setopt ($session, CURLOPT_COOKIEFILE, substr($cookieToken, 0, 32));
	// Tell curl that this is the body of the POST
	curl_setopt ($session, CURLOPT_POSTFIELDS, json_encode($post));
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	// allow redirects 
	//curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($session, CURLOPT_CONNECTTIMEOUT,12000);
	$response = curl_exec($session);
	//print_r ($response);
	//echo substr($cookieToken, 0, 32);
	#echo "<h1>Processing...</h1><br />";
	echo $response;

	session_destroy();
	curl_close($session);
?>