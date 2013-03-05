/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.27 : Database - lithefzj_exam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lithefzj_exam` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `lithefzj_exam`;

/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `module` */

insert  into `module`(`id`,`description`,`link`,`category_id`,`group`,`icon`,`order`,`is_public`) values (1,'User Access Control','userMatrix',1,NULL,NULL,NULL,0),(2,'User Administration','userMatrix/administration',1,NULL,NULL,NULL,0),(3,'Change Password',NULL,2,NULL,NULL,NULL,1),(8,'Exam Classifications','examclassifications',5,NULL,NULL,NULL,0),(9,'Question Classifications','questionclassifications',5,NULL,NULL,NULL,0),(10,'Scaffolding','userMatrix/scaffolding',1,NULL,NULL,NULL,0),(13,'Manage Question Set','exam',7,NULL,NULL,NULL,0),(23,'Services','FILESERV',5,NULL,NULL,NULL,0),(24,'Faculty Evaluation Schedule','FacultyEvaluation',7,NULL,NULL,NULL,0),(25,'View Results','results/',7,NULL,NULL,NULL,1);

/*Table structure for table `module_category` */

DROP TABLE IF EXISTS `module_category`;

CREATE TABLE `module_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `module_category` */

insert  into `module_category`(`id`,`description`,`icon`,`order`,`is_public`) values (1,'USER MATRIX','/images/icons2/hammer_screwdriver.png',4,0),(2,'MY ACCOUNT','/images/icons/user.png',1,1),(3,'FACILITIES','/images/icons/package.png',5,NULL),(4,'MANAGE LIBRARIES','/images/icons/package.png',6,1),(5,'FILEREFERENCE','/images/icons/folder.png',2,0),(7,'APPLICATIONS','/images/icons/application.png',3,1);

/*Table structure for table `module_group` */

DROP TABLE IF EXISTS `module_group`;

CREATE TABLE `module_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `module_group` */

insert  into `module_group`(`id`,`description`) values (1,'Super User'),(2,'Student'),(3,'Pmms.staff');

/*Table structure for table `module_group_access` */

DROP TABLE IF EXISTS `module_group_access`;

CREATE TABLE `module_group_access` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(20) DEFAULT NULL,
  `module_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `module_group_access` */

insert  into `module_group_access`(`id`,`group_id`,`module_id`) values (1,1,1),(2,1,2),(3,1,4),(4,2,4),(5,1,5),(6,3,5),(7,3,4),(8,1,6),(9,1,8),(10,1,9),(11,1,10),(12,1,11),(13,1,23),(14,1,13),(15,1,24);

/*Table structure for table `module_group_users` */

DROP TABLE IF EXISTS `module_group_users`;

CREATE TABLE `module_group_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `group_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `module_group_users` */

insert  into `module_group_users`(`id`,`user_id`,`username`,`group_id`) values (1,1,'darryl.anaud',1),(2,NULL,'richard.base',1),(3,NULL,'maribeth.rivas',1),(4,NULL,'niz.nolasco',1),(5,NULL,'apple.aala',2),(6,NULL,'test.admin',3),(7,NULL,'greg',1),(8,NULL,'gary',1);

/*Table structure for table `question_answers` */

DROP TABLE IF EXISTS `question_answers`;

CREATE TABLE `question_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `correct_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `question_answers` */

/*Table structure for table `question_categories` */

DROP TABLE IF EXISTS `question_categories`;

CREATE TABLE `question_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `question_categories` */

/*Table structure for table `tbl_faculty_evaluation_answers` */

DROP TABLE IF EXISTS `tbl_faculty_evaluation_answers`;

CREATE TABLE `tbl_faculty_evaluation_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `answer` int(11) DEFAULT NULL,
  `answer_text` text,
  `correct_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_faculty_evaluation_answers` */

/*Table structure for table `tbl_faculty_evaluation_session` */

DROP TABLE IF EXISTS `tbl_faculty_evaluation_session`;

