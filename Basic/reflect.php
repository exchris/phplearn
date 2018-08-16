<?php

class Person {
	function say() {
		return "wo shi xiaoqiang";
	}
	function run($speed,$addr) {
		return "wo shi xiaoqiang,wo zai".
				$addr."跑步,目前速度是:".$speed;
	}
}

// $obj = new Person;
// $obj->say();
// $obj->run('10', '海淀');

//利用反射实现对象调用方法
$tom = new Person;
$med = new ReflectionMethod($tom, 'say'); //反射方法
//对象调用方法
echo $med->invoke($tom).'<br/>';

$xiaoming = new Person;
$med2 = new ReflectionMethod($xiaoming, 'run');
echo $med2->invokeArgs($xiaoming, array('20', 'xishan'));

