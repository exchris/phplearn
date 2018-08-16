<?php
namespace Admin\Controller;
use Think\Controller;
class SecondController extends Controller {
	public function second() {
		//获取用户列表
		$count = M('second')->count();
		$Page = new \Think\Page($count, 10);
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show();
		$user = M('second')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display('second');
	}
	
	public function save() {
		if (IS_POST) {
			$data['name'] = I('post.name');
			$data['area'] = I('post.area');
			$data['price'] = I('post.price');
			$data['type'] = I('post.type');
			$data['mianji'] = I('post.mianji');
			$data['addr'] = I('post.addr');
			$data['from'] = I('post.from');
			$data['phone'] = I('post.phone');
			$data['mortgage'] = I('post.mortgage');
			$data['summary'] = I('post.summary');
			
			$res = M('second')->add($data);
	
			echo "<script language='javascript'> alert('添加成功');
			window.location.href='second.html';</script>";
		}
		$this->display('user');
	}
	
	public function update() {
		$id = I('post.id');
		if (IS_POST) {
			$data['name'] = I('post.name');
			$data['area'] = I('post.area');
			$data['price'] = I('post.price');
			$data['type'] = I('post.type');
			$data['mianji'] = I('post.mianji');
			$data['addr'] = I('post.addr');
			$data['from'] = I('post.from');
			$data['phone'] = I('post.phone');
			$data['mortgage'] = I('post.mortgage');
			$data['summary'] = I('post.summary');
			
			$res = M('second')->where("id=$id")->save($data);
			
			echo "<script language='javascript'> alert('修改成功');
			window.location.href='second.html';</script>";
		}
	}
	
	public function edit() {
		$id = I('post.id');	
		
		$user = D('second')->where("id=$id")->find();
		$this->ajaxReturn($user);
	}
	
	public function delete() {
		$id = I('post.id');
		$user = D('second')->where("id=$id")->delete();
		if($user){
			echo 1;
		}
	
	}
}