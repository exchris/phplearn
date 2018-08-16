<?php
#定义父类Number
class Number {}

#定义子类One
class One extends Number {
	private $name;
	function setName($name) {
		$this->name = $name;
	}
	
	function getName() {
		return $this->name;
	}
}

#定义子类Two
class Two extends Number {
	private $name;
	function setName($name) {
		$this->name = $name;
	}
	function getName() {
		return $this->name;
	}
}

class IsClass {
	#检验对象是否属于某个类
	static function check($obj) {
		if ($obj instanceof One) {
			echo "属于One类";
			
		} elseif ($obj instanceof Two) {
			echo "属于Two类";
		} else {
			echo "不属于任何类";
		}
		
	}
}

$one = new One();
$one->setName("one");
echo $one->getName();
IsClass::check($one);
echo "<br>";

$two = new Two();
$two->setName("two");
echo $two->getName();
IsClass::check($two);