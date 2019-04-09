<?php

// 运动秀接口优化
define('BASEDIR', __DIR__);

include BASEDIR . '/common/Loader.php';
spl_autoload_register('\\common\\Loader::autoload');

$user = new \common\User();
$user->setUid(208037);
$user->setUsername('2687547643@qq.com');

$record = new \common\Record();
$res = $record->sysc($user->getUid(), $user->getUsername());