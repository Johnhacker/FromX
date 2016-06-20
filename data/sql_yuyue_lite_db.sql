-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2016 年 05 月 13 日 18:51
-- 服务器版本: 5.1.28
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sql_yuyue_lite_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_admin`
--

CREATE TABLE IF NOT EXISTS `v9tb_admin` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) NOT NULL COMMENT '管理员名',
  `password` varchar(32) NOT NULL COMMENT '管理员密码',
  `encrypt` varchar(6) DEFAULT NULL COMMENT '效验',
  `depart` varchar(20) NOT NULL COMMENT '部门角色',
  `purview` varchar(255) NOT NULL COMMENT '操作权限',
  `useing` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `lastloginip` varchar(15) DEFAULT NULL COMMENT '最后一次登录IP',
  `explain` varchar(80) DEFAULT NULL COMMENT '说明',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `v9tb_admin`
--

INSERT INTO `v9tb_admin` (`userid`, `username`, `password`, `encrypt`, `depart`, `purview`, `useing`, `lastlogintime`, `lastloginip`, `explain`, `addtime`) VALUES
(1, 'yltuan', 'f3aeb79b271044cff145d548171fa344', 'LVLevy', '网络部', '|12,|14,|16,|17,|19,|110,|22,|23,|24,|25,|26,|31,|32,|41,|42,|43,|45,|46,|47,|48,|49,|410,|411,|51,|52,|61,|62,|A1,|A2,|A3,|A4,|A5,|A6,|71,|72,|73,|74,|75,|76,|77,|78,|79,|710,|711,|712,|713,|714,|715,|81,|82,|83,|84,|86,', 1, 1463162179, '192.168.1.100', NULL, 1436715564),
(5, '黄咨询', '6bfa9213c40bfb29dcd06a2c90c048ec', 'JVzT3d', '咨询部', '|12,|13,|17,|18,|19,|110,|22,|31,|41,|42,|43,|45,|46,|47,|48,|49,|410,|411,|51,|61,|A1,|A2,|A3,|A4,|A6,|78,', 1, 1462509045, '192.168.1.100', NULL, 1457885256);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_adminlogs`
--

CREATE TABLE IF NOT EXISTS `v9tb_adminlogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '登录帐号',
  `depart` varchar(20) DEFAULT NULL COMMENT '部门角色',
  `loginip` varchar(15) DEFAULT NULL COMMENT '登录时的IP地址',
  `loginsoft` varchar(255) DEFAULT NULL COMMENT '登录时使用的浏览器',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=180 ;

--
-- 表的结构 `v9tb_bmfz`
--

CREATE TABLE IF NOT EXISTS `v9tb_bmfz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '部门分组',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 导出表中的数据 `v9tb_bmfz`
--

INSERT INTO `v9tb_bmfz` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(13, '网络部', '网络部', 0, 1450167399),
(14, '咨询部', '咨询部', 0, 1450167464),
(15, '行政部', '行政部', 0, 1450167480),
(16, '客服部', '客服部', 0, 1450167490);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_bzks`
--

CREATE TABLE IF NOT EXISTS `v9tb_bzks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '病种科室',
  `explains` varchar(255) NOT NULL COMMENT '病种匹配',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `v9tb_bzks`
--

INSERT INTO `v9tb_bzks` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '产科', '婚前检查，孕前检查，产检，生产', 0, 1450009782),
(2, '男科', '生殖炎症，前列腺疾病，性功能障碍，生殖整形，男性不育，性病，男科检查', 0, 1450009937),
(3, '乳腺疾病', '乳腺炎，乳腺增生，乳腺纤维瘤，乳腺癌', 0, 1450009962),
(4, '妇科', '妇科炎症，计划生育，生殖整形，内分泌异常，女性不孕，性病，妇科检查', 0, 1450009975),
(5, '肛肠', '痔疮，肛裂，肛瘘，肛周脓肿', 0, 1450009990),
(6, '微创外科', '腋臭，结石，肿瘤，阑尾炎，胆囊疾病', 0, 1450010003),
(7, '皮肤科', '痤疮，皮炎，湿疹，白癜风，祛斑，荨麻疹，毛囊炎，扁平疣，瘙痒症，顽固皮肤病', 0, 1450010016),
(8, '综合科', '体检，口腔，内科，中医，骨科，其他', 0, 1450010031),
(9, '待定', '待定', 0, 1450010039);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_diqu`
--

CREATE TABLE IF NOT EXISTS `v9tb_diqu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '地区',
  `explains` varchar(255) NOT NULL COMMENT '地区匹配',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `v9tb_diqu`
