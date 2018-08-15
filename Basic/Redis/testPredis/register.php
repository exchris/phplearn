<?php
// 设置Content-type以始浏览器可以使用正确的编码显示提示信息,
// 具体的编码需要根据文件实际编码选择，此处是utf-8
header('content-type:text/html;charset=utf-8');
require_once '../predis/autoload.php';
var_dump($_POST);

if (!isset($_POST['email']) ||
    !isset($_POST['password']) ||
    !isset($_POST['nickname'])) {
    echo '请填写完整的信息'; exit;
}

$email = $_POST['email'];
// 验证用户提交的邮箱是否正确
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '邮箱格式不正确,请重填检测';exit;
}

$rawPassword = $_POST['password'];
// 验证用户提交的面膜是否安全
if (strlen($rawPassword) < 6) {
    echo '为了保证安全,密码长度至少为6。';exit;
}

$nickname = $_POST['nickname'];
$config = [
    'hort' => '127.0.0.1',
    'port' => 6379
];
$redis = new Predis\Client($config);
if ($redis->hexists('email.to.id', $email)) {
    echo '该邮箱已经被注册了';exit;
}

function bcryptHash($rawPassword, $round = 8)
{
    if ($round < 4 || $round > 31) $round = 8;
    $salt = '$2a$' . str_pad($round, 2, '0', STR_PAD_LEFT). '$';
    $randomValue = openssl_random_pseudo_bytes(16);
    $salt .= substr(strtr(base64_encode($randomValue), '+', '.'), 0, 22);
    return crypt($rawPassword, $salt);
}

$hashedPassword = bcryptHash($rawPassword);

// 首先获取一个自增的用户ID
$userID = $redis->incr('users:count');
// 存储用户信息
$redis->hmset("user:{$userID}", array(
    'email' => $email,
    'password' => $hashedPassword,
    'nickname' => $nickname
));

// 记得记录下邮箱和用户ID的对应关系
$redis->hset('email.to.id', $email, $userID);

// 提示用户注册成功
echo '注册成功!';

