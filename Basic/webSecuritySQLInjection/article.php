<?php

// error_reportint(0);

$db_config = [
	'host' => '127.0.0.1',
	'port' => 3306,
	'user' => 'root',
	'password' => 'root',
	'database' => 'sql_inject'
];

// 传入参数非空校验
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($id) || !is_numeric($id)) {
	dir("article id is not allowed empty");
}

$server = $db_config['host'] . ':' .$db_config['port'];
$db = mysqli_connect($server, $db_config['user'], $db_config['password'],
	$db_config['database']) or die('unable to connect to mysql server: '.
	mysqli_error($db));

mysqli_set_charset($db,"utf8");

// 数字注入
$sql = "SELECT * FROM article WHERE id = ". $id;
// learn.me/sql/article.php?id=-1 OR 1=1

echo '<pre>';
print_r($sql);
echo '</pre>';

$result = mysqi_query($db, $sql);
if (!$result) {
	die("query failed: " . mysqli_error($db));
}

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<pre>';
	print_r($row);
	echo '</pre>';
}
mysqli_close($db);
