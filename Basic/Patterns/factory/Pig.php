<?php

namespace Factory;

/**
 * 实体猪
 */
class Pig implements IAnimal
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        echo "生产了一只猪~~~\n";
    }
}