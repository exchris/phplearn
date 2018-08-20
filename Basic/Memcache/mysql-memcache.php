<?php
  $memcachehost = "127.0.0.1";
  $memcacheport = 11211;
  $memcachelife = 60;

  $memcache = new Memcache();
  $memcache->connect($memcachehost, $memcacheport) or die("Could not connect");

  $query = "select * from personal_info limit 10";
  $key = md5($query);
  
  if (!$memcache->get($key))
  {
      $link = new mysqli('localhost', 'root', 'root', 'mydb');
      $result = $link->query($query);
      while (false != ($row = $result->fetch_assoc()))
      {
          $arr[] = $row;
      }
      $f = 'mysql';
      $memcache->add($key, serialize($arr), 0, 30); // mysql查询后,插入memcached
      $data = $arr;
  }
  else {
    $f = 'memcache';
    $data_mem = $memcache->get($key);
    $data = unserialize($data_mem);
  }

  echo $f;
  echo "<br/>";

  print_r($data);
  echo "<hr/>";

  foreach ($data as $a)
  {
  	  echo "number is:<b><font color='#f00'>".$a['pi_id']."</font></b>";
      echo "<br/>";

      echo "name is:<b><font color='#f00'>".$a['pi_name']."</font></b>";
      echo "<br/>";

      echo "tel is:<b><font color='#f00'>".$a['pi_tel']."</font></b>";
      echo "<br/>";

      echo "qq is:<b><font color='#f00'>".$a['pi_qq']."</font></b>";
      echo "<br/>";

      echo "email is:<b><font color='#f00'>".$a['pi_email']."</font></b>";
      echo "<br/>";
  }

?>
