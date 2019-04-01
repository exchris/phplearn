<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->delete('s');
$redis->sAdd('s', 5);
$redis->sAdd('s', 4);
$redis->sAdd('s', 2);
$redis->sAdd('s', 1);
$redis->sAdd('s', 3);
$redis->sAdd('s', 6);

var_dump($redis->sort('s'));
var_dump($redis->sort('s', ['sort' => 'desc']));
var_dump($redis->sort('s', ['sort' => 'asc']));
var_dump($redis->sort('s', ['sort' => 'desc', 'store' => 'out']));