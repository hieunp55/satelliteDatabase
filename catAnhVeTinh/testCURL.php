<?php
session_start(); 
	/*
	//paste your XML file here
	 
	$xml = '
	 
		<?xml version="1.0" encoding="UTF-8"?>
		<Parent>
			<Child>
				<Name>Roshini</Name>
				<Age>5</Age>
			</Child>
		</Parent>';
	 
	// give the path of the Third party site
	$url = "http://localhost/catAnhVeTinh/getXML.php";
	 
	$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_MUTE, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	echo $output;
	 
	curl_close($ch);
	*/
	//set URL
//$url = 'http://localhost/catAnhVeTinh/getXML.php';
$url = 'http://127.0.0.1:8000/replies/';
//set xml request
$xml = '
<SearchQuery xmlns="http://schemas.datacontract.org/2004/07/S3.Common.Search" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
    <Mode>And</Mode>
    <Elements>
        <SearchElement i:type="SearchParameter">
            <Name>IndicatorDescriptionID</Name>
            <Operator>Equal</Operator>
            <Value>15</Value>
        </SearchElement>
        <SearchElement i:type="SearchParameter">
            <Name>LocaleID</Name>
            <Operator>Equal</Operator>
            <Value>39</Value>
        </SearchElement>
    </Elements>
    <Page>1</Page>
</SearchQuery>
';
//This needs to be the full path to the file you want to send.
	//$file_name = realpath('./CV.Sample.HRTECH.demo.pdf');output.txt
	$file_name = realpath('./output.txt');
        /* curl will accept an array here too.
         * Many examples I found showed a url-encoded string instead.
         * Take note that the 'key' in the array will be the key that shows up in the
         * $_FILES array of the accept script. and the at sign '@' is required before the
         * file name.
         */
	$post = array('test'=>array('extra_info' => '123456','file_contents'=>'@'.$file_name));

// Get the curl session object
$session = curl_init($url);
//$CsrfTest = new CsrfToken();
// set url to post to 
//curl_setopt($session, CURLOPT_URL,$url);
// Tell curl to use HTTP POST;
curl_setopt ($session, CURLOPT_POST, true);
//curl_setopt($session, CURLOPT_COOKIEJAR, $CsrfToken);
  //  curl_setopt($session, CURLOPT_COOKIEFILE, $CsrfToken);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, json_encode($post));
// Tell curl not to return headers, but do return the response
//curl_setopt($session, CURLOPT_HEADER, true);
curl_setopt($session, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=utf-8"));
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
// allow redirects 
//curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($session);
//print_r ($response);
echo json_encode($post) . "</br>";
echo "<h1>Health Data</h1><br />";
echo $response."</br>";
echo "<hr />";

curl_close($session);
#session_close();
 
?>