-- MySQL dump 10.13  Distrib 5.5.19, for osx10.6 (i386)
--
-- Host: localhost    Database: lithefzj_exam
-- ------------------------------------------------------
-- Server version	5.5.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `group` int(10) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'User Matrix','userMatrix',1,NULL,NULL,NULL,0),(2,'User Administration','userMatrix/administration',1,NULL,NULL,NULL,0),(3,'Change Password',NULL,2,NULL,NULL,NULL,1),(6,'Questions','questions',4,NULL,NULL,NULL,1),(7,'Exams','exam',4,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_category`
--

DROP TABLE IF EXISTS `module_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_category`
--

LOCK TABLES `module_category` WRITE;
/*!40000 ALTER TABLE `module_category` DISABLE KEYS */;
INSERT INTO `module_category` VALUES (1,'USER MATRIX','/images/icons2/hammer_screwdriver.png',NULL,0),(2,'MY ACCOUNT','/images/icons/user.png',NULL,1),(3,'FACILITIES','/images/icons/package.png',NULL,NULL),(4,'MANAGE EXAMS','/images/icons/package.png',NULL,1);
/*!40000 ALTER TABLE `module_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_group`
--

DROP TABLE IF EXISTS `module_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_group`
--

LOCK TABLES `module_group` WRITE;
/*!40000 ALTER TABLE `module_group` DISABLE KEYS */;
INSERT INTO `module_group` VALUES (1,'Super User'),(2,'Student'),(3,'Pmms.staff');
/*!40000 ALTER TABLE `module_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_group_access`
--

DROP TABLE IF EXISTS `module_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_group_access` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(20) DEFAULT NULL,
  `module_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_group_access`
--

LOCK TABLES `module_group_access` WRITE;
/*!40000 ALTER TABLE `module_group_access` DISABLE KEYS */;
INSERT INTO `module_group_access` VALUES (1,1,1),(2,1,2),(3,1,4),(4,2,4),(5,1,5),(6,3,5),(7,3,4),(8,1,6);
/*!40000 ALTER TABLE `module_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_group_users`
--

DROP TABLE IF EXISTS `module_group_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_group_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `group_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_group_users`
--

LOCK TABLES `module_group_users` WRITE;
/*!40000 ALTER TABLE `module_group_users` DISABLE KEYS */;
INSERT INTO `module_group_users` VALUES (1,1,'darryl.anaud',1),(2,NULL,'richard.base',1),(3,NULL,'maribeth.rivas',1),(4,NULL,'niz.nolasco',1),(5,NULL,'apple.aala',2),(6,NULL,'test.admin',3);
/*!40000 ALTER TABLE `module_group_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` char(40) DEFAULT NULL,
  `user_type_code` varchar(10) DEFAULT NULL,
  `STUDCODE` int(11) DEFAULT NULL,
  `STUDIDNO` char(10) DEFAULT NULL,
  `ADVICODE` int(11) DEFAULT NULL,
  `ADVIIDNO` char(10) DEFAULT NULL,
  `PARECODE` int(11) DEFAULT NULL,
  `PAREIDNO` char(10) DEFAULT NULL,
  `dmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'darryl.anaud','916cb67aa119d20627f839ad29a5068bbee2ca83',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-01 01:19:07',NULL),(2,'richard.base','cee8da72db7d001cb40ae3314887380cc4a6882e',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 08:52:53',NULL),(3,'maribeth.rivas','1409957c57942079d4139f6c8cdf647d4b32cfc2',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 08:52:31',NULL),(5,'niz.nolasco','37e5c9b2528b6c6e8fc4da450626efd0d77f669f',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 08:52:43',NULL),(12,'apple.aala','85ecc3653e1fbee400eefba07b9adc2d7b79e62e',NULL,'STUD',287,'3F7N010259',NULL,NULL,NULL,NULL,'2012-05-03 22:30:28',NULL),(13,'test.admin','14fb1e49a92d35e952854a9f4a9740252025b0d5',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-07-30 18:25:20',NULL),(14,'greg','62fd1ecd141171aa41a7b0986c83882b3e3bb743',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-11-29 13:47:13',NULL);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_type`
--

DROP TABLE IF EXISTS `tbl_user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY (`id`,`code`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_type`
--

LOCK TABLES `tbl_user_type` WRITE;
/*!40000 ALTER TABLE `tbl_user_type` DISABLE KEYS */;
INSERT INTO `tbl_user_type` VALUES (1,'ADMIN','Administrator'),(2,'FACU','Faculty'),(3,'STUD','Student'),(4,'PRNT','Parent');
/*!40000 ALTER TABLE `tbl_user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_table`
--

DROP TABLE IF EXISTS `test_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_table` (
  `id` int(11) NOT NULL,
  `test` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_table`
--

LOCK TABLES `test_table` WRITE;
/*!40000 ALTER TABLE `test_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-01-06 15:07:38
