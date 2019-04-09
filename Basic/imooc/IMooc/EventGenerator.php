<?php

namespace IMooc;


abstract class EventGenerator
{
    protected $observers = array();
    function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    function notify()
    {
        foreach ($this->observers as $observer)
        {
            $observer->update();
        }
    }
}