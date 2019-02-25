<?php
<?php
function getkey()
{
    $pro = [
        '谢谢惠顾1' =>30,
        '瑜伽垫' =>20,
		'奖品1' => 30,
		'谢谢惠顾' => 20,
		'奖品1' => 30,
		'谢谢惠顾' => 20,
		'奖品1' => 30,
		'谢谢惠顾' => 20,
    ];
 
    $ret = '';
    $sum = array_sum($pro);
    foreach($pro as $k=>$v)
    {
        $r = mt_rand(1, $sum);
        if($r <= $v)
        {
            $ret = $k;
            break;
        }else{
            $sum = max(0, $sum - $v);
        }
    }
    return $ret;
}
 
echo getkey();


/*
 * 经典的概率算法，
 * $proArr是一个预先设置的数组，
 * 假设数组为：array(100,200,300，400)，
 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内， 
 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
 * 这样 筛选到最终，总会有一个数满足要求。
 * 就相当于去一个箱子里摸东西，
 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
 * 这个算法简单，而且效率非常高，
 * 这个算法在大数据量的项目中效率非常棒。
 */
function get_rand($proArr) { 
  $result = ''; 
  //概率数组的总概率精度 
  $proSum = array_sum($proArr); 
  //概率数组循环 
  foreach ($proArr as $key => $proCur) { 
    $randNum = mt_rand(1, $proSum); 
    if ($randNum <= $proCur) { 
      $result = $key; 
      break; 
    } else { 
      $proSum -= $proCur; 
    }    
  } 
  unset ($proArr); 
  return $result; 
} 
  
  
/*
 * 奖项数组
 * 是一个二维数组，记录了所有本次抽奖的奖项信息，
 * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
 * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
 * 数组中v的总和（基数），基数越大越能体现概率的准确性。
 * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
 * 如果v的总和是10000，那中奖概率就是万分之一了。
 * 
 */
$prize_arr = array( 
  '0' => array('id'=>1,'prize'=>'平板电脑','v'=>1), 
  '1' => array('id'=>2,'prize'=>'数码相机','v'=>5), 
  '2' => array('id'=>3,'prize'=>'音箱设备','v'=>10), 
  '3' => array('id'=>4,'prize'=>'4G优盘','v'=>12), 
  '4' => array('id'=>5,'prize'=>'10Q币','v'=>22), 
  '5' => array('id'=>6,'prize'=>'下次没准就能中哦','v'=>50), 
); 
  
/*
 * 每次前端页面的请求，PHP循环奖项设置数组，
 * 通过概率计算函数get_rand获取抽中的奖项id。
 * 将中奖奖品保存在数组$res['yes']中，
 * 而剩下的未中奖的信息保存在$res['no']中，
 * 最后输出json个数数据给前端页面。
 */
foreach ($prize_arr as $key => $val) { 
  $arr[$val['id']] = $val['v']; 
} 
$rid = get_rand($arr); //根据概率获取奖项id 
  
$res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项 
unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项 
shuffle($prize_arr); //打乱数组顺序 
for($i=0;$i<count($prize_arr);$i++){ 
  $pr[] = $prize_arr[$i]['prize']; 
} 
$res['no'] = $pr; 
print_r($res);

/* 
 * 不同概率的抽奖原理就是把0到*（比重总数）的区间分块
 * 分块的依据是物品占整个的比重，再根据随机数种子来产生0-* 中的某个数
 * 判断这个数是落在哪个区间上，区间对应的就是抽到的那个物品。
 * 随机数理论上是概率均等的，那么相应的区间所含数的多少就体现了抽奖物品概率的不同。
 */  
function get_rand($proArr) 
{   
    $result = array();
    foreach ($proArr as $key => $val) { 
        $arr[$key] = $val['v']; 
    }  
    $proSum = array_sum($arr);      // 计算总权重
    $randNum = mt_rand(1, $proSum);
    $d1 = 0;
    $d2 = 0;
    for ($i=0; $i < count($arr); $i++)
    {
        $d2 += $arr[$i];
        if($i==0)
        {
            $d1 = 0;
        }
        else
        {
            $d1 += $arr[$i-1];
        }
        if($randNum >= $d1 && $randNum <= $d2)
        {
            $result = $proArr[$i];
        }
    }
    unset ($arr); 
    return $result;
}

 /* 
 * 使用较多的为这个方法
 */ 
function get_rand1($proArr) {   
    $result = array();
    foreach ($proArr as $key => $val) { 
        $arr[$key] = $val['v']; 
    } 
    // 概率数组的总概率  
    $proSum = array_sum($arr);        
    asort($arr);
    // 概率数组循环   
    foreach ($arr as $k => $v) {   
        $randNum = mt_rand(1, $proSum);   
        if ($randNum <= $v) {   
            $result = $proArr[$k];   
            break;   
        } else {   
            $proSum -= $v;   
        }         
    }     
    return $result;   
}   

/*
 * 奖项数组 
 * 奖品id,名称，比重 
 */

$arr = array(   
    array('id'=>1,'name'=>'特等奖','v'=>1),
    array('id'=>2,'name'=>'一等奖','v'=>5),
    array('id'=>3,'name'=>'二等奖','v'=>10),
    array('id'=>4,'name'=>'三等奖','v'=>12),
    array('id'=>5,'name'=>'四等奖','v'=>22),
    array('id'=>6,'name'=>'没中奖','v'=>50)
);   


# 测试结果(10000次)：
$count_1 = 0;
$count_2 = 0;
$count_3 = 0;
$count_4 = 0;
$count_5 = 0;
$count_6 = 0;
for ($i = 0; $i < 10000; $i++) {
	$result = get_rand1($arr);
	if ($result['id'] == 1) {
		$count_1 += 1;
	} else if ($result['id'] == 2) {
		$count_2 += 1;
	} else if ($result['id'] == 3) {
		$count_3 += 1;
	} else if ($result['id'] == 4) {
		$count_4 += 1;
	} else if ($result['id'] == 5) {
		$count_5 += 1;
	} else {
		$count_6 += 1;
	}
}

echo sprintf("count_1:%d coutn_2:%d count_3:%d count_4:%d count_5:%d count_6:%d",
$count_1, $count_2, $count_3, $count_4, $count_5, $count_6
);

  #   count_1：0 count_2：490 count_3：1021 count_4：1172 count_5：2172 count_6：5145
  #   特等奖中奖率全为：0
# get_rand1();
#     count_1：92 count_2：477 count_3：1017 count_4：1195 count_5：2264 count_6：4955
# 总体感觉 get_rand1() 更准确些......
?>
