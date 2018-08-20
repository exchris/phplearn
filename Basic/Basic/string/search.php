<?php
  # 使用strpos与stripos来确定子串的位置
  # 函数strpos()和stripos()用于查找一个子字符串在一个字符串中出现的位置
  # int strpos(string haystack, mixed needle [,int offset])
  # strpos()是区分大小写的
  $str = 'apple';
  $needle = 'p';
  $pos = strpos($str, $needle);
  if ($pos === false) {
    echo "'$needle' is not in '$str'.<br><br>";
  } else {
    echo "The position is $pos.<br><br>";
  }
  # 从第3个字符开始搜索
  $pos = strpos($str, 'p', 2);

  if ($pos === false) {
    echo "'$needle' is not in '$str'.";
  } else {
    echo "The position is $pos.<br>";
  }

  # 字符串不区分大小写
  # stripos函数认为"a"与"A"匹配,所以$ipos返回值为0
  $ipos = stripos($str, 'a');
  if ($ipos === false) {
    echo "'A' is not in '$str'.";
  } else {
    echo "The position is $ipos.";
  }
?>
