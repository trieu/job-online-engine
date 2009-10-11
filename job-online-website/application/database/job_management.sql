/*
MySQL Data Transfer
Source Host: localhost
Source Database: job_management
Target Host: localhost
Target Database: job_management
Date: 8/30/2009 1:13:44 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for meta
-- ----------------------------
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `activation_code` varchar(40) NOT NULL default '0',
  `forgotten_password_code` varchar(40) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `groups` VALUES ('2', 'operator', 'Nhan vien van hanh he thong');
INSERT INTO `groups` VALUES ('3', 'customer', 'Khach hang');
INSERT INTO `groups` VALUES ('1', 'admin', 'admin');
INSERT INTO `meta` VALUES ('1', '2', 'Trieu', 'Nguyen tan');
INSERT INTO `meta` VALUES ('2', '3', 'Trieu', 'Nguyen');
INSERT INTO `users` VALUES ('1', '1', '127.0.0.1', 'trieu', '1362627da60f8abd4176aaf7b3f02f69bca5515a', 'tantrieuf31@gmail.com', '', '892163d6e309f3f2b66f4986fb49bb8d33f37b27');
INSERT INTO `users` VALUES ('2', '3', '127.0.0.1', 'trieunguyen', '28501bb04bd8255bf26ea1f2069511731b404d35', 'trieunguyen@yopco.com', '', '0');
INSERT INTO `users` VALUES ('3', '3', '127.0.0.1', 'trieu_drd', '0f376afb66926ffb0f4604223fd83d537b64c415', 'trieu@drdvietnam.com', '', '0');
