<?php

$memcache = new Memcache; // 创建一个memcache对象
$memcache->connect('127.0.0.1', 11211) or die("Cound not connect"); // 连接Memcache服务器

$memcache->set('key', 'hello memcache!'); // 设置一个变量到内存中,名称为key,值是"hello memcache!"

$out = $memcache->get('key'); // 从内存中取出key的值

echo $out; // 输出key的值
?>
