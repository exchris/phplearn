<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16 0016
 * Time: 下午 4:50
 * Link: http://www.ifitshow.com
 * Copyright 2017-11-17 10:24 AM
 */
header ( "Content-type: text/html; charset=utf-8" );

/**
 * 去除PHP源码中的空白和注释
 * @param $content
 * @return string
 */
function removePHPSrc($content)
{
    $result = token_get_all ( $content );
// 遍历数组 使用指针
    $string = '';
    $space = false;
// print_r($result);
    while ( current ( $result ) ) {
        $value = current ( $result );
        if (is_string ( $value )) {
            // 去掉字符左侧的 空白
            if ($space) {
                $string = rtrim ( $string ) . $value;
            } else {
                $string .= $value;
            }
            // 去掉字符右侧的 空白 添加一个标记  如果为 True需要删除右侧的空白 如果 为 false 不需要删除右侧的空白
            $space = true;
        } else {
            switch ($value [0]) {
                // 去掉php开始标记中的空格
                case T_OPEN_TAG :
                    $string .= trim ( $value [1] ) . ' ';
                    //这样做了能删除各种注释下的多余空格 如果没有下边这句会造成有多余空格  如 <?php /**/,<?php // , <?php echo
                    //虽然我这样做了 ^_^ 但是我没想明白...
                    $space = true;
                    break;
                // 把空白字符全部转换为 空格
                case T_WHITESPACE :
                    if ($space == false) {
                        $string .= ' ';
                        $space = true;
                    }
                    break;
                // 去掉注释
                case T_DOC_COMMENT :
                    $space = true;
                    break;
                // 去掉注释
                case T_COMMENT :
                    $space = true;
                    break;
                // 判断定界符开始
                case T_START_HEREDOC :
                    $space = false;
                    $string .= "<<<S\n";
                    break;
                // 判断定界符结束
                case T_END_HEREDOC :
                    $space = true;
                    $string .= "S;\n";
                    //因为这里取到的值是不带 分号 ; 的 这里直接 跳过下个元素的处理 注：不知道会不会存在问题  测试没问题
                    next ( $result );

                    break;
                default :
                    // 去掉某些 左右 的空白 你可以添加更多你认为两边可以删除空白的标记 目前我找到这些
                    $array = array (
                        T_CONCAT_EQUAL, // .=
                        T_DOUBLE_ARROW, // =>
                        T_BOOLEAN_AND, // &&
                        T_BOOLEAN_OR, // ||
                        T_IS_EQUAL, // ==
                        T_IS_NOT_EQUAL, // != or <>
                        T_IS_SMALLER_OR_EQUAL, // <=
                        T_IS_GREATER_OR_EQUAL, // >=
                        T_INC, // ++
                        T_DEC, // --
                        T_PLUS_EQUAL, // +=
                        T_MINUS_EQUAL, // -=
                        T_MUL_EQUAL, // *=
                        T_DIV_EQUAL, // /=
                        T_IS_IDENTICAL, // ===
                        T_IS_NOT_IDENTICAL, // !==
                        T_DOUBLE_COLON, // ::
                        T_PAAMAYIM_NEKUDOTAYIM, // ::
                        T_OBJECT_OPERATOR, // ->
                        T_DOLLAR_OPEN_CURLY_BRACES, // ${
                        T_AND_EQUAL, // &=
                        T_MOD_EQUAL, // %=
                        T_XOR_EQUAL, // ^=
                        T_OR_EQUAL, // |=
                        T_SL, // <<
                        T_SR, // >>
                        T_SL_EQUAL, // <<=
                        T_SR_EQUAL  // >>=
                    );

                    if (in_array ( $value [0], $array )) {
                        $string = rtrim ( $string ) . $value [1];
                        // ;;;;;;;;;;; //有强迫症的可以继续删除 多余 的分号 我就不删除了
                    } else {
                        $string .= $value [1];
                    }
                    $space = in_array ( $value [0], $array );
                    break;
            }
        }
        next ( $result );
    }
    return $string;
}
// $content = file_get_contents ( 'demo.php' );

$content = file_get_contents ('../record.php');

file_put_contents("../src_record.php", removePHPSrc($content));