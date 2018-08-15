<?php
/**
 * Registry class
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 4:56
 */
class Package
{
    protected static $data = [];
    public static function set($key, $value) {
        self::$data[$key] = $value;
    }

    public static function get($key) {
        return isset(self::$data[$key]) ? self::$data[$key] : null;
    }

    final public static function removeObject($key)
    {
        if (array_key_exists($key, self::$data)) {
            unset(self::$data[$key]);
        }
    }
}

Package::set('name', 'Package name');

print_r(Package::get('name'));
// Package name