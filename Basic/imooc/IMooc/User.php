<?php

namespace IMooc;

class User
{
    public $id;
    public $name;
    public $mobile;
    public $regtime;
    public $serial_no;

    protected $db;

    /**
     * User constructor.
     * @param $id
     */
    function __construct($id)
    {
        $this->db = new \IMooc\Database\MySQLi();
        $this->db->connect('127.0.0.1', 'root', 'root', 'test');
        $res = $this->db->query("select * from user limit 1");
        $data = $res->fetch_assoc();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->mobile = $data['mobile'];
        $this->regtime = $data['regtime'];
        $this->serial_no = $data['serial_no'];
    }

    function __destruct()
    {
        $this->db->query("update user set name='{$this->name}',
        mobile='{$this->mobile}',regtime='{$this->regtime}',
        serial_no='{$this->serial_no}' where id = {$this->id} limit 1");
    }
}