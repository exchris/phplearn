<?php
/**********************************************
 ** @Description:工厂设计模式之工厂方法设计模式
 ** @Author: cxm
 ** @Date:   2017-03-14 14:18:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 14:18:00
 **********************************************/

#工厂接口类
interface IceCreamFactory {
	public function getFactory($iceCreamType); #获取
}

#A工厂类-具体工厂
class FactoryA implements IceCreamFactory {
	public function getFactory($iceCreamType) {
		return new $iceCreamType('FactoryA');
	}
}
#B工厂类-具体工厂
class FactoryB implements IceCreamFactory {
	public function getFactory($iceCreamType) {
		return new $iceCreamType('FactoryB');
	}
}

#冰淇淋接口类
interface IceCream {
	public function getTaste(); #获取味道
	public function getFactoryName(); #获取工厂名称
}
#冰淇淋抽象类-抽象产品
abstract class abstractIceCream implements IceCream {
	public $iceCreamType;
	public $factoryType;
	
	public function getTaste() {
		return $this->iceCreamType;
	}
	public function getFactoryName() {
		return $this->factoryType;
	}
}

#冰淇淋产品-具体产品
class AppleIceCream extends abstractIceCream {
	public $iceCreamType = 'apple';
	public $factoryType;
	
	public function __construct($factoryType) {
		$this->factoryType = $factoryType;
	}
}
#冰淇淋-具体产品
class MilkIceCream extends abstractIceCream {
	public $iceCreamType = 'milk';
	public $factoryType;
	
	public function __construct($factoryType) {
		$this->factoryType = $factoryType;
	}
}

#应用
$factory = new FactoryA();
$iceCream = $factory->getFactory('MilkIceCream');
var_dump($iceCream->getTaste()); #获取味道
var_dump($iceCream->factoryType); #获取生产地