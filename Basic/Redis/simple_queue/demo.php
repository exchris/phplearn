<?php
/**
 * 插入数据到redis队列
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 3:47
 */

$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

$password = '123456';

$redis->auth($password);

$arr = array('h','e','l','l','o','w','o','r','l','d');

if ($redis->exists("mylist")) {
    $redis->delete("mylist");
}

foreach ($arr as $k => $v) {
    $redis->rPush("mylist", $v);
}