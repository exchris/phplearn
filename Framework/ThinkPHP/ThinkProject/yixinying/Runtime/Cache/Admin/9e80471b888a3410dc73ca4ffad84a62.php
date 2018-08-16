<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/yxy/Public/admin/img/logo.png"/>
    <title>房产后台管理系统</title>
    <link href="/yxy/Public/admin/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/yxy/Public/admin/css/mmss.css"/>
    <link rel="stylesheet" href="/yxy/Public/admin/css/font-awesome.min.css"/>
    <!--[if lt IE 9]>
    <script src="/yxy/Public/admin/js/html5shiv.min.js"></script>
    <script src="/yxy/Public/admin/js/respond.min.js"></script>
    <![endif]-->
    <style>

    </style>
</head>
<body>
<header>
    <div class="container-fluid navbar-fixed-top bg-primary">
        <ul class="nav navbar-nav  left">
            <li class="text-white h4">
                &nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-leaf"></span>&nbsp;&nbsp;<b>房产后台管理系统</b>
            </li>
        </ul>
        <ul class="nav navbar-nav nav-pills right ">
            
            <li class="bg-info dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;<span>系统管理员</span><span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="text-center"><a href="#"><span class="text-primary">账号设置</span></a></li>
                    <li class="text-center"><a href="#"><span class="text-primary">消息设置</span></a></li>
                    <li class="text-center"><a href="#"><span class="text-primary">帮助中心</span></a></li>
                    <li class="divider"><a href="#"></a></li>
                    <li class="text-center"><a href="<?php echo U('User/logout');?>"><span class="text-primary">退出</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<section >
    <div class="container-fluid">
        <div class="row ">
            <!--左侧导航开始-->
            <div class="col-xs-2 bg-blue">
                <br/>
                <div class="panel-group sidebar-menu" id="accordion" aria-multiselectable="true">
                    <div class="panel panel-default menu-first">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                           aria-controls="collapseOne">
                            <i class="icon-user-md icon-large"></i> 系统管理</a>
                        </a>

                         <div id="collapseOne" class="panel-collapse collapse " >
                            <ul class="nav nav-list menu-second">
                                <li><a href="<?php echo U('Estate/estate');?>"><i class="icon-list"></i>&nbsp;&nbsp;&nbsp;楼盘管理</a></li>
                                <li><a href="<?php echo U('Renting/renting');?>"><i class="icon-list"></i>&nbsp;&nbsp;&nbsp;租房管理</a></li>
                                <li><a href="<?php echo U('Second/second');?>"><i class="icon-list"></i>二手房管理</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default menu-first">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                           aria-expanded="false" aria-controls="collapseTwo">
                            <i class="icon-book icon-large"></i> 用户管理</a>
                        </a>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <ul class="nav nav-list menu-second">
                                <li><a href="<?php echo U('User/user');?>"><i class="icon-user"></i> 用户管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--左侧导航结束-->
            <!----------------------------------------------------------------------------------------------------->
            <!--右侧内容开始-->
            <div class="col-xs-10">
                <br/>
                <ol class="breadcrumb">
                    <li><a href="index.html"><span class="glyphicon glyphicon-home"></span>&nbsp;后台首页</a></li>
                    <li class="active">系统管理 - 二手房管理</li>
                </ol>
                <br/><br/>
                <table class="table table-bordered table-striped text-center bg-info">
                    <thead >
                    <tr class="info">
                        <th class="text-center">名字</th>
                        <th class="text-center">区域</th>
                        <th class="text-center">价格</th>
                        <th class="text-center">屋型</th>
                        <th class="text-center">面积</th>
                        <th class="text-center">地址</th>
                        <th class="text-center">来源</th>
                        <th class="text-center">电话</th>
                        <th class="text-center">房贷方式</th>
                        <th class="text-center">简介</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    	<td><?php echo ($vo["name"]); ?></td>
                    	<td><?php echo ($vo["area"]); ?></td>
                    	<td><?php echo ($vo["price"]); ?></td>
                    	<td><?php echo ($vo["type"]); ?></td>
                  		<td><?php echo ($vo["mianji"]); ?></td>
                    	<td><?php echo ($vo["addr"]); ?></td>
                    	<td><?php echo ($vo["from"]); ?></td>
                    	<td><?php echo ($vo["phone"]); ?></td>
                    	<td><?php echo ($vo["mortgage"]); ?></td>
                    	<td><?php echo ($vo["summary"]); ?></td>
                    	<td>
                    		<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add1">添加</a>
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" onclick="model_edit(<?php echo ($vo["id"]); ?>)" data-target="#edit">编辑</a>
                            <a href="#" class="btn btn-primary btn-sm" onclick="model_delete(<?php echo ($vo["id"]); ?>)">删除</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    
                    <!-- Modal begin-->
                    <div class="modal fade" id="add1" tabindex="-1" role="dialog" aria-labelledby="add11">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="add11">添加</h4>
                                    </div>
                                    <form action="<?php echo U('Second/save');?>" method="post">
                                    <div class="modal-body">
                                    <ul>
                                    	<li>
                                    		<label><span>名字:</span></label>
                                    		<input type="text" name="name" required="required" />
                                    	</li>
                                            <li>
                                                <label><span>区域 ：</span></label>
                                                <select name="area">
                                                	<option value="新区">新区</option>
                                                	<option value="惠山">惠山</option>
                                                	<option value="江阴">江阴</option>
                                                	<option value="锡山">锡山</option>
                                                	<option value="北塘">北塘</option>
                                                	<option value="南长">南长</option>
                                                	<option value="崇安">崇安</option>
                                                	<option value="滨湖">滨湖</option>
                                                	<option value="宜兴">宜兴</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label><span>价格 :</span></label>
                                                <input type="text" name="price" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>屋型:</span></label>
                                                <input type="text" name="type" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>面积 :</span></label>
                                                <input type="text" name="mianji" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>地址 :</span></label>
                                                <input type="text" name="addr"/>
                                            </li>
                                            <li>
                                                <label><span>来源 :</span></label>
                                                <input type="text" name="from" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>电话 :</span></label>
                                                <input type="text" name="phone" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>房贷方式:</span></label>
                                                <input type="text" name="mortgage" required="required"/>
                                            </li>
                                            <li>
                                            	<label><span>简介:</span></label>
                                            	<input type="text" name="summary"  />
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                                        <button type="submit" class="btn btn-primary btn-sm">保存</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!--编辑-->
                       <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="edit" aria-label="Close"><span aria-hidden="true" data-dismiss="modal">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel1">编辑</h4>
                                    </div>
                                    <form action="<?php echo U('Second/update');?>" method="post">
                                    <div class="modal-body">
                                    <input type="hidden" id="id" name="id" />
                                        <ul>
                                    	<li>
                                    		<label><span>名字:</span></label>
                                    		<input type="text" name="name" id="name" required="required" />
                                    	</li>
                                            <li>
                                                <label><span>区域:</span></label>
                                                <select name="area" id="area">
                                                	<option value="新区">新区</option>
                                                	<option value="惠山">惠山</option>
                                                	<option value="江阴">江阴</option>
                                                	<option value="锡山">锡山</option>
                                                	<option value="北塘">北塘</option>
                                                	<option value="南长">南长</option>
                                                	<option value="崇安">崇安</option>
                                                	<option value="滨湖">滨湖</option>
                                                	<option value="宜兴">宜兴</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label><span>价格 :</span></label>
                                                <input type="text" name="price" id="price"　required="required"/>
                                            </li>
                                            <li>
                                                <label><span>屋型:</span></label>
                                                <input type="text" name="type" id="type" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>面积:</span></label>
                                                <input type="text" name="mianji" id="mianji" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>地址 :</span></label>
                                                <input type="text" name="addr" id="addr" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>来源 :</span></label>
                                                <input type="text" name="from" id="from" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>电话:</span></label>
                                                <input type="text" name="phone" id="phone" required="required"/>
                                            </li>
                                            <li>
                                                <label><span>房贷方式:</span></label>
                                                <input type="text" name="mortgage" id="mortgage" required="required"/>
                                            </li>
                                            <li>
                                            	<label><span>简介:</span></label>
                                            	<input type="text" name="summary" id="summary" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                                        <button type="submit" class="btn btn-primary btn-sm">保存</button>
                                    </div>
                                    
                                </div>
                                </form>
                            </div>
                      
                        </div>
                        <!--Modal end-->
                        
                   </tbody>
                </table>
                <ul class="pagination right">
                    <?php echo ($page); ?>
                </ul>
            </div>
            <!--右侧内容结束-->
        </div>
    </div>
