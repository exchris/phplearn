<?php

// 函数式编程
$users = array(
    array('id' => 1, 'name' => 'abc1', 'age' => 29, 'sex' => '男'),
    array('id' => 2, 'name' => 'abc2', 'age' => 21, 'sex' => '女'),
    array('id' => 3, 'name' => 'abc3', 'age' => 23, 'sex' => '男'),
    array('id' => 4, 'name' => 'abc4', 'age' => 25, 'sex' => '女'),
    array('id' => 5, 'name' => 'abc5', 'age' => 20, 'sex' => '女'),
    array('id' => 6, 'name' => 'abc6', 'age' => 24, 'sex' => '男'),
    array('id' => 7, 'name' => 'abc7', 'age' => 28, 'sex' => '女'),
    array('id' => 8, 'name' => 'abc8', 'age' => 27, 'sex' => '男'),
);

// 获取性别为女的用户
$arrayFilterByFemale = array_filter($users, function($item){
    return $item['sex']  == '女' ;
});

//print_r($arrayFilterByFemale).PHP_EOL;

// 不影响原数组，返回一个新数组
$arrayMap = array_map(function($item){
    return array(
        'id' => $item['id'],
        'name' => $item['name'],
        'age' => $item['age'],
        'gender' => $item['sex'] == '男' ? 'male' : 'female'
    );
}, $users);
//print_r($arrayMap).PHP_EOL;

//修改原数组，对年龄+10处理，同时新增索引gender，返回值1或0
$newusers = array_walk($users, function(&$item, $index){
    $item['gender'] = $item['sex'] == '男' ? 'male' : 'female';
    if($index % 2 == 0) {
        $item['age'] += 10;
    }
});
print_r($newusers);

//array_reduce(array $input , callable $function [,$initial = NULL ]) 用回调函数迭代地将数组简化为单一的值
// 求最大年龄的用户,返回最大年龄用户信息
$arrayReduce = array_reduce($users, function($init, $val){
    return $init['age'] > $val['age'] ? $init : $val;
}, array('age' => 0));

// 求平均年龄
$avgAge = array_reduce($users, function($init, $item){
        return $init + $item['age'];
    }, 0) / count($users);


/*
 * array_reduce 的内部实现方式
function array_reduce($data, $callback, $initial) {
    foreach ($data as $index => $val) {
        $initial = $callback($initial, $val);
    }
    return $initial;
}
*/
//用array_map和array_mutisort来排序
//利用array_map获取要依据排序的数组,(匿名函数 create_function($args, return $val))
//$arrField = array_map(create_function('$item', 'return $item["age"];'), $users); 【不推荐】
$arrField = array_map(function($item){
    return $item['age'];
}, $users);

//利用array_mutisort来进行年龄从大到小排序
$arrSort = array_multisort($arrField, SORT_DESC, $users);
?>
