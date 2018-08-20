<?php
/**********************************************
 ** @Description:单例模式示例代码
 ** @Author: cxm
 ** @Date:   2017-03-14 14:57:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 14:57:00
 **********************************************/

class DbBase {
	
	//创建一个非公有变量用于保存示例
	static protected $db;
	
	//构造方法必须是私有方法,防止外部new的方法实例化
	private function __construct() {
		self::$db = false;
	}
	
	//创建一个创建示例的方法,供外部使用
	static public function getInstance() {
		//判断是否被实例化
		if (!self::$db) {
			self::$db = new self();
		}
		return self::$db;
	}
}

#调用
$dbCon = DbBase::getInstance();
var_dump($dbCon);