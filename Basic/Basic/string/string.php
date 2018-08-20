<?php
  # strtoupper: 字符串转大写
  # strtolower: 字符串转小写
  # ucfirst: 字符串首字母大写
  # ucwords: 把字符串中每个单词的首字母转大写
  # explode: 字符串切割函数
  # implode: 字符串合并函数
  # str_split:平均分割字符串
  $data = "http://www.csdn.net";
  list($http, $name, $ext) = explode(".", $data);
  list($http, $www) = explode("://", $http);

  echo $http."<br/>";
  echo $www."<br/>";
  echo $name."<br/>";
  echo $ext ."<br/>";

  $str = '1,2,3,4,5';
  echo '<pre>';
  print_r($lists = explode(',', $str, 2));
  echo '</pre><pre>';
  print_r($lists = explode(',', $str, -2));
  echo '</pre>';
  foreach ($lists as $list) {
    $list += $list;
  }
  echo "explode(',', '$str', -2) 分割后的元素之和:"
  .$list."<br/>";

  $array = array('www', 'csdn', 'net');
  $http = implode(".", $array);
  echo $http;
?>
