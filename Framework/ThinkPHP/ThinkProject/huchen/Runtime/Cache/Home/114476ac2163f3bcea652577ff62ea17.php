<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>thinkphp与excel导入导出</title>
</head>
<body>
	<p><a href="<?php echo U('Test/expUser');?>">导出数据并生成excel</a></p><br />
	<form action="<?php echo U('Test/upload');?>" method="post" enctype="multipart/form-data">
		<input type="file" name="import" />
		<input type="hidden" name="table" value="tablename" />
		<input type="submit" value="导入" />
	</form>
</body>
</html>