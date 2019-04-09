<?php
  header("Content-Type:text/html; charset=utf-8");
  $cardid = '36123419920401285X';
  # 只能是18位
  if (strlen($cardid) != 18) {
  	return false;
  }
  # 取出前17位
  $idcard_base = substr($cardid, 0, -1);
  # 取出检验码
  $verifycode = substr($cardid, -1);

  # 加权因子
  $factor = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
  # 校验码对应值
  $verify_code_arr = array('1','0','X','9','8','7','6','5','4','3','2');
  # 根据前17位计算校验码
  $S = 0;
  for ($i = 0; $i < 17; $i++) {
  	$S += substr($idcard_base, $i, 1) * $factor[$i];
  }
  
  # 取模
  $mod = $S % 11;
  # 比较校验码
  if ($verifycode == $verify_code_arr[$mod]) {
  	echo "身份证号码正确";
  } else {
  	echo "身份证号码错误";
  }
?>