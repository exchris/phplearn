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
                    <li class="text-center"><a href="<?php echo U('Index/index');?>"><span class="text-primary">退出</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<section>
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
        </div>
    </div>
</section>

<footer class="bg-primary navbar-fixed-bottom">
</footer>

<script src="/yxy/Public/admin/js/jquery-1.11.3.js"></script>
<script src="/yxy/Public/admin/js/bootstrap.js"></script>
<script>

    $(function () {
        $('dt').click(function () {
            $(this).parent().find('dd').show().end().siblings().find('dd').hide();
        });
    });
</script>
</body>
</html>