<?php
class Image
{
    public $error = '';

    /**
     * 得到图片信息
     * @param string $filename 文件名
     * @return array 图片信息
     */
    public function getImageInfo($filename) {
        $imgInfo = getimagesize($filename);
        if (false === $imgInfo) {
            return false;
        }
        $info = array(
            'width' => $imgInfo[0],
            'height' => $imgInfo[1],
            'ext' => strtolower(image_type_to_extension($imgInfo[2], false)),
            'createFun' => str_replace('/','createfrom', $imgInfo['mime']),
            'outFun' => str_replace('/',null,$imgInfo['mime'])
        );
        return $info;
    }

    /**
     * 缩略图 等比例缩放
     * @param string $filename 文件名
     * @param string $thumbPath 保存路径
     */
    public function thumb($filename, $thumbPath = 'thumb', $prefix = 'thumb_', $maxWidth = 200,
        $maxHeight = 200, $delSource = false) {
        $imgInfo = $this->getImageInfo($filename);    // 图片信息
        if (false === $imgInfo) {
            $this->error = $filename.'文件不是真实图片';
            return false;
        }
        // 得到原始图像的宽度和高度
        $srcWidth = $imgInfo['width'];
        $srcHeight = $imgInfo['height'];
        // 得到缩放比例
        $ratio_orig = $srcWidth / $srcHeight;
        if ($maxWidth / $maxHeight > $ratio_orig) {
            $maxWidth = $maxHeight * $ratio_orig;
        } else {
            $maxHeight = $maxWidth / $ratio_orig;
        }
        $createFun = $imgInfo['createFun'];
        if (!function_exists($createFun)) {
            $this->error = $createFun.'函数不支持,请先开启相关扩展';
            return false;
        }
        $src_image = $createFun($filename);
        // 创建缩略图
        if (function_exists('imagecreatetruecolor')) {
            $dst_image = imagecreatetruecolor($maxWidth, $maxHeight);
        } else {
            $dst_image = imagecreate($maxWidth, $maxHeight);
        }
        if (function_exists('imagecopyresampled')) {
            imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $maxWidth, $maxHeight,
                $srcWidth,$srcHeight);
        } else {
            imagecopyresized($dst_image, $src_image, 0, 0, 0, 0, $maxWidth, $maxHeight,
                $srcWidth, $srcHeight);
        }
        $outFun = $imgInfo['outFun'];
        $this->make_dir($thumbPath);
        $basename = basename($filename);
        $rand = mt_rand(100000,999999);
        $destName = "{$prefix}_{$rand}_{$basename}";
        $dest = $thumbPath.'/'.$destName;
        if (file_exists($dest)) {
            $this->error = '目标目录存在同名文件,请重新命名进行操作';
            return false;
        }
        $outFun($dst_image, $dest);
        imagedestroy($dst_image);
        imagedestroy($src_image);
        if ($delSource) {
            unlink($filename);
        }
        return $dest;
    }

    /**
     * @param $filename             源文件名称或路径
     * @param $fontFile             字体文件路径
     * @param string $text          内容
     * @param int $pos              起始位置
     * @param array $color          颜色
     * @param string $waterPath     水印路径
     * @param string $prefix        文件路径前缀
     * @param int $fontSize         字体大小
     * @param int $fontAngle        角度
     * @param int $alpha            透明度
     * @param bool $delSource       是否删除源文件
     */
    public function water_text($filename, $fontFile, $text = 'king', $pos = 6, $color =
        array(255, 0, 0), $waterPath = 'waterText', $prefix = 'waterText', $fontSize = 24,
        $fontAngle = 0, $alpha = 50, $delSource = false) {
        if (!file_exists($filename)) {
            $this->error = $filename . '文件不存在';
            return false;
        }
        $imgInfo = $this->getImageInfo($filename);
        $image = $imgInfo['createFun']($filename);
        $rect = imagettfbbox($fontSize, $fontAngle, $fontFile, $text);
        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $width = $maxX - $minX;
        $height = $maxY - $minY;
        // 计算书写坐标位置
        list($x, $y) = $this->get_water_pos($pos, $imgInfo['width'], $imgInfo['height'],
            $width, $height);
        $y = $y == 0 ? $y = $fontSize * 2 : $y;
        $color = imagecolorallocatealpha($image, $color[0], $color[1], $color[2], $alpha);
        imagettftext($image, $fontSize, $fontAngle, $x, $y, $color, $fontFile, $text);
        $this->make_dir($waterPath);
        $basename = basename($filename);
        $rand = mt_rand(100000, 999999);
        $destName = "{$prefix}_{$rand}_{$basename}";
        $dest = $waterPath . '/' . $destName;
        if (file_exists($dest)) {
            $this->error = '目标目录存在同名文件,请重新命名后进行操作';
            return false;
        }
        $imgInfo['outFun']($image, $dest);
        imagedestroy($image);
        if ($delSource) {
            unlink($filename);
        }
        return $dest;
    }

    /**
     * 图片水印
     * @param $filename     文件名
     * @param $waterPic     水印文件
     * @param int $pos      默认位置
     * @param int $pct      合并度
     * @param string $waterPicPath  默认保存位置
     * @param bool $delSource       是否删除源文件
     * @param string $prefix        前缀
     * @return string                 最终保存位置
     */
    public function water_pic($filename, $waterPic, $pos = 0, $pct = 50,
        $waterPicPath = 'waterPic', $delSource = false, $prefix = 'waterPic') {
        if (!file_exists($filename) || !file_exists($waterPic)) {
            $this->error = '源文件或水印图片不存在';
            return false;
        }
        $fileInfo = $this->getImageInfo($filename);
        $waterInfo = $this->getImageInfo($waterPic);
        $file = $fileInfo['createFun']($filename);
        $water = $waterInfo['createFun']($waterPic);
        list($x, $y) = $this->get_water_pos($pos, $fileInfo['width'], $fileInfo['height'],
            $waterInfo['width'], $waterInfo['height']);
        imagecopymerge($file, $water, $x, $y, 0, 0, $waterInfo['width'], $waterInfo['height'], $pct);
        $this->make_dir($waterPicPath);
        $basename = basename($filename);
        $rand = mt_rand(100000, 999999);
        $destName = "{$prefix}_{$rand}_{$basename}";
        $dest = $waterPicPath.'/'.$destName;
        if (file_exists($dest)) {
            $this->error = '目标目录存在同名文件,请重新命名后进行操作';
            return false;
        }
        $fileInfo['outFun']($file, $dest);
        imagedestroy($file);
        imagedestroy($water);
        if ($delSource) {
            unlink($filename); unlink($waterPic);
        }
        return $dest;
    }

    /**
     * 创建目录
     * @param string $path 目录名称
     */
    private function make_dir($path) {
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }
    }

    /**
     * 得到水印图片位置
     * @param integer $pos          默认水印位置
     * @param integer $srcWidth     原图片宽度
     * @param integer $srcHeight    原图片高度
     * @param integer $waterWidth   水印图片宽度
     * @param integer $waterHeight  水印图片高度
     * @return array    返回水印图片在目标图片的位置
     */
    private function get_water_pos($pos, $srcWidth, $srcHeight, $waterWidth, $waterHeight)
    {
        switch ($pos) {
            case 0:
                $x = $y = 0;
                break;
            case 1:
                $x = ($waterWidth - $srcWidth)/2;
                $y = 0;
                break;
            case 2:
                $x = $waterWidth - $srcWidth;
                $y = 0; break;
            case 3:
                $x = 0;
                $y = ($waterHeight - $srcHeight)/2;
                break;
            case 4:
                $x = ($waterWidth - $srcWidth)/2;
                $y = ($waterHeight - $srcHeight)/2;
                break;
            case 5:
                $x = $waterWidth - $srcWidth;
                $y = ($waterHeight - $srcHeight)/2;
                break;
            case 6:
                $x = 0;
                $y = $waterHeight - $srcHeight;
                break;
            case 7:
                $x = ($waterWidth - $srcWidth)/2;
                $y = $waterHeight - $srcHeight; break;
            case 8:
                $x = $waterWidth - $srcWidth;
                $y = $waterHeight - $srcHeight;
                break;
            default:
                $x = $y = 0; break;
        }
        return array($x, $y);
    }

    public function getError() {
        return $this->error;
    }
}
header('content-type:text/html;charset=utf-8');
$img = new Image();
$res = $img->thumb('../images/iphone.png', 'testThumb');
if (false === $res) {
    echo $img->getError();
}
$res = $img->water_text('../images/jd.jpg', '../fonts/KAITI.TTF');
$res = $img->water_pic('../images/jd.jpg', '../images/iphone.png', 0);
if (false === $res) {
    echo $img->getError();
}
echo $res;
echo '<hr/>';