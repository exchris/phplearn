<?php
  // 连接本地的Redis服务
  $redis = new Redis();
  $redis->connect('127.0.0.1', 6379);
  echo "Connection to server successfully<br/>";
  // 查看服务是否运行
  echo "Server is running : " . $redis->ping();
?>
