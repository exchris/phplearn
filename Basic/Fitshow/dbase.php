<?php
header("Content-Type:text/html;charset=utf-8");
error_reporting(0);

function error($id, $msg)
{
	echo json_encode(array("err"=>$id, "msg"=>$msg));
}

function err($id, $msg)
{
	echo json_encode(array("err"=>$id, "msg"=>$msg));
}

/*================================================
 * 获取客户端IP
================================================*/
function getIP()
{
	$ip = "0.0.0.0";

	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");

	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");

	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");

	return $ip;
}

/*================================================
 * 连接数据库
================================================*/
try {
	$link = new mysqli('127.0.0.1', 'root', 'root', 'ttpaobu');
	if ($link->connect_errno) {
		throw new Exception('Could not connect:'.$link->connect_error);
	} else {
		$link->set_charset('utf8mb4');
	}
} catch (Exception $e) {
	echo error($link->connect_errno, $e->getMessage());
}

// 全局变量
$user = null;
$gid = intval($_REQUEST['gid']);
$uid  = intval($_REQUEST['uid']);

/*================================================
 * 查询数据库
================================================*/
function query($sql)
{
	global $link;
	return $link->query($sql);
}

/*================================================
 * 输出信息
================================================*/
function json($code, $message)
{
	$arr = array('code'=>$code, 'message'=>$message);
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
}

/*================================================
 * 检验当前用户是否有效
================================================*/
function existsUser()
{
	global $user, $link, $uid;

	$bool = 0;
	
	$name = $_REQUEST['username'];

	if ($uid && $name)		//这里应该加入更多的安全措施
	{
		$stmt = $link->prepare("SELECT uid,image FROM user WHERE uid=? AND username=? LIMIT 1");
		$stmt->bind_param("is", $uid, $name);

		$stmt->execute();
		$stmt->store_result();

		$photo = "";
		$stmt->bind_result($uid, $photo);
		if ($stmt->fetch())
		{
			$bool = 1;
			$user['uid'] = $uid;
			$user['photo'] = $photo;
		}
		$stmt->close();
	}

	return $bool;
}

function uintVal($s)
{
	if (ctype_digit($s)) return $s;
	
	return 0;
}

/*================================================
 * 获取数据,防SQL注入
================================================*/
function getString($request)
{
	$str = @$_REQUEST[$request];
	if (!$str) return null;

	return addslashes($str);
}

/*================================================
 * 日志
================================================*/
function log1( $logthis ) 
{
	return file_put_contents('logfile.log', date("Y-m-d H:i:s"). " " . $logthis. "\r\n", FILE_APPEND | LOCK_EX);
}


/*================================================
 * 检验圈子ID
================================================*/
function existGroup($id)
{
	$result = query("select gid from `group` where gid={$id}");
	$row = $result->fetch_assoc();
	if ($row['gid'])
	{
		return 1;
	}
	else 
	{
		return 0;
	}
}

/*================================================
 * 检验用户ID
================================================*/
function isUser($id)
{
	$sql = "select uid from user where uid={$id} limit 1";
	$result=query($sql);
	$row = $result->fetch_assoc();
	if ($row['uid'])
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

/*================================================
 * 随机生成6位数字
================================================*/
function randStr($len=6,$format='NUMBER') 
{
	switch($format) {
		case 'ALL':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; break;
		case 'CHAR':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
		case 'NUMBER':
			$chars='0123456789'; break;
		default :
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
			break;
	}
	mt_srand((double)microtime()*1000000*getmypid());
	$password="";
	while (strlen($password) < $len)
		$password.=substr($chars,(mt_rand()%strlen($chars)),1);
	return $password;
}

/*================================================
 * 根据sport获取打卡类型
================================================*/
function get_type($sport)
{
	if ($sport == 0) 
	{
		$value = 2049;
	} else 
	{
		$value = $sport;
	}
	$t = '';
	for ($i=0;$i<32;$i++)
	{
		if ((1<<$i)&$value)
		{
			$t.=$i.',';
		}
	}
	$result = substr($t, 0,-1);
	return 'in('.$result.')';
}

/*================================================
 * 获取最低打卡距离
================================================*/
function min_dis($dis) 
{
	return $dis*100;
}

function existRid($id)
{
	$sql = "select rid from record where rid={$id} limit 1";
	$result=query($sql);
	$row = $result->fetch_assoc();
	if ($row['rid'])
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

/**
 * 浏览器多语言
 * @return string
 */
function getLangs() {
	if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$lang = substr($lang,0,5);
		if (preg_match("/zh-cn/i",$lang)){
			$lang = "cn";
		} elseif (preg_match("/zh/i",$lang)){
			$lang = "tw";
		} else {
			$lang = "en";
		}
		return $lang;
	} else {
		return "en";
	}
}
?>
