<?php
$filename = 'images/iphone.png';
// getimagesize() 得到图片信息
$fileInfo = getimagesize($filename);
list($src_w, $src_h) = $fileInfo;

// imagecopyresampled();
// 创建100 X 100
$dst_w = 100;
$dst_h = 100;
// 创建目标画布资源
$dst_image = imagecreatetruecolor($dst_w,$dst_h);
// 通过图片文件创建画布资源 imagecreatefromjpeg()|imagecreatefrompng()|imagecreatefromgif()
$src_image = imagecreatefrompng($filename);
// var_dump($src_image);exit;
$dst_x = $dst_y = $src_x = $src_y = 0;
imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

// 输出
header('content-type:image/png');
imagepng($dst_image, 'thumbs/iphone_100x100.png');
// 销毁资源
imagedestroy($dst_image);
imagedestroy($src_image);

/**
 * png
 * gif
 * jpeg
 * getimagesize()
 * imagecopyresampled()
 * imagecreatefromjpeg()
 * imagecreatefrompng()
 * imagecreatefromgif()
 */