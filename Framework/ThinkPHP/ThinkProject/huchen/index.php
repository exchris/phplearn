<?php

header("Content-Type:text/html;charset=utf-8");

//自定义测试方法
function show_bug($msg) 
{
	echo "<pre style='color:red'>";
		var_dump($msg);
	echo "</pre>";
}

//把目前tp模式由生成模式变为开发模式
define('APP_DEBUG', true);


// 引入ThinkPHP入口文件
require "./ThinkPHP/ThinkPHP.php";

// 亲^_^ 后面不需要任何代码了 就是如此简单