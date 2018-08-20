<?php
  header("content-type:text/html;charset=utf-8");
  # 类型检测
  $var = 'abc';
  if (is_string($var)) {
    echo "$var 是字符串<br/><br/>";
  }

  $var = 12.3;
  if (is_numeric($var)) {
    echo "$var 是数字类型<br/><br/>";
  }

  $var = true ;
  if (is_bool($var)) {
    echo "$var 是布尔类型<br/><br/>";
  }

  $var = array('a','b');
  if (is_array($var)) {
    echo "是数组类型<br/><br/>";
  }

  $var = null;
  if (is_null($var)) {
    echo "$var 是空类型<br/><br/>";
  }

  $var = '';
  if (empty($var)) {
    echo "$var 没有值或为零值<br/><br/>";
  }

  if (isset($var)) {
    echo "$var 已定义<br/><br/>";
  }

  if (!isset($var2)) {
    echo "$var2 未定义<br/><br/>";
  }
