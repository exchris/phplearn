<?php
require_once 'conn.php';
require_once 'dbase.php';
require_once 'response.php';

//输出内容兼容json数据
function output($string, $l = "en", $name='name') 
{
	
	$result = array();
	$arr = json_decode($string, true);
	if ($l == "cn&zh") $l = "cn";
 	$keys = array("cn","en","tw","pt","es","ru","ja","fr","de");
 
	foreach ($arr as $key=>$value) 
	{
		if (in_array($l, $keys)) {
			$result[$name] = isset($arr[$l]) ? $arr[$l] : "";
		} else {
			$result[$name] = isset($arr['en']) ? $arr['en'] : ''; // 其他语言默认语言
		}
		foreach ($keys as $v) {
			if ($v == $key) {
				$key = $name."_".$key;
				$result[$key] = isset($value) ? $value : "";
			} else {
				$v1 = $name."_".$v;
				$result[$v1] = isset($arr[$v]) ? $arr[$v] : "";
			}
		}		
	}
	return $result;
}

//将[[a,b],[c,d]]格式转换为a,c和b,d
function out($str) {
	//把最外面的[]去掉
	$vpStr = substr($str, 1, -1);
	$arr = explode(",", $vpStr);
	foreach ($arr as $key=>$value) {
		if ($key % 2 == 0) {
			$v[] = substr($value, 1);
		} else {
			$p[] = substr($value, 0, -1);
		}
	}
	return array("v"=>$v,"p"=>$p);
}

$fun = getString('method');

if ($fun)
{
	if (function_exists($fun))
		eval("echo $fun();");
	else
		echo error(-100, "unknow method <$fun>");
}


//选择训练计划
function select() 
{
	global $pdo;
	$l = isset($_REQUEST['l']) ? getString('l') : 'cn';
	if ($l == "cn&zh") $l = 'cn';
	//默认运动秀,appkey=sunny则$appkey='SUNNY'
	$appkey = isset($_REQUEST['appkey']) ? strtoupper($_REQUEST['appkey']) : 'FITSHOW' ;
	$where = "where appkey='$appkey'";
	//语言选择
	//获取所有的训练计划
	$sql = <<<EOF
	SELECT id,name,image,type FROM plan $where order by timestamp desc LIMIT 0, 10;
EOF;
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
	while (($row = $stmt->fetch()) != false) 
	{
		$arr = output($row['name'], $l);
		unset($row['name']);
		$plan[] = array_merge($row, $arr);
	}
	
	if ( count($plan)) {
		return json_encode($plan,JSON_UNESCAPED_UNICODE);
	} else {
		return json_encode(array(array(
		'code' => 1001,
		'msg'  => L('No plans', $l))),JSON_UNESCAPED_UNICODE);
	}
}

//选择该计划的训练等级
function selevel() 
{
	global $pdo;
	$l = isset($_REQUEST['l']) ? getString('l') : 'cn';
	if ($l == "cn&zh") $l = 'cn';
	$id = intval($_REQUEST['pid']); //计划ID
	$arr = array(); //数组初始化
	
	//查询该计划ID的训练等级分类
	$sql = <<<EOF
	SELECT l.id,l.name,l.summary from plan_level l inner join 
plan p on p.id = l.pid where p.id = ? ;
EOF;
	
	$stmt = $pdo->prepare($sql);
	
	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	
	$stmt->execute(); 
	
	while (($row = $stmt->fetch()) != false)
	{
		$planname = output($row['name'], $l, $name='name');		//计划等级名称
		
		unset($row['name']);
		$levelsummary = output($row['summary'], $l, $name='summary');	//计划等级描述
		
		$levels[] = array_merge(array_merge($row, $planname), $levelsummary);
	}

	if (count($levels)) {
		return removeHTML(json_encode($levels,JSON_UNESCAPED_UNICODE));
	} else {
		return json_encode(array(array(
			"code" => "2000",
			"msg"  => L('No levels', $l))),JSON_UNESCAPED_UNICODE);
	}
}

