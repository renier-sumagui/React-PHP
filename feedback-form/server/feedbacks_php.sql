-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: feedbacks_php
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'PHP Track','2025-05-27 17:04:00','2025-05-27 17:04:00'),(2,'Advanced JavaScript','2025-05-27 17:04:00','2025-05-27 17:04:00'),(3,'Front End Track','2025-05-27 17:04:00','2025-05-27 17:04:00');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedbacks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `reason` text,
  `score` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedbacks_courses_idx` (`course_id`),
  CONSTRAINT `fk_feedbacks_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

LOCK TABLES `feedbacks` WRITE;
/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,1,'Renier','Great course! I learned a lot',10,'2025-05-27 17:05:39','2025-05-27 17:05:39'),(2,2,'Renier','Awesome!',10,'2025-05-27 17:05:39','2025-05-27 17:05:39'),(3,2,'Renierss','Very awesome course!',1,'2025-05-27 19:46:43','2025-05-27 19:46:43'),(4,1,'Test 1','Very awesome course!',10,'2025-05-27 19:52:04','2025-05-27 19:52:04'),(5,1,'Test 1','Very awesome course!',10,'2025-05-27 19:52:39','2025-05-27 19:52:39'),(6,2,'Bogus Gateway','test',2,'2025-05-27 20:10:59','2025-05-27 20:10:59'),(7,1,'Eigital','testssdfsdf',2,'2025-05-27 20:12:39','2025-05-27 20:12:39'),(8,1,'Test 1','Very awesome course!',10,'2025-05-27 20:58:32','2025-05-27 20:58:32'),(9,2,'Test 1','Very awesome course!',10,'2025-05-27 20:58:41','2025-05-27 20:58:41'),(10,2,'Test 1','Very awesome course!',10,'2025-05-28 13:54:13','2025-05-28 13:54:13'),(11,2,'Renier Paolo Sumagui','testing',3,'2025-05-28 14:04:10','2025-05-28 14:04:10'),(12,2,'Bogus Gateway','test',2,'2025-05-28 14:04:41','2025-05-28 14:04:41'),(13,2,'Renier Paolo Sumagui','test',2,'2025-05-28 14:05:18','2025-05-28 14:05:18'),(14,3,'Szchin','awesome',10,'2025-05-28 14:55:01','2025-05-28 14:55:01'),(15,3,'Renier Paolo Sumagui','test',10,'2025-05-28 14:55:20','2025-05-28 14:55:20');
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-28 14:56:43
