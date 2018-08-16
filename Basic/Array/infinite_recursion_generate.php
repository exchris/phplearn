<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 上午 11:58
 * 利用了递归,数组的key值与id值可以不相同,最后以顺序的结构输出数组
 *
 * 优点:方便遍历,查找父子元素
 *
 * 缺点:php不擅长递归,数据量大的情况下效率会显著降低
 */
header("Content-Type:text/html;charset=utf8");
$arr = [
    0 => ['id' => 1, 'name' => '父1', 'father' => 0],
    1 => ['id' => 2, 'name' => '父2', 'father' => 0],
    2 => ['id' => 3, 'name' => '父3', 'father' => 0],
    3 => ['id' => 4, 'name' => '儿1-1', 'father' => 1],
    4 => ['id' => 5, 'name' => '儿1-2', 'father' => 1],
    5 => ['id' => 6, 'name' => '儿1-3', 'father' => 1],
    6 => ['id' => 7, 'name' => '儿2-1', 'father' => 2],
    7 => ['id' => 8, 'name' => '儿2-1', 'father' => 2],
    8 => ['id' => 9, 'name' => '儿3-1', 'father' => 3],
    9 => ['id' => 10, 'name' => '儿3-1-1', 'father' => 9],
    10 => ['id' => 11, 'name' => '儿1-1-1', 'father' => 4],
    11 => ['id' => 12, 'name' => '儿2-1-1', 'father' => 7],
];
function generateTree($arr, $id, $step)
{
    static $tree = [];
    foreach ($arr as $key => $val) {
        if ($val['father'] == $id) {
            $flg = str_repeat('└―', $step);
            $val['name'] = $flg . $val['name'];
            $tree[] = $val;
            generateTree($arr, $val['id'], $step + 1);
        }
    }
    return $tree;
}

$tree = generateTree($arr, 0, 0);
foreach ($tree as $val) {
    echo $val['name'] . '<br>';
}