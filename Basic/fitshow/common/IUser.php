<?php

namespace common;

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