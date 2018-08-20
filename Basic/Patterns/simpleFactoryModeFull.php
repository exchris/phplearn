<?php
/**********************************************
 ** @Description:工厂设计模式之工厂方法设计模式
 ** @Author: cxm
 ** @Date:   2017-03-14 14:33:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 14:33:00
 **********************************************/

#冰淇淋的配方和工艺要求
interface IceCream {
	public function makeIceCream(); #生产
}

#苹果味冰淇淋生产车间
class AppleIceCream implements IceCream {
	public function makeIceCream() {
		return "Apple IceCream";
	}
}

#牛奶味的冰淇淋生产车间
class MilkIceCream implements IceCream {
	public function makeIceCream() {
		return "Milk IceCream";
	}
}

#工厂类
class Factory {
	public static function getIceCream($iceCreamName) {
		if (!class_exists($iceCreamName)) throw new Exception("Error", 1);
		$iceCream = new $iceCreamName();
		if ($iceCream instanceof IceCream) {
			return $iceCream;
		}
	}
}

#调用
try {
	$iceCream = Factory::getIceCream("MilkIceCream");
	var_dump($iceCream->makeIceCream());
} catch (Exception $e) {
	var_dump($e);
}