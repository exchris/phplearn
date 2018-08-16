<?php
require_once './dbase.php';
require_once './response.php';
require_once __DIR__.'api/lib/ErrorCode.php';
$lang = array();
$l = $_REQUEST['lang'] ? $_REQUEST['lang'] : 'zh'; // 默认中文
include 'locale/errorjson/'.$l.'.php';

class SMS {
	const USERID = '3544';
	const ACCOUNT = 'fitshow';
	const PASSWORD = '786XcM6w';
	public $mobile;
	public $content;

	public function getSMS() {
		global $lang;
		$mobile = getString('mobile');
		$username = getString('username');
		
		// 手机号码不能为空
		if (empty($mobile)) {
			return Response::err(ErrorCode::MOBILE_CANNOT_EMPTY, "手机号码不能为空");	
		}
		
		
		
		// 在设置中
		
		
		if (isset($mobile)) {
			if (preg_match('/^1[3578]\d{9}$/i', $mobile)) {
				//判断该手机号码是否存在对应用户
				$phone = query("select uid from user where username ='{$mobile}' union select 
					uid from user_bind where platform='$mobile' and plat='phone'")->fetch_assoc();
				if ($phone['uid']) {
					//该手机号码已经存在
					echo Response::err(1, $lang['You enter the account has been registered']);
					return ;
				} else {
					$rand = randStr(6,'NUMBER');
					$arr = array(
							'userid' => self::USERID ,
							'account' => self::ACCOUNT,
							'password' => self::PASSWORD,
							'mobile' => $mobile,
							'content' => '【运动秀】'.'您的验证码是'.$rand.',2分钟有效，请勿泄露'
					);
					$params ='';
					foreach ($arr as $key=>$value) {
						$params .="&";
						$params .= $key."=";
						$params .= urlencode($value);
					}
					
					$ip = getIP();
					define('MAX_COUNT', 1);
					//首先判断客户端请求的ip是否已经存在
					$sql = "select count(*)as counts from ip where ip='$ip' limit 1 ";
					
					$result = query($sql)->fetch_assoc();
					
					if ($result['counts']>MAX_COUNT){
						return json_encode(array('code'=>1,'msg'=>'同一IP只能访问5次'));
					} else {
						//判断当前手机今天有几条数据
						$now = date('Y-m-d'); //今日日期
						$q = "select count(*) as s from ip where mobile='$mobile' and date='$now'";
						
						$rs = query($q)->fetch_assoc();
						if($rs['s']>MAX_COUNT){
							return json_encode(array('code'=>2,'msg'=>'同一手机一天只能访问5次'));
						} else {
							session_start();
							$time = time();
							define('TIME_OUT', 120);
							if (isset($_SESSION['time'])) {
								if (($time - $_SESSION['time']) <= TIME_OUT) {
									return json_encode(array('code'=>3,'msg'=>'验证码2分钟有效'));
								}
							} else {
								$url = "";
							
								query("insert into ip set date='$now',ip='$ip',mobile='$mobile',appkey='fitshow'");
								$file = file_get_contents($url);
								$xml = simplexml_load_file($file);
								$json = json_encode(array('code'=>0,'data'=>$rand));
								return $json;
							}
							
						}
					}
				}
			
			} else {
				echo Response::err(2, $lang["Please enter the correct format"]);
				return ;
			}
		} else {
			echo Response::err(3, $lang["Please fill in complete information"]);
			return;
		}
	}
	
	public function message() {
		global $lang;
		$mobile = getString('mobile');
		if (isset($mobile)) {
			if (preg_match('/^1[3578]\d{9}$/i', $mobile)) {
				//判断该手机号码是否存在对应用户
				$phone = query("select uid from user where username ='{$mobile}'")->fetch_assoc();
				if ($phone['uid']) {
					$rand = randStr(6,'NUMBER');
					$arr = array(
							'userid' => self::USERID ,
							'account' => self::ACCOUNT,
							'password' => self::PASSWORD,
							'mobile' => $mobile,
							'content' => '【运动秀】'.'您的验证码是'.$rand.',2分钟有效，请勿泄露'
					);
					$params ='';
					foreach ($arr as $key=>$value) {
						$params .="&";
						$params .= $key."=";
						$params .= urlencode($value);
					}
					$url = "http://sms.kingtto.com:9999/sms.aspx?action=send";
	
					$file = file_get_contents($url);
					$xml = simplexml_load_file($file);
					$json = json_encode(array('code'=>0,'data'=>$rand));
					echo $json;
					return ;
				} else {
					echo Response::err(1, $lang['Account does not exist']);
					return;
				}
					
			} else {
				echo Response::err(2, $lang['Please enter the correct format']);
				return ;
			}
		} else {
			echo Response::err(3, $lang['Please fill in complete information']);
			return;
		}
	}
	
	public function register() {
		global $link,$lang;
		$mobile = getString('username');
		$password = getString('password');
		$time = date('Y-m-d H:i:s');
		$user = array();
		if (strlen($mobile)>=1) {
			if (preg_match('/^1[3578]\d{9}$/i', $mobile)) {
				$phone = query("select uid from user where username = '{$mobile}'")->fetch_assoc();
				if ($phone['uid']) {
					echo Response::err(1, $lang['You enter the account has been registered']);
					return;
				} else {
					if (strlen($password) >= 6) {
						
						query("INSERT INTO user set username='{$mobile}',password='{$password}',
						nickname='{$mobile}',regdate='{$time}'");
						$uid = $link->insert_id;
						$u = query("select * from user where uid=$uid limit 1");
						if ($u && ($r = $u->fetch_assoc())!=false) {
							$r['newuser'] = 1;
							$user[] = $r;
						}
						echo Response::json(0, "success", $user);
						return;
					} else {
						echo Response::err(4, $lang['Invalid password']);
						return ;
					}
				}
			} else {
				echo Response::err(2, $lang['Please enter the correct format']);
				return ;
			}
		} else {
			echo Response::err(3, $lang['Please fill in complete information']);
			return ;
		}
	}
	
	/**
	 * 修改密码
	 * @var string $username
	 * @var string $password
	 */
	public function updatePassword() {
		global $link, $lang;
		//手机号码
		$username = getString('username');
		$password = getString('password');
		if (preg_match('/^1[3578]\d{9}$/i', $username)) {
			//判断手机号码是否注册过
			$result = query("select uid from user where username='{$username}'");
			$row = $result->fetch_assoc();
			if ($row['uid']) {
				if (strlen($password) >= 6) {
				
					//修改密码
					query("update user set password='{$password}' where username='{$username}'");
					if ($link->affected_rows) {
						Response::err(0, "update success");
					} else {
						Response::err(1, $lang['The password is the same']);
					}
				
				} else {
				
					Response::err(2, $lang['Invalid password']);
				}
			} else {
				Response::err(4, $lang['Invalid username']);
			}
			
			
		} else {
			Response::err(3, $lang['Please fill in complete information']);	
		}
		
	} 
}
$sms = new SMS();
switch (strtolower(@$_REQUEST['method'])) {
	case 'sms':
		$sms->getSMS();
		break;
	case 'message':
		$sms->message();
		break;
	case 'register':
		$sms->register();
		break;
	case 'update':
		$sms->updatePassword();
		break;
	default:
		echo Response::err(900, "no method!");
		break;
}
?>