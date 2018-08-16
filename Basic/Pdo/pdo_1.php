<?php
$dsn = "mysql:host=localhost;dbname=test";
$user = "root";
$pass = "root";

$link = new PDO($dsn, $user, $pass);

// var_dump($link);

//执行sql语句获取
$sql = "select * from user_info";
$result = $link->query($sql); //query方法返回的是PDOStatement对象

//如果想获取具体的数据,需要调用对象的方法:fetchAll;参数是类常量,表示返回什么样的数据

$rows = $result->fetchAll(PDO::FETCH_ASSOC);

// var_dump($rows);

//更新数据库的操作
$updateSQL = "UPDATE user_info set password=md5('123456') WHERE id = 2";

//执行增删改的语句,exec()方法,执行查询的语句query()

//exec()返回受影响的函数 query() 返回PDOStatement对象
$nums = $link->exec($updateSQL);

var_dump($nums);
