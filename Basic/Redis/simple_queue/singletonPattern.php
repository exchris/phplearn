<?php
/**
 * singletonPattern.php
 *
 * 单例模式
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 4:11
 */

// 载入Redis
include_once('RedisOperate.php');

class Client
{
    /**
     * 初始化配置文件
     *
     * @return null
     */
    public static function initConfig() {
        // Redis主机
        $_SERVER['REDIS_HOST'] = '127.0.0.1';

        // Redis port
        $_SERVER['REDIS_PORT'] = 6379;
    }

    /**
     * 主函数
     *
     * @return null
     */
    public function main() {
        // 初始化配置
        self::initConfig();

        // Redis key3
        RedisOperate::getInstance()->set("key3", "Redis Code3");
        echo RedisOperate::getInstance()->get("key3");
        echo "\r\n---\r\n";

        // Redis key4
        RedisOperate::getInstance()->set("key4", "Redis Code4");
        echo RedisOperate::getInstance()->get("key4");
        echo "\r\n---\r\n";
    }
}

/**
 * 程序入口
 */
function start() {
    $client = new Client();
    $client->main();
}

start();