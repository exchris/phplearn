<?php
header('content-type:text/html;charset=utf-8');
if (!isset($_POST['email']) ||
    !isset($_POST['password'])) {
    echo '请填写完整的信息。';exit;
}

$email = $_POST['email'];
$rawPassword = $_POST['password'];

require '../predis/autoload.php';
$redis = new Predis\Client();

// 获得用户的ID
$userID = $redis->hget('email.to.id', $email);
if (!$userID) {
    echo '用户名或密码错误.';exit;
}

$hashedPassword = $redis->hget("user:{$userID}", 'password');

function bcryptVerify($rawPassword, $storedHash)
{
    return crypt($rawPassword, $storedHash) == $storedHash;
}

if (!bcryptVerify($rawPassword, $hashedPassword)) {
    echo '用户名或密码错误。';
    exit;
}

echo '登录成功!';