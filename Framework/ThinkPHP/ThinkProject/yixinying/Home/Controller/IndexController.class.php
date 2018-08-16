<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
	//首页
	function index() {
		$username = session('username');
		$uid = session('uid');
		
		$this->assign('username', $username);
		
		//获取最新的10条楼盘信息
		$estate = M('estate')->limit(10)->order('time desc')->select();

		$this->assign('info', $estate);
		
		//二手房信息
		$second = M('second s')->limit(10)
			->field('s.type,s.price,s.area,s.name')->select();
	
		$this->assign('second', $second);
		
		//租房
		$rent = M('renting')->field('price,type,area,name')
			->limit(6)->select();
		$this->assign('rent', $rent);
		
		$this->display();
	}
	
}