<?php
  # 单例模式
  # 单例模式就是只有一个示例.
  # 作为对象的创建模式,单例模式确保某一类只有一个示例,而且自行实例化并向整个系统提供这个示例

  # 单例模式的要点有三个:
  # 1.一是某个类只能有一个示例
  # 2. 二是它必须自行创建这个示例
  # 3. 三是它必须自行向整个系统提供这个示例

  # 为什么要使用PHP单例模式
  # 1.php的应用主要在于数据库应用,一个应用中会存在大量的数据库操作,在使用面向对象的方式开发时
  #  如果使用单例模式,则可以避免大量的new操作消耗的资源,还可以减少数据库连接这样就不容易出现
  #  too many connections情况。

  /**
   * 设计模式之单例模式
   * $_instance必须声明为静态的私有变量
   * 构造函数必须声明为私有,防止外部程序new类从而失去单例模式的意义
   * getInstance()方法必须设置为公有的,必须调用此方法以返回示例的一个应用
   * ::操作符只能访问静态变量和静态函数
   * new对象都会消耗内存
   * 使用场景:最常用的地方是数据库连接
   * 使用单例模式生成一个对象后,该对象可以被其他众多对象所使用
   */
   class Man
   {
     // 保存示例在此属性中
     private static $_instance;

     // 构造函数声明为private,防止直接创建对象
     private function __construct()
     {
       echo "我被实例化了!";
     }

     // 单例方法
     public static function get_instance()
     {
       var_dump(isset(self::$_instance));

       if (!isset(self::$_instance))
       {
         self::$_instance = new self();
       }
       return self::$_instance;
     }

     // 阻止用户复制对象示例
     private function __clone()
     {
       trigger_error('Clone is not allow', E_USER_ERROR);
     }

     function test()
     {
       echo "test";
     }
  }　
  // 这个写法会出错,因为构造方法被声明为private
  // $test = new Man;
  // 下面将得到Example类的单例对象
  $object = Man::get_instance();
  $object->test();
  
  // 复制对象将导致一个E_USER_ERROR。
  // $test_clone = clone $test;
?>
