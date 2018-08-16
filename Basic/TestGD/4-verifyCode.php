<?php
	$width = 200;
	$height = 40;
	// 创建画布
	$image = imagecreatetruecolor($width, $height);
	// 创建颜色
	$white = imagecolorallocate($image, 255, 255, 255);
	// 随机颜色
	$randColor = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
	// 填充画布颜色
	imagefilledrectangle($image,0,0,$width,$height,$white);
	// 给画布添加内容
	$size = mt_rand(20,28);
	$angle = mt_rand(-15,15);
	$x = 60;
	$y = 20;
	$fontFile = 'fonts/CONSOLA.TTF';
	$text = mt_rand(1000,9999);
	imagettftext($image, $size, $angle, $x, $y, $randColor, $fontFile, $text);
	// 告知浏览器以png图片输出
	header('content-type:image/png');
	imagepng($image);
	imagedestroy($image);