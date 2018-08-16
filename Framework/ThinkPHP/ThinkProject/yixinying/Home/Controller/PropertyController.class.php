<?php
namespace Home\Controller;

use Think\Controller;

class PropertyController extends Controller {

	function property() {
		$username = session('username');
		$uid = session('uid');
		$result = M('estate')->select();
		$count = count($result);
		$this->assign('count', $count);
		$this->assign('result', $result);
		$this->assign('username', $username);
		$this->display();
	}
	
	function propertydetail() {
		$id = I('get.id');
		if ($id) {
			//获取楼盘信息
			$result = M('estate')->where("id=$id")->find();
			$this->assign('result', $result);
		}

		$this->display();
	}
	
	function propertydetailalbums() {
		$this->display();
	}
	
	function propertydetailapartment() {
		$this->display();
	}
	
	function propertydetailinfo() {
		$this->display();
	}
	
	function propertydetaillisting() {
		$this->display();
	}
	
	function propertydetailmap() {
		$this->display();
	}
	
	function propertydetailprice() {
		$this->display();
	}
	
	function renting() {
		$username = session('username');
		$uid = session('uid');
		$result = M('renting')->limit(10)->select();
		$this->assign('username', $username);
		$this->assign('result', $result);
		$this->display();
	}
	
	function sellers() {
		$username = session('username');
		$uid = session('uid');
		$result = M('renting')->select();
		$count = count($result);
		$this->assign('count', $count);
		$this->assign('result', $result);
		$this->assign('username', $username);
		$this->display();
	}
	
	function buy() {
		$username = session('username');
		$uid = session('uid');
		$result = M('renting')->select();
		$count = count($result);
		$this->assign('count', $count);
		$this->assign('result', $result);
		$this->assign('username', $username);
		$this->display();
	}
	
	function secondhandhouse() {
		$username = session('username');
		$uid = session('uid');
		$this->assign('username', $username);
		$this->display();
	}
	
	//楼盘搜索控制器
	function searchs(){
		$id = $_GET['id'];
		switch ($id) {
			case '新区':
				$result = M('estate')->where('area="新区"')->select();break;
			case '惠山':
				$result = M('estate')->where('area="惠山"')->select();break;
			case '锡山':
				$result = M('estate')->where('area="锡山"')->select();break;
			case '北塘':
				$result = M('estate')->where('area="北塘"')->select();break;
			case '南长':
				$result = M('estate')->where('area="南长"')->select();break;
			case '崇安':
				$result = M('estate')->where('area="崇安"')->select();break;
			case '滨湖':
				$result = M('estate')->where('area="滨湖"')->select();break;
			case '宜兴':
				$result = M('estate')->where('area="宜兴"')->select();break;
			case 'area':
			case 'price':
			case 'huxing':
			case 'type':
				$result = M('estate')->select();
				break;
			case 1:
				$result = M('estate')->where('price<6000')->select();
				break;
			case 2:
				$result = M('estate')->where('price between 6000 and 7000')->select();
				break;
			case 3:
				$result = M('estate')->where('price between 8000 and 10000')->select();
				break;
			case 4:
				$result = M('estate')->where('price between 10000 and 12000')->select();
				break;
			case 5:
				$result = M('estate')->where('price > 12000')->select();
				break;
			case 11:
				$result = M('estate')->where("type='一室'")->select();
				break;
			case 12:
				$result = M('estate')->where("type='二室'")->select();break;
			case 13:
				$result = M('estate')->where("type='三室'")->select();break;
			case 14:
				$result = M('estate')->where("type='四室'")->select();break;
			case 15:
				$result = M('estate')->where("type='五室以上'")->select();break;
			case 21:
				$result = M('estate')->where("state='住宅'")->select();break;
			case 22:
				$result = M('estate')->where("state='别墅'")->select();break;
			case 23:
				$result = M('estate')->where("state='写字楼'")->select();break;
			case 24:
				$result = M('estate')->where("state='商铺'")->select(); break;
		}
		$this->ajaxReturn($result);
	}

	
	//租房搜索控制器
	function search() {
		$id = $_GET['id'];
		switch ($id) {
			case '新区':
				$result = M('renting')->where('area="新区"')->select();break;
			case '惠山':
				$result = M('renting')->where('area="惠山"')->select();break;
			case '锡山':
				$result = M('renting')->where('area="锡山"')->select();break;
			case '北塘':
				$result = M('renting')->where('area="北塘"')->select();break;
			case '南长':
				$result = M('renting')->where('area="南长"')->select();break;
			case '崇安':
				$result = M('renting')->where('area="崇安"')->select();break;
			case '滨湖':
				$result = M('renting')->where('area="滨湖"')->select();break;
			case '宜兴':
				$result = M('renting')->where('area="宜兴"')->select();break;
			case 'area':
			case 'price':
			case 'huxing':
			case 'type':
			case 41:
			case 51:
				$result = M('renting')->select();
				break;
			case 1:
				$result = M('renting')->where('price<1000')->select();
				break;
			case 2:
				$result = M('renting')->where('price between 1000 and 1500')->select();
				break;
			case 3:
				$result = M('renting')->where('price between 1500 and 2000')->select();
				break;
			case 4:
				$result = M('renting')->where('price between 2000 and 2500')->select();
				break;
			case 5:
				$result = M('renting')->where('price between 3000 and 4000')->select();
				break;
			case 6:
				$result = M('renting')->where('price > 4000')->select();break;
			case 11:
				$result = M('renting')->where('mianji < 50')->select();break;
			case 12:
				$result = M('renting')->where('mianji between 50 and 70')->select();break;
			case 13:
				$result = M('renting')->where('mianji between 70 and 90')->select();break;
			case 14:
				$result = M('renting')->where('mianji between 90 and 110')->select();break;
			case 15:
				$result = M('renting')->where('mianji between 110 and 130')->select();break;
			case 16:
				$result = M('renting')->where('mianji > 130')->select();break;
			case 21:
				$result = M('renting')->where("type='一室'")->select();
				break;
			case 22:
				$result = M('renting')->where("type='二室'")->select();break;
			case 23:
				$result = M('renting')->where("type='三室'")->select();break;
			case 24:
				$result = M('renting')->where("type='四室'")->select();break;
			case 25:
				$result = M('renting')->where("type='五室以上'")->select();break;
			case 31:
				$result = M('renting')->where("state='整套出租'")->select();break;
			case 32:
				$result = M('renting')->where("state='单间出租'")->select();break;
			case 33:
				$result = M('renting')->where("state='床位出租'")->select();break;
			case 42:$result = M('renting')->where("xiang='东'")->select();break;
			case 43:$result = M('renting')->where("xiang='南'")->select();break;
			case 44:$result = M('renting')->where("xiang='东南'")->select();break;
			case 45:$result = M('renting')->where("xiang='西南'")->select();break;
			case 52:$result = M('renting')->where("xiu='毛坯'")->select();break;
			case 53:$result = M('renting')->where("xiu='简单装修'")->select();break;
			case 54:$result = M('renting')->where("xiu='中等装修'")->select();break;
			case 55:$result = M('renting')->where("xiu='精装修'")->select();break;
			case 56:$result = M('renting')->where("xiu='豪华装修'")->select();break;
			
		}
		$this->ajaxReturn($result);
	}

}