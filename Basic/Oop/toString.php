<?php
class Example {
	#__toString()方法允许一个类决定当它被修改为string类型时是如何起作用的。
	#__toString()方法直接打印对象句柄,从而获得该方法的基本信息或其他内容
	public function __toString() {
		return "张三";
	}
}
$object = new Example();
echo $object;