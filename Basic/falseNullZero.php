<?php
$arr = array('php在路上',12,'',array('我是字符串'));
echo in_array(array(0), $arr) ? 1 : 0;

$arr = array('12',13,'php在路上');
echo array_search('12',$arr,true)===false ? '没找到' : '找到了';

$arr = array('php在路上',1);
echo in_array(true,$arr) ? 1 : 0;
echo in_array(0,$arr) ? 1 : 0;

define('AUTHOR','haodaquan');
define('AUTHOR','PHP在路上');
echo AUTHOR;