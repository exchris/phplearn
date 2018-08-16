<?php 
header('content-type:text/html;charset=utf-8');
 $width = 200;
 $height = 40;
// 创建画布
 $image = imagecreatetruecolor($width, $height);
// 创建画布颜色
 $white = imagecolorallocate($image, 255, 255, 255);
// 填充颜色
 imagefilledrectangle($image, 0, 0, $width, $height, $white);
// 创建画布随机颜色
function getRandColor($image) {
    return imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
}
// 快速创建字符串 $string = 'asdfghjkxcvbnm12345'
$string = join('',array_merge(range(0, 9),range('a','z'),range('A','Z')));
//echo $string;
// 得到字体宽度和高度
$textWidth = imagefontwidth(28);
$textHeight = imagefontheight(28);

 $length = 4;
 for ($i = 0; $i < $length; $i++) {
     $randColor = getRandColor($image);
 	$size = mt_rand(20,28);
 	$angle = mt_rand(-15,15);
// 	$x = 20 + 40 * $i;
// 	$y = 30;
    $x = ($width/$length)*$i+$textWidth;
     $y = mt_rand($height/2,$height-$textHeight);
 	$fontFile = 'fonts/CONSOLA.TTF';
 	$text = str_shuffle($string)[0];
 	imagettftext($image, $size, $angle, $x, $y, $randColor, $fontFile, $text);
 }
// 添加干扰元素
// 添加像素当作干扰元素
for ($i = 1; $i <= 50; $i++) {
    imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),getRandColor($image));
}
// 绘制线段当作干扰元素
for ($i = 1; $i <= 3; $i++) {
    imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),
        getRandColor($image));
}
// 绘制圆弧
for ($i = 1; $i <= 3; $i++) {
    imagearc($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width/2),
        mt_rand(0,$height/2),mt_rand(0,360),mt_rand(0,360),getRandColor($image));
}

 // 告诉浏览器以png图片显示
 header('content-type:image/png');
 // 输出到浏览器
 imagepng($image);
// 销毁资源
imagedestroy($image);

/**
 * imagesetpixel() : 添加像素当作干扰元素
 * imageline(): 绘制线段当作干扰元素
 * imagearc() : 绘制圆弧当作干扰元素
 * imagefontwidth();
 * imagefontheight();
 */