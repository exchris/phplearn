<?php
header('content-type:text/html;charset=utf-8');
$redis = new \Redis();

// 连接Redis Server
$redis->connect('127.0.0.1', 6379);

// hash操作
$redis->delete('driver');

$redis->hSet('driver', 'name', '张三');
$redis->hSet('driver','age', 21);
$redis->hSet('driver', 'gender', '男');
$val = $redis->hGet('driver', 'name');
echo $val.'<br/>'; // 张三
$val = $redis->hMGet('driver', array('name','age','gender'));
var_dump($val);
echo '<hr/>';
// array(3) { ["name"]=> string(6) "张三" ["age"]=> string(2) "21" ["gender"]=> string(3) "男" }

$val = $redis->hGetAll('driver');
var_dump($val);

// array(3) { ["name"]=> string(6) "张三" ["age"]=> string(2) "21" ["gender"]=> string(3) "男" }