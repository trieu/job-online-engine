# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.0.51b-community
# Server OS:                    Win32
# HeidiSQL version:             5.1.0.3590
# Date/time:                    2011-02-01 10:56:46
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for hoangnhan2db
DROP DATABASE IF EXISTS `hoangnhan2db`;
CREATE DATABASE IF NOT EXISTS `hoangnhan2db` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `hoangnhan2db`;


# Dumping structure for table hoangnhan2db.class_relationship
DROP TABLE IF EXISTS `class_relationship`;
CREATE TABLE IF NOT EXISTS `class_relationship` (
  `ObjectClassSelfID` int(10) unsigned NOT NULL,
  `ObjectClassOtherID` int(10) unsigned NOT NULL,
  `ConstraintType` varchar(5) collate utf8_unicode_ci default NULL,
  `Explanation` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ObjectClassSelfID`,`ObjectClassOtherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.class_using_process
DROP TABLE IF EXISTS `class_using_process`;
CREATE TABLE IF NOT EXISTS `class_using_process` (
  `ObjectClassID` int(10) unsigned default NULL,
  `ProcessID` int(10) unsigned default NULL,
  `ProcessOrder` int(11) default NULL,
  KEY `FK_REFERENCE_14` (`ObjectClassID`),
  KEY `FK_REFERENCE_15` (`ProcessID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.fieldoptions
DROP TABLE IF EXISTS `fieldoptions`;
CREATE TABLE IF NOT EXISTS `fieldoptions` (
  `FieldOptionID` int(10) unsigned NOT NULL auto_increment,
  `FieldID` bigint(20) unsigned NOT NULL,
  `OptionName` text character set utf8 NOT NULL,
  PRIMARY KEY  (`FieldOptionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.fields
DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `FieldID` int(10) unsigned NOT NULL auto_increment,
  `FieldTypeID` smallint(5) unsigned default NULL,
  `FieldName` text character set utf8 NOT NULL,
  `ValidationRules` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`FieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.fieldtype
DROP TABLE IF EXISTS `fieldtype`;
CREATE TABLE IF NOT EXISTS `fieldtype` (
  `FieldTypeID` smallint(5) unsigned NOT NULL auto_increment,
  `FieldTypeName` varchar(40) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`FieldTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.fieldvalues
DROP TABLE IF EXISTS `fieldvalues`;
CREATE TABLE IF NOT EXISTS `fieldvalues` (
  `FieldValueID` bigint(20) unsigned NOT NULL auto_increment,
  `FieldID` int(10) unsigned NOT NULL,
  `ObjectID` bigint(20) default NULL,
  `FieldValue` text character set utf8 NOT NULL,
  `SelectedFieldValue` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`FieldValueID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.field_form
DROP TABLE IF EXISTS `field_form`;
CREATE TABLE IF NOT EXISTS `field_form` (
  `FieldID` int(10) unsigned NOT NULL,
  `FormID` int(10) unsigned NOT NULL,
  `OrderInForm` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`FieldID`,`FormID`),
  KEY `FK_ASSOCIATION_5` (`FormID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.forms
DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `FormID` int(10) unsigned NOT NULL auto_increment,
  `FormName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`FormID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.form_process
DROP TABLE IF EXISTS `form_process`;
CREATE TABLE IF NOT EXISTS `form_process` (
  `FormID` int(10) unsigned NOT NULL,
  `ProcessID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`FormID`,`ProcessID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) character set utf8 NOT NULL,
  `description` varchar(100) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Default Data
INSERT INTO groups(name,description) VALUES("admin","Administrator");
INSERT INTO groups(name,description) VALUES("operator","Operator");
INSERT INTO groups(name,description) VALUES("user","User");


# Dumping structure for table hoangnhan2db.language
DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `LanguageID` bigint(20) unsigned NOT NULL auto_increment,
  `TableName` varchar(50) collate utf8_unicode_ci NOT NULL,
  `TableKey` bigint(20) unsigned NOT NULL,
  `Meaning` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`LanguageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.matched_class_structure
DROP TABLE IF EXISTS `matched_class_structure`;
CREATE TABLE IF NOT EXISTS `matched_class_structure` (
  `BaseClassID` int(10) unsigned NOT NULL,
  `MatchedClassID` int(10) unsigned NOT NULL,
  `MatchedStructure` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`BaseClassID`,`MatchedClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.meta
DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `ext_info` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.objectclass
DROP TABLE IF EXISTS `objectclass`;
CREATE TABLE IF NOT EXISTS `objectclass` (
  `ObjectClassID` int(10) unsigned NOT NULL auto_increment,
  `AccessDataURI` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ObjectClassName` varchar(500) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ObjectClassID`),
  UNIQUE KEY `AccessDataURI` (`AccessDataURI`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.objecthtmlcaches
DROP TABLE IF EXISTS `objecthtmlcaches`;
CREATE TABLE IF NOT EXISTS `objecthtmlcaches` (
  `cacheID` bigint(20) unsigned NOT NULL auto_increment,
  `objectClass` varchar(30) character set utf8 NOT NULL default '',
  `objectPK` bigint(20) unsigned NOT NULL default '0',
  `cacheContent` text collate utf8_unicode_ci NOT NULL,
  `javascriptContent` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cacheID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.objects
DROP TABLE IF EXISTS `objects`;
CREATE TABLE IF NOT EXISTS `objects` (
  `ObjectID` bigint(20) unsigned NOT NULL auto_increment,
  `ObjectPrefixKey` varchar(30) collate utf8_unicode_ci NOT NULL,
  `ObjectClassID` int(11) NOT NULL,
  `ObjectRefKey` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`ObjectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.object_ext_info
DROP TABLE IF EXISTS `object_ext_info`;
CREATE TABLE IF NOT EXISTS `object_ext_info` (
  `ObjectID` bigint(20) unsigned NOT NULL,
  `Name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ObjectID`,`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.processes
DROP TABLE IF EXISTS `processes`;
CREATE TABLE IF NOT EXISTS `processes` (
  `ProcessID` int(10) unsigned NOT NULL auto_increment,
  `ProcessName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `Description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ProcessID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.query_filters
DROP TABLE IF EXISTS `query_filters`;
CREATE TABLE IF NOT EXISTS `query_filters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `query_name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `query_details` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) collate utf8_unicode_ci NOT NULL default '0',
  `ip_address` varchar(16) collate utf8_unicode_ci NOT NULL default '0',
  `user_agent` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.


# Dumping structure for table hoangnhan2db.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Data exporting was unselected.



DROP TABLE IF EXISTS label;

/*==============================================================*/
/* Table: "label"                                               */
/*==============================================================*/
create table label
(
   LabelID              bigint(20) unsigned not null,
   LabelName            varchar(120) not null,
   ParentLabelID        bigint(20) unsigned default 0,
   primary key (LabelID)
);


DROP TABLE IF EXISTS label_object;

/*==============================================================*/
/* Table: label_object                                          */
/*==============================================================*/
create table label_object
(
   LabelID              bigint(20) unsigned not null,
   ObjectID             bigint(20) unsigned not null,
   primary key (LabelID, ObjectID)
);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

