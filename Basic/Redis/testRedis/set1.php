<?php
	
	header('content-type:text/html;charset=utf-8');

    # 实例化redis
    $redis = new Redis();
    # 连接
    $redis->connect('127.0.0.1', 6379);
    # 集合
    $redis->delete('set');
    # 添加一个元素
    echo $redis->sAdd('set', 'cat');echo '<br>';
    echo $redis->sAdd('set', 'cat');echo '<br>';
    echo $redis->sAdd('set', 'dog');echo '<br>';
    echo $redis->sAdd('set', 'rabbit');echo '<br>';
    echo $redis->sAdd('set', 'bear');echo '<br>';
    echo $redis->sAdd('set', 'horse');echo '<br>';

    # 查看集合中所有的元素
    $set = $redis->sMembers('set');
    print_r($set);echo '<br>';

    //删除集合中的value,存在返回1,不存在返回0
    echo $redis->sRem('set', 'cat');echo '<br>';
    var_dump($redis->sRem('set', 'bird'));echo '<br>';

    $set = $redis->sMembers('set');
    print_r($set);echo '<br>';

    //判断元素是否是set的成员
    var_dump($redis->sIsmember('set', 'dog'));echo '<br>';
    var_dump($redis->sIsmember('set', 'bird'));echo '<br>';

    //查看集合中成员的数量
    echo $redis->sCard('set');echo '<br>';

    //移除并返回集合中的一个随机元素(返回被移除的元素)
    echo $redis->sPop('set');echo '<br>';

    print_r($redis->sMembers('set'));echo '<br>';

    // 结果
    // 1
    // 0
    // 1
    // 1
    // 1
    // 1
    // Array ( [0] => rabbit [1] => cat [2] => bear [3] => dog [4] => horse )
    // 1
    // int(0)
    // Array ( [0] => dog [1] => rabbit [2] => horse [3] => bear )
    // bool(true)
    // bool(false)
    // 4
    // bear
    // Array ( [0] => dog [1] => rabbit [2] => horse )