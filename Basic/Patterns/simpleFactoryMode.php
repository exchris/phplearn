<?php
/**********************************************
 ** @Description:工厂设计模式之工厂方法设计模式
 ** @Author: cxm
 ** @Date:   2017-03-14 14:29:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 14:29:00
 **********************************************/

class AppleIceCream {
	public function makeIceCream() {
		return "Apple IceCream";
	}
}

class MilkIceCream {
	public function makeIceCream() {
		return "Milk IceCream";
	}
}

class Factory {
	public static function getIceCream($iceCreamName) {
		return new $iceCreamName();
	}
}

#调用者要牛奶冰淇淋
$iceCream = Factory::getIceCream('MilkIceCream');
var_dump($iceCream->makeIceCream());