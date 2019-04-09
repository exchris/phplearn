<?php

namespace common;

interface IRecord
{
    function existsRid($rid);
    function load($rid);
    function sysc($uid, $username);
    function delete($rid);
    function save();
}