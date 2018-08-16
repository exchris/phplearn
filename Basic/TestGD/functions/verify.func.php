<?php
/**
 * 默认产生4位数字的验证码
 *
 * @param string $fontfile  字体文件
 * @param int $type         1:数字 2:字母 3: 数字+字母 4:汉字
 * @param int $length       验证码长度
 * @param string $codeName  存入session的名字
 * @param int $pixel        像素点
 * @param int $line         线段
 * @param int $arc          弧线
 * @param int $width        画布宽度
 * @param int $height       画布高度
 * @return void
 */
function getVerify($fontfile,$type=1,$length=4,$codeName='verifyCode',$pixel=50,$line=0,$arc=0,$width=200,$height=50)
{
    /** 创建画布*/
    // $width = 200;
    // $height = 50;
    $image = imagecreatetruecolor($width, $height);
    // 创建颜色
    $white = imagecolorallocate($image, 255, 255, 255);
    // 创建填充矩形
    imagefilledrectangle($image, 0, 0, $width, $height, $white);
    // 随机颜色
    function getRandColor($image)
    {
        return imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255),
            mt_rand(0, 255));
    }

    /**
     * 默认是4位的数字的验证码
     * 1 - 数字
     * 2- 字母
     * 3 - 数字 + 字母
     * 4 - 汉字
     */
    // $type = 4;
    // $length = 4;
    switch ($type) {
        case 1: // 数字
            // $string = '1234567890'
            $string = join('', array_rand(range(0, 9), $length));
            break;
        case 2: // 字母
            $string = join('', array_rand(array_flip(array_merge(range('a', 'z'), range('A', 'Z'))), $length));
            break;
        case 3: // 字母 + 数字
            $string = join('', array_rand(array_flip(array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'))), $length));
            break;
        case 4: // 汉字
            $str = "声,如,千,骑,疾,气,卷,山,来,天,安,门,广,场,胜,利,大,阅,兵,的,壮,观,景,象,犹,眼,前,就,是" .
                "在,那,次,纪,念,人,民,抗,日,战,争,暨,世,界,反,法,西,斯,战,争,胜,利,周,年,阅,兵,式,上,习,主,席,向" .
                "庄,严,宣,布,中,国,将,裁,减,军,队,员,额,万";
            $arr = explode(',', $str);
            $string = join('', array_rand(array_flip($arr), $length));
            break;
        default:
            exit('非法参数');
            break;
    }
    // 将验证码存入session中
    session_start();
    $_SESSION[$codeName] = $string;
    for ($i = 0; $i < $length; $i++) {
        $size = mt_rand(20, 28);
        $angle = mt_rand(-15, 15);
        $x = 20 + ceil(($width / $length)) * $i;
        $y = mt_rand(ceil($height / 3), $height - 20);
        $color = getRandColor($image);
        // $fontFile = '../fonts/KAITI.TTF';
        // 中文 mb_substr()
        $text = mb_substr($string, $i, 1, 'utf-8');
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
    // $pixel = 50;
    // $line = 3;
    // $arc = 2;
// 添加像素当干扰元素
    if ($pixel > 0) {
        for ($i = 1; $i <= $pixel; $i++) {
            imagesetpixel($image, mt_rand(0, $width), mt_rand(0, $height), getRandColor($image));
        }
    }
    // 添加线段当作干扰元素
    if ($line > 0) {
        for ($i = 1; $i <= $line; $i++) {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height),
                mt_rand(0, $width), mt_rand(0, $height), getRandColor($image));
        }
    }
    // 添加弧线
    if ($arc > 0) {
        for ($i = 1; $i <= $arc; $i++) {
            imagearc($image, mt_rand(0, $width / 2), mt_rand(0, $height / 2), mt_rand(0, $width),
                mt_rand(0, $height), mt_rand(0, 360), mt_rand(0, 360), getRandColor($image));
        }
    }

    header('content-type:image/png');
    imagepng($image);
    imagedestroy($image);
}

/**
 * 完成验证码的封装及调用
 */