CREATE TABLE `tbl_faculty_evaluation_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_set_id` int(11) DEFAULT NULL,
  `title` varchar(75) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `dcreated` datetime DEFAULT NULL,
  `dmodified` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_faculty_evaluation_session` */

/*Table structure for table `tbl_preset` */

DROP TABLE IF EXISTS `tbl_preset`;

CREATE TABLE `tbl_preset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `dcreated` datetime DEFAULT NULL,
  `dmodified` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_preset` */

insert  into `tbl_preset`(`id`,`description`,`dcreated`,`dmodified`,`created_by`,`modified_by`) values (1,'Evaluation Rating Scale (5-Highest 1-Lowest)','2013-02-24 20:08:03',NULL,'darryl.anaud',NULL);

/*Table structure for table `tbl_preset_choices` */

DROP TABLE IF EXISTS `tbl_preset_choices`;

CREATE TABLE `tbl_preset_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preset_id` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `correct_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_preset_choices` */

insert  into `tbl_preset_choices`(`id`,`preset_id`,`description`,`correct_flag`) values (1,1,'1',0),(2,1,'2',0),(3,1,'3',0),(4,1,'4',0),(5,1,'5',0);

/*Table structure for table `tbl_question` */

DROP TABLE IF EXISTS `tbl_question`;

CREATE TABLE `tbl_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_set_id` int(11) DEFAULT NULL,
  `classification_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `order_position` tinyint(3) DEFAULT NULL,
  `dcreated` datetime DEFAULT NULL,
  `dmodified` datetime DEFAULT NULL,
  `createdby` varchar(30) DEFAULT NULL,
  `modifiedby` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_question` */

insert  into `tbl_question`(`id`,`question_set_id`,`classification_id`,`category_id`,`description`,`order_position`,`dcreated`,`dmodified`,`createdby`,`modifiedby`) values (1,1,5,1,'Explains clearly the learning objectives of the lesson',29,'2013-02-24 20:00:21',NULL,'darryl.anaud',NULL),(2,1,5,1,'Presents ideas and concepts in a clear and organized manner',29,'2013-02-24 20:01:25',NULL,'darryl.anaud',NULL),(3,1,5,1,'Relates subject matter/lesson to other subjects and its practical applications',29,'2013-02-24 20:02:29',NULL,'darryl.anaud',NULL),(4,1,5,1,'Encourages questions from students; stimulates interest, thinking, and discussion in the class',29,'2013-02-24 20:02:45',NULL,'darryl.anaud',NULL),(5,1,5,1,'Is well prepared for class; shows master of the subject matter',29,'2013-02-24 20:03:07',NULL,'darryl.anaud',NULL),(6,1,5,1,'Makes use of effective teaching aids and methods to ensure students understanding',29,'2013-02-24 20:05:20',NULL,'darryl.anaud',NULL),(7,1,5,1,'Stands and moves around while conducting classroom lectures and activites',29,'2013-02-24 20:05:47',NULL,'darryl.anaud',NULL),(8,1,5,1,'Writing on the board is legible/readable',29,'2013-02-24 20:06:13',NULL,'darryl.anaud',NULL),(9,1,5,2,'Has clearly-defined basis for grading students',29,'2013-02-24 20:18:07',NULL,'darryl.anaud',NULL),(10,1,5,2,'Gives tests and practical exercises that are well prepared and are easily understood as good measure of what the students have learned',29,'2013-02-24 20:19:00',NULL,'darryl.anaud',NULL),(11,1,5,2,'Practices fairness; avoids favoritism',29,'2013-02-24 20:19:32',NULL,'darryl.anaud',NULL),(12,1,5,3,'Makes sure the students maintain cleanliness and orderliness in the classroom',29,'2013-02-24 20:20:00',NULL,'darryl.anaud',NULL),(13,1,5,3,'Is strict but reasonable in disciplining students; handles classroom misbehavior effectively in a timely manner',29,'2013-02-24 20:20:51',NULL,'darryl.anaud',NULL),(14,1,5,3,'Observes classroom courtesy; talks to students in a polite manner',29,'2013-02-24 20:21:35',NULL,'darryl.anaud',NULL),(15,1,5,3,'Handles classroom misbehavior effectively and professionally',29,'2013-02-24 20:22:02',NULL,'darryl.anaud',NULL),(16,1,5,4,'Shows genuine interest in students; gives recognition to deserving students',29,'2013-02-24 20:22:41',NULL,'darryl.anaud',NULL),(17,1,5,4,'Shows respect and consideration for students opinions and suggestions',30,'2013-02-24 20:23:14',NULL,'darryl.anaud',NULL),(18,1,5,4,'Uses the last few minutes of classroom hours and breaks for consultation',30,'2013-02-24 20:23:58',NULL,'darryl.anaud',NULL),(19,1,5,4,'Understands and addresses the individual differences of students; has genuine empathy for their welfare',30,'2013-02-24 20:24:24',NULL,'darryl.anaud',NULL),(20,1,5,4,'Is a good role model for proper conduct and good values',30,'2013-02-24 20:24:44',NULL,'darryl.anaud',NULL),(21,1,5,5,'Is neat, clean and well-groomed',30,'2013-02-24 20:25:31',NULL,'darryl.anaud',NULL),(22,1,5,5,'Uses corporate attire/uniform from Monday to Friday',NULL,NULL,NULL,NULL,NULL),(23,1,5,5,'Uses the English language as the medium of instruction (except in Filipino subjects)',30,'2013-02-24 20:28:57',NULL,'darryl.anaud',NULL),(24,1,5,5,'Treats students as mature individuals',30,'2013-02-24 20:29:42',NULL,'darryl.anaud',NULL),(25,1,5,6,'Attends the class regularly',30,'2013-02-24 20:30:06',NULL,'darryl.anaud',NULL),(26,1,5,7,'Comes to class on time',30,'2013-02-24 20:30:26',NULL,'darryl.anaud',NULL),(27,1,5,8,'Dismisses the class on time',30,'2013-02-24 20:30:54',NULL,'darryl.anaud',NULL),(28,1,5,9,'Joins social activities of students OUTSIDE of school',30,'2013-02-24 20:31:34',NULL,'darryl.anaud',NULL),(29,1,2,10,'What is the best professional attribute of this instructor?',30,'2013-02-24 20:32:06',NULL,'darryl.anaud',NULL),(30,1,2,10,'What is the most critical are for improvement of this instructor?',30,'2013-02-24 20:32:32',NULL,'darryl.anaud',NULL),(31,2,1,6,'Test',0,'2013-02-28 14:04:10',NULL,'darryl.anaud',NULL);

/*Table structure for table `tbl_question_choices` */

DROP TABLE IF EXISTS `tbl_question_choices`;

CREATE TABLE `tbl_question_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `position` tinyint(3) DEFAULT NULL,
  `correct_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_question_choices` */

