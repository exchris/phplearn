<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379); //serverip port
$redis->auth('');//my redis password

$redis->set('key', 'string value');
print_r($redis->getRange('key', 0, 5));
echo PHP_EOL;
print_r($redis->getRange('key', -5, -1));
echo PHP_EOL;

//setRange
$redis->set('key', 'Hello World');
$redis->setRange('key', 6, "redis"); /* returns 11*/
print_r($redis->get('key'));
echo PHP_EOL;

//strLen
echo $redis->strlen('key').PHP_EOL;

// getBit
$redis->set('key', "\x7f"); // this is 0111 1111

echo $redis->getBit('key', 0).PHP_EOL; /*0*/
echo $redis->getBit('key', 1).PHP_EOL; /*0*/