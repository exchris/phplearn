public function exportExcel($expTableData,$expTitle){
        $expCellName  = array(
            array('','序号'),
            array('title','任务名称'),
            array('tasksn','任务编号'),
            array('is_refer_verify_time','完成时间'),
            array('textValidations','文字验证说明'),
            array('text_validation','文字验证'),
            array('picture_verification','验证图片'),
        );
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);
        if(stripos($_SERVER["HTTP_USER_AGENT"],"firefox")){
            $fileName = urldecode($expTitle);
        }else{
            $fileName = urlencode($expTitle);
        }
        //列数
        $cellNum = count($expCellName);
        //行数
        $dataNum = count($expTableData);

        //引用PHPExcel文件
        require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $cellName=array('A','B','C','D','E','F','G','H','I','J','K','L','M');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle);
        //垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置默认行高
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(60);

        //数据
        for ($i=0; $i < $cellNum; $i++) {
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i])->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i])->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平居中
            if(in_array($i, array('4','5','6'))){
                $objPHPExcel->getActiveSheet(0)->getColumnDimension($cellName[$i])->setWidth(50);//设置宽度
            }elseif($i==0){
                $objPHPExcel->getActiveSheet(0)->getColumnDimension($cellName[$i])->setWidth(10);//设置宽度
            }else{
                $objPHPExcel->getActiveSheet(0)->getColumnDimension($cellName[$i])->setWidth(20);//设置宽度
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
            for ($j=0; $j < $dataNum; $j++) {
                if($i == 0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].($j+3), $j+1);
                }elseif($i == 2){
                    //字符串显示
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($cellName[$i].($j+3), $expTableData[$j][$expCellName[$i][0]], PHPExcel_Cell_DataType::TYPE_STRING);
                }elseif($i == 6){
                    //一行多张图片导出
                    $imgs = explode(',', $expTableData[$j][$expCellName[$i][0]]);
                    foreach ($imgs as $k => $v) {
                        $objDrawing[$k] = new PHPExcel_Worksheet_Drawing();
                        //图片路径,项目目录下就行
                        $objDrawing[$k]->setPath('./attachment/'.$v);
                        $objDrawing[$k]->setCoordinates($cellName[$i+$k].($j+3));
                        $objDrawing[$k]->setWidth(50);
                        $objDrawing[$k]->setHeight(50);
                        //图片偏移距离
                        $objDrawing[$k]->setOffsetX(10);
                        $objDrawing[$k]->setOffsetY(10);
                        $objDrawing[$k]->setWorksheet($objPHPExcel->getActiveSheet());
                        //设置列宽
                        $objPHPExcel->getActiveSheet(0)->getColumnDimension($cellName[$i+$k])->setWidth(15);
                    }
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].($j+3), $expTableData[$j][$expCellName[$i][0]]);
                }
            }
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $xlsTitle . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $this->SaveViaTempFile($writer);
        exit();
    }
    public function SaveViaTempFile($objWriter)
    {
        $filePath = '' . rand(0, getrandmax()) . rand(0, getrandmax()) . '.tmp';
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }