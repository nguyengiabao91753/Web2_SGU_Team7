-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: web2
-- ------------------------------------------------------
-- Server version	8.1.0

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
-- Table structure for table `userfunctions`
--

DROP TABLE IF EXISTS `userfunctions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userfunctions` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `LevelId` int DEFAULT NULL,
  `FunctId` int DEFAULT NULL,
  `Action` varchar(50) DEFAULT NULL,
  `Status` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `LevelId` (`LevelId`),
  KEY `FunctId` (`FunctId`),
  CONSTRAINT `userfunctions_ibfk_1` FOREIGN KEY (`LevelId`) REFERENCES `levels` (`LevelId`),
  CONSTRAINT `userfunctions_ibfk_2` FOREIGN KEY (`FunctId`) REFERENCES `functions` (`FunctionId`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userfunctions`
--

LOCK TABLES `userfunctions` WRITE;
/*!40000 ALTER TABLE `userfunctions` DISABLE KEYS */;
INSERT INTO `userfunctions` VALUES (1,1,1,'Create',1),(2,1,1,'Update',1),(3,1,1,'Delete',1),(4,2,1,'Create',0),(5,2,1,'Update',0),(6,2,1,'Delete',0),(7,3,1,'Create',0),(8,3,1,'Update',0),(9,3,1,'Delete',0),(10,4,1,'Create',0),(11,4,1,'Update',0),(12,4,1,'Delete',0),(13,1,2,'Create',1),(14,1,2,'Update',1),(15,1,2,'Delete',1),(16,2,2,'Create',0),(17,2,2,'Update',0),(18,2,2,'Delete',0),(19,3,2,'Create',0),(20,3,2,'Update',0),(21,3,2,'Delete',0),(22,4,2,'Create',0),(23,4,2,'Update',0),(24,4,2,'Delete',0),(25,1,3,'Create',1),(26,1,3,'Update',1),(27,1,3,'Delete',1),(28,2,3,'Create',0),(29,2,3,'Update',0),(30,2,3,'Delete',0),(31,3,3,'Create',0),(32,3,3,'Update',0),(33,3,3,'Delete',0),(34,4,3,'Create',0),(35,4,3,'Update',0),(36,4,3,'Delete',0),(37,1,4,'Create',1),(38,1,4,'Update',1),(39,1,4,'Delete',1),(40,2,4,'Create',0),(41,2,4,'Update',0),(42,2,4,'Delete',0),(43,3,4,'Create',0),(44,3,4,'Update',0),(45,3,4,'Delete',0),(46,4,4,'Create',0),(47,4,4,'Update',0),(48,4,4,'Delete',0),(49,1,5,'Create',1),(50,1,5,'Update',1),(51,1,5,'Delete',1),(52,2,5,'Create',0),(53,2,5,'Update',0),(54,2,5,'Delete',0),(55,3,5,'Create',0),(56,3,5,'Update',0),(57,3,5,'Delete',0),(58,4,5,'Create',0),(59,4,5,'Update',0),(60,4,5,'Delete',0),(61,1,6,'Pending',1),(62,1,6,'Delivering',1),(63,1,6,'Delivered',1),(64,2,6,'Pending',0),(65,2,6,'Delivering',0),(66,2,6,'Delivered',0),(67,3,6,'Pending',0),(68,3,6,'Delivering',0),(69,3,6,'Delivered',0),(70,4,6,'Pending',0),(71,4,6,'Delivering',0),(72,4,6,'Delivered',0),(73,1,7,'Create',1),(74,1,7,'Update',1),(75,1,7,'Delete',1),(76,2,7,'Create',0),(77,2,7,'Update',0),(78,2,7,'Delete',0),(79,3,7,'Create',0),(80,3,7,'Update',0),(81,3,7,'Delete',0),(82,4,7,'Create',0),(83,4,7,'Update',0),(84,4,7,'Delete',0),(85,1,8,'Create',0),(86,1,8,'Update',0),(87,1,8,'Delete',0),(88,2,8,'Create',0),(89,2,8,'Update',0),(90,2,8,'Delete',0),(91,3,8,'Create',0),(92,3,8,'Update',0),(93,3,8,'Delete',0),(94,4,8,'Create',0),(95,4,8,'Update',0),(96,4,8,'Delete',0);
/*!40000 ALTER TABLE `userfunctions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 19:08:28
