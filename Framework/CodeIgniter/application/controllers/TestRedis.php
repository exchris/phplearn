<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @class TestRedis
 * @author dev.erxuan@gmail.com
 * @date 2018-08-06
 * @description redis操作测试类
 */
class TestRedis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
    }
}