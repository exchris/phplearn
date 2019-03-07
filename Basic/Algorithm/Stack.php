<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 9:20
 * @author exchris
 */

class Data
{
    // 数据
    private $_data;

    public function __construct($data)
    {
        $this->_data = $data;
        echo $data . ":哥入栈了!<br>";
    }

    public function getData()
    {
        return $this->_data;
    }
}

class Stack
{
    private $size;
    private $top;
    private $stack = array();

    public function __construct($size)
    {
        $this->Init_Stack($size);
    }

    // 初始化栈
    public function Init_Stack($size)
    {
        $this->size = $size;
        $this->top = -1;
    }

    // 判断栈是否为空
    public function Empty_Stack()
    {
        return $this->top == -1 ? 1 : 0;
    }

    // 判断栈是否已满
    public function Full_Stack()
    {
        return $this->size < $this->size - 1 ? 0 : 1;
    }

    //入栈
    public function Push_Stack($data)
    {
        if ($this->Full_Stack()) echo "栈满了<br />";
        else $this->stack[++$this->top] = new data($data);
    }

    //出栈
    public function Pop_Stack()
    {
        if ($this->Empty_Stack()) echo "栈空着呢<br />";
        else unset($this->stack[$this->top--]);
    }

    //读取栈顶元素
    public function Top_Stack()
    {
        return $this->Empty_Stack() ? "栈空无数据！" : $this->stack[$this->top]->getData();
    }
}

$stack = new stack(4);
$stack->Pop_Stack();
$stack->Push_Stack("aa");
$stack->Push_Stack("aa1");
$stack->Pop_Stack("aa1");
$stack->Push_Stack("aa2");
$stack->Push_Stack("aa3");
$stack->Push_Stack("aa4");
echo $stack->Top_Stack(), '<br />';
$stack->Push_Stack("aa5");
$stack->Push_Stack("aa6");
$stack->Pop_Stack();
$stack->Pop_Stack();
$stack->Pop_Stack();
$stack->Pop_Stack();
$stack->Pop_Stack();
$stack->Pop_Stack();