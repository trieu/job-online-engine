DROP TABLE IF EXISTS class_using_process;
CREATE TABLE  class_using_process (
  ObjectClassID int(10) unsigned DEFAULT NULL,
  ProcessID int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS field_form;
CREATE TABLE  field_form (
  FieldID int(10) unsigned NOT NULL,
  FormID int(10) unsigned NOT NULL,
  PRIMARY KEY (FieldID,FormID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS fieldoptions;
CREATE TABLE  fieldoptions (
  FieldOptionID int(10) unsigned NOT NULL AUTO_INCREMENT,
  FieldID bigint(20) unsigned NOT NULL,
  OptionName text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (FieldOptionID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `FieldID` int(10) unsigned NOT NULL auto_increment,
  `FieldTypeID` smallint(5) unsigned default NULL,
  `FieldName` text character set utf8 NOT NULL,
  `ValidationRules` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`FieldID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS fieldtype;
CREATE TABLE  fieldtype (
  FieldTypeID smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  FieldTypeName varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (FieldTypeID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS fieldvalues;
CREATE TABLE  fieldvalues (
  FieldValueID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  FieldID int(10) unsigned NOT NULL,
  ObjectID bigint(20) DEFAULT NULL,
  FieldValue text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (FieldValueID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS form_process;
CREATE TABLE  form_process (
  FormID int(10) unsigned NOT NULL,
  ProcessID int(10) unsigned NOT NULL,
  PRIMARY KEY (FormID,ProcessID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS forms;
CREATE TABLE  forms (
  FormID int(10) unsigned NOT NULL AUTO_INCREMENT,
  FormName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  Description text COLLATE utf8_unicode_ci,
  PRIMARY KEY (FormID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS groups;
CREATE TABLE  groups (
  id tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(20) CHARACTER SET utf8 NOT NULL,
  description varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS language;
CREATE TABLE  language (
  LanguageID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  TableName varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  TableKey bigint(20) unsigned NOT NULL,
  Meaning text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (LanguageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS objectclass;
CREATE TABLE  objectclass (
  ObjectClassID int(10) unsigned NOT NULL AUTO_INCREMENT,
  ObjectClassName varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  Description text COLLATE utf8_unicode_ci,
  PRIMARY KEY (ObjectClassID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `objecthtmlcaches`;
CREATE TABLE `objecthtmlcaches` (
  `cacheID` bigint(20) unsigned NOT NULL auto_increment,
  `objectClass` int(11) NOT NULL,
  `objectPK` bigint(20) NOT NULL,
  `cacheContent` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cacheID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS objects;
CREATE TABLE  objects (
  ObjectID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  ObjectPrefixKey varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  ObjectClassID int(11) NOT NULL,
  ObjectRefKey varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (ObjectID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS processes;
CREATE TABLE  processes (
  ProcessID int(10) unsigned NOT NULL AUTO_INCREMENT,
  ProcessName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  Description text COLLATE utf8_unicode_ci,
  PRIMARY KEY (ProcessID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS sessions;
CREATE TABLE  sessions (
  session_id varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
  ip_address varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
  user_agent varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  last_activity int(10) unsigned NOT NULL DEFAULT 0,
  user_data text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS users;
CREATE TABLE  users (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  group_id mediumint(8) unsigned NOT NULL,
  ip_address char(16) CHARACTER SET utf8 NOT NULL,
  username varchar(15) CHARACTER SET utf8 NOT NULL,
  password varchar(40) CHARACTER SET utf8 NOT NULL,
  email varchar(40) CHARACTER SET utf8 NOT NULL,
  activation_code varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT 0,
  forgotten_password_code varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT 0,
  data_of_birth bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS object_ext_info;
CREATE TABLE  object_ext_info (
 ObjectID bigint(20) unsigned NOT NULL,
  Name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  Value text COLLATE utf8_unicode_ci,
  PRIMARY KEY (ObjectID,Name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;