<?php
header ( "Content-Type:text/html;charset=utf-8" );
error_reporting ( 0 );
include '../api/dbase.php';
/**
 *
 * @return 
 * 			两个全局变量$user_agent,$lang
 * @param 
 * 			$user_agent 获取访问者的客户端系统       	
 * @param 
 * 			$lang 获取系统的默认语言，去语言头部的前2位       	
 */

global $user_agent, $lang;
$user_agent = $_SERVER ['HTTP_USER_AGENT'];
$app = @$_REQUEST['app'];
$lang = substr ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'], 0, 2 );

/**
 *
 * @param
 *       	 This page support three version as PC,Android and iPhone
 * @param
 *       	 Not Support for example WinPhone
 */

	if($_REQUEST['m']=='' || $_REQUEST['s']==''){
		if ($_REQUEST [t]) {
			switch (strtolower($app)) {
				case 'sunny':
					header("location:http://ttpaobu.com/interface/version.php?download=sunny.apk");
					exit();
				default:
					header ( "location: http://ttpaobu.com/interface/version.php?download=fitshow.apk" );
					exit();
			}
	
} else {
	
	//判断客户端语言   中文
	if (preg_match("/zh/i", $lang))
	{
		switch (strtolower($app)) 
		{
			case 'sunny':
				header("location:http://a.app.qq.com/o/simple.jsp?pkgname=com.sunny");
				exit();
				
			default:
				header ( "location:http://a.app.qq.com/o/simple.jsp?pkgname=com.fitshow" );
				exit();
		}
	}

	else if (preg_match ( "/(iphone|ipod|ipad)/i", $user_agent )) 
	{
		switch (strtolower($app)) {
			case 'sunny':
				header("location:https://itunes.apple.com/cn/app/isunny/id1121994674?mt=8");
				exit();
			default:
				header ( "location:https://itunes.apple.com/us/app/ifitshow/id1099080595?l=zh&ls=1&mt=8" );
				exit();
		}
		
	} 	
	else if (preg_match ( "/(android|Googlebot-Mobile)/i", $user_agent )) 
	{
		switch (strtolower($app)) {
			case 'sunny':
				header("location:https://play.google.com/store/apps/details?id=com.sunny ");
				exit();
			default :
				header ( "location:https://play.google.com/store/apps/details?id=com.fitshow " );
				exit();
		}
	}
	// 其他客戶端类型
	else 
	{
		// $lang = substr ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'], 0, 4 );
		// 判断客户端语言是不是中文，如果是跳转到应用宝，如果不是就跳转到谷歌市场
		if (preg_match ( "/zh/i", $lang )) 
		{
			switch (strtolower($app)) {
				case 'sunny':
					header("location:http://a.app.qq.com/o/simple.jsp?pkgname=com.sunny ");
					exit();
				default :
					header ( "location: http://a.app.qq.com/o/simple.jsp?pkgname=com.fitshow " );
					exit();
			}
			
		} 
		else 
		{
			switch (strtolower($app)) {
				case 'sunny':
					header("location:https://play.google.com/store/apps/details?id=com.sunny ");
					exit();
				default :
					header ( "location:https://play.google.com/store/apps/details?id=com.fitshow " );
					exit();
			}
		}
	
	}

}
	}
	else{
		//手机扫描时接口
if(is_array($_REQUEST)&&count($_REQUEST)>0)//先判断是否通过REQUEST传值了
    {
if(isset($_REQUEST['uid'])){
    $uid=$_REQUEST['uid'];
    $se=$_REQUEST['s'];
    $de=$_REQUEST['m'];
    
      $res_se=query("SELECT  device FROM qr where serials=$se and device=$de");
      if ($res_se && ($re = $res_se->fetch_assoc()) != false)
		{
			query("UPDATE qr SET uid='$uid' where serials=$se and device=$de");
			exit(json_encode(array("code"=>200,"result"=>"登录成功","message"=>"登录成功")));
		}
	  	 //exit(json_encode(array("code"=>1000,"result"=>"没有跑步记录","message"=>"没有跑步记录")));
	  

     

echo "<script>window.location.href='http://www.ifitshow.com/qr/';</script>";
   return 0;
}
//跑步机上跑的接口
}



$device=$_REQUEST['m'];
$serials=$_REQUEST['s'];
$es = ini_get('error_reporting');
register_shutdown_function( "time_out_callback");
set_time_limit(30); //运行30
error_reporting(0);//停闭错误信息
$sql="insert ignore into qr(device,serials) values('{$device}','{$serials}')";
	$request=query($sql);
	if($request){

		while(1){
		$r=query("SELECT  uid FROM  qr WHERE device={$device} and serials={$serials} LIMIT 1 ");
		if ($r && ($record = $r->fetch_assoc()) != false)
		{
			 $uid= $record['uid'];
			$uid_select=query("SELECT  uid,nickname,state,country,province,cover,city,gender,interest,disease,settings,signature,username,birthday,height,weight,email,image FROM user WHERE uid='{$uid}' LIMIT 1");
			while ($uid_select && ($row = $uid_select->fetch_assoc())!=false)
				
						{
							$user[] = $row;
						}
						if (count($user))
						{
							//print_r($user['nickname']);
							echo json_encode($user[0]);
							//删除数据
							$res=query("delete from qr where uid = {$uid}");
							return 0;
						}
		}
		   ob_end_flush();//关闭缓存
		   print str_repeat(" ", 4096);
		   ob_flush(); //强制将缓存区的内容输出
		   flush(); //刷新并输出PHP缓冲数据
		   sleep(1); //延迟3秒
				
				}

	}


function time_out_callback()
{
    if(connection_status()!= 0)
    {	
    	$devi=$_REQUEST['device'];
    	//连接超时、删除记录
		$res=query("delete from qr where device = {$devi}");
        exit(json_encode(array("code"=>1010,"result"=>"请求超时","message"=>"请求超时"))); 
    }

   
}

	}


?>
