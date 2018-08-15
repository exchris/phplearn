<?php
header("Content-Type:text/html;charset=utf8");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 上午 10:34
 */
// 连接本地的Redis服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server sucessfully<br/>";
// 获取数据并输出
$arList = $redis->keys("*");
echo "Stored keys in redis::<br/>";
print_r($arList);