/**训练列表信息**/
function training() 
{
	global $pdo,$uid;
	
	$l = isset($_REQUEST['l']) ? getString('l') : 'cn';
	if ($l == "cn&zh") $l = 'cn';
	//计划ID
	$id = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : 13;
	//计划等级ID
	$lid = isset($_REQUEST['lid']) ? $_REQUEST['lid'] : 22;
	//计划开始时间
	$time = isset($_REQUEST['datetime']) ? getString('datetime') : date('Y-m-d');
	//概况或创建 0代表概况,1代表创建
	$state = intval($_REQUEST['state']) ? $_REQUEST['state'] : 0;
	
	//判断uid是否合法
	if (isUser($uid)) {
		$task = array();
		$info = result($id, $lid, $l, $time);
		foreach ($info['task'] as $key=>$value) {
			$task[$key]['state'] = isset($value['state']) ? $value['state'] : '';
			$task[$key]['t'] = $value['t'];
		}
		
		foreach ($task as $k=>$v) {
			if ($v['state'] != '0') {
				unset($task[$k]);
			}
		}
		sort($task);
		
		$endtime = $info['endtime'];
		$gearArr = array(
			"pid" => $id,
			"lid" => $lid,
			"task" => $task
		);
		
		$gear = removeHTML(json_encode($gearArr));
		
		if ($state == 0) {
			//概况
			$info['id'] = "0";
			return removeHTML(json_encode($info,JSON_UNESCAPED_UNICODE));
		} else {
			//创建用户计划
			$doing = "select state,gear from plan_user where uid=? and state=0 limit 1";
			$do = $pdo->prepare($doing);
			$do->bindParam(1,$uid, PDO::PARAM_INT);
			$do->execute();
			$d = $do->fetch();

			if ($d['state'] == 0 && $do->rowCount()) {
				return json_encode(
					array(
						"code" => 1002,
						"msg" => L("Having Plan To Do", $l)
					),JSON_UNESCAPED_UNICODE
				); 
			} else {
				//创建计划信息
				$create = "INSERT INTO plan_user SET uid=?,starttime=?,state=0,gear=?,endtime=? ";
				//预处理插入语句
				$c = $pdo->prepare($create);
				$c->bindParam(1, $uid, PDO::PARAM_INT);
				$c->bindParam(2, $time, PDO::PARAM_STR);
				$c->bindParam(3, $gear, PDO::PARAM_STR);
				$c->bindParam(4, $endtime, PDO::PARAM_STR);
				$c->execute();
				$info['id'] = $pdo->lastInsertId();
				return removeHTML(json_encode($info,JSON_UNESCAPED_UNICODE)); #去除HTML标签
			}

		}
 
	} else { 
		//不合法
		return json_encode(
			array(
				"code" => 1001,
				"msg"  => L('Invalid username', $l)
 			),JSON_UNESCAPED_UNICODE);
	}
}

/**获取对应计划图片**/
function image() 
{
	$name = getString ( 'image' );
	$arr = explode ( "_", $name );
	
	$file = "../../images/plan";
//	if ($_REQUEST ['cover'])
//		$file .= "_cover";
	$file .= "/" . $name;
	
	if (file_exists ( $file )) 
	{
		list ( $width, $height, $type ) = getimagesize ( $file );
		switch ($type) {
			case 1 :
				header ( "Content-type:image/gif" );
				break;
			case 2 :
				header ( "Content-type:image/jpeg" );
				break;
			case 3 :
				header ( "Content-type:image/png" );
				break;
			default :
				return 1;
		}
			
		echo file_get_contents ( $file );
		return;
	}
	
	return err ( 20, 'no image' );
}

/**放弃计划**/
function revokePlan() 
{
	global $pdo,$uid;
	$l = isset($_REQUEST['l']) ? getString('l') : 'cn';
	//放弃计划操作
	$sql = "DELETE FROM plan_user WHERE uid=? AND state = 0 LIMIT 1";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(1, $uid, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount()) {
		return json_encode(
			array("code"=>0,"msg"=>L("RevokePlan Success", $l))
		);
	} else {
		return json_encode(
			array("code"=>1000, "msg"=>L("Not Have Plan", $l))
		);
	}
}

