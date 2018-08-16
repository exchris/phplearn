<?php
class People {
	public $name; //定义成员属性$name
	
	function study() {
		//定义成员方法study()
		echo $this->name."正在学习PHP...<br>";
	}
}
$Tom = new People();//创建Tom对象
$Tom->name = "Tom";
$Tom->study();

$Lily = new People(); //创建Lily对象
$Lily->name = "Lily";
$Lily->study();

$Paul = new People();
$Paul->name = "Paul";
$Paul->study();