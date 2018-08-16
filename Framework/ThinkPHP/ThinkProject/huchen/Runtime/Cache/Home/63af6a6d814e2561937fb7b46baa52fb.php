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
    <div class="panel-head"><strong class="icon-reorder"> 学生信息管理</strong></div>
    <div class="padding border-bottom">
      <ul class="search">
        <li>
          <button type="button"  class="button border-green" id="checkall"><span class="icon-check"></span> 全选</button>
          <button type="submit" class="button border-red"><span class="icon-trash-o"></span> 批量删除</button>
        </li>
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="120">学号</th>
        <th>姓名</th>       
        <th>性别</th>
        <th>专业</th>
        <th>系别</th>
        <th width="25%">地址</th>
         <th width="120">是否在校</th>
        <th>操作</th>       
      </tr>     
      <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td><input type="checkbox" name="id[]" value="1" />
            <?php echo ($vo["sno"]); ?></td>
          <td><?php echo ($vo["truename"]); ?></td>
          <td><?php echo ($vo["ssex"]); ?></td>
          <td><?php echo ($vo["major"]); ?></td>  
           <td><?php echo ($vo["depart"]); ?></td>         
          <td><?php echo ($vo["saddr"]); ?></td>
          <td><?php if($vo["state"] == 1): ?>在校
          <?php else: ?>毕业<?php endif; ?></td>
          <td>
          <div class="button-group">
          	<a href="<?php echo U('Admin/addStudent');?>" class="button border-red"">
          		<span class="icon-tint">添加</span>
          	</a>
          	</div>
          	<div class="button-group">
          	<a href="<?php echo U('Admin/editStudent?id='.$vo['sno']);?>" class="button border-red"">
          		<span class="icon-edit">修改</span>
          	</a>
          	</div>
         	<div class="button-group"> 
         	<a class="button border-red" href="<?php echo U('Admin/delStudent?id='.$vo['sno']);?>">
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

function del(id){
	if(confirm("您确定要删除吗?")){
		
	}
}

$("#checkall").click(function(){ 
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})

function DelSelect(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false; 		
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}

</script>
</body></html>