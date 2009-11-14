/*
MySQL Data Transfer
Source Host: localhost
Source Database: job_management2
Target Host: localhost
Target Database: job_management2
Date: 11/13/2009 8:49:14 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for class_using_process
-- ----------------------------
DROP TABLE IF EXISTS `class_using_process`;
CREATE TABLE `class_using_process` (
  `ObjectClassID` int(10) unsigned default NULL,
  `ProcessID` int(10) unsigned default NULL,
  KEY `FK_REFERENCE_14` (`ObjectClassID`),
  KEY `FK_REFERENCE_15` (`ProcessID`),
  CONSTRAINT `FK_REFERENCE_14` FOREIGN KEY (`ObjectClassID`) REFERENCES `objectclass` (`ObjectClassID`),
  CONSTRAINT `FK_REFERENCE_15` FOREIGN KEY (`ProcessID`) REFERENCES `processes` (`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for field_form
-- ----------------------------
DROP TABLE IF EXISTS `field_form`;
CREATE TABLE `field_form` (
  `FieldID` int(10) unsigned NOT NULL,
  `FormID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`FieldID`,`FormID`),
  KEY `FK_ASSOCIATION_5` (`FormID`),
  CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (`FormID`) REFERENCES `forms` (`FormID`),
  CONSTRAINT `FK_FIELDFORM_FIELD` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldoptions
-- ----------------------------
DROP TABLE IF EXISTS `fieldoptions`;
CREATE TABLE `fieldoptions` (
  `FieldOptionID` int(10) unsigned NOT NULL auto_increment,
  `FieldID` bigint(20) unsigned NOT NULL,
  `OptionName` text character set utf8 NOT NULL,
  PRIMARY KEY  (`FieldOptionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fields
-- ----------------------------
DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `FieldID` int(10) unsigned NOT NULL auto_increment,
  `FieldTypeID` smallint(5) unsigned default NULL,
  `FieldName` text character set utf8 NOT NULL,
  `ValidationRules` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldtype
-- ----------------------------
DROP TABLE IF EXISTS `fieldtype`;
CREATE TABLE `fieldtype` (
  `FieldTypeID` smallint(5) unsigned NOT NULL auto_increment,
  `FieldTypeName` varchar(40) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`FieldTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldvalues
-- ----------------------------
DROP TABLE IF EXISTS `fieldvalues`;
CREATE TABLE `fieldvalues` (
  `FieldValueID` bigint(20) unsigned NOT NULL auto_increment,
  `FieldID` int(10) unsigned NOT NULL,
  `ObjectID` bigint(20) default NULL,
  `FieldValue` text character set utf8 NOT NULL,
  PRIMARY KEY  (`FieldValueID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for form_process
-- ----------------------------
DROP TABLE IF EXISTS `form_process`;
CREATE TABLE `form_process` (
  `FormID` int(10) unsigned NOT NULL,
  `ProcessID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`FormID`,`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for forms
-- ----------------------------
DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
  `FormID` int(10) unsigned NOT NULL auto_increment,
  `FormName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`FormID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) character set utf8 NOT NULL,
  `description` varchar(100) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for language
-- ----------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `LanguageID` bigint(20) unsigned NOT NULL auto_increment,
  `TableName` varchar(50) collate utf8_unicode_ci NOT NULL,
  `TableKey` bigint(20) unsigned NOT NULL,
  `Meaning` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for meta
-- ----------------------------
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for object_ext_info
-- ----------------------------
DROP TABLE IF EXISTS `object_ext_info`;
CREATE TABLE `object_ext_info` (
  `ObjectID` bigint(20) unsigned NOT NULL,
  `Name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ObjectID`,`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for objectclass
-- ----------------------------
DROP TABLE IF EXISTS `objectclass`;
CREATE TABLE `objectclass` (
  `ObjectClassID` int(10) unsigned NOT NULL auto_increment,
  `ObjectClassName` varchar(500) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ObjectClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for objecthtmlcaches
-- ----------------------------
DROP TABLE IF EXISTS `objecthtmlcaches`;
CREATE TABLE `objecthtmlcaches` (
  `cacheID` bigint(20) unsigned NOT NULL auto_increment,
  `objectClass` int(11) NOT NULL,
  `objectPK` bigint(20) NOT NULL,
  `cacheContent` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cacheID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for objects
-- ----------------------------
DROP TABLE IF EXISTS `objects`;
CREATE TABLE `objects` (
  `ObjectID` bigint(20) unsigned NOT NULL auto_increment,
  `ObjectPrefixKey` varchar(30) collate utf8_unicode_ci NOT NULL,
  `ObjectClassID` int(11) NOT NULL,
  `ObjectRefKey` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`ObjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for processes
-- ----------------------------
DROP TABLE IF EXISTS `processes`;
CREATE TABLE `processes` (
  `ProcessID` int(10) unsigned NOT NULL auto_increment,
  `ProcessName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ProcessID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(40) collate utf8_unicode_ci NOT NULL default '0',
  `ip_address` varchar(16) collate utf8_unicode_ci NOT NULL default '0',
  `user_agent` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) character set utf8 NOT NULL,
  `username` varchar(15) character set utf8 NOT NULL,
  `password` varchar(40) character set utf8 NOT NULL,
  `email` varchar(40) character set utf8 NOT NULL,
  `activation_code` varchar(40) character set utf8 NOT NULL default '0',
  `forgotten_password_code` varchar(40) character set utf8 NOT NULL default '0',
  `data_of_birth` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `forms` VALUES ('1', 'form1', 'des of form1');
INSERT INTO `forms` VALUES ('2', 'form2', 'des of form2');
INSERT INTO `forms` VALUES ('3', 'form3', 'des of form 3');
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` VALUES ('2', 'operator', 'Operator');
INSERT INTO `groups` VALUES ('3', 'user', 'User');
INSERT INTO `meta` VALUES ('1', '2', 'Trieu', 'Nguyen tan');
INSERT INTO `meta` VALUES ('2', '3', 'Trieu', 'Nguyen');
INSERT INTO `objecthtmlcaches` VALUES ('1', '0', '1', '');
INSERT INTO `processes` VALUES ('1', 'test1', 'test1 des 123');
INSERT INTO `processes` VALUES ('2', 'test2', 'test2 Description1');
INSERT INTO `users` VALUES ('1', '3', '127.0.0.1', 'trieu', '1362627da60f8abd4176aaf7b3f02f69bca5515a', 'tantrieuf31@gmail.com', '0', '892163d6e309f3f2b66f4986fb49bb8d33f37b27', '0');
INSERT INTO `users` VALUES ('2', '2', '127.0.0.1', 'trieunguyen', '28501bb04bd8255bf26ea1f2069511731b404d35', 'trieunguyen@yopco.com', '0', '0', '0');
INSERT INTO `users` VALUES ('3', '1', '127.0.0.1', 'trieu_drd', '0f376afb66926ffb0f4604223fd83d537b64c415', 'trieu@drdvietnam.com', '0', '0', '0');
