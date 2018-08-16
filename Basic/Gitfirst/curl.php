<?php
//file_get_contents抓取https地址内容
function getCurl($url)
{
  $curl = curl_init(); //初始化
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  $result = curl_exec($curl);
  //释放url地址
  curl_close($curl);
  return $result;
}

