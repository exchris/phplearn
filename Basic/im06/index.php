<?php
// 静态：http://yourhost.com/index.php/12/2.html
// 动态：http://yourhost.com/index.php?type=12&id=2
$pathinfo = $_SERVER['PATH_INFO'];
if( preg_match('/^\/(\d+)\/(\d+)/', $pathinfo,$path) ){
    $type = $path[1];
    $id = $path[2];
    echo 'type=',$type,'&id=',$id;//获得type 和 id 进一步处理
}else{
    //错误处理
    echo "err";
}