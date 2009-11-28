-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.37


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema job_management
--

CREATE DATABASE IF NOT EXISTS job_management;
USE job_management;

--
-- Definition of table `job_management`.`class_using_process`
--

DROP TABLE IF EXISTS `job_management`.`class_using_process`;
CREATE TABLE  `job_management`.`class_using_process` (
  `ObjectClassID` int(10) unsigned DEFAULT NULL,
  `ProcessID` int(10) unsigned DEFAULT NULL,
  KEY `FK_REFERENCE_14` (`ObjectClassID`),
  KEY `FK_REFERENCE_15` (`ProcessID`),
  CONSTRAINT `FK_REFERENCE_14` FOREIGN KEY (`ObjectClassID`) REFERENCES `objectclass` (`ObjectClassID`),
  CONSTRAINT `FK_REFERENCE_15` FOREIGN KEY (`ProcessID`) REFERENCES `processes` (`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`class_using_process`
--

/*!40000 ALTER TABLE `class_using_process` DISABLE KEYS */;
LOCK TABLES `class_using_process` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `class_using_process` ENABLE KEYS */;


--
-- Definition of table `job_management`.`field_form`
--

DROP TABLE IF EXISTS `job_management`.`field_form`;
CREATE TABLE  `job_management`.`field_form` (
  `FieldID` int(10) unsigned NOT NULL,
  `FormID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`FieldID`,`FormID`),
  KEY `FK_ASSOCIATION_5` (`FormID`),
  CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (`FormID`) REFERENCES `forms` (`FormID`),
  CONSTRAINT `FK_FIELDFORM_FIELD` FOREIGN KEY (`FieldID`) REFERENCES `fields` (`FieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`field_form`
--

/*!40000 ALTER TABLE `field_form` DISABLE KEYS */;
LOCK TABLES `field_form` WRITE;
INSERT INTO `job_management`.`field_form` VALUES  (8,1),
 (9,1),
 (10,1),
 (11,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `field_form` ENABLE KEYS */;


--
-- Definition of table `job_management`.`fieldoptions`
--

DROP TABLE IF EXISTS `job_management`.`fieldoptions`;
CREATE TABLE  `job_management`.`fieldoptions` (
  `FieldOptionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FieldID` bigint(20) unsigned NOT NULL,
  `OptionName` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`FieldOptionID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`fieldoptions`
--

/*!40000 ALTER TABLE `fieldoptions` DISABLE KEYS */;
LOCK TABLES `fieldoptions` WRITE;
INSERT INTO `job_management`.`fieldoptions` VALUES  (1,1,'aaaa'),
 (2,1,'bbb'),
 (3,4,'16 - 25'),
 (4,4,'26 - 35'),
 (5,4,'36 - 45'),
 (6,4,'46 - 55'),
 (7,4,'56 - 65'),
 (8,4,'65+'),
 (9,0,'1-10'),
 (10,0,'11-20'),
 (11,9,'10-20'),
 (12,9,'21-30'),
 (13,0,'aa'),
 (14,10,'fsdffsfs'),
 (15,11,'a'),
 (16,11,'b');
UNLOCK TABLES;
/*!40000 ALTER TABLE `fieldoptions` ENABLE KEYS */;


--
-- Definition of table `job_management`.`fields`
--

DROP TABLE IF EXISTS `job_management`.`fields`;
CREATE TABLE  `job_management`.`fields` (
  `FieldID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FieldTypeID` smallint(5) unsigned DEFAULT NULL,
  `FieldName` text CHARACTER SET utf8 NOT NULL,
  `ValidationRules` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`FieldID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`fields`
--

/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
LOCK TABLES `fields` WRITE;
INSERT INTO `job_management`.`fields` VALUES  (1,4,'field 1 ext','required'),
 (2,2,'field 2',''),
 (3,3,'Ngay sinh',''),
 (4,4,'Tuổi/Age',''),
 (5,1,'aaa',''),
 (6,1,'Job Seeker Name',''),
 (7,4,'What is your Age ?',''),
 (8,1,'Name',''),
 (9,4,'What is your Age ?',''),
 (10,4,'aaaa',''),
 (11,7,'chexcxvbox','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;


--
-- Definition of table `job_management`.`fieldtype`
--

DROP TABLE IF EXISTS `job_management`.`fieldtype`;
CREATE TABLE  `job_management`.`fieldtype` (
  `FieldTypeID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `FieldTypeName` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`FieldTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`fieldtype`
--

/*!40000 ALTER TABLE `fieldtype` DISABLE KEYS */;
LOCK TABLES `fieldtype` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `fieldtype` ENABLE KEYS */;


--
-- Definition of table `job_management`.`fieldvalues`
--

DROP TABLE IF EXISTS `job_management`.`fieldvalues`;
CREATE TABLE  `job_management`.`fieldvalues` (
  `FieldValueID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FieldID` int(10) unsigned NOT NULL,
  `ObjectID` bigint(20) DEFAULT NULL,
  `FieldValue` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`FieldValueID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`fieldvalues`
--

/*!40000 ALTER TABLE `fieldvalues` DISABLE KEYS */;
LOCK TABLES `fieldvalues` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `fieldvalues` ENABLE KEYS */;


--
-- Definition of table `job_management`.`form_process`
--

DROP TABLE IF EXISTS `job_management`.`form_process`;
CREATE TABLE  `job_management`.`form_process` (
  `FormID` int(10) unsigned NOT NULL,
  `ProcessID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`FormID`,`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`form_process`
--

/*!40000 ALTER TABLE `form_process` DISABLE KEYS */;
LOCK TABLES `form_process` WRITE;
INSERT INTO `job_management`.`form_process` VALUES  (1,2),
 (4,3),
 (5,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `form_process` ENABLE KEYS */;


--
-- Definition of table `job_management`.`forms`
--

DROP TABLE IF EXISTS `job_management`.`forms`;
CREATE TABLE  `job_management`.`forms` (
  `FormID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FormName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`FormID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`forms`
--

/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
LOCK TABLES `forms` WRITE;
INSERT INTO `job_management`.`forms` VALUES  (1,'PERSONAL INFORMATION','for Job Seeker'),
 (2,'YOUR DISABILITY','for Job Seeker'),
 (3,'EDUCATION','for Job Seeker'),
 (4,'YOUR SKILLS & INTERESTS','for Job Seeker'),
 (5,'Employment details','for Job Seeker'),
 (6,'3 MONTH FOLLOW UP','for Job Seeker'),
 (7,'6  MONTH FOLLOW UP','for Job Seeker'),
 (8,'12  MONTH FOLLOW UP','for Job Seeker'),
 (9,'EMPLOYER CONTACT DETAILS','for Employer'),
 (10,'Reasonable Accomodation','for Employer'),
 (11,'Education','for Employer'),
 (12,'Skills and Support','for Employer'),
 (13,'Employment','for Employer'),
 (14,'3 MONTH FOLLOW UP','for Employer'),
 (15,'6  MONTH FOLLOW UP','for Employer'),
 (16,'12  MONTH FOLLOW UP','for Employer'),
 (17,'Employer Feedback','for Employer');
UNLOCK TABLES;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;


--
-- Definition of table `job_management`.`groups`
--

DROP TABLE IF EXISTS `job_management`.`groups`;
CREATE TABLE  `job_management`.`groups` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`groups`
--

/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
LOCK TABLES `groups` WRITE;
INSERT INTO `job_management`.`groups` VALUES  (1,'admin','Administrator'),
 (2,'operator','Operator'),
 (3,'user','User');
UNLOCK TABLES;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


--
-- Definition of table `job_management`.`language`
--

DROP TABLE IF EXISTS `job_management`.`language`;
CREATE TABLE  `job_management`.`language` (
  `LanguageID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `TableName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `TableKey` bigint(20) unsigned NOT NULL,
  `Meaning` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`language`
--

/*!40000 ALTER TABLE `language` DISABLE KEYS */;
LOCK TABLES `language` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `language` ENABLE KEYS */;


--
-- Definition of table `job_management`.`meta`
--

DROP TABLE IF EXISTS `job_management`.`meta`;
CREATE TABLE  `job_management`.`meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`meta`
--

/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
LOCK TABLES `meta` WRITE;
INSERT INTO `job_management`.`meta` VALUES  (1,2,'Trieu','Nguyen tan'),
 (2,3,'Trieu','Nguyen');
UNLOCK TABLES;
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;


--
-- Definition of table `job_management`.`object_ext_info`
--

DROP TABLE IF EXISTS `job_management`.`object_ext_info`;
CREATE TABLE  `job_management`.`object_ext_info` (
  `ObjectID` bigint(20) unsigned NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ObjectID`,`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`object_ext_info`
--

/*!40000 ALTER TABLE `object_ext_info` DISABLE KEYS */;
LOCK TABLES `object_ext_info` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `object_ext_info` ENABLE KEYS */;


--
-- Definition of table `job_management`.`objectclass`
--

DROP TABLE IF EXISTS `job_management`.`objectclass`;
CREATE TABLE  `job_management`.`objectclass` (
  `ObjectClassID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ObjectClassName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ObjectClassID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`objectclass`
--

/*!40000 ALTER TABLE `objectclass` DISABLE KEYS */;
LOCK TABLES `objectclass` WRITE;
INSERT INTO `job_management`.`objectclass` VALUES  (1,'Job Seeker','Nguoi tim viec '),
 (2,'Employers','Nha tuyen dung'),
 (3,'Job Coach','The person who helps the job seeker');
UNLOCK TABLES;
/*!40000 ALTER TABLE `objectclass` ENABLE KEYS */;


--
-- Definition of table `job_management`.`objecthtmlcaches`
--

DROP TABLE IF EXISTS `job_management`.`objecthtmlcaches`;
CREATE TABLE  `job_management`.`objecthtmlcaches` (
  `cacheID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `objectClass` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `objectPK` bigint(20) unsigned NOT NULL DEFAULT '0',
  `cacheContent` text COLLATE utf8_unicode_ci NOT NULL,
  `javascriptContent` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cacheID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`objecthtmlcaches`
--

/*!40000 ALTER TABLE `objecthtmlcaches` DISABLE KEYS */;
LOCK TABLES `objecthtmlcaches` WRITE;
INSERT INTO `job_management`.`objecthtmlcaches` VALUES  (2,'form_',1,'','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `objecthtmlcaches` ENABLE KEYS */;


--
-- Definition of table `job_management`.`objects`
--

DROP TABLE IF EXISTS `job_management`.`objects`;
CREATE TABLE  `job_management`.`objects` (
  `ObjectID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ObjectPrefixKey` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ObjectClassID` int(11) NOT NULL,
  `ObjectRefKey` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ObjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`objects`
--

/*!40000 ALTER TABLE `objects` DISABLE KEYS */;
LOCK TABLES `objects` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `objects` ENABLE KEYS */;


--
-- Definition of table `job_management`.`processes`
--

DROP TABLE IF EXISTS `job_management`.`processes`;
CREATE TABLE  `job_management`.`processes` (
  `ProcessID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProcessName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ProcessID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`processes`
--

/*!40000 ALTER TABLE `processes` DISABLE KEYS */;
LOCK TABLES `processes` WRITE;
INSERT INTO `job_management`.`processes` VALUES  (1,'Posting a job profile for Job Seeker','test1 des'),
 (2,'Manage Personal Job Seeker Information ','test2 Description1'),
 (3,'Tracking Job Seeker','Tranking Job seeker by a job coach'),
 (4,'Posting Employer Contact Details','This is used by DRD staff'),
 (5,'Posting a job requirements','This process can be used multiple times.'),
 (6,'Tracking Employer','This process is used to manage feedbacks of employer');
UNLOCK TABLES;
/*!40000 ALTER TABLE `processes` ENABLE KEYS */;


--
-- Definition of table `job_management`.`sessions`
--

DROP TABLE IF EXISTS `job_management`.`sessions`;
CREATE TABLE  `job_management`.`sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
LOCK TABLES `sessions` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;


--
-- Definition of table `job_management`.`users`
--

DROP TABLE IF EXISTS `job_management`.`users`;
CREATE TABLE  `job_management`.`users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) CHARACTER SET utf8 NOT NULL,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `activation_code` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `forgotten_password_code` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `data_of_birth` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_management`.`users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
LOCK TABLES `users` WRITE;
INSERT INTO `job_management`.`users` VALUES  (1,3,'127.0.0.1','trieu','1362627da60f8abd4176aaf7b3f02f69bca5515a','tantrieuf31@gmail.com','0','892163d6e309f3f2b66f4986fb49bb8d33f37b27',0),
 (2,2,'127.0.0.1','trieunguyen','28501bb04bd8255bf26ea1f2069511731b404d35','trieunguyen@yopco.com','0','0',0),
 (3,1,'127.0.0.1','trieu_drd','0f376afb66926ffb0f4604223fd83d537b64c415','trieu@drdvietnam.com','0','0',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
