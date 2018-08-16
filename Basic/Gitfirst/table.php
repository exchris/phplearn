<?php
header('Content-Type:text/html;charset=utf-8');
//包含连接数据库的文件
require 'conn.php';
//获取数据库名字
$database = @$_GET['database'];
//SQL语句
$sql1 = "use `$database`";
//执行SQL语句
$result1 = $pdo->query($sql1);
//SQL语句
$sql2 = "show tables";
$result2 = $pdo->query($sql2);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>itcastAdmin</title>
	<style type="text/css">
		table {margin:10px auto;}
		a:link,a:visited {color:#333;text-decoration:none;}
		a:hover,a:active {color:#F5A52E;text-decoration:none;}
	</style>
</head>
<body>
	<table border='1' cellspacing='1' align='center' width='520'>
		<tr bgcolor='#ccc' align='center'>
			<td>表名</td>
			<td colspan="3">操作</td>
		</tr>
		<?php if ($result2->rowCount()) { while (($row =
			$result2->fetch(PDO::FETCH_ASSOC))!=false) { ?>
		<tr align='center'>
			<td><?php echo $row['Tables_in_'.$database];?></td>
			<td><a href="">浏览</a></td>
			<td><a href="">结构</a></td>
			<td><a href="">删除</a></td>
		</tr>
		<?php }}?>
	</table>
	<center>
		<a href="index.php">返回上一页</a>
	</center>
</body>
</html>