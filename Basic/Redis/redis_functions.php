<?php

define("HOST", "127.0.0.1");
define("PORT", 6379);
define("REDIS_PREFIX", "redis_");

/**
 * 如果不传入$host和$port默认读取Laravel环境变量的参数
 * redis Set/setex封装,可直接传入数组,可设置过期时间 written:yangxingyi
 */
function RedisSet($key, $value, $expire = 0, $host = '', $port = '')
{
    if (!$key || !$value) return false;
    $redis = new Redis();
    $redis->connect(HOST, PORT);
    $value = is_array($value) ? json_encode($value) : $value;
    return $expire > 0 ? $redis->setex(getenv('REDIS_PREFIX') . $key, $expire, $value) : $redis->set(getenv('REDIS_PREFIX') . $key, $value);
}

/**
 * redis get封装,如果传入的是数组,返回的也是数组,同理字符串 written:yangxingyi
 */
function RedisGet($key)
{
    $redis = new Redis();
    $redis->connect(HOST, PORT);
    $result = $redis->get(getenv('REDIS_PREFIX') . $key);
    return is_null(json_decode($result)) ? $result : json_decode($result, true);
}


print(RedisSet("test", "hello world", 30));
