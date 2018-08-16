<?php
return array(
	//'配置项'=>'配置值'

	//url模式设置
	'URL_MODEL' => 1, //pathinfo

	//让页面显示追踪日志信息
	'SHOW_PAGE_TRACE' => false,
	
	//URL地址大小写不敏感设置
	'URL_CASE_INSENSITIVE' => true,
		
	/* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'hc',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'root',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  '',    // 数据库表前缀
	'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
	'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
	
	//多语言支持
	'LANG_SWITCH_ON'		=> true, 	            //默认关闭语言包功能
	'LANG_AUTO_DETECT'		=> true, 	            //自动侦测语言 开启多语言功能后有效
	'LANG_LIST'				=> 'zh-cn,zh-tw,en-us', //允许切换的语言列表 用逗号分割
	'VAR_LANGUAGE'			=> 'hl',		        //默认语言切换变量
	

	//主题静态文件路径
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => '/hc/Public',
	),
		
	//设置SESSION过期时间
	'SESSION_OPTIONS' => array(
		'name' => 'username',		//设置session名称
		'expire' => 3600,			//session保存时间
		'use_trans_sid' => 1, 		//跨页传递
		'use_only_cookies' => 0,	//是否只开启给予
	),
);