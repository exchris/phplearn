/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hc

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-04-11 17:33:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `index` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('10000', 'admin', '123456');
INSERT INTO `admin` VALUES ('10001', 'huchen', '123456');

-- ----------------------------
-- Table structure for `class`
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `cno` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程ID',
  `cname` varchar(40) NOT NULL DEFAULT '' COMMENT '课程名称',
  `credit` float unsigned NOT NULL COMMENT '学分',
  `term` varchar(40) NOT NULL DEFAULT '2015-2016上学期' COMMENT '学期',
  `require` enum('必修课','公共任选课','限选课') NOT NULL DEFAULT '必修课' COMMENT '课程要求',
  `tno` int(11) unsigned NOT NULL COMMENT '教工号',
  PRIMARY KEY (`cno`)
) ENGINE=MyISAM AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8mb4 COMMENT='课程表';

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1001', '数据库管理系统', '5', '2015-2016上学期', '必修课', '100009');
INSERT INTO `class` VALUES ('1002', '高等数学', '6', '2015-2016上学期', '必修课', '100007');
INSERT INTO `class` VALUES ('1003', '大学物理', '6.5', '2015-2016上学期', '必修课', '100002');
INSERT INTO `class` VALUES ('1004', '大学体育', '2', '2016-2017上学期', '必修课', '100006');

-- ----------------------------
-- Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goods_sn` varchar(40) NOT NULL DEFAULT '',
  `goods_name` varchar(40) NOT NULL,
  `goods_thumb` varchar(50) NOT NULL DEFAULT '',
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('AHC-625', 'AHC', '', '1');
INSERT INTO `goods` VALUES ('AHC-611', 'AHC', '', '2');
INSERT INTO `goods` VALUES ('AHC-1545', 'AHC', '', '3');
INSERT INTO `goods` VALUES ('AHC-617', 'AHC', '', '4');

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `parent` int(11) unsigned NOT NULL COMMENT '回复',
  `content` varchar(300) NOT NULL DEFAULT '' COMMENT '留言内容',
  `datetime` datetime NOT NULL COMMENT '留言时间',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) unsigned NOT NULL COMMENT '留言者ID',
  `title` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='留言表';

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', '0', '数据库管理系统如何学习', '2017-03-24 09:30:05', '2017-03-24 10:47:16', '20130901', '学习');
INSERT INTO `message` VALUES ('3', '0', 'what\'s about?', '2017-03-24 10:41:54', '2017-04-11 10:08:47', '20130901', '疑问');
INSERT INTO `message` VALUES ('5', '0', '13信管同学请注意:5月毕业答辩', '2017-03-27 15:53:41', '2017-03-27 15:53:41', '20130906', '13信管同学');
INSERT INTO `message` VALUES ('4', '0', '留言表如何创建，有那些说明的内容', '2017-03-24 10:49:34', '2017-03-24 10:50:11', '20130901', '留言表有那些说明');
INSERT INTO `message` VALUES ('6', '0', '13信管同学请注意:5月毕业答辩', '2017-03-27 15:53:57', '2017-03-27 15:53:57', '20130906', '13信管同学111');
INSERT INTO `message` VALUES ('7', '0', 'teacher is our country purent is a are you ok?', '2017-03-27 16:41:03', '2017-04-11 10:13:00', '100009', 'teacher');
INSERT INTO `message` VALUES ('9', '0', 'teacher', '2017-03-27 17:42:47', '2017-04-11 10:08:36', '20130911', 'teacher12312');
INSERT INTO `message` VALUES ('14', '0', '我太美丽了，请叫我郝美丽', '2017-04-11 10:09:50', '2017-04-11 10:09:50', '100009', '你好');
INSERT INTO `message` VALUES ('13', '0', 'what the is this', '2017-04-11 10:01:41', '2017-04-11 10:01:41', '100009', '疑问');

-- ----------------------------
-- Table structure for `score`
-- ----------------------------
DROP TABLE IF EXISTS `score`;
CREATE TABLE `score` (
  `sno` int(11) unsigned NOT NULL COMMENT '学号',
  `cno` int(11) unsigned NOT NULL COMMENT '课程号',
  `score` int(11) unsigned NOT NULL COMMENT '成绩',
  PRIMARY KEY (`sno`,`cno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='成绩表';

