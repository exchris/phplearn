<?php
$filename  = 'images/iphone.png';
$fileInfo = getimagesize($filename);
$mime = $fileInfo['mime'];
$createFun = str_replace('/','createfrom',$mime);
$outFun = str_replace('/',null,$mime);
$fileInfo['createFun'] = $createFun;
$fileInfo['outFun'] = $outFun;
$image = $fileInfo['createFun']($filename);

// 画笔颜色
// $red = imagecolorallocate($image, 255,0,0);
$red = imagecolorallocatealpha($image,255,0,0,80);
imagettftext($image,30,0,0,$fileInfo[1]-100,$red,'fonts/KAITI.TTF','JD.COM');

// 输出
header('content-type:'.$mime);
imagepng($image);
imagedestroy($image);