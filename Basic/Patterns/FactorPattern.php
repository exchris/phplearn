<?php
#简单工厂模式
#抽象类Product
abstract class Product {
	abstract function getName();
}

#具体产品类ProductA
class ProductA extends Product {

	public function getName() {
		echo "I am ProductA";
	}
}

#具体产品类ProductB
class ProductB extends Product {
	public function getName() {
		echo "I am ProductB";
	}
}
#工厂类ProductFactory
class ProductFactory {
	static function create($name) {
		switch($name) {
			case "A":
				return new ProductA();
			case "B":
				return new ProductB();
		}
	}
}

$product = ProductFactory::create("A");
$product->getName();
echo "<br>";
$product = ProductFactory::create("B");
$product->getName();