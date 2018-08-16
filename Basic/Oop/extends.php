<?php
#定义一个父类People
class People {
	#定义构造方法
	function __construct($name, $age) {
		$this->name = $name;
		$this->age  = $age;
	}	
	
	#定义成员方法say()
	function say() {
		echo "姓名: ".$this->name." ";
		echo "年龄: ".$this->age. " ";
		echo "<br>";
	}
	
	#定义析构方法
	function __destruct() {}
}

#定义一个子类Student
class Student extends People {
	#定义成员方法study()
	function study($language) {
		echo $this->name."正在学习 ".$language."......";
	}
}

$student = new Student("运动秀", 5);#创建子类对象$student
$student->say();#调用父类的成员方法
$student->study("PHP"); #调用子类的成员方法