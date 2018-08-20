<?php

    // 中文显示
    header("Content-Type:text/html;charset=UTF-8");
    // 创建一个Memcache对象
    $memcache = new Memcache;

    $memcacheD = new Memcached;

    $memcache->addServer($host);
    $memcacheD->addServers($servers);

    $checks = array(
      123,
      4542.21,
      'a string',
      true,
      array(123, 'string'),
      (object)array('key1' => 'value1'),
    );

    foreach ($checks as $i => $value) {
      print "Checking WRITE with Memcache\n";
      $key = 'cachetest' . $i;
      $memcache->set($key, $value);
      usleep(100);
      $val = $memcache->get($key);
      $valD = $memcacheD->get($key);
      if ($val !== $valD) {
        print "Not compatible!";
        var_dump(compact('val', 'valD'));
      }

      print "Checking WRITE with MemcacheD\n";
      $key = 'cachetest' . $i;
      $memcacheD->set($key, $value);
      usleep(100);
      $val = $memcache->get($key);
      $valD = $memcacheD->get($key);
      if ($val !== $valD) {
        print "Not compatible!";
        var_dump(compact('val', 'valD'));
      }
    }
?>