-- ----------------------------
-- Records of score
-- ----------------------------
INSERT INTO `score` VALUES ('20130906', '1001', '80');
INSERT INTO `score` VALUES ('20130906', '1002', '90');
INSERT INTO `score` VALUES ('20130906', '1003', '68');
INSERT INTO `score` VALUES ('20130910', '1001', '68');
INSERT INTO `score` VALUES ('20130910', '1002', '70');
INSERT INTO `score` VALUES ('20130910', '1003', '59');
INSERT INTO `score` VALUES ('20130904', '1001', '69');
INSERT INTO `score` VALUES ('20130904', '1002', '70');
INSERT INTO `score` VALUES ('20130904', '1003', '90');
INSERT INTO `score` VALUES ('20130905', '1001', '60');
INSERT INTO `score` VALUES ('20130905', '1002', '40');
INSERT INTO `score` VALUES ('20130905', '1003', '80');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `sno` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学号',
  `sname` varchar(60) NOT NULL DEFAULT '' COMMENT '姓名',
  `ssex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `major` varchar(20) NOT NULL COMMENT '专业',
  `depart` varchar(20) NOT NULL COMMENT '系别',
  `regdate` date NOT NULL COMMENT '注册日期',
  `birthday` date NOT NULL COMMENT '年龄',
  `state` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1 在校生\r\n0 毕业生',
  `password` char(32) NOT NULL DEFAULT '123456' COMMENT '密码',
  `saddr` varchar(100) NOT NULL DEFAULT '' COMMENT '籍贯',
  `truename` varchar(60) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `email` varchar(40) NOT NULL,
  `phone` char(20) NOT NULL,
  `signature` varchar(300) NOT NULL,
  `qq` char(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`sno`),
  UNIQUE KEY `index` (`sname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20130912 DEFAULT CHARSET=utf8mb4 COMMENT='学生表';

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('20130910', 'liumou', '女', '电子竞技', '电气与信息工程', '2015-09-08', '1993-05-06', '1', '123456', '天津市 天津市 塘沽区', '刘谋', '', '', '', '');
INSERT INTO `student` VALUES ('20130904', 'wanghenwen', '男', '园林艺术', '土木建筑', '2013-09-01', '0000-00-00', '1', '123456', '江西 南昌', '王恒文', '', '', '', '');
INSERT INTO `student` VALUES ('20130905', 'shenwangzhong', '男', '软件工程', '电气与信息工程', '2013-09-01', '0000-00-00', '1', '123456', '江西 南昌', '沈网中', '', '', '', '');
INSERT INTO `student` VALUES ('20130906', 'huchen', '女', '信息管理与信息系统', '电气与信息工程', '2014-09-01', '1994-05-06', '1', '123456', '江西省 南昌市 东湖区', '胡晨', '11111@qq.com', '15259250794', '哈哈任务书有毒', '10001');

-- ----------------------------
-- Table structure for `teacher`
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `tno` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tname` varchar(40) NOT NULL,
  `tsex` enum('男','女') NOT NULL DEFAULT '男',
  `taddr` varchar(100) NOT NULL DEFAULT '江西 南昌' COMMENT '籍贯',
  `depart` varchar(20) NOT NULL COMMENT '系号',
  `birthday` date NOT NULL COMMENT '出生日期',
  `entrytime` date NOT NULL COMMENT '入职时间',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` char(32) NOT NULL DEFAULT '' COMMENT '个人简介',
  `truename` varchar(40) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `qq` varchar(40) NOT NULL DEFAULT '' COMMENT 'QQ',
  `email` varchar(40) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(40) NOT NULL DEFAULT '' COMMENT '手机号',
  `signature` varchar(300) NOT NULL DEFAULT '' COMMENT '个人简介',
  PRIMARY KEY (`tno`),
  UNIQUE KEY `index` (`tname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100012 DEFAULT CHARSET=utf8mb4 COMMENT='教师表';

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('100001', 'zhangsan', '男', '江西 南昌', '土木建筑', '1984-06-22', '2008-03-15', '2017-03-23 14:35:34', '123456', '张三', '', '', '', '');
INSERT INTO `teacher` VALUES ('100002', 'lisi', '女', '江西 南昌', '机电工程', '1984-06-22', '2008-03-15', '2017-03-23 14:35:36', '123456', '李四', '', '', '', '');
INSERT INTO `teacher` VALUES ('100003', 'wangwu', '男', '江西 南昌', '电气与信息工程', '1984-06-22', '2008-03-15', '2017-03-23 14:35:38', '123456', '王五', '', '', '', '');
INSERT INTO `teacher` VALUES ('100004', 'dengliu', '男', '江西 南昌', '经济管理', '1984-06-22', '2008-03-15', '2017-03-23 14:35:40', '123456', '邓六', '', '', '', '');
INSERT INTO `teacher` VALUES ('100005', 'qianer', '女', '江西 南昌', '人文法学', '1984-06-22', '2008-03-15', '2017-03-23 14:35:41', '123456', '钱二', '', '', '', '');
INSERT INTO `teacher` VALUES ('100006', 'wangxiaoer', '女', '江西 南昌', '体育', '1984-06-22', '2008-03-15', '2017-03-23 14:35:44', '123456', '王小二', '', '', '', '');
INSERT INTO `teacher` VALUES ('100007', 'liumou', '男', '江西 南昌', '理学', '1984-06-22', '2008-03-15', '2017-03-24 13:47:01', '123456', '刘某', '10001', '1111@qq.com', '17756894231', '无敌是多么寂寞');
INSERT INTO `teacher` VALUES ('100008', 'lilili', '女', '江西 南昌', '理学', '1984-06-22', '2008-03-15', '2017-03-23 14:35:50', '123456', '李莉莉', '', '', '', '');
INSERT INTO `teacher` VALUES ('100009', 'huchen', '女', '天津市 天津市 河东区', '电气与信息工程', '1980-11-01', '2008-10-01', '2017-03-23 16:42:35', '123456', '胡晨', '', '', '', '');
INSERT INTO `teacher` VALUES ('100010', 'huzongxian', '男', '天津市 天津市 河东区', '土木建筑', '1976-06-01', '1989-10-01', '2017-04-11 09:57:30', '123456', '胡宗宪', '', '', '', '');
