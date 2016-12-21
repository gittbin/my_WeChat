-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2016-12-21 16:12:13
-- 服务器版本： 5.5.27
-- PHP Version: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wxtang`
--

-- --------------------------------------------------------

--
-- 表的结构 `w_admin`
--

CREATE TABLE `w_admin` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_admin`
--

INSERT INTO `w_admin` (`id`, `username`, `password`) VALUES
(3, 'admin', 'd0c0850f894e29c7230ef4ceb83128dd');

-- --------------------------------------------------------

--
-- 表的结构 `w_exchange`
--

CREATE TABLE `w_exchange` (
  `id` mediumint(9) NOT NULL COMMENT 'id',
  `user` varchar(30) NOT NULL COMMENT '用户名',
  `content` varchar(300) NOT NULL COMMENT '内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文本信息表';

-- --------------------------------------------------------

--
-- 表的结构 `w_liuyan`
--

CREATE TABLE `w_liuyan` (
  `id` mediumint(9) NOT NULL COMMENT 'id',
  `user` varchar(30) NOT NULL COMMENT '用户名',
  `content` varchar(300) NOT NULL COMMENT '内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言表';

--
-- 转存表中的数据 `w_liuyan`
--

INSERT INTO `w_liuyan` (`id`, `user`, `content`, `addtime`) VALUES
(1, '羽落', '今天好冷', 1480523339);

-- --------------------------------------------------------

--
-- 表的结构 `w_menu_info`
--

CREATE TABLE `w_menu_info` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '简要说明',
  `picurl` varchar(100) NOT NULL DEFAULT '' COMMENT '图片地址',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加的时间',
  `type_id` tinyint(4) NOT NULL COMMENT '类型id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单发送消息信息表';

--
-- 转存表中的数据 `w_menu_info`
--

INSERT INTO `w_menu_info` (`id`, `title`, `description`, `picurl`, `url`, `addtime`, `type_id`) VALUES
(1, '成长,就是不断的挣扎与折腾', '她，开着几百万的玛莎利蒂在中州路奔驰，银行贷款却有一百万，挣扎在生与死的边缘。', 'http://www.duwenzhang.com/upimg/160714/1_131201.JPG', 'http://www.duwenzhang.com/wenzhang/lizhiwenzhang/20160714/355810.html', '2016-11-27 21:48:00', 2),
(2, '韦少砍17+13+15三双数追平詹皇 雷霆复仇活塞', 'NBA常规赛，雷霆主场以106-88力擒活塞，报了本赛季此前负于对手的一箭之仇。韦少贡献本赛季第7次三双，得到17分13篮板和15助攻。这是韦少生涯第44次三双，追平詹姆斯，并列历史三双榜第6。', 'http://img1.gtimg.com/sports/pics/hv1/113/136/2160/140488793.jpg', 'http://sports.qq.com/a/20161127/008923.htm', '2016-11-27 21:50:00', 3),
(3, 'ESPN实力指数：勇士持续领跑 骑士第4火箭第7', 'ESPN公布了最新一期实力指数，勇士、快船、马刺、骑士、猛龙以及火箭等球队的指数都有所上升。在具体排名上，勇士、快船、马刺仍然排名前三位，骑士只排在第四位，火箭排名第七。', 'http://img1.gtimg.com/sports/pics/hv1/43/116/2160/140483623.jpg', 'http://sports.qq.com/a/20161127/000853.htm', '2016-11-27 18:45:00', 3),
(4, '1', '1', '', '1', '0000-00-00 00:00:00', 1),
(5, '333', '3', '3', '', '0000-00-00 00:00:00', 2),
(6, '222', '2', '2', '2', '0000-00-00 00:00:00', 2),
(7, '1', '1', '', '1', '0000-00-00 00:00:00', 1),
(8, '', '', '', '', '0000-00-00 00:00:00', 0),
(9, '333', '3', '3', '', '0000-00-00 00:00:00', 2),
(10, '222', '2', '2', '2', '0000-00-00 00:00:00', 2),
(11, '1', '1', '', '1', '0000-00-00 00:00:00', 1),
(12, '', '', '', '', '2016-11-28 13:52:50', 0),
(13, '333', '3', '3', '', '0000-00-00 00:00:00', 2),
(14, '222', '2', '2', '2', '0000-00-00 00:00:00', 2),
(15, '1', '1', '', '1', '0000-00-00 00:00:00', 1),
(16, '333', '3', '3', '', '0000-00-00 00:00:00', 2),
(17, '222', '2', '2', '2', '0000-00-00 00:00:00', 2),
(18, '1', '1', '', '1', '2016-11-28 13:53:43', 1),
(19, '333', '3', '3', '', '2016-11-28 13:53:43', 2),
(20, '222', '2', '2', '2', '2016-11-28 13:53:43', 2),
(21, '33', '', '4', '', '2016-11-28 14:08:06', 3),
(22, '3', '', '5', '', '2016-11-28 14:08:06', 1),
(23, '66', '', '3', '', '2016-11-28 14:08:06', 3),
(24, '1111', '111', '', '', '2016-11-28 14:33:22', 2),
(25, '222', '', '222', '', '2016-11-28 14:33:22', 1),
(26, '444', '444', '444', '44', '2016-11-28 14:33:22', 1),
(27, '555', '55', '6', '', '2016-11-28 14:33:22', 3),
(28, '111', '111', '', '', '2016-11-28 14:34:22', 2),
(29, '222', '222', '', '222', '2016-11-28 14:34:22', 2),
(30, '333', '333', '', '', '2016-11-28 14:34:22', 1);

-- --------------------------------------------------------

--
-- 表的结构 `w_num`
--

CREATE TABLE `w_num` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `type` varchar(30) NOT NULL COMMENT '某种类型',
  `number` tinyint(4) NOT NULL COMMENT '条数数量',
  `type_name` varchar(30) NOT NULL COMMENT '菜单类型名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每条信息回复数量表';

--
-- 转存表中的数据 `w_num`
--

INSERT INTO `w_num` (`id`, `type`, `number`, `type_name`) VALUES
(1, 'focus', 1, '新闻关注'),
(2, 'from_me', 2, '我的推荐'),
(3, 'basketball', 1, '篮球热点');

-- --------------------------------------------------------

--
-- 表的结构 `w_send_day`
--

CREATE TABLE `w_send_day` (
  `id` mediumint(9) NOT NULL COMMENT 'id',
  `admin_name` varchar(30) NOT NULL COMMENT '管理员，简便考虑，没有使用id，有点违背规则',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(30) NOT NULL DEFAULT '' COMMENT '作者',
  `thumb_media_id` varchar(50) NOT NULL DEFAULT '' COMMENT '图文消息缩略图的media_id',
  `content_source_url` varchar(150) NOT NULL DEFAULT '' COMMENT '原文链接',
  `digest` varchar(150) NOT NULL DEFAULT '' COMMENT '图文描述',
  `addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每日推送';

--
-- 转存表中的数据 `w_send_day`
--

INSERT INTO `w_send_day` (`id`, `admin_name`, `title`, `author`, `thumb_media_id`, `content_source_url`, `digest`, `addtime`) VALUES
(1, '213', '321', '321', '321', '321', '321', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `w_user`
--

CREATE TABLE `w_user` (
  `id` mediumint(9) NOT NULL COMMENT 'id',
  `openid` varchar(30) NOT NULL COMMENT '用户唯一标识',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户的昵称',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未知，1男性，2女性',
  `city` varchar(40) NOT NULL DEFAULT '' COMMENT '城市',
  `country` varchar(40) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(40) NOT NULL DEFAULT '' COMMENT '省份',
  `language` varchar(30) NOT NULL DEFAULT '' COMMENT '用户的语言',
  `headimgurl` varchar(150) NOT NULL DEFAULT '' COMMENT '用户头像',
  `subscribe_time` int(4) NOT NULL DEFAULT '0' COMMENT '关注时间',
  `unionid` varchar(30) NOT NULL DEFAULT '' COMMENT '绑定到微信开放平台帐号后，才会出现',
  `remark` varchar(30) NOT NULL DEFAULT '' COMMENT '备注',
  `tagid_list` varchar(30) NOT NULL DEFAULT '' COMMENT '标签列表',
  `subscribe` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否订阅',
  `groupid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分组ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_user`
--

INSERT INTO `w_user` (`id`, `openid`, `nickname`, `sex`, `city`, `country`, `province`, `language`, `headimgurl`, `subscribe_time`, `unionid`, `remark`, `tagid_list`, `subscribe`, `groupid`) VALUES
(1, 'oeVwDv7KHzfNVcfAzqU3Rh7eDs7k', '唐魂淡', 1, '西青', '中国', '天津', 'zh_CN', 'http://wx.qlogo.cn/mmopen/YJgEWxmqfZWWltcslgbrgGMoiadsf84Vu0ibY2g9gjbmHEgcnFKSZsYDeq6y8QibbvYGVrS92YJicHNPR9uZMVuS0H3TXaib1g9y6/0', 1480079015, '', '', '', 1, 0),
(2, 'oeVwDv3HWFbWiv9eNz8_bURjpI6w', '邓邓', 2, '', '', '', 'zh_CN', 'http://wx.qlogo.cn/mmopen/Bej2w3kS6rKAylvWfq8gStK5eCrzzNyibfBI9pG1kfstp41fZzLZjTyCV4uGDsenvdEGpqKsuwib2ABibfYeSsFy6eyZiaEKmibian/0', 1479295787, '', '', '', 1, 0),
(3, 'oeVwDv9pVUoxWx1x9UBlqdcKWmjQ', '羽落', 1, '桂林', '中国', '广西', 'zh_CN', 'http://wx.qlogo.cn/mmopen/uvlvhnbYRbZOYp0yGNuxu25lJVLicdHbdkjWBPfgI9zbIM3ia5nsVmEajia3oDstXgI7W7ngeBKbpWbnibnAcvnic2GqZPgOWMa0q/0', 1480242828, '', '', '', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `w_admin`
--
ALTER TABLE `w_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `w_liuyan`
--
ALTER TABLE `w_liuyan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_menu_info`
--
ALTER TABLE `w_menu_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_num`
--
ALTER TABLE `w_num`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_send_day`
--
ALTER TABLE `w_send_day`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_user`
--
ALTER TABLE `w_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openid` (`openid`),
  ADD KEY `nickname` (`nickname`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `w_admin`
--
ALTER TABLE `w_admin`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `w_liuyan`
--
ALTER TABLE `w_liuyan`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `w_menu_info`
--
ALTER TABLE `w_menu_info`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=31;
--
-- 使用表AUTO_INCREMENT `w_num`
--
ALTER TABLE `w_num`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `w_send_day`
--
ALTER TABLE `w_send_day`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `w_user`
--
ALTER TABLE `w_user`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
