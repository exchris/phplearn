<?php 

/**
 * 导出csv文件，适用于大量数据导出
 *
 */
function exportCSV($fileName = '', $headArr = [], $data = []){

    ini_set('memory_limit', '1024M'); //设置程序运行的内存
    ini_set('max_execution_time', 0); //设置程序的执行时间，0为无上限
    ob_end_clean(); //清除内存
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=".$fileName.'.csv');
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($fp, $headArr);
    $index = 0;
    foreach ($data as $item) {
	if ($index == 1000) { // 每次写入1000条数据清除内存
            $index = 0;
            ob_flush(); //清除内存
            flush();	    
	}
	$index++;
	fputcsv($fp, $item);
    }    
    
    ob_flush();
    flush();
    ob_end_clean();
    exit();
}
