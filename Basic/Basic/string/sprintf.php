<?php
  header("content-type:text/html;charset=utf-8");
  # 字符串格式化
  $num = 3;
  $location = 'desk';
  $format = 'There are %d apples on the %s.<br><br>';
  printf($format, $num, $location);

  echo sprintf($format, $num, $location);

  # %l$s表示调用$location,%2$d表示调用$num
  $format1 = 'There are %2$d apples on the %l$s.<br/><br/>';
  echo sprintf($format1, $location, $num);

  $s = 'bigmarten';
  echo sprintf("[%10s]<br/>", $s);
  echo sprintf("[%-10s]<br/>", $s);
  echo sprintf("[% 10s]<br/>", $s);
  echo sprintf("[%010s]<br>", $s);
  echo sprintf("[%'#10s']<br><br>", $s);

  $money = 23.10;
  echo sprintf("￥%5.1f<br>", $money);
  echo sprintf("￥%.2f<br>", $money);
?>
