<?php

$redis = new \Redis();

$redis->connect('127.0.0.1', 6379);

$arr = $redis->keys("*");

foreach ($arr as $key => $value) {
    $redis->delete($value);
}