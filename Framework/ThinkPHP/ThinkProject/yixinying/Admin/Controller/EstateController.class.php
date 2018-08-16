<?php
namespace Admin\Controller;
use Think\Controller;
class EstateController extends Controller {
	public function estate() {
		//获取用户列表
		$count = M('estate')->count();
		$Page = new \Think\Page($count, 10);
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show();
		$user = M('estate')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display('estate');
	}
	
	public function save() {
		if (IS_POST) {
			$data['area'] = I('post.area');
			$data['name'] = I('post.name');
			$data['owner'] = I('post.owner');
			$dat['state'] = I('post.state');
			$data['big'] = I('post.big');
			$data['price'] = I('post.price');
			$data['avg'] = 6000;
			$data['image'] = "Property02.jpg";
			$data['addr'] = I('post.addr');
			$data['phone'] = I('post.phone');
			
			$res = M('estate')->add($data);
	
			echo "<script language='javascript'> alert('添加成功');
			window.location.href='estate.html';</script>";
		}
		$this->display('user');
	}
	
	public function update() {
		$id = I('post.id');
		if (IS_POST) {
			$data['area'] = I('post.area');
			$data['name'] = I('post.name');
			$data['owner'] = I('post.owner');
			$data['big'] = I('post.big');
			$data['state'] = I('post.state');
			$data['price'] = I('post.price');
			$data['addr'] = I('post.addr');
			$data['phone'] = I('post.phone');
			
			$res = M('estate')->where("id=$id")->save($data);
			
			echo "<script language='javascript'> alert('修改成功');
			window.location.href='estate.html';</script>";
		}
	}
	
	public function edit() {
		$id = I('post.id');	
		$user = D('estate')->where("id=$id")->find();
		$this->ajaxReturn($user);
	}
	
	public function delete() {
		$id = I('post.id');
		$user = D('Estate')->where("id=$id")->delete();
		if($user){
			echo 1;
		}
	
	}
}