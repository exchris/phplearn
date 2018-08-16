<?php
 $divisor = 0;
 $number = 100;
 //判断除数是否为零
 if ($divisor != 0) {
 	$result = $number / $divisor;
 	echo $result;
 } else {
 	#调用trigger_error()函数
//  	trigger_error("除数不能为零!",E_USER_NOTICE); 
 	header("Location:errorPage.php");#重定向浏览器
 	#确保重定向后,后续代码不会被执行
 	exit;
 	
 }