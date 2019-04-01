<?php

//连接本地的Redis服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server successfully".PHP_EOL;

//获取数据并输出
$arList = $redis->keys("*");
echo "Stored keys in redis::".PHP_EOL;
print_r($arList);