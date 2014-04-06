<?php
	include("listDistrict.php");
	$getData = (int)$_POST["data"];

	echo json_encode(getResultDistrict($getData));
?>