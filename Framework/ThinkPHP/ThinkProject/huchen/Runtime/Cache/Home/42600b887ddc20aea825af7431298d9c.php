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
    <div class="panel-head"><strong class="icon-reorder"> 教师查询</strong></div>
    <div class="padding border-bottom">
    <form action="<?php echo U('Teacher/search');?>" method="post">
      <ul class="search">
        <li>
          <span class="span">搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索:</span>
          <input type="text" name="name" id="name" placeholder="教师姓名或者教工号" data-validate="required:请输入内容" style="height:43px;width:63%;"/>
			<br /><br />
          <input type="submit"  class="button border-green icon-search" style="float:left;" value="搜索">
        </li>
      </ul>
     </form>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th>教工号</th>
        <th>姓名</th>       
        <th>性别</th>
        <th>QQ</th>
        <th>邮箱</th>
        <th>联系方式</th>
        <th>简介</th>
        <th>系别</th>
        <th width="25%">地址</th>
      </tr>     
      <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td><?php echo ($vo["tno"]); ?></td>
          <td><?php echo ($vo["truename"]); ?></td>
          <td><?php echo ($vo["tsex"]); ?></td>
          <td><?php echo ($vo["qq"]); ?></td>  
           <td><?php echo ($vo["email"]); ?></td>         
          <td><?php echo ($vo["phone"]); ?></td>
          <td><?php echo ($vo["signature"]); ?></td>
          <td><?php echo ($vo["depart"]); ?></td>
          <td><?php echo ($vo["taddr"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
        
      <tr>
        <td colspan="8"><div class="pagelist"> <?php echo ($page); ?></div></td>
      </tr>
    </table>
  </div>
</form>
</body></html>