<?php
//Month day year
$jd = GregorianToJD(5, 19, 2013);
//$jd = GregorianToJD(9, 22, 2013);
echo "$jd\n";
$gregorian = JDToGregorian($jd);
echo "$gregorian\n";
//2013-09-22
$str = "2014-05-12";
$arrays = explode("-", $str);
$arrays[1] += 10;
print_r($arrays);

?>