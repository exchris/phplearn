<?php
  # 不区分大小写的比较函数strcasecmp与strncasecmp
  $str1 = "apple";
  $str2 = "aPPle";
  if (strcasecmp($str1, $str2) == 0) {
    echo '$str1 == $str2';
  } elseif (strcasecmp($str1, $str2) > 0 ) {
    echo '$str1 > $str2';
  } else {
    echo '$str1 < $str2';
  }

  if (strncasecmp("appl", $str2, 5) == 0) {
    echo 'appl == $str2';
  } elseif (strncasecmp("appl", $str2, 5) > 0 ) {
    echo 'appl > $str2';
  } else {
    echo 'appl < $str2';
  }
?>
