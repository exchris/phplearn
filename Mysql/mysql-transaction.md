# Mysql事务
## 第一种方式
```php
<?php

$conn = mysql_connect('localhost','root','root') or die ("数据连接错误!!!");
mysql_select_db('test',$conn);
mysql_query("set names 'GBK'"); //使用GBK中文编码;
//开始一个事务
mysql_query("BEGIN"); //或者mysql_query("START TRANSACTION");
$sql = "INSERT INTO `user` (`id`, `username`, `sex`) VALUES (NULL, 'test1', '0')";
$sql2 = "INSERT INTO `user` (`did`, `username`, `sex`) VALUES (NULL, 'test1', '0')";//这条我故意写错
$res = mysql_query($sql);
$res1 = mysql_query($sql2);
if($res && $res1){
mysql_query("COMMIT");
echo '提交成功。';
}else{
mysql_query("ROLLBACK");
echo '数据回滚。';
}
mysql_query("END");
```

## 第二种方式
```php
<?php

mysql_query("SET AUTOCOMMIT=0"); //设置mysql不自动提交，需自行用commit语句提交
$sql = "INSERT INTO `user` (`id`, `username`, `sex`) VALUES (NULL, 'test1', '0')";
$sql2 = "INSERT INTO `user` (`did`, `username`, `sex`) VALUES (NULL, 'test1', '0')";//这条我故意写错
$res = mysql_query($sql);
$res1 = mysql_query($sql2); 
if($res && $res1){
mysql_query("COMMIT");
echo '提交成功。';
}else{
mysql_query("ROLLBACK");
echo '数据回滚。';
}
mysql_query("END"); //事务处理完时别忘记mysql_query("SET AUTOCOMMIT=1");自动提交

```
