<?php

/**
 * 数据导出多个数据工作表
 * $period:
 *  1. 月
 *  2. 天
 */
function excelOne($data)
{
    set_time_limit(0);
    ini_set("memory_limit", "512M");
    $params = $data['params'];
    $period = $data['period'];
    $excelTitle = $data['titles'];
    $excelData = $data['excelData'];
    $filename = $data['filename'];
    $gtype = $data['gtype'];

    $params['time'] = !empty($params['time']) ? $params['time'] : time();
    if (!empty($params['time'])) {
        if ($period == 2) { // 当天日期
            $st = date("Y-m-d", $params['time']);
            $et = $st;
        } else {
            $st = date('Y-m-01', $params['time']);
            $monthDays = date('t', $params['time']);
            $end_time = date("Y-m-{$monthDays} 23:59:59", $params['time']);
            $et = date("Y-m-d", strtotime($end_time));
        }
    }
    $titleNum = count($excelTitle); // 工作表的标题总数

    $dataNum = count($excelData); // 数据总数
    // 获取CI变量
    $_ci = &get_instance();
    // 加载类名Phpexcel和Iofactory
    $_ci->load->library('Phpexcel');
    $_ci->load->library('PHPExcel/Iofactory');

    /*$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
    $cacheSettings = array('memoryCacheSize' => '16MB');
    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);*/

    $cellName = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG',
        'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR',
        'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
    );
    // 商品列表工作表
    $objPHPExcel = new Phpexcel();
    $objPHPExcel->getActiveSheet(0)->setTitle($filename);
    for ($i = 0; $i < $dataNum - 1; $i++) {
        $otherSheet = new PHPExcel_Worksheet($objPHPExcel, $filename);
        $objPHPExcel->addSheet($otherSheet);
    }
    for ($i = 0; $i < $dataNum; $i++) {
        // 合并单元格
        $objPHPExcel->getActiveSheet($i)->mergeCells('A1:' . $cellName[$titleNum - 1] . '1');
        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', '全部' . $filename);
        $objPHPExcel->getActiveSheet($i)->getStyle('A1:O1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('A')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('B')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('G')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('H')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('I')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('J')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('K')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('L')->setWidth(20);

        // 设置工作表1的标题
        for ($j = 0; $j < $titleNum; $j++) {
            $objPHPExcel->setActiveSheetIndex($i)->setCellValue($cellName[$j] . '2', $excelTitle[$j][1]);
        }
        // 设置表数据
        for ($m = 0; $m < count($excelData[$i]); $m++) {
            for ($n = 0; $n < $titleNum; $n++) {
                $objPHPExcel->getActiveSheet($i)->setCellValue($cellName[$n] . ($m + 3), $excelData[$i][$m][$excelTitle[$n][0]] . "\t");
            }
        }
    }


    // 设置工作表1的标题
    /*for ($i = 0; $i < $titleNum; $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $excelTitle[$i][1]);
    }
    // 设置工作表1的数据
    for ($i = 0; $i < $dataNum; $i++) {
        for ($j = 0; $j < $titleNum; $j++) {
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $excelData[$i][$excelTitle[$j][0]]."\t");
        }
    }*/
    ob_end_clean();
    ob_start();

    // 将获取得excel文件存到指定目录下面

    $time = date("YmdHi") . rand(0, 999);
    $fileName = $filename . "_" . $time;
    $fileName .= ".xlsx";
    $upload_folder = RESOURCES_PATH . "upload/club/excels/" . date("Y/m/d/");
    if (!file_exists($upload_folder)) {
        mkdir($upload_folder, DIR_WRITE_MODE, true);
    }
    $objPHPExcel->setActiveSheetIndex(0); // 重新定位到工作表0
    $objWriter = \Iofactory::createWriter($objPHPExcel, 'Excel2007');
    $sliceBanner = $upload_folder . $fileName;
    $objWriter->save($sliceBanner);
    $sliceBanner = str_replace(RESOURCES_PATH, "", $sliceBanner);
    $downPath = RESOURCES_DOMAIN . $sliceBanner;
    $empId = 0;
    if ($gtype != 15) {
        $updateExcel = [
            'data' => $params,
            'sliceBanner' => $sliceBanner,
            'gtype' => $gtype,
            'empId' => $empId
        ];
        updateExcel($updateExcel);
    }
    $result = array();
    $result['code'] = 1;
    $result['message'] = $downPath;
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $json;
}

