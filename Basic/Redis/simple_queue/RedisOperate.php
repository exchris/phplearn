<?php
/**
 * RedisOperate.php
 *
 * 单例模式设置Redis操作类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 4:07
 */
class RedisOperate extends Redis
{
    // 实例
    protected  static $_instance = null;

    /**
     * Single instance (获取自己的实例)
     *
     * @return RedisOperate
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
            $host = $_SERVER['REDIS_HOST'];
            $port = $_SERVER['REDIS_PORT'];
            self::$_instance->connect($host, $port);
        }
        return self::$_instance;
    }
}