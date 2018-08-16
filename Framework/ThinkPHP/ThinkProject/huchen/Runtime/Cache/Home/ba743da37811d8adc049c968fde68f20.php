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
    <div class="panel-head"><strong class="icon-reorder"> 成绩查询</strong></div>
    <div class="padding border-bottom">
    <form action="<?php echo U('Index/score');?>" method="post">
      <ul class="search">
        <li>
          <span class="span">内&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;容:</span>
          <input type="text" name="name" id="name" placeholder="课程,教师" data-validate="required:请输入内容" style="height:43px;width:63%;"/>
          <br /><br />
          <p style="color:red;">两个搜索只能二选一(<strong>由于技术问题</strong>)</p>
     	  <span class="span">成绩范围:</span>
     	  <input type="text" name="from" id="from" style="height:43px;width:15%;"/>
     	  <span>To</span>
     	  <input type="text" name="to" id="to" style="height:43px;width:15%;"/>
     	  <br /><br />
          <input type="submit"  class="button border-green icon-search" style="float:left;" value="搜索">
        </li>
      </ul>
      </form>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="120">课程号</th>
        <th>课程名称</th>       
        <th>学分</th>
        <th>教师</th>
        <th>分数</th>
        <th width="25%">课程类型</th>
         <th width="25%">学期</th>      
      </tr>      
	  <?php if(is_array($score)): $i = 0; $__LIST__ = $score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
  		<td><?php echo ($vo["cno"]); ?></td>
  		<td><?php echo ($vo["cname"]); ?></td>
  		<td><?php echo ($vo["credit"]); ?></td>
  		<td><?php echo ($vo["truename"]); ?></td>
  		<td><?php echo ($vo["score"]); ?></td>
  		<td><?php echo ($vo["require"]); ?></td>
  		<td><?php echo ($vo["term"]); ?></td>
	  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td colspan="8">
        	<div class="pagelist"> 
        		<?php echo ($page); ?> 
        	</div>
        </td>
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