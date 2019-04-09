<?php

namespace IMooc;

class Config implements \ArrayAccess
{

    protected $path;
    protected $configs = array();

    function __construct($path)
    {
        $this->path = $path;
    }

    public function offsetExists($offset)
    {
        return isset($this->configs[$offset]);
    }

    public function offsetGet($offset)
    {
        if (empty($this->configs[$offset]))
        {
            $file_path = $this->path.'/'.$offset.'.php';
            $config = require $file_path;
            $this->configs[$offset] = $config;
        }
        return $this->configs[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception("cannot write config file.");
    }

    public function offsetUnset($offset)
    {
        unset($this->configs[$offset]);
    }
}