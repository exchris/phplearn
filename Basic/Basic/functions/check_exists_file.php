<?php 
function check_exists_file($file_http_path){
	if(strtolower(substr($file_http_path,0,4))=='http'){
            $header = get_headers($file_http_path,true);
            return isset($header[0]) && (strpos($header[0], '200') || strpos($header[0], '304'));
    }else{
		return file_exists('.'.$file_http_path);
	}
}
