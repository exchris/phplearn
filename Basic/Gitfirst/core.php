<?php
	/** 写一个能创建多级目录的PHP函数(新浪网技术部)*/
	
	/**
	 * 创建多级目录
	 * @param $path string 要创建的目录
	 * @param $mode int 创建目录的模式,在windows下可忽略
	 */
	function create_dir($path, $mode = '0777')
	{
		# 如果目录已经存在,则不创建
		if (is_dir($path)) {
			echo "该目录已经存在!";
		} else {
			# 不存在,创建
			if (mkdir($path, $mode, true)) {
				echo "创建目录成功!";
			} else {
				echo "创建目录失败!";
			}
		}
	}
	
	# 写一段PHP代码,确保多个进程同时写入同一个文件成功(腾讯)
	# 核心思路:加锁
	function writeProcessor() {
		$fp = fopen("lock.txt", "w+");
		if (flock($fp, LOCK_EX)) {
			# 获得写锁,写数据
			fwrite($fp, "write something");
			# 解除锁定
			flock($fp, LOCK_UN);
		} else {
			echo "file is locking...";
		}
		fclose($fp);
	}
	
	# 写一个函数,尽可能高效的,从一个标准url里取出文件的扩展名
	# http://www.sina.com.cn/abc/de/fg.php?id=1需要取出php或.php(新浪)
	
	/**
	 * 方案一
	 */
	function getExt1($url) {
		$arr = parse_url($url);
		//Array([scheme]=>http [host]=>www.sina.com.cn [path]=>
		// /abc/de/fg.php [query]=>id=1)
		$file = basename($arr['path']);
		$ext = explode('.', $file);
		return $ext[count($ext) - 1];
	}
	//方案二
	function getExt2($url) {
		$url = basename($url);
		$pos1 = strpos($url,'.');
		$pos2 = strpost($url,'?');
		if (strstr($url, '?')) {
			return substr($url, $pos1+1, $pos2-$pos1-1);
		} else {
			return substr($url, $pos1);
		}
	}
	$path = "http://www.sina.com.cn/abc/de/fg.php?id=1";
    echo getExt1($path);
    echo "<br />";
    echo getExt2($path);

	# 写一个函数,能够遍历一个文件夹下的所有文件和子文件夹(新浪)
	function my_scandir($dir) {
		$files = array();
		if (is_dir($dir)) {
			if ($handle = opendir($dir)) {
				while(($file = readdir($handle)) !== false) {
					if ($file != "." && $file != "..") {
						if (is_dir($dir."/". $file)) {
							$files[$file] = my_scandir($dir."/".$file);
						} else {
							$files[] = $dir."/".$file;
						}
					}
				}
				closedir($handle);
				return $files;
			}
		}
	}
	
	# 简述论坛中无限分类的实现原理(新浪)
	# 创建类别表如下:
	# sql文件
	/**
	 * CREATE TABLE category(
	 * 	cat_id smallint unsigned not null auto_increment primary key comment '类别ID',
	 *  cat_name VARCHAR(30) NOT NULL DEFAULT '' COMMENT '类别名称',
	 *  parent_id SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '类别父ID'
	 *  )ENGINE=MyIsam charset=utf8;
	 */
	# 编写一个函数,递归遍历,实现无限分类
	function tree($arr, $pid=0, $level=0) {
		static $list = array();
		foreach ($arr as $v) {
			#如果是顶级分类,则将其存到$list中,并以此节点为根节点,遍历其子节点
			if ($v['parent_id'] == $pid) {
				$v['level'] = $level;
				$list[] = $v;
				tree($arr, $v['cat_id'], $level+1);
			}
		}
		return $list;
	}
	
	# 写一个函数,算出两个文件的相对路径,如$a='/a/b/c/d/e.php';$b='/a/b/12/34/c.php';
	# 计算出$a相对于$b的相对路径应该是../../c/d
	function releative_path($path1, $path2) {
		$arr1 = explode("/", dirname($path1);
		$arr2 = explode("/", dirname($path2);
		for ($i=0,$len=count($arr2); $i<$len; $i++) {
			if($arr1[$i] != $arr2[$i]){
				break;
			}
		}
		
		//不在同一个根目录下
		if ($i == 1) {
			$return_path = array();
		} 
		// 在同一个根目录下
		if ($i !=1 && $i < $len) {
			$return_path = array_fill(0, $len-$i, '..');
		}
		//在同一个目录下
		if ($i == $len) {
			$return_path = array("./");
		}
		$return_path = array_merge($return_path,array_slice($arr1,$i));
		return implode('/', $return_path);
	}
	$a = '/a/b/c/d/e.php';
	$b = '/a/b/12/34/c.php';
	$c = '/e/b/c/d/f.php';
	$d = '/a/b/c/d/g.php';
	
	echo releative_path($a,$b);//结果是../../c/d
	echo "<br />";
	echo releative_path($a,$c);//结果是a/b/c/d
	echo "<br />";
	echo releative_path($a,$d);//结果是./
	echo "<br />";
	
	//有一个网页地址,比如php开发资源网主页:http://www.phpres.com/index.html,如何得到它的内容?
	$readcontents = fopen("http://www.phpres.com/index.html", "rb");
	$contents = stream_get_contents($readcontents);
	fclose($readcontents);
	echo $contents;
	
	#方法2:
	echo file_get_contents("http://www.phpres.com/index.html");
	
	# php如何实现页面跳转
	
	  # 方法一:php函数跳转,缺点,header头之前不能有输出,跳转后的程序继续执行,可用exit中断执行后面的程序
	    header("Location:网址"); //直接跳转
	    header("refresh:3;url=http://axgle.za.net"); //三秒后跳转
	  
	  #方法二:利用meta
	    echo "<meta http-equiv=refresh content='0;url=网址'>";
	    	
	#写出一个正则表达式,过滤网页上的所有JS/VBS脚本(即把script标记及其内容都去掉)
	# 过滤javascript脚本参看:
	header("content-type:text/html;charset=utf-8");
	$script = "以下内容不显示:<script type='text/javascript'>alert('cc');</script>";
	$pattern = '/<script[^>]*?>.*?</script>/si';
	echo preg_replace($pattern,"脚本内容",$script); //以下内容不显示:脚本内容
	
	# 方法一, 使用php內建函数strip_tags()除去HTML标签
	# 方法二,自定义函数
	  header("content-type:text/html;charset=utf-8");
	  function strip_html_tags($str){
	  	$pattern = '</("[^"]*"|\'[^\']\*\'|[^>"\'])*>/';
	  	return preg_replace($pattern, '', $str);
	  }
	  // 实例
      $html = '<p id="">ddddd<br /></p>';
      echo strip_html_tags($html);
      echo "<br />";

      $html = '<p id=">">bb<br />aaa<br /></p>';
      echo strip_html_tags($html);
      
      #验证电子邮件邮件的格式是否正确
      preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+/',　$email);
      
      #把一个日期从MM/DD/YYYY的格式转为DD/MM/YYYY的格式
      $date = '08/26/2003';
      print ereg_replace("([0-9]+)/([0-9]+)/([0-9]+)",\2/\1/\3, $date);
      
      #php中如何判断一个字符串是否是合法的日期模式:2007-03-13 13:13:13.要求代码不超过5行
      function checkDateTime($data){
	      if (date('Y-m-d H:i:s', strtotime($data)) == $data){
		      return true;
		  } else {
		  	  return false;
		  }
      }
      $data = '2015-06-20 13:35:42';
      var_dump(checkDateTime($data));//bool(true)

      $data = '2015-06-36 13:35:42';
      var_dump(checkDateTime($data));//bool(false)
	
	#编写函数取得上一个月的最后一天
	date_default_timezone_set('PRC');
	/**
	 * 获取给定月份的上一个最后一天
	 * @param $date string 给定日期
	 * @return string 上一月最后一天
	 */
	function get_last_month_last_day($date = ''){
		if($date != ''){
			$time = strtotime($date);
		} else {
			$time = time();
		}
		# 获取该日期是当前月的第几天
		$day = date("j", $time);
		return date('Y-m-d',strtotime("-{$day} days", $time));
	}
	// 测试
    echo get_last_month_last_day();
    echo "<br />";
    echo get_last_month_last_day("2013-3-21");

?>