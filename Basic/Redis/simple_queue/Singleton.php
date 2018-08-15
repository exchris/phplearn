<?php
/**
 * 单例模式类
 */
final class Product
{
    /**
     * @var self
     */
    private static $_instance = null;

    /**
     * @var mixed
     */
    public $mix;

    /**
     * Return self instance
     *
     * @return self
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {}

    private function __clone() {}
}

$firstProduct = Product::getInstance();
$secondProduct = Product::getInstance();

$firstProduct->mix = 'test';
$secondProduct->mix = 'example';

print_r($firstProduct->mix);
// example
print_r($secondProduct->mix);
// example