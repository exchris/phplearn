<?php

namespace IMooc;

class Object
{

    protected $array = array();

    function __get($key)
    {
        // 打印方法名称
        var_dump(__METHOD__);
        return $this->array[$key];
    }

    function __set($key, $value)
    {
        $this->array[$key] = $value;
    }

    function __call($func, $param)
    {
        var_dump($func, $param);
        return "magic function\n";
    }

    static function __callStatic($func, $param)
    {
        var_dump($func, $param);
        return "magic function\n";
    }

    function __toString()
    {
        return __CLASS__;
    }

    function __invoke($param)
    {
        var_dump($param);
        var_dump("invoke");
    }

}