<?php
    /**
     * Memcache函数库是在PECL(PHP Extension Community Library)中,
     * 主要作用是搭建大容量的内存数据的临时存放区域,
     * 在分布式的时候作用体现的非常明显
     */

     // 1.实例化一个Memcache对象
     $mem = new Memcache();

     // 2.连接到指定的memcache中
     $mem->connect("127.0.0.1", 11211);

     // 如果我们网站,需要多个memcache缓存系统,如下使用分布式
     $mem->addServer("192.168.1.100", 11211);
     $mem->addServer("192.168.1.200", 11211);
     $mem->addServer("192.168.1.222", 11211);

     // 创建多个memcache服务使用addServer会根据负载均衡算法,自动放入每个服务器
     $mem->add("name", "zs", 0, 100);
?>
