<?php
try {
	$num = 0;
	//判断除数是否为零
	if ($num == 0) {
		$errmsg = "除数不能为零,请更改其他值";
		throw new Exception($errmsg); //抛出异常
	} else {
		echo 50/$num;
	}
} catch (Exception $e) {
	//捕获并处理异常
	echo "出错原因:".$e->getMessage()."<br>";
	echo "错误文件路径:".$e->getFile()."<BR>";
	echo "错误代码行号:".$e->getLine();
}