<?php

class MyClass {
	static $staticVariable = 0; #定义静态属性$staticVariable

	function addOne() {
		self::$staticVariable++; #调用同一类中的静态属性$staticVariable
		echo "\$staticVariable的值为: ".self::$staticVariable;
	}
}
$object = new MyClass();
$object->addOne(); 