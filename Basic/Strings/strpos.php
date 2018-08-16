<?php
/**
 * 指定字符串中查找子字符串的方法
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 3:00
 */
$haystack1 = "2349534134345w3mentor16504381640386488129";
$haystack2 = "w3mentor234953413434516504381640386488129";
$haystack3 = "center234953413434516504381640386488129fyi";
$pos1 = strpos($haystack1, "w3mentor");
$pos2 = strpos($haystack2, "w3mentor");
$pos3 = strpos($haystack3, "w3mentor");
print("pos1 = ($pos1); type is " . gettype($pos1) . "\n");
print("pos2 = ($pos2); type is " . gettype($pos2) . "\n");
print("pos3 = ($pos3); type is " . gettype($pos3) . "\n");