insert  into `tbl_question_choices`(`id`,`question_id`,`description`,`position`,`correct_flag`) values (1,8,'1',NULL,0),(2,8,'2',NULL,0),(3,8,'3',NULL,0),(4,8,'4',NULL,0),(5,8,'5',NULL,0),(6,7,'1',NULL,0),(7,7,'2',NULL,0),(8,7,'3',NULL,0),(9,7,'4',NULL,0),(10,7,'5',NULL,0),(11,6,'1',NULL,0),(12,6,'2',NULL,0),(13,6,'3',NULL,0),(14,6,'4',NULL,0),(15,6,'5',NULL,0),(16,4,'1',NULL,0),(17,4,'2',NULL,0),(18,4,'3',NULL,0),(19,4,'4',NULL,0),(20,4,'5',NULL,0),(21,5,'1',NULL,0),(22,5,'2',NULL,0),(23,5,'3',NULL,0),(24,5,'4',NULL,0),(25,5,'5',NULL,0),(26,3,'1',NULL,0),(27,3,'2',NULL,0),(28,3,'3',NULL,0),(29,3,'4',NULL,0),(30,3,'5',NULL,0),(31,2,'1',NULL,0),(32,2,'2',NULL,0),(33,2,'3',NULL,0),(34,2,'4',NULL,0),(35,2,'5',NULL,0),(36,1,'1',NULL,0),(37,1,'2',NULL,0),(38,1,'3',NULL,0),(39,1,'4',NULL,0),(40,1,'5',NULL,0),(41,9,'1',NULL,0),(42,9,'2',NULL,0),(43,9,'3',NULL,0),(44,9,'4',NULL,0),(45,9,'5',NULL,0),(46,10,'1',NULL,0),(47,10,'2',NULL,0),(48,10,'3',NULL,0),(49,10,'4',NULL,0),(50,10,'5',NULL,0),(51,11,'1',NULL,0),(52,11,'2',NULL,0),(53,11,'3',NULL,0),(54,11,'4',NULL,0),(55,11,'5',NULL,0),(56,28,'1',NULL,0),(57,28,'2',NULL,0),(58,28,'3',NULL,0),(59,28,'4',NULL,0),(60,28,'5',NULL,0),(61,27,'1',NULL,0),(62,27,'2',NULL,0),(63,27,'3',NULL,0),(64,27,'4',NULL,0),(65,27,'5',NULL,0),(66,26,'1',NULL,0),(67,26,'2',NULL,0),(68,26,'3',NULL,0),(69,26,'4',NULL,0),(70,26,'5',NULL,0),(71,25,'1',NULL,0),(72,25,'2',NULL,0),(73,25,'3',NULL,0),(74,25,'4',NULL,0),(75,25,'5',NULL,0),(76,24,'1',NULL,0),(77,24,'2',NULL,0),(78,24,'3',NULL,0),(79,24,'4',NULL,0),(80,24,'5',NULL,0),(81,23,'1',NULL,0),(82,23,'2',NULL,0),(83,23,'3',NULL,0),(84,23,'4',NULL,0),(85,23,'5',NULL,0),(86,22,'1',NULL,0),(87,22,'2',NULL,0),(88,22,'3',NULL,0),(89,22,'4',NULL,0),(90,22,'5',NULL,0),(91,21,'1',NULL,0),(92,21,'2',NULL,0),(93,21,'3',NULL,0),(94,21,'4',NULL,0),(95,21,'5',NULL,0),(96,20,'1',NULL,0),(97,20,'2',NULL,0),(98,20,'3',NULL,0),(99,20,'4',NULL,0),(100,20,'5',NULL,0),(101,19,'1',NULL,0),(102,19,'2',NULL,0),(103,19,'3',NULL,0),(104,19,'4',NULL,0),(105,19,'5',NULL,0),(106,18,'1',NULL,0),(107,18,'2',NULL,0),(108,18,'3',NULL,0),(109,18,'4',NULL,0),(110,18,'5',NULL,0),(111,17,'1',NULL,0),(112,17,'2',NULL,0),(113,17,'3',NULL,0),(114,17,'4',NULL,0),(115,17,'5',NULL,0),(116,16,'1',NULL,0),(117,16,'2',NULL,0),(118,16,'3',NULL,0),(119,16,'4',NULL,0),(120,16,'5',NULL,0),(121,15,'1',NULL,0),(122,15,'2',NULL,0),(123,15,'3',NULL,0),(124,15,'4',NULL,0),(125,15,'5',NULL,0),(126,14,'1',NULL,0),(127,14,'2',NULL,0),(128,14,'3',NULL,0),(129,14,'4',NULL,0),(130,14,'5',NULL,0),(131,13,'1',NULL,0),(132,13,'2',NULL,0),(133,13,'3',NULL,0),(134,13,'4',NULL,0),(135,13,'5',NULL,0),(136,12,'1',NULL,0),(137,12,'2',NULL,0),(138,12,'3',NULL,0),(139,12,'4',NULL,0),(140,12,'5',NULL,0),(141,31,'Test 123',NULL,0);

