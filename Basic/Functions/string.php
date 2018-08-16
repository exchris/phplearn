<?php
$string = "Hello world & sunyang!";
$count = str_word_count($string);
echo '字符串中共有'.$count.'个单词'."<br>";
print_r(str_word_count($string,1)); //显示字符串中的单词
echo "<br/>";
print_r(str_word_count($string,2));//显示字符串中的单词和单词的开始位置
echo "<br/>";
print_r(str_word_count($string,1,"&"));//将第三个参数当成单词处理

