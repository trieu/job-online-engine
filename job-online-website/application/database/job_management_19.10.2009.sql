/*
MySQL Data Transfer
Source Host: localhost
Source Database: job_management
Target Host: localhost
Target Database: job_management
Date: 10/19/2009 9:31:06 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for field_form
-- ----------------------------
DROP TABLE IF EXISTS `Field_Form`;
CREATE TABLE `field_form` (
  `FieldID` bigint(20) unsigned NOT NULL,
  `FormID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`FieldID`,`FormID`),
  KEY `FK_ASSOCIATION_5` (`FormID`),
  CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (`FormID`) REFERENCES `forms` (`FormID`),
  CONSTRAINT `FK_FIELDFORM_FIELD` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldoptions
-- ----------------------------
DROP TABLE IF EXISTS `FieldOptions`;
CREATE TABLE `fieldoptions` (
  `FieldOptionID` bigint(20) unsigned NOT NULL auto_increment,
  `FieldID` bigint(20) unsigned NOT NULL,
  `OptionName` text character set utf8 NOT NULL,
  PRIMARY KEY  (`FieldOptionID`),
  KEY `FK_FIELD_FIELDOPTION` (`FieldID`),
  CONSTRAINT `FK_FIELD_FIELDOPTION` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fields
-- ----------------------------
DROP TABLE IF EXISTS `Fields`;
CREATE TABLE `fields` (
  `FieldID` bigint(20) unsigned NOT NULL auto_increment,
  `ObjectID` int(10) unsigned NOT NULL,
  `FieldTypeID` smallint(5) unsigned NOT NULL,
  `FieldName` text character set utf8 NOT NULL,
  `ValidationRules` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`FieldID`),
  KEY `FK_FIELD_OBJECT` (`ObjectID`),
  KEY `FIELD_NAME` (`FieldName`(255)),
  CONSTRAINT `FK_FIELD_OBJECT` FOREIGN KEY (`ObjectID`) REFERENCES `objects` (`ObjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldtype
-- ----------------------------
DROP TABLE IF EXISTS `FieldType`;
CREATE TABLE `fieldtype` (
  `FieldTypeID` smallint(5) unsigned NOT NULL auto_increment,
  `FieldTypeName` varchar(40) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`FieldTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for fieldvalues
-- ----------------------------
DROP TABLE IF EXISTS `FieldValues`;
CREATE TABLE `fieldvalues` (
  `FieldValueID` bigint(20) unsigned NOT NULL auto_increment,
  `FieldID` bigint(20) unsigned NOT NULL,
  `FieldValue` text character set utf8 NOT NULL,
  PRIMARY KEY  (`FieldValueID`),
  KEY `FK_FIELDVALUE_FIELD` (`FieldID`),
  CONSTRAINT `FK_FIELDVALUE_FIELD` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for form_process
-- ----------------------------
DROP TABLE IF EXISTS `Form_Process`;
CREATE TABLE `form_process` (
  `FormID` bigint(20) unsigned NOT NULL,
  `ProcessID` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`FormID`,`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for forms
-- ----------------------------
DROP TABLE IF EXISTS `Forms`;
CREATE TABLE `forms` (
  `FormID` bigint(20) unsigned NOT NULL auto_increment,
  `FormName` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`FormID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Table structure for objectclass
-- ----------------------------
DROP TABLE IF EXISTS `ObjectClass`;
CREATE TABLE `objectclass` (
  `ObjectClassID` int(11) NOT NULL,
  `ObjectClassName` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ObjectClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for objecthtmlcaches
-- ----------------------------
DROP TABLE IF EXISTS `ObjectHtmlCaches`;
CREATE TABLE `objecthtmlcaches` (
  `cacheID` bigint(20) unsigned NOT NULL auto_increment,
  `objectClass` varchar(100) collate utf8_unicode_ci NOT NULL,
  `objectPK` bigint(20) NOT NULL,
  `cacheContent` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cacheID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for objects
-- ----------------------------
DROP TABLE IF EXISTS `Objects`;
CREATE TABLE `objects` (
  `ObjectID` int(10) unsigned NOT NULL auto_increment,
  `ObjectName` varchar(500) collate utf8_unicode_ci NOT NULL,
  `ObjectPrefixKey` varchar(30) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ObjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for processes
-- ----------------------------
DROP TABLE IF EXISTS `Processes`;
CREATE TABLE `processes` (
  `ProcessID` bigint(20) unsigned NOT NULL auto_increment,
  `GroupID` tinyint(3) unsigned default NULL,
  `ProcessName` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ProcessID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `ObjectID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `field_form` VALUES ('1', '1');
INSERT INTO `field_form` VALUES ('2', '1');
INSERT INTO `field_form` VALUES ('4', '1');
INSERT INTO `field_form` VALUES ('5', '1');
INSERT INTO `field_form` VALUES ('6', '1');
INSERT INTO `field_form` VALUES ('7', '1');
INSERT INTO `field_form` VALUES ('8', '1');
INSERT INTO `field_form` VALUES ('10', '1');
INSERT INTO `field_form` VALUES ('1', '2');
INSERT INTO `field_form` VALUES ('2', '2');
INSERT INTO `field_form` VALUES ('4', '2');
INSERT INTO `field_form` VALUES ('5', '2');
INSERT INTO `field_form` VALUES ('6', '2');
INSERT INTO `field_form` VALUES ('7', '2');
INSERT INTO `field_form` VALUES ('9', '2');
INSERT INTO `field_form` VALUES ('7', '6');
INSERT INTO `fields` VALUES ('1', '1', '1', 'Name', '');
INSERT INTO `fields` VALUES ('2', '1', '1', 'Address 1', '');
INSERT INTO `fields` VALUES ('3', '1', '5', 'Date of birth', '');
INSERT INTO `fields` VALUES ('4', '1', '2', 'What is your Age', '');
INSERT INTO `fields` VALUES ('5', '1', '1', 'Mobile number 1', '');
INSERT INTO `fields` VALUES ('6', '1', '1', 'Mobile number 2', '');
INSERT INTO `fields` VALUES ('7', '1', '1', 'E Mail', '');
INSERT INTO `fields` VALUES ('8', '1', '1', 'Repeat E Mail', '');
INSERT INTO `fields` VALUES ('9', '1', '1', 'Address 2', '');
INSERT INTO `fields` VALUES ('10', '1', '1', 'A lambda expression is in ‘normal form’ if no sub-expression can be reduced. A lambda expression is in ‘head normal form’ if the outermost application cannot be reduced. Some expressions do not have a normal form as reduction never terminates. Lambda calculus has the ‘Church-Rosser property’, so that if two methods of reduction lead to two normal forms, they can differ only by alpha conversion.', '');
INSERT INTO `fieldtype` VALUES ('1', 'Text Box');
INSERT INTO `fieldtype` VALUES ('2', 'Select Box');
INSERT INTO `fieldtype` VALUES ('3', 'Multi Select Box');
INSERT INTO `fieldtype` VALUES ('4', 'Radio Button');
INSERT INTO `fieldtype` VALUES ('5', 'Date Chooser');
INSERT INTO `fieldtype` VALUES ('6', 'Check Box');
INSERT INTO `form_process` VALUES ('1', '6');
INSERT INTO `form_process` VALUES ('2', '7');
INSERT INTO `form_process` VALUES ('3', '7');
INSERT INTO `form_process` VALUES ('4', '7');
INSERT INTO `form_process` VALUES ('5', '7');
INSERT INTO `form_process` VALUES ('6', '8');
INSERT INTO `form_process` VALUES ('7', '8');
INSERT INTO `form_process` VALUES ('8', '8');
INSERT INTO `forms` VALUES ('1', 'PERSONAL INFORMATION');
INSERT INTO `forms` VALUES ('2', 'YOUR DISABILITY');
INSERT INTO `forms` VALUES ('3', 'EDUCATION');
INSERT INTO `forms` VALUES ('4', 'YOUR SKILLS & INTERESTS');
INSERT INTO `forms` VALUES ('5', 'Employment details');
INSERT INTO `forms` VALUES ('6', '3 MONTH FOLLOW UP');
INSERT INTO `forms` VALUES ('7', '6  MONTH FOLLOW UP');
INSERT INTO `forms` VALUES ('8', '12  MONTH FOLLOW UP');
INSERT INTO `groups` VALUES ('2', 'operator', 'Operator');
INSERT INTO `groups` VALUES ('3', 'user', 'User');
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `meta` VALUES ('1', '2', 'Trieu', 'Nguyen tan');
INSERT INTO `meta` VALUES ('2', '3', 'Trieu', 'Nguyen');
INSERT INTO `objecthtmlcaches` VALUES ('5', 'form_', '1', '<div><label for=\"field_1\" class=\"\" style=\"color: rgb(0, 0, 0);\">Name</label>&lt;input name=\"Name\" value=\"\" id=\"field_1\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_7\" class=\"\" style=\"color: rgb(0, 0, 0);\">E Mail</label>&lt;input name=\"E Mail\" value=\"\" id=\"field_7\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_8\" class=\"\" style=\"color: rgb(0, 0, 0);\">Repeat E Mail</label>&lt;input name=\"Repeat E Mail\" value=\"\" id=\"field_8\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_6\" class=\"\" style=\"color: rgb(0, 0, 0);\">Mobile number 2</label>&lt;input name=\"Mobile number 2\" value=\"\" id=\"field_6\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_4\" class=\"\" style=\"color: rgb(0, 0, 0);\">What is your Age</label><select name=\"field_4\" id=\"field_4\">\n</select></div>\n<div><label for=\"field_10\" class=\"\" style=\"color: rgb(0, 0, 0);\">A lambda expression is in ‘normal form’ if no sub-expression can be reduced. A lambda expression is in ‘head normal form’ if the outermost application cannot be reduced. Some expressions do not have a normal form as reduction never terminates. Lambda calculus has the ‘Church-Rosser property’, so that if two methods of reduction lead to two normal forms, they can differ only by alpha conversion.</label>&lt;input name=\"A lambda expression is in ‘normal form’ if no sub-expression can be reduced. A lambda expression is in ‘head normal form’ if the outermost application cannot be reduced. Some expressions do not have a normal form as reduction never terminates. Lambda calculus has the ‘Church-Rosser property’, so that if two methods of reduction lead to two normal forms, they can differ only by alpha conversion.\" value=\"\" id=\"field_10\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div>');
INSERT INTO `objecthtmlcaches` VALUES ('7', 'form_', '2', '<div><label for=\"field_1\" class=\"\" style=\"color: rgb(0, 0, 0);\">Name</label>&lt;input name=\"Name\" value=\"\" id=\"field_1\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_2\" class=\"\" style=\"color: rgb(0, 0, 0);\">Address 1</label>&lt;input name=\"Address 1\" value=\"\" id=\"field_2\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div>\n<div><label for=\"field_4\" class=\"\" style=\"color: rgb(0, 0, 0);\">What is your Age</label><select name=\"field_4\" id=\"field_4\">\n</select></div><div><label for=\"field_7\" class=\"\" style=\"color: rgb(0, 0, 0);\">E Mail</label>&lt;input name=\"E Mail\" value=\"\" id=\"field_7\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div>\n<div><label for=\"field_9\" class=\"\" style=\"color: rgb(0, 0, 0);\">Address 2</label>&lt;input name=\"Address 2\" value=\"\" id=\"field_9\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_5\" class=\"\" style=\"color: rgb(0, 0, 0);\">Mobile number 1</label>&lt;input name=\"Mobile number 1\" value=\"\" id=\"field_5\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_6\" class=\"\" style=\"color: rgb(0, 0, 0);\">Mobile number 2</label>&lt;input name=\"Mobile number 2\" value=\"\" id=\"field_6\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div>');
INSERT INTO `objecthtmlcaches` VALUES ('6', 'form_', '6', '<div><label for=\"field_1\" class=\"\" style=\"color: rgb(0, 0, 0);\">Name</label>&lt;input name=\"Name\" value=\"\" id=\"field_1\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_2\" class=\"\" style=\"color: rgb(0, 0, 0);\">Address 1</label>&lt;input name=\"Address 1\" value=\"\" id=\"field_2\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div><div><label for=\"field_5\" class=\"\" style=\"color: rgb(0, 0, 0);\">Mobile number 1</label>&lt;input name=\"Mobile number 1\" value=\"\" id=\"field_5\" maxlength=\"100\" size=\"50\" style=\"width: 50%;\" type=\"text\"&gt;&lt;/div>\n<div><label for=\"field_7\" class=\"\" style=\"color: #000;\">E Mail</label>&lt;input type=\"text\" name=\"E Mail\" value=\"\" id=\"field_7\" maxlength=\"100\" size=\"50\" style=\"width:50%\"&gt;&lt;/div>');
INSERT INTO `objects` VALUES ('1', 'Job Seeker', 'js');
INSERT INTO `objects` VALUES ('2', 'Employer', 'em');
INSERT INTO `processes` VALUES ('1', '1', 'Tao cau hoi');
INSERT INTO `processes` VALUES ('2', '3', 'Thống kê');
INSERT INTO `processes` VALUES ('3', '3', 'Kiểm thứ 1fdffdsf');
INSERT INTO `processes` VALUES ('4', '3', ' The Lambda Calculus was developed by Alonzo Church in the 1930s and published in 1941 as ‘The Calculi Of Lambda Conversion’.');
INSERT INTO `processes` VALUES ('5', '3', 'test\ntest');
INSERT INTO `processes` VALUES ('6', '3', 'Create account');
INSERT INTO `processes` VALUES ('7', '2', 'Post a Job Seeker\'s profile');
INSERT INTO `processes` VALUES ('8', '2', 'Job Tracking');
INSERT INTO `users` VALUES ('1', '1', '127.0.0.1', 'trieu', '1362627da60f8abd4176aaf7b3f02f69bca5515a', 'tantrieuf31@gmail.com', '', '892163d6e309f3f2b66f4986fb49bb8d33f37b27', '0');
INSERT INTO `users` VALUES ('2', '3', '127.0.0.1', 'trieunguyen', '28501bb04bd8255bf26ea1f2069511731b404d35', 'trieunguyen@yopco.com', '', '0', '0');
INSERT INTO `users` VALUES ('3', '1', '127.0.0.1', 'trieu_drd', '0f376afb66926ffb0f4604223fd83d537b64c415', 'trieu@drdvietnam.com', '', '0', '0');
