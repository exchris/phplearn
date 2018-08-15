<?php
header('content-type:text/html;charset=utf-8');
$redis = new Redis();
$redis->connect('127.0.0.1',6379) or die ("could net connect redis server");
$query = "select * from user limit 8";
//为了简单一点，这里就读取了8条数据
for ($key = 1; $key < 9; $key++)
{
    $newkey = $key + '';
    if (!$redis->get($newkey))
    {
        $connect = mysqli_connect('127.0.0.1','root','root','ttpaobu');
        $result = mysqli_query($connect, $query);
        //如果没有找到$key,就将该查询sql的结果缓存到redis
        while ($row = mysqli_fetch_assoc($result))
        {
            echo $row['username'].'插入成功'.$redis->set($newkey,$row['username'])."<br/>";
        }
        $myserver = 'mysql';
        break;
    }
    else
    {
        $myserver = "redis";
        echo $redis->get($newkey)."<br/>";
    }
}

echo $myserver;
?>