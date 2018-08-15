<?php
header("content-type:text/html;charset=utf-8");
error_reporting(0);
// 实例化
$redis = new Redis();
// 连接服务器
$conn = $redis->connect("127.0.0.1", 6379);
//var_dump($conn); bool(true)
// 授权
$redis->auth("exchris");