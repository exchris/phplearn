<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>楼盘，新房</title>

<link href="/yxy/Public/css/bootstrap.min.css" rel="stylesheet">
<link href="/yxy/Public/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/yxy/Public/css/common/top.css" rel="stylesheet" type="text/css" />
<link href="/yxy/Public/css/common/foot.css" rel="stylesheet" type="text/css" />
<link href="/yxy/Public/css/Property.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/yxy/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/yxy/Public/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/yxy/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/yxy/Public/js/scripts.js"></script>


</head>

<body>

<div class="container-fluid">
	<!--头部开始-->
	<div id="top">
		<div class="span2" id="logo">
			<a href="<?php echo U('Index/index');?>"><img src="/yxy/Public/property/logo.png" width="150" height="50" border="0"></a>
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
								<li >
									<a href="<?php echo U('Property/property');?>">楼盘</a>
								</li>
								<li>
									<a href="<?php echo U('Property/renting');?>">租房</a>
								</li>
								<li>
									<a href="<?php echo U('Property/secondhandhouse');?>">二手房</a>
								</li>
								<li >
									<a href="<?php echo U('Property/buy');?>">买房</a>
								</li>
								<li class="active"> 
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
								<!--<li>
									<a href="#">倾城自恋</a>
								</li>-->
								<li class="divider-vertical">
								</li>
								<?php if($username != ''): ?><li class="dropdown">
									 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
									  <?php if($username == ''): ?>我的
									 <?php else: ?>
									 	<?php echo ($username); endif; ?>
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
										<li class="divider"></li>
										<li>
											<a href="<?php echo U('Index/index');?>">退出</a>
										</li>
										
									</ul>
								</li>
								<?php else: ?>
								<li></li><?php endif; ?>
							</ul>
						</div>
						
				</div>
				
			</div>
			<!--导航结束-->
	</div>
	
	<!--条件搜索-->
	<div class="span12" id="ConditionSearch">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr height="30">
				<td width="40"><span>区域：</span></td>
				<td width="40"><a class="allCondition" href="#" onclick="a('area')">全部</a></td>
				<td width="840">
					<a href="#" onclick="a('新区')">新区</a>
					<a href="#" onclick="a('惠山')">惠山</a>
					<a href="#" onclick="a('锡山')">锡山</a>
					<a href="#" onclick="a('北塘')">北塘</a>
					<a href="#" onclick="a('南长')">南长</a>
					<a href="#" onclick="a('崇安')">崇安</a>
					<a href="#" onclick="a('滨湖')">滨湖</a>
					<a href="#" onclick="a('宜兴')">宜兴</a>
				</td>
			</tr>
			<tr height="30">
				<td><span>价格：</span></td>
				<td><a class="allCondition" href="#" onclick="a('price')">全部</a></td>
				<td>
					<a href="#" onclick="a(1)">6000以下</a>
					<a href="#" onclick="a(2)">6000-7000</a>
					<a href="#" onclick="a(3)">7000-8000</a>
					<a href="#" onclick="a(4)">8000-1万</a>
					<a href="#" onclick="a(5)">1万-1.2万</a>
					<a href="#" onclick="a(6)">1.2万以上</a>
				</td>
			</tr>
			<tr height="30">
				<td><span>户型：</span></td>
				<td><a class="allCondition" href="#" onclick="a('huxing')">全部</a></td>
				<td>
					<a href="#" onclick="a(11)">一室</a>
					<a href="#" onclick="a(12)">二室</a>
					<a href="#" onclick="a(13)">三室</a>
					<a href="#" onclick="a(14)">四室</a>
					<a href="#" onclick="a(15)">5室以上</a>
				</td>
			</tr>
			<tr height="30">
				<td><span>类型：</span></td>
				<td><a class="allCondition" href="#" onclick="a('type')">全部</a></td>
				<td>
					<a href="#" onclick="a(21)">住宅</a>
					<a href="#" onclick="a(22)">别墅</a>
					<a href="#" onclick="a(23)">写字楼</a>
					<a href="#" onclick="a(24)">商铺</a>
				</td>
			</tr>
		</table>

	</div>
	
	<!--条件搜索结束-->
	
	<div class="span12" id="Content">
		<!--楼盘列表开始-->
		<div class="span9" id="PropertyList">
			<table cellpadding="0" cellspacing="0" width="700" border="0" id="res">
				<tr height="40" class="FirstLine">
					<td align="center"><p>共有<span class="SearchResults"><?php echo ($count); ?></span>个符合要求的楼盘</p></td>
					<td colspan="2" align="right">
						<button class="btn btn-info" type="button" >默认</button>
						<button class="btn btn-info" type="button" id="price" onclick="price()">价格↑</button>
					</td>
				</tr>
				<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr height="150">
					<td width="200" align="center"><a href="<?php echo U('Property/propertydetail');?>"><img src="/yxy/Public/property/Property/<?php echo ($vo["image"]); ?>" width="160" height="117" border="0" /></a></td>
					<td width="350">
						<p><a href="<?php echo U('Property/propertydetail');?>" class="PropertyName"><?php echo ($vo["name"]); ?></a></p>
						<p>主推户型：<?php echo ($vo["type"]); ?></p>
						<p>面积：<?php echo ($vo["big"]); ?>平米</p>
						<p>地址：<a href="#">[<?php echo ($vo["area"]); ?>]</a> <?php echo ($vo["addr"]); ?></p>
						<p>电话：<?php echo ($vo["phone"]); ?></p>
					</td>
					<td align="center" width="150"><p>均价<span class="PropertyPrice"><?php echo ($vo["avg"]); ?></span>元/平米</p></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<!-- <tr height="40" class="tr-bgclor">
					  <td width="30" colspan="3">
					  	<div class="span8" id="page">
							<a href="#">尾页</a>
							<a href="#">下一页</a>
							<a href="#">2</a>
							<a href="#">1</a>
							<a href="#">上一页</a>
					  		<a href="#">第一页</a>
							
						</div>
					  </td>
						
					</tr> -->
			</table>
			
			
			
		</div>
		<!--楼盘列表结束-->
	
	</div>
	
	
	
	
		
