-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 09 月 14 日 17:32
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `single30_egg_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `solution_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `benefit` varchar(300) NOT NULL,
  `drawback` varchar(300) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`comment_id`, `solution_id`, `user_id`, `benefit`, `drawback`, `create_at`, `modify_at`) VALUES
(7, 1, 1, '无', '太贵', '2012-09-14 15:58:19', '2012-09-14 15:58:19'),
(9, 3, 3, '还行', '太便宜', '2012-09-14 15:59:40', '2012-09-14 15:59:40');

-- --------------------------------------------------------

--
-- 表的结构 `solution`
--

CREATE TABLE IF NOT EXISTS `solution` (
  `solution_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(500) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`solution_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `solution`
--

INSERT INTO `solution` (`solution_id`, `subject_id`, `user_id`, `content`, `create_at`, `modify_at`) VALUES
(1, 3, 3, '1000元就差不多了																			', '2012-09-07 17:34:07', '2012-09-07 17:37:44'),
(3, 3, 1, '600元', '2012-09-12 09:51:16', '2012-09-12 09:51:16'),
(4, 3, 5, 'error', '2012-09-12 10:13:47', '2012-09-12 10:13:47');

-- --------------------------------------------------------

--
-- 表的结构 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `close_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `include_judge` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(40) NOT NULL,
  `phase_two_token` varchar(60) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `subject`
--

INSERT INTO `subject` (`subject_id`, `user_id`, `name`, `desc`, `close_datetime`, `include_judge`, `token`, `phase_two_token`, `is_active`, `create_at`, `modify_at`) VALUES
(1, 1, '测试', '说明', '2012-08-05 18:00:00', 1, '', '', 1, '2012-09-05 13:44:09', '2012-09-10 15:00:48'),
(2, 1, '测试风暴的最优流程是怎样的？', '', '2012-08-06 18:00:00', 0, '', '', 0, '2012-09-05 16:00:20', '2012-09-10 17:38:11'),
(3, 1, '应该买多少钱的包包？', '希望自己使用', '2012-09-11 14:00:00', 1, '53d1bd0c1b34d0dfd4c8e', '53d1bd0c1b34d0dfd4c8eI1180dcc091', 1, '2012-09-05 16:04:10', '2012-09-14 15:57:23');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` char(40) CHARACTER SET utf16 NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `email`, `is_active`, `create_at`, `modify_at`) VALUES
(1, 'Richard', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'shadow_wu82@163.com', 1, '2012-09-05 10:33:22', '2012-09-05 10:33:22'),
(3, 'Eric', 'dea742e166979027ae70b28e0a9006fb1010e760', 'shadowwu82@gmail.com', 1, '2012-09-07 16:33:29', '2012-09-07 16:33:29'),
(4, 'heyfay', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'heyfay@qq.com', 1, '2012-09-10 15:01:44', '2012-09-10 15:01:44'),
(5, 'error', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'abc@azy12.com', 1, '2012-09-12 10:13:43', '2012-09-12 10:13:43');
