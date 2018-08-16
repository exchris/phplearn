<?php
#定义一个父类People
class People {
	//定义构造函数
	function __construct($name, $age) {
		$this->name = $name;
		$this->age  = $age;
		echo "调用父类的构造方法<br>";
	}
	
	#定义成员方法say()
	function say() {
		echo "姓名: ".$this->name." ";
		echo "年龄: ".$this->age." ";
		echo "<br>";
	}
	
	#定义析构方法
	function __destruct() {}
}

#定义一个子类Student
class Student extends People {
	function __construct($name, $age) {
		$this->name = $name;
		$this->age  = $age;
		echo "调用子类的构造方法";
		echo "<br>";
	}
	
	#定义成员方法study
	function study($language) {
		echo $this->name."正在学习".$language."......";
	}
	
	#定义析构方法
	function __destruct() {}
}
$student = new Student("运动秀",5); #创建子类对象student
$student->say();
$student->study("PHP");
