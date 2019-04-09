<?php

namespace Singleton;

/**
 * Class SinglePerson
 */

class SinglePerson
{
    /**
     * 保存对象示例
     * @var
     */
    protected static $isMake;

    /**
     * 不允许外部实例化
     * SinglePerson constructor.
     */
    private function __construct(){}

    /**
     * 使用静态变量控制只会创建一次对象示例
     *
     * @return mixed
     */
    public static function make()
    {
        if (is_null(self::$isMake)) {
            self::$isMake = new static();
        }
        return static::$isMake;
    }
}

$instance = SinglePerson::make();