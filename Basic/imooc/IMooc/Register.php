<?php

namespace IMooc;

class Register
{
    protected static $objects;
    static function set($alias, $object)
    {
        self::$objects[$alias] = $object;
    }

    static function get($alias)
    {
        return self::$objects[$alias];
    }

    function _unset($alias)
    {
        unlink(self::$objects[$alias]);
    }
}