<?php

$redis = new \Redis();

// 连接Redis Server
$redis->connect('127.0.0.1', 6379);

// sortset操作
$redis->delete("zset1");

$redis->zAdd('zset1', 100, "exchris"); // rank : 2
$redis->zAdd('zset1', 90, 'hong');  // rank : 0
$redis->zAdd('zset1', 93, 'wang');  // rank : 1

$val = $redis->zRange("zset1", 0, -1);
var_dump($val);
// array(3) { [0]=> string(4) "hong" [1]=> string(4) "wang" [2]=> string(7) "exchris" }

$val = $redis->zRevRange("zset1", 0, -1); // 从高到低
var_dump($val);
// array(3) { [0]=> string(7) "exchris" [1]=> string(4) "wang" [2]=> string(4) "hong" }