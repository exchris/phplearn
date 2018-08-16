<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>地区三级联动</title>
	<script>
		//创建Ajax对象
		function createAjax() {
			var xmlHttp = false;
			if (window.XMLHttpRequest) {
				//主流浏览器方式创建Ajax对象
				xmlHttp = new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				try {
					//IE方式创建Ajax对象
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch(e) {
					try {
						//IE方式创建Ajax对象
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP")；
					} catch(e) {
						xmlHttp = false;
					}
				}
			}
			return xmlHttp;
		}
		var ajax = null;
		// 获得省下的所有城市
		function getCity(province_id) {
			//调用函数createAjax获得Ajax对象
			ajax = createAjax();
			//感知Ajax状态
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4 && ajax.status == 200) {
					//接收服务器返回的JSON格式的城市信息
					eval("var info="+ajax.responseText);
					//将city下拉列表的选项置为零,避免重新选择省时,城市信息叠加显示
					$('city').length = 0;
					//重新为city元素创建option节点
					var myoption = document.createElement("option");
					myoption.value = "";
					myoption.innerHTML = "--请选择城市--";
					//将option节点追加到city元素节点后
					$('city').appendChild(myoption);
					//循环将获得的JSON信息追加到city元素节点的子节点option
					for(var i=0; i<info.length;i++) {
						var myoption = document.createElement("option");
						myoption.value = info[i].city_id;
						myoption.innerHTML = info[i].city_name;
						$('city').appendChild(myoption);
					}
				}
			}
			//创建一个http请求,并设置"请求地址"及异步请求方式
			ajax.open("post", "selectPro.php", true);
			//设置HTTP头协议信息
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			//发送请求信息
			ajax.send("province_id="+province_id);
		}
		//获得城市下所有的县
		function getCounty(city_id){
			//调用函数createAjax获得Ajax对象
			ajax = createAjax();
			//感知Ajax状态
			ajax.onreadystatechange=function(){
				if(ajax.readyState == 4 && ajax.status == 200){
					//接收服务器返回的JSON格式的城市信息
					eval(" var info="+ajax.responseText);
					//将county下拉列表的选项置为零，避免重新选择城市时，县信息叠加显示
					$('county').length=0;
					//重新为county元素创建option节点
					var myoption = document.createElement("option");
					myoption.value = "";
					myoption.innerHTML = "--请选择县--" ;
					//将option节点追加到county元素节点后
					$('county').appendChild(myoption);
					//循环将获得的JSON信息追加到county元素节点的子节点option
					for(var i=0;i<info.length;i++){
						var myoption = document.createElement("option");
						myoption.value = info[i].county_id;
						myoption.innerHTML = info[i].county_name;
						$('county').appendChild(myoption);
					}
				}
			}
			//创建一个http请求，并设置"请求地址"及异步请求方式
			ajax.open("post","selectPro.php",true);
			//设置HTTP头协议信息
			ajax.setRequestHeader("Content-Type", 
	"application/x-www-form-urlencoded");
			//发送请求信息
			ajax.send("city_id="+city_id);
		}
		//模仿jQuery的选择器
		function $(id){
			return document.getElementById(id);
		}
	</script>
</head>
<body>
	<form name="location">
		<select name="province" onchange="getCity(this.value)">
			<option value="">--请选择省份--</option>
			<?php 
				//包含连接数据库的文件
				require 'conn.php';
				$sql = "select * from province";
				//执行SQL语句
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				//处理结果集
				while(($res = $stmt->fetch())!=false) {
			?>
			<option value="<?php echo $res['province_id'];?>">
			<?php echo $res['province_name']?>
			</option>
			<?php 
				}
			?>
		</select>
		<select name="city" id="city" onChange="getCounty(this.value)">
			<option value="">--请选择城市--</option>
		</select>
		<select name="county" id="county">
			<option value="">--请选择县--</option>
		</select>
	</form>
</body>
</html>
