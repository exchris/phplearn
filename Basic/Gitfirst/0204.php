<?php
//php删除字符串中指定字符
$str = "我_们_的_=家+园";
$str = str_replace(array("_","=","+"), "", $str);
echo $str;