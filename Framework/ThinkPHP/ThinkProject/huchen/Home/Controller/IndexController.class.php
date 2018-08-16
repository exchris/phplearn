<?php
namespace Home\Controller;
use Think\Page;

use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	//登录页面
    	$this->display('login');
    }
    
    //学生登录后主页
    public function main() {
    	$this->display('index');
    }
    
    //学生个人信息
    public function info() {
    	$uid = session('uid');
    	$user = M('student')->where("sno=$uid")->find();
    	$this->assign('user', $user);
    	if (IS_POST) {
    		$data['email'] = I('post.email');
    		$data['phone'] = I('post.phone');
    		$data['qq'] = I('post.qq');
    		$data['signature'] = I('post.signature');
    		$result = M('student')->where("sno=$uid")->save($data);
    		if ($result) {
    			$this->success("修改成功");
    		} else {
    			$this->success("您未修改任何内容");
    		}
    	}
    	$this->display();
    }
    
    //学生修改密码
    public function pass() {
    	$uid = session("uid");
    	$user = M('student')->where("sno=$uid")->find();
    	$this->assign('user', $user);
    	if (IS_POST) {
    		$data['password'] = I('post.newpass');
    		$result = M('student')->where("sno=$uid")->save($data);
    		if ($result) {
    			$this->success("修改密码成功");
    		} else {
    			$this->error("修改密码失败,密码与原密码相同");
    		}
    	}
    	$this->display();
    }
    
    //留言表
    public function msglist() {
    	$uid = session('uid');
    	//查看当前学生发表了几条留言
    	$count = M('message')->count();
    	$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
    	$Page->setConfig('header', '共%TOTAL_ROW%条');
    	$Page->setConfig('first', '首页');
    	$Page->setConfig('last', '共%TOTAL_PAGE%页');
    	$Page->setConfig('prev', '上一页');
    	$Page->setConfig('next', '下一页');
    	$Page->setConfig('link', 'indexpagenumb');
    	$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
    	$show = $Page->show(); //分页显示输出
    	//查询当前学生发表了那些留言
    	//进行分页数据查询
    	//$Page->firstRow起始条数 $Page->listRows获取多少条
    	$list = M('message m')
    		->field('m.id,content,title,datetime')
    		->order("datetime desc")
    		->limit($Page->firstRow.','.$Page->listRows)->select();
 
    	$this->assign('list', $list); //赋值数据集
    	$this->assign('page', $show); //赋值分页输出
    	$this->display();
    }
    
    //提交留言
    public function add() {
    	$uid = session('uid');
    	if (IS_POST) {
    		$data['uid'] = $uid;
    		$data['datetime'] = date('Y-m-d H:i:s');
    		$data['parent'] = 0;
    		$data['title'] = I('post.title');
    		$data['content'] = I('post.content');
    		$result = M('message')->add($data);
    		if ($result) {
    			$this->success("留言成功",U('Index/msglist'));
    		} else {
    			$this->success("留言失败");
    		}
    	}
    	$this->display();
    }
    
    public function score() {
    	$uid = session('uid');
    	$Page = new \Think\Page(); //实例化分页类 传入总留言总数
    	$Page->setConfig('header', '共%TOTAL_ROW%条');
    	$Page->setConfig('first', '首页');
    	$Page->setConfig('last', '共%TOTAL_PAGE%页');
    	$Page->setConfig('prev', '上一页');
    	$Page->setConfig('next', '下一页');
    	$Page->setConfig('link', 'indexpagenumb');
    	$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
    	if (IS_POST) {
    		$name = I('post.name');
    		$from = I('post.from');
    		$to = I('post.to');
    		if ($name == '' && $from == '' && $to == '') {
    				$this->error("请输入内容", U('Index/score'), 2);
    		} elseif ($name) {
    			//搜索内容可以依据课程名称，教师，分数来查询
    			$count = M('score s')->join("inner join class c on c.cno=s.cno inner join teacher t on t.tno=c.tno")
    			->where("(cname like '%{$name}%') OR (truename like '%{$name}%')")->count();
    			$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
    			$score = M('score s')->join('inner join class c on c.cno=s.cno
    				inner join teacher t on t.tno=c.tno')
    			->field('c.cno,cname,credit,t.truename,term,`require`,score')
    			->where("s.sno=$uid AND ((cname like '%{$name}%') OR (truename like '%{$name}%'))")
    			->select();
    		} elseif ($from && $to == '') {
    			$count = M('score s')->where("sno=$uid AND score>=$from")->count();
    			$Page = new \Think\Page($count, 10);
    			$score = M('score s')->join('inner join class c on c.cno=s.cno
    					inner join teacher t on t.tno=c.tno')
    					->field('c.cno,cname,credit,t.truename,term,`require`,score')
    					->where("s.sno=$uid AND (score>=$from)")
    					->select();
    		} elseif ($to && $from == '') {
    			$count = M('score s')->where("sno=$uid AND score<=$to")->count();
    			$Page = new \Think\Page($count, 10);
    			$score = M('score s')->join('inner join class c on c.cno=s.cno
    					inner join teacher t on t.tno=c.tno')
    					->field('c.cno,cname,credit,t.truename,term,`require`,score')
    					->where("s.sno=$uid AND (score<=$to)")
    					->select();
    		} elseif ($from && $to) {
    			$count = M('score s')->where("sno=$uid AND score between $from AND $to")->count();
    			$Page = new \Think\Page($count, 10);
    			$score = M('score s')->join('inner join class c on c.cno=s.cno
    					inner join teacher t on t.tno=c.tno')
    					->field('c.cno,cname,credit,t.truename,term,`require`,score')
    					->where("s.sno=$uid AND (score between $from AND $to)")
    					->select();
    		} 
    		
    	} else {
    		$count = M('score')->where("sno=$uid")->count();
    		$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
    		$show = $Page->show(); //分页显示输出
    		$score = M('score s')->join('inner join class c on c.cno=s.cno
    			inner join teacher t on t.tno=c.tno')
    			->field('c.cno,cname,credit,t.truename,term,`require`,score')
    			->where("s.sno=$uid")
    			->select();
    	}
    	$this->assign('score', $score);
    	$this->assign('page', $show); //赋值分页输出
    	$this->display();
    }
    
    //验证码处理
    public function verifyImg() {
    	$config = array(
    		fontSize => 14, 	//验证码字体大小(px)
    		imageH   => 30, 	//验证码图片宽度
    		imageW   => 100,     //验证码图片宽度
    		useCurve => false,  //是否画混淆曲线
    		useNoise => false,	//是否添加杂点
    		fontttf  => '4.ttf',//验证码字体,不设置随机获取
    		length   => 4, 		//验证码位数
    	);
    	$verify = new \Think\Verify($config);
    	
    	$verify->entry();
    }
    
    //登录页面处理
    public function login() {
    	if (IS_POST) {
    		$username = I('post.name');			//账号或者姓名
    		$password = I('post.password'); //密码
    		$role = I('post.role');			//角色
    		switch ($role) {
    			case "学生":  //学生登录操作
    			//验证账号是否存在
    			$name = M()->query("select sno from student where sname='$username' limit 1");
    			if ($name) {
    				//验证密码
    				$member = M('student')->where("sname='$username' AND password='$password'")->find();
    				$sno = $member['sno'];
    				$sname = $member['sname']; //账号
    				$password = $member['password']; //密码
    					
    				if ($password == I('post.password')) {
    					//验证码是否正确
    					$verify = new \Think\Verify();
    					if (!$verify->check($_POST['code'])) {
    						$this->error("验证码错误", U('Index/index'), 2);
    					} else {
    						session('username', I('post.name'));
    						session('uid', $sno);
    						$this->success("登录成功",U('Index/main'));
    						return;
    					}
    				} else {
    					$this->error("密码错误,重新登录!",U("Index/index"));
    					return;
    				}
    			} else {
    				$this->error("该学生账户不存在,请注册",U('Index/register'));
    				return;
    			}
    			break;
    			case "教师":  //教师登录操作
    			//验证账号是否存在
    			$name = M()->query("select tno from teacher where tname='$username' limit 1");
    			if ($name) {
    				//验证密码
    				$member = M('teacher')->where("tname='$username' AND password='$password'")->find();
    				$uid = $member['tno'];
    				$tname = $member['tname']; //账号
    				$password = $member['password']; //密码
    						
    				if ($password == I('post.password')) {
    					//验证码是否正确
    					$verify = new \Think\Verify();
    					if (!$verify->check($_POST['code'])) {
    						$this->error("验证码错误", U('Index/index'), 2);
    					} else {
    						session('username', I('post.name'));
    						session('uid', $uid);
    						$this->success("登录成功",U('Teacher/index'));
    						return;
    					}
    				} else {
    					$this->error("密码错误,重新登录!",U("Index/index"));
    					return;
    				}
    			} else {
    				$this->error("该教师不存在,请注册",U('Index/register'));
    				return;
    			}
    			break;
    			default:     //管理员登录操作
    			//验证账号是否存在
    			$name = M()->query("select uid from admin where username='$username' limit 1");
    			if ($name) {
    				//验证密码
    				$member = D('admin')->where("username='{$username}' AND password='$password'")->find();
    					
    				$uid = $member['uid'];
    				$username = $member['username']; //账号
    				$password = $member['password']; //密码
    						
    				if ($password == I('post.password')) {
    					//验证码是否正确
    					$verify = new \Think\Verify();
    					if (!$verify->check($_POST['code'])) {
    						$this->error("验证码错误", U('Index/index'), 2);
    					} else {
    						session('username', I('post.name'));
    						session('uid', $uid);
    						$this->success("登录成功",U('Admin/index'));
    						return;
    					}
    				} else {
    					$this->error("密码错误,重新登录!",U("Index/index"));
    					return;
    				}
    			} else {
    				$this->error("管理员不存在,请注册",U('Index/register'));
    				return;
    			}
    			break;
    		}
    	}
    	$this->display();
    }
	
    //判断用户名是否存在
    public function checkUser() {
    	if (IS_POST) {
    		$name = I('post.name');
    		$role = I('post.role');
    		//由于技术的缺陷,必须选择角色后才能判断(因为管理员、教师和学生不在同一个表中)
    		switch ($role) {
    			case "学生":
    				$member = M('student')->field("sno")->where("sname='$name'")->find();
    				break;
    			case "教师":
    				$member = M('teacher')->field("tno")->where("tname='$name'")->find();
    				break;
    			default:
    				$member = M('admin')->field("uid")->where("username='$name'")->find();
    				break;
    		}
    		if ($member) {
    			$this->ajaxReturn(1);
    		} else {
    			$this->ajaxReturn(0);
    		}
    	}
    }
    
//     //判断验证码是否正确
//     public function checkLogin() {
//     	$verify = new \Think\Verify();
//     	//验证码是否正确
//     	if (!$verify->check($_POST['code'])) {
//     		$this->ajaxReturn(0);
//     	} else {
//     		$this->ajaxReturn(1);
//     	}
//     }
    
    
	//注册页面处理
	public function register() {
		
		if (IS_POST) {
			$role = I('post.role');
			switch ($role) {
				case "学生":  //学生注册
					$data['sname'] = I('post.name');
					$data['truename'] = I('post.nickname');
					$data['password'] = I('post.password');
					$province = I('post.s_province');
					$city = I('post.s_city');
					$county = I('post.s_county');
					$data['saddr'] = $province." ".$city." ".$county;
					$data['ssex'] = I('post.sex');
					$data['birthday'] = I('post.birthday');
					$data['regdate'] = I('post.entrytime');
					$data['depart'] = I('post.depart');
					$data['major'] = I('post.major');
					$data['state'] = 1;
					$re = M('student')->add($data);
					if ($re) {
						session('uid', $re);
						session('username', I('post.name'));
						$this->success("注册成功,登录",U("Index/index"));
					} else {
						$this->error("注册失败", U("Index/regiseter"));
					}
					break;
				case "教师": //教师注册
					$data['tname'] = I('post.name');
					$data['truename'] = I('post.nickname');
					$data['password'] = I('post.password');
					$province = I('post.s_province');
					$city = I('post.s_city');
					$county = I('post.s_county');
					$data['taddr'] = $province." ".$city." ".$county;
					$data['tsex'] = I('post.sex');
					$data['birthday'] = I('post.birthday');
					$data['entrytime'] = I('post.entrytime');
					$data['depart'] = I('post.depart');
					$re = M('teacher')->add($data);
					if ($re) {
						session('uid', $re);
						session('username', I('post.name'));
						$this->success("注册成功,登录",U("Teacher/index"));
					} else {
						$this->error("注册失败", U("Index/regiseter"));
					}
					break;
				default:    //管理员注册
					$data['username'] = I('post.name');
					$data['password'] = I('post.password');
					$re = M('admin')->add($data);
					
					if ($re) {
						session('uid', $re);
						session('username', I('post.name'));
						$this->success("注册成功,登录",U("Admin/Index/index"));
					} else {
						$this->error("注册失败", U("Index/regiseter"));
					}
					break;
			}
		}
		$this->display();
	}
}