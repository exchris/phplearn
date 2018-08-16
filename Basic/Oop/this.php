<?php
class People {
	private $name; #定义成员属性$name
	function setName($name) {
		#定义成员方法setName()
		$this->name = $name;
	}
	
	function getName() { 
		#定义成员方法getName()
		echo $this->name."<br>";
	}
}

$user1 = new People();#创建对象$user1
$user1->setName("张三");
$user1->getName();

$user2 = new People(); #创建对象$user2
$user2->setName("李四");
$user2->getName();