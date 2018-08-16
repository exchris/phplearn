<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
	//登陆界面
    public function login() {
    	//处理表单
    	if (IS_POST) {
    	
    		$username = I('post.username');
    		$password = I('post.password');
    		//首先验证用户名/邮箱是否存在
    		$name = M()->query("select uid from user where username='$username' limit 1");
    		
    		if ($name) {
    			// 验证密码
    			$member = M()->query("select * from user where
    					username = '$username' and password='$password' limit 1");
    		
    			$uid = $member[0]['uid'];
    			$username = $member[0]['username'];
    			$password = $member[0]['password'];
    			
    		
    			if ($password == I('post.password')) {
    				session('username', I('post.username'));
    				session('uid', $uid);
    				$this->success('登录成功，请稍后',U('Index/main'));
    				return;
    			} else {
    				$this->error("密码错误,请重新登录", U("Index/index"));
    				return;
    			}
    		} else {
    			$this->error("用户名/邮箱不存在,请注册", U('User/register'));
    			return;
    		}
    	}
    	$this->display();
    }  
    
    /**
     * 
     * 注册新用户
     */
    
    public function register() {
    	//处理表单数据
    	if(IS_POST) {
	        $da['username'] = I('post.username');
	        $member = M('user')->where($da)->find();
	        
	        if($member) {
	          $this->error("用户名已经存在！");
	          return;
	        } 

	         $data['username'] = I('post.username');
	         $data['password'] = I('post.password');
	         $data['role']     = '管理员';
	         $re = M('user')->add($data);
	         
         	 if($re) {
           		session('uid',$re);
           
           		session('username', I('post.username'));

           		$user = $_POST['username'];
          
          		$this->success("注册成功,请登录", U("User/login"));
         	} else {
           	$this->error("注册失败",U("User/register"));
         }
       } 
       $this->display();
    }
    
    public function find() {
    	//处理表单数据
    	if(IS_POST) {
    		$da['username'] = I('post.username');
    		$member = M('user')->where($da)->find();
    		$uid = $member['uid'];
    		if($member) {
    			$data['username'] = I('post.username');
    			$data['password'] = I('post.password');
    			$re = M('user')->where("uid=$uid")->save($data);
    		}
    	
    		if($re) {
    			session('uid',$re);
    			 
    			session('username', I('post.username'));
    	
    			$user = $_POST['username'];
    	
    			$this->success("请您用新密码登录", U("User/login"));
    		} 
    	}
    	$this->display();
    }
    
    /**
     * 用户注销
     */
    public function logout() {
    	//清除所有session
    	session(null);
    	$this->success('正在退出登录...', U('User/login'), 2);
    }
	
	public function delete() {
		$id = I('post.id');
		$user = D('user')->where("uid=$id")->delete();
		if($user){
			echo 1;
		}
		
	}
	
	public function add() {
		if (IS_POST) {
			$data['username'] = I('post.username');
			$data['password'] = I('post.pwd');
			$data['name'] = I('post.name');
			$data['sex'] = I('post.sex');
			$data['email'] = I('post.email');
			$res = M('user')->add($data);
			
			echo "<script language='javascript'> alert('添加成功');
				window.location.href='user.html';</script>";
		}
		$this->display('user');
	}
	
	public function edit() {
		$id = I('post.id');	
		$user = D('user')->where("uid=$id")->find();
		$this->ajaxReturn($user);
	}
	
	public function save() {
		$id = I('post.id');
		if (IS_POST) {
			$data['username'] = I('post.username');
			$data['password'] = I('post.pwd');
			$data['name'] = I('post.name');
			$data['sex'] = I('post.sex');
			$data['email'] = I('post.email');
			$res = M('user')->where("uid=$id")->save($data);
			
			echo "<script language='javascript'> alert('修改成功');
				window.location.href='user.html';</script>";
		}
		$this->display('user');
	}
	
	public function user() {
		//获取用户列表
		$count = M('user')->where("role<>'管理员'")->count(); 
		$Page = new \Think\Page($count, 10);
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show();
		$user = M('user')->where("role<>'管理员'")->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display('user');
	}
}