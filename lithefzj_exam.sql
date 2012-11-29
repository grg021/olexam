-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2012 at 07:47 AM
-- Server version: 5.0.95
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lithefzj_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` bigint(20) NOT NULL auto_increment,
  `description` varchar(50) default NULL,
  `link` varchar(100) default NULL,
  `category_id` int(10) default NULL,
  `group` int(10) default NULL,
  `icon` varchar(50) default NULL,
  `order` int(10) default NULL,
  `is_public` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `description`, `link`, `category_id`, `group`, `icon`, `order`, `is_public`) VALUES
(1, 'User Matrix', 'userMatrix', 1, NULL, NULL, NULL, 0),
(2, 'User Administration', 'userMatrix/administration', 1, NULL, NULL, NULL, 0),
(3, 'Change Password', NULL, 2, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_category`
--

CREATE TABLE IF NOT EXISTS `module_category` (
  `id` bigint(20) NOT NULL auto_increment,
  `description` varchar(50) default NULL,
  `icon` varchar(50) default NULL,
  `order` int(10) default NULL,
  `is_public` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_category`
--

INSERT INTO `module_category` (`id`, `description`, `icon`, `order`, `is_public`) VALUES
(1, 'USER MATRIX', '/images/icons2/hammer_screwdriver.png', NULL, 0),
(2, 'MY ACCOUNT', '/images/icons/user.png', NULL, 1),
(3, 'FACILITIES', '/images/icons/package.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_group`
--

CREATE TABLE IF NOT EXISTS `module_group` (
  `id` bigint(20) NOT NULL auto_increment,
  `description` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `module_group`
--

INSERT INTO `module_group` (`id`, `description`) VALUES
(1, 'Super User'),
(2, 'Student'),
(3, 'Pmms.staff');

-- --------------------------------------------------------

--
-- Table structure for table `module_group_access`
--

CREATE TABLE IF NOT EXISTS `module_group_access` (
  `id` bigint(20) NOT NULL auto_increment,
  `group_id` int(20) default NULL,
  `module_id` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `module_group_access`
--

INSERT INTO `module_group_access` (`id`, `group_id`, `module_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 4),
(5, 1, 5),
(6, 3, 5),
(7, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `module_group_users`
--

CREATE TABLE IF NOT EXISTS `module_group_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `username` varchar(100) default NULL,
  `group_id` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `module_group_users`
--

INSERT INTO `module_group_users` (`id`, `user_id`, `username`, `group_id`) VALUES
(1, 1, 'darryl.anaud', 1),
(2, NULL, 'richard.base', 1),
(3, NULL, 'maribeth.rivas', 1),
(4, NULL, 'niz.nolasco', 1),
(5, NULL, 'apple.aala', 2),
(6, NULL, 'test.admin', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` char(40) default NULL,
  `user_type_code` varchar(10) default NULL,
  `STUDCODE` int(11) default NULL,
  `STUDIDNO` char(10) default NULL,
  `ADVICODE` int(11) default NULL,
  `ADVIIDNO` char(10) default NULL,
  `PARECODE` int(11) default NULL,
  `PAREIDNO` char(10) default NULL,
  `dmodified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `modified_by` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `user_type_code`, `STUDCODE`, `STUDIDNO`, `ADVICODE`, `ADVIIDNO`, `PARECODE`, `PAREIDNO`, `dmodified`, `modified_by`) VALUES
(1, 'darryl.anaud', '916cb67aa119d20627f839ad29a5068bbee2ca83', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-05-01 01:19:07', NULL),
(2, 'richard.base', 'cee8da72db7d001cb40ae3314887380cc4a6882e', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-05-02 08:52:53', NULL),
(3, 'maribeth.rivas', '1409957c57942079d4139f6c8cdf647d4b32cfc2', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-05-02 08:52:31', NULL),
(5, 'niz.nolasco', '37e5c9b2528b6c6e8fc4da450626efd0d77f669f', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-05-02 08:52:43', NULL),
(12, 'apple.aala', '85ecc3653e1fbee400eefba07b9adc2d7b79e62e', NULL, 'STUD', 287, '3F7N010259', NULL, NULL, NULL, NULL, '2012-05-03 22:30:28', NULL),
(13, 'test.admin', '14fb1e49a92d35e952854a9f4a9740252025b0d5', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-07-30 18:25:20', NULL),
(14, 'greg', '62fd1ecd141171aa41a7b0986c83882b3e3bb743', NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2012-11-29 13:47:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE IF NOT EXISTS `tbl_user_type` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(10) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`id`, `code`, `description`) VALUES
(1, 'ADMIN', 'Administrator'),
(2, 'FACU', 'Faculty'),
(3, 'STUD', 'Student'),
(4, 'PRNT', 'Parent');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
