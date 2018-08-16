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
<form method="post" action="">
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 课程管理</strong></div>
    <div class="padding border-bottom">
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th>课程号</th>
        <th>课程名称</th>       
        <th>学分</th>
        <th>教师</th>
        <th>学期</th>
        <th>课程性质</th>
        <th>操作</th>      
      </tr>     
      <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td>
            <?php echo ($vo["cno"]); ?></td>
          <td><?php echo ($vo["cname"]); ?></td>
          <td><?php echo ($vo["credit"]); ?></td>
          <td><?php echo ($vo["truename"]); ?></td>  
           <td><?php echo ($vo["term"]); ?></td>         
          <td><?php echo ($vo["require"]); ?></td>
          <td>
          	<div class="button-group">
          	<a href="<?php echo U('Admin/addClass');?>" class="button border-red"">
          		<span class="icon-tint">添加</span>
          	</a>
          	</div>
          	<div class="button-group">
          	<a href="<?php echo U('Admin/editClass?cno='.$vo['cno']);?>" class="button border-red"">
          		<span class="icon-edit">修改</span>
          	</a>
          	</div>
         	<div class="button-group"> 
         	<a class="button border-red" href="<?php echo U('Admin/delClass?cno='.$vo['cno']);?>">
         		<span class="icon-trash-o"></span> 删除</a> 
         	</div>
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
        
      <tr>
        <td colspan="8"><div class="pagelist"> <?php echo ($page); ?></div></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">
$(function(){
	$("#search").blur(function(e){
		var content = $(this).val();
		if (content == "") {
			$("#content").html("请您输入学生姓名或学号");
			$("#content").css({"color":"red","float":"left","margin-left":"64px"});
		} else {
			$("#content").hide();
		}
	}); 
});

</script>
</body></html>