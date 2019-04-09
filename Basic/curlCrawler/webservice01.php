<?php

/**
 * 查询本天气预报Web Services支持的国内外城市或地区信息
 * @param $byProvinceName 指定的洲或国内的省份,若为ALL或空则表示返回全部城市;
 * @return 一个一维字符串数组String(),结构为:城市名称(城市代码)
 */
$data = "byProvinceName=江西";
$curlobj = curl_init(); // 初始化 
curl_setopt($curlobj, CURLOPT_URL, "http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getSupportCity");
curl_setopt($curlobj, CURLOPT_HEADER, 0);
curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);

// post数据
curl_setopt($curlobj,CURLOPT_POST,1);
curl_setopt($curlobj,CURLOPT_POSTFIELDS,$data);
curl_setopt($curlobj,CURLOPT_HTTPHEADER,array("application/x-www-form-urlencoded;charset=utf-8;","Content-length: ".strlen($data)));
curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
$result = curl_exec($curlobj);
if (!curl_errno($curlobj)) {
	echo $result;
} else {
	echo "Curl Failed : " . curl_error($curlobj);
}

curl_close($curlobj);

?>