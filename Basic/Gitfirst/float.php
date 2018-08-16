<?php
/**********************************************
 ** @Description:防坑1--float
 ** $a = 2586;
 ** $b = 2585.98
 ** var_dump($a - $b); 
 ** @Result : float(0.019999999999982)
 ** @Expect : float(0.02)
 ** @Function:
 ** 1、通过乘100的方式转化为整数加减,然后在除以100转化回来
 ** 2、使用number_format转化成字符串,然后在使用(float)强转回来
 ** 3、php提供了高精度计算的函数库
 ** bcadd:将两个高精度数字相加;
 ** bccomp:比较两个高精度数字,返回-1,0,1
 ** bcdiv:将两个高精度数字相除
 ** bcmod:求高精度数字余数
 ** bcmul:将两个高精度数字相乘
 ** bcpowmod:求高精度数字乘方求模,数论里非常常用
 ** bcscale:配置默认小数点位数,相当于就是Linux bc中的"scale="
 ** bcsqrt:求高精度数字平方根
 ** bcsub:将两个高精度数字相减
 ** @Author: cxm
 ** @Date:   2017-03-14 14:33:00
 ** @Last Modified by: cxm
 ** @Last Modified time: 2017-03-14 14:33:00
 **********************************************/
$a = 2586;
$b = 2585.98;
var_dump(bcsub($a, $b, 2));
