<?php

/**
 *
 * redis数据出队操作，从redis中将请求取出
 */
$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);
while (true) {
    try {
        $value = $redis->lPop('click');
        if (!$value) {
            echo "出队完成";
            break;
        }
        print_r($value);

        /**
         * 利用$value进行逻辑和数据处理
         */
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}