<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index() {
		$this->display('User/login');
	}
	
	public function main() {
		$this->display('index');
	}
}