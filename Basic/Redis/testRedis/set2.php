<?php
	header('content-type:text/html;charset=utf-8');
    //实例化redis
    $redis = new \Redis();
    //连接
    $redis->connect('127.0.0.1', 6379);
    //集合
    $redis->delete('set');
    $redis->delete('set2');

    $redis->sAdd('set', 'horse');
    $redis->sAdd('set', 'cat');
    $redis->sAdd('set', 'dog');
    $redis->sAdd('set', 'bird');
    $redis->sAdd('set2', 'fish');
    $redis->sAdd('set2', 'dog');
    $redis->sAdd('set2', 'bird');

    # 返回集合的所有值
    print_r($redis->sMembers('set'));echo '<br>';
    print_r($redis->sMembers('set2'));echo '<br>';

    //返回集合的交集
    print_r($redis->sInter('set', 'set2'));echo '<br>';

    //执行交集操作 并结果放到一个集合中
    $redis->sInterstore('output', 'set', 'set2');
    print_r($redis->sMembers('output'));echo '<br>';

    //返回集合的并集
    print_r($redis->Sunion('set', 'set2'));echo '<br>';

    //执行并集操作 并结果放到一个集合中
    $redis->Sunionstore('output', 'set', 'set2');
    print_r($redis->sMembers('output'));echo '<br>';

    //返回集合的差集
    print_r($redis->sDiff('set', 'set2'));echo '<br>';

    //执行差集操作 并结果放到一个集合中
    $redis->sDiffstore('output', 'set', 'set2');
    print_r($redis->sMembers('output'));echo '<br>';

    // 结果
    // Array ( [0] => cat [1] => dog [2] => bird [3] => horse )
    // Array ( [0] => bird [1] => dog [2] => fish )
    // Array ( [0] => bird [1] => dog )
    // Array ( [0] => dog [1] => bird )
    // Array ( [0] => cat [1] => dog [2] => bird [3] => horse [4] => fish )
    // Array ( [0] => cat [1] => dog [2] => bird [3] => horse [4] => fish )
    // Array ( [0] => horse [1] => cat )
    // Array ( [0] => horse [1] => cat )