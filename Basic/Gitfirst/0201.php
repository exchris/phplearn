<?php
//将数组内元素内容相同的合并成一个
$arr1 = array(
	array('id'=>1,'name'=>'哈哈'),
	array('id'=>2,'name'=>'哈哈'),
	array('id'=>3,'name'=>'呵呵'),
);

$output_arr = array();
$help_arr = array();

foreach ($arr1 as $item) {
	if (!in_array($item['name'], $help_arr)) {
		$output_arr[] = $item;
		$help_arr[] = $item['name'];
	}
}
print_r($output_arr);
?>