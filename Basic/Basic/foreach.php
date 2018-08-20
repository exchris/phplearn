<?php
/**
 * foreach循环遍历对象时,需要区别的是在对象的成员函数中使用还是在公共程序中使用。
 * 当在对象的成员函数中使用foreach循环时,将遍历对象的所有成员、包括公有成员、保护成员和私有成员
 *
 * 当在公共程序中使用foreach循环时,将只遍历对象的公有成员
 */
 class MyClass # 定义一个类MyClass
 {
   public $var1 = 'value A'; # 类的公有成员
   public $var2 = 'value B';
   public $var3 = 'valur C';
   protected $protected = 'protected varA'; # 类的保护成员
   private $private = 'private varA'; # 类的私有成员

   # 类的成员函数
   function iterateVisible()
   {
     echo "MyClass::iterateVisible:\n";
     # 成员函数中的foreach循环
     foreach ($this as $key => $value) {
       print "$key => $value \n";
     }
   }
 }

 $class = new MyClass(); # 声明一个对象
 foreach ($class as $key => $value) {
   # 公共程序中的foreach循环
   print "$key => $value \n";
 }
 
 $class->iterateVisible(); // 执行对象的成员函数
?>
