-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4126
-- Date/time:                    2012-04-07 11:21:27
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table i2tree.applications
DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `client_secret` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(250) NOT NULL DEFAULT '',
  `auto_approve` tinyint(1) NOT NULL DEFAULT '0',
  `autonomous` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('development','pending','approved','rejected') NOT NULL DEFAULT 'development',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `notes` tinytext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`)
) AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.applications: ~1 rows (approximately)
DELETE FROM `applications`;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` (`id`, `name`, `client_id`, `client_secret`, `redirect_uri`, `auto_approve`, `autonomous`, `status`, `suspended`, `notes`) VALUES
	(100, 'mobile app test', 'hello-i2tree', 'e10adc3949ba59abbe56e057f20f883e', 'http://localhost/i2tree/index.php/unit-tests/', 1, 0, 'development', 0, NULL);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;


-- Dumping structure for table i2tree.groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.groups: ~3 rows (approximately)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Administrator'),
	(2, 'operator', 'Operator'),
	(3, 'user', 'User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Dumping structure for table i2tree.meta
DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ext_info` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
)  AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.meta: ~2 rows (approximately)
DELETE FROM `meta`;
/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
INSERT INTO `meta` (`id`, `user_id`, `first_name`, `last_name`, `ext_info`) VALUES
	(2, 3, 'Trieu', 'Nguyen', '0'),
	(13, 15, 'tantrieuf31', 'databased', '0');
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;


-- Dumping structure for table i2tree.oauth_sessions
DROP TABLE IF EXISTS `oauth_sessions`;
CREATE TABLE IF NOT EXISTS `oauth_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(250) NOT NULL DEFAULT '',
  `type_id` varchar(64) DEFAULT NULL,
  `type` enum('user','auto') NOT NULL DEFAULT 'user',
  `code` text,
  `access_token` varchar(50) DEFAULT '',
  `stage` enum('request','granted') NOT NULL DEFAULT 'request',
  `first_requested` int(10) unsigned NOT NULL,
  `last_updated` int(10) unsigned NOT NULL,
  `limited_access` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Used for user agent flows',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `applications` (`client_id`) ON DELETE CASCADE
)AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.oauth_sessions: ~1 rows (approximately)
DELETE FROM `oauth_sessions`;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;
INSERT INTO `oauth_sessions` (`id`, `client_id`, `redirect_uri`, `type_id`, `type`, `code`, `access_token`, `stage`, `first_requested`, `last_updated`, `limited_access`) VALUES
	(2, 'hello-i2tree', 'http://localhost/i2tree/index.php/unit-tests/', '1000', 'user', NULL, '3916f65b0af4687b30da58048815fab67416a874', 'granted', 1333475921, 1333478728, 0);
/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;


-- Dumping structure for table i2tree.oauth_session_scopes
DROP TABLE IF EXISTS `oauth_session_scopes`;
CREATE TABLE IF NOT EXISTS `oauth_session_scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `scope` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `scope` (`scope`),
  KEY `access_token` (`access_token`),
  CONSTRAINT `oauth_session_scopes_ibfk_1` FOREIGN KEY (`scope`) REFERENCES `scopes` (`scope`),
  CONSTRAINT `oauth_session_scopes_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.oauth_session_scopes: ~1 rows (approximately)
DELETE FROM `oauth_session_scopes`;
/*!40000 ALTER TABLE `oauth_session_scopes` DISABLE KEYS */;
INSERT INTO `oauth_session_scopes` (`id`, `session_id`, `access_token`, `scope`) VALUES
	(2, 2, '3916f65b0af4687b30da58048815fab67416a874', 'user.details');
/*!40000 ALTER TABLE `oauth_session_scopes` ENABLE KEYS */;


-- Dumping structure for table i2tree.scopes
DROP TABLE IF EXISTS `scopes`;
CREATE TABLE IF NOT EXISTS `scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.scopes: ~1 rows (approximately)
DELETE FROM `scopes`;
/*!40000 ALTER TABLE `scopes` DISABLE KEYS */;
INSERT INTO `scopes` (`id`, `scope`, `name`, `description`) VALUES
	(1, 'user.details', 'user.details', 'Get user\'s details');
/*!40000 ALTER TABLE `scopes` ENABLE KEYS */;


-- Dumping structure for table i2tree.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.sessions: ~0 rows (approximately)
DELETE FROM `sessions`;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;


-- Dumping structure for table i2tree.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
) AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `data_of_birth`) VALUES
	(3, 1, '127.0.0.1', 'trieu_drd', '0f376afb66926ffb0f4604223fd83d537b64c415', 'trieu@drdvietnam.com', '0', '0', 0),
	(15, 3, '127.0.0.1', 'tantrieuf31.dat', '92cd9fbe4db5e57eaa6f1f63881d6f43f0c3181d', 'tantrieuf31.database@gmail.com', '0', '0', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
