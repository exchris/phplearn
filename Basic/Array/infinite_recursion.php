<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 上午 11:46
 * Description:PHP迭代与递归实现无限级分类
 * 分析:
 * 这个算法利用了循环迭代,将线性结构按照父子关系以树形结构输出,算法的关键在于使用了引用
 * 优点:速度快,效率高
 * 缺点:数据的key值必须与id值相同,不便于取出数据(舒勇递归获取数据)
 */
header("Content-Type:text/html;charset=utf8");
$arr = [
    1 => ['id' => 1, 'name' => '父1', 'father' => NULL],
    2 => ['id' => 2, 'name' => '父2', 'father' => NULL],
    3 => ['id' => 3, 'name' => '父3', 'father' => NULL],
    4 => ['id' => 4, 'name' => '儿1-1', 'father' => 1],
    5 => ['id' => 5, 'name' => '儿1-2', 'father' => 1],
    6 => ['id' => 6, 'name' => '儿1-3', 'father' => 1],
    7 => ['id' => 7, 'name' => '儿2-1', 'father' => 2],
    8 => ['id' => 8, 'name' => '儿2-2', 'father' => 2],
    9 => ['id' => 9, 'name' => '儿3-1', 'father' => 3],
    10 => ['id' => 10, 'name' => '儿3-1-1', 'father' => 9],
    11 => ['id' => 11, 'name' => '儿1-1-1', 'father' => 4],
    12 => ['id' => 12, 'name' => '儿2-1-1', 'father' => 7]
];

function generateTree($items)
{
    $tree = [];
    foreach ($items as $item)
    {
        if (isset($item['father'])) {
            $items[$item['father']]['son'][] = &$items[$item['id']];
        } else {
            $tree[] = &$items[$item['id']];
        }
    }
    return $tree;
}

$tree = generateTree($arr);
echo json_encode($tree, JSON_UNESCAPED_UNICODE);
