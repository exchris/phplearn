<?php

//连接本地的Redis服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server successfully".PHP_EOL;

//存储数据到列表中
$redis->lPush("tutorial-list", "Redis");
$redis->lPush("tutorial-list", "Mongodb");
$redis->lPush("tutorial-list", "Mysql");

//获取存储的数据并输出
$arList = $redis->lRange("tutorial-list", 0, 5);
echo "Stored string in redis".PHP_EOL;
print_r($arList);