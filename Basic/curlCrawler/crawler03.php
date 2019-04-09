<?php 

/**
 * 用cURL调用WebService获取天气信息
 * User: Ollydebug
 * Date: 2015/11/11
 * Time: 19:44
 */

//在WeatherWs的服务器上，默认大连城市的 theCityCode = 864

$data = 'theCityCode=864&theUserID=';
$curlobj = curl_init();

curl_setopt($curlobj,CURLOPT_URL,"http://www.webxml.com.cn/WebServices/WeatherWS.asmx/getWeather");
curl_setopt($curlobj,CURLOPT_HEADER,0);
curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curlobj,CURLOPT_POST,1);
curl_setopt($curlobj,CURLOPT_POSTFIELDS,$data);
curl_setopt($curlobj,CURLOPT_HTTPHEADER,array("application/x-www-form-urlencoded;charset=utf-8;","Content-length: ".strlen($data)));
curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');

$rtn = curl_exec($curlobj);
if(!curl_errno($curlobj)){
    echo $rtn;
}else{
    echo 'Curl error: '.curl_errno($curlobj);
}
curl_close($curlobj);

?>
