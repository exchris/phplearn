<?php
header ( "Content-Type:text/html;charset=utf-8" );
error_reporting ( 0 );
include '../api/dbase.php';
/**
 *
 * @return 
 * 			����ȫ�ֱ���$user_agent,$lang
 * @param 
 * 			$user_agent ��ȡ�����ߵĿͻ���ϵͳ       	
 * @param 
 * 			$lang ��ȡϵͳ��Ĭ�����ԣ�ȥ����ͷ����ǰ2λ       	
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
	
	//�жϿͻ�������   ����
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
	// �����͑�������
	else 
	{
		// $lang = substr ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'], 0, 4 );
		// �жϿͻ��������ǲ������ģ��������ת��Ӧ�ñ���������Ǿ���ת���ȸ��г�
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
		//�ֻ�ɨ��ʱ�ӿ�
if(is_array($_REQUEST)&&count($_REQUEST)>0)//���ж��Ƿ�ͨ��REQUEST��ֵ��
    {
if(isset($_REQUEST['uid'])){
    $uid=$_REQUEST['uid'];
    $se=$_REQUEST['s'];
    $de=$_REQUEST['m'];
    
      $res_se=query("SELECT  device FROM qr where serials=$se and device=$de");
      if ($res_se && ($re = $res_se->fetch_assoc()) != false)
		{
			query("UPDATE qr SET uid='$uid' where serials=$se and device=$de");
			exit(json_encode(array("code"=>200,"result"=>"��¼�ɹ�","message"=>"��¼�ɹ�")));
		}
	  	 //exit(json_encode(array("code"=>1000,"result"=>"û���ܲ���¼","message"=>"û���ܲ���¼")));
	  

     

echo "<script>window.location.href='http://www.ifitshow.com/qr/';</script>";
   return 0;
}
//�ܲ������ܵĽӿ�
}



$device=$_REQUEST['m'];
$serials=$_REQUEST['s'];
$es = ini_get('error_reporting');
register_shutdown_function( "time_out_callback");
set_time_limit(30); //����30
error_reporting(0);//ͣ�մ�����Ϣ
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
							//ɾ������
							$res=query("delete from qr where uid = {$uid}");
							return 0;
						}
		}
		   ob_end_flush();//�رջ���
		   print str_repeat(" ", 4096);
		   ob_flush(); //ǿ�ƽ����������������
		   flush(); //ˢ�²����PHP��������
		   sleep(1); //�ӳ�3��
				
				}

	}


function time_out_callback()
{
    if(connection_status()!= 0)
    {	
    	$devi=$_REQUEST['device'];
    	//���ӳ�ʱ��ɾ����¼
		$res=query("delete from qr where device = {$devi}");
        exit(json_encode(array("code"=>1010,"result"=>"����ʱ","message"=>"����ʱ"))); 
    }

   
}

	}


?>
