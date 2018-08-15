<?php

header("content-type:text/html;charset=utf-8");

try {

	# 实例化redis
	$redis = new \Redis();

	# 连接
	$redis->connect('127.0.0.1', '6379');

	# 检测是否连接成功
	echo "Server is running :" . $redis->ping()."<br/>";
	# 输出结果 Server is running: + PONG

	print_r($redis);


} catch (RedisException $e) {
	echo "错误代码为:".$e->getCode().",错误信息为:".$e->getMessage();
}