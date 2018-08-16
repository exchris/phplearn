<?php
//判断数据是否为合法的json数据
function is_json($string)
{
  if(is_string($string)){
     @json_decode($string);
     return (json_last_error() === JSON_ERROR_NONE);    
  }
  return false;
}
?>
