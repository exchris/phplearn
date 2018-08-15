<?php

header("content-type:text/html;charset=utf-8");

try {

	# 实例化redis
	$redis = new \Redis();

	# 连接
	$redis->connect('127.0.0.1', '6379');

	// 列表
	$redis->delete('list1');
	// 存储数据到列表中
	$redis->lPush('list1', 'html');
	$redis->lPush('list1', 'css');
	$redis->lPush('list1', 'php');

	// 获取列表中所有的值
	$lists = $redis->lRange('list1', 0, -1);
	print_r($lists);
	echo "<hr/>";

	// 从右侧加入一个
	$redis->rPush('list1', 'mysql');
	$lists = $redis->lRange('list1', 0, -1);
	print_r($lists);
	echo "<hr/>";

	// 从左侧弹出一个
	$lPopElement = $redis->lPop('list1');
	$lists = $redis->lRange('list1', 0, -1);
	echo "左侧弹出的元素为:" . $lPopElement."<br/>";
	// 打印出剩余的元素
	print_r($lists); echo "<hr/>";

	// 从右侧弹出一个元素
	$rPopElement = $redis->rPop('list1');
	$lists = $redis->lRange('list1', 0, -1);
	echo "右侧弹出的元素为:".$rPopElement."<br/>";
	print_r($lists);

} catch (RedisException $e) {
	echo "错误代码为:".$e->getCode().",错误信息为:".$e->getMessage();
}