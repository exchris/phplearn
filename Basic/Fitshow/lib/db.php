<?php
/**
 * 连接数据库并返回连接句柄
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 下午 6:57
 */
error_reporting(0);
header("Content-Type:text/html;charset=utf8");
/**
 * 为了安全处理利用PDO连接数据库
 * 防止SQL注入
 * 连接服务器数据库
 */
$db = array(
    'dsn' 		=> 'mysql:host=127.0.0.1;dbname=ttpaobu;port=3306;charset=utf8',
    'host'  	=> '127.0.0.1',
    'port'		=> 3306,
    'dbname'	=> 'ttpaobu',
    'username'  => 'root',
    'passwd'    => 'yujie1299',
    'charset'   => 'utf8'
);

// 修改连接默认属性
$options = array(
    PDO::ATTR_ERRMODE 	=> PDO::ERRMODE_EXCEPTION, // 默认是PDO::ERRMODE_SLIENT,0,(忽略错误模式)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 默认是PDO::FETCH_BOTH,4
);

// 抛出连接服务器异常信息
try
{
    $pdo = new PDO($db['dsn'], $db['username'], $db['passwd'], $options);
}
catch (PDOException $e)
{
    echo error($e->getCode(), $e->getMessage());
}

?>