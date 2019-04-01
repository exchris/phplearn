<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379); //serverip port
$redis->auth('');//my redis password
echo "Connection to server successfully".PHP_EOL;

// 查看服务是否运行
echo "Server is running:".$redis->ping();

$redis->set("test", "Hello World");
echo $redis->get("test").PHP_EOL;

echo $redis->expire("test", 60);