/*Table structure for table `tbl_question_set` */

DROP TABLE IF EXISTS `tbl_question_set`;

CREATE TABLE `tbl_question_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `timePerQuestion` int(4) DEFAULT '0',
  `dcreated` datetime DEFAULT NULL,
  `dmodified` datetime DEFAULT NULL,
  `createdby` varchar(30) DEFAULT NULL,
  `modifiedby` varchar(30) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_question_set` */

insert  into `tbl_question_set`(`id`,`name`,`description`,`timePerQuestion`,`dcreated`,`dmodified`,`createdby`,`modifiedby`,`is_delete`) values (1,'RD-004 REV 04','STUDENT\'S EVALUATION OF FACULTY MEMBERS',0,'2013-02-24 19:56:47',NULL,'darryl.anaud',NULL,NULL),(2,'Test eval','Test',0,'2013-02-25 11:55:23',NULL,'darryl.anaud',NULL,NULL);

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`id`,`username`,`password`,`salt`,`user_type_code`,`STUDCODE`,`STUDIDNO`,`ADVICODE`,`ADVIIDNO`,`PARECODE`,`PAREIDNO`,`dmodified`,`modified_by`) values (1,'darryl.anaud','916cb67aa119d20627f839ad29a5068bbee2ca83',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-01 09:19:07',NULL),(2,'richard.base','cee8da72db7d001cb40ae3314887380cc4a6882e',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 16:52:53',NULL),(3,'maribeth.rivas','1409957c57942079d4139f6c8cdf647d4b32cfc2',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 16:52:31',NULL),(5,'niz.nolasco','37e5c9b2528b6c6e8fc4da450626efd0d77f669f',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-05-02 16:52:43',NULL),(12,'apple.aala','85ecc3653e1fbee400eefba07b9adc2d7b79e62e',NULL,'STUD',287,'3F7N010259',NULL,NULL,NULL,NULL,'2012-05-04 06:30:28',NULL),(13,'staff','14fb1e49a92d35e952854a9f4a9740252025b0d5',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2013-02-25 20:41:50',NULL),(14,'greg','62fd1ecd141171aa41a7b0986c83882b3e3bb743',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2012-11-29 21:47:13',NULL),(15,'gary','89552e831c92fd37035401d8d46c9ef4dc82e5c6',NULL,'ADMIN',NULL,NULL,NULL,NULL,NULL,NULL,'2013-02-25 20:42:31',NULL);

/*Table structure for table `tbl_user_type` */

DROP TABLE IF EXISTS `tbl_user_type`;

CREATE TABLE `tbl_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY (`id`,`code`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user_type` */

insert  into `tbl_user_type`(`id`,`code`,`description`) values (1,'ADMIN','Administrator'),(2,'FACU','Faculty'),(3,'STUD','Student'),(4,'PRNT','Parent');

/*Table structure for table `test_table` */

DROP TABLE IF EXISTS `test_table`;

CREATE TABLE `test_table` (
  `id` int(11) NOT NULL,
  `test` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `test_table` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
