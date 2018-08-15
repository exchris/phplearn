<?php
header("Content-Type:text/html; charset=utf-8");
$dsn = "mysql:host=127.0.0.1;dbname=leetcode;port=3306;charset=utf8";
$username = "root";
$passwd = "root";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

$redis = new Redis();
$redis->connect('127.0.0.1',6379) or die("Could not connect redis server.");
$query = "select * from test limit 8";
$data = [];
// 将结果缓存到redis中
for ($key = 1; $key < 9; $key++)
{
    if (!$redis->get($key))
    {
        $pdo = new PDO($dsn, $username, $passwd, $options);

        foreach ($pdo->query($query) as $row) {
            $redis->set($row['id'], $row['name']);
        }
        $myserver = 'mysql';
        break;
    } else {
        $myserver = "redis";
        $data[$key] = $redis->get($key);
    }
}
echo $myserver;
for ($key = 1; $key < 9; $key++)
{
    echo "number is <b><font color=#FF0000>$key</font></b>";

    echo "<br>";

    echo "name is <b><font color=#FF0000>$data[$key]</font></b>";

    echo "<br>";
}