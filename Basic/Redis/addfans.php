<?php

//关注功能，建议用集合实现，因为集合元素唯一，并且可以容易求出两个用户粉丝之间交集与差集，进而进行好友推荐功能

$id = $_GET['id'];
$uid = $_GET['uid'];
require("redis.php");
$redis->sadd("user:".$uid.":following",$id);
$redis->sadd("user:".$id.":followers",$uid);
header("location:list.php");