--

INSERT INTO `v9tb_diqu` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '北京', '西城区，海淀区，朝阳区，丰台区', 0, 1450009120);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_email`
--

CREATE TABLE IF NOT EXISTS `v9tb_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emname` varchar(20) NOT NULL COMMENT '名称',
  `emaddr` varchar(255) NOT NULL COMMENT '邮箱地址',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `useing` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `v9tb_email`
--

INSERT INTO `v9tb_email` (`id`, `emname`, `emaddr`, `explains`, `listorder`, `useing`, `addtime`) VALUES
(1, 'admin888', 'admin888@qq.cn', '', 0, 1, 1450013068);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_ipbanned`
--

CREATE TABLE IF NOT EXISTS `v9tb_ipbanned` (
  `ipbannedid` smallint(5) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL,
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipbannedid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `v9tb_ipbanned`
--


-- --------------------------------------------------------

--
-- 表的结构 `v9tb_jzqk`
--

CREATE TABLE IF NOT EXISTS `v9tb_jzqk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '就诊情况',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `v9tb_jzqk`
--

INSERT INTO `v9tb_jzqk` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '消费|大于50元', '消费金额50元以上（含50元）', 0, 1449992764),
(2, '消费|不足50元', '消费金额不足50元', 0, 1449992779),
(3, '消费|大于1000', '消费金额大于1000', 0, 1449992843),
(4, '检查没治疗', '只检查没治疗', 0, 1449992968),
(5, '检查没手术', '只检查没手术', 0, 1449992989),
(6, '挂号没消费', '挂号没消费', 0, 1449993001),
(7, '待定', '消费待定', 0, 1449993043);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_log`
--

CREATE TABLE IF NOT EXISTS `v9tb_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field` varchar(15) NOT NULL,
  `value` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(15) NOT NULL,
  `file` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `querystring` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`logid`),
  KEY `module` (`module`,`file`,`action`),
  KEY `username` (`username`,`action`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=616 ;

--
-- 表的结构 `v9tb_lyfs`
--

CREATE TABLE IF NOT EXISTS `v9tb_lyfs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '来院方式',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `v9tb_lyfs`
--

INSERT INTO `v9tb_lyfs` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '预约到院', '预约到院', 0, 1449993369);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_menu`
--

CREATE TABLE IF NOT EXISTS `v9tb_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `roid` varchar(6) DEFAULT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` varchar(20) NOT NULL DEFAULT '',
  `c` varchar(20) NOT NULL DEFAULT '',
  `a` varchar(20) NOT NULL DEFAULT '',
  `data` varchar(30) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `display` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`a`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- 导出表中的数据 `v9tb_menu`
--

INSERT INTO `v9tb_menu` (`id`, `roid`, `name`, `parentid`, `m`, `c`, `a`, `data`, `listorder`, `display`) VALUES
(1, '9999', '预约数据', 0, 'admin', 'main', '', '', 1, '1'),
(2, '9999', '到院数据', 0, 'admin', 'dyua', '', '', 2, '1'),
(3, '9999', '综合数据', 0, 'admin', 'comp', '', '', 5, '1'),
(4, '9999', '统计分析', 0, 'admin', 'anls', '', '', 7, '1'),
(5, '9999', '统计报表', 0, 'admin', 'repo', '', '', 10, '1'),
(6, '9999', '排班表', 0, 'admin', 'line', '', '', 12, '1'),
(7, '9999', '用户管理', 0, 'admin', 'user', '', '', 16, '1'),
(8, '9999', '系统设置', 0, 'admin', 'sysm', '', '', 18, '1'),
(9, '0', '全部', 1, 'admin', 'main', 'public_list', '', 1, '1'),
(10, '0', '本月', 1, 'admin', 'main', 'public_list', 's=cmonth', 2, '1'),
(11, '0', '上个月', 1, 'admin', 'main', 'public_list', 's=pmonth', 5, '1'),
(12, '0', '本周', 1, 'admin', 'main', 'public_list', 's=cweek', 7, '1'),
(13, '0', '昨天', 1, 'admin', 'main', 'public_list', 's=teday', 10, '1'),
(14, '0', '今天', 1, 'admin', 'main', 'public_list', 's=today', 12, '1'),
(15, '0', '预计明天', 1, 'admin', 'main', 'public_list', 's=prtomor', 16, '1'),
(16, '0', '预计今天', 1, 'admin', 'main', 'public_list', 's=prtoday', 18, '1'),
(17, '0', '预计近期', 1, 'admin', 'main', 'public_list', 's=prnear', 20, '1'),
(18, '0', '预计不到院', 1, 'admin', 'main', 'public_list', 's=prnonat', 24, '1'),
(19, '110', '历史编辑', 1, 'admin', 'edlg', 'public_list', '', 26, '1'),
(20, '17', '录入预约数据', 1, 'admin', 'main', 'public_add', '', 28, '1'),
(21, '0', '全部', 2, 'admin', 'dyua', 'public_list', '', 1, '0'),
(22, '0', '本月', 2, 'admin', 'dyua', 'public_list', 's=cmonth', 2, '1'),
(23, '0', '上个月', 2, 'admin', 'dyua', 'public_list', 's=pmonth', 5, '1'),
(24, '0', '本周', 2, 'admin', 'dyua', 'public_list', 's=cweek', 7, '1'),
(25, '0', '昨天', 2, 'admin', 'dyua', 'public_list', 's=teday', 10, '1'),
(26, '0', '今天', 2, 'admin', 'dyua', 'public_list', 's=today', 12, '1'),
(27, '31', '本月', 3, 'admin', 'comp', 'public_wlxf_list', 's=cmonth', 2, '1'),
(28, '31', '上个月', 3, 'admin', 'comp', 'public_wlxf_list', 's=pmonth', 5, '1'),
(29, '32', '录入/修改', 3, 'admin', 'comp', 'public_wlxf_add', '', 7, '1'),
(30, '41', '到院统计', 4, 'admin', 'anls', 'public_dyuan', '', 1, '1'),
(31, '42', '预约＆有效对话', 4, 'admin', 'anls', 'public_yydh', '', 3, '1'),
(32, '43', '推广费用', 4, 'admin', 'anls', 'public_wlxf', '', 5, '1'),
(33, '45', '时段统计', 4, 'admin', 'anls', 'public_sduan', '', 7, '1'),
(34, '46', '途径统计', 4, 'admin', 'anls', 'public_tjing', '', 10, '1'),
(35, '47', '病种统计', 4, 'admin', 'anls', 'public_bzhong', '', 12, '1'),
(36, '48', '地区分布', 4, 'admin', 'anls', 'public_qiqu', '', 16, '1'),
(37, '49', '咨询员数据', 4, 'admin', 'anls', 'public_zxyuan', '', 18, '1'),
(38, '410', '部门数据', 4, 'admin', 'anls', 'public_bmen', '', 20, '1'),
(39, '411', '年度综合数据', 4, 'admin', 'anls', 'public_ndzh', '', 24, '1'),
(40, 'A1', '咨询员途径报表', 5, 'admin', 'repo', 'public_zxytj', '', 1, '1'),
(41, 'A2', '咨询员报表', 5, 'admin', 'repo', 'public_zxyuan', '', 3, '1'),
(42, 'A3', '咨询途径报表', 5, 'admin', 'repo', 'public_tjing', '', 5, '1'),
(43, 'A4', '病种统计报表', 5, 'admin', 'repo', 'public_bzhong', '', 7, '1'),
(44, 'A5', '到院数据报表', 5, 'admin', 'repo', 'public_dyuan', '', 10, '1'),
(45, 'A6', '增长比报表', 5, 'admin', 'repo', 'public_zzbi', '', 12, '1'),
(46, '51', '咨询排班表', 6, 'admin', 'line', 'public_list', 's=1', 1, '1'),
(47, '51', '导医排班表', 6, 'admin', 'line', 'public_list', 's=2', 3, '1'),
(48, '51', '竞价排班表', 6, 'admin', 'line', 'public_list', 's=3', 5, '1'),
(49, '52', '录入/修改', 6, 'admin', 'line', 'public_pbset', '', 7, '1'),
(50, '61', '修改密码', 7, 'admin', 'user', 'public_changepwd', '', 1, '1'),
(51, '62', '用户列表', 7, 'admin', 'user', 'public_userlist', '', 3, '1'),
(52, '62', '添加用户', 7, 'admin', 'user', 'public_adduser', '', 5, '1'),
(53, '77', '用户登录日志', 8, 'admin', 'sysm', 'public_loginlogs', '', 60, '1'),
(54, '71', '常量设置', 8, 'admin', 'sysm', 'public_siteset', '', 3, '1'),
(55, '73', '部门设置', 8, 'admin', 'sysm', 'public_bmfzset', '', 5, '1'),
(56, '72', '邮箱设置', 8, 'admin', 'sysm', 'public_emailset', '', 7, '1'),
(57, '74', '排班设置', 8, 'admin', 'sysm', 'public_pbqkset', '', 10, '1'),
(58, '78', '专 家', 8, 'admin', 'sysm', 'public_zjysset', '', 12, '1'),
(59, '79', '咨询员', 8, 'admin', 'sysm', 'public_zxzyset', '', 16, '1'),
(60, '710', '咨询途径', 8, 'admin', 'sysm', 'public_yytjset', '', 18, '1'),
(61, '714', '就诊情况', 8, 'admin', 'sysm', 'public_jzqkset', '', 28, '1'),
(62, '713', '来院方式', 8, 'admin', 'sysm', 'public_lyfsset', '', 30, '1'),
(63, '712', '地区校验', 8, 'admin', 'sysm', 'public_diquset', '', 20, '1'),
(64, '711', '病种校验', 8, 'admin', 'sysm', 'public_bzksset', '', 24, '1'),
(65, '715', '推广消费', 8, 'admin', 'sysm', 'public_wlxfset', '', 34, '1'),
(66, '23', '录入到院数据', 2, 'admin', 'dyua', 'public_add', '', 20, '0');

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_pbqk`
--

CREATE TABLE IF NOT EXISTS `v9tb_pbqk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '排班名称',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `v9tb_pbqk`
--

INSERT INTO `v9tb_pbqk` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '咨询排班表', '白班：08:50-12:30~15:00-18:20　晚班：08:50-00:00', 0, 1439785609),
(2, '导医排班表', '上班时间：8:00-17:30', 0, 1439785655),
(3, '竞价排班表', '白班：8:30-16:30　晚班：3:30-23:30', 0, 1439785698);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_pbqk_data`
--

CREATE TABLE IF NOT EXISTS `v9tb_pbqk_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pbmonth` int(10) unsigned DEFAULT '0' COMMENT '排班月份',
  `pbsort` varchar(20) NOT NULL COMMENT '排班分类',
  `pbcontent` text COMMENT '排班详细内容',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `v9tb_pbqk_data`
--

INSERT INTO `v9tb_pbqk_data` (`id`, `pbmonth`, `pbsort`, `pbcontent`, `addtime`) VALUES
(1, 4, '导医排班表', 'a:3:{i:0;a:1:{i:0;a:2:{i:0;s:12:"自动填充";i:1;s:113:"早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,早,,";}}i:1;a:1:{i:0;a:2:{i:0;s:12:"自动填充";i:1;s:113:"中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,,";}}i:2;a:1:{i:0;a:2:{i:0;s:12:"自动填充";i:1;s:111:"中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,中,X,中,中,中,中,中,中,中,中,中,中,中,,";}}}', 1439783452);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_session`
--

