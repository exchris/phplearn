<?php
class MyClass {
	#定义静态方法showResult()
	static function showResult($number) {
		echo "\$number= ". $number;
		echo "<br>";
		self::addOne($number);#调用同一类中的静态方法addOne()
	}
	#定义静态方法addOne() 
	static function addOne($number) {
		echo "\$number+1=";
		echo $number+1;
	}
}
$number = 100;
MyClass::showResult($number);