/**计划详情**/
function detail() 
{
	global $pdo, $uid;
	$l = isset($_REQUEST['l']) ? getString('l') : 'cn';
	query("call updatePlanState()");
	
	$pid = intval($_REQUEST['pid']);
	if ($pid && $uid) {
		$sql = "SELECT pid,gear,starttime,state FROM `plan_user` WHERE pid=$pid LIMIT 1";
	} else {
		//获取当前用户的计划详情
		$sql = "SELECT pid,gear,starttime,state FROM plan_user WHERE uid=? AND state=0 LIMIT 1";
	}
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(1, $uid);
	$stmt->execute();
	$res = $stmt->fetch();
	
	if ($stmt->rowCount()) {
		$r = json_decode($res['gear'], true);
		$time = date('Y-m-d',strtotime($res['starttime']));
		$info = result($r['pid'], $r['lid'], $l, $time );
		foreach ($info['task'] as $key=>$value) {
			foreach ($r['task'] as $k=>$v) {
				if ($value['t'] == $v['t']) {
					$info['task'][$key]['state'] = $v['state'];
				}
			}
		}

		$info['id'] = $res['pid'];
		$info['state'] = $res['state'];
		return removeHTML(json_encode($info));
	} else {
		return json_encode(array("code"=>1000, "msg"=>L("No Playing Plan", $l)));
	}
}

/**
 * Created by:cxm
 * Time:2017-03-09 13:36
 * Signature:完成小计划(状态)
 * Content: 
 */
function finish()
{
	global $pdo,$uid;
	$l = isset($_REQUEST['l']) ? $_REQUEST['l'] : 'cn';
	
	//小计划对应时间
	$datetime = date('Y-m-d', strtotime(getString('datetime')));
	//当前日期
	$current = date('Y-m-d');
	
	//查询用户正在进行的计划信息
	$sql = "SELECT gear,pid,starttime FROM `plan_user` WHERE uid=? AND state=0 limit 1";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(1, $uid, PDO::PARAM_INT);
	$stmt->execute();
	$res = $stmt->fetch();
	$pid = $res['pid'];
	$time = $res['starttime']; // 用户当前计划开始时间
	if ($stmt->rowCount())
	{
		// 将计划详情转为数组格式
		$arr = json_decode($res['gear'], true);
		// 获取用户计划天数
		$days = count($arr['task']) - 1;
		$lastDay =  $arr['task'][$days]['t'];
		
		$gear = result($arr['pid'], $arr['lid'], $l, $time);
		
		foreach ($gear['task'] as $key=>$value) {
			foreach ($arr['task'] as $k=>$v) {
				// 用户传入的时间刚好等于计划最后的日期
				if ($lastDay == $datetime) {
					$arr['task'][$days]['state'] = "1";
					$result = str_replace('\u', '\\u', json_encode($arr));
					
					$smt = $pdo->prepare("update `plan_user` set gear=? where pid=$pid");
					$smt->bindParam(1, $result);
					$smt->execute();
					
					//修改大计划状态
					$s = $pdo->prepare("update `plan_user` set state=1 where pid=$pid ");
					$s->execute();
					return json_encode(array("code"=>1000, "msg"=>L("Not Have Plan", $l)));
				}
				elseif ($v['t'] == $datetime)
				{ // 用户传入的时间
					$arr['task'][$k]['state'] = "1";
					$result = str_replace('\u', '\\u', json_encode($arr));
					
					$smt = $pdo->prepare("update `plan_user` set gear=? where pid=$pid");
					$smt->bindParam(1, $result);
					$smt->execute();
					return json_encode(array("code"=>0, "msg"=>L("Update Plan Success", $l)));
				}
				elseif ($current > $lastDay) 
				{   // 当前时间大于计划的最后运动时间
					$smt = $pdo->prepare("update `plan_user` set state=1 where pid=$pid");
					$smt->execute();
					return json_encode(array("code"=>1000, "msg"=>L("Not Have Plan", $l)));
				}
			}
		}
	}
	else
	{
		return json_encode(array("code"=>1000, "msg"=>L("Not Have Plan", $l)));
	}
}

