<?php

$redis = new \Redis();

// 连接Redis Server
$redis->connect('127.0.0.1', 6379);

// set操作
 $redis->delete("set1");

$redis->sAdd("set1", "A");
$redis->sAdd("set1", "B");
$redis->sAdd("set1", "C");
$redis->sAdd("set1", "C");

$val = $redis->sCard("set1");
var_dump($val); // 3

$val = $redis->sMembers("set1");
var_dump($val);

//array(3) { [0]=> string(1) "C" [1]=> string(1) "A" [2]=> string(1) "B" }