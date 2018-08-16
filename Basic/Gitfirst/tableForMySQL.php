<?php
header("Content-Type:text/html;charset=utf8");
define('HOST','localhost'); //主机名
define('USER','admin'); //用户名
define('PWD','pass'); //密码
//1.连接初始化,选择数据库
$conn = @mysql_connect(HOST,USER,PWD) or
die('数据库连接错误!');
$db = mysql_select_db('ecshop',$conn);
mysql_query("set names utf8"); //设置编码格式


//2. 实现业务逻辑:查询所有商品信息
$sql = "select * from product";
$result = mysql_query($sql, $conn);

//3. 展示商品信息
//将result结果集中查询结果取出一条
echo "<table border='1' width='400px'>";
echo "<tr><th>ID</th><th>商品名称</th></tr>";
while(($row=mysql_fetch_assoc($result))!=false)
{
	echo "<tr><td>".$row["id"].
	"</td><td>".$row["name"].
	"</td><tr>";
}
echo "</table>";
mysql_close($conn);
?>