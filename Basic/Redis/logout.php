<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 5:04
 */
setcookie("auth","",time()-1);
header("location:list.php");