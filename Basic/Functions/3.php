<?php
//使用array()结构创建数组
$letters = array(0=>"a",1=>"b",2=>"c");
//将数组内部指针倒回到第一个单元
reset($letters); 
while (list($key,$value) = each($letters)) {
	//使用list(),each()和reset()结合来遍历数组
	print "$key----$value<br>";
}

array_pop($letters); //删除数组中最后一个元素
array_push($letters, array(3=>"d")); //入栈操作
var_dump($letters);