<?php
namespace Home\Controller;

use Think\Controller;

class UserInfoController extends Controller {
	
	function browsehistory() {
		$username = session('username');
		$uid = session('uid');
		$this->assign('username', $username);
		$this->display();
	}
	
	function modifypassword() {
		$username = session('username');
		$uid = session('uid');
		$where['username'] = $username;
		$res = D('User')->where($where)->find();
		
		//表单处理
		if (IS_POST) {
			$password = I('post.password');

			//验证用户输入的初始密码是否正确
			if ($res['password'] != $password) {
				echo "<script>alert('原始密码不正确');</script>";
			} else {
				$data['password'] = I('post.pwd1');
				$re = D('User')->where($where)->save($data);
			if($re){
				echo "<script language='javascript'> alert('更新成功！请重新登录');window.location.href='modifypassword.html';</script>";
			}else{
				echo "<script language='javascript'> alert('更新失败！')</script>";
			}
			}
		}
		$this->assign('username', $username);
		$this->display();
	}
	
	//修改个人资料
	function modifypersonalinfo() {
		//表单处理
		$username = session('username');
		$uid = session('uid');
		if (IS_POST) {
			$where['username'] = session('username');
	
			$data['nickname'] = I('post.nickname');
			$data['email']    = I('post.email');
			$data['phone']    = I('post.phone');
			$data['name']     = I('post.name');
			$data['tel']	   = I('post.tel');
			$data['unit']	   = I('post.unit');
			$data['addr']	   = I('post.addr');
			$re = D('User')->where($where)->save($data);
			if ($re) {
				echo "<script>alert('修改成功!');window.location.href='ModifyPersonalInfo.html';</script>";
			} else {
				echo "<script>alert('修改失败!');</script>";
			}
		} 
		
		$this->assign('username', $username);
		$this->display();
	}
	
	function myfavorite() {
		$username = session('username');
		$uid = session('uid');
		$this->assign('username', $username);
		$this->display();
	}
	
	function released() {
		$username = session('username');
		$uid = session('uid');
		//获取当前用户发布的信息
		$info = M('renting')->where("uid=$uid")->limit(10)->select();
		$this->assign('info', $info);
		$this->assign('username', $username);
		$this->display();
	}
	
	function releaseproperty() {
		$username = session('username');
		$uid = session('uid');
		$this->assign('username', $username);
		$this->display();
	}
	
	function releaserent() {
		$username = session('username');
		$uid = session('uid');
		//处理表单
		if (IS_POST) {
			$where['name'] = I('post.name');
			$where['full'] = I('post.full');
			$where['type'] = I('post.type');
			$where['image'] = I('post.image');
			$where['phone'] = I('post.phone');
			$where['addr'] = I('post.addr');
			$where['price'] = I('post.price');
			$where['area'] = I('post.area');
			$where['xiang'] = I('post.xiang');
			$where['xiu'] = I('post.xiu');
			$where['mianji'] = I('post.mianji');
			$where['uid'] = $uid;
			$where['style'] = 0;
			$re = M('renting')->add($where);
			
			if($re) {
				echo "<script>alert('发布成功');</script>";
			} else {
				echo "<script>alert('发布失败');</script>";
			}
			
		}
		$this->assign('username', $username);
		$this->display();
	}
	
	function releasesale() {
		$username = session('username');
		$uid = session('uid');
		//处理表单
		if (IS_POST) {
			$where['name'] = I('post.name');
			$where['full'] = I('post.full');
			$where['type'] = I('post.type');
			$where['image'] = I('post.image');
			$where['phone'] = I('post.phone');
			$where['addr'] = I('post.addr');
			$where['price'] = I('post.price');
			$where['area'] = I('post.area');
			$where['xiang'] = I('post.xiang');
			$where['xiu'] = I('post.xiu');
			$where['mianji'] = I('post.mianji');
			$where['uid'] = $uid;
			$where['style'] = 1;
			$re = M('renting')->add($where);
		
			if($re) {
				echo "<script>alert('发布成功');</script>";
			} else {
				echo "<script>alert('发布失败');</script>";
			}
			
		}
		$this->assign('username', $username);
		$this->display();
	}
	
	function subscription() {
		$username = session('username');
		$this->assign('username', $username);
		$this->display();
	}
}