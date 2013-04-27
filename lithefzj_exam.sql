/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.25a : Database - lithefzj_exam
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
  `SCHEIDNO` char(5) DEFAULT NULL,
  `dcreated` datetime DEFAULT NULL,
  `dmodified` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_faculty_evaluation_session` */

insert  into `tbl_faculty_evaluation_session`(`id`,`question_set_id`,`title`,`description`,`start_date`,`end_date`,`faculty_id`,`SCHEIDNO`,`dcreated`,`dmodified`,`created_by`,`modified_by`) values (1,1,NULL,NULL,'2013-04-28 00:00:00','2013-04-30 00:00:00',5,'03804',NULL,NULL,'darryl.anaud',NULL),(2,1,NULL,NULL,'2013-04-28 00:00:00','2013-04-30 00:00:00',5,'03909',NULL,NULL,'darryl.anaud',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
