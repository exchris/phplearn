<?php
set_time_limit(0);
ini_set('memory_limit', '128M');

$fileName = date('YmdHis', time());
header('Content-Type: application/vnd.ms-execl');
header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');

$begin = microtime(true);

//打开php标准输出流
//以写入追加的方式打开
$fp = fopen('php://output', 'a');

$db = new mysqli('127.0.0.1', 'root', 'root', 'test');

if($db->connect_error) {
    die('connect error');
}

//我们试着用fputcsv从数据库中导出1百万的数据
//我们每次取1万条数据，分100步来执行
//如果线上环境无法支持一次性读取1万条数据，可把$nums调小，$step相应增大。
$step = 100;
$nums = 10000;

//设置标题
$title = array('ID', '用户名', '用户年龄', '用户描述', '用户手机', '用户QQ', '用户邮箱', '用户地址');
foreach($title as $key => $item) {
    $title[$key] = iconv('UTF-8', 'GBK', $item);
}
//将标题写到标准输出中
fputcsv($fp, $title);

for($s = 1; $s <= $step; ++$s) {
    $start = ($s - 1) * $nums;
    $result = $db->query("SELECT * FROM tb_users ORDER BY id LIMIT {$start},{$nums}");

    if($result) {
        while($row = $result->fetch_assoc()) {
            foreach($row as $key => $item) {
                //这里必须转码，不然会乱码
                $row[$key] = iconv('UTF-8', 'GBK', $item);
            }
            fputcsv($fp, $row);
        }
        $result->free();

        //每1万条数据就刷新缓冲区
        ob_flush();
        flush();
    }
}

$end = microtime(true);
echo '用时：', $end - $begin;
?>