</section>

<footer class="bg-primary navbar-fixed-bottom">
</footer>

<script src="/yxy/Public/admin/js/jquery-1.11.3.js"></script>
<script src="/yxy/Public/admin/js/bootstrap.js"></script>
<script>

//    添加编辑模态框
    $('#edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
    })
    
   function model_edit(id) {
	var id=id;
	 $.ajax({
		type:"post",
		url:"<?php echo U('Second/edit');?>",
		data:{"id":id},
		success(data) {
		   $("#id").val(data.id);
		   $("#name").val(data.name);
		   $("#area").val(data.area);
		   $("#price").val(data.price);
		   $("#type").val(data.type);
		   $("#mianji").val(data.mianji);
		   $("#addr").val(data.addr);
		   $("#from").val(data.from);
		   $("#phone").val(data.phone);
		   $("#mortgage").val(data.mortgage);
		   $("#summary").val(data.summary);
		},
	 }) 
   }
   
   function model_delete(id) {
	   var id = id;
	   $.ajax({
		  type:"post",
		  url:"<?php echo U('Second/delete');?>",
		  data:{"id":id},
		  success(data) {
			 if (data == 1) {
				 alert('删除成功');
				 window.location.href = "<?php echo U('Second/second');?>";
			 } 
		  }
	   });
   }
</script>
</body>
</html>