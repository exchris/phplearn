<?php
  # 字符串比较函数strcmp与strncmp
  # strcmp函数用于比较两个字符串是否相等,也可以用于两个字符串的排序
  # int strcmp(string str1, string str2)
  # 如果字符串str1中字符的ASCII码值大于字符串str2中对象的字符,
  # 就返回一个正数;反之,就返回一个负数;如果相等,则返回0
  $str1 = 'abc';
  $str2 = 'aBcde';

  if (strcmp($str1, $str2) > 0)
    echo "'$str1' > '$str2'";
  elseif (strcmp($str1, $str2) < 0)
    echo "'$str1' < '$str2'";
  else
    echo "'$str1 == $str2'";

  # strncmp的作用与函数strcmp非常类似,
  # strncmp多一个参数,用于指导比较字符串的长度
  if (strncmp($str1, $str2, 1) > 0)
    echo "'$str1' > '$str2'";
  elseif (strncmp($str1, $str2, 1) < 0)
    echo "'$str1' < '$str2'";
  else
    echo "'$str1 == $str2'";
?>
