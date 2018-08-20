<?php
  header("content-type:text/html;charset=utf-8");

  # str_pad函数同样能实现填充字符串的功能
  # string str_pad(string input, int pad_length [,
  # string pad_string, [,int pad_type]])
  # input 表示要操作的源字符串
  # pad_length表示字符串输出的长度
  # pad_string表示用于填充的字符串
  # pad_type表示填充的方向,这个参数有三个可选项
  # STR_PAD_RIGHT, STR_PAD_LEFT, STR_PAD_BOTH
  # 向右填充、向左填充、同时向左右填充
  $str = 'apple';
  echo '['.str_pad($str, 10).']<br>';
  echo '['.str_pad($str, 10, "*#", STR_PAD_LEFT).']<br>';
  echo '['.str_pad($str, 10, "*", STR_PAD_BOTH).']<br>';
  echo '['.str_pad($str, 6, " ***").']<br>';
  # 如果pad_length的长度小于源字符串的实际长度,str_pad将输出源字符串。
  echo '['.str_pad($str, 3, "***").']<br>';
