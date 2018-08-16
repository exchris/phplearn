/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : home

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-02-21 18:27:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `estate`
-- ----------------------------
DROP TABLE IF EXISTS `estate`;
CREATE TABLE `estate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `price` int(11) NOT NULL,
  `time` datetime NOT NULL COMMENT '楼盘发布时间',
  `state` enum('住宅','别墅','写字楼','商铺') NOT NULL DEFAULT '住宅' COMMENT '类型',
  `type` varchar(30) NOT NULL DEFAULT '一室',
  `owner` varchar(40) NOT NULL DEFAULT '3室1厅' COMMENT '主推户型',
  `big` int(11) unsigned NOT NULL DEFAULT '132' COMMENT '面积',
  `addr` varchar(100) NOT NULL DEFAULT '[新区] 珠江路与旺庄路交界处' COMMENT '地址',
  `phone` varchar(20) NOT NULL DEFAULT '400-640-9988转12743' COMMENT '电话',
  `avg` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='楼盘表';

-- ----------------------------
-- Records of estate
-- ----------------------------
INSERT INTO `estate` VALUES ('1', '锡山', '无锡碧桂园', '6500', '2017-02-20 15:55:11', '住宅', '一室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '8000', 'Property01.jpg');
INSERT INTO `estate` VALUES ('2', '江阴', '金港福景园', '16000', '2017-02-20 15:55:15', '别墅', '5室以上', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '9000', 'Property02.jpg');
INSERT INTO `estate` VALUES ('3', '新区', '美新玫瑰大道', '7600', '2017-02-20 15:55:18', '写字楼', '四室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '8500', 'Property03.jpg');
INSERT INTO `estate` VALUES ('4', '滨湖', '魅力万科城酩悦', '11000', '2017-02-20 15:55:20', '商铺', '三室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '1000', 'Property05.jpg');
INSERT INTO `estate` VALUES ('5', '北塘', '元一蔚蓝观邸', '7500', '2017-02-20 15:55:23', '写字楼', '二室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '6000', 'Property04.jpg');
INSERT INTO `estate` VALUES ('6', '崇安', '山湾水榭', '17800', '2017-02-20 15:55:26', '别墅', '5室以上', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '15000', 'Property01.jpg');
INSERT INTO `estate` VALUES ('7', '惠山', '复地公园城邦', '8000', '2017-02-20 15:55:28', '商铺', '一室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '8000', 'Property02.jpg');
INSERT INTO `estate` VALUES ('8', '南长', '茂业天地观园', '10000', '2017-02-20 15:55:31', '住宅', '三室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '10000', 'Property03.jpg');
INSERT INTO `estate` VALUES ('9', '锡山', '鹅湖一号', '5200', '2017-02-20 15:55:34', '别墅', '三室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '5000', 'Property04.jpg');
INSERT INTO `estate` VALUES ('10', '滨湖', '蠡湖国际公寓', '9000', '2017-02-20 15:55:36', '住宅', '三室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '8500', 'Property06.jpg');
INSERT INTO `estate` VALUES ('11', '宜兴', '宜兴广场', '8100', '2017-02-20 16:58:51', '住宅', '一室', '3室1厅', '132', '[新区] 珠江路与旺庄路交界处', '400-640-9988转12743', '7500', 'Property05.jpg');

-- ----------------------------
-- Table structure for `jingjiren`
-- ----------------------------
DROP TABLE IF EXISTS `jingjiren`;
CREATE TABLE `jingjiren` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `phone` char(12) NOT NULL,
  `dian` varchar(40) NOT NULL,
  `fuze` varchar(100) NOT NULL,
  `image` varchar(40) NOT NULL,
  `area` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10015 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jingjiren
-- ----------------------------
INSERT INTO `jingjiren` VALUES ('10001', '杨玉萍', '13879139393', '三眼井', '站前西路邮电小区', 'img/pic_home_slider_3.jpg', '东湖');
INSERT INTO `jingjiren` VALUES ('10002', '张小三', '17756892314', '上海路链家', '站前南路机关小区', 'img/pic_home_slider_3.jpg', '西湖');
INSERT INTO `jingjiren` VALUES ('10003', '李小四', '17689542361', '安居客', '中山路小区', 'img/pic_home_slider_3.jpg', '红谷滩');
INSERT INTO `jingjiren` VALUES ('10004', '王小二', '17689542362', '安居客', '小兰', 'img/pic_home_slider_3.jpg', '青山湖');
INSERT INTO `jingjiren` VALUES ('10005', '杨启桥', '17689542363', '安居客', '丁公路', 'img/pic_home_slider_3.jpg', '湾里');
INSERT INTO `jingjiren` VALUES ('10006', '白京', '17689542364', '安居客', '高新大道', 'img/pic_home_slider_3.jpg', '湾里');
INSERT INTO `jingjiren` VALUES ('10007', '李一', '17689542365', '安居客', '昌北路', 'img/pic_home_slider_3.jpg', '青山湖');
INSERT INTO `jingjiren` VALUES ('10008', '李二', '17689542366', '安居客', '机场路', 'img/pic_home_slider_3.jpg', '红谷滩');
INSERT INTO `jingjiren` VALUES ('10009', '李三', '17689542367', '安居客', '站前东路', 'img/pic_home_slider_3.jpg', '西湖');
INSERT INTO `jingjiren` VALUES ('10010', '李四', '17689542368', '安居客', '站前北路', 'img/pic_home_slider_3.jpg', '高新');
INSERT INTO `jingjiren` VALUES ('10011', '李武', '17689542369', '安居客', '站前小路', 'img/pic_home_slider_3.jpg', '昌西');
INSERT INTO `jingjiren` VALUES ('10012', '李柳', '17689542370', '安居客', '小路汲取', 'img/pic_home_slider_3.jpg', '昌南');

-- ----------------------------
-- Table structure for `renting`
-- ----------------------------
DROP TABLE IF EXISTS `renting`;
CREATE TABLE `renting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '名字',
  `price` int(11) unsigned NOT NULL COMMENT '价格',
  `type` varchar(40) NOT NULL DEFAULT '' COMMENT '房型',
  `area` varchar(40) NOT NULL DEFAULT '' COMMENT '区域',
  `mianji` int(10) NOT NULL,
  `addr` varchar(40) NOT NULL,
  `image` varchar(40) NOT NULL,
  `full` varchar(40) NOT NULL DEFAULT '' COMMENT '全名称',
  `xiu` varchar(40) NOT NULL DEFAULT '' COMMENT '装修情况',
  `xiang` varchar(20) NOT NULL COMMENT '朝向',
  `state` enum('整套出租','单间出租','床位出租') NOT NULL DEFAULT '整套出租',
  `from` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='房屋表';

