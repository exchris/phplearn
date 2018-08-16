<?php
//用于获取具体省下的所有城市信息和具体城市下的所有县级信息
//禁止缓存
header("Content-type:text/xml;charset=utf-8");
header("Cache-Control:no-cache");
//包含连接数据库的文件
require 'conn.php';
//获取城市
if (!empty($_POST['province_id'])) {
	$province_id = $_POST['province_id'];
	$sql = "select * from city where province_id = {$province_id}";
	//执行SQL语句
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	//处理结果集
	$info = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($info);
}
//获取县
if (!empty($_POST['city_id'])) {
	$city_id = $_POST['city_id'];
	$sql = "select * from county where city_id = {$city_id}";
	//执行SQL语句
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	//处理结果集
	$info = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($info);
}