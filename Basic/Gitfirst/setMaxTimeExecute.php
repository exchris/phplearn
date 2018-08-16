<?php
  //定义重复操作最短的允许时间,单位秒
  define('TIME_OUT', 30);
  @session_start();
  $time = time();
  if(isset($_SESSION['time'])) {
    //判断超时
    if($time - $_SESSION['time'] <= TIME_OUT) {
      echo "<script type='text/javascript'>alert("在30秒内只能访问一次!");</script>";
      exit();      
    }
  }
  $_SESSION['time'] = $time;
  echo "这还是正常";
?>
