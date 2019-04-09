<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5 0005
 * Time: 上午 11:58
 */

namespace IMooc;

interface Observer
{
    function update($event_info = null);
}