<?php

function formatSec($sec){
  $second = $sec % 60;
  $minute = $sec / 60;
  $hour = $minute / 60;
  $minute = $minute % 60;
  $res = sprintf("%d:%02d:%02d", $hour, $minute, $second);
  return $res;
}

header('content-type:image/png');


$image = imagecreatefrompng('images/bg.png');
$currnt = imagecreatefrompng('images/day.png');
//imagesavealpha($image, true);
imagecolorallocate($image, 0, 0, 0);
 
$white = imagecolorallocate($image, 255, 255, 255);
$gray = imagecolorallocate($image, 146, 146, 146);

$steps = @$_REQUEST['steps'];
$calorie = @$_REQUEST['calorie'];
$time = @$_REQUEST['time'];
//$time=formatSec(60 * 5 + 31);
$distance = @$_REQUEST['distance'];

$steps = rand(1000,10000);
$calorie = rand(1,1000);
$time = rand(1,900);
//$time=formatSec(60 * 5 + 31);
$distance = rand(1,1000);

$font = "方正兰亭大黑_GBK.ttf";
$week = date("w");
$pos = array(0, 110, 229, 338, 447, 554,667);
imagecopy($image, $currnt, $pos[$week], 170, 0, 0, 83, 120);
$fontsize = 35;
$day = date("d");
$size = imagettfbbox($fontsize, 0, $font, $day);
$left = $pos[$week] + (83 - $size[2]) / 2;
imagettftext($image, $fontsize, 0, $left, 261, $white, $font, $day);

$fontsize = 111;
$size = imagettfbbox($fontsize, 0, $font, $time);
$left = 185 + (368 - $size[2]) / 2;
imagettftext($image, $fontsize, 0, $left, 601, $white, $font, $time);

$font = "方正兰亭黑_GBK.ttf";
$fontsize = 31;
$size = imagettfbbox($fontsize, 0, $font, $steps);
$left = 587 + (126 - $size[2]);
imagettftext($image, $fontsize, 0, $left, 1130, $gray, $font, $steps);

$size = imagettfbbox($fontsize, 0, $font, $calorie);
$left = 587 + (126 - $size[2]);
imagettftext($image, $fontsize, 0, $left, 1028, $gray, $font, $calorie);

$size = imagettfbbox($fontsize, 0, $font, $distance);
$left = 587 + (126 - $size[2]);
imagettftext($image, $fontsize, 0, $left, 920, $gray, $font, $distance);


imagepng($image);
 
imagedestroy($image);
?>