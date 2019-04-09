<?php
/**
 * Created by PhpStorm.
 * User: dev.erxuan@gmail.com
 * Date: 2017/11/16 0016
 * Time: 下午 4:36
 * 功能: 去除PHP源码中空白行以及注释行
 */

/**
 * 去除PHP代码注释
 * @param string $content 代码内容
 * @return string 去除注释之后的内容
 */
function removeComment($content)
{
    return preg_replace("/(\/\*.*\*\/)|(#.*?\n)|(\/\/.*?\n)/s", '',str_replace(array("\r\n","\r"),"\n", $content));
}

/**
 * 去除代码中的空白和注释
 * @param string $content 代码内容
 * @return string
 */
function strip_whitespace($content) {
    $stripStr   = '';
    //分析php源码
    $tokens     = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $stripStr  .= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                //过滤各种PHP注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //过滤空格
                case T_WHITESPACE:
                    if (!$last_space) {
                        $stripStr  .= ' ';
                        $last_space = true;
                    }
                    break;
                case T_START_HEREDOC:
                    $stripStr .= "<<<THINK\n";
                    break;
                case T_END_HEREDOC:
                    $stripStr .= "THINK;\n";
                    for($k = $i+1; $k < $j; $k++) {
                        if(is_string($tokens[$k]) && $tokens[$k] == ';') {
                            $i = $k;
                            break;
                        } else if($tokens[$k][0] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                    break;
                default:
                    $last_space = false;
                    $stripStr  .= $tokens[$i][1];
            }
        }
    }
    return $stripStr;
}

/**
 * @param $src 源码内容
 * @return bool|string
 */
function replace_php_src($src) {
    static $IW = array(
        T_CONCAT_EQUAL,             // .=
        T_DOUBLE_ARROW,             // =>
        T_BOOLEAN_AND,              // &&
        T_BOOLEAN_OR,               // ||
        T_IS_EQUAL,                 // ==
        T_IS_NOT_EQUAL,             // != or <>
        T_IS_SMALLER_OR_EQUAL,      // <=
        T_IS_GREATER_OR_EQUAL,      // >=
        T_INC,                      // ++
        T_DEC,                      // --
        T_PLUS_EQUAL,               // +=
        T_MINUS_EQUAL,              // -=
        T_MUL_EQUAL,                // *=
        T_DIV_EQUAL,                // /=
        T_IS_IDENTICAL,             // ===
        T_IS_NOT_IDENTICAL,         // !==
        T_DOUBLE_COLON,             // ::
        T_PAAMAYIM_NEKUDOTAYIM,     // ::
        T_OBJECT_OPERATOR,          // ->
        T_DOLLAR_OPEN_CURLY_BRACES, // ${
        T_AND_EQUAL,                // &=
        T_MOD_EQUAL,                // %=
        T_XOR_EQUAL,                // ^=
        T_OR_EQUAL,                 // |=
        T_SL,                       // <<
        T_SR,                       // >>
        T_SL_EQUAL,                 // <<=
        T_SR_EQUAL,                 // >>=
    );
    if(is_file($src)) {
        if(!$src = file_get_contents($src)) {
            return false;
        }
    }
    $tokens = token_get_all(substr ($src, 0, -2));

    $new = "";
    $c = sizeof($tokens);
    $iw = false; // ignore whitespace
    $ih = false; // in HEREDOC
    $ls = "";    // last sign
    $ot = null;  // open tag
    for($i = 0; $i < $c; $i++) {
        $token = $tokens[$i];
        if(is_array($token)) {
            list($tn, $ts) = $token; // tokens: number, string, line
            $tname = token_name($tn);
            if($tn == T_INLINE_HTML) {
                $new .= $ts;
                $iw = false;
            } else {
                if($tn == T_OPEN_TAG) {
                    if(strpos($ts, " ") || strpos($ts, "\n") || strpos($ts, "\t") || strpos($ts, "\r")) {
                        $ts = rtrim($ts);
                    }
                    $ts .= " ";
                    $new .= $ts;
                    $ot = T_OPEN_TAG;
                    $iw = true;
                } elseif($tn == T_OPEN_TAG_WITH_ECHO) {
                    $new .= $ts;
                    $ot = T_OPEN_TAG_WITH_ECHO;
                    $iw = true;
                } elseif($tn == T_CLOSE_TAG) {
                    if($ot == T_OPEN_TAG_WITH_ECHO) {
                        $new = rtrim($new, "; ");
                    } else {
                        $ts = " ".$ts;
                    }
                    $new .= $ts;
                    $ot = null;
                    $iw = false;
                } elseif(in_array($tn, $IW)) {
                    $new .= $ts;
                    $iw = true;
                } elseif($tn == T_CONSTANT_ENCAPSED_STRING
                    || $tn == T_ENCAPSED_AND_WHITESPACE)
                {
                    if($ts[0] == '"') {
                        $ts = addcslashes($ts, "\n\t\r");
                    }
                    $new .= $ts;
                    $iw = true;
                } elseif($tn == T_WHITESPACE) {
                    $nt = @$tokens[$i+1];
                    if(!$iw && (!is_string($nt) || $nt == '$') && !in_array($nt[0], $IW)) {
                        $new .= " ";
                    }
                    $iw = false;
                } elseif($tn == T_START_HEREDOC) {
                    $new .= "<<<S\n";
                    $iw = false;
                    $ih = true; // in HEREDOC
                } elseif($tn == T_END_HEREDOC) {
                    $new .= "S;";
                    $iw = true;
                    $ih = false; // in HEREDOC
                    for($j = $i+1; $j < $c; $j++) {
                        if(is_string($tokens[$j]) && $tokens[$j] == ";") {
                            $i = $j;
                            break;
                        } else if($tokens[$j][0] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                } elseif($tn == T_COMMENT || $tn == T_DOC_COMMENT) {
                    $iw = true;
                } else {
                    if(!$ih) {
                        $ts = strtolower($ts);
                    }
                    $new .= $ts;
                    $iw = false;
                }
            }
            $ls = "";
        } else {
            if(($token != ";" && $token != ":") || $ls != $token) {
                $new .= $token;
                $ls = $token;
            }
            $iw = true;
        }
    }
    return $new.' ?>';
}

echo "源码:<br/>";
show_source(__FILE__);
echo "<hr/>去除注释后:<br/>";
highlight_string(removeComment(file_get_contents(__FILE__)));

