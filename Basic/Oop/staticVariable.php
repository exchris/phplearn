<?php
class MyClass {
	static $staticVariable = 0; #定义静态属性$staticVariable
}
MyClass::$staticVariable++;
echo "\$staticVariable的值为: ".MyClass::$staticVariable;