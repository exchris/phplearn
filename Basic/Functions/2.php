<?php
define("TIME_AREA", "PRC");
date_default_timezone_set(TIME_AREA);
echo "date()函数的应用为:".date("Y年n月j日H:i:s a")."<br>";
echo "gmdate()函数的应用为:".gmdate("Y年n月j日H:i:s a",mktime(0,0,0,3,15,2017))."<br>";

$today = getdate();
print_r($today);