<?php

/**
 * 创建型模式
 *
 * php单例模式
 *
 */

// 注册自动加载
spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) .'//..//'.str_replace('\\','/',$class).'.php';
}

/*************************test****************************/

use Singleton\Singleton;

// 获取单例
$instance = Singleton::getInstance();

$instance->test();

// clone对象试试
$instanceClone = clone $instance;