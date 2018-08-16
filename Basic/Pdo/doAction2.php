<?php 
error_reporting(0);
header ( 'content-type:text/html;charset=utf-8' );
$username = 'admin';
$password = '123456';
try {
	$pdo = new PDO ( 'mysql:host=localhost;dbname=ttpaobu', 'root', 'root' );
	//以?预处理
	$sql = "select * from user where username=? and password=?";
	$stmt = $pdo->prepare ( $sql );
	$stmt->execute ( array ($username, $password ) );
	echo $stmt->rowCount ();

} catch ( PDOException $e ) {
	echo $e->getMessage ();
}
