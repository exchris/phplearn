<?php
header("Content-Type:text/html;charset=utf-8");
/**
 * 遍历多维数组
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 3:05
 */
$a = ['fruits'=>['a'=>'orance','b'=>'grape','c'=>'apple'],
      'numbers'=>[1,2,3,4,5,6],
      'holes'=>['first',5=>'second','third']];

# 第二种: 递归遍历
function multiArrayToSingle($array) {
    $temp = []; # 初始化
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                multiArrayToSingle($value);
            } else {
                echo "key:".$key."<br/>"."value:".$value."<hr/>";
            }
        }
    }
}

# 第一种
foreach ($a as $list=>$things) {
    if (is_array($things)) {
        foreach ($things as $newList => $counter) {
            echo "key:".$newList."<br/>"."value:".$counter."<hr/>";
        }
    }
}
