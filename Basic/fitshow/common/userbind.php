<?php 
include_once 'dbase.php';
include 'conn.php';
include_once 'Response.php';
include 'smtp.class.php';
require_once __DIR__.'/lib/ErrorCode.php';
require_once __DIR__.'/lib/Mcrypt.php';
global $pdo;
date_default_timezone_set("PRC");

define("MAILACCOUNT", "info@ifitshow.com");
define("MAILPASSWORD", "x4BJBUSt8AN6DQhr");
define("MAILSERVER", "ssl://smtp.exmail.qq.com");
define("MAILPORT", 465);

switch (strtolower($_REQUEST['method']))
{
	case 'bind': //第三方绑定
		UserBind::binduser();break;
		
	case 'revoke': //解除绑定测试已完成(邮箱|手机必须存其一)
		UserBind::revokebind();break;
		
	case 'semail': //设置中邮箱绑定
		UserBind::settingemail();break;
	
	case 'sphone': //设置中手机绑定
		UserBind::settingphone();break;
	
	case 'email': //注册邮箱绑定
		UserBind::bindemail();break;
	
	case 'register': // 邮箱注册
		UserBind::register(); break;
		
	case 'phone': //注册手机绑定
		UserBind::bindphone();break;
	
	case 'verify': // 验证码验证功能
		$uid = getString('uid');
		$code = getString('code');
		$flag = getString('flag'); 
		$l = getString('l');
		UserBind::verify($uid, $code, $flag, $l); break;
		
	case 'login': //第三方登录
		UserBind::thirdParty();break;
	
	case 'info': //绑定状况(已完成测试)
		UserBind::bindinfo();break;
	
	case 'code': // 获取验证码
		$username = getString('username');
		$flag = getString('flag');
		$l = getString('l');
		$app = getString('app');
		UserBind::getRand($username, $flag, $l, $app); break;
	
	case 'forget': // 忘记密码
		$username = getString('username');
		$password = getString('password');
		$code = getString('code');
		$l = getString('l');
		UserBind::forget($username, $password, $code, $l); break;
		
	default:
		Response::err(990, "unknown method!");
		break;
}

/**
 * 用户绑定相关类
 * @author <tsaiming6@163.com>
 * Note:用户绑定用于用户第三方平台登录
 */
class UserBind {
	const USERID = '3544';
	const ACCOUNT = 'fitshow';
	const PASSWORD = '786XcM6w';
	public $mobile;
	public $content;
	
