<?php 

$file_name = 'index.shtml';

// 如果文件时存在并且最后修改时间小于设定时间10s
// filemtime($file_name); // 得到文件最后修改时间
// time();	// 当前时间
if (file_exists($file_name) && filemtime($file_name) - time() < 10) {
	require_once($file_name); // 引入文件
} else {
	ob_start();
}
?>
<p>我是要生成的静态内容</p>
<?php
// 输出到浏览器
file_put_contents($file_name, ob_get_contents());
?>