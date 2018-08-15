<?php 
	
	header('content-type:text/html;charset=utf-8');

	try {
		# 实例化Redis
		$redis = new \Redis();

		# 连接
		$redis->connect('127.0.0.1', 6379);

		# 列表
		$redis->delete('list1');
		# 存储数据到列表中
		$redis->lPush('list1', 'html');
		$redis->lPush('list1', 'css');
		$redis->lPush('list1', 'php');
		$redis->lPush('list1', 'mysql');
		$redis->lPush('list1', 'javascript');
		$redis->lPush('list1', 'ajax');

		# 获取列表中所有的值
		$lists = $redis->lRange('list1', 0, -1);
		var_dump($lists); echo "<br/>";

		# 获取列表的长度
		$length = $redis->lSize('list1');
		echo $length."<br/>";

		# 返回列表key中index位置的值
		echo $redis->lGet('list1', 2)."<br/>";
		echo $redis->lIndex('list1', 2)."<br/>";

		# 设置列表中index位置的值
		echo $redis->lSet('list1', 2, 'linux')."<br/>";
		
		$lists = $redis->lRange('list1', 0, -1);
		var_dump($lists); echo "<br/>";

		# 截取链表中start到end的元素
		$lists = $redis->lGetRange('list1', 0, 2);
		var_dump($lists); echo "<br/>";

		
		# 截取列表后列表发生变化,列表保留截取的元素,其余的删除
		$lists = $redis->lTrim('list1', 0, 1);
		var_dump($lists); echo "<br/>";

		$lists = $redis->lRange('list1', 0, -1);
		print_r($lists);

	} catch (RedisExceptione $e) {
		# 连接Redis Server 错误信息
		var_dump($e);
	}