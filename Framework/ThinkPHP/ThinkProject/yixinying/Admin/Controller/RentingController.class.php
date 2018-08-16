<?php
namespace Admin\Controller;
use Think\Controller;
class RentingController extends Controller {
	public function renting() {
		//获取用户列表
		$count = M('renting')->count();
		$Page = new \Think\Page($count, 10);
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show();
		$user = M('renting')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display('renting');
	}
	
	public function save() {
		if (IS_POST) {
			$data['name'] = I('post.name');
			$data['price'] = I('post.price');
			$data['type'] = I('post.type');
			$data['area'] = I('post.area');
			$data['addr'] = I('post.addr');
			$data['mianji'] = I('post.mianji');
			$data['full'] = I('post.full');
			$data['xiu'] = I('post.xiu');
			$data['xiang'] = I('post.xiang');
			$data['state'] = I('post.state'); 
			
			$res = M('renting')->add($data);
			
			echo "<script language='javascript'> alert('添加成功');
			window.location.href='renting.html';</script>";
		}
		$this->display('user');
	}
	
	public function update() {
		$id = I('post.id');
		
		if (IS_POST) {
			$data['name'] = I('post.name');
			$data['price'] = I('post.price');
			$data['type'] = I('post.type');
			$data['area'] = I('post.area');
			$data['addr'] = I('post.addr');
			$data['mianji'] = I('post.mianji');
			$data['full'] = I('post.full');
			$data['xiu'] = I('post.xiu');
			$data['xiang'] = I('post.xiang');
			$data['state'] = I('post.state'); 
			
			$res = M('renting')->where("id=$id")->save($data);
			
			echo "<script language='javascript'> alert('修改成功');
			window.location.href='renting.html';</script>";
		}
	}
	
	public function edit() {
		$id = I('post.id');	
		$user = D('renting')->where("id=$id")->find();
		$this->ajaxReturn($user);
	}
	
	public function delete() {
		$id = I('post.id');
		$user = D('renting')->where("id=$id")->delete();
		if($user){
			echo 1;
		}
	
	}
}