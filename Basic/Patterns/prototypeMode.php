<?php
/**********************************************
 ** @Description:php设计模式之 原型模式代码示例
 ** @Author: cxm
 ** @Date:   2017-03-14 13:44:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 13:44:00
 **********************************************/

#悟空
class Wukong {
	public $attribute = 0;
}

#毫毛
class Hair {
	public $obj;
	public function __construct($obj) {
		$this->obj = $obj;
	}
	#去掉这个方法是浅复制
	public function __clone() {
		$this->obj = clone $this->obj;
	}
}
#创建一个悟空:石头蹦出来__
$mainWuKong = new Wukong();
#毫毛变孙悟空的对象a
$wukong_a = new Hair($mainWuKong);
#clone一个能干仗的孙悟空实例b
$wukong_b = clone $wukong_a;
var_dump(sql_object_hash($wukong_a->obj) === sql_object_hash($wukong_b->obj)); 