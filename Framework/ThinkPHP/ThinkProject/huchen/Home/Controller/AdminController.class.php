<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function index(){
    	//登录页面
    	$this->display('index');
    }

	//管理员密码修改
	public function pass() {
		$uid = session("uid");
		$user = M('admin')->where("uid=$uid")->find();
		$this->assign('user', $user);
		
		if (IS_POST) {
			$data['password'] = I('post.newpass');
			$result = M('admin')->where("uid=$uid")->save($data);
		
			if ($result) {
				$this->success("修改密码成功", U('Admin/pass'));
			} else {
				$this->error("修改密码失败,密码与原密码相同");
			}
		}
		$this->display();
	}
	
	//教师管理
	public function teacher() {
		$count = M('teacher')->count();
		$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show(); //分页显示输出
		$user = M('teacher')->order('timestamp desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display();
	}
	
	//教师管理之添加教师
	public function addTeacher() {
		if (IS_POST) {
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
				$this->success("添加成功",U("Admin/teacher"));
			} else {
				$this->error("注册失败", U("Admin/addStudent"));
			}
		}
		$this->display();
	}
	
	//教师管理之修改教师信息
	public function editTeacher() {
		if (IS_GET) {
			$uid = I('get.id');
			//获取学生信息
			$user = M('teacher')->where("tno=$uid")->find();
		
			$this->assign('user', $user);
		}
		
		if (IS_POST) {
			$tno = I('post.tno');
			$data['truename'] = I('post.nickname');
			$data['password'] = I('post.password');
			$province = I('post.s_province');
			$city = I('post.s_city');
			$county = I('post.s_county');
			$data['taddr'] = $province." ".$city." ".$county;
			$data['tsex'] = I('post.sex');
			$data['depart'] = I('post.depart');
			$result = M('teacher')->where("tno=$tno")->save($data);
			if ($result) {
				$this->success("修改成功",U('Admin/teacher'),2);
			} else {
				$this->error("修改失败",U('Admin/teacher'),2);
			}
		}
		$this->display();
	}
	
	//教师管理之删除教师
	public function delTeacher() {
		if (IS_GET) {
			$uid = I('get.id');
			$result = M('teacher')->where("tno=$uid")->delete();
			if ($result) {
				$this->success("删除成功", U('Admin/teacher'), 2);
			} else {
				$this->success("删除失败", U('Admin/teacher'), 2);
			}
		}
	}
	
	//学生管理
	public function student() {
		$uid = session('uid');

		$count = M('student')->count();
		$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show(); //分页显示输出
		$user = M('student')->order('regdate desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display();
	}
	
	//学生管理之成绩
	public function score() {
		$uid = session('uid');

		$count = M('score')->count();
		$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show(); //分页显示输出
		$user = M('score s')->field('s.sno,c.cno,score,truename,ssex,saddr,cname,credit,term')
			->join('inner join class c on c.cno=s.cno inner join student t on t.sno=s.sno')
			->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display();
	}
	
	//留言管理
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
    		->field('m.id,content,uid,title,datetime')
    		->order("datetime desc")
    		->limit($Page->firstRow.','.$Page->listRows)->select();

    	$this->assign('list', $list); //赋值数据集
    	$this->assign('page', $show); //赋值分页输出
    	$this->display();
	}

	public function search() {
		if (IS_POST) {
			$name = I('post.name');
			$count = M('teacher')->where("(tno like '%$name%') OR (truename like '%$name%')")->count();
			
			$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
			$Page->setConfig('header', '共%TOTAL_ROW%条');
			$Page->setConfig('first', '首页');
			$Page->setConfig('last', '共%TOTAL_PAGE%页');
			$Page->setConfig('prev', '上一页');
			$Page->setConfig('next', '下一页');
			$Page->setConfig('link', 'indexpagenumb');
			$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
			$show = $Page->show(); //分页显示输出
			$user = M('teacher')->where("(tno like '%$name%') OR (truename like '%$name%')")->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('user', $user);
			$this->assign('page', $show);
			$this->display();
		} else {
			$count = M('teacher')->count();
			$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
			$Page->setConfig('header', '共%TOTAL_ROW%条');
			$Page->setConfig('first', '首页');
			$Page->setConfig('last', '共%TOTAL_PAGE%页');
			$Page->setConfig('prev', '上一页');
			$Page->setConfig('next', '下一页');
			$Page->setConfig('link', 'indexpagenumb');
			$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
			$show = $Page->show(); //分页显示输出
			$user = M('teacher')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('user', $user);
			$this->assign('page', $show);
			$this->display();
		}
	}
	
	//添加学生
	public function addStudent() {
		if (IS_POST) {
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
				$this->success("添加成功",U("Admin/student"));
			} else {
				$this->error("注册失败", U("Admin/addStudent"));
			}
		}
		$this->display();
	}
	
	//判断用户名是否存在
	public function checkUser() {
		if (IS_POST) {
			$name = I('post.name');

			$member = M('student')->field("sno")->where("sname='$name'")->find();

			if ($member) {
				$this->ajaxReturn(1);
			} else {
				$this->ajaxReturn(0);
			}
		}
	}
	
	//修改学生操作
	public function editStudent() {
		if (IS_GET) {
			$uid = I('get.id');
			//获取学生信息
			$user = M('student')->where("sno=$uid")->find();
		
			$this->assign('user', $user);
		}
		
		if (IS_POST) {
			$sno = I('post.sno');
			$data['truename'] = I('post.nickname');
			$data['password'] = I('post.password');
			$province = I('post.s_province');
			$city = I('post.s_city');
			$county = I('post.s_county');
			$data['saddr'] = $province." ".$city." ".$county;
			$data['ssex'] = I('post.sex');
			$data['depart'] = I('post.depart');
			$data['major'] = I('post.major');
			$result = M('student')->where("sno=$sno")->save($data);
			if ($result) {
				$this->success("修改成功",U('Admin/student'),2);
			} else {
				$this->error("修改失败",U('Admin/student'),2);
			}
		}
		$this->display();
	}

	//删除学生操作
	public function delStudent() {
		if (IS_GET) {
			$uid = I('get.id');
			$result = M('student')->where("sno=$uid")->delete();
			if ($result) {
				$this->success("删除成功", U('Admin/student'), 2);
			} else {
				$this->success("删除失败", U('Admin/student'), 2);
			}
		}
	}

	//课程列表
	public function classes() {
		$count = M('class')->count();
		
		$Page = new \Think\Page($count, 10); //实例化分页类 传入总留言总数
		$Page->setConfig('header', '共%TOTAL_ROW%条');
		$Page->setConfig('first', '首页');
		$Page->setConfig('last', '共%TOTAL_PAGE%页');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('link', 'indexpagenumb');
		$Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$show = $Page->show(); //分页显示输出
		$user = M('class c')->join('inner join teacher t on t.tno=c.tno')
			->field('cno,cname,credit,truename,term,require')
		->order('cno desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->display('class');
	}
	
	//添加课程
	public function addClass() {
		if (IS_POST) {
			$data['cname'] = I('post.cname');
			$data['credit'] = I('post.credit');
			$data['require'] = I('post.require');
			$data['tno'] = I('post.tno');
			$tno = I('post.tno');
			$data['term'] = I('post.term');
			
			// 判断tno是否存在
			$teacher = M('teacher')->where("tno=$tno")->find();
			if ($teacher) {
				$result = M('class')->add($data);
				if ($result) {
					$this->success("添加课程成功",U('Admin/classes'),1);
				}
			} else {
				$this->error("职工号不存在");
			}
		}
		$this->display();
	}
	
	//修改课程
	public function editClass() {
		if (IS_GET) {
			$uid = I('get.cno');
			//获取课程信息
			$user = M('class')->where("cno=$uid")->find();
		
			$this->assign('user', $user);
		}
		
		if (IS_POST) {
			$cno = I('post.cno');
			$data['cname'] = I('post.cname');
			$data['credit'] = I('post.credit');
			$data['term'] = I('post.term');
			$data['tno'] = I('post.tno');
			$data['require'] = I('post.require');
			$result = M('class')->where("cno=$cno")->save($data);
			if ($result) {
				$this->success("修改成功",U('Admin/classes'),2);
			} else {
				$this->error("修改失败",U('Admin/classes'),2);
			}
		}
		$this->display();
	}
	
	//删除学生操作
	public function delClass() {
		if (IS_GET) {
			$uid = I('get.cno');
			$result = M('class')->where("cno=$uid")->delete();
			if ($result) {
				$this->success("删除成功", U('Admin/classes'), 2);
			} else {
				$this->success("删除失败", U('Admin/classes'), 2);
			}
		}
	}
}