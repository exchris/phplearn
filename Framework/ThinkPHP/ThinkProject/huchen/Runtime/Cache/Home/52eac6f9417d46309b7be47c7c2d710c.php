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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>提交留言</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('Teacher/editMsg');?>"> 
      <input type="hidden" name="id" value="<?php echo ($result['id']); ?>" />
      <div class="form-group">
        <div class="label">
          <label>标题:</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($result['title']); ?>" name="title" data-validate="required:请输入标题" />
          <div class="tips"></div>
        </div>
      </div>    

      <div class="form-group">
        <div class="label">
          <label>留言内容:</label>
        </div>
        <div class="field">
          <textarea name="content" class="input" style="height:300px; border:1px solid #ddd;" data-validate="required:请输入留言内容"><?php echo ($result['content']); ?></textarea>
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