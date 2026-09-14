-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: librarysys
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `BookID` smallint(6) NOT NULL AUTO_INCREMENT,
  `GenreCode` char(2) DEFAULT NULL,
  `BookTitle` varchar(30) NOT NULL,
  `Author` varchar(30) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Status` char(1) DEFAULT 'A',
  `IsDeleted` char(1) DEFAULT 'N',
  PRIMARY KEY (`BookID`),
  KEY `GenreCode` (`GenreCode`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`GenreCode`) REFERENCES `genres` (`GenreCode`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (12,'FN','The Silent Shore','Emily Carter','Mystery on a coastal town','A','N'),(13,'HH','Midnight Echo','Daniel Moore','Haunting psychological horror tale','A','N'),(14,'SF','Starfall Colony','Liam Bennett','Space colony survival story','A','N'),(15,'FN','Broken Compass','Anna Reed','Lost traveler survival story','L','N'),(16,'AD','Autumn Expedition','Grace Hall','Journey through unknown lands','L','N'),(17,'MC','Dark Protocol','Mark Stevens','Tech crime investigation thriller','L','N'),(18,'FN','River of Glass','Olivia Turner','Family secrets unfold','A','N'),(19,'MC','The Final Clue','James Parker','Detective solves cold case','A','N'),(20,'SF','Orbit Breaker','Nina Patel','                        Space war epic            ','A','N'),(21,'FN','Hidden Orchard','Laura King','Small town drama story','L','N'),(22,'BI','Life of Edison','Alan West','Biography of Thomas Edison','A','N'),(23,'FN','Ashes of Dawn','Mia Collins','Post-war recovery story','L','N'),(24,'SF','Neon Horizon','Ethan Clarke','Cyberpunk future city','A','N'),(25,'MC','Murder in Ashwood','Victor Lane','Small town murder mystery','A','N'),(26,'FN','The Long Return','Sophie Grant','War veteran returns home','A','N'),(27,'PY','Human Behaviour Guide','Karen Blake','Modern psychology insights','L','N'),(28,'AD','Beyond the Valley','Jack Howard','Adventure into uncharted land','L','N'),(29,'FN','Harry Potter','J.K Rowling','Harry Potter','A','N'),(31,'FN','Harry Potter 2','J.K Rowling','Harry Potter 2','A','N');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genres` (
  `GenreCode` char(2) NOT NULL,
  `GenreDesc` varchar(30) NOT NULL,
  PRIMARY KEY (`GenreCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES ('AD','Adventure'),('BI','Biography'),('FN','Fiction'),('FY','Fantasy'),('HH','Horror'),('MC','Mystery & Crime'),('PY','Psychology'),('SF','Science Fiction');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loans` (
  `LoanID` smallint(6) NOT NULL,
  `MemID` smallint(6) NOT NULL,
  `BookID` smallint(6) NOT NULL,
  `StartDate` date NOT NULL,
  `DueDate` date NOT NULL,
  `ReturnedDate` date DEFAULT NULL,
  PRIMARY KEY (`LoanID`),
  KEY `fk_member_loans` (`MemID`),
  KEY `fk_books_loans` (`BookID`),
  CONSTRAINT `fk_books_loans` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  CONSTRAINT `fk_member_loans` FOREIGN KEY (`MemID`) REFERENCES `members` (`MemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loans`
--

LOCK TABLES `loans` WRITE;
/*!40000 ALTER TABLE `loans` DISABLE KEYS */;
INSERT INTO `loans` VALUES (1,2,23,'2026-04-30','2026-05-07',NULL),(2,2,28,'2026-04-30','2026-05-07',NULL),(3,2,15,'2026-04-30','2026-05-07',NULL),(4,2,17,'2026-04-30','2026-05-07',NULL),(5,2,21,'2026-04-30','2026-05-07',NULL),(6,2,27,'2026-04-30','2026-05-07',NULL);
/*!40000 ALTER TABLE `loans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `MemID` smallint(6) NOT NULL AUTO_INCREMENT,
  `Fname` varchar(25) NOT NULL,
  `Sname` varchar(25) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `IsDeleted` char(1) DEFAULT 'N',
  PRIMARY KEY (`MemID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (2,'John','Murphy','0871234567','john.murphy@email.com','N'),(3,'Emma','O\'Brien','0862345678','emma.obrien@email.com','N'),(4,'Liam','Kelly','0853456789','liam.kelly@email.com','N'),(5,'Aoife','Ryan','0874567890','aoife.ryan@email.com','N'),(6,'Noah','Doyle','0865678901','noah.doyle@email.com','N'),(7,'Sophie','Walsh','0856789012','sophie.walsh@email.com','N'),(8,'Jack','Hughes','0877890123','jack.hughes@email.com','N'),(9,'Mia','Smith','0868901234','mia.smith@email.com','N'),(10,'James','Byrne','0859012345','james.byrne@email.com','N'),(11,'Chloe','Kavanagh','0870123456','chloe.kavanagh@email.com','N'),(12,'Daniel','Fitzgerald','0861122334','daniel.fitz@email.com','N'),(13,'Grace','Reilly','0852233445','grace.reilly@email.com','N'),(14,'Ethan','Ward','0873344556','ethan.ward@email.com','N'),(15,'Ella','Byrne','0864455667','ella.byrne@email.com','N'),(16,'Finn','O\'Connor','0855566778','finn.oconnor@email.com','N'),(17,'Lucy','Moran','0876677889','lucy.moran@email.com','N'),(18,'Adam','Nolan','0867788990','adam.nolan@email.com','N'),(19,'Zoe','Healy','0858899001','zoe.healy@email.com','N'),(20,'Ryan','Kenny','0879900112','ryan.kenny@email.com','N'),(21,'Hannah','Flynn','0861011121','hannah.flynn@email.com','N');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-30 16:30:04