/**
 * 数据导出单一数据表
 * $period:
 *  1. 月
 *  2. 天
 */
function excelOneSheet($data)
{
    set_time_limit(120);
    ini_set("memory_limit", "256M");
    $params = $data['params'];
    $period = $data['period'];
    $excelTitle = $data['titles'];
    $excelData = $data['excelData'];
    $filename = $data['filename'];
    $gtype = $data['gtype'];

    $params['time'] = !empty($params['time']) ? $params['time'] : time();
    if (!empty($params['time'])) {
        if ($period == 2) { // 当天日期
            $st = date("Y-m-d", $params['time']);
            $et = $st;
        } else {
            $st = date('Y-m-01', $params['time']);
            $monthDays = date('t', $params['time']);
            $end_time = date("Y-m-{$monthDays} 23:59:59", $params['time']);
            $et = date("Y-m-d", strtotime($end_time));
        }
    }
    $titleNum = count($excelTitle); // 工作表的标题总数
    $dataNum = count($excelData); // 数据总数
    // 获取CI变量
    $_ci = &get_instance();
    // 加载类名Phpexcel和Iofactory
    $_ci->load->library('Phpexcel');
    $_ci->load->library('PHPExcel/Iofactory');

    $cellName = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG',
        'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR',
        'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
    );
    // 商品列表工作表
    $objPHPExcel = new Phpexcel();
    $objPHPExcel->getActiveSheet(0)->setTitle($filename);
    $objPHPExcel->setActiveSheetIndex(0);
    //合并单元格
    $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$titleNum - 1] . '1');
    //第一行标题
    if ($gtype == 20 || $gtype == 21) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "全部" . $filename);
    } else {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "({$st}至{$et})" . $filename);
    }
    $objPHPExcel->getActiveSheet(0)->getStyle('A1:O1')->getFont()->setSize(18);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(20);

    // 设置工作表1的标题
    for ($i = 0; $i < $titleNum; $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $excelTitle[$i][1]);
    }
    // 设置工作表1的数据
    for ($i = 0; $i < $dataNum; $i++) {
        for ($j = 0; $j < $titleNum; $j++) {
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $excelData[$i][$excelTitle[$j][0]] . "\t");
        }
    }
    ob_end_clean();
    ob_start();

    // 将获取得excel文件存到指定目录下面

    $time = date("YmdHi") . rand(0, 999);
    $fileName = $filename . "_" . $time;
    $fileName .= ".xlsx";
    $upload_folder = RESOURCES_PATH . "upload/club/excels/" . date("Y/m/d/");
    if (!file_exists($upload_folder)) {
        mkdir($upload_folder, DIR_WRITE_MODE, true);
    }
    $objPHPExcel->setActiveSheetIndex(0); // 重新定位到工作表0
    $objWriter = \Iofactory::createWriter($objPHPExcel, 'Excel2007');
    $sliceBanner = $upload_folder . $fileName;
    $objWriter->save($sliceBanner);
    $sliceBanner = str_replace(RESOURCES_PATH, "", $sliceBanner);
    $downPath = RESOURCES_DOMAIN . $sliceBanner;
    $empId = 0;
    if ($gtype != 15) {
        $updateExcel = [
            'data' => $params,
            'sliceBanner' => $sliceBanner,
            'gtype' => $gtype,
            'empId' => $empId
        ];
        updateExcel($updateExcel);
    }
    $result = array();
    $result['code'] = 1;
    $result['message'] = $downPath;
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $json;
}

function updateExcel($params)
{
    $data = $params['data'];
    $gtype = $params['gtype'];
    $empId = $params['empId'];
    $sliceBanner = $params['sliceBanner'];

    $CI = &get_instance();
    $CI->load->model("clubs/club_excel_model");
    $sql = "select * from sfs_club_excel where club_id = " . $data['clubId'] . " and branch_id = " . $data['branchId'] . " and 
		type = " . $gtype . " and status = 1";
    if ($empId != 0) {
        $sql .= " and emp_id = " . $empId;
        if ($gtype == 3 || $gtype == 5) {
            //$sql .= " and ctime = ".$this->stime." and etime = ".$this->etime;
        }
    }
    $sql .= " order by id desc limit 0,1";
    log_message("info", "update excel --->".$sql);
    $r = $CI->club_excel_model->selectData($sql);
    if ($r) {
        //找出该条记录
        $up = array();
        $up['url'] = $sliceBanner;
        $up['status'] = 2;
        $up['upuid'] = $data['uid'];
        $up['uptime'] = time();
        $where = "id = " . $r[0]['id'];
        $CI->club_excel_model->updateData($where, $up);
    }
}

