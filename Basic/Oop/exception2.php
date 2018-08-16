<?php
#扩展基本异常类
class CustomException extends Exception {
	public function errorMessage() {
		$errorMsg = "出错原因:".$this->getMessage()."不是一个合法的Email<br>";
		$errorMsg .= "错误文件路径:".$this->getFile()."<br>";
		$errorMsg .= "错误代码行号:".$this->getLine();
		return $errorMsg;
	}
}
$email = "sunyang@example...com";
try {
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
		throw new CustomException($email);
	} 
} catch (CustomException $ce) {
	echo $ce->errorMessage();
}