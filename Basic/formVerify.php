<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>JavaScript和PHP综合示例----表单验证</title>
	<script>
		function form_sub() 
		{
			if (!test_username(document.form1.username.value)) //检测姓名
			{
				alert("姓名格式不正确");
				return false;
			}	
			
			if (!test_date(document.forms.birthday.value)) //检测日期
			{
				alert("日期格式不正确");
				return false;
			}
			
			if (!test_email(document.form1.email.value)) //检测E-mail 
			{
				alert("E-mail地址格式不正确");
				return false;
			}
			
			if (!test_password(document.form1.password.value,document.form1.password.value))
			{
				alert("两次密码输入不相同");
				return false;
			}
		}
		
		function test_username(str_username) //检测用户名的函数 
		{
			var pattern = /[a-zA-Z_]/;
			if (pattern.test(str_username))
				return true;
			else 
				return false;
		}
		
		function test_date(str_birthday) //检测日期的函数
		{
			var pattern = /[0-9]{4}-[0-9]{2}-[0-9]{2}/
			if (pattern.test(str_birthday))
				return true;
			else
				return false;
		}
		
		function test_email(str_email) //检测E-mail的函数
		{
			var pattern = /^[a-zA-Z0-9_.]+@([a-zA-Z0-9_]+.)+[a-zA-Z]{2,3}$/;
			if (pattern.test(str_email))
				return true;
			else
				return false;
		}
		
		function test_password(str_p1, str_p2) //检测密码的函数 
		{
			if (str_p1 == str_p2) 
				return true;
			else	
				return false;
		}
	</script>
</head>
<body>
	<form action="post.php" method="get" name="form1" onsubmit="return form_sub()">
		<table width="271" border="0" align="center" cellpadding="0" cellspacing="0">
			
			<tr>
				<td width="85">
					<div align="right">姓名:</div>
				</td>
				<td width="186">
					<input type="text" name="username" id="username" />
				</td>
			</tr>
			<tr>
				<td><div align="right">密码:</div></td>
				<td><input name="password" type="password" id="password"/></td>
			</tr>
			<tr>
				<td><div align="right">密码确认:</div></td>
				<td><input name="password2" type="password" id="password2"/></td>
			</tr>
			<tr>
				<td><div align="right">性别:</div></td>
				<td><select name="sex" id="sex">
					<option value="0" selected>男</option>
					<option value="1">女</option>
				</select></td>
			</tr>
			<tr>
				<td><div align="right">生日</div></td>
				<td><input type="text" name="birthday" id="birthday" /></td>
			</tr>
			<tr>
				<td><div align="right">E-mail</div></td>
				<td><input name="email" type="email" id="email"/></td>
			</tr>
			<tr>
				<td><div align="right">职业:</div></td>
				<td><input type="text" name="job" id="job"></td>
			</tr>
		</table>
		<p align="center">
			<input type="submit" value="Submit" />
			<input type="reset" value="Reset" />
		</p>
	</form>
</body>
</html>
<?php

?>