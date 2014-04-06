<?php
//namespace Csrf;
	session_start(); //if you are copying this code, this line makes it work.
/*function store_in_session($key,$value)
{
	if (isset($_SESSION))
	{
		$_SESSION[$key]=$value;
	}
}
function unset_session($key)
{
	$_SESSION[$key]=' ';
	unset($_SESSION[$key]);
}
function get_from_session($key)
{
	if (isset($_SESSION))
	{
		return $_SESSION[$key];
	}
	else {  return false; } //no session data, no CSRF risk
}
function csrfguard_generate_token($unique_form_name)
{
	if (function_exists("hash_algos") and in_array("sha512",hash_algos()))
	{
		$token=hash("sha512",mt_rand(0,mt_getrandmax()));
	}
	else
	{
		$token=' ';
		for ($i=0;$i<128;++$i)
		{
			$r=mt_rand(0,35);
			if ($r<26)
			{
				$c=chr(ord('a')+$r);
			}
			else
			{ 
				$c=chr(ord('0')+$r-26);
			} 
			$token.=$c;
		}
	}
	store_in_session($unique_form_name,$token);
	return $token;
}
function csrfguard_validate_token($unique_form_name,$token_value)
{
	$token=get_from_session($unique_form_name);
	if ($token===false)
	{
		return true;
	}
	elseif ($token===$token_value)
	{
		$result=true;
	}
	else
	{ 
		$result=false;
	} 
	unset_session($unique_form_name);
	return $result;
}
function csrfguard_replace_forms($form_data_html)
{
	$count=preg_match_all("/<form(.*?)>(.*?)<\\/form>/is",$form_data_html,$matches,PREG_SET_ORDER);
	if (is_array($matches))
	{
		foreach ($matches as $m)
		{
			if (strpos($m[1],"nocsrf")!==false) { continue; }
			$name="CSRFGuard_".mt_rand(0,mt_getrandmax());
			$token=csrfguard_generate_token($name);
			$form_data_html=str_replace($m[0],
				"<form{$m[1]}>
<input type='hidden' name='CSRFName' value='{$name}' />
<input type='hidden' name='CSRFToken' value='{$token}' />{$m[2]}</form>",$form_data_html);
		}
	}
	return $form_data_html;
}
function csrfguard_inject()
{
	$data=ob_get_clean();
	$data=csrfguard_replace_forms($data);
	echo $data;
}
function csrfguard_start()
{
	if (count($_POST))
	{
		if ( !isset($_POST['CSRFName']) or !isset($_POST['CSRFToken']) )
		{
			trigger_error('No CSRFName found, probable invalid request.',E_USER_ERROR);		
		} 
		$name =$_POST['CSRFName'];
		$token=$_POST['CSRFToken'];
		if (!csrfguard_validate_token($name, $token))
		{ 
			trigger_error("Invalid CSRF token.",E_USER_ERROR);
		}
	}
	ob_start();
	register_shutdown_function(csrfguard_inject);	
}
csrfguard_start();
*/
/**
 * CsrfToken.php
 *
 * This fine contains the CsrfToken class that handles genration and checking 
 * of Synchronization tokens (http://bit.ly/owasp_synctoken).
 *
 * The basic usage involves initializing an instance at some point, calling 
 * either the getHiddenField() or generateToken() methods. The former produces 
 * an XHTML-compliant input element, whereas the latter produces a raw 
 * Base64-encoded string. In another request, the request can be tested for 
 * authenticity (to the best of this script's author's knowledge) by calling 
 * the checkToken() method.
 *
 * The generateHiddenField() and generateToken() create a $_SESSION['csrf'] 
 * array, which contains the material for token creation. This data is 
 * preserved so that the token can be checked later.
 *
 * DISCLAIMER: This script has not been widely tested (actually, it's been only 
 * tested on a local host), so I do not recommend using it without sufficient 
 * testing. That said, I do think it will work as expected.
 *
 * TODO: Write unit tests.
 *
 * @author Branko Vukelic <studio@brankovukelic.com>
 * @version 0.1.2
 * @package Csrf 
 */

//use Exception;


/**
 * Token generation and checking class
 *
 * This class encapsulates all of the functionality of the Csrf package. On
 * initialization, it checks for session ID, and it will throw an exception is
 * one is not found, so it is best you initialize right after session_start().
 *
 * Since the time used to generate the token is not the time when
 * initialization takes place, you can initialize at any time before token
 * generation.
 *
 * @package Csrf
 * @subpackage classes
 */
