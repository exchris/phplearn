<?php
//使用系统内置函数
$queue = array("A","B");
//在数组之前插入对象(元素)
array_unshift($queue, "C",array("C","D"));
# print_r($queue);
# Array ( [0] => C [1] => Array ( [0] => C [1] => D ) [2] => A [3] => B )

$shuaige = array("a"=>"wuyanzhu", "b"=>"huangxiaoming", "c"=>"ninzetao");

function test_print($item2, $key)
{
	echo $key."---".strtoupper($item2)."<br/>\n";
}

echo "<pre style='color:#ccc'>";
var_dump($shuaige);
echo "</pre>";

array_walk($shuaige, 'test_print');

echo "用自定义函数test_print执行后的结果:";
echo "<pre style='color:#ccc'>";
var_dump($shuaige);
echo "</pre>";