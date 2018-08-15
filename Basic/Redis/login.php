<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 5:04
 */
require("redis.php");
$username = $_POST['username'];
$pass = $_POST['password'];
//根据注册时存储的以用户名为键的字符类型中查找用户id
$id = $redis->get("username:".$username);
if(!empty($id)){
    $password = $redis->hget("user:".$id,"password");
    if(md5($pass) == $password){
        $auth = md5(time().$username.rand());
        $redis->set("auth:".$auth,$id);
        setcookie("auth",$auth,time()+86400);
        header("location:list.php");
    }
}

?>

<form action="" method="post">
    用户名:<input type="text" name="username"/><br>
    密码:<input type="password" name="password"><br>
    <input type="submit" value="登录"/>
</form>