class CsrfToken {

    /**
     *  Flag to determine whether GET HTTP verb is checked for a token
     *
     *  Otherwise, only POST will be checked (default).
     *
     *  @access protected
     *  @var boolean
     */
    protected $acceptGet = FALSE;

    /**
     *  Default timeout for token check
     *
     *  If the request is made outside of this time frame, it will be
     *  considered invalid. This parameter can be manually overriden at check
     *  time by supplying the appropriate arugment to the {@link checkToken()}
     *  method.
     *
     *  @access protected
     *  @var integer
     */
    protected $timeout = 300;

    /**
     *  Class constructor
     *
     *  While initializing this class, it is possible to specify the {@link
     *  $timeout} parameter. The timeout is 300 seconds (5 minutes) by default.
     *  The {@link acceptGet} argument can be set to TRUE if you wish to
     *  include GET requests in the check. Otherwise, all GET requests will be
     *  considered invalid (default).
     */
    public function __construct($timeout=300, $acceptGet=FALSE){
        $this->timeout = $timeout;
        if (session_id()) {
            $this->acceptGet = (bool) $acceptGet;
        } else {
            throw new Exception('Could not find session id', 1);
        }
    }

    /**
     *  Random string gnerator
     *
     *  Utility function for random string generation of the $len length.
     *
     *  @param integer $len (defaults to 10) length of the generated string
     *  @return string
     */
    public function randomString($len = 10) {
        // Characters that may look like other characters in different fonts
        // have been omitted.
        $rString = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        $charsTotal  = strlen($chars);
        for ($i = 0; $i < $len; $i++) {
            $rInt = (integer) mt_rand(0, $charsTotal);
            $rString .= substr($chars, $rInt, 1);
        }
        return $rString;
    }

    /**
     *  Calculates the SHA1 hash from the csrf token material
     *
     *  The token material is found in $_SESSION['csrf'] array. This function
     *  is not used directly. It is called by other public CsrfToken method.
     *
     *  @see generateToken(), generateHiddenField(), checkToken()
     *  @visibility protected
     *  @return string
     */
    protected function calculateHash() {
        return sha1(implode('', $_SESSION['csrf']));
    }

    /**
     *  Generates the token string encoded using Base64 algorythm
     *
     *  When this method is called, it also resets any data in the
     *  $_SESSION['csrf'] array, so it can be called multiple times. It is not
     *  wise to call this method just before performing a chek for an earlier
     *  request, as it will overwrite any token material it finds.
     *
     *  @see generateHiddenField()
     *  @visibility public
     *  @return string
     */
    public function generateToken() {
        // Create or overwrite the csrf entry in the seesion
        $_SESSION['csrf'] = array();
        $_SESSION['csrf']['time'] = time();
        $_SESSION['csrf']['salt'] = $this->randomString(32);
        $_SESSION['csrf']['sessid'] = session_id();
        $_SESSION['csrf']['ip'] = $_SERVER['REMOTE_ADDR'];
        // Generate the SHA1 hash
        $hash = $this->calculateHash();
        // Generate and return the token
        return base64_encode($hash);
    }

    /**
     *  Generates the entire hiddent form element containing the token
     *
     *  Since Sychronize Token CSRF protection is most effective with POST
     *  requests, this convenience method allows you to generate a
     *  prefabricated hidden element that you will insert into your forms. The
     *  markup is XHTML compliant. Since it will not break regular HTML or
     *  HTML5 markup, there are no options for customization. You can use the
     *  {@link generateToken()} method if you want a custom markup, or just
     *  want the raw token string.
     *
     *  @see generateToken()
     *  @visibility public
     *  @return string
     */
    public function generateHiddenField() {
        // Shortcut method to generate the entire form
        // element containing the CSRF protection token
        $token = $this->generateToken();
        return "<input type=\"hidden\" name=\"csrf\" value=\"$token\" />";
    }

