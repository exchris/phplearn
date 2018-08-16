<?php

//PDO连接MySQL数据库
$link = new PDO("mysql:host=localhost;dbname=test", "root", "root");

# 默认不是长连接,若要使用数据库长连接,需要在最后加如下参数
# $longLink = new PDO("mysql:host=localhost;dbname=test", "root", "root", array(PDO::ATTR_PERSISTENT=>true));

# PDO常用方法以及应用
# PDO::query() 主要是用于有记录结果返回的操作,特别是SELECT操作
# PDO::exec() 主要是针对没有结果集合返回的操作, 如INSERT、UPDATE等操作
# PDO::lastInsertId() 返回上次插入操作, 主键列类型是自增的最后的自增ID
# PDOStatement::fetch() 是用来获取一条记录
# PDOStatement:fetchAll() 是获取所有记录集中的一个

var_dump($link);
if ($link->exec("insert into user(username,password) VALUES('admin', '123456')")) {
	echo '插入成功<br>';
	echo $link->lastInsertId();
} else {
	echo '插入失败<br>';
}

# 查询操作
$rs = $link->query("select * from user");
while (($row = $rs->fetch()) != false)
{
	print_r($row);
}