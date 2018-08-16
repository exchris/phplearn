<?php
//验证码类加入到框架基础类的基础类列表中
class framework {
	public function user_autoload($class_name) {
		//定义基础类列表
		$base_classes = array(
			//类名 => 所在位置
			'model' => './model.class.php',
			'MySQLPDO' => './MySQLPDO.class.php',
			'page' => './page.class.php',
			'captcha' => './captcha.class.php', //新增此行代码
		);
	}
}