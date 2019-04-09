<?php

/*
年份的数字表示

常见的合法日期时间在一个范围内，这里我们取[0001年01月01日 00时00分00秒] 到[9999年12月31日 23时59分59秒]
所有年份正则表达式
[0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3}

闰年
([0-9]{2})(0[48]|[2468][048]|[13579][26])	

^((([0-9]{2})(0[48]|[2468][048]|[13579][26]))   #闰年，能被4整除但不能被100整除
|((0[48]|[2468][048]|[13579][26])00)   #闰年，能被400整除
-02-29)  #匹配闰年2月29日这一天。如果不是这一天，则由下面式子继续匹配验证。 
|([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3}) #平年（0001-9999）
-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))   #月日，1、3、5、7、8、10、12月有31天
|((0[469]|11)-(0[1-9]|[12][0-9]|30))   #月日，4、6、9、11月有30天
|(02-(0[1-9]|[1][0-9]|2[0-8])))   #平年2月只有28天，月日表示为【02-01至02-28】
*/


$pattern = '/^((([0-9]{2})(0[48]|[2468][048]|[13579][26]))|((0[48]|[2468][048]|[13579][26])00)-02-29)|([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))$/'

var_dump(preg_match($pattern, '2000-02-30'));


//手机号校验
$phone = '/^1[3456789]\d{9}$/';
var_dump(preg_match($phone, '15259020794'));

//判断生日
$birthday = '/^[1-2]\d{3}[\-](0?[1-9]|1[012])([\-](0?[1-9]|[12][0-9]|3[01]))$/';
var_dump(!preg_match($birthday, '1992-04-10'));




?>