<?php
namespace Home\Controller;
use Think\Controller;
class AccountController extends Controller {
	
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
    				//验证码是否正确
    				$verify = new \Think\Verify();
    				if (!$verify->check($_POST['captcha'])) {
    					$this->error("验证码错误", U('Index/index'), 2);
    				} else {
    					session('username', I('post.username'));
    					session('uid', $uid);
    					$this->success('登录成功，请稍后',U('Index/index'));
    					return;
    				}
    			} else {
    				$this->error("密码错误,请重新登录", U("Account/login"));
    				return;
    			}
    		} else {
    			$this->error("用户名/邮箱不存在,请注册", U('Account/register'));
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
	         $data['phone']    = I('post.phone');
	         $data['tel']	   = I('post.tel');
	         $data['email']    = I('post.email');
	         $data['name']     = I('post.name'); 
	         $data['unit']     = I('post.unit');
	         $data['role']     = I('post.role');
			 $data['addr']     = I('post.addr');
	         $re = M('user')->add($data);
	         
         	 if($re) {
           		session('uid',$re);
           
           		session('username', I('post.username'));

           		$user = $_POST['username'];
          
          		$this->success("注册成功,请登录", U("Account/login"));
         	} else {
           	$this->error("注册失败",U("Account/register"));
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
    	$this->success('正在退出登录...', U('Index/index'), 2);
    }
    
    /**
     * 验证码
     */
	public function verifyImg() {
    	//以下类Verify在之前并没有include引入
    	//走自动加载Think.class.php autoload()
    	$config = array(
    			fontSize => 14,		// 验证码字体大小(px)
    			imageH   => 30, 	// 验证码图片高度
    			imageW   => 100,	// 验证码图片宽度
    			useCurve => false, 	// 是否画混淆曲线
    			useNoise => false, 	// 是否添加杂点
    			fontttf => '4.ttf', // 验证码字体，不设置随机获取
    			length => 4,		// 验证码位数
    	);
    	$verify = new \Think\Verify($config);
    
    	$verify->entry();
    }
    
    /**
     * 用户协议
     */
	public function useragreement() {
		$this->display();
	}
	
	public function getpassword() {
		
		//处理表单
		if (IS_POST) {
			$name = I('post.name'); //用户名
			$verify = new \Think\Verify();
			if (!$verify->check($_POST['captcha'])) {
				$this->error("验证码错误", U('Account/getpassword'), 2);
			} else {
				$user = M('user')->field('password')->where("username = '$name '")->find();
				$password = $user['password'];
				$this->assign('password', $password);
			}
		}
		$this->display();
	}
	
	public function resetpassword() {
		$this->display();	
	}
	
	
	
}