<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>已经发布</title>

<link href="/yxy/Public/css/bootstrap.min.css" rel="stylesheet">
<link href="/yxy/Public/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/yxy/Public/css/common/top.css" rel="stylesheet" type="text/css" />
<link href="/yxy/Public/css/common/foot.css" rel="stylesheet" type="text/css" />
<link href="/yxy/Public/css/common/UserInfoLeft.css" rel="stylesheet" type="text/css" />
<link href="/yxy/Public/css/myFavorite.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/yxy/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/yxy/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/yxy/Public/js/scripts.js"></script>

</head>

<body>

<div class="container-fluid">
	<!--头部开始-->
	<div id="top">
		<div class="span2" id="logo">
			<a href="#"><img src="/yxy/Public/userinfo/logo.png" width="150" height="50" border="0"></a>
		</div>
		<div class="span2" id="City" style="position:relative;">
			<span class="city1">无锡</span><a class="city-sel" href="#">[切换]
				
			</a>
			<div class="city2"style="position:absolute; display:none; top:40px; left:0; background:#fff; width:60px">
			<span style="width:60px; height:24px; display:block;line-height:24px;text-align:center;">南昌</span>
			<span style="width:60px;height:24px;display:block;line-height:24px;text-align:center;">无锡</span>
			</div> 
		</div>
		<script>
		$(document).ready(function(){
			$(".city-sel").click(function(){
				$(".city2").show()
			})
			$(".city2 span").click(function(){
				var city=$(this).text();
				$(".city1").text(city);
				$(".city2").hide()
			})
		});
		</script>
		<div class="span5">
		</div>
		
	</div>
	<!--头部结束-->
	
	<div class="clear"></div>

		<div class="span12">
			<!--导航开始-->
			<div class="navbar">
				<div class="navbar-inner">
						<div class="nav-collapse collapse navbar-responsive-collapse" id="Navigation">
							<ul class="nav">
								<li>
									<a href="<?php echo U('Index/index');?>">首页</a>
								</li>
								<li>
									<a href="<?php echo U('Property/property');?>">楼盘</a>
								</li>
								<li>
									<a href="<?php echo U('Property/renting');?>">租房</a>
								</li>
								<li>
									<a href="<?php echo U('Property/secondhandhouse');?>">二手房</a>
								</li>
								<li>
									<a href="<?php echo U('Property/buy');?>">买房</a>
								</li>
								<li>
									<a href="<?php echo U('Property/sellers');?>">卖房</a>
								</li>
								<li>
									<a href="<?php echo U('Index/search');?>">搜索</a>
								</li>
							</ul>
							<ul class="nav pull-right">
								<li class="active">
									<a href="#"><?php echo ($username); ?></a>
								</li>
								<li class="divider-vertical">
								</li>
								<li class="dropdown">
									 <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo ($username); ?><strong class="caret"></strong></a>
									<ul class="dropdown-menu">
										<li>
											<a href="MyFavorite.html">我的收藏</a>
										</li>
										<li>
											<a href="Subscription.html">订阅管理</a>
										</li>
										<li>
											<a href="BrowseHistory.html">浏览历史</a>
										</li> 
										<li>
											<a href="Released.html">我的发布</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="ReleaseSale.html">发布出售</a>
										</li>
										<li>
											<a href="ReleaseRent.html">发布出租</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="<?php echo U('Account/logout');?>">退出</a>
										</li>
										
									</ul>
								</li>
							</ul>
						</div>
						
				</div>
				
			</div>
			<!--导航结束-->
		</div>
		
		
		
	<div class="span12">	
		<!--左侧-->
		<div id="Left" class="span4">
			<!--个人中心-->
			<div class="personalCenter">
				<div class="personalCenter-title">
					<h5>个人中心</h5>
				</div>
				<div class="personalCenter-content">
					<p class="userName"><?php echo ($username); ?></p>
					<p><a href="ModifyPersonalInfo.html">修改个人资料</a></p>
					<p><a href="ModifyPassword.html">修改密码</a></p>
				</div>
			</div>
			<!--个人中心结束-->
			
			<!--用户功能权限-->
			<div class="userFunction">
				<ul class="nav nav-pills nav-tabs nav-stacked">
					<li><a href="MyFavorite.html" class="MyFavorites"><img src="/yxy/Public/userinfo/MyFavorites.png" width="15" height="15" border="0">我的收藏</a></li>
					
					<li><a href="BrowseHistory.html" class="BrowseHistory"><img src="/yxy/Public/userinfo/BrowseHistory.png" width="15" height="15" border="0">浏览历史</a></li>
					<li><a href="Subscription.html" class="Subscription"><img src="/yxy/Public/userinfo/Subscription.png" width="15" height="15" border="0">订阅管理</a></li> 
					<li><a href="Released.html" class="Released"><img src="/yxy/Public/userinfo/Released.png" width="15" height="15" border="0">已经发布</a></li>
					<li><a href="ReleaseSale.html" class="ReleaseSale"><img src="/yxy/Public/userinfo/ReleaseSale.png" width="15" height="15" border="0">发布出售</a></li>
					<li><a href="ReleaseRent.html" class="ReleaseRent"><img src="/yxy/Public/userinfo/ReleaseSale.png" width="15" height="15" border="0">发布出租</a></li>
				</ul>
			</div>
			<!--用户功能权限结束-->
			
			
		</div>
		<!--左侧结束-->
		
		<!--右侧-->
		<div id="Right" class="span8">
			<div class="released-title">
				<h4>您已经发布的信息</h4>
			</div>
			
			<!--已经发布开始-->
			<div class="span8" id="myFavorite">
				<table width="700" cellspacing="0" cellpadding="0" border="0">
				<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr height="120" valign="middle">
					  <td width="30" align="center"></td>
						<td width="150" align="left"><img src="/yxy/Public/property/Property/<?php echo ($vo["image"]); ?>" width="125" height="85" border="0" /></td>
						<td width="230">
							<p><a href="#" class="PropertyName"><?php echo ($vo["name"]); ?></a></p>
							<p>户型：<span><?php echo ($vo["type"]); ?></span></p>
							<p>区域：<span><?php echo ($vo["area"]); ?></span></p>					  
						</td>
						<td  width="70" align="center"><p class="PropertyPrice"><?php echo ($vo["price"]); ?></p></td>
						<td width="230">
							<p><?php echo ($vo["from"]); ?></p>
							<p>电话：<span><?php echo ($vo["phone"]); ?></span></p>
							<p><?php if($vo["style"] == 1): ?>出售<?php else: ?>出租<?php endif; ?></p>		
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			  </table>
			</div>
			<!--已经发布结束-->
			
		</div>
		<!--右侧结束-->
	</div>
		
</div>


	<div class="clear"></div>


</body>
</html>