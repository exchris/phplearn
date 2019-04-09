<?php

namespace common;
use common\Database;

interface IUser
{
    public function existsUser($uid, $username);
    public function login($username, $password);
    public function echoUserProperty($row = null, $new = false, $info = true);
    public function register($username, $password);
    public function loadImage($image);
    public function saveImage($uid);
    public function saveDetail($info = array(), $last = false);
    public function search($uid);
}

class User implements IUser
{
    private $uid;
    private $username;
    private $password;
    private $nickname;
    private $state;
    private $country;
    private $province;
    private $city;
    private $gender;
    private $birthday;
    private $height;
    private $weight;
    private $disease;
    private $interest;
    private $settings;
    private $level;
    private $times;
    private $distance;
    private $runtime;
    private $calories;
    private $count;
    private $image;
    private $cover;
    private $signature;
    private $summary;
    private $timestamp;
    private $regdate;
    private $appkey;

    protected $db;

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     * @return User
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     * @return User
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     * @return User
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return User
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisease()
    {
        return $this->disease;
    }

    /**
     * @param mixed $disease
     * @return User
     */
    public function setDisease($disease)
    {
        $this->disease = $disease;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param mixed $interest
     * @return User
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     * @return User
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimes()
    {
        return $this->times;
    }

    /**
     * @param mixed $times
     * @return User
     */
    public function setTimes($times)
    {
        $this->times = $times;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     * @return User
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param mixed $runtime
     * @return User
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * @param mixed $calories
     * @return User
     */
    public function setCalories($calories)
    {
        $this->calories = $calories;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     * @return User
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     * @return User
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     * @return User
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     * @return User
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     * @return User
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegdate()
    {
        return $this->regdate;
    }

    /**
     * @param mixed $regdate
     * @return User
     */
    public function setRegdate($regdate)
    {
        $this->regdate = $regdate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppkey()
    {
        return $this->appkey;
    }

    /**
     * @param mixed $appkey
     * @return User
     */
    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;
        return $this;
    }

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect('121.201.3.144','root','yujie1299','ttpaobu');
    }

    /**
     * 判断当前用户是否合法
     */
    public function existsUser($uid, $username)
    {
        $res = $this->db->query("select uid from user where uid=$uid and username='{$username}' limit 1");
        if ($res->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $res = $this->db->query("select * from user where username='{$username}' and password='{$password}' limit 1");
        return $res->fetch_assoc();
    }

    public function echoUserProperty($row = null, $new = false, $info = true)
    {
        // TODO: Implement echoUserProperty() method.
    }

    public function register($username, $password)
    {
        // TODO: Implement register() method.
    }

    public function loadImage($image)
    {
        // TODO: Implement loadImage() method.
    }

    public function saveImage($uid)
    {
        // TODO: Implement saveImage() method.
    }

    public function saveDetail($info = array(), $last = false)
    {
        // TODO: Implement saveDetail() method.
    }

    public function search($uid)
    {
        // TODO: Implement search() method.
    }
}
