<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 上午 10:23
 */

// 连接本地的Redis服务
$redis = new Redis();
// 判断是否连接Redis server 成功
try {
    $redis->connect('127.0.0.1', 6379);
    echo "Connection to server sucessfully<br/>";
    // 存储数据到列表中
    $values = ["Redis", "Mongodb", "Mysql"];
    // 删除tutorial-list列表
    $redis->del("tutorial-list");
    foreach ($values as $v) {
        $redis->lpush("tutorial-list", $v);
    }
    // 获取存储的数据并输出
    $arList = $redis->lRange("tutorial-list", 0, -1);
    echo "Stored string in redis<br/>";
    foreach ($arList as $value) {
        echo $value."<br/>";
    }
} catch (RedisException $e) {
    echo "Could not connect redis server";
    echo $e->getCode();
}