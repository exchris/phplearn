<?php
header('Content-Type:text/html;charset=utf-8');
//包含连接数据库的文件
require 'conn.php';
//获取数据库名字
$database = $_GET['database'];
//SQL语句
$sql1 = "drop database `".$database."`";
//执行SQL语句并判断,成功:跳转到index.php 失败:输出提示信息
if ($pdo->query($sql1)) {
	header("location:index.php");
} else {
	echo $database."数据库删除失败";
}