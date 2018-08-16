<?php

# 预编译:PDO::prepare($sql); 返回PDOStatement对象
# 绑定数据 PDOStatement->bindParam(); 给预编译的结果绑定数据
# 执行编译结果 PDOStatement->execute();

# 使用PDO操作数据库
# 第一个参数:连接数据库的类型: 主机名; 数据库名
$dsn = 'mysql:host=localhost;dbname=test';
$user = 'root';
$pass = 'root';

try {
	$pdo = new PDO($dsn, $user, $pass);
}catch (PDOException $e){
	echo '数据库连接失败：'.$e->getMessage();
	exit;
}


# 预编译:prepare(); 参数是不带数据的sql语句
# 先将sql语句中的数据部分用占位符代替:占位符名称
$sql = 'insert into user(username,password) values(?,?)';

$smt = $pdo->prepare($sql); // 返回一个PDOStatement对象

# 绑定数据PDOStatement对象的bindParam()来绑定参数: 占位符,实际数据

$username = 'user';
$password = md5(123456);

$smt->bindParam(1, $username);
$smt->bindParam(2, $password);

$smt->execute();           //执行参数被绑定后的准备语句
?>