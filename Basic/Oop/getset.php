<?php
class Example {
	public $c = 0;
	public $array = array();
	public function __set($k, $v) {
		echo "使用__set()方法设置属性".$k."的值为:".$v."<br>";
		$this->array[$k] = $v;
	}
	public function __get($k) {
		echo $k."的值为".$this->array[$k];
	}
}
$object = new Example();
$object->b = 1; #成员变量b不存在,所以会调用__set()
$object->c = 2; #成员办理c是存在的,所以不调用__set(),无任何输出
$object->b; #成员变量b不存在,所以会调用__get();