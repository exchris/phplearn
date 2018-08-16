<?php
$filename = 'images/iphone.png';
if ($fileInfo = getimagesize($filename)) {
    list($src_w,$src_h) = $fileInfo;
} else {
    exit('文件不是真实图片');
}
// 等比例缩放
// 设置最大宽和高
$dst_w = 300;
$dst_h = 600;

$ratio_orig = $src_w/$src_h;

if ($dst_w/$dst_h > $ratio_orig) {
    $dst_w = $dst_h * $ratio_orig;
} else {
    $dst_h = $dst_w / $ratio_orig;
}

// 重新取样
$dst_image = imagecreatetruecolor($dst_w, $dst_h);
$src_image = imagecreatefrompng($filename);
imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

// 输出等比例缩放的图片
header('content-type:image/png');
imagepng($dst_image, 'thumbs/thumbs_300x300.jpeg');
imagedestroy($dst_image);
imagedestroy($src_image);
