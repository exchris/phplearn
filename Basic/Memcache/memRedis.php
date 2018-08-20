<?php
/**
 * memcache与redis的区别:
 * 1、都是存储数据的,memcache直接保存到内存中,
 * 2、redis保存到内存中,关闭之后保存到硬盘中,memcache重启电脑,关闭服务都回造成数据丢失
 * 3、保存在内存中
 * 3、重启电脑,重启服务器全部数据都丢失
 * 4、LRU算法,根据最近使用的变量,将长时间没使用的变量删除
 *
 * memcache可以保存的数据:字符串,数值,数组,对象
 * 当我们获得memcache中保存的对象的时候,需要提供这个类的定义,否则,提示不知道是那个类的对象
 * memcache和redis：redis还可以保存hash,数据结构
 */
 // 初始化Memcache对象
 $mem = new Memcache();

 // 连接
 $mem->connect("127.0.0.1", 11211);

 class Dog
 {

     public $name;
     public $color;

     // 构造方法
     public function __construct($name, $color)
     {
          $this->name = $name;
          $this->color = $color;
     }
 }
 $dog = new Dog('Jim', 'yellow');
 $setDog = $mem->set('dog', $dog, 0, 60);
 $getDog = $mem->get($setDog);
 var_dump($getDog);

?>
