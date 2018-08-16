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
    <script src="/hc/Public/ js/pintuer.js"></script>  
</head>
<body>
<form method="post" action="">
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 留言管理</strong></div>
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
        <th>留言ID</th>
        <th>留言标题</th>
        <th>留言者</th>
        <th width="25%">留言内容</th>
         <th width="30%">留言时间</th>
         <th>操作</th> 
      </tr>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
      		<td><input type="checkbox" name="id[]" value="1" /><?php echo ($vo["id"]); ?></td>
      		<td><?php echo ($vo["title"]); ?></td>
      		<td><?php echo ($vo["uid"]); ?></td>
      		<td><?php echo ($vo["content"]); ?></td>
      		<td><?php echo ($vo["datetime"]); ?></td>
      	<td>
          <div class="button-group">
          	<a href="<?php echo U('Teacher/addMsg');?>" class="button border-green">
          		<span class="icon-tint">添加</span>
          	</a>
          	</div>
    
          	<div class="button-group">
          	<a href="<?php echo U('Teacher/editMsg?id='.$vo['id']);?>" class="button border-red">
          		<span class="icon-edit">修改</span>
          	</a>
          	</div>
         	<div class="button-group"> 
         	<a class="button border-blue" href="<?php echo U('Teacher/delMsg?id='.$vo['id']);?>">
         		<span class="icon-trash-o"></span> 删除</a> 
         	</div>
         </td>
         </tr><?php endforeach; endif; else: echo "" ;endif; ?>  
      <tr>
        <td colspan="8">
        	<div class="pagelist"> 
        		<!-- <a href="">上一页</a> 
        		<span class="current">1</span>
        		<a href="">2</a>
        		<a href="">3</a>
        		<a href="">下一页</a>
        		<a href="">尾页</a>  -->
        		<?php echo ($page); ?>
        	</div>
        </td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">

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

</script>
</body></html>