    /**
     *  Checks the timeliness of the request
     *
     *  This method is not meant to be called directly, but is called by the
     *  {@link checkToken()} method. It checks the time recorded in the session
     *  against the time of request, and returns TRUE if the request was just
     *  in time, or FALSE if the request broke the time limit.
     *
     *  @see checkToken()
     *  @visibility protected
     *  @param integer $timeout request timeout in seconds
     *  @return boolean
     */
    protected function checkTimeout($timeout=NULL) {
        if (!$timeout) {
            $timeout = $this->timeout;
        }
        return ($_SERVER['REQUEST_TIME'] - $_SESSION['csrf']['time']) < $timeout;
    }

    /**
     *  Checks the token to authenticate the request
     *
     *  The check will fail if the session wasn't started (or the session id
     *  got lost somehow), if the $_SESSION['csrf'] wasn't set (probably the
     *  form page didn't do its part in generating and using the token), if
     *  the request did not contain the 'csrf' parameter, or if the 'csrf'
     *  parameter does not match the generated from the information in the
     *  $_SESSION['csrf']. The check will also fail if the request was made
     *  outside of the time limit specified by the optional $timeout parameter
     *  or took longer than the default 5 minutes. For multi-page scenarios,
     *  or for longer forms (like blog posts and user comments) it is
     *  recommended that you manually extend the time limit to a more
     *  reasonable time frame.
     *
     *  @visibility public
     *  @param integer $timeout
     *  @return boolean
     */
    public function checkToken($timeout=NULL) {
        // Default timeout is 300 seconds (5 minutes)

        // First check if csrf information is present in the session
        if (isset($_SESSION['csrf'])) {

            // Check the timeliness of the request
            if (!$this->checkTimeout($timeout)) {
                return FALSE;
            }

            // Check if there is a session id
            if (session_id()) {
                // Check if response contains a usable csrf token
                $isCsrfGet = isset($_GET['csrf']);
                $isCsrfPost = isset($_POST['csrf']);
                if (($this->acceptGet and $isCsrfGet) or $isCsrfPost) {
                    // Decode the received token hash
                    $tokenHash = base64_decode($_REQUEST['csrf']);
                    // Generate a new hash from the data we have
                    $generatedHash = $this->calculateHash();
                    // Compare and return the result
                    if ($tokenHash and $generatedHash) {
                        return $tokenHash == $generatedHash;
                    }
                }
            }
        }

        // In all other cases return FALSE
        return FALSE;
    }

}

	$json = json_decode($_POST['data'], true);
	
	/* /* create a dom document with encoding utf8 */
    $doc = new DOMDocument('1.0', 'UTF-8');
	$doc->formatOutput = true;
    /* create the root element of the xml tree */
    $root = $doc->createElement("xml");
    /* append it to the document created */
    $root = $doc->appendChild($root);

	$satelliteImage = $doc->createElement('SATELLITE_IMAGE');
	$satelliteImage=$root->appendChild($satelliteImage);
	
	$startDate=$doc->createElement('START_DATE', $json['fromTime']);
	$startDate=$satelliteImage->appendChild($startDate);
	
	$endDate=$doc->createElement('END_DATE', $json['toTime']);
	$endDate=$satelliteImage->appendChild($endDate);
	
	$band=$doc->createElement('BAND');
	$band=$satelliteImage->appendChild($band);
	
	for($i=0; $i<$json['numBands']; $i++){
		$tempt='band'.(string)$i;
		$fnband=$doc->createElement('FILE_NAME_BAND_'.(string)$i, $json[$tempt]);
		$fnband=$band->appendChild($fnband);
	}
	
	$loImCrop=$doc->createElement('LOCATION_IMAGE_CROP');
	$loImCrop=$satelliteImage->appendChild($loImCrop);
	//Upper left
	$latLong=$doc->createElement('CORNER_UL_LAT_PRODUCT', $json['lat0']);
	$latLong=$loImCrop->appendChild($latLong);
	
	$latLong=$doc->createElement('CORNER_UL_LON_PRODUCT', $json['lg0']);
	$latLong=$loImCrop->appendChild($latLong);
	//Upper right
	$latLong=$doc->createElement('CORNER_UR_LAT_PRODUCT', $json['lat1']);
	$latLong=$loImCrop->appendChild($latLong);
	
	$latLong=$doc->createElement('CORNER_UR_LON_PRODUCT', $json['lg1']);
	$latLong=$loImCrop->appendChild($latLong);
	//Lower left
	$latLong=$doc->createElement('CORNER_LL_LAT_PRODUCT', $json['lat2']);
	$latLong=$loImCrop->appendChild($latLong);
	
	$latLong=$doc->createElement('CORNER_LL_LON_PRODUCT', $json['lg2']);
	$latLong=$loImCrop->appendChild($latLong);
	//Lower right
	$latLong=$doc->createElement('CORNER_LR_LAT_PRODUCT', $json['lat3']);
	$latLong=$loImCrop->appendChild($latLong);
	
	$latLong=$doc->createElement('CORNER_LR_LON_PRODUCT', $json['lg3']);
	$latLong=$loImCrop->appendChild($latLong);
	/*
	for($i=0; $i<8; $i=$i+2){
		$tempt='band'.(string)$i;
		$fnband=$doc->createElement('FILE_NAME_BAND_'.(string)$i, $json[$tempt]);
		$fnband=$band->appendChild($fnband);
	}
	*/
  
    //echo $doc->saveXML();
	$doc->save("write.xml");
	
	/*
<SATELLITE_IMAGE_RESPONSE>
<DATE_ACQUIRED>DD/MM/YYYY</DATE_ACQUIRED>
<BAND_NAME/>
<LINK_PREVIEW/>
<LINK_FULL_IMAGE_CROP/>
</SATELLITE_IMAGE_RESPONSE>
*/
	//Response json data:
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
	
	//echo json_encode($datas);
	
	$url = 'http://127.0.0.1:8000/replies/';
	//$url = 'http://localhost/catAnhVeTinh/getXML.php';
	// Get the curl session object
