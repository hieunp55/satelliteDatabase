<?php
	include("listCWT.php");
	$getData = (int)$_POST["data"];

	echo json_encode(getResultCWT($getData));
?>