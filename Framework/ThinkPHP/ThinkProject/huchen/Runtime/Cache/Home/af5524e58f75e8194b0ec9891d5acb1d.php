<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/hc/Public/css/pintuer.css">
<link rel="stylesheet" href="/hc/Public/css/admin.css">
<script src="/hc/Public/js/jquery.js"></script>
<script src="/hc/Public/js/pintuer.js"></script>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>课程管理</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('Admin/addClass');?>">  
      <div class="form-group">
        <div class="label">
          <label>课程名称:</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="cname" data-validate="required:请输入课程名称" />
          <div class="tips"></div>
        </div>
      </div>    

      <div class="form-group">
        <div class="label">
          <label>学分:</label>
        </div>
        <div class="field">
          <input type="text" name="credit" class="input w50" data-validate="required:请输入学分"/>
          <div class="tips"></div>
        </div>
      </div>
      
      <div class="form-group">
      	<div class="label">
      		<label for="课程性质">课程性质</label>
      	</div>
      	<div class="field">
      		<select name="require" id="" class="input w50">
      			<option value="必修课">必修课</option>
      			<option value="公共任选课">公共任选课</option>
      			<option value="限选课">限选课</option>
      		</select>
      	</div>
      </div>
      
      <div class="form-group">
      	<div class="label">
      		<label for="教工号">教工号</label>
      	</div>
      	<div class="field">
      		<input type="text" name="tno" class="input w50" data-validate="required:请输入教工号" />
      		<div class="tips"></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<div class="label">
      		<label for="学期">学期:</label>
      	</div>
      	<div class="field">
      		<input type="text" name="term" class="input w50" data-validate="required:请输入学期" />
      		<div class="tips"></div>
      	</div>
      </div>
     
      <div class="clear"></div>

      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body></html>