	/**
	 * 用户第三方绑定接口
	 * @param integer $uid 当前登录用户
	 * @param string $app appkey
	 * @param string $platform 平台
	 * @return object json对象
	 * Note:第三方平台绑定(1、从未绑定;2、已绑定过但是取消绑定了)
	 */
	public static function binduser() {
		global $uid,$link;
		$app = strtolower($_REQUEST['app']);
		$form = getString('platform');
		$plat = strtolower(substr($form, 0, 2));
		
		$time = date('Y-m-d H:i:s');
		
		//登录
		if (isUser($uid)) 
		{
			//判断该平台数据是否已经绑定了
			$result = query("SELECT uid,platform from user_bind WHERE
				appkey='{$app}' and platform='{$form}'");
			$row = $result->fetch_assoc();
			
			if ($row['uid']) 
			{ //表中有记录
			 	Response::err(1102, "already bind ".$plat);
			}
			else 
			{ //表中无记录
				//第一次绑定该平台
				query("INSERT INTO user_bind SET uid=$uid,appkey='{$app}',
					platform='{$form}',plat='{$plat}',datetime='{$time}'");
				Response::err(0, "bind ".$plat." success");
			} 
		}
		else
		{
			Response::err(1100, "please login");
		}
	}

	/**
	 * 用户取消绑定接口
	 * @param integer $uid 当前登录用户
	 * @param string $app appkey
	 * @param string $plat 平台
	 * @param object json对象
	 * Note:取消绑定(1、从未绑定请绑定;2、取消)
	 */
	public static function revokebind() {
		global $uid;
		$app = strtolower(($_REQUEST['app']));
		$plat = getString('plat');
		$time = date('Y-m-d H:i:s');
		
		# 验证用户合法性
		if (!isUser($uid))
			Response::err(1100, "please login");
		
		# 无效参数
		if (!in_array($plat, array('email','phone','qq','wx','wb')))
			Response::err(1101, "Invalid param");
		
		# 查询用户是否同时绑定了邮箱和手机
		if (in_array($plat, array('email', 'phone'))) 
		{
			$query = "select * from user_bind where uid=$uid and appkey='$app'";
			$result = query($query);
			if ($result->num_rows != 2)
				Response::err(1103, "phone|email have one");
			
			# 解除对应的flag标识 sql语句
			$revoke = "delete from user_bind where uid=$uid and plat='$plat' and appkey='$app'";
			# 获取当前用户的用户名
			$user = "select platform from user_bind where uid=$uid and plat<>'$plat' and appkey='$app'";
			$u = query($user)->fetch_assoc();
			$username = $u['platform'];
			
			# 邮箱用户名然后解除绑定
			query("update `user` set username='$username' where uid=$uid limit 1");
			query($revoke);
			Response::err(0, "revoke success");
		} else 
		{
			query("delete from user_bind where uid=$uid and plat='$plat' and appkey='{$app}'");
			Response::err(0, "revoke success");
		}
	}
	
	/**
	 * 第三方登录
	 * @param string $platform 平台数据
	 * @
	 */
	public static function thirdParty() {
		$platform = getString('platform');
		$app = getString('app');
		//判断该平台是否已经绑定了
		$first = "SELECT uid FROM user_bind WHERE platform='{$platform}' and appkey='{$app}' limit 1";
		$firstValue = query($first)->fetch_assoc();
		
		$uid = $firstValue['uid'];
		if ($uid)
		{   //已经绑定了该平台直接登录
			$user = query("select * from user where uid={$uid} limit 1");
			if ($user && ($row = $user->fetch_assoc()))
			{
				$row['photo'] = $row['image'];
				$data[] = $row;
			}
			echo json_encode($data[0]);  
			exit();
		}
		else
		{
			Response::err(1100, "the first register/login");
		}
	}
	
	/**
	 * 设置中绑定邮箱
	 * @param integer $uid 登录用户ID
	 * @param string $app app
	 * @param string $name 邮箱
	 * @return object json对象
	 */
	public static function settingemail() {
		global $uid;
		$name = getString('email');
		$app = strtolower($_REQUEST['app']);
		$l = getString('l');
		
		query("call clear()");
		if (isUser($uid)) 
		{
			if (empty($name)) {
				Response::err(ErrorCode::EMAIL_CANNOT_EMPTY, L("Email Cannot Empty", $l));
			}
			$encryption = new MCrypt();
// 			// 解密结果为
			$code = $encryption->decrypt($name);
	
			// 将解密结果转为数组
			$arr = explode("_", $code);
			$email = $arr[0];
			$array = explode("@", $email);
			$_name = $array[0];
			$emailName = $arr[1];
			if ($_name == $emailName) 
			{
				$reg = " /^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i ";
				if (preg_match($reg, $email)) 
				{
					// 判断邮箱是否在绑定表中
					$query = <<<EOF
	SELECT uid FROM `user_bind` WHERE platform='$email' LIMIT 1; 
EOF;
					$isExists = query($query)->fetch_assoc();
					if ($isExists['uid']) {
						Response::err(ErrorCode::USERNAME_EXISTS, L("Email Exists", $l));
					} else {
						// 邮箱未绑定
						$time = time();
						// 判断邮箱短信是否存在该邮箱记录
						$code = query("select * from `user_verify` where username='$email' limit 1")->fetch_assoc();
						$id = $code['id'];
						if ($id) 
						{
							// 存在记录
							$timestamp = $code['createAt'];
							
							$diff = 120 - ($time - $timestamp);
							echo json_encode(array('uid'=>$uid, 'timestamp'=>$diff));
							return;
						
						} else {
							// 第一次发送验证码
							$smtpserver = MAILSERVER;//服务器
							$smtpserverport = MAILPORT;//服务器端口
							$smtpusermail = MAILACCOUNT;//用户邮箱
							$smtpemailto = $email;//发送给谁
							$smtpuser = MAILACCOUNT;//用户帐号
							$smtppass = MAILPASSWORD;//用户密码
						
							$mailsubject = L("Code Information", $l);;//邮件主题
							$rand = randStr(6,'NUMBER');
							if ($l == 'en') {
								$a = "<div>Hello, Dear $email";
							} else {
								$a = "<div>".L("Dear", $l).$email.",".L("hello",$l)."</div>";
							}
							
							$b = "<div>".L("Code Is", $l)."<span style='color:red'>$rand</span></div>";
							$c = "<div>".L("Copy Code Set Password", $l)."</div>";
							$d = "<div>".L("A Email For Message", $l)."</div>";
							$e = "<div style='height:10px; border-bottom:1px dashed;width:300px;'></div>";
							
							$mailbody = $a.$b.$c.$d.$e;//邮件内容
							$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
							$smtp= new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
							$smtp->debug = false;//是否显示发送的调试信息
							$res = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

							if (!$res) {
								Response::err(ErrorCode::CODE_SEND_FAILED, L("Send Failed", $l));
							} else {

								query("insert into `user_verify` set id=$uid,username='$email',appkey='$app',
									plat='email',code='$rand',createAt='$time'");
								echo json_encode(array('uid'=>$uid, 'timestamp'=>120));
								return;
							}
						}
					}
				} else {
					Response::err(ErrorCode::EMAIL_INVALID, L("Email Invalid", $l));
				}
			} 
			else
			{
				Response::err(ErrorCode::EMAIL_INVALID, L("Email Invalid", $l));
			}
		}
		else
		{
			Response::err(ErrorCode::USER_INVALID, L("User Invalid", $l));
		}
	}

	/**
	 * 设置中绑定手机
	 * @param integer $uid 登录用户ID
	 * @param string $app app
	 * @param string $name 手机
	 * @return object json对象
	 */
	public static function settingphone() {
		global $link;
		$uid = getString('uid');
		$app = strtolower($_REQUEST['app']);
		$name = getString('mobile');
		$rand = randStr(6, 'NUMBER');
		
		// 清空两分钟之前的验证信息
		query("call clear()");
		$l = getString('l');
		
		if (isUser($uid)) 
		{
			if (empty($name)) {
				Response::err(ErrorCode::MOBILE_CANNOT_EMPTY, L("Mobile Cannot Empty", $l));
			}
			$encryption = new MCrypt();
			// 解密结果为
			$encrypt = $encryption->decrypt($name);
			$arr = explode("_", $encrypt); // 将解密结果转为数组
			
			$phone = $arr[0];
			if ($phone == $arr[1]) {
				if (preg_match('/^1[34578]\d{9}$/i', $phone)) {
					// 判断手机是否在绑定表中
					$query = <<<EOF
	SELECT uid FROM `user_bind` WHERE platform='$phone' LIMIT 1;
EOF;
	
					$isExists = query($query)->fetch_assoc();
					
					// 手机存在且绑定成功
					if ($isExists['uid']) {
						Response::err(ErrorCode::USERNAME_EXISTS, L("Mobile Exists", $l));
					} else {
						$time = time();
						// 手机未绑定
						// 判断用户短信验证表中是否存在该手机记录
						$sql = "select * from `user_verify` where username='$phone' limit 1";
						
						$code = query($sql)->fetch_assoc();
						
						$id = $code['id'];
						if ($id)
						{ // 存在记录
							$timestamp = $code['createAt'];
							
							$diff = 120 - ($time - $timestamp);
							echo json_encode(array('uid'=>$uid, 'timestamp'=> $diff));
							return;
						} else {
							$post_data['userid'] = self::USERID;
							$post_data['account'] = self::ACCOUNT;
							$post_data['password'] = self::PASSWORD;
							if ($app == 'konlega') {
								$post_data['content'] = '【康乐佳】您的验证码是'.$rand.',两分钟有效,请勿泄露';
							} elseif ($app == 'aeonfit') {
								$post_data['content'] = '【正伦】您的验证码是'.$rand.',两分钟有效,请勿泄露';
							} else {
								$post_data['content'] = '【运动秀】您的验证码是'.$rand.',两分钟有效，请勿泄露';
							}
							
							//多个手机号码用英文半角豆号‘,’分隔
							$post_data['mobile'] = $phone;
							$url='http://sms.kingtto.com:9999/sms.aspx?action=send';
							$o='';
							foreach ($post_data as $k=>$v)
							{
								//短信内容需要用urlencode编码，否则可能收到乱码
								$o.="$k=".urlencode($v).'&'; 
							}
							$post_data=substr($o,0,-1);
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
							$result = curl_exec($ch);
							$r = simplexml_load_string($result);
							$json = json_decode(json_encode($r), true);
							if ($json['message'] == 'ok') {
								$t = time();
								query("insert into `user_verify` set id=$uid,username='$phone',
									code='$rand',createAt='$t',appkey='$app',plat='phone'");
								echo json_encode(array('uid'=>$uid, 'timestamp'=> 120));
								return;
							} else {
								return;
							}
						}
					}
				} else {
					Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Invalid", $l));
				}
			} else {
				Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Invalid", $l));
			}
		} else {
			Response::err(ErrorCode::USER_INVALID, L("User Invalid", $l));
		}
	}

	/**
	 * 邮箱绑定接口
	 * @param string $email 邮箱
	 * @param string $password 密码
	 * @param string $appkey appkey
	 * @return object json对象
	 */
	public static function register() 
	{
		global $link;
		$name = $_POST['email'];
		$pass = getString('password');
		$app = strtolower(isset($_REQUEST['app']) ? $_REQUEST['app'] : 'fitshow');
		$date = date('Y-m-d H:i:s');
		$l = getString('l'); 
		$length = strlen($pass);
		// 发送验证码前清空两分钟之前的信息
		query("call clear()");
		if (empty($name)) {
			Response::err(ErrorCode::EMAIL_CANNOT_EMPTY, L("Email Cannot Empty", $l));
		}
		if ($length < 6 || $length > 20) {
			Response::err(ErrorCode::PASSWORD_LENGTH_SETTING, L("Password Length Invalid", $l));
		}
		
		$encryption = new MCrypt();
		// 解密结果为
		$encrypt = $encryption->decrypt($name);
		// 将解密结果转为数组
		$arr = explode("_", $encrypt);
		$email = $arr[0];
		$array = explode("@", $email);
		$_name = $array[0];
		$emailName = $arr[1];
		if ($_name == $emailName)
		{
			//注册页面绑定邮箱,输入密码
			$reg = " /^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i";
			if (preg_match($reg, $email)) { 
				// 判断邮箱用户是否在用户表中或已经绑定了该邮箱
				$query = <<<EOF
SELECT uid,state FROM `user` WHERE username='$email' union
SELECT uid,state FROM `user` WHERE uid=(SELECT uid FROM `user_bind`
WHERE platform='$email' AND plat='email') LIMIT 1;
EOF;
				$isExists = query($query)->fetch_assoc();
				$id = $isExists['uid'];
				$state = $isExists['state'];
				// 邮箱存在且绑定成功
				if ($isExists['uid'] && $isExists['state']) {
					Response::err(ErrorCode::USERNAME_EXISTS, L("Email Exists", $l));
				} else {	
					// 邮箱不存在
					$nickname = isset($_REQUEST['nickname']) ? $_REQUEST['nickname'] : $email;
				
					// 手机不存在
					$sql = "insert into user set username='$email', password='$pass',
					nickname='$nickname', regdate='$date', state=0,appkey='$app'";
					
					$result = query($sql);
					
					$uid = $link->insert_id;
					if ($uid) {
						$key = $uid;
					} else {
						$key = $id;
					}
					
					$rs1 = query("select * from `user_verify` where username='$email' limit 1");
					$r1 = $rs1->fetch_assoc();
					
					if (($uid || $state == 0) && !$r1['id']) 
					{
						// 第一次发送验证码
						$smtpserver = MAILSERVER;//服务器
						$smtpserverport = MAILPORT;//服务器端口
						$smtpusermail = MAILACCOUNT;//用户邮箱
						$smtpemailto = $email;//发送给谁
						$smtpuser = MAILACCOUNT;//用户帐号
						$smtppass = MAILPASSWORD;//用户密码
						
						$mailsubject = L("Code Information", $l);;//邮件主题
						$rand = randStr(6,'NUMBER');
						if ($l == 'en') {
							$a = "<div>Hello, Dear $email";
						} else {
							$a = "<div>".L("Dear", $l).$email.",".L("hello",$l)."</div>";
						}
						
						$b = "<div>".L("Code Is", $l)."<span style='color:red'>$rand</span></div>";
						$c = "<div>".L("Copy Code Set Password", $l)."</div>";
						$d = "<div>".L("A Email For Message", $l)."</div>";
						$e = "<div style='height:10px; border-bottom:1px dashed;width:300px;'></div>";
						
						$mailbody = $a.$b.$c.$d.$e;//邮件内容
						$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
						$smtp= new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
						$smtp->debug = false;//是否显示发送的调试信息
						$res = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
						if (!$res) {
							Response::err(ErrorCode::CODE_SEND_FAILED, L("Send Failed", $l));
						} else {
							$t = time();
							query("insert into `user_verify` set id=$key,username='$email',
								code='$rand',createAt=$t,plat='email',appkey='$app'");

							echo json_encode(array('uid' => $key, 'timestamp' => 120));
							return;
						}
		
					} else {
						$rs = query("select * from `user_verify` where username='$email' limit 1");
						$r = $rs->fetch_assoc();
						$time = 120 - (time() - $r['createAt']);
						echo json_encode(array('uid'=>$key, 'timestamp'=> $time));
						return;
					}
				}
  
			} else {
				Response::err(ErrorCode::EMAIL_INVALID, L("Email Invalid", $l));
			}
		} else {
			Response::err(ErrorCode::EMAIL_INVALID, L("Email Invalid", $l));
		}
	}
	
	/**
	 * 邮箱绑定接口
	 * @param string $email 邮箱
	 * @param string $password 密码
	 * @param string $appkey appkey
	 * @return object json对象
	 */
	public static function bindemail() 
	{
		global $link,$uid;
		$name = strtolower(getString('email'));
		$pass = getString('password');
		$len = strlen($pass);
		$app = strtolower($_REQUEST['app']);
		$time = date('Y-m-d H:i:s');
		
		$user = array();
		$info = array();
		if ($len < 6 || $len > 20) {
			Response::err(1101, "password length is 6-20");
		}
		
		if (!preg_match("/^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i", $name)) {
			Response::err(1100, "not email");
		}
		// 邮箱注册接口
		$bind = "select uid from `user_bind` where platform='$name'";
		$result = query($bind)->fetch_assoc();
		if ($result['uid']) {
			Response::err(1102, "already bind");
		} else {
			// 未绑定
			$nickname = empty($_REQUEST['nickname']) ? $_REQUEST['nickname'] : "FitShow_".randStr(6,"NUMBER");
			$sql = "INSERT INTO `user` SET username='$name',password='$pass',regdate='$time',nickname='$nickname'";
			// 注册接口
			$register = query($sql);
			$uid = $link->insert_id;
			if ($uid) {
				$info = "INSERT INTO `user_bind` SET uid=$uid,appkey='$app',platform='$name',datetime='$time',plat='email'";
				$u = query("select * from user where uid=$uid limit 1");
				if ($u && ($r = $u->fetch_assoc()) != false) {
					$r['newuser'] = 1;
					$user[] = $r;
				}
				echo json_encode($user[0]);
				return;
			} else {
				// 注册失败,用户表中已存在该邮箱
				$user = query("select uid from user where username='$name' and state= 2 limit 1");
				$value = $user->fetch_assoc();
				$id = $value['uid'];
				// 绑定
				query("INSERT INTO `user_bind` SET uid=$id,appkey='$app',platform='$name',datetime='$time',plat='email'");
				$res = query("select * from `user` where uid=$id limit 1");
				if (($s = $res->fetch_assoc()) != false) {
					$info[] = $s;
				}
				echo json_encode($info[0]);
				return;
			}
		}
	}

	/**
	 * 手机绑定接口
	 * @param string $name 手机
	 * @param string $password 密码
	 * @param string $appkey appkey
	 * @return object json
	 */
	public static function bindphone() {
		global $link;
		$mobile = $_POST['mobile'];
		query("call clear()");
		$password = getString('password');
		$date = date('Y-m-d H:i:s');
		$app = strtolower(isset($_REQUEST['app']) ? $_REQUEST['app'] : 'fitshow');
		$l = getString('l');
		$length = strlen($password); // 密码长度
		
		if (empty($mobile)) {
			Response::err(ErrorCode::MOBILE_CANNOT_EMPTY, L("Mobile Cannot Empty", $l));
		}
		
		if ($length < 6 || $length > 20) {
			Response::err(ErrorCode::PASSWORD_LENGTH_SETTING, L("Password Length Invalid", $l));
		}
		
		$encryption = new MCrypt();
		$rand = randStr(6, 'NUMBER');
		// 解密结果为
		$encrypt = $encryption->decrypt($mobile);
		
		$arr = explode("_", $encrypt); // 将解密结果转为数组
		
		$phone = $arr[0];
		
		if ($phone == $arr[1]) {
			if (preg_match('/^1[3578]\d{9}$/i', $phone)) {
				//判断手机是否存在
				$query = <<<EOF
	SELECT uid,state FROM `user` WHERE username='$phone' union 
SELECT uid,state FROM `user` where uid=(select uid from `user_bind` where platform='$phone'
AND plat='phone') limit 1; 
EOF;
				
				$isExists = query($query)->fetch_assoc();
				$id = $isExists['uid'];
				$state = $isExists['state'];
				// 手机存在且绑定成功
				if ($isExists['uid'] && $isExists['state'] >= 2) {
					Response::err(ErrorCode::USERNAME_EXISTS, L("Mobile Exists", $l));
				} else {
					
					$nickname = isset($_REQUEST['nickname']) ? $_REQUEST['nickname'] : $phone;
				
					// 手机不存在
					$sql = "insert into user set username='$phone', password='$password',
					nickname='$nickname', regdate='$date', state=0,appkey='$app'";
					
					$result = query($sql);
					
					$uid = $link->insert_id;
					if ($uid) {
						$key = $uid;
					} else {
						$key = $id;
					}
					$rs1 = query("select * from `user_verify` where username='$phone' limit 1");
					$r1 = $rs1->fetch_assoc();
					
					if (($uid || ($state == 0)) && !$r1['id']) {
						$post_data['userid'] = self::USERID;
						$post_data['account'] = self::ACCOUNT;
						$post_data['password'] = self::PASSWORD;
						if ($app == 'konlega') {
							$post_data['content'] = '【康乐佳】您的验证码是'.$rand.',两分钟有效,请勿泄露';
						} elseif ($app == 'aeonfit') {
							$post_data['content'] = '【正伦】您的验证码是'.$rand.',两分钟有效,请勿泄露';
						} else {
							$post_data['content'] = '【运动秀】您的验证码是'.$rand.',两分钟有效，请勿泄露';
						}
						

						//多个手机号码用英文半角豆号‘,’分隔
						$post_data['mobile'] = $phone;
						$url='http://sms.kingtto.com:9999/sms.aspx?action=send';
						$o='';
						foreach ($post_data as $k=>$v)
						{
							//短信内容需要用urlencode编码，否则可能收到乱码
							$o.="$k=".urlencode($v).'&';
						}
						$post_data=substr($o,0,-1);
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_URL,$url);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
						$result = curl_exec($ch);
						$r = simplexml_load_string($result);
						$json = json_decode(json_encode($r), true);

						if ($json['message'] == 'ok') {
							$t = time();
							query("insert into `user_verify` set id=$key,username='$phone',
									code='$rand',createAt=$t,plat='phone',appkey='$app'");
							echo json_encode(array('uid'=>$key, 'timestamp'=> 120));
							return;
						}
					} else {
						$rs = query("select * from `user_verify` where username='$phone' limit 1");
						$r = $rs->fetch_assoc();
						$time = 120 - (time() - $r['createAt']);
						echo json_encode(array('uid'=>$key, 'timestamp'=>$time));
						return;
					}
				}
			}
			else {
				Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Invalid", $l));
			}
		}
		else {
			Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Invalid", $l));
		}
	}
	
	/**
	 * 验证验证码是否正确
	 * @param unknown_type $uid 用户ID
	 * @param unknown_type $code 验证码
	 */
	public static function verify($uid, $code, $flag, $l = 'en') {
		query("call clear()");
		$sql = "select * FROM `user_verify` WHERE id=$uid and plat='$flag' limit 1";
		
		$result = query($sql)->fetch_assoc();
		if (!$result['id']) {
			Response::err(ErrorCode::CODE_INVALID, L("Code Not Found", $l));
		} else {
			$app = $result['appkey'];
			$username = $result['username'];
			$plat = $result['plat'];
			$date = date('Y-m-d H:i:s',time());
			
			if ($result['code'] != $code) {
				Response::err(ErrorCode::CODE_INVALID, L("Code Invalid", $l));
			} else {
				query("update `user` set state =2,regdate='$date' where uid=$uid limit 1");
				query("insert into `user_bind` SET uid=$uid,appkey='$app',datetime='$date',
						platform='$username',plat='$flag'");
				Response::err(ErrorCode::SUCCESS, L("Code Correct", $l));
			}
		}
	}
	
	/**
	 * 绑定信息
	 * @param integer $uid
	 * @return object json
	 */
	public static function bindinfo() {
		global $uid;
		
		$info = array();
		
		if (isUser($uid)) 
		{
			$sql = "select platform,plat from user_bind where uid=$uid";
			$result = query($sql);
			$arr = array(
				"phone"=>0,
				"email"=>0,
				"qq"=>0,
				"wx"=>0,
				"fb"=>0,
				"wb"=>0,
				"tw"=>0,
			);
			while (($row = $result->fetch_assoc())!=false) 
			{
				if (in_array($row['plat'], array_keys($arr))) 
				{
					if ($row['plat'] == 'email' || $row['plat'] == 'phone') 
					{
						$arr[$row['plat']] = 1;
						$arr[$row['plat'].'_value'] = $row['platform'];
					}
					else
					{
						$arr[$row['plat']] = 1;
					}
				}
			}
			if (count($arr)) 
			{
				echo json_encode($arr);
				exit();
			}
			else
			{
				Response::err(1101, "no bind thrid-party");
			}
			
		}
		else
		{
			Response::err(1100, "please login");
		}
	}
	
	public static function getRand($username, $flag, $l, $app='fitshow') {
		global $link;
		$encryption = new MCrypt();
		$name = $encryption->decrypt($username);
		$nameInfo = explode("_", $name);
		switch ($flag) {
			case 'email':
				if (empty($username)) {
					Response::err(ErrorCode::EMAIL_CANNOT_EMPTY, L("Email Cannot Empty", $l));
				}
				$email = $nameInfo[0];
				$arr = explode("@", $email);
				$reg = " /^\\s*\\w+(?:\\.{0,1}[\\w-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\\.[a-zA-Z]+\\s*$/i ";
				if ($arr[0] != $nameInfo[1] || !preg_match($reg, $email)) {
					Response::err(ErrorCode::EMAIL_INVALID, L("Email Invalid", $l));
				}
				// 处理两分钟之前的验证码信息
				query("call clear()");
				$sql = "select * from `user_verify` where username='$email' limit 1";
				$result = query($sql)->fetch_assoc();
				if ($result['id']) {
					$time = 120 - (time() - $result['createAt']);
					echo json_encode(array("uid"=>$result['id'],"timestamp"=>$time));
					return; 
				} else {
					// 获取手机的uid
					$bind = "select uid from user where username='$email' and state =2 union
					select uid from `user_bind` where platform='$email' and plat='email' limit 1";
					
					$user = query($bind)->fetch_assoc();
					$uid = $user['uid'];
					if (!$uid) {
						Response::err(ErrorCode::EMAIL_INVALID, L("Email Not Exists", $l));
					}
						$smtpserver = MAILSERVER;//服务器
						$smtpserverport = MAILPORT;//服务器端口
						$smtpusermail = MAILACCOUNT;//用户邮箱
						$smtpemailto = $email;//发送给谁
						$smtpuser = MAILACCOUNT;//用户帐号
						$smtppass = MAILPASSWORD;//用户密码
						
						$mailsubject = L("Code Information", $l);;//邮件主题
						$rand = randStr(6,'NUMBER');
						if ($l == 'en') {
							$a = "<div>Hello, Dear $email";
						} else {
							$a = "<div>".L("Dear", $l).$email.",".L("hello",$l)."</div>";
						}
						
						$b = "<div>".L("Code Is", $l)."<span style='color:red'>$rand</span></div>";
						$c = "<div>".L("Copy Code Set Password", $l)."</div>";
						$d = "<div>".L("A Email For Message", $l)."</div>";
						$e = "<div style='height:10px; border-bottom:1px dashed;width:300px;'></div>";
						
						$mailbody = $a.$b.$c.$d.$e;//邮件内容
						$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
						$smtp= new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
						$smtp->debug = false;//是否显示发送的调试信息
						$res = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
						if (!$res) {
							Response::err(ErrorCode::CODE_SEND_FAILED, L("Send Failed", $l));
						} else {
							$t = time();
							query("insert into `user_verify` set id=$uid,username='$email',
								code='$rand',createAt=$t,plat='email',appkey='fitshow'");

							echo json_encode(array("uid" => $uid, "timestamp" => 120));
							return;
						}
				}
				break;
			case 'phone':
				if (empty($username)) {
					Response::err(ErrorCode::MOBILE_CANNOT_EMPTY, L("Mobile Cannot Empty", $l));
				}
				$phone = $nameInfo[0];
				if ($phone != $nameInfo[1] || !preg_match('/^1[34578]\d{9}$/', $phone)) {
					Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Invalid", $l));
				}
				// 处理两分钟之前的验证码信息
				query("call clear()");
				$sql = "select * from `user_verify` where username='$phone' limit 1";
				$result = query($sql)->fetch_assoc();
				if ($result['id']) {
					$time = 120 - (time() - $result['createAt']);
					echo json_encode(array("uid"=>$result['id'],"timestamp"=>$time));
					return;
				} else {
					// 获取手机的uid
					$bind = "select uid from user where username='$phone' and state =2 union 
						select uid from `user_bind` where platform='$phone' and plat='phone' limit 1";
					$user = query($bind)->fetch_assoc();
					$uid = $user['uid'];
					if (!$uid) {
						Response::err(ErrorCode::MOBILE_INVALID, L("Mobile Not Exists", $l));
					}
					$rand = randStr(6, 'NUMBER');
					$post_data['userid'] = self::USERID;
					$post_data['account'] = self::ACCOUNT;
					$post_data['password'] = self::PASSWORD;
					if ($app == 'konlega') {
						$post_data['content'] = '【康乐佳】您的验证码是'.$rand.',两分钟有效,请勿泄露';
					} elseif ($app == 'aeonfit') {
						$post_data['content'] = '【正伦】您的验证码是'.$rand.',两分钟有效,请勿泄露';
					} else {
						$post_data['content'] = '【运动秀】您的验证码是'.$rand.',两分钟有效，请勿泄露';
					}
					
					
					//多个手机号码用英文半角豆号‘,’分隔
					$post_data['mobile'] = $phone;
					$url='http://sms.kingtto.com:9999/sms.aspx?action=send';
					$o='';
					foreach ($post_data as $k=>$v)
					{
						//短信内容需要用urlencode编码，否则可能收到乱码
						$o.="$k=".urlencode($v).'&';
					}
					$post_data=substr($o,0,-1);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
					$result = curl_exec($ch);
					$r = simplexml_load_string($result);
					$json = json_decode(json_encode($r), true);
					
					if ($json['message'] == 'ok') {
						$t = time();
						query("insert into `user_verify` set id=$uid,username='$phone',
								code='$rand',createAt=$t,plat='phone',appkey='fitshow'");
						
						echo json_encode(array("uid"=>$uid,"timestamp"=>120));
						return; 
					}
				}
				break;
			default:
				Response::err(ErrorCode::USERNAME_FLAG, L("Username Flag", $l));
				break;
		}
	}
	
	
	public static function forget($username, $password, $code, $l) {
		global $link;
		
		$length = strlen($password);
		if ($length < 6 || $length > 20) {
			Response::err(ErrorCode::PASSWORD_LENGTH_SETTING, L("Password Length Invalid", $l));
		}
		// 获取验证码信息
		$sql = "SELECT * FROM `user_verify` WHERE  username='$username' LIMIT 1";
		$result = query($sql)->fetch_assoc();
		$uid = $result['id'];
		if (!$result['id']) {
			Response::err(ErrorCode::CODE_NOT_FOUND, L("Code Not Found", $l));
		} else {
			if ($result['code'] == $code) {
				// 修改密码
				query("UPDATE `user` SET password='$password' WHERE uid=$uid LIMIT 1");
				if ($link->affected_rows) {
					echo json_encode(array("code"=>ErrorCode::SUCCESS,"msg"=>L("Update Success Password", $l)));
					return;
				} else {
					// 跟之前密码一样
					echo json_encode(array("code"=>ErrorCode::SUCCESS,"msg"=>L("Update Success Password", $l)));
					return;
				}
			} else {
				Response::err(ErrorCode::CODE_INVALID, L("Code Invalid", $l));
			}
		}
	}
}

?>