<?php

namespace common;

use common\IRecord;
use common\User;

class Record implements IRecord
{
    protected $db;
    public function __construct()
    {
        $this->db = new \common\Database();
        $this->db->connect('121.201.3.144','root','yujie1299','ttpaobu');
    }

    function existsRid($rid)
    {
        $res = $this->db->query("select rid from record where rid=$rid limit 1");
        if ($res->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    function load($rid)
    {
        // TODO: Implement load() method.
    }

    function sysc($uid, $username)
    {
        $user = new User();
        $rids = '';
        $existsUser = $user->existsUser($uid, $username);
        if ($existsUser) {
            $res = $this->db->query("select rid from record where uid=$uid order by rid desc");
            foreach ($res as $key => $value) {
                $rids .= $value['rid'].',';
            }
            echo json_encode(["count"=>$res->num_rows,"ids"=>"{$rids}0"],JSON_UNESCAPED_UNICODE) ;
        } else {
            throw new \Exception("非法用户");
        }
    }

    function delete($rid)
    {
        // TODO: Implement delete() method.
    }

    function save()
    {
        // TODO: Implement save() method.
    }
}