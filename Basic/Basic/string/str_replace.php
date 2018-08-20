<?php
  header("content-type:text/html;charset=utf-8");
  # str_replace替换字符串
  # mixed str_replace(mixed search, mixed replace, mixed subject [,int &count])
  # 参数subject:操作的源字符串
  # 参数search:在subject中被替换的字符串
  # 参数replace:表示用于替换的字符串
  # 参数count:是一个输出变量,它返回了replace子字符串被替换的次数
  $subject = "apple banana and orange.";
  $old = array("apple", "banana", "orange");
  $new = array("book", "pen", "desk");

  echo str_replace($old, $new, $subject).'<br/><br/>';

  $str = str_replace("p", "*", "apple", $count);
  echo '替换的次数:'.$count;
?>
