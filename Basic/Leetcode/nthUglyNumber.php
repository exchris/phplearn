<?php
/**
 * 输入第N个丑数
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 10:05
 * @author exchris
 *
 * Sn = min(T1*2,T2*3,T3*5)
 * Sn+1 =
 */

function nthUglyNumber($number)
{
    $arr = [];
    array_push($arr, 1);
    $index = 1;
    $index2 = 0;
    $index3 = 0;
    $index5 = 0;
    while ($index < $number) {
        $min = min([$arr[$index2] * 2, $arr[$index3] * 3, $arr[$index5] * 5]);
        if ($arr[$index2] * 2 == $min) {
            $index2 += 1;
        }
        if ($arr[$index3] * 3 == $min) {
            $index3 += 1;
        }
        if ($arr[$index5] * 5 == $min) {
            $index5 += 1;
        }
        array_push($arr, $min);
        $index += 1;
    }
    var_dump($arr);
}

nthUglyNumber(12);