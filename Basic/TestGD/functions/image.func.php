<?php
/**
 * 指定缩放比例
 * 最大宽度和高度,等比例缩放
 * 可以对缩略图文件添加前缀
 * 选择是否删除缩略图的源文件
 */

/**
 * 返回图片信息
 * @param $filename [文件名]
 * @return array 包含图片的宽度、高度,创建和输出的字符串以及扩展名
 */
function getImageInfo($filename)
{
    if (@!$info = getimagesize($filename)) {
        exit('文件不是真实图片');
    }
    $fileInfo['width'] = $info[0];
    $fileInfo['height'] = $info[1];
    $mime = image_type_to_mime_type($info[2]);
    $createFun = str_replace('/', 'createfrom', $mime);
    $outFun = str_replace('/', '', $mime);
    $fileInfo['createFun'] = $createFun;
    $fileInfo['outFun'] = $outFun;
    $fileInfo['ext'] = strtolower(image_type_to_extension($info[2]));
    return $fileInfo;
}

/**
 * 形成缩略图的函数
 * @param $filename 文件名
 * @param string $dest 缩略图保存路径
 * @param string $pre  默认前缀为thumb_
 * @param null $dst_w  最大宽度
 * @param null $dst_h  最大高度
 * @param float $scale 默认缩放比例
 * @param bool $delSource 是否删除源文件标志
 * @return string 最终保存路径及文件名
 */
function thumb($filename,$dest = 'thumb', $pre = 'thumb_', $dst_w = null,$dst_h = null,$scale = 0.5,$delSource = false)
{
    $fileInfo = getImageInfo($filename);
    $dst_w = 200;
    $dst_h = 300;
    $src_w = $fileInfo['width'];
    $src_h = $fileInfo['height'];
// 如果指定最大宽度和高度,按照等比例缩放比例
    if (is_numeric($dst_w) && is_numeric($dst_h)) {
        $ratio_orig = $src_w / $src_h;
        if ($dst_w / $dst_h > $ratio_orig) {
            $dst_w = $dst_h * $ratio_orig;
        } else {
            // 没指定按照默认的缩放比例处理
            $dst_h = $dst_w / $ratio_orig;
        }
    } else {
        $dst_w = ceil($src_w * $scale);
        $dst_h = ceil($src_h * $scale);
    }
    $dst_image = imagecreatetruecolor($dst_w, $dst_h);
    $src_image = $fileInfo['createFun']($filename);
    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
    // 检测目标目录是否存在,不存在则创建
    if ($dest && !file_exists($dest)) {
        mkdir($dest, 0777, true);
    }
    $randNum = mt_rand(100000,999999);
    // 以thumb_为前缀,随机6位数字的文件名
    $dstName = "{$pre}_{$randNum}".$fileInfo['ext'];
    // echo $dstName;
    $destination = $dest ? $dest .'/'.$dstName : $dstName;
    $destination = $fileInfo['outFun']($dst_image, $destination);
    imagedestroy($dst_image);
    imagedestroy($src_image);
    if ($delSource) {
        unlink($filename);
    }
    return $destination;
}

/**
 * 图像添加水印效果
 * @param $filename 文件名
 * @param $fontfile 字体路径
 * @param string $text 水印内容
 * @param string $dest 路径
 * @param string $pre 路径前缀
 * @param int $r  红色
 * @param int $g  绿色
 * @param int $b 蓝色
 * @param int $alpha 透明度
 * @param int $size 字体大小
 * @param int $angle 角度
 * @param int $x  开始位置宽度
 * @param int $y  开始位置高度
 * @param boolean $delSource 是否删除源文件
 * @return string
 */
function waterText($filename,$fontfile,$text = '水印效果',$dest = 'waterText',$pre='watetText_',$r=255,$g=0,$b=0,$alpha=60,
    $size = 30, $angle = 0, $x = 0, $y = 30,$delSource = false)
{
    $fileInfo = getImageInfo($filename);
    $image = $fileInfo['createFun']($filename);
    $color = imagecolorallocatealpha($image,$r,$g,$b,$alpha);
    imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
    if ($dest && !file_exists($dest)) {
        mkdir($dest, 0777, true);
    }
    $random = mt_rand(100000,999999);
    $dstName = "{$pre}_{$random}".$fileInfo['ext'];
    $destination = $dest ? $dest.'/'.$dstName : $dstName;
    $fileInfo['outFun']($image, $destination);
    if ($delSource) {
        @unlink($filename);
    }
    imagedestroy($image);
    return $destination;
}

/**
 * 给图片添加图片水印
 * @param $dstName       目标文件
 * @param $srcName       源文件
 * @param int $pos       起始位置
 * @param string $dest  文件路径
 * @param string $pre  文件前缀
 * @param bool $delSource 是否删除文件
 */
function water_pic($dstName, $srcName, $pos = 0,$pct = 50, $dest = 'waterPic', $pre = 'waterPic_',$delSource = false )
{
    $dstInfo = getImageInfo($dstName);
    $srcInfo = getImageInfo($srcName);
    $dst_im = $dstInfo['createFun']($dstName);
    $src_im = $srcInfo['createFun']($srcName);
    $src_width = $srcInfo['width'];
    $src_height = $srcInfo['height'];
    $dst_width = $dstInfo['width'];
    $dst_height = $dstInfo['height'];
    switch ($pos) {
        case 0:
            $x = $y = 0;
            break;
        case 1:
            $x = ($dst_width - $src_width)/2;
            $y = 0;
            break;
        case 2:
            $x = $dst_width - $src_width;
            $y = 0; break;
        case 3:
            $x = 0;
            $y = ($dst_height - $src_height)/2;
            break;
        case 4:
            $x = ($dst_width - $src_width)/2;
            $y = ($dst_height - $src_height)/2;
            break;
        case 5:
            $x = $dst_width - $src_width;
            $y = ($dst_height - $src_height)/2;
            break;
        case 6:
            $x = 0;
            $y = $dst_height - $src_height;
            break;
        case 7:
            $x = ($dst_width - $src_width)/2;
            $y = $dst_height - $src_height; break;
        case 8:
            $x = $dst_width - $src_width;
            $y = $dst_height - $src_height;
            break;
        default:
            $x = $y = 0; break;
    }
    // 拷贝并合并图像的一部分
    imagecopymerge($dst_im,$src_im,$x,$y,0,0,$src_width,$src_height,$pct);
    if ($dest && !file_exists($dest)) {
        mkdir($dest, 0777, true);
    }
    $randNum = mt_rand(100000,999999);
    $dstName = "{$pre}_{$randNum}".$dstInfo['ext'];
    $destination = $dest ? $dest.'/'.$dstName : $dstName;
    $dstInfo['outFun']($dst_im, $destination);
    imagedestroy($src_im);
    imagedestroy($dst_im);
    if ($delSource) {
        @unlink($src_im);
    }
    return $destination;
}

