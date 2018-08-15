<?php 
	
	header('content-type:text/html;charset=utf-8');

	# 实例化redis
	$redis = new \Redis();

	# 连接
	$redis->connect('127.0.0.1', 6379);

	# 字典
	$redis->delete('hash2');
	# 批量设置多个key的值
	$arr = [1=>1,2=>2,3=>3,4=>4,5=>5];
	$redis->hMset('hash2', $arr);
	var_dump($redis->hGetall('hash2'));
	echo "<br/>";

	# 检测hash中某个key是否存在
	echo $redis->hExists('hash2', '1')."<br/>";
	var_dump($redis->hExists('hash2', 'cat'));
	echo "<br/>";

	var_dump($redis->hGetall('hash2')); echo "<br/>";

	# 给hash表中key增加一个整数值
	$redis->hIncrby('hash2', '1', 1);
	var_dump($redis->hGetall('hash2'));
	echo "<br/>";

	# 给hash中的某个key增加一个浮点值
	$redis->hincrbyfloat('hash2', '2', 1.3);
	var_dump($redis->hGetall('hash2'));