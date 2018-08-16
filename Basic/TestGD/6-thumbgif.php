<?php

// 文件地址
$filename = 'images/human.gif';
// 缩率比例
$percent = 0.5;
// 获取文件信息
$fileInfo = getimagesize($filename);
list($src_width,$src_height) = $fileInfo;
$dst_width = $src_width * $percent;
$dst_height = $src_height * $percent;

// 创建缩率图的画布
$dst_image = imagecreatetruecolor($dst_width, $dst_height);
// 源文件图片
$src_image = imagecreatefromgif($filename);
// 缩略图实现
imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_width,$dst_height,$src_width,$src_height);

// 输出
header('content-type:image/gif');
imagegif($dst_image, 'thumbs/human_thumb.gif'); // 保存到thumbs目录下
// 销毁资源
imagedestroy($dst_image);
imagedestroy($src_image);