function result($id, $lid, $l = 'en', $time)
{
	//合法
	global $pdo;
	$sql = "select p.name,l.name as level,p.image,p.type,task,taskdetail from plan p inner join
	plan_level l on l.pid=p.id where p.id=? and l.id=? limit 1";
	
	$play = $pdo->prepare($sql);
	//绑定参数
	$play->bindParam(1,$id,PDO::PARAM_INT);
	$play->bindParam(2,$lid,PDO::PARAM_INT);
	$play->execute();
	$res = $play->fetch();
	
	$planname = output($res['name'], $l, $name='name');
	
	$levelname = output($res['level'], $l, $name='level');
	$info = array_merge($planname, $levelname);
	$info['image'] = $res['image']; $info['type'] = $res['type'];
	$infotask = $res['task'];
	$infojson = explode(",",$infotask);
	foreach ($infojson as $k=>$v) {
		//查询value对应的程式信息
		$pid = $v;
		$vp = query("select data,name,value,summary from model where mid=$pid limit 1");
		$rs = $vp->fetch_assoc();
			
		if ($vp->num_rows && $rs['value'] != 0) {
			$data = out($rs['data']);
			$modelname = output($rs['name'], $l, $name='name');
			$modelsignature = output(removeHTML(($rs['summary'] == '') ? '' : $rs['summary']),$l, $name='signature');
			$info1[$k] = array_merge($modelname, $modelsignature);
		
			$info1[$k]['state'] = "0";
			$info1[$k]['v'] = implode(',', $data['v']);
			$info1[$k]['p'] = implode(',', $data['p']);
			$info1[$k]['time'] = $rs['value'];
			$info1[$k]['t'] = date('Y-m-d',strtotime($time."+$k day"));
	
		} else {
			//休息
			$modelname = output($rs['name'], $l, $name='name');
			$modelsignature = output(removeHTML(($rs['summary'] == '') ? '' : $rs['summary']),$l, $name='signature');
			$info1[$k] = array_merge($modelname, $modelsignature);
			$info1[$k]['t'] = date('Y-m-d',strtotime($time."+$k day"));
		}
	}
	$info['task'] = $info1;
	//获取任务的信息
	$infodetail = json_decode($res['taskdetail'],true);
	$info['training'] = $infodetail['xdata'];
	$sum = $infodetail['zdata'] - 1;
	$info['distance'] = $infodetail['distance'];
	$info['endtime'] = date('Y-m-d',strtotime($time."+$sum day"));
	$endtime = $info['endtime'];
	//最后一天的结束时间为
	$info['count'] = $infodetail['zdata'];
	$info['state'] = "0";
	unset($info['taskdetail']);
	return $info;
}

function myPlan()
{
	global $pdo, $uid;
	$user = existsUser();
	$l = isset($_REQUEST['l']) ? $_REQUEST['l'] : 'en';

	if (!$user)
		Response::err(100, L("Invalid username", $l));

	

	// 获取当前用户的计划列表
	$sql = "SELECT * FROM `plan_user` WHERE uid=:uid ORDER BY pid DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':uid', $uid);
	$stmt->execute();

	if (!$stmt->rowCount())
		Response::err(101, L("No plans", $l));

	while (false != ($plan = $stmt->fetch()))
	{
		$gear = json_decode($plan['gear'], true);
		
		$info = result($gear['pid'], $gear['lid'], $l, $plan['starttime']);
		
		$name = $info['name'];
		$level = $info['level'];
		$pid = $plan['pid'];
		$count = $info['count'];
		$train = $info['training'];
		$state = $plan['state'];
		# 计算完成天数
		$finish = 0;
		# 跳过天数
		$jump = 0;$now = date('Y-m-d');
		# 休息天数
		$reset = 0;
		
		foreach ($info['task'] as $key=>$value) {
			
			# 计算完成天数
			if ($value['state'] == 1) {
				$finish++;
			}
			# 计划跳过天数
			
			if ($value['state'] == '0' && ($value['t'] < $now)) {
				$jump++;
			}
			# 计划休息跳过天数
			if (is_null($value['state']) && ($value['t'] < $now)) {
				$reset++;
			}

		}

		$planlist[] = array(
			"id" => $pid ,
			"name" => $name,
			"level" => $level,
			"state" => $state,
			"count" => $count,
			"training" => $train,
			"finish" => $finish,
			"jump" => $jump,
			"reset" => $reset
		);
	}
	
	echo json_encode(array("planlist"=>$planlist));
	return;
}

?>

