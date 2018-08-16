<?php
header("Content-Type:text/html;charset=utf-8");
error_reporting(0);
//定义重复操作最短的允许时间,单位秒
define('TIME_OUT', 10);
define('MAX_COUNT', 10);
@session_start();
$time = time();
echo "次数为:".$_SESSION['counts']."<br/>";
echo "session时间为:".$_SESSION['time']."<br/>";
echo "值为:".isset($_SESSION['time'])."<br/>";
echo "时间差为:".($time-$_SESSION['time'])."<br/>";
//判断是否对时间进行session赋值
if(isset($_SESSION['time'])) {
    //判断超时
    if($time - $_SESSION['time'] <= TIME_OUT) 
    {
    	echo json_encode(array("code"=>1,"msg"=>"在30秒内只能访问一次!"));
      	exit();      
    } 
    else 
    { 
    	//未超时
    	if (isset($_SESSION['counts'])) 
    	{
    		//判断次数
    		if ($_SESSION['counts'] > MAX_COUNT) 
    		{
    			echo json_encode(array("code"=>2,"msg"=>"1天之内最多访问10次!"));
    			exit();
    		} 
    		else 
    		{
    			$_SESSION['time'] = $time;
    			$_SESSION['counts'] = $_SESSION['counts'] + 1;
    			echo "执行了".$_SESSION['counts'];
    		}
    	} 
    	else 
    	{
    		$_SESSION['counts'] = $_SESSION['counts'] + 1;
    		
    		$_SESSION['time'] = $time;
    		echo "这还是正常";
    	}
    }
} 
else 
{
  $_SESSION['counts'] = $_SESSION['counts'] + 1;
  	 
  $_SESSION['time'] = $time;
  echo "这还是正常";
}
?>