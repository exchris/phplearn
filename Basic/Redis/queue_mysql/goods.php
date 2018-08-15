<?php
// 这个文件主要是配送系统处理队列中的订单并进行标记的一个文件

include '../include/db.php';
$db = DB::getInstance();
// 1.先把要处理的记录更新为等待处理
$waiting = array('status' => 0,);
$lock = array('status' => 2,);
$res_lock = $db->update("order_queue", $lock, $waiting, 2);

// 2. 我们要选择出刚刚咱们更新的这些数据,然后进行配送系统的处理
if ($res_lock) {
    $res = $db->selectAll("order_queue", $lock);
    // 选择出要处理的订单的内容

    // 然后由p配货系统进行退货处理
    // ...

    // 处理完成之后吧订单更新为已处理

    // 3. 是吧这些处理过的程序更新为已完成
    $success = array(
        "status" => 1,
        "updated_at" => date('Y-m-d H:i:s', time())
    );
    $res_last = $db->update("order_queue", $success, $lock);
    if ($res_last) {
        echo "Success:".$res_last;
    } else {
        echo "Fail:".$res_last;
    }
}



