<?php

namespace App\Controller;

use IMooc\Controller;
use IMooc\Factory;

class Home extends Controller
{
    function index()
    {
        $model = Factory::getMode('User');
        $userid = $model->create(array('name' => 'rango', 'mobile' => '18933330000'));
        return array('userid' => $userid, 'name' => 'rango');
    }

    function index2()
    {
        echo "index2";
    }
}