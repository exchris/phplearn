<?php
	
	header('content-type:text/html;charset=utf-8');

	# 实例化redis
	$redis = new \Redis();

	# 连接
	$redis->connect('127.0.0.1', 6379);

	# 列表 为了可读性不伦该列表是否存在直接删除
	$redis->delete('list2');

	# 存储数据到列表中
	/*$redis->lpush('list2', 'html');
    $redis->lpush('list2', 'html');
    $redis->lpush('list2', 'html');
    $redis->lpush('list2', 'css');
    $redis->lpush('list2', 'php');
    $redis->lpush('list2', 'mysql');
    $redis->lpush('list2', 'javascript');
    $redis->lpush('list2', 'html');
    $redis->lpush('list2', 'html');
    $redis->lpush('list2', 'html');
    $redis->lpush('list2', 'ajax');*/

	$datas = ['html','html','html','css','php','mysql','javascript','html','html','html','ajax'];
	foreach ($datas as $value) {
		$redis->lPush('list2', $value);
	}

	# 获取列表lists的长度
	echo $redis->lSize('list2')."<br/>";

	# 获取列表中所有的值
	$lists = $redis->lRange('list2', 0, -1);
	var_dump($lists); echo "<br/>";

	# 删除列表中count个值为value的元素
	# 从左向右删
	$redis->lRem('list2', 'html', 2);
	$lists = $redis->lRange('list2', 0, -1);
	var_dump($lists); echo "<br/>";

	# 从右向左删
	$redis->lRem('list2', 'html', -2);
	$lists = $redis->lRange('list2', 0, -1);
	var_dump($lists); echo "<br/>";

	# 删除所有
	$redis->lRem('list2', 'html', 0);
	$lists = $redis->lRange('list2', 0, -1);
	var_dump($lists); echo "<br/>";