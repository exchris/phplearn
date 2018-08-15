<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18 0018
 * Time: 下午 4:59
 */
interface Factory {
    public function getProduct();
}

interface Product {
    public function getName();
}

class FirstFactory implements Factory {
    public function getProduct()
    {
        return new FirstProduct();
    }
}

class SecondFacotry implements Factory {
    public function getProduct()
    {
        return new SecondProduct();
    }
}

class FirstProduct implements Product {
    public function getName()
    {
        return 'The first product';
    }
}

class SecondProduct implements Product {
    public function getName() {
        return 'Second product';
    }
}

$factory = new FirstFactory();
$firstProduct = $factory->getProduct();
$factory = new SecondFacotry();
$secondProduct = $factory->getProduct();

print_r($firstProduct->getName());
// The first product
print_r($secondProduct->getName());
// Second product

