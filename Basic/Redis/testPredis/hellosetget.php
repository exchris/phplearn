<?php
header('content-type:text/html;charset=utf-8');
// 加载Predis库的自动加载函数
require '../predis/autoload.php';

// 连接Redis
$redis = new Predis\Client(array(
    'host' => '127.0.0.1',
    'port' => 6379
));

// 如果提交了姓名则使用SET命令将姓名写入到Redis中
if (@$_GET['name']) {
    $redis->set('name', $_GET['name']);
}

// 通过GET命令从Redis中读取姓名
$name = $redis->get('name');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的第一个Redis程序</title>
</head>
<body>
    <?php if ($name) : ?>
        <p>您的姓名是:<?php echo $name;?></p>
    <?php else: ?>
        <p>您还没有设置姓名</p>
    <?php endif;?>
    <hr />
    <h1>更改姓名</h1>
    <form action="">
        <p>
            <label for="name">您的姓名:</label>
            <input type="text" name="name" id="name" />
        </p>
        <p>
            <button type="submit">提交</button>
        </p>
    </form>
</body>
</html>
