<?php
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
	'passwd'    => 'root',
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

/**
 * 预处理SQL
 * $sql string sql语句
 */
function prepare($sql)
{
	global $pdo;
	return $pdo->prepare($sql);
}


/**
 * 检验圈子ID、记录ID、用户ID合法性
 * @param integer $id 圈子ID、记录ID、用户ID
 * @param string $table 表名
 * @param string $column 表字段主键
 */
function exists($id, $table, $column)
{
	if (is_numeric($id)) 
	{
		# code...
		$sql = "SELECT $column FROM `$table` WHERE $column = ? LIMIT 1";
		$stmt = prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}
	else
	{
		return 0;
	}
}

/**
 * 多语言设置
 */
/**
 * 多语言设置
 */
function L($msg, $l = 'en')
{
	global $lang;
	$arr = array('cn','en','tw');
	if (in_array($l, $arr)) {
		include 'locale/errorjson/'.$l.'.php';
	} else {
		include 'locale/errorjson/'.'en.php';
	}
	
	return $lang[$msg];
}

/**********************************************
 ** @Description:将html标签、换行符转义字符删除
** @Author: cxm
** @Date:   2017-03-14 13:53:00
** @Last Modified by: cxm
** @Last Modified time: 2017-03-14 16:19:20
**********************************************/
function removeHTML($str)
{
	$search = array (
			"'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
			"'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
			"'([\r\n])[\s]+'",                 // 去掉空白字符
			"'&(quot|#34);'i",                 // 替换 HTML 实体
			"'&(amp|#38);'i",
			"'&(lt|#60);'i",
			"'&(gt|#62);'i",
			"'&(nbsp|#160);'i",
			"'&(iexcl|#161);'i",
			"'&(cent|#162);'i",
			"'&(pound|#163);'i",
			"'&(copy|#169);'i",
			"'peihuo\.cn|peihuo\.mobi|div|\/'",
			"'&#(\d+);'e");                    // 作为 PHP 代码运行

	$replace = array (
			"",
			"",
			" ",//"\\1",
			"\"",
			"&",
			"<",
			">",
			" ",
			chr(161),
			chr(162),
			chr(163),
			chr(169),
			"",
			"chr(\\1)");
	return  preg_replace ($search, $replace, $str);
}


