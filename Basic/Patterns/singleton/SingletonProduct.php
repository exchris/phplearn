<?php
namespace Singleton;
/**
 * Singleton class
 */
final class SingletonProduct
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var mixed
     */
    public $mix;

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {

    }
}

$firstProduct = SingletonProduct::getInstance();
$secondProduct = SingletonProduct::getInstance();

$firstProduct->mix = 'test';
$secondProduct->mix = 'example';

print_r($firstProduct->mix);
print_r($secondProduct->mix);