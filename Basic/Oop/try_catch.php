<?php
try {
	$num = 0;
	#判断除数是否为零
	if ($num == 0) {
		throw new Exception(); //抛出异常
	} else {
		echo 50/$num;
	}
} catch(Exception $e) { 
	//捕获并处理异常
	echo "除数不能为零,请更改为其他值";
}