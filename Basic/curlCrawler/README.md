# PHP--理解和使用CURL
### 1、CURL的概念
	Client URL Library Functions;
	curl是客户端向服务器请求资源的工具;
### 2、CURL的使用场景
	- 网页资源:编写网页爬虫
	- WebService数据接口资源:动态获取接口数据,比如天气、号码归属地等等
	- FTP服务器里面的文件资源:下载FTP服务器里面的文件
	- 其他资源:所有网络上的资源都可以用CURL访问和下载到
### 3、 在PHP中使用CURL
	1、初始化CURL curl_init()
	2、向服务器发送请求
	3、接收服务器数据 curl_exec()
	4、关闭curl curl_close()
### 4、CURL实战
```
<?php
$curl = curl_init("http://www.baidu.com");
curl_exec($curl);
curl_close($curl);
```

