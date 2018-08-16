<?php
#定义一个抽象类
abstract class Study {
	#定义一个抽象方法
	abstract function printStudy($name, $language);
}

#定义OneStudy类继承于Study类
class OneStudy extends Study {
	#抽象方法的具体实现
	function printStudy($name, $language) {
		echo $name."正在学习".$language."......<br>";
	}
}

#定义TwoStudy类继承于Study类
class TwoStudy extends Study {
	#抽象方法的具体实现
	function printStudy($name, $language) {
		echo $name."正在学习".$language."......<br>";
	}
}
$first = new OneStudy();#创建对象$first
$first->printStudy("Paul", "Perl");
$second = new TwoStudy(); #创建对象$second
$second->printStudy("Bob", "Java");
