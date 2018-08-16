<?php
/**
 * 冒泡排序
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 3:19
 */
function bubbleSort($arr)
{
    $n = count($arr);
    $temp = 0; # 临时变量
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n - $i; $j++) {
            if ($arr[$j] < $arr[$i]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $temp;
            }
        }
    }
    return $arr;
}

$arr = [2, 5, 3, 0];
print_r(bubbleSort($arr));