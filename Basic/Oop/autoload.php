<?php
function __autoload($class_name) {
	include $class_name.".php";
}
$p = new Example();
$p->printSunYang();
// $d = new Demo();