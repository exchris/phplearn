<?php
//数据库的配置信息
define("DB_MS", "mysql"); //数据库服务器类型
define("DB_HOST", "localhost"); //主机
define("DB_PORT", "3306"); //端口号
define("DB_USER", "root"); //用户名
define("DB_PWD", "123456"); //密码
define("DB_NAME", "test"); //选择的数据库
define("DB_CHARSET", "utf8"); //字符集
//设置数据源
// $dsn = "mysql:host=localhost;port=3306;dbname=itcast;charset=utf8";
$dsn = DB_MS.":host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";
	charset=".DB_CHARSET;
// 修改连接默认属性
$options = array(
	PDO::ATTR_ERRMODE 	=> PDO::ERRMODE_EXCEPTION, // 默认是PDO::ERRMODE_SLIENT,0,(忽略错误模式)
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 默认是PDO::FETCH_BOTH,4
);
//连接数据库
try {
	//实例化PDO创建数据库服务器连接
	$pdo = new PDO($dsn, DB_USER, DB_PWD, $options);
	//设置抛出异常错误模式
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	//输出异常信息
	echo $e->getMessage().'<br/>';
}
?>