/**
 *
 * @desc 将数据导出到Excel中
 * @param $data array 设置表格数据
 * @param $titlename string 设置head
 * @param $filename 设置默认文件名
 * @return 将字符串输出，即输出字节流,下载excel文件
 */
function excelData($data, $titlename, $title, $filename, $gtype, $params)
{
    # xmlns即是xml的命名空间
    # $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
    # 以下构建一个html类型格式的表格
    $str = '<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    $str .= '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name></x:Name><x:WorksheetOptions><x:Selected/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
    $str .= $title;
    $str .= "<table border=1><thead>" . $titlename . "</thead>";
    foreach ($data as $key => $rt) {
        $str .= "<tr>";
        foreach ($rt as $k => $v) {
            $str .= "<td style=' mso-number-format:\"\@\"' align='center'>" . $v . "</td>";
            # $str .= "<td >{$v}</td>";
        }
        $str .= "</tr>\n";
    }
    $str .= "</table></body></html>";
    // 将获取得excel文件存到指定目录下面
    $time = date("YmdHi") . rand(0, 999);
    $fileName = $filename . "_" . $time;
    $fileName .= ".xls";
    $upload_folder = RESOURCES_PATH . "upload/club/excels/" . date("Y/m/d/");
    if (!file_exists($upload_folder)) {
        mkdir($upload_folder, DIR_WRITE_MODE, true);
    }
    $sliceBanner = $upload_folder . $fileName;
    $file = fopen($sliceBanner, "w") or die("Unable to open file!");
    fwrite($file, $str);
    fclose($file);
    $sliceBanner = str_replace(RESOURCES_PATH, "", $sliceBanner);
    $downPath = RESOURCES_DOMAIN . $sliceBanner;
    $empId = 0;
    if ($gtype != 15) {
        $updateExcel = array(
            'data' => $params,
            'sliceBanner' => $sliceBanner,
            'gtype' => $gtype,
            'empId' => $empId
        );
        updateExcel($updateExcel);
    }
    $result = array();
    $result['code'] = 1;
    $result['message'] = $downPath;
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $json;
}


/**
 * 数据导出多个数据工作表，多个titles
 * $titles = array(array("排名", "团队名称", "人数", "卡路里"));
 *
 *$excelData = array(array(array(1, "渥大维", 2, 200)))
 **/
