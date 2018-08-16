<?php

namespace beijing;
function getName() {
	return "beijing";
}

namespace shanghai;
function getName() {
	return "shanghai";
}
class Person {
	static $name = "shanghairen";
}

namespace nanjing;
function getName() {
	return "nanjing";
}

use shanghai\Person;
//Person在本身默认空间没有找到就会去引入的空间里寻找
echo Person::$name;

//第二种使用
use shanghai;
echo shanghai\Person::$name;
