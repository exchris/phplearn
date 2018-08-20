<?php
    /**
     * memcache是一个高效的分布式的内存对象缓存系统;
     *它可以支持把php的各种数据(数组,对象,基本数据类型)放在它管理的内存中
     **/
     header("Content-Type:text/html;charset=UTF-8");
     // 连接
     $mem = new Memcache;
     $mem->connect("127.0.0.1", 11211) or die("Could not connect");

     // 显示版本
     $version = $mem->getVersion();
     echo "Memcached Server version:".$version."<br/>";

     // 保存数据
     $mem->set('key1', 'This is first value', 0, 60);
     $val = $mem->get('key1');
     echo "Get key1 value:" . $val . "<br>";

     // 替换数据
     $mem->replace('key1', 'This is repace value',  0, 60);
     $val = $mem->get('key1');
     echo "Get key1 value:" . $val . "<br/>";

     // 保存数组
     $arr = array('aaa', 'bbb', 'ccc', 'ddd');
     $mem->set('key2', $arr, 0, 60);
     $val2 = $mem->get('key2');
     echo "Get key2 value:";
     print_r($val2);
     echo "<hr/>";

     // 对数组进行序列化,在网络传输的时候,为了保证数据类型的不丢失,先序列化,再发生.
     // $arr1 = serialize($arr);
     $arr2 = json_encode($arr, JSON_UNESCAPED_UNICODE);
     print_r($arr2);
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
     echo "<br/>";

     // 关闭连接
     $mem->close();
?>
