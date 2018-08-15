<?php 

# 引入先导文件
require_once '../include/db.php';
require_once '../include/redis.php';

$db = DB::getInstance();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
} catch (RedisException $e) {
    echo $e->getMessage();
}
//echo $redis->ping();
//$arr = $redis->info();


$sql = "SELECT uid, username FROM `user` LIMIT 1000";

$result = $db->getAll($sql);

foreach ($result as $key => $value) {
    if (!$redis->get($key)) {
        echo $redis->set($key, $value['username']);
        echo "<br/>";
    }
    $redis->delete($key);
    echo $redis->get($key)."<br/>";
}



