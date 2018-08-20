<?php
  # 函数substr通过在指定的字符串中设置检查的起点和长度,获取其中一部分子字符串
  # string substr(string str, int start [, int length])
  echo substr("apple", 1) . '<br>';
  echo substr("apple", 1, 3) . '<br>';
  echo substr("apple", -2) . "<br>";
  echo substr("apple", -3, 1) . "<br>";
  echo substr("apple", 2, -1). "<br>";
  echo substr("apple", -2, -1) . "<br>";
  echo substr("apple", 4, -1) . "<br>";
?>
