<?php
#定义接口Tools
interface Tools {
	function goHome();
}
class Walk implements Tools {
	function goHome() {
		echo "步行回家";
	}
}
class Bicycle implements Tools {
	function goHome() {
		echo "骑自行车回家";
	}
}

function printRightSelect($object) {
	if ($object instanceof Tools) {
		$object->goHome();
	} else {
		echo "出现错误!";
	}
	echo "<br>";
}
echo "第一种选择为:";
$object1 = new Walk();
printRightSelect($object1);
echo "第二种选择为:";
$object2 = new Bicycle();
printRightSelect($object2);