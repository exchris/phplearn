<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>优楼盘--首页</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	
	<link href="/yxy/Public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/yxy/Public/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/yxy/Public/css/style.css" rel="stylesheet">
	<link href="/yxy/Public/css/common/top.css" rel="stylesheet" type="text/css">
    <link href="/yxy/Public/css/common/foot.css" rel="stylesheet" type="text/css">
    <link href="/yxy/Public/css/common/Compatibility.css" rel="stylesheet" type="text/css">

  

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/yxy/Public/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/yxy/Public/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/yxy/Public/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="/yxy/Public/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="/yxy/Public/img/favicon.png">
  
	<script type="text/javascript" src="/yxy/Public/js/jquery.min.js"></script>
	<script type="text/javascript" src="/yxy/Public/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/yxy/Public/js/scripts.js"></script>
</head>

<body>


<div class="container-fluid">

	<!--头部开始-->
	<div id="top">
		<div class="span2" id="logo">
			<a href="<?php echo U('Index/index');?>"><img src="/yxy/Public/img/logo.png" width="150" height="50" border="0"></a>
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
		<div class="span3" id="tel">
			<img src="/yxy/Public/img/tel.png" width="150" height="50"/>
		</div>
	</div>
	<!--头部结束-->
	
	<div class="clear"></div>
	
	<div class="row-fluid">
		<div class="span12">
			<!--导航开始-->
			<div class="navbar">
				<div class="navbar-inner">
						<div class="nav-collapse collapse navbar-responsive-collapse" id="Navigation">
							<ul class="nav">
								<li class="active">
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
								
							</ul>
							<ul class="nav pull-right">
								<li>
									<a href="<?php echo U('Account/login');?>">登录</a>
								</li>
						
								<li>
									<a href="<?php echo U('Account/register');?>">注册</a>
								</li>
						
								<li class="divider-vertical">
								</li>
								<?php if($username != ''): ?><li class="dropdown">
									 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
									 <?php echo ($username); ?>
									 <strong class="caret"></strong></a>
									<ul class="dropdown-menu">
										<li>
											<a href="<?php echo U('UserInfo/myfavorite');?>">我的收藏</a>
										</li>
										<li>
											<a href="<?php echo U('UserInfo/subscription');?>">订阅管理</a>
										</li>
										<li>
											<a href="<?php echo U('UserInfo/browsehistory');?>">浏览历史</a>
										</li>
										<li>
											<a href="<?php echo U('UserInfo/released');?>">我的发布</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="<?php echo U('UserInfo/releasesale');?>">发布出售</a>
										</li>
										<li>
											<a href="<?php echo U('UserInfo/releaserent');?>">发布出租</a>
										</li>
										<li><a href="<?php echo U('Account/logout');?>">退出</a></li>
										
									</ul>
								</li>
								<?php else: ?>
								<li></li><?php endif; ?>
							</ul>
						</div>
						
				</div>
				
			</div>
			<!--导航结束-->
			
			<!--关于楼盘部分开始-->
			<div class="row-fluid" id="part1">
				<!--楼盘大全开始-->
				<div class="span9" id="AllProperty">
					
					<div class="part5-title">
						<h5>楼盘大全</h5>
					</div>
					<!--楼盘大全开始-->
				  	<div class="span4" id="AllProperty01" style="width:100%;">
						<table style="width:100%;">
						<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr height="25">
								<td style="width:33.33%"><span class="PropertyArea"><?php echo ($info["area"]); ?></span></td>
								<td><a href="#" class="PropertyName"><?php echo ($info["name"]); ?></a></td>
								<td><a href="#" class="PropertyPrice"><?php echo ($info["price"]); ?>元/平米</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</table>
					</div>
					
				</div>
				<!--楼盘大全结束-->
			</div>
			<!--关于楼盘部分结束-->
			
			<!--二手房、租房开始-->
			<div class="row-fluid" id="part7">
				<div class="span12">
					<div class="tabbable" id="tabs-932533">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-430111" data-toggle="tab">二手房</a>
							</li>
							<li>
								<a href="#panel-451213" data-toggle="tab">租房</a>
							</li>
						</ul>
						
						<!--选项卡内容部分开始-->
						<div class="tab-content">
							<!--二手房内容开始-->
							<div class="tab-pane active" id="panel-430111">
								<!--二手房楼盘-->
								<div class="span4" id="ShopProperty" style="width:100%;">
									<table style="width:100%;">
										<tr align="left" height="30" class="table-title">
											<td class="td-Propertyname" style="width:25%">楼盘名称</td>
											<td>房型</td>
											<td>价格</td>
											<td class="td-area">区域</td>
										</tr>
										<?php if(is_array($second)): $i = 0; $__LIST__ = $second;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<td class="td-Propertyname">
													<a href="#" class="PropertyName"><?php echo ($vo["name"]); ?></a>
												</td>
												<td><span><?php echo ($vo["type"]); ?></span></td>
												<td><span><?php echo ($vo["price"]); ?>万</span></td>
												<td width="40" class="td-area">
													<span class="PropertyArea"><?php echo ($vo["area"]); ?></span>
												</td>
											</tr><?php endforeach; endif; else: echo "" ;endif; ?>
									</table>

								</div>
							
							</div>
							<!--二手房内容结束-->
							
							<!--租房内容开始-->
							<div class="tab-pane" id="panel-451213">
								<!--租房-->
								<table>
									<tr>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse01.jpg" width="125" height="85" border="0"></a></td>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse02.jpg" width="125" height="85" border="0"></a></td>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse03.jpg" width="125" height="85" border="0"></a></td>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse04.jpg" width="125" height="85" border="0"></a></td>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse05.jpg" width="125" height="85" border="0"></a></td>
										<td width="155"><a href="#"><img src="/yxy/Public/img/RentHouse/rentHouse06.jpg" width="125" height="85" border="0"></a></td>
									</tr>
									<tr height="105">
									<?php if(is_array($rent)): $i = 0; $__LIST__ = $rent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td valign="top">
											<p><a href="#"><?php echo ($vo["name"]); ?></a></p>
											<p class="PropertyPrice">价格:<?php echo ($vo["price"]); ?>元/月</p>
											<p>房型:<?php echo ($vo["type"]); ?></p>
											<p>区域:<?php echo ($vo["area"]); ?></p>
										</td><?php endforeach; endif; else: echo "" ;endif; ?>
									</tr>
									
								</table>
							</div>
							<!--租房内容结束-->
							
						</div>
						<!--选项卡内容结束-->
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--container结束-->
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
</body>
</html>