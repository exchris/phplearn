<?php

  // 连接
  // 初始化一个Memcache的对象
  $mem = new Memcache;

  // 连接到我们的Memcache服务器端,第一个参数是服务器的IP地址,也可以是主机名
  // 第二个参数是Memcache的开放端口号
  $mem->connect("127.0.0.1",11211) or die("Cound not connect");

  // 保存一个数据到Memcache服务器上,第一个参数是数据的key,用来定位一个数据,第二个参数是需要保存的数据内容
  // 第三个参数是一个标记,一般设置为O或者MEMCACHE_COMPRESSED就行,
  // 第四个参数是数据的有效期,就是说数据在这个时间内是有效的,如果过去这个时间,那么会被Memcache服务器端清除掉这个数据,
  // 单位是秒,如果设置为0，则是永远有效，我们这里设置了60，就是一分钟有效时间。
  $mem->set('key1', 'This is first value', 0, 60);

  // 从Memcache服务器端获取一条数据,它只有一个参数,就是需要获取数据的key
  $val = $mem->get('key1');
  echo "Get key1 value:" . $val . "<br/>";

  // 替换数据
  // 现在是使用replace方法来替换掉上面Key1的值,replace方法的参数跟set是一样的,
  // 不过第一个参数key1是必须是要替换数据的key,最后输出了:
  $mem->replace('key1', 'This is replace value', 0, 60);
  $val = $mem->get('key1');
  echo "Get key1 value:" . $val . "<br/>";

  // 保存数组
  $arr = array('aaa', 'bbb', 'ccc', 'ddd');
  $mem->set('key2', $arr, 0, 60);
  $val2 = $mem->get('key2');
  echo "Get key2 value:";
  print_r($val2);
  echo "<hr/>";

  // 删除数据
  $mem->delete('key1');
  $val = $mem->get('key1');
  echo "Get key1 value:" . $val . "<br/>";

  // 清除所有数据
  $mem->flush();
  $val2 = $mem->get('key2');
  echo "Get key2 value:";
  print_r($val2);
  echo "<hr/>";

  // 关闭连接
  $mem->close();

?>
