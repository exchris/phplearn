<?php

namespace IMooc;

class FemaleUserStrategy implements UserStrategy
{

    function showAd()
    {
        echo "2017新款女装";
    }

    function showStrategy()
    {
        echo "女装";
    }
}