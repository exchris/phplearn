<?php
# 类型运算符:instanceof。
# instanceof用来测定一个给定的对象是否来自指定的对象类
  class A {}
  class B {} // 定义两个类A, B

  $thing = new A; // 声明类A的一个对象$thing

  if ($thing instanceof A) {
    echo 'A';
  }
  if ($thing instanceof B) {
    echo 'B';
  }

  # 输出 : 'A'
?>
