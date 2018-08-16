<?php
//创建验证码类,实现验证码的创建及验证功能
/**
 * 验证码工具类
 */
class captcha {
	
	/**
	 * 判断验证码是否输入正确
	 * @param $code 用户输入的验证码
	 * @return bool 验证结果 
	 */
	public function checkCode($code) {
		@session_start();
		//判断验证码是否存在
		if (isset($_SESSION['captcha_code'])) {
			//判断验证码
			$rst = ($code == $_SESSION['captcha_code']);
			//清除验证码,防止被重用
			unset($_SESSION['captcha_code']);
			//返回结果
			return $rst;
		}
		return false;
	}
	
	/**
	 * 生成验证码图片
	 * @param $char_len = 4 码值长度
	 */
	public function generate($char_len = 4, $font = 5) {
		//生成码值
		$char = array_merge(range('A', 'Z'), range(1, 9)); //不需要0，与O冲突
		$rand_keys = array_rand($char, $char_len);
		shuffle($rand_keys);
		$code = '';
		foreach ($rand_keys as $key) {
			$code .= $char[$key];
		}
		//保存session中
		@session_start();
		$_SESSION['captcha_code'] = strtolower($code);
		//写入到图片中并展示
		//1 生成画布
		$captcha_img = imagecreatetruecolor(100, 30);
		//2 操作画布
		//设定字符串颜色
		$str_color = imagecolorallocate($captcha_img, 0xff, 0xff, 0xff); //白
		//设定字符串颜色
		$img_w = imagesx($captcha_img);//画布的宽
		$img_h = imagesy($captcha_img);//画布的高
		$font_w = imagefontwidth($font); //字体宽
		$font_h = imagefontheight($font);//字体高
		$str_w = $font_w * $char_len; //字符串宽
		imagestring($captcha_img, $font, ($img_w - $str_w)/2, ($img_h-$font-h)/2, 
			$code, $str_color);
		//3 输出图片内容
		header('Content-Type:image/jpeg');
		imagejpeg($captcha_img);
		//4 销毁画布
		imagedestroy($captcha_img);
		
		
	}
}