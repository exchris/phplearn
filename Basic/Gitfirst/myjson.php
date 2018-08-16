<?php
//json中如何将key中的引号去掉
function my_json_decode($str)
{
  //去掉key的双引号
  $str = preg_replace('/"(\w+)"(\s*:\s*)/is','$1$2',$str);
  return $str;
}
$str = '{"test":[{"testName":"哈哈","Url":"http://www.test.com"}]}';
$str = my_json_decode($str);
echo $str;
