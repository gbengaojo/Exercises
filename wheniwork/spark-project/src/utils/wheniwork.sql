-- MySQL dump 10.13  Distrib 5.5.20-ndb-7.2.5, for linux2.6 (i686)
--
-- Host: localhost    Database: wheniwork
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.12.04.2

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
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shift` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `break` float(4,2) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_id` (`manager_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `shift_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`),
  CONSTRAINT `shift_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shift`
--

LOCK TABLES `shift` WRITE;
/*!40000 ALTER TABLE `shift` DISABLE KEYS */;
INSERT INTO `shift` VALUES (1,1,1,1.00,'2015-11-30 14:00:00','2015-11-30 23:00:00','2015-11-11 19:59:52',NULL),(2,1,1,1.00,'2015-11-29 14:00:00','2015-11-29 23:00:00','2015-11-11 19:59:57',NULL),(3,1,1,1.00,'2015-11-28 14:00:00','2015-11-28 23:00:00','2015-11-11 20:00:02',NULL),(4,1,1,1.00,'2015-11-27 14:00:00','2015-11-27 23:00:00','2015-11-11 20:00:07',NULL),(5,1,3,1.00,'2015-12-01 14:00:00','2015-12-02 00:00:00','2015-11-11 21:54:36',NULL),(7,1,3,1.00,'2015-12-02 13:00:00','2015-12-01 22:00:00','2015-11-12 13:14:33',NULL),(10,2,1,1.00,'2015-12-01 14:00:00','2015-12-01 23:00:00','2015-11-12 14:19:18',NULL),(11,2,1,0.00,'2015-12-02 16:00:00','2015-12-03 02:00:00','2015-11-12 14:19:42',NULL),(12,2,3,0.00,'2015-12-02 16:00:00','2015-12-03 02:00:00','2015-11-12 14:20:03',NULL),(13,2,1,1.00,'2015-12-03 14:00:00','2015-12-03 23:00:00','2015-11-12 14:24:18',NULL),(14,2,3,0.00,'2015-12-02 16:00:00','2015-12-03 02:00:00','2015-11-12 14:27:20',NULL),(15,2,1,1.00,'2015-12-04 14:00:00','2015-12-04 23:00:00','2015-11-13 02:16:16',NULL),(16,2,1,1.00,'2015-12-05 14:00:00','2015-12-05 23:00:00','2015-11-13 02:16:43',NULL),(17,2,1,1.00,'2015-12-07 14:00:00','2015-12-07 23:00:00','2015-11-13 02:17:34',NULL),(18,2,1,1.00,'2015-12-08 14:00:00','2015-12-08 23:00:00','2015-11-13 02:17:44',NULL),(19,2,1,1.00,'2015-12-09 14:00:00','2015-12-09 23:00:00','2015-11-13 02:17:50',NULL),(20,2,1,1.00,'2015-12-10 14:00:00','2015-12-10 23:00:00','2015-11-13 02:17:57',NULL),(21,2,1,1.00,'2015-12-11 14:00:00','2015-12-11 23:00:00','2015-11-13 02:18:02',NULL),(22,2,1,1.00,'2015-12-12 14:00:00','2015-12-12 23:00:00','2015-11-13 02:18:07',NULL),(23,2,1,1.00,'2015-12-13 14:00:00','2015-12-13 23:00:00','2015-11-13 02:18:11',NULL),(24,2,1,1.00,'2015-12-14 14:00:00','2015-12-14 23:00:00','2015-11-13 02:18:17',NULL),(25,2,1,1.00,'2015-12-15 14:00:00','2015-12-15 23:00:00','2015-11-13 02:18:24',NULL);
/*!40000 ALTER TABLE `shift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` enum('employee','manager') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Gbenga Ojo','employee','gbenga@lucidmediaconcepts.com','214.417.4082',NULL,NULL),(2,'John Doe','manager','john@doe.com','212.555.5123',NULL,NULL),(3,'Leslie Dean','employee','leslie@dean.com','702.555.2039',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-13  5:08:23
