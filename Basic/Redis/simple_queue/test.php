<?php
header('content-type:text/html;charset=utf-8');
/**
 * 定时扫描出队列
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 3:51
 */
$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

$password = '123456';

$redis->auth($password);

//var_dump($redis->lRange("mylist", 0, -1));

$lists = $redis->lRange('mylist', 0, -1);

foreach ($lists as $key => $value) {
    // list类型出队操作
    $v = $redis->lPop('mylist');
    if ($v) {
        echo "出队的值{$value}<br/>";
    } else {
        echo "出队完成";
    }
}
