<?php
class MyClass {
	const SUNYANG = "运动秀";
	function showResult() {
		echo "SUNYANG的值为:".self::SUNYANG;
	}
}
$object = new MyClass();
$object->showResult();