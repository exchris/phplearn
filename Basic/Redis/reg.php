<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 5:00
 */
require("redis.php");
$username = $_POST['username'];
$password = md5($_POST['password']);
$age = $_POST['age'];
$uid = $redis->incr("userid"); // 设置自增id，相当于主键
// 用hash类型存储用户方便
$redis->hMset("user:".$uid,array("uid"=>$uid,"username"=>$username,"password"=>$password,"age"=>$age));
// 将用户id存入一个链表中,便于统计数据
$redis->rPush("uid", $uid);
// 将用id存入以用户名为键的字符类型中,便于查看用户是否存在。
$redis->set("username:".$username, $uid);
header("location:list.php");
