<?php
namespace Home\Controller;
use Think\Controller;
class TeacherController extends Controller {
    public function index(){
    	//登录页面
    	$this->display('index');
    }

    //个人信息操作
    public function info() {
    	$uid = session('uid');
    	$user = M('teacher')->where("tno=$uid")->find();
    	$this->assign('user', $user);
    	
    	if (IS_POST) {
    		$data['email'] = I('post.email');
    		$data['phone'] = I('post.phone');
    		$data['qq'] = I('post.qq');
    		$data['signature'] = I('post.signature');
    		$result = M('teacher')->where("tno=$uid")->save($data);
  
    		if ($result) {
    			$this->success("修改成功");
    		} else {
    			$this->success("您未修改任何内容");
    		}
    	}
    	$this->display();
    }

	//教师密码修改
	public function pass() {
		$uid = session("uid");
		$user = M('teacher')->where("tno=$uid")->find();
		$this->assign('user', $user);
		
		if (IS_POST) {
			$data['password'] = I('post.newpass');
			$result = M('teacher')->where("tno=$uid")->save($data);
			if ($result) {
				$this->success("修改密码成功");
			} else {
				$this->error("修改密码失败,密码与原密码相同");
			}
		}
		$this->display();
	}
	
	//学生成绩查询
	public function score() {
		if (IS_POST) {
			$name = I('post.search');
			$count = M('score s')->field('s.sno,c.cno,score,truename,ssex,saddr,cname,credit,term')
				->join('inner join class c on c.cno=s.cno inner join student t on t.sno=s.sno')
				->where(("(s.sno like '%$name%') OR (truename like '%$name%')"))
				->count();
			
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
				->where(("(s.sno like '%$name%') OR (truename like '%$name%')"))
				->order('score desc')
				->limit($Page->firstRow.','.$Page->listRows)->select();
			
			$this->assign('user', $user);
			$this->assign('page', $show);
			$this->display();
			
		} else {
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
				->order('score desc')
				->limit($Page->firstRow.','.$Page->listRows)->select();
			
			$this->assign('user', $user);
			$this->assign('page', $show);
			$this->display();
		}

	}
	
	//留言列表
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

	//教师查询功能
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
	
	//删除留言操作
	public function delMsg() {
		if (IS_GET) {
			$id = I('get.id');
			$res = M('message')->where("id=$id")->delete();
			if ($res) {
				$this->success("删除成功",U('Teacher/msglist'), 2);
			} else {
				$this->error("删除失败",U('Teacher/msglist'), 2);
			}
		}
	}
	
	//教师留言或回复
	public function addMsg() {
		$uid = session('uid');
		
    	if (IS_POST) {
    		$data['uid'] = $uid;
    		$data['datetime'] = date('Y-m-d H:i:s');
    		$data['parent'] = 0;
    		$data['title'] = I('post.title');
    		$data['content'] = I('post.content');
    		$result = M('message')->add($data);
    		if ($result) {
    			$this->success("留言成功",U('Teacher/msglist'));
    		} else {
    			$this->success("留言失败");
    		}
    	}
    	$this->display();
	}
	
	//教师留言修改
	public function editMsg() {
		$uid = session('uid');
		$id = I('get.id');
		
    	if (IS_POST) {
    		$ids = I('post.id');
    		$data['title'] = I('post.title');
    		$data['content'] = I('post.content');
    		$result = M('message')->where("id=$ids")->save($data);
    		
    		if ($result) {
    			$this->success("修改成功",U('Teacher/msglist'));
    		} else {
    			$this->success("留言失败");
    		}
    	} else {
    		$result = M('message')->where("id=$id")->find();
    		$this->assign('result', $result);
    		$this->display();
    	}	
	}
	
	//教师录入成绩,教师只能为所教学生添加成绩
	public function addScore() {
		$uid = session('uid');
		$isAdmin = M('admin')->where("uid=$uid")->find(); 
		// 管理员操作
		if ($isAdmin) {
			$info = M('class')->field('cno,cname')->select();
		} else {
			//教师操作
			// 查询该教师教了那几门课程
			$info = M('class')->field('cno,cname')->where("tno=$uid")->select();
		}
		
		$this->assign('info', $info);
		
		if (IS_POST) {
			$data['sno'] = I('post.sno');
			$sno = I('post.sno');
			$student = M('student')->where("sno=$sno")->find();
			if ($student) {
				$cno = I('post.cno');
				$data['cno'] = I('post.cno');
				$data['score'] = I('post.score');
				$class = M('score')->where("sno=$sno AND cno=$cno")->find();
				if ($class) {
					$this->error("该学生成绩已存在");
				} else {
					$result = M('score')->add($data);
					$this->success("添加成功",U('Teacher/score'));
				}
			} else {
				$this->error("该学号不存在");
			}
		}
		$this->display();
	}
	
	/**成绩修改**/
	function editScore() {
		$uid = session('uid');
		$isAdmin = M('admin')->where("uid=$uid")->find();
		$admin = $isAdmin['uid'];
		if (IS_GET) {
			$sno = I('get.sno');
			$cno = I('get.cno');
			//查询成绩
			$score = M('score')->field('score,cno,sno')->where("sno=$sno AND cno=$cno")->find();
			$this->assign('score', $score);
// 			$this->display();
		}
		if (IS_POST) {
			$sno = I('post.sno');
			$cno = I('post.cno');
			$data['score'] = I('post.score');
			$teacher = M('class')->where("cno=$cno AND tno=$uid")->find();
			if ($teacher) {
				$result = M('score')->where("sno=$sno AND cno=$cno")->save($data);
				if ($result) {
					$this->success("修改成功",U('Teacher/score'));
				}
			} elseif ($isAdmin) { //管理员
				$result = M('score')->where("sno=$sno AND cno=$cno")->save($data);
				if ($result) {
					$this->success("修改成功",U('Teacher/score'));
				}
			} else {	
				$this->error("对不起,您只能修改您所教的课程",U('Teacher/score'));
			}
		}
		$this->display();
	}
	
}