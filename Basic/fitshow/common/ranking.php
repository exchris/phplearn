<?php
require './dbase.php';
require './response.php';
class Rank {
	
	/**
	 * 记录排名之中总排名
	 * @global integer $uid 当前登录用户ID
	 * @param integer $start 分页起始页
	 * @param integer $length 分页终止页
	 * @param integer $type 5KM,10KM,21.097KM,42.195KM
	 * @internal integer $score 当前世界记录
	 * @param integer $myself 当前用户至上
	 * @return string 
	 */
	public function get_record_rank() {
		global $uid;
		
		$start = intval ( @$_REQUEST ['start'] ); // 起始排名
		if ($start)
			$start --;
		$length = intval ( @$_REQUEST ['length'] ); // 记录条数长度
		if ($length == 0)
			$length = 20;
		else if ($length > 100)
			$length = 100;
		
		//判断当前用户是否合法
		if (isUser($uid)) {
			//条件
			switch (@$_REQUEST['type']) {
				case 1:
					$distance = '10000 as score'; //10km
					$score = 'score2 >= 1604 ';
					$tmp = 'score2';
					break;
				case 2:
					$distance = '21097 as score';//半马
					$score = 'score3 >= 3503 ';
					$tmp = 'score3';
					break;
				case 3:
					$distance = '42195 as score'; //全马
					$score = 'score4 >= 7403 ';
					$tmp = 'score4';
					break;
				default:
					$distance = '5000 as score'; //5km
					$score = 'score1 >= 757 ';
					$tmp = 'score1';
			}
			//排行表
			$rank = "select @rank:=@rank+1 as rank,b.* from (select @rank:=$start)rank,( ";
			//用古属性
			$rank .="select nickname,image,city,state,b.* from user u join (";
			//用户属性
			$rank .="select r.uid,$distance,min($tmp) as runtime,datetime from record r where type in(0,11) and $score group by uid order by runtime asc) b on b.uid = u.uid ";
	
			//条件
			$rank .=" where u.state >1)b ";
			
			$result = query($rank);
			//用户个人排名(若有用户ID第一项总是返回用户的排名)
			$myself = null;
			if (getString('myself'))
			{
	
				$result = query("SELECT b.* FROM({$rank})b WHERE b.uid={$uid} LIMIT 1");
				if ($result && ($row = $result->fetch_assoc()) != false)
				{
					if (substr($row['nickname'],0,2) == 'QQ') {
						$row['nickname'] = 'QQ_'.$row['rank'];
					} 
					
					unset($row['state']);
					$myself[] = $row;
				} 
			 
			}
						
					
			//获取排行榜
			$i = 0;
			$record = array();
			$result = query($rank. " LIMIT {$start},{$length}");
			while ($result && ($row = $result->fetch_assoc()) != false)
			{
				if (substr($row['nickname'],0,2) == 'QQ') {
					$row['nickname'] = 'QQ_'.$row['rank'];
				}
				
				unset($row['state']);
				$record[$i++] = $row;
			}
	
	
			if ($myself || $i)
			{
				if ($myself)
					return json_encode(array("myself"=>$myself, "ranking"=>$record));
				else
					return json_encode(array("ranking"=>$record));
			}
			return json(1103, "no records");
		} else {
			return json(1101, "no user");
		}		
	} 
	
	/**
	 *  地区排行榜
	 *  @param integer $uid 当前登录用户ID
	 *  @param integer myself 
	 *  @param integer $start 起始分页
	 *  @param integer $length 终止分页
	 *  @param integer $city 地区ID
	 *  @internal integer $type 5KM,10KM,半马,全马
	 *  @internal integer $score 世界记录
	 *  @return string 
	 */
	public function get_region_rank() {
		global $uid;
		
		//地区
		$city = intval($_REQUEST['city']);
		if ($city >= 10000) {
			$where = "city = {$city} and ";
		} else {
			$where = '';
		}
		$start = intval ( @$_REQUEST ['start'] ); // 起始排名
		if ($start)
			$start --;
		$length = intval ( @$_REQUEST ['length'] ); // 记录条数长度
		if ($length == 0)
			$length = 20;
		else if ($length > 100)
			$length = 100;
		
		//判断uid是否合法
		if (isUser($uid)) {
			//条件
			switch (@$_REQUEST['type']) {
				case 1:
					$distance = '10000 as score'; //10km
					$score = 'score2 >= 1604 ';
					$tmp = 'score2';
					break;
				case 2:
					$distance = '21097 as score';//半马
					$score = 'score3 >= 3503 ';
					$tmp = 'score3';
					break;
				case 3:
					$distance = '42195 as score'; //全马
					$score = 'score4 >= 7403 ';
					$tmp = 'score4';
					break;
				default:
					$distance = '5000 as score'; //5km
					$score = 'score1 >= 757 ';
					$tmp = 'score1';
			}
			//排行表
			$rank = "select @rank:=@rank+1 as rank,b.* from (select @rank:=$start)rank,( ";
			//用古属性
			$rank .="select nickname,image,city,state,b.* from user u join (";
			//用户属性
			$rank .="select r.uid,$distance,min($tmp) as runtime,datetime from record r where type in(0,11) and $score group by uid order by runtime asc) b on b.uid = u.uid ";
	
			//条件
			$rank .=" where $where u.state >1 )b ";

			$result = query($rank);
			
			//用户个人排名(若有用户ID第一项总是返回用户的排名)
			$myself = null;
			if (getString('myself'))
			{
			
				$result = query("SELECT b.* FROM({$rank})b WHERE b.uid={$uid} LIMIT 1");
				if ($result && ($row = $result->fetch_assoc()) != false)
				{
					if (substr($row['nickname'],0,2) == 'QQ') {
						$row['nickname'] = 'QQ_'.$row['rank'];
					}
					
					unset($row['state']);
					$myself[] = $row;
				}
			
			}
			
				
			//获取排行榜
			$i = 0;
			$record = array();
			$result = query($rank. " LIMIT {$start},{$length}");
			while ($result && ($row = $result->fetch_assoc()) != false)
			{
				if (substr($row['nickname'],0,2) == 'QQ') {
					$row['nickname'] = 'QQ_'.$row['rank'];
				} else {
					$row['nickname'] = $row['nickname'];
				}
				unset($row['state']);
				$record[$i++] = $row;
			}
			
			
			if ($myself || $i)
			{
				if ($myself)
					return json_encode(array("myself"=>$myself, "ranking"=>$record));
				else
					return json_encode(array("ranking"=>$record));
			}
			return json(1103, "no records");;
		} else {
			return json(1101,"no user");
		}
	}
	
