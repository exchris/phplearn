<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>管理员页面</title>  
    <link rel="stylesheet" href="/hc/Public/css/pintuer.css">
    <link rel="stylesheet" href="/hc/Public/css/admin.css">
    <script src="/hc/Public/js/jquery.js"></script>   
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="/hc/Public/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />管理员页面</h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> 
  <a class="button button-little bg-red" href="<?php echo U('Index/index');?>"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><span class="icon-pencil-square-0">基本设置</span></h2>
  <ul>
  	<li><a href="<?php echo U('Admin/pass');?>" target="right"><span class="icon-caret-right"></span>密码修改</a></li>
  </ul>
  <h2><span class="icon-pencil-square-o">管理员权限</span></h2>  
  <ul>
  	<li><a href="<?php echo U('Admin/teacher');?>" target="right"><span class="icon-caret-right"></span>教师管理</a></li>
  	<li><a href="<?php echo U('Admin/student');?>" target="right"><span class="icon-caret-right"></span>学生管理</a></li>
  	<li><a href="<?php echo U('Admin/msglist');?>" target="right"><span class="icon-caret-right"></span>留言管理</a></li>
  	<li><a href="<?php echo U('Admin/classes');?>" target="right"><span class="icon-caret-right"></span>课程管理</a></li>
  	<li><a href="<?php echo U('Teacher/score');?>" target="right"><span class="icon-caret-right"></span>成绩管理</a></li>
  </ul>
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
</script>
<ul class="bread">
  <li><a href="<?php echo U('Admin/pass');?>" target="right" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">个人信息</a></li>
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="pass.html" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">
</div>
</body>
</html>