</div>


	<div class="clear"></div>

<script>
function a(b){
	//$("#res").hide();
	var dash = '';
	var d = '';
	$.ajax({
		type:"get",
		url:"<?php echo U('Property/searchs');?>",
		async:true,
		data:{id:b},
		success(re){
			var data = eval(re);
			var length = data.length;
			for (var x in data) {
				var url = 'http://localhost/yxy/index.php/Home/Property/propertydetail.html?id='+data[x]['id'];
				dash += "<tr height='150'><td width='200' align='center'><a href='www.baidu.com'>";
				dash += "<img src='/yxy/Public/property/Property/"+data[x]['image']+"' width='160' height='117' border='0' /></a></td>";
				dash += "<td width='350'><p><a href='"+url+"' class='PropertyName'>"+data[x]['name']+"></a></p>";
				dash += "<p>主推户型:"+data[x]['type']+"</p><p>面积:"+data[x]['big']+"平米</p>";
				dash += "<p>地址：<a href='#'>[新区]</a>"+data[x]['addr']+"</p><p>电话："+data[x]['phone']+"</p></td>";
				dash += "<td align='center' width='150'><p>均价<span class='PropertyPrice'>"+data[x]['avg']+"</span>元/平米</p></td></tr>";
			}
			d += "<table cellpadding='0' cellspacing='0' width='700' border='0' id='res'>";
			d += "<tr height='40' class='FirstLine'>";
			d += "<td align='center'><p>共有<span class='SearchResults'>"+length+"</span>个符合要求的楼盘</p></td>";
			d += "<td colspan='2' align='right'><button class='btn btn-info' type='button' >默认</button>";
			d += "<button class='btn btn-info' type='button'>价格↑</button></td></tr>";
			d += dash;
			$("#res").html(d);
		},
		error(data) {
			alert(2);
		}
	});
}

</script>


</body>
</html>