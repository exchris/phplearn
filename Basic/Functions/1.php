<?php
//求最大公约数
function divisor($m, $n) {
	if ($m % $n == 0) {
		return $n;
	} else {
		return divisor($n, $m%$n);
	}
}

//舍去方法
function distance($dis)
{
	return (((int)(($dis)*(($dis) >= 10000 ? 1.0 : (($dis) >= 1000 ? 10.0 : 100.0))))/(($dis) >= 10000 ? 1.0 : ($dis >= 1000 ? 10.0 : 100.0)));
}
