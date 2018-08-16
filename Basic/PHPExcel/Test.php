<?php

define('BASEPATH', __DIR__);

require_once BASEPATH . '/Classes/PHPExcel.php';
require_once BASEPATH . '/Classes/PHPExcel/Writer/Excel2007.php';


//浏览器输出excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dzg_card_info.xls"');
header('Cache-Control: max-age=0');

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0); //设置第一个工作表为活动工作表
$objPHPExcel->getActiveSheet()->setTitle('card_info'); //设置工作表名称
//为单元格赋值
//方法①:直接设置单元格的值
/* $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PHPExcel');
  $objPHPExcel->getActiveSheet()->setCellValue('A2', 12345.6789);
  $objPHPExcel->getActiveSheet()->setCellValue('A3', TRUE); */
$expTitle = '测试';
//方法②:二维数组
$arrHeader = array(
    array('id','ID'),
    array('name','名字'),
    array('jr','技能'),
    array('time','创建时间')
);
$arrAllCardInfo = [
    ['id'=>123, 'name'=>'张三', 'jr'=>'tt', 'time'=>'111'],
    ['id'=>123, 'name'=>'张三', 'jr'=>'tt', 'time'=>'111'],
    ['id'=>123, 'name'=>'张三', 'jr'=>'tt', 'time'=>'111'],
];
$cellNum = count($arrHeader);
$dataNum = count($arrAllCardInfo);
$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
$objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));//第一行标题
for ($i = 0; $i < $cellNum; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $arrHeader[$i][1]);
}
// Miscellaneous glyphs, UTF-8
for ($i = 0; $i < $dataNum; $i++) {
    for ($j = 0; $j < $cellNum; $j++) {
        $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $arrAllCardInfo[$i][$arrHeader[$j][0]]);
    }
}
//创建第二个工作表
$msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'card_message'); //创建一个工作表
$objPHPExcel->addSheet($msgWorkSheet); //插入工作表
$objPHPExcel->setActiveSheetIndex(1); //切换到新创建的工作表
$arrHeader1 = array(
    array('id','ID'),
    array('nickname','名字'),
    array('desc','描述')
);
$arrBody = [
    ['id'=>1, 'nickname'=>123, 'desc'=>''],
    ['id'=>1, 'nickname'=>123, 'desc'=>''],
    ['id'=>1, 'nickname'=>123, 'desc'=>''],
];
$cellNum1 = count($arrHeader1);
$dataNum1 = count($arrBody);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));//第一行标题
for ($i = 0; $i < $cellNum1; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $arrHeader1[$i][1]);
}
// Miscellaneous glyphs, UTF-8
for ($i = 0; $i < $dataNum1; $i++) {
    for ($j = 0; $j < $cellNum1; $j++) {
        $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $arrBody[$i][$arrHeader1[$j][0]]);
    }
}

$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;