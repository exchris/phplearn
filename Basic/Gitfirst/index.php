<?php
header("Content-Type:text/html;charset=utf-8");
//包含连接数据库的文件
require 'conn.php';
//SQL语句
$sql = "show databases";
//执行SQL语句
$result = $pdo->query($sql);
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
	<center>
		<form action="addDatabase.php" method="post">
			新建数据库: <input type="text" name="database" />
			默认字符集: <select name="charset" style="width:58px">
						<option value="armscii8">armscii8</option>
						<option value="big5">big5</option>
						<option value="binary">binary</option>
						<option value="cp1250">cp1250</option>
						<option value="utf8" selected>utf8</option>
					 </select>
					 <input type="submit" value="新建" />
		</form>
	</center>
	
	<table border='1' cellspacing='1' align='center' width='420'>
		<tr bgcolor='#ccc' align='center'>
			<td>数据库名</td>
			<td colspan="2">操作</td>
		</tr>
		<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
		<tr align="center">
			<td><?php echo $row['Database'];?></td>
			<td><a href="table.php?database=<?php echo $row['Database'];?>">查看</a></td>
			<td><a href="delDatabase.php?database=<?php echo $row['Database'];?>"
				onclick="{if (confirm('确定要删除记录吗?\n\n<?php echo $row['Database'];?>')) {
					return true;
				}return false;}">删除</a></td>
		</tr>
		<?php }?>
	</table>
</body>
</html>