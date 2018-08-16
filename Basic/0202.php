<?php
$arr1 = array(
		array('id'=>1,'name'=>'哈哈'),
		array('id'=>1,'name'=>'哈哈'),
		array('id'=>3,'name'=>'呵呵'),
);

print_r (array_unique_fb($arr1));
//将二维数组中相同的元素过滤并且不改变键值
function array_unique_fb($array) {
	foreach ($array as $k => $v) {
		$keyvalue = array_keys($v);
		$key = array_keys($v);
		$v = implode('$', $v); //降维,也可以用implode,将一维数组转换为逗号连接的字符串
		$temp[] = $v;
	}
	$temp = array_unique($temp); //去掉重复的字符串,也就是重复的一位数组
	foreach ($temp as $k => $v) {
		$temp[$k] = explode('$', $v); //再将拆开的数组重新组装
	}
	foreach ($temp as $key => $value) {
		$newArray[] = array_combine($keyvalue, $value);
	}
	return $newArray;
}