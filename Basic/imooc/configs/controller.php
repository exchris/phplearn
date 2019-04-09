<?php

$config = array(
    'home' => array(
        'decorator' => array(
            // 'IMooc\Decorator\Template',
            // 'App\Decorator\Login',
            // 'App\Decorator\Template',
            'App\Decorator\Json',
        ),
    ),
    'default' => 'hello world',
);
return $config;