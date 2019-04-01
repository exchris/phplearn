<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379); //serverip port
$redis->auth('');//my redis password
echo "Connection to server successfully".PHP_EOL;

if($redis->exists("mykey")){
    $redis->set("mykey","value1 ");
    $redis->append("mykey", "value2");
}else{
    $redis->set('mykey', 'value1 ');
    $redis->append("mykey", "value2");
}

echo $redis->get("mykey");