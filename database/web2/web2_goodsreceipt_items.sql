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
-- Table structure for table `goodsreceipt_items`
--

DROP TABLE IF EXISTS `goodsreceipt_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goodsreceipt_items` (
  `ItemID` int NOT NULL AUTO_INCREMENT,
  `ReceiptId` int DEFAULT NULL,
  `ProductID` int DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Quantity` int DEFAULT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `ReceiptId` (`ReceiptId`),
  KEY `ProductID` (`ProductID`),
  CONSTRAINT `goodsreceipt_items_ibfk_1` FOREIGN KEY (`ReceiptId`) REFERENCES `goodsreceipt` (`ReceiptId`),
  CONSTRAINT `goodsreceipt_items_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goodsreceipt_items`
--

LOCK TABLES `goodsreceipt_items` WRITE;
/*!40000 ALTER TABLE `goodsreceipt_items` DISABLE KEYS */;
INSERT INTO `goodsreceipt_items` VALUES (9,9,1,155.00,12),(10,10,1,155.00,1),(13,13,3,12.00,120),(14,14,11,456.00,20),(15,15,11,912.00,12);
/*!40000 ALTER TABLE `goodsreceipt_items` ENABLE KEYS */;
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
