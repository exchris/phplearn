<?php

namespace Singleton;

/**
 * 单例
 */
class Singleton
{
    /**
     * 自身示例
     *
     * @var object
     */
    private static $_instance;

    /**
     * 构造函数
     *
     * @return void
     */
    private function __construct() {}

    /**
     * 魔术方法
     * 禁止clone对象
     *
     * @return string
     */
    public function __clone()
    {
        echo 'clone is forbidden';
    }

    /**
     * 获取示例
     *
     * @return object
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * 测试方法
     *
     * @return string
     */
    public function test()
    {
        echo "这是个测试\n";
    }

}