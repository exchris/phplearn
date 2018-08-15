<?php 
	# Hash (字典)
	header('content-type:text/html;charset=utf-8');

	# 实例化redis
	$redis = new \Redis();

	# 连接
	$redis->connect('127.0.0.1', 6379);

	# 字典
	$redis->delete('hash1');

	# 给hash表中某个key设置value
	# 如果没有则设置成功,返回1,如果存在会替换原有的值,返回0,失败返回0
	/*$datas = [
		'cat' => 'cat', 
		'cat' => 'cat', 
		'cat' => 'cat1', 
		'dog' => 'dog', 
		'bird' => 'bird', 
		'monkey' => 'monkey'];
	var_dump($datas);
	echo "<br/>";
	foreach ($datas as $key => $value) {
		echo $redis->hSet('hash1', $key, $value);
		echo "<br/>";
	}*/

	echo $redis->hSet('hash1', 'cat', 'cat');echo '<br>';
    echo $redis->hSet('hash1', 'cat', 'cat');echo '<br>';
    echo $redis->hSet('hash1', 'cat', 'cat1');echo '<br>';
    echo $redis->hSet('hash1', 'dog', 'dog');echo '<br>';
    echo $redis->hSet('hash1', 'bird', 'bird');echo '<br>';
    echo $redis->hSet('hash1', 'monkey', 'monkey');echo '<br>';

	# 获取hash中某个key的值
	echo $redis->hGet('hash1', 'cat')."<br/>";

	# 获取hash中所有的keys
	$arr = $redis->hKeys('hash1');
	var_dump($arr); echo "<br/>";

	# 获取hash中所有的值 顺序是随机的
	$arr = $redis->hVals('hash1');
	var_dump($arr); echo "<br/>";

	# 获取hash中key的数量
	echo $redis->hLen('hash1')."<br/>";

	# 删除hash中一个key 如果表不存在或key不存在则返回false
	echo $redis->hDel('hash1', 'dog')."<br/>";
	var_dump($redis->hDel('hash1', 'rabbite'));