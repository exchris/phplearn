<?php 

# 制作一个简单的网页爬虫
error_reporting(0);

// 初始化并设置抓取的URL
$curl = curl_init("http://www.baidu.com");
// 设置头文件的信息作为数据流输出
curl_setopt($curl, CURLOPT_HEADER, 1);
// 设置获取的信息以文件流的形式返回,而不是直接输出
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// 执行命令
$data = curl_exec($curl);
// 关闭CURL请求
curl_close($curl);
// 显示获得数据
print_r($data);