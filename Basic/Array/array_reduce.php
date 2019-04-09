<?php

/**
 * array_reduce($arr ,callable $callback) 使用回调函数迭代地将数组简化为单一的值
 *$arr 输入数组
 *
 * $callback($result, $value) 接收两个参数,
 * $result 为上一次迭代产生的值
 * $value 是当前迭代的值
 *
 */

/**
 *
 * array_reduce()替代foreach()循环最常用的一个业务场景就是数组求和
 *
 */
$arr = array('1', '2', '3'); // 计算数组中数字的和
$sum = 0;
foreach ($arr as $v){ // 使用foreach循环计算
    $sum += $v; // echo $sum
}

// 使用array_reduce()迭代求和
echo array_reduce($arr, function($result, $value){
   return $result += $value;
})."<br/>";

$a = array(
    array("id" => 1, "name" => "a"),
    array("id" => 2, "name" => "b"),
    array("id" => 3, "name" => "c"),
);
echo array_reduce($a, function($r, $v){
   return $r.','.$v['id'];
})."<br/>";

/**
 *
 * array_map(callback $callback, $arr) 返回用户自定义函数作用后的数组。
 * 回调函数接收的参数数目应该和传递给array_map()函数的数组数目一致
 *
 *
 */

$b = array('2','3','4','5');
array_map('intval', $b); // 在拼接sql查询的时候很有用
print_r($b);
array_map('htmlspecialchars', $b);
