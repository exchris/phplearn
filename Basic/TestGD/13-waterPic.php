<?php
$logo = 'images/jd.jpg';
$filename = 'images/iphone.png';
$dst_im = imagecreatefrompng($filename); // 目标文件
$src_im = imagecreatefromjpeg($logo);

imagecopymerge ($dst_im, $src_im, 0, 0, 0, 0, 1024, 810, 30);
header('content-type:image/png');
imagepng($dst_im);
imagedestroy($dst_im);
imagedestroy($src_im);