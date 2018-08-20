<?php
#单例模式
class Singleton {
	private static $instance = null; #私有静态属性$instance
	
	#私有构造方法__construct()
	private function __construct() {}
	
	#公有静态方法getInstance()
	public static function getInstance() {
		//确保只有一个示例被创建
		if (self::$instance == null) {
			return new Singleton();
		}
		return self::$instance;
	}
	
	#公有成员方法printString()
	public function printString() {
		echo "运动秀";
	}
}
$class = Singleton::getInstance(); #获取单元素
$class->printString();
