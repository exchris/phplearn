<?php
//顺序查找
function seq_sch($array, $n, $k) {
	//顺序查找算法的实现
	$array[$n] = $k;
	for ($i=0; $i<$n;$i++) {
		if($array[$i] == $k) {
			return true; #找到目标值后跳出循环体
			break;
		}
	}
	if ($i < $n) {
		//判断是否到数组的末尾
		return $i;
	} else {
		return false;#查找目标值失败
	}
}

// $array = array(3,6,1,9,2,10);#使用array结构创建数组
// $n = count($array);
// $k = 3;
// if (seq_sch($array, $n, $k)) {
// 	//使用顺序查找法查找数字3
// 	echo "顺序查找成功";
// } else {
// 	echo "顺序查找失败";
// }
#顺序查找成功

//二分法查找
function bin_sch($array, $low, $high, $k) {
	//二分查找算法的实现
	if ($low <= $high) {
		$mid = intval(($low+$high)/2);
		if ($array[$mid] == $k) {
			return true;
		} elseif ($k < $array[$mid]) {
			return bin_sch($array, $low, $mid-1, $k);
		} else {
			return bin_sch($array, $mid+1, $high, $k);
		}
	}
}
$array = array(3,6,1,9,2,10);
$low = min(3,6,1,9,2,10);
$high = max(3,6,1,9,2,10);
$k = 8;
if (bin_sch($array,$low,$high,$k)) {
	//使用二分查找法查找数字8
	echo "二分查找成功";
} else {
	echo "二分查找失败";
}
