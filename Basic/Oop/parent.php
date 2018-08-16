<?php
/**
 * 关键字parent::用来表示父类和要调用的父类中的成员方法
 */
#定义父类People
class People {
	#定义构造方法
	public function __construct($name) {
		$this->name = $name;
	}
	
	function __destruct() {}
}

#定义一个子类Student
class Student extends People {
	#定义构造方法
	function __construct($name, $age) {
		parent::__construct($name); //使用parent::调用了父类的构造函数
		$this->age = $age;
	}
	
	#定义成员方法say()
	function say() {
		echo "姓名 ".$this->name." ";
		echo "年龄 ".$this->age." ";
		echo "<br>";
	}
	
	#定义成员方法study() 
	function study($language) {
		echo $this->name."正在学习 ".$language.".....";
	}
	
	#定义析构方法
	function __destruct() {}
}

$student = new Student("运动秀",2); #创建子类对象$student
$student->say();
$student->study("PHP");