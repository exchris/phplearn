<?php
  $mem = new Memcache();
  $mem->connect("127.0.0.1", 11211);
  // 添加数据
  $mem->add('name', 'admin', MEMCACHE_COMPRESSED, 0);
  echo "Get name value:".$mem->get('name')."<br/>";
  // 修改数据
  $mem->set('name', 'xioahua', MEMCACHE_COMPRESSED, 0);
  echo "Get name value:".$mem->get('name')."<br/>";

  // replace的使用
  $mem->replace('name', 'xiaobai', MEMCACHE_COMPRESSED, 0);
  echo "Get name value:".$mem->get('name')."<br/>";

  $mem->delete('name');
  echo "Get name value:".$mem->get('name')."<br/>";

  // memcache中可以保存什么数据类型
  // 1.数组
  $arr = array('name'=>'admin', 'age'=>23);
  $mem->add('person', $arr, MEMCACHE_COMPRESSED, 0);
  echo "Get person value:";
  print_r($mem->get('person'));
  echo "<hr/>";

  // 2.对象
  class Dog
  {
      public $name;
      public $color;
      public function __construct($name, $color)
      {
          $this->name = $name;
          $this->color = $color;
      }
  }
  $dog = new Dog('xiaohua', 'white');
  $mem->add('dog', $dog, MEMCACHE_COMPRESSED, 0);
  echo "Get dog value:";
  print_r($mem->get('dog'));
  echo "<hr/>";
?>
