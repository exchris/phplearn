<?php
include_once './include/db.php';
header('content-type:text/html;charset=utf-8');
class Group
{
    // 运动圈属性
    private $_groupId;             // 圈子ID
    private $_groupName;          // 圈子名称
    private $_groupSignature;    // 圈子简介
    private $_groupOwner;        // 圈子圈主
    private $_groupState;        // 圈子状态
    private $_groupType;         // 圈子类型
    private $_groupCountry;     // 圈子所属国家
    private $_groupProvince;    // 圈子所属国家省州
    private $_groupCity;        // 圈子所属城市
    private $_groupSport;       // 圈子支持的打卡运动
    private $_groupImage;       // 圈子头像

    private static $_instance = null;

    // 单例模式
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function getGroupCity()
    {
        return $this->_groupCity;
    }

    public function getGroupId()
    {
        return $this->_groupId;
    }

    public function getGroupName()
    {
        return $this->_groupName;
    }

    public function getGroupCountry()
    {
        return $this->_groupCountry;
    }

    public function getGroupImage()
    {
        return $this->_groupImage;
    }

    public function getGroupOwner()
    {
        return $this->_groupOwner;
    }

    public function getGroupProvince()
    {
        return $this->_groupProvince;
    }

    public function getGroupSignature()
    {
        return $this->_groupSignature;
    }

    public function getGroupSport()
    {
        return $this->_groupSport;
    }

    public function getGroupState()
    {
        return $this->_groupState;
    }

    public function getGroupType()
    {
        return $this->_groupType;
    }

    public function setGroupCity($groupCity)
    {
        $this->_groupCity = $groupCity;
    }

    public function setGroupCountry($groupCountry)
    {
        $this->_groupCountry = $groupCountry;
    }

    public function setGroupId($groupId)
    {
        $this->_groupId = $groupId;
    }

    public function setGroupImage($groupImage)
    {
        $this->_groupImage = $groupImage;
    }

    public function setGroupName($groupName)
    {
        $this->_groupName = $groupName;
    }

    public function setGroupOwner($groupOwner)
    {
        $this->_groupOwner = $groupOwner;
    }

    public function setGroupProvince($groupProvince)
    {
        $this->_groupProvince = $groupProvince;
    }

    public function setGroupSignature($groupSignature)
    {
        $this->_groupSignature = $groupSignature;
    }

    public function setGroupSport($groupSport)
    {
        $this->_groupSport = $groupSport;
    }

    public function setGroupState($groupState)
    {
        $this->_groupState = $groupState;
    }

    public function setGroupType($groupType)
    {
        $this->_groupType = $groupType;
    }

    public static function existsGroup($name) {
        $db = DB::getInstance();
        $sql = "select gid from `group` where name='{$name}' limit 1";
        $result = $db->getOne($sql);
        return $result;
    }
}

$group = Group::getInstance();
$a = $group->existsGroup('运动秀·官方');
var_dump($a);
