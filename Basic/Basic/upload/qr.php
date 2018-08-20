<?php
header ( "Content-Type:text/html;charset=utf-8" );
error_reporting ( 0 );

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


?>
