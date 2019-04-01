<?php

require_once 'PHPExcel.php';
require_once 'PHPExcel/Reader/Excel2007.php';
require_once 'PHPExcel/IOFactory.php';

//报告所有错误
error_reporting(E_ALL);

$filePath = 'd:/data/iot/files/club/race/excels/2019/03/28/31智慧跑参赛人员导入模板_20190328152535.xlsx';
if(!file_exists($filePath)){
    echo 'no file';
}
$PHPExcel = new PHPExcel();

/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
/*$PHPReader = new PHPExcel_Reader_Excel2007();
if(!$PHPReader->canRead($filePath)){
    $PHPReader = new PHPExcel_Reader_Excel5();
    if(!$PHPReader->canRead($filePath)){
        echo 'no Excel';
        return ;
    }
}*/

try{
    $inputFileType = PHPExcel_IOFactory::identify($filePath);
    $PHPReader = PHPExcel_IOFactory::createReader($inputFileType);
    $PHPReader->setReadDataOnly(true);
    $PHPExcel = $PHPReader->load($filePath);
} catch(Exception $e){
    die('Error loading file "'.pathinfo($filePath,PATHINFO_BASENAME).'":'.$e->getMessage());
}
# $PHPExcel = $PHPReader->load($filePath);
/**读取excel文件中的第一个工作表*/
$currentSheet = $PHPExcel->getSheet(0);
/**取得最大的列号*/
$allColumn = $currentSheet->getHighestColumn();
/**取得一共有多少行*/
$allRow = $currentSheet->getHighestRow();

echo $allColumn, $allRow;
exit;
?>