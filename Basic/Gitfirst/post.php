
	<?php
	
	//本程序用于接收来自HTML页面的表单数据并进行相应的验证
	$founderr = false; //初始化founderr变量,表示没有错误
	if (!ereg("[a-zA-Z_]", $_POST['username'])) //检查用户名
	{
		echo "姓名格式不正确<br>";
			$founderr = true;
	}
	
	if (!ereg("[0-9]{4}-[0-9]{2}-[0-9]{2}", $_POST['birthday'])) //检查日期格式
	{
		echo "日期格式不正确<br>";
		$founderr = true;
	}
	
	if (!ereg("^[a-zA-Z0-9_.]+@([a-zA-Z0-9_]+.)+[a-zA-Z]{2,3}$", $_POST['email'])) //检查E-mail格式
	{
		echo "E-mail地址格式不正确<br>";
		$founderr = true;
	}
	
	if ($_POST['password'] != $_POST['password2']) //检查密码
	{
		echo "两次密码输入不相同";
		$founderr = true;
	}

if (!$founderr) //如果通过验证,输出页面
{
	?>
	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>JavaScript和PHP--表单验证</title>
	</head>
	<body>
		<table width="271" border="0" align="center" cellpadding="0" cellspacing="0">
			
			<tr>
				<td width="85">
					<div align="right">姓名:</div>
				</td>
				<td width="186">
					<?php echo $_POST['username'];?>
				</td>
			</tr>
			<tr>
				<td><div align="right">密码:</div></td>
				<td><?php echo $_POST['password'];?></td>
			</tr>
			<tr>
				<td><div align="right">性别:</div></td>
				<td><?php if ($_POST['sex'] == 0) echo "男"; else echo "女";?></td>
			</tr>
			<tr>
				<td><div align="right">生日</div></td>
				<td><?php echo $_POST['birthday'];?></td>
			</tr>
			<tr>
				<td><div align="right">E-mail</div></td>
				<td><?php echo $_POST['email'];?></td>
			</tr>
			<tr>
				<td><div align="right">职业:</div></td>
				<td><?php echo $_POST['job'];?></td>
			</tr>
		</table>
	</body>
	</html>
<?php } ?>
