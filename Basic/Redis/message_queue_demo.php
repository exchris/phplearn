<?php

/**
 *
 * 将请求存入redis
 *
 * 为了模拟多个用户的请求，使用一个for循环替代
 *
 * //redis数据入队操作
 */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
for ($i = 0; $i < 50; $i++) {
    try {
        $redis->lPush('click', rand(1000, 5000));
    } catch (Exception $e) {
        echo $e->getMessage().PHP_EOL;
    }
}