$session = curl_init($url);

// set url to post to 
//curl_setopt($session, CURLOPT_URL,$url);
// Tell curl to use HTTP POST;
curl_setopt ($session, CURLOPT_POST, true);
curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true); 
curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 2); 
//curl_setopt($session, CURLOPT_CAINFO, getcwd() . "/cacert.pem");
//curl_setopt($session, CURLOPT_COOKIEJAR, $CsrfToken);
//curl_setopt($session, CURLOPT_COOKIEFILE, $CsrfToken);
// Tell curl that this is the body of the POST $doc->saveXML()
curl_setopt ($session, CURLOPT_POSTFIELDS, json_encode($datas));
// Tell curl not to return headers, but do return the response
//curl_setopt($session, CURLOPT_HEADER, true);
curl_setopt($session, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=utf-8"));
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($session,CURLOPT_SSL_VERIFYPEER,true); 
//curl_setopt($session,CURLOPT_CAINFO,'ca-bundle.crt'); /* problem here! */
// allow redirects 
//curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($session);
//print_r ($response);

//echo "<h1>Health Data</h1><br />";
echo $response;
//echo "<hr />";

curl_close($session);



function read_header($ch, $string)
{
    global $location;
    global $cookiearr;
    global $ch; 
       # ^overrides the function param $ch
       # this is okay because we need to 
       # update the global $ch with 
       # new cookies
    //echo $string;
    $length = strlen($string);
    if(!strncmp($string, "Location:", 9))
    {
      $location = trim(substr($string, 9, -1));
    }
    if(!strncmp($string, "Set-Cookie:", 11))
    {
      $cookiestr = trim(substr($string, 11, -1));
      $cookie = explode(';', $cookiestr);
      $cookie = explode('=', $cookie[0]);
      $cookiename = trim(array_shift($cookie)); 
      $cookiearr[$cookiename] = trim(implode('=', $cookie));
    }
    $cookie = "";
    if(trim($string) == "") 
    {
      foreach ($cookiearr as $key=>$value)
      {
        $cookie .= "$key=$value; ";
      }
      curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
	//print_r($cookiearr);
	//echo "<br/>";
    return $length;
}

//namespace kafene;

/**
 * kafene\csrf;
 *
 * This is a class for making and validating CSRF tokens
 * I let it run automatically, every "non-safe" request
 * (not HEAD, OPTIONS, GET) MUST have a token, or it is discarded.
 * It's kind of sparsely commented but should be easy enough to figure out.
 * Oh and all the methods are static :-)
 *
 * @todo use hash_hmac
 * @todo multiple tokens
 *
 * @link https://github.com/kafene/csrf
 * @version 20130517
 * @license Public Domain <http://unlicense.org/>
 * @copyright Waived
 */
class csrf {
    static $lastToken;

    static function init() {
        static $init = true;
        if ($init) {
            if (PHP_SESSION_ACTIVE !== session_status()) {
                session_start();
            }
            if (empty($_SESSION['CSRF::Tokens'])) {
                $_SESSION['CSRF::Tokens'] = [];
            } else {
                # Garbage collection
                foreach ($_SESSION['CSRF::Tokens'] as $md5 => $val) {
                    if (time() > $val['expires']) {
                        unset($_SESSION['CSRF::Tokens'][$md5]);
                    }
                }
            }
            $init = false;
        }
    }

    static function getToken($ttl = 300) {
        static::init();
        if ($ttl && !empty(static::$lastToken)) {
            $k = static::$lastToken;
            if (!empty($_SESSION['CSRF::Tokens'][$k])) {
                return $_SESSION['CSRF::Tokens'][$k]['nonce'];
            }
        }
        $nonce = openssl_random_pseudo_bytes(32);
        $expires = $ttl ? (time() + $ttl) : false;
        $ip = getenv('REMOTE_ADDR');
        static::$lastToken = $i = md5($nonce);
        $nonce = static::encode($nonce);
        $_SESSION['CSRF::Tokens'][$i] = compact('nonce', 'expires', 'ip');
        return $nonce;
    }

    static function checkToken(&$token) {
        static::init();
        if (empty($token)) return false;
        $token = static::decode($token);
        $i = md5($token);
        if (empty($_SESSION['CSRF::Tokens'][$i])) return false;
        $valid = $_SESSION['CSRF::Tokens'][$i];
        $_SESSION['CSRF::Tokens'] = [];
        return (0 === strcmp($token, static::decode($valid['nonce'])))
            && ($valid['ip'] === $_SERVER['REMOTE_ADDR'])
            && ($valid['expires'] === false || (time() < $valid['expires']));
    }

    static function requestMethodIsSafe($method = null) {
        $method = $method ?: strtoupper(getenv('REQUEST_METHOD'));
        $safe_methods = ['HEAD', 'GET', 'OPTIONS'];
        return in_array($method, $safe_methods, true);
    }

    # Base64, but URL-ready.
    static function encode($value) {
        return strtr(base64_encode($value), '+/=', '-_~');
    }
    static function decode($value) {
        return base64_decode(strtr($value, '-_~', '+/='));
    }

    static function protect() {
        # We don't need to run protection if the method is 'safe'.
        if (static::requestMethodIsSafe() && empty($_POST)) return;
        $token = static::detectToken();
        if (!$token || !static::checkToken($token)) {
            throw new \UnexpectedValueException('CSRF Token Invalid');
        }
        return true;
    }

    # Wraps 3 ways of detecting the token and returns any that was found.
    static function detectToken() {
        if ($token = getenv('HTTP_X_CSRF_TOKEN')) {
            return $token;
        }
        if ($token = getenv('HTTP_X_REQUEST_TOKEN')) {
            return $token;
        }
        if (!empty($_POST['token'])) {
            return (string) $_POST['token'];
        }
        if (!static::requestMethodIsSafe() && !empty($_REQUEST['token'])) {
            return (string) $_REQUEST['token'];
        }
    }
}


# Example:

CSRF::protect();
ob_get_level() || ob_start();

/*function csrfSafeMethod(method) {
	return false;
    // these HTTP methods do not require CSRF protection
    //return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}*/
$cookieToken= CSRF::getToken();
	while (strlen($cookieToken) <= 42){
		$cookieToken= CSRF::getToken();
	}
	
		#echo "<hr />";
	/*
	curl_setopt($session, CURLOPT_HTTPHEADER, Array(
		'X-CSRFToken: '.CSRF::getToken(),
		'Accept-Encoding: gzip,deflate,sdch',
		'Accept-Language: en-US,en;q=0.8,vi;q=0.6',
		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
	));
	curl_setopt ($session, CURLOPT_COOKIE, 'csrftoken=' . substr(CSRF::getToken(), 0, 32));
	curl_setopt ($session, CURLOPT_COOKIEJAR, substr(CSRF::getToken(), 0, 32));
	curl_setopt ($session, CURLOPT_COOKIEFILE, substr(CSRF::getToken(), 0, 32));
	// Tell curl that this is the body of the POST
	curl_setopt ($session, CURLOPT_POSTFIELDS, json_encode($post));
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	
	*/
	//echo "</br>".$_COOKIE["PHPSESSID"];