CREATE TABLE IF NOT EXISTS `v9tb_session` (
  `sessionid` char(32) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `roleid` tinyint(3) unsigned DEFAULT '0',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL,
  `c` char(20) NOT NULL,
  `a` char(20) NOT NULL,
  `data` char(255) NOT NULL,
  PRIMARY KEY (`sessionid`),
  KEY `lastvisit` (`lastvisit`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 表的结构 `v9tb_site`
--

CREATE TABLE IF NOT EXISTS `v9tb_site` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitetitle` varchar(255) NOT NULL COMMENT '系统名称',
  `cookietime` int(10) unsigned NOT NULL DEFAULT '12' COMMENT 'Cookie时间',
  `fsemail` varchar(255) DEFAULT NULL COMMENT '发送邮箱',
  `fsemailpwd` varchar(255) DEFAULT NULL COMMENT '发送邮箱密码',
  `stylecss` varchar(20) NOT NULL DEFAULT '0' COMMENT '系统风格',
  `systemsn` varchar(255) NOT NULL COMMENT '授权号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `v9tb_site`
--

INSERT INTO `v9tb_site` (`id`, `sitetitle`, `cookietime`, `fsemail`, `fsemailpwd`, `stylecss`, `systemsn`) VALUES
(1, '医院预约管理系统', 12, 'admin@qq.com', '333333', '0', '344FD7B65D1C71583B');

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_times`
--

CREATE TABLE IF NOT EXISTS `v9tb_times` (
  `username` char(40) NOT NULL,
  `ip` char(15) NOT NULL,
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `times` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`,`isadmin`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `v9tb_times`
--


-- --------------------------------------------------------

--
-- 表的结构 `v9tb_wlxf`
--

CREATE TABLE IF NOT EXISTS `v9tb_wlxf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '网络消费名称',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `v9tb_wlxf`
--

INSERT INTO `v9tb_wlxf` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '百度竞价1', '百度竞价账户', 0, 1450010472),
(2, '360竞价1', '360竞价账户', 0, 1439813669);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_wlxf_data`
--

CREATE TABLE IF NOT EXISTS `v9tb_wlxf_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组ID',
  `rcdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '费用日期',
  `cname` varchar(20) NOT NULL COMMENT '推广名称',
  `tgcost` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广费用',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `rcdate` (`rcdate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 表的结构 `v9tb_wlzh_data`
--

CREATE TABLE IF NOT EXISTS `v9tb_wlzh_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rcdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录日期',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 表的结构 `v9tb_yuyue`
--

CREATE TABLE IF NOT EXISTS `v9tb_yuyue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yydate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约日期',
  `hzname` varchar(20) NOT NULL COMMENT '患者姓名',
  `djname` varchar(20) DEFAULT NULL COMMENT '患者登记姓名',
  `hzsex` varchar(20) DEFAULT NULL COMMENT '性别',
  `hzage` varchar(20) DEFAULT NULL COMMENT '年龄',
  `hzcity` varchar(20) DEFAULT NULL COMMENT '地区',
  `hztel` varchar(20) NOT NULL COMMENT '电话/QQ',
  `bingzx` varchar(20) DEFAULT NULL COMMENT '病种',
  `bingzm` varchar(20) DEFAULT NULL COMMENT '病种',
  `yynum` varchar(20) NOT NULL COMMENT '预约号',
  `yytime1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约时间',
  `yytime2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约时间',
  `yyzxy` varchar(20) NOT NULL COMMENT '咨询员',
  `yytj` varchar(20) NOT NULL COMMENT '预约途径',
  `yyzj` varchar(20) DEFAULT NULL COMMENT '预约专家',
  `jzzj` varchar(20) DEFAULT NULL COMMENT '接诊专家',
  `bmfz` varchar(20) DEFAULT NULL COMMENT '部门分组',
  `yykey` varchar(20) DEFAULT NULL COMMENT '关键词',
  `lydate` int(10) unsigned DEFAULT NULL COMMENT '来院日期',
  `lyfs` varchar(20) DEFAULT NULL COMMENT '来院方式',
  `jzqk` varchar(20) DEFAULT NULL COMMENT '就诊情况',
  `sjxf` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际消费',
  `hfjg` varchar(255) DEFAULT NULL COMMENT '回访结果',
  `tover` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '接管状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `username` varchar(20) NOT NULL COMMENT '操作用户',
  PRIMARY KEY (`id`),
  KEY `hztel` (`hztel`),
  KEY `bingz` (`bingzx`),
  KEY `yynum` (`yynum`),
  KEY `yytime1` (`yytime1`),
  KEY `yytime2` (`yytime2`),
  KEY `yyzxy` (`yyzxy`),
  KEY `yytj` (`yytj`),
  KEY `yyzj` (`yyzj`),
  KEY `zjzj` (`jzzj`),
  KEY `bmfz` (`bmfz`),
  KEY `yykey` (`yykey`),
  KEY `lydate` (`lydate`),
  KEY `lyfs` (`lyfs`),
  KEY `jzqk` (`jzqk`),
  KEY `tover` (`tover`),
  KEY `addtime` (`addtime`),
  KEY `yydate` (`yydate`),
  KEY `bingzm` (`bingzm`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19955 ;

--
-- 表的结构 `v9tb_yuyue_data`
--

CREATE TABLE IF NOT EXISTS `v9tb_yuyue_data` (
  `id` int(10) unsigned NOT NULL,
  `remark` text COMMENT '备注',
  `jzremark` text COMMENT '接诊备注',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 表的结构 `v9tb_yytj`
--

CREATE TABLE IF NOT EXISTS `v9tb_yytj` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '咨询途径',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `v9tb_yytj`
--

INSERT INTO `v9tb_yytj` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '熟人介绍', '企划部', 0, 1449990675),
(2, '免费电话', '网络部', 0, 1449990689),
(3, '电视电话', '市场部', 0, 1449990787),
(5, '商务通', '网络部', 0, 1449990858),
(6, '网络电话', '网络部', 0, 1449990943),
(8, 'QQ', '网络部', 0, 1449991078),
(9, '网络微信', '网络部', 0, 1449991197),
(10, '百度商桥', '网络部', 0, 1459098742),
(11, '报纸电话', '市场部', 0, 1460552571);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_zjys`
--

CREATE TABLE IF NOT EXISTS `v9tb_zjys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '专家姓名',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 导出表中的数据 `v9tb_zjys`
--

INSERT INTO `v9tb_zjys` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '杜医生', '男科', 0, 1449979456),
(2, '谢医生', '男科', 0, 1449981066),
(3, '傅医生', '妇科', 0, 1449981101),
(4, '牟医生', '外科', 0, 1449981146),
(5, '杨医生', '综合科', 0, 1449981168),
(6, '周医生', '皮肤科', 0, 1449981189),
(7, '综合科', '类别', 0, 1460516456),
(8, '外科', '类别', 0, 1460516441),
(9, '妇科', '类别', 0, 1460516419),
(10, '男科', '类别', 0, 1460516403),
(11, '皮肤科', '类别', 0, 1460516474);

-- --------------------------------------------------------

--
-- 表的结构 `v9tb_zxdh`
--

CREATE TABLE IF NOT EXISTS `v9tb_zxdh` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zxydate` int(10) unsigned DEFAULT '0' COMMENT '日期',
  `zxyname` varchar(20) NOT NULL COMMENT '咨询员',
  `zxyzdh` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总对话',
  `zxyjjdh` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '极佳对话',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `v9tb_zxdh`
--


-- --------------------------------------------------------

--
-- 表的结构 `v9tb_zxzy`
--

CREATE TABLE IF NOT EXISTS `v9tb_zxzy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL COMMENT '咨询专员名称',
  `explains` varchar(255) DEFAULT NULL COMMENT '说明',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 导出表中的数据 `v9tb_zxzy`
--

INSERT INTO `v9tb_zxzy` (`id`, `cname`, `explains`, `listorder`, `addtime`) VALUES
(1, '杨咨询', '咨询组', 0, 1449985383),
(2, '李咨询', '咨询组', 0, 1449985744),
(3, '黄咨询', '咨询组', 0, 1449990103);
