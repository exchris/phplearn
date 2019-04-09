<?php

namespace common;
use common\IDatabase;


class Database implements IDatabase
{
    protected $conn;

    function connect($host, $user, $passwd, $dbname)
    {
        $conn = mysqli_connect($host, $user, $passwd, $dbname);
        $this->conn = $conn;
    }

    function query($sql)
    {
        $res = mysqli_query($this->conn, $sql);
        return $res;
    }

    function getLastId()
    {
        return mysqli_insert_id($this->conn);
    }

    function close()
    {
        mysqli_close($this->_conn);
    }
}