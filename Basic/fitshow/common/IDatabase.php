<?php

namespace common;

interface IDatabase
{
    function connect($host, $user, $passwd, $dbname);
    function query($sql);
    function getLastId();
    function close();
}