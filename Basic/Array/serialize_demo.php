<?php
/**
 * 数组序列化
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 9:13
 * @author exchris
 */
$arr = [
    'table' => 'member',
    'field' => 1,
    'rule' => -0,
    'cycle' =>24,
    'max' => 1
];

// 用serialize函数序列号然后打印输出序列化的结果
$serialize = serialize($arr);
echo $serialize;

/**
 * a:5:{s:5:"table";s:6:"member";s:5:"field";i:1;s:4:"rule";i:0;s:5:"cycle";i:24;s:3:"max";i:1;}
 *
 * a:后代表是个数
 * s:后代表是字符串长度
 * i:数字长度
 */

$unserialize = unserialize($serialize);

echo "<pre style='color:red'>";
print_r($unserialize);
echo "</pre>";