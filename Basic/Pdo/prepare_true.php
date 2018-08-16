<?php
header('Content-Type:text/html;charset=utf-8');

//实例化pdo对象
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=test', 'root', 'root');

//通过query函数执行sql命令
$pdo->query('set names utf8');

//插入数据
$sql = "insert into user(username,password) values (?, ?);" ;
$preObj = $pdo->prepare($sql);

$res = $preObj->execute(array('小明', 22));
// var_dump($res);

# echo $pdo->lastInsertId(); output 5

//删除数据
$sql = "delete from user where uid = ?";
$preObj = $pdo->prepare($sql);
$res = $preObj->execute(array(5));

// 修改数据
$sql = "update user set password= ? where uid = ?;";
$preObj = $pdo->prepare($sql);
$res = $preObj->execute(array('123456', 2));
var_dump($res);

//查询数据
$sql = "select * from user where username = ? order by uid desc";
$preObj = $pdo->prepare($sql);
$preObj->execute(array('admin'));
$arr = $preObj->fetchAll(PDO::FETCH_ASSOC);

/*
 *  FETCH_BOTH 是默认的,可省, 返回关联和索引
 *  FETCH_ASSOC 参数决定返回的只有关联数组
 *  PDO::FETCH_NUM 返回索引数组
 *  PDO::FETCH_OBJ 返回由对象组成的二维数组
 */

print_r($arr);