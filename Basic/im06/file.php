<?php 

# file_put_contents('index.shtml', 'dhrhadfqfckcasse');

ob_start(); # 打开输出控制缓冲,开辟一个新的缓冲区
echo 345566;
# echo ob_get_contents();
file_put_contents('index.shtml', ob_get_clean());
// ob_clean();