function excelMultiData($data)
{
    set_time_limit(0);
    ini_set("memory_limit", "512M");
    $titles = $data['titles'];
    $excelData = $data['excelData'];
    $tableTitle = $data['tableTitle'];
    $filename = $data['filename'];
    $period = isset($data['period']) ? $data['period'] : 2;
    $params = $data['params'];
    $gtype = $data['gtype'];
    $new = isset($data['new']) ? $data['new'] : 0;

    if (empty($new)) {
        $params['time'] = isset($params['time']) ? $params['time'] : time();
        if (!empty($params['time'])) {
            if ($period == 2) { // 当天日期
                $st = date("Y-m-d", $params['time']);
                $et = $st;
            } else {
                $st = date('Y-m-01', $params['time']);
                $monthDays = date('t', $params['time']);
                $end_time = date("Y-m-{$monthDays} 23:59:59", $params['time']);
                $et = date("Y-m-d", strtotime($end_time));
            }
            $tableTitle .= "({$st}至{$et})";
        }
    }else{
        if(isset($params['stime'])){
            $st = date('Y-m-d', $params['stime']);
        }
        if(isset($params['etime'])){
            $et = date('Y-m-d', $params['etime']);
        }
        $tableTitle .= "({$st}至{$et})";
    }
    // 获取CI变量
    $_ci = &get_instance();
    // 加载类名Phpexcel和Iofactory
    $_ci->load->library('Phpexcel');
    $_ci->load->library('PHPExcel/Iofactory');

    $cellName = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG',
        'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR',
        'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
    );
    $filename = $data['filename'];
    $objPHPExcel = new Phpexcel();
    $objPHPExcel->getActiveSheet(0)->setTitle("工作簿");
    $titleNums = count($titles);; // 标题数据总数
    for ($i = 1; $i < $titleNums; $i++) {
        $otherSheet = new PHPExcel_Worksheet($objPHPExcel, "工作簿" . "{$i}");
        $objPHPExcel->addSheet($otherSheet);
    }
    for ($i = 0; $i < $titleNums; $i++) {
        $p = count($titles[$i]) - 1;
        $objPHPExcel->setActiveSheetIndex($i);
        $objPHPExcel->getActiveSheet($i)->mergeCells('A1:' . $cellName[$p] . '1');
        $objPHPExcel->getActiveSheet($i)->setCellValue('A1', $tableTitle);
        $objPHPExcel->getActiveSheet($i)->getStyle('A1:O1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('A')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('B')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('G')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('H')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('I')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('J')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('K')->setWidth(18);
        $objPHPExcel->getActiveSheet($i)->getColumnDimension('L')->setWidth(20);

        for ($j = 0; $j < count($titles[$i]); $j++) {
            $objPHPExcel->getActiveSheet($i)->setCellValue($cellName[$j] . '2', $titles[$i][$j]);
        }
        if (0 == count($excelData[$i])) {
            // 不做处理
        } else {
            for ($m = 0; $m < count($excelData[$i]); $m++) {
                for ($n = 0; $n < count($titles[$i]); $n++) {
                    $objPHPExcel->setActiveSheetIndex($i);
                    $objPHPExcel->getActiveSheet($i)->setCellValue($cellName[$n] . ($m + 3), $excelData[$i][$m][$n] . "\t");
                }
            }
        }
    }
    $objPHPExcel->setActiveSheetIndex(0); // 重新定位到工作表0
    ob_end_clean();
    ob_start();

    /*header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $filename . '.xlsx"');
    header("Content-Disposition:attachment;filename=$filename.xlsx");//attachment新窗口打印inline本窗口打印
    $objWriter = \Iofactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save("php://output");
    exit;*/

    // 将或缺的excel文件存到指定目录下面
    $time = date("YmdHi") . rand(0, 999);
    $fileName = $filename . "_" . $time;
    $fileName .= ".xlsx";
    $upload_folder = RESOURCES_PATH . "upload/club/excels/" . date("Y/m/d/");
    if (!file_exists($upload_folder)) {
        mkdir($upload_folder, DIR_WRITE_MODE, true);
    }
    $objWriter = \Iofactory::createWriter($objPHPExcel, 'Excel2007');
    $sliceBanner = $upload_folder . $fileName;
    $objWriter->save($sliceBanner);
    $sliceBanner = str_replace(RESOURCES_PATH, "", $sliceBanner);
    $downPath = RESOURCES_DOMAIN . $sliceBanner;
    $empId = 0;
    if ($gtype != 15) {
        $updateExcel = [
            'data' => $params,
            'sliceBanner' => $sliceBanner,
            'gtype' => $gtype,
            'empId' => $empId
        ];
        updateExcel($updateExcel);
    }
    $result = array();
    $result['code'] = 1;
    $result['message'] = $downPath;
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    echo $json;
    return;
}

/**
 * 数据导入
 */
function importExcel($file, $sheet = 0){

    // 获取CI变量
    $_ci = &get_instance();
    // 加载类名Phpexcel和Iofactory
    $_ci->load->library('Phpexcel');
    $_ci->load->library('PHPExcel/Iofactory');

    //文件的扩展名
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $tmpfile = 'tmp'.$ext;

    file_put_contents($tmpfile, file_get_contents($file));

    $objPHPExcel = Iofactory::load($tmpfile);

    $cellName = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G',
        'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y', 'Z'
    );

    $currentSheet = $objPHPExcel->getSheet($sheet); // 获取指定的sheet表
    $allColumn = array_flip($cellName)[$currentSheet->getHighestColumn()]; // 取得最大的列号

    $allRow = $currentSheet->getHighestRow(); // 获取总行数

    $result = array();

    // 读取内容
    $num = 0;
    for($row = 2; $row <= $allRow; $row++){
        for($column = 0; $column <= $allColumn; $column++){
            $cellId = $cellName[$column].$row;
            $cellValue = $currentSheet->getCell($cellId)->getValue();
            if($cellValue instanceof PHPExcel_RichText){
                $cellValue = $cellValue->__toString();
            }
            if(!empty($cellValue)) {
                $result[$num][$cellName[$column]] = $cellValue;
            }
        }
        $num++;
    }
    return $result;

}