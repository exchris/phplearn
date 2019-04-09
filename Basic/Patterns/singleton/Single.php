<?php
namespace Singleton;
/**
 * 单例模式
 */
final class Single
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 封锁重写和继承
     */
    final private function __construct(){}

    /**
     * 封锁克隆
     */
    final private function __clone(){}
}

// 第一个对象
$s1 = Single::getInstance();

// 第二个对象
$s2 = Single::getInstance();

if ($s1 === $s2) {
    echo '是同一个对象';
} else {
    echo '不是同一个对象';
}
