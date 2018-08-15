<?php

require '../predis/autoload.php';

$redis = new Predis\Client(array(
    'host'  => '127.0.0.1',
    'port' => 6379
));

try {
    if (is_null($redis->get('foo')))
        throw new Exception("ERR Operation against a key holding the wrong kind of value");
    echo $redis->get('foo');
} catch (Exception $e) {
    echo "Message:{$e->getMessage()}";
}

echo "<hr/>";

$userName = [
    'user:1:name' => 'Tom',
    'user:2:name' => 'Jack'
];
// 相当于 $redis->mset('user:1:name','Tom','user:2:name','Jack');
$redis->mset($userName);

$users = array_keys($userName);
print_r($redis->mget($users));

echo "<hr/>";

// HMSET/HMGET/HGETALL
$user1 = [
    'name' => 'Tom',
    'age' => 32
];
$redis->hmset('user:1', $user1);
$user = $redis->hgetall('user:1');
echo $user['name']; // Tom

// 3.LPUSH/SADD/ZADD
$items = array('a', 'b');
// 相当于 $redis->lpush('list', 'a', 'b');
$redis->lpush('list1', $items);


// 相当于$redis->sadd('set','a','b')
$redis->sadd('set', $items);

//
$itemScore = array(
    'Tom' => '100',
    'Jack' => '89'
);
// 相当于$redis->zadd('zset', '100', 'Tom','89','Jack')
$redis->zadd('zset', $itemScore);

// SORT
$redis->sort('mylist', array(
    'by' => 'weight_*',
    'limit' => array(0,10),
    'get' => array('value_*', '#'),
    'sort' => 'asc',
    'alpha' => true,
    'store' => 'result'
));