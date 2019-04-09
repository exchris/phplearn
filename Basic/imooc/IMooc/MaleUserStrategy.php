<?php

namespace IMooc;

class MaleUserStrategy implements UserStrategy
{

    function showAd()
    {
       echo "iPhoneX";
    }

    function showStrategy()
    {
        echo "电子产品";
    }
}