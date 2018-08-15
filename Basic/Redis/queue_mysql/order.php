<?php
// 这个文件时用来接受用户的订单信息并写入队列的一个文件

include '../include/db.php';

if (!empty($_GET['mobile'])) {
    // 这里应该首先是订单中心的处理流程
    // ......
    // 用户传过来的数据进行过滤
    $order_id = rand(100000,999999);
    // 咱们把生成的订单信息存入到队列表中
    $insert_data = array(
        'order_id' => $order_id,
        'mobile' => $_GET['mobile'],
        'created_at' => date('Y-m-d H:i:s',time()),
        'status' => 0,
    );
    // 把数据存放到队列表中
    $db = DB::getInstance();
    $res = $db->insert('order_queue', $insert_data);
    if ($res) {
        echo '插入成功,订单ID为'.$insert_data['order_id'];
    } else {
        echo '插入失败';
    }
}