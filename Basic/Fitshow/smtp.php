<?php
	include_once("smtp.class.php");
	require_once 'dbase.php';
	include 'conn.php';

	//获取验证码函数
	function getVerify() {
		session_start();
		$name=strtolower($_REQUEST['email']);
		
		$l = getString('l');
		if (preg_match("/^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i", $name))
		{
			//判断用户是否有邮箱
			$email = query("select username from user where username='{$name}'");
			$row = $email->fetch_assoc();
			
			if ($row['username']) {
				
				$smtpserver = "smtp.qq.com";//服务器
				$smtpserverport =25;//服务器端口
				$smtpusermail = "feedback@ifitshow.com";//用户邮箱
				$smtpemailto = $name;//发送给谁
				$smtpuser = "feedback@ifitshow.com";//用户帐号
				$smtppass = "Fitshow001";//用户密码
				
				$mailsubject = L("Reset Password", $l);//邮件主题
				$rand = randStr(6,'NUMBER');
				
				if ($l == 'en') {
					$a = "<div>Hello, Dear $name";
				} else {
					$a = "<div>".L("Dear", $l).$name.",".L("hello",$l)."</div>";
				}
				
				$b = "<div>".L("Code Is", $l)."<span style='color:red'>$rand</span></div>";
				$c = "<div>".L("Copy Code Set Password", $l)."</div>";
				$d = "<div>".L("A Email For Message", $l)."</div>";
				$e = "<div style='height:10px; border-bottom:1px dashed;width:300px;'></div>";
				
				$mailbody = $a.$b.$c.$d.$e;//邮件内容
				$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
				$smtp= new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
				$smtp->debug = false;//是否显示发送的调试信息
				$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
				
				$_SESSION['verify'] = $rand;
				$_SESSION['email'] = $name;
				$json = array(
					'ret'=>0,
					'data'=>$rand,				
				);
				
				exit (json_encode($json));
				
			}
			exit(json_encode(array("ret"=>2,"data"=>"your email isn't username")));
		}
		echo json_encode(array("ret"=>1,"data"=>"illegal email"));
		exit();
	}
	
	//判断验证码是否正确
	function check_verify() {
		session_start(600);
// 		$ran = $_COOKIE['verify'];
		//客户端输入的值
		$verify = $_REQUEST['rand'];
		if ($verify == $_SESSION['verify']) {
			echo json_encode(array("ret"=>0,"data"=>"last update password"));
			return 0;
		}
		return 1;
	}
	
	//修改密码
	function alter() {
		global $link;
		$username = strtolower(htmlspecialchars($_REQUEST['email']));
		$password = htmlspecialchars($_REQUEST['password']);
		if (isset($username) && isset($password))
		$sql ="update user set password = '".$password."' where username = '".$username."'";
		query($sql);
		if ($link->affected_rows) {
			echo json_encode(array("ret"=>0,"data"=>"update success"));
			return 0;
		}
		return 1;
	}
	
	//verify()
	function getSixRand() {
		$name = strtolower($_REQUEST['username']);
		$l = getString('l');
		if (preg_match("/^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i", $name))
		{
			$u = query("select uid from user where username='{$name}'")->fetch_assoc();
			if ($u['uid'])
			{
				exit(json_encode(array("code"=>1102,"msg"=>"already register")));
			}
			else
			{
				$smtpserver = "smtp.qq.com";//服务器
				$smtpserverport =25;//服务器端口
				$smtpusermail = "feedback@ifitshow.com";//用户邮箱
				$smtpemailto = $name;//发送给谁
				$smtpuser = "feedback@ifitshow.com";//用户帐号
				$smtppass = "Fitshow001";//用户密码
				$mailsubject = L("Code Information", $l);//邮件主题
				$rand=randStr(6,'NUMBER');
				if ($l == 'en') {
					$a = "<div>Hello, Dear $name";
				} else {
					$a = "<div>".L("Dear", $l).$name.",".L("hello",$l)."</div>";
				}
				
				$b = "<div>".L("Code Is", $l)."<span style='color:red'>$rand</span></div>";
				$c = "<div>".L("Copy Code Set Password", $l)."</div>";
				$d = "<div>".L("A Email For Message", $l)."</div>";
				$e = "<div style='height:10px; border-bottom:1px dashed;width:300px;'></div>";
						
				$mailbody = $a.$b.$c.$d.$e;//邮件内容
				$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
				$smtp= new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
				$smtp->debug = false;//是否显示发送的调试信息
				$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
				$_SESSION['verify'] = $rand;
				$_SESSION['email'] = $name;
				$json=array(
						'code'=>0,
						'data'=>$rand,
				);
				exit (json_encode($json));
			}
			
		}
		else 
		{
			exit(json_encode(array('code'=>1101,"msg"=>"no email")));
		}
	}
	
	//邮箱注册
	function register() 
	{
		global $link;
		$name = strtolower(getString('username'));
		$pass = getString('password');
		$time = date('Y-m-d');
		$appkey = isset($_REQUEST['appkey']) ? strtolower($_REQUEST['appkey']) : 'fitshow' ;
		if (preg_match("/^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i", $name))
		{
			if (strlen($pass) >= 6 && strlen($pass) <=20)
			{
				$result = query("select uid from `user` where username='{$name}'")->fetch_assoc();
				if ($result['uid']) 
				{
					exit(json_encode(array("code"=>1100,"msg"=>"already register")));
				}
				else 
				{
					$nickname = "FitShow_".randStr(6,"NUMBER");
					$sql = "insert into `user` set username='{$name}',
					password='{$pass}',regdate='{$time}',nickname='{$nickname}',appkey='{$appkey}'";
					$register = query($sql);
					$uid = $link->insert_id;
					$data = array();
					$user = query("select * from user where uid={$uid}");
					if ($user && ($row = $user->fetch_assoc()))
					{
						unset($row['appkey']);
						$row['email'] = $name;
						$row['newuser'] = 1;
						$data[] = $row;
					}
					echo json_encode(array("code"=>0,"msg"=>"success","result"=>$data));
					exit();
				}
				
			}
			else 
			{
				echo json_encode(array("code"=>1102,"msg"=>"password length is 6-20"));
				exit();
			}
		}
		else 
		{
			echo json_encode(array("code"=>1101,"msg"=>"username is illegal email"));
			exit();
		}
	}
	
switch (strtolower(@$_REQUEST['method'])) {
	case 'getverify':
		getVerify();
		break;
	case 'check':
		if (check_verify())
			echo json_encode(array("ret"=>1,"data"=>"verify error"));
		break;
	case 'alter':
		if (alter())
			echo json_encode(array("ret"=>1,"data"=>"password same"));
		break;
	case 'rand':
		getSixRand();
		break;
	case 'register':
		register();
		break;
		
	default:
		echo json_encode(array("err"=>100,"msg"=>"unknow method!"));
}
?>


