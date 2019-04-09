<?php

define('BASEDIR', __DIR__);

// 设计模式学习

include BASEDIR . '/IMooc/Loader.php';
spl_autoload_register('\\IMooc\\Loader::autoload');
// echo '<meta http-equiv="content-type" content="text/html;charset=utf-8"/>';


// IMooc\Application::getInstance(__DIR__)->dispatch();

//$config = new \IMooc\Config(__DIR__.'/configs');
//var_dump($config['controller']);

// 代理模式
//$proxy = new \IMooc\Proxy();
//$proxy->getUserName($id);
//$proxy->setUserName($id, $proxy);


// 迭代器模式
//$users = new \IMooc\AllUser();
//foreach ($users as $user)
//{
//    var_dump($user->name);
//    var_dump(rand(10000, 90000));
//    $user->serial_no = rand(10000, 90000);
//}

// $db = new IMooc\Database\MySQLi();
// $db->connect('127.0.0.1','root','root','test');
// $db->query("show databases");
// $db->close();

// $user = new \IMooc\User(1);

//var_dump($user->id, $user->mobile, $user->name, $user->regtime);
//exit();

// $user->mobile = '18933334444';
// $user->name = 'test';
// $user->regtime = date('Y-m-d H:i:s');


class Page
{
    function index()
    {
        $user = IMooc\Factory::getUser(1);
        $user->name = 'rango';
        $this->test();
    }

    function test()
    {
        $user = IMooc\Factory::getUser(1);
        $user->mobile = '18933330000';
    }

    /**
     * @var \IMooc\UserStrategy
     */
//    protected $strategy;
//    function index()
//    {
//        echo "AD:";
//        $this->strategy->showAd();
//        echo "<br/>";
//
//        echo "Category:";
//        $this->strategy->showStrategy();
//        echo "<br/>";
//    }

//    function setStrategy(\IMooc\UserStrategy $strategy) {
//        $this->strategy = $strategy;
//    }
}

//class Canvas2 extends IMooc\Canvas
//{
//    function draw()
//    {
//        echo "<div style='color:red';>";
//        parent::draw();
//        echo "</div>";
//    }
//}

// 装饰器模式
//$canvas1 = new IMooc\Canvas();
//$canvas1->init();
//$canvas1->addDecorator(new \IMooc\ColorDrawDecorator('green'));
//$canvas1->addDecorator(new IMooc\SizeDrawDecorator('20px'));
//$canvas1->rect(3, 6, 4, 12);
//$canvas1->draw();

// 原型模式
// $prototype = new IMooc\Canvas();
// $prototype->init();
//
// $canvas1 = clone $prototype;
// $canvas1->rect(3, 6, 4, 12);
// $canvas1->draw();
//
// echo "==================================<br/>\n";
//
// $canvas2 = clone $prototype;
// $canvas2->rect(4, 3, 2, 6);
// $canvas2->draw();


// 观察者模式
class Event extends \IMooc\EventGenerator
{
    function trigger()
    {
        echo "Event<br/>\n";
        $this->notify();
    }
}

class Observer1 implements \IMooc\Observer
{
    function update($event_info = null)
    {
        echo "逻辑1<br/>\n";
    }
}

class Observer2 implements \IMooc\Observer
{
    function update($event_info = null)
    {
        echo "逻辑2<br/>\n";
    }
}

//$event = new Event();
//$event->addObserver(new Observer1);
//$event->addObserver(new Observer2);
//$event->trigger();

// $page = new Page();

//if (isset($_GET['female'])) {
//    $strategy = new \IMooc\FemaleUserStrategy();
//} else {
//    $strategy = new \IMooc\MaleUserStrategy();
//}
//$page->setStrategy($strategy);

// $page->index();


// $obj = new IMooc\Object();
// $obj->title = "hello";
// echo $obj->title;
// $obj->test("hello",123);
// echo IMooc\Object::test("hello1",123);
// echo $obj("test1");


/*
 * 测试实例
 * IMooc\Object::test();
 * App\Controller\Home\Index::test();
 * */

// 栈先进后出
/*
 * $stack = new SplStack();
 * $stack->push("data1\n");
 * $stack->push("date2\n");
 *
 * echo $stack->pop();
 * echo $stack->pop();*/

/**
 * 队列先进先出
 * $queue = new SplQueue();
 * $queue->enqueue("data1\n");
 * $queue->enqueue("data2\n");
 *
 * echo $queue->dequeue();
 * echo $queue->dequeue();
 */

/*
 * $heap = new SplMinHeap();
 * $heap->insert("data1\n");
 * $heap->insert("data2\n");
 *
 * echo $heap->extract();
 * echo $heap->extract();
 **/

/**
 * $array = new SplFixedArray(10);
 * $array[0] = 123;
 * $array[9] = 1234;
 * var_dump($array);
 **/

/*
 * $db = new \IMooc\Database();
 * $db->where("id=1")->where("name=2")
 * ->order("id desc")->limit(10);
 **/



