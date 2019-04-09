<?php

// error_reporting(0);

$db_config = [
	'host' => '127.0.0.1',
	'port' => 3306,
	'user' => 'root',
	'password' => 'root',
	'database' => 'sql_inject'
];

// 参数非空校验
$user_name = isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

if (empty($user_name) || empty($password) || preg_match("/^[a-zA-Z0-9]{6,}$/", $user_name)) {
	dir("you input user_name and password not valid!");
}

$server = $db_config['host'] . ':' .$db_config['port'];
$db = mysqli_connect($server, $db_config['user'], $db_config['password'],
	$db_config['database']) or die('unable to connect to mysql server: '.
	mysqli_error($db));

mysqli_set_charset($db,"utf8");

// 字符串注入
// mysqli_real_escape_string($db,$user_name);

// $sql = "SELECT * FROM user WHERE user_name = '".addslashes($user_name).
//	"' AND password = '".md5($password)."'";

// $sql = "SELECT * FROM user WHERE user_name = 'james'#' AND password='697d51a19d8a121ce81499d7b701668'"
// $sql = "SELECT * FROM user WHERE user_name = 'james'-- 'AND password='698d51a19d8a121ce81499d7b701668'"	

$sql = "SELECT id,user_name FROM user WHERE user_name = ? AND password=?";
bind_param($sql,'ss',$user_name,$password);
$password = md5($password);
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt,'ss',$user_name,$password);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$id,$user_name);
mysqli_stmt_fetch($stmt);
echo $id, $user_name;
if (empty($id) || empty($user_name)) {
	die("user_name or password is invalid");
}
mysqli_close($db);

function bind_param($sql,$formate) 
{
	$args = func_get_args();
	$prepare_sql = array_shift($args);
	$formate = array_shift($args);
	$i = 0;
	while ($i < strlen($formate)) {
		switch ($i) {
			case 's':
				# code...
				$args[$i] = "'".addslashes($args[$i])."'";
				break;
			case 'i':
				$args[$i] = intval($args[$i]);
				break;
			
			default:
				# code...
				break;
		}
		$prepare_sql = str_replace('?', $args[$i], $prepare_sql);
		$i++;
	}
	return $prepare_sql;
}


echo '<pre>';
print_r($sql);
echo '</pre>';

$result = mysqli_query($db, $sql);
if (!$result) {
	die("query failed: ". mysqli_error($db));
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (empty($row)) {
	die("invalid user_name or password!");
}
echo '<pre>';
print_r($row);
echo '</pre>';
echo 'login success';
mysqli_close($db);