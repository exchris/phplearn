<?php
  class SingletonBasic {
    private static $instance;

    private function __construct() {

    }

    private function __clone() {}

    public static function getInstance() {
      if (!self::$instance instanceof self) {
        self::$instance = new self();
      }
      return self::$instance;
    }
  }

  $a = SingletonBasic::getInstance();
  $b = SingletonBasic::getInstance();
  var_dump($a == $b);
?>
