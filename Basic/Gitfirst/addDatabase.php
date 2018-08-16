<?php
header('Content-Type:text/html;charset=utf-8');
//包含连接数据库的文件
require 'conn.php';
//获取数据库名字和默认字符集
$database = $_POST['database'];
$charset = $_POST['charset'];
//执行SQL语句
$dbs = $pdo->query("show databases");
//获得结果集
$temp = array();
while (FALSE!=($row=$dbs->fetch(PDO::FETCH_ASSOC))) {
	$temp[] = $row['Database'];
}
//判断$database是否已存在
if (!in_array($database, $temp)) {
	//SQL语句
	$sql = "create database if not exists `".$database."` default charset=".$charset;
	//执行SQL语句
	$pdo->query($sql);
	header("location:index.php");
} else {
	echo $database."数据库已存在";
	header("refresh:2;url=index.php");
}