	/**
	 *  地区中距离排行榜
	 *  @param integer $uid 当前登录用户ID
	 *  @param integer myself 
	 *  @param integer $start 起始分页
	 *  @param integer $length 终止分页
	 *  @param integer $city 地区ID
	 *  @internal integer $type 月,周,日,年,总	 
	 *  @internal integer $score 世界记录
	 *  @return string 
	 */
	public function ranking() {
		global $uid;
		
		$city = isset($_REQUEST['city']) ? getString('city') : 10000;
	
		$where = "and city={$city} ";
		
		$start = intval(@$_REQUEST['start']);		//起始排名
		if ($start) $start--;
		
		$length = intval(@$_REQUEST['length']);		//排名长度
		if ($length == 0) $length = 20;
		else if ($length > 100) $length = 100;
		
		//排名名次
		$rank  = "SELECT @rank:=@rank+1 AS rank, data.* FROM(SELECT @rank:=$start)rank,(";
		
		//排名数据(这里定制要显示的用户属性)
		$rank .= "SELECT data.*,user.nickname,user.image,user.gender,user.city FROM(";
		
		//排名依据(这里合计要输出的运动量)
		$rank .= "SELECT uid, SUM(distance) AS distance,SUM(runtime) AS runtime FROM record ";
		
		//排名类型,默认总排名
		$format = "Y-m-d H:i:s";
		$datetime = $_REQUEST['datetime'] ? strtotime($_REQUEST['datetime']) : time();
		
		switch ($_REQUEST['type'])
		{
			case 4:		//年排名
				$startdate = date('Y-01-01 0:00:00', $datetime);
				$enddate = date($format, strtotime("+1 year", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 1:		//月排名
				$startdate = date('Y-m-01 0:00:00', $datetime);
				$enddate = date($format, strtotime("+1 month", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 2:		//周排名
				$startdate = date($format, strtotime("last monday", strtotime("+1 day", $datetime)));
				$enddate = date($format, strtotime("+1 week", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 3:		//日排名
				$startdate = date($format, strtotime("today", $datetime));
				$enddate = date($format, strtotime("+1 day", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			default: $rank .= "WHERE state=0 ";
		}
		
		if ($_REQUEST['sport'])			//运动类型
		{
			$rank .= "AND type IN({$_REQUEST['sport']}) ";
		}
		
		$rank .= "GROUP BY uid)data INNER JOIN user ON data.uid=user.uid ";
		
		//符合条件的用户才参与排名
		$rank .= "WHERE user.state>1 $where)data ORDER BY data.distance DESC";
		
		//用户个人排名(若有用户ID第一项总是返回用户的排名)
		$myself = null;
		if ($_REQUEST['myself'])
		{
			$result = query("SELECT data.* FROM($rank)data WHERE data.uid=$uid LIMIT 1");
			if ($result && ($row = $result->fetch_assoc()) != false)
			{
				$row['photo'] = $row['image'];
				$myself = $row;
			}
		}
		
		//获取排行榜
		$i = 0;
		$record = array();
		
		$result = query($rank. " LIMIT $start,$length");
		while ($result && ($row = $result->fetch_assoc()) != false)
		{
			$row['photo'] = $row['image'];
			$record[$i++] = $row;
		}
		
		if ($myself || $i)
		{
			if ($myself)
				return json_encode(array("myself"=>$myself, "ranking"=>$record));
			else
				return json_encode(array("ranking"=>$record));
		}
		return json(1100, "no record");
	}
	
	/**
	 * @global integer $uid 当前登录用户
	 * @param integer $type 默认5公里,1为10KM,2为半马，3为全马
	 * @internal integer $score 世界记录
	 */
	public function person() {
		global $uid;
		//判断用户是否合法
		if (isUser($uid)) {
			//条件
			switch (@$_REQUEST['type']) {
				case 1:
					$runtime = 'score2 as runtime';
					$type = 10000;
					$score = 'score2 >= 1604'; //10KM
					break;
				case 2:
					$runtime = 'score3 as runtime';
					$type = 21097;
					$score = 'score3 >= 3503'; //半马
					break;
				case 3:
					$runtime = 'score4 as runtime';
					$type = 42195;
					$score = 'score4 >= 7403'; //全马
					break;
				default:
					$runtime = 'score1 as runtime';
					$type = 5000;
					$score = 'score1 >= 757'; //5公里
			}	
			//获取个人的最佳成绩
			$sql = "select rid,uid,type,$runtime,datetime from record ";

			$sql .="where uid=$uid and type in(0,11) and $score ";
			$sql .="order by runtime asc limit 1";
						
			$result =query($sql);
			$best = array();
			if ($result && ($row=$result->fetch_assoc())!=false) {
				$best[] = $row;
			}
		
			if (count($best)) {
				return json_encode(array("result"=>$best));
			} else {
				return json(1101, "Efforts over $type");
			}
		} else {
			return json(1100, "no user");
		}
	}
	
	/**
	 * 个人今日排名
	 * @method torank()
	 * @param integer $uid
	 */
	public function todayRank() {
		global $uid;
		
		//初始化
		$record = array();
		$start = intval(@$_REQUEST['start']);		//起始排名
		if ($start) $start--;
		
		$length = intval(@$_REQUEST['length']);		//排名长度
		if ($length == 0) $length = 20;
		else if ($length > 100) $length = 100;
		
		//判断uid是否合法
		if (isUser($uid)) {
			
			//排名名次
		$rank  = "SELECT @rank:=@rank+1 AS rank, data.* FROM(SELECT @rank:=$start)rank,(";
		
		//排名数据(这里定制要显示的用户属性)
		$rank .= "SELECT data.*,nickname,image,gender FROM(";
		
		//排名依据(这里合计要输出的运动量)
		$rank .= "select uid,sum(distance) as distance,sum(runtime) as runtime,sum(calories) as calories from record ";
		
		//排名类型,默认总排名
		$format = "Y-m-d H:i:s";
		$datetime = $_REQUEST['datetime'] ? strtotime($_REQUEST['datetime']) : time();
		
		switch ($_REQUEST['type'])
		{
			case 4:		//年排名
				$startdate = date('Y-01-01 0:00:00', $datetime);
				$enddate = date($format, strtotime("+1 year", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 1:		//月排名
				$startdate = date('Y-m-01 0:00:00', $datetime);
				$enddate = date($format, strtotime("+1 month", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 2:		//周排名
				$startdate = date($format, strtotime("last monday", strtotime("+1 day", $datetime)));
				$enddate = date($format, strtotime("+1 week", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			case 3:		//日排名
				$startdate = date($format, strtotime("today", $datetime));
				$enddate = date($format, strtotime("+1 day", strtotime($startdate)));
				$rank .= "WHERE datetime>='$startdate' AND datetime<'$enddate' AND state=0 ";
				break;
					
			default: $rank .= "WHERE state=0 ";
		}
		
		if ($_REQUEST['sport'])			//运动类型
		{
			$rank .= "AND type IN({$_REQUEST['sport']}) ";
		}
		
		$rank .= "GROUP BY uid)data INNER JOIN user ON data.uid=user.uid ";
		
		//符合条件的用户才参与排名
		$rank .= "WHERE user.state>1 )data ORDER BY data.distance DESC";
		
		//统计当前时间跑步人数
		$count = query("select count(uid) as count from ($rank)b ")->fetch_assoc();
		$result = query("SELECT b.* FROM($rank)b WHERE b.uid=$uid LIMIT 1");
		if ($result && ($row = $result->fetch_assoc())!=false) {
			$row['count'] = $count['count'];
			$record[] = $row;
		}
			if (count($record)) {
				echo Response::json(0, "success", $record);
				exit();
			} else {
				echo Response::err(1101,"no record");
				exit();
			}
		} else {
			echo Response::err(1100, "no user");
			exit();
		}
	}
 }

$r = new Rank();
switch (strtolower(@$_REQUEST['method'])) {
	case 'total':
		echo $r->get_record_rank();
		break;
		
	case 'region':
		echo $r->get_region_rank();
		break;
		
	case 'ranking':
		echo $r->ranking();
		break;
		
	case 'person':
		echo $r->person();
		break;
	
	case 'time':
		echo $r->todayRank();
		break;
		
	default:
		exit(json(999, "no method!"));
}