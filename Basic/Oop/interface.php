<?php
#定义接口IName
interface IName {
	function setName($name);
	function getName();
}
#定义接口IAge
interface IAge {
	function setAge($age);
	function getAge();
}

#定义一个用于实现上面接口的类
class SunYang implements IName,IAge {
	private $name;
	private $age;

	public function setAge($age) {
		$this->age = $age;
	}

	public function getName() {
		echo "姓名:".$this->name." ";
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getAge() {
		echo "年龄:".$this->age." ";
	}
}

$object = new SunYang(); #创建对象$object
$object->setName("三洋开泰");
$object->getName();
$object->setAge(5);
$object->getAge();
