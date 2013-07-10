# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: bbkanba.com (MySQL 5.5.29-log)
# Database: machineBill
# Generation Time: 2013-07-10 09:13:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `history`;

CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT '0000-00-00 00:00:00',
  `nickname` varchar(45) NOT NULL,
  `operate` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;

INSERT INTO `history` (`id`, `time`, `nickname`, `operate`)
VALUES
	(1,'2013-07-10 16:42:28','刘磊','添加省份 河北'),
	(2,'2013-07-10 16:42:39','刘磊','添加省份 河南'),
	(3,'2013-07-10 16:43:01','刘磊','添加省份 山东'),
	(4,'2013-07-10 16:43:06','刘磊','添加省份 山西'),
	(5,'2013-07-10 16:43:14','刘磊','添加省份 广州'),
	(6,'2013-07-10 16:43:23','刘磊','添加省份 北京'),
	(7,'2013-07-10 16:44:31','刘磊','添加服务器 北京01号机器'),
	(8,'2013-07-10 16:44:51','刘磊','添加服务器 北京02号机器'),
	(9,'2013-07-10 16:44:58','刘磊','添加服务器 北京03号机器'),
	(10,'2013-07-10 16:45:12','刘磊','添加服务器 山东01号机器'),
	(11,'2013-07-10 16:45:19','刘磊','添加服务器 河南01号机器'),
	(12,'2013-07-10 16:45:26','刘磊','添加服务器 山西01号机器'),
	(13,'2013-07-10 16:46:47','刘磊','更新了 北京2号机器 的数据'),
	(14,'2013-07-10 16:47:05','刘磊','更新了 北京3号机器 的数据'),
	(15,'2013-07-10 16:47:30','刘磊','更新了 北京1号机器 的数据');

/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table province
# ------------------------------------------------------------

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceName` varchar(45) NOT NULL,
  `serverPlanNumber` smallint(5) unsigned NOT NULL,
  `serverActualNumber` smallint(5) unsigned NOT NULL,
  `remarks` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`,`provinceName`),
  UNIQUE KEY `provinceName_UNIQUE` (`provinceName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;

INSERT INTO `province` (`id`, `provinceName`, `serverPlanNumber`, `serverActualNumber`, `remarks`)
VALUES
	(1,'河北',15,0,'河北省份的情况'),
	(2,'河南',20,1,'河南省份的情况'),
	(3,'山东',10,1,'山东省份的情况'),
	(4,'山西',10,1,'山西省份的情况'),
	(5,'广州',30,0,'广州的情况'),
	(6,'北京',10,3,'北京的情况');

/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table serverMachine
# ------------------------------------------------------------

DROP TABLE IF EXISTS `serverMachine`;

CREATE TABLE `serverMachine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverNumber` smallint(5) unsigned NOT NULL,
  `area` varchar(300) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `ping` tinyint(1) NOT NULL,
  `login` tinyint(1) NOT NULL,
  `proxylogin` tinyint(1) NOT NULL,
  `eth` varchar(10000) NOT NULL,
  `remarks` varchar(10000) NOT NULL,
  `provinceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `serverMachine` WRITE;
/*!40000 ALTER TABLE `serverMachine` DISABLE KEYS */;

INSERT INTO `serverMachine` (`id`, `serverNumber`, `area`, `ip`, `ping`, `login`, `proxylogin`, `eth`, `remarks`, `provinceID`)
VALUES
	(1,1,'北京机房','192.168.0.11',1,1,0,'eth0','测试',6),
	(2,2,'北京机房','192.168.0.12',0,1,1,'eth0','测试',6),
	(3,3,'北京机房','192.168.0.14',1,0,1,'eth0','测试',6),
	(4,1,'北京机房','192.168.1.14',1,1,1,'eth0','测试',3),
	(5,1,'北京机房','192.168.2.14',1,1,1,'eth0','测试',2),
	(6,1,'北京机房','192.168.3.14',1,1,1,'eth0','测试',4);

/*!40000 ALTER TABLE `serverMachine` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) NOT NULL,
  `userPassword` varchar(100) NOT NULL,
  `nickname` varchar(45) NOT NULL,
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName_UNIQUE` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `userName`, `userPassword`, `nickname`, `lastlogin`)
VALUES
	(1,'leo','leo','刘磊','2013-07-10 17:11:29');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
