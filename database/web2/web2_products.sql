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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `ProductID` int NOT NULL AUTO_INCREMENT,
  `Series` int DEFAULT NULL,
  `CategoryID` int DEFAULT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` text,
  `Feature` text,
  `Price` decimal(10,2) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Size` varchar(255) DEFAULT NULL,
  `TotalQuantity` int DEFAULT NULL,
  `Quantity` int DEFAULT NULL,
  `Sale_Quantity` int DEFAULT NULL,
  `Status` int DEFAULT NULL,
  PRIMARY KEY (`ProductID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,123,3,'Áo sơ mi nam 2024','../admin2/img/product-min-03.jpg','','None',122.00,'Black','24',135,132,3,1),(3,123,3,'Áo Cotton Nam','../admin2/img/product-03.jpg','','None',12.00,'White','24',120,120,NULL,1),(4,123,3,'Áo sơ mi nam 2024','../admin2/img/banner-05.jpg','','None',180.00,'Black','40',100,100,0,1),(5,123,3,'Ao Nam','../admin2/img/product-min-02.jpg','','None',50.00,'White','40',100,100,0,1),(6,123,2,'Áo Phông nữ 2024','../admin2/img/product-01.jpg','','None',63.00,'White','37',100,98,2,1),(7,133,2,'Áo Phông nữ 2024','../admin2/img/product-13.jpg','','Feature',63.00,'White','38',100,100,0,1),(8,133,1,'Áo sơ mi nam 2024','../admin2/img/product-11.jpg','','Feature',180.00,'Blue','40',100,95,5,1),(9,133,4,'Áo Phông nữ 2024','../admin2/img/gallery-09.jpg','','Feature',180.00,'Black','38',100,97,3,1),(10,133,1,'Giày Nam','../admin2/img/product-09.jpg','','Feature',180.00,'Black','42',100,95,5,1),(11,123,1,'abc','../admin2/img/banner-09.jpg','','None',912.00,'Black','34',154,154,0,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 19:08:27
