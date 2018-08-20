<?php
/**********************************************
 ** @Description:php设计模式(9) 注册模式代码示例
 ** @Author: cxm
 ** @Date:   2017-03-14 13:31:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 13:32:00
 **********************************************/
#注册类,相当于理发店
class Register {
	#创建数组存储对象
	protected static $objects;
	#注册示例对象
	public static function set($alias, $objects) {
		self::$objects[$alias] = $objects;
	}
	#获取示例对象
	public static function get($alias) {
		return self::$objects[$alias];
	}
	#移除示例对象
	public static function _unset($alias) {
		unset(self::$objects[$alias]);
	}
}
#理发师类
class Hairdresser {
	public $hairdresser;
	public function __construct($name) {
		$this->hairdresser = $name;
	}
}

#第一次使用时候,创建实例化对象,并将对象放到注册树种
$zhangsan = new Hairdresser('zhangsan');
Register::set('hd001', $zhangsan);
$lisi = new Hairdresser('lisi');
Register::set('hdoo2', $lisi);

#再次使用时,直接去注册树上取出就行了
$hairdresser = Register::get('hd001');
var_dump($hairdresser->hairdresser);
#运行结果:string(8) "zhangsan"