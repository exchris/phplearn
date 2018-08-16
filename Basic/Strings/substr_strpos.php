<?php
/**
 * php使用substr()和strpos()联合查找字符串中某一特定字符的方法
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 2:56
 */
$str = "admin || 46cc468df60c961d8da2326337c7aa58 || 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
echo substr($str,0,strpos($str,"||")); # 输出内容为"admin"