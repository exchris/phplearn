<?php

namespace IMooc;
date_default_timezone_set('PRC');
class Loader
{
    static function autoload($class)
    {
        require BASEDIR.'/'.str_replace('\\','/',$class).'.php';
    }
}