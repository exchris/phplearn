<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 5:05
 */
require("redis.php");
$uid = $_GET['id'];
//echo $uid;
$username = $redis->hget("user:".$id,"username");
$a=$redis->del("user:".$uid);
$redis->del("username:".$username);
$redis->lrem("uid",$uid);
//var_dump($a);
header("location:list.php");