<?php

namespace common;

date_default_timezone_set('PRC');
class Loader
{
    static function autoload($className)
    {
        require BASEDIR.'/'.str_replace('\\','/',$className).'.php';
    }
}