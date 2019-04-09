<?php 
function getFileType($fileName)
{
	if(function_exists("finfo_open")) {
		$handle = finfo_open(FILEINFO_MIME_TYPE);
		$fileType = finfo_file($handle, $fileName); //Return information about a file
		finfo_close($handle);
	} else {
		//TODO:: 若没有启用扩展fileinfo采用此方式获取类型，待完善
		$file = fopen($fileName, "rb");
		$bin = fread($file, 2); //只读2字节
		fclose($file);
		$strInfo  = @unpack('C2chars', $bin);
		$typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
		switch ($typeCode) {
			case 255216:
				$fileType = 'image/jpeg';
				break;
			case 7173:
				$fileType = 'image/gif';
				break;
			case 13780:
				$fileType = 'image/png';
				break;
			default:
				$fileType = "application/octet-stream";
		}
		//Fix
		if ($strInfo['chars1'] == '-1' && $strInfo['chars2'] == '-40') {
			return 'image/jpeg';
		}
		if ($strInfo['chars1'] == '-119' && $strInfo['chars2'] == '80') {
			return 'image/png';
		}
	}
	return $fileType;
}
?>