-- ----------------------------
-- Records of renting
-- ----------------------------
INSERT INTO `renting` VALUES ('1', '五洲国际广场银河城', '2000', '2室1厅', '崇安', '97', '崇安新城住在五洲国际附近', 'Property01.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '精装修', '西南', '整套出租', '个人房源');
INSERT INTO `renting` VALUES ('2', '无锡万健商业广场', '1200', '1室1厅', '南长', '80', '南长近郊 无锡万健商业附近', 'Property02.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '简单装修', '东南', '整套出租', '张三');
INSERT INTO `renting` VALUES ('3', '五洲国际银河城', '3500', '四室', '滨湖', '120', '滨湖正对面，银河城附近', 'Property03.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '中等装修', '东南', '单间出租', '李四');
INSERT INTO `renting` VALUES ('4', '无锡万健商业广场', '1800', '1室1厅', '宜兴', '60', '宜兴湖边', 'Property05.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '简单装修', '东南', '床位出租', '张三');
INSERT INTO `renting` VALUES ('5', '五洲国际广场银河城', '800', '1室', '锡山', '40', '锡山郊外', 'Property04.jpg', '单间出租|精装2室1厅家电齐全，高性价比，拎包入住', '毛坯', '西南', '单间出租', '个人房源');
INSERT INTO `renting` VALUES ('6', '无锡万健商业广场', '1500', '1室1厅', '惠山', '95', '惠山万健', 'Property06.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '豪化装修', '南', '床位出租', '个人房源');
INSERT INTO `renting` VALUES ('7', '无锡万健商业广场', '4500', '5室以上', '北塘', '150', '北塘商业广场', 'Property02.jpg', '整租|精装2室1厅家电齐全，高性价比，拎包入住', '豪华装修', '东', '整套出租', '个人房源');
INSERT INTO `renting` VALUES ('8', '', '1111', '111', '新区', '1111', '1111', 'Property01.jpg', '1111', '精装修', '东', '整套出租', '');
INSERT INTO `renting` VALUES ('9', '', '1111', '111', '新区', '1111', '1111', 'Property01.jpg', '1111', '精装修', '东', '整套出租', '');

-- ----------------------------
-- Table structure for `second`
-- ----------------------------
DROP TABLE IF EXISTS `second`;
CREATE TABLE `second` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL DEFAULT '',
  `price` int(11) unsigned NOT NULL,
  `area` varchar(40) NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of second
-- ----------------------------
INSERT INTO `second` VALUES ('1', '2室1厅', '46', '锡山区', '1');
INSERT INTO `second` VALUES ('2', '1室1厅', '36', '江阴市', '2');
INSERT INTO `second` VALUES ('3', '2室1厅', '50', '新区', '3');
INSERT INTO `second` VALUES ('4', '2室1厅', '40', '滨湖区', '4');
INSERT INTO `second` VALUES ('5', '2室1厅', '38', '北塘区', '5');
INSERT INTO `second` VALUES ('6', '2室1厅', '42', '江阴市', '6');
INSERT INTO `second` VALUES ('7', '2室1厅', '43', '惠山区', '7');
INSERT INTO `second` VALUES ('8', '2室1厅', '48', '南长区', '8');
INSERT INTO `second` VALUES ('9', '2室1厅', '45', '惠山区', '8');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长用户ID',
  `username` varchar(40) NOT NULL DEFAULT '' COMMENT '用户登录的用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `role` enum('普通用户','管理员','经纪人') NOT NULL DEFAULT '普通用户' COMMENT '角色',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '真实名字或昵称',
  `tel` char(12) NOT NULL DEFAULT '' COMMENT '电话',
  `addr` varchar(100) NOT NULL DEFAULT '' COMMENT '地址',
  `email` varchar(40) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` char(12) NOT NULL DEFAULT '' COMMENT '手机',
  `unit` varchar(40) NOT NULL DEFAULT '' COMMENT '单位',
  `nickname` varchar(40) NOT NULL DEFAULT '' COMMENT '昵称',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `index` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1010 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1000', 'admin', '123456', '管理员', '', '', '', 'admin@11', '', '', 'admin');
INSERT INTO `user` VALUES ('1001', 'zs', '123456', '普通用户', '张三', '', '', '', '', '', '');
INSERT INTO `user` VALUES ('1002', 'ls', '123456', '普通用户', '李四', '', '', '', '', '', '');
INSERT INTO `user` VALUES ('1003', '123', '123123', '普通用户', '', '', '', '', '', '', '');
INSERT INTO `user` VALUES ('1004', 'admin1111', '111', '普通用户', '', '', '', 'adadf@qq.com', '', '', '');
INSERT INTO `user` VALUES ('1005', '李四', '123456', '普通用户', '', '15622222', '', '362201@qq.com', '', '', '');
INSERT INTO `user` VALUES ('1006', '4-20个字', '', '普通用户', '', '0510-8517678', '', '', '', '', '');
INSERT INTO `user` VALUES ('1007', '张小三', '', '经纪人', '张三', '0510-8517678', '', '', '', '', '');
INSERT INTO `user` VALUES ('1008', 'yxy', '123456', '普通用户', '', '0510-8517678', '', 'yxy@qq.com', '17756894231', '', '');
INSERT INTO `user` VALUES ('1009', 'nch', '123456', '普通用户', '', '0510-8517678', '', '1111@qq.com', '13111111111', '', '');
