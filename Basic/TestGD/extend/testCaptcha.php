<?php
require_once 'Captcha.class.php';
$config = array(
    'fontfile' => '../fonts/KAITI.TTF',
    'pixel' => 100,
    'line' => 3
);
$captcha = new Captcha($config);
session_start();
$_SESSION['verifyName'] = $captcha->getCaptcha();