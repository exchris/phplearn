<?php
/**********************************************
 ** @Description:工厂设计模式之抽象工厂模式
** @Author: cxm
** @Date:   2017-03-14 13:53:00
** @Last Modified by: cxm
** @Last Modified time: 2017-03-14 13:53:00
**********************************************/

#工厂接口类
interface IceCreamFactory {
	public function getIceCreamFactory($iceCreamType); #获取冰淇淋
	public function getCanFactory($canType); #获取罐头
}

#A工厂类-具体工厂
class FactoryA implements IceCreamFactory {
	public function getIceCreamFactory($iceCreamType) {
		return new $iceCreamType('FactoryA');
	}

	public function getCanFactory($canType) {
		return new $canType('FactoryA');
	}
}
#B工厂类-具体工厂
class FactoryB implements IceCreamFactory {
	public function getIceCreamFactory($iceCreamType) {
		return new $iceCreamType('FactoryB');
	}
	public function getCanFactory($canType) {
		return new $canType('FactoryB');
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

#冰淇淋产品-具体产品
class MilkIceCream extends abstractIceCream {
	public $iceCreamType = 'milk';
	public $factoryType;

	public function __construct($factoryType) {
		$this->factoryType = $factoryType;
	}
}

#罐头接口类
interface Can {
	public function getTaste(); #获取味道
	public function getFactoryName(); #获取工厂名称
}
#罐头抽象类-抽象产品
abstract class abstractCan implements Can {
	public $canType;
	public $factoryType;

	public function getTaste() {
		return $this->canType;
	}

	public function getFactoryName() {
		return $this->factoryType;
	}
}

#梨罐头-具体产品
class PearCan extends abstractCan {

	public $canType = 'pear';
	public $factoryType;

	public function __construct($factoryType) {
		$this->factoryType = $factoryType;
	}
}
#桃子产品-具体产品
class PeachCan extends abstractCan {
	public $canType = 'peach';
	public $factoryType;

	public function __construct($factoryType) {
		$this->factoryType = $factoryType;
	}
}

#应用
$factory = new FactoryA();
#冰淇淋
$iceCream = $factory->getIceCreamFactory('MilkIceCream');
var_dump($iceCream->getTaste());  #获取味道
var_dump($iceCream->factoryType); #获取生产地
#罐头
$can = $factory->getCanFactory('PearCan');
var_dump($can->getTaste());#获取味道
var_dump($can->factoryType);#获取生产地
