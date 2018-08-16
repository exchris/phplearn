<?php
#创建People类
class People {
	#定义构造方法
	function __construct($name, $sex, $age) {
		$this->name =  $name;
		$this->sex  =  $sex;
		$this->age  =  $age;
	}
	
	#定义成员方法say()
	function say() {
		echo "姓名: ".$this->name." ";
		echo "性别: ".$this->sex." ";
		echo "年龄: ".$this->age." ";
		echo "<br>";
	}
	
	#定义析构方法
	function __destruct() {
		echo "销毁对象 ".$this->name."<br>";	
	} 
}

$p1 = new People("张三", "男", 20);
$p1->say();