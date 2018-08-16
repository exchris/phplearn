<?php
//扩展基本异常类
class CustomException extends Exception {
	public function errorMessage() {
		$errorMsg = "出错原因:".$this->getMessage()."不是一个合法的Email<br>";
		$errorMsg .= "错误文件路径:".$this->getFile()."<br>";
		$errorMsg .= "错误代码行号:".$this->getLine();
		return $errorMsg;
	}
}
$email = "sunyang@example.com";
try {
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
		throw new CustomException($email);
	} 
	
	if (strpos($email, "example") !== FALSE) {
		throw new Exception("<b>".$email."</b>是一个example电子邮件地址");
	}
} catch (CustomException $ce) {
	echo $ce->errorMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}