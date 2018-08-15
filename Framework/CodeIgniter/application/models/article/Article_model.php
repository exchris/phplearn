<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends CI_Model
{
    private $_tablename = 'article';
    private $db_connect = null;
    public function __construct()
    {
        parent::__construct();
        $this->db_connect = $this->load->database("ci_blogs", true);
    }

    public function getNameById($id)
    {

    }
}