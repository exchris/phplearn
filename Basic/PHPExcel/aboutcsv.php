<?php 
function exportExcel()
    {
        //加载模型
        $this->load->library('Phpexcel');
        $this->load->library('PHPExcel/Iofactory');

        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array();
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $objPHPExcel = new Phpexcel();
        echo "<pre>";
        print_r($objPHPExcel);
        echo "</pre>";
    }

    //导出说明:因为EXCEL单表只能显示104W数据，同时使用PHPEXCEL容易因为数据量太大而导致占用内存过大，
    //因此，数据的输出用csv文件的格式输出，但是csv文件用EXCEL软件读取同样会存在只能显示104W的情况，所以将数据分割保存在多个csv文件中，并且最后压缩成zip文件提供下载
    function putCsv(array $head, $data, $mark = 'attack_ip_info', $fileName = "test.csv")
    {
        set_time_limit(0);
        $sqlCount = $data->count();
        // 输出Excel文件头，可把user.csv换成你要的文件名
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $sqlLimit = 100000;//每次只从数据库取100000条以防变量缓存太大
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        // buffer计数器
        $cnt = 0;
        $fileNameArr = array();
        // 逐行取出数据，不浪费内存
        for ($i = 0; $i < ceil($sqlCount / $sqlLimit); $i++) {
            $fp = fopen($mark . '_' . $i . '.csv', 'w'); //生成临时文件
            //     chmod('attack_ip_info_' . $i . '.csv',777);//修改可执行权限
            $fileNameArr[] = $mark . '_' . $i . '.csv';
            // 将数据通过fputcsv写到文件句柄
            fputcsv($fp, $head);
            $dataArr = $data->offset($i * $sqlLimit)->limit($sqlLimit)->get()->toArray();
            foreach ($dataArr as $a) {
                $cnt++;
                if ($limit == $cnt) {
                    //刷新一下输出buffer，防止由于数据过多造成问题
                    ob_flush();
                    flush();
                    $cnt = 0;
                }
                fputcsv($fp, $a);
            }
            fclose($fp);  //每生成一个文件关闭
        }
        //进行多个文件压缩
        $zip = new ZipArchive();
        $filename = $mark . ".zip";
        $zip->open($filename, ZipArchive::CREATE);   //打开压缩包
        foreach ($fileNameArr as $file) {
            $zip->addFile($file, basename($file));   //向压缩包中添加文件
        }
        $zip->close();  //关闭压缩包
        foreach ($fileNameArr as $file) {
            unlink($file); //删除csv临时文件
        }
        //输出压缩文件提供下载
        header("Cache-Control: max-age=0");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . basename($filename)); // 文件名
        header("Content-Type: application/zip"); // zip格式的
        header("Content-Transfer-Encoding: binary"); //
        header('Content-Length: ' . filesize($filename)); //
        @readfile($filename);//输出文件;
        unlink($filename); //删除压缩包临时文件
    }

    /*
     * 该方法是把数据库读出的数据进行CSV文件输出，能接受百万级别的数据输出，因为用生成器，不用担心内存溢出。
     * @param string $sql 需要导出的数据SQL
     * @param string $mark 生成文件的名字前缀
     * @param bool $is_multiple 是否要生成多个CSV文件
     * @param int $limit 每隔$limit行，刷新输出buffer,以及每个CSV文件行数限制
     *
     */
    function putNewCsv($sql, $mark, $is_multiple = 0, $limit = 100000)
    {
        set_time_limit(0);
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $mark . '"');
        header('Cache-Control: max-age=0');

        // 每隔$limit行，刷新一下输出buffer,也可以控制多csv文件生成的行数限制
//    $limit = 100000;
        // buffer计数器
        $file_num = 0;  //文件名计数器
        $row_num = 0;
        $fileNameArr = array();
        // 逐行取出数据，不浪费内存
        $fp = fopen($mark . '_' . $file_num . '.csv', 'w'); //生成临时文件
        $fileNameArr[] = $mark . '_' . $file_num . '.csv';
        fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));//转码,防止乱码
        foreach (query($sql) as $a) {
            $row_num++;
            if ($limit <= $row_num) {
                //刷新一下输出buffer，防止由于数据过多造成问题
                if (ob_get_level() > 0) ob_flush();
                flush();
                $row_num = 0;
                $file_num++;
                if ($is_multiple > 0) {
                    fclose($fp);  //每生成一个文件关闭
                    $fp = fopen($mark . '_' . $file_num . '.csv', 'w');
                    $fileNameArr[] = $mark . '_' . $file_num . '.csv';
                    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));//转码,防止乱码
                }
            }
            fputcsv($fp, $a);
        }
        fclose($fp);  //每生成一个文件关闭
        getZip('test', $fileNameArr); //生成zip文件
    }
?>
