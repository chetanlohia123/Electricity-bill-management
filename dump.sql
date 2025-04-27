-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: electricity_bill_system
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Account` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `cust_id` int DEFAULT NULL,
  `account_number` varchar(50) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `Customer` (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Account`
--

LOCK TABLES `Account` WRITE;
/*!40000 ALTER TABLE `Account` DISABLE KEYS */;
INSERT INTO `Account` VALUES (1,1,'ACC000001','Active'),(2,2,'ACC000002','Active'),(3,3,'ACC000003','Active'),(4,4,'ACC000004','Active'),(5,5,'ACC000005','Active'),(6,6,'ACC000006','Active'),(7,7,'ACC000007','Active'),(8,8,'ACC000008','Active'),(9,9,'ACC000009','Active'),(10,10,'ACC000010','Active'),(11,11,'ACC000011','Active'),(12,12,'ACC000012','Active'),(13,13,'ACC000013','Active'),(14,14,'ACC000014','Active'),(15,15,'ACC000015','Active');
/*!40000 ALTER TABLE `Account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Address`
--

DROP TABLE IF EXISTS `Address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Address`
--

LOCK TABLES `Address` WRITE;
/*!40000 ALTER TABLE `Address` DISABLE KEYS */;
INSERT INTO `Address` VALUES (1,'123 Main St','',''),(2,'456 Oak St','',''),(3,'789 Pine St','',''),(4,'101 Elm St','',''),(5,'202 Birch St','',''),(6,'303 Cedar St','',''),(7,'404 Maple St','',''),(8,'505 Spruce St','',''),(9,'606 Willow St','',''),(10,'707 Ash St','',''),(11,'808 Cherry St','',''),(12,'909 Poplar St','',''),(13,'111 Lime St','',''),(14,'222 Peach St','',''),(15,'333 Plum St','','');
/*!40000 ALTER TABLE `Address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `login_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `login_id` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (1,'admin1@example.com','admin123'),(2,'admin2@example.com','admin456'),(3,'admin3@example.com','admin789'),(4,'admin4@example.com','admin101'),(5,'admin5@example.com','admin202'),(6,'admin6@example.com','admin303'),(7,'admin7@example.com','admin404'),(8,'admin8@example.com','admin505'),(9,'admin9@example.com','admin606'),(10,'admin10@example.com','admin707'),(11,'admin11@example.com','admin808'),(12,'admin12@example.com','admin909'),(13,'admin13@example.com','admin111'),(14,'admin14@example.com','admin222'),(15,'admin15@example.com','admin333'),(16,'chetan@email.com','chetan');
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Bills`
--

DROP TABLE IF EXISTS `Bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Bills` (
  `bill_id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bill_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Paid') DEFAULT 'Pending',
  PRIMARY KEY (`bill_id`),
  UNIQUE KEY `account_id` (`account_id`,`bill_date`),
  CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `Account` (`account_id`),
  CONSTRAINT `chk_amount` CHECK ((`amount` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Bills`
--

LOCK TABLES `Bills` WRITE;
/*!40000 ALTER TABLE `Bills` DISABLE KEYS */;
INSERT INTO `Bills` VALUES (1,1,15.00,'2025-02-01','2025-02-15','Pending'),(2,2,18.00,'2025-02-01','2025-02-15','Pending'),(3,3,13.50,'2025-02-01','2025-02-15','Pending'),(4,4,16.50,'2025-02-01','2025-02-15','Paid'),(5,5,19.50,'2025-02-01','2025-02-15','Pending'),(6,6,14.25,'2025-02-01','2025-02-15','Pending'),(7,7,17.25,'2025-02-01','2025-02-15','Pending'),(8,8,18.75,'2025-02-01','2025-02-15','Pending'),(9,9,15.75,'2025-02-01','2025-02-15','Pending'),(10,10,20.25,'2025-02-01','2025-02-15','Pending'),(11,11,12.75,'2025-02-01','2025-02-15','Pending'),(12,12,21.00,'2025-02-01','2025-02-15','Pending'),(13,13,22.50,'2025-02-01','2025-02-15','Pending'),(14,14,12.00,'2025-02-01','2025-02-15','Pending'),(15,15,21.75,'2025-02-01','2025-02-15','Pending');
/*!40000 ALTER TABLE `Bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customer`
--

DROP TABLE IF EXISTS `Customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Customer` (
  `cust_id` int NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address_id` int NOT NULL,
  PRIMARY KEY (`cust_id`),
  UNIQUE KEY `email` (`email`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `Address` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customer`
--

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;
INSERT INTO `Customer` VALUES (1,'John Doe','john@example.com','pass123',1),(2,'Jane Smith','jane@example.com','pass456',2),(3,'Alice Brown','alice@example.com','pass789',3),(4,'Bob Johnson','bob@example.com','pass101',4),(5,'Carol White','carol@example.com','pass202',5),(6,'David Lee','david@example.com','pass303',6),(7,'Eve Black','eve@example.com','pass404',7),(8,'Frank Green','frank@example.com','pass505',8),(9,'Grace Hill','grace@example.com','pass606',9),(10,'Hank Gray','hank@example.com','pass707',10),(11,'Ivy Blue','ivy@example.com','pass808',11),(12,'Jack Red','jack@example.com','pass909',12),(13,'Kelly Yellow','kelly@example.com','pass111',13),(14,'Liam Orange','liam@example.com','pass222',14),(15,'Mia Purple','mia@example.com','pass333',15);
/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `customer_bill_summary`
--

DROP TABLE IF EXISTS `customer_bill_summary`;
/*!50001 DROP VIEW IF EXISTS `customer_bill_summary`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `customer_bill_summary` AS SELECT 
 1 AS `cust_id`,
 1 AS `cust_name`,
 1 AS `total_bills`,
 1 AS `total_amount`,
 1 AS `pending_amount`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Customer_Interaction`
--

DROP TABLE IF EXISTS `Customer_Interaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Customer_Interaction` (
  `interaction_id` int NOT NULL AUTO_INCREMENT,
  `cust_id` int NOT NULL,
  `interaction_type` enum('Complaint','Support','Feedback') NOT NULL,
  `description` text NOT NULL,
  `interaction_date` date NOT NULL,
  `status` enum('Pending','Resolved','Open','Closed') NOT NULL,
  PRIMARY KEY (`interaction_id`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `customer_interaction_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `Customer` (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customer_Interaction`
--

LOCK TABLES `Customer_Interaction` WRITE;
/*!40000 ALTER TABLE `Customer_Interaction` DISABLE KEYS */;
INSERT INTO `Customer_Interaction` VALUES (1,1,'Complaint','Power outage','2025-02-01','Resolved'),(2,2,'Complaint','High bill','2025-02-02','Resolved'),(3,3,'Complaint','Meter issue','2025-02-03','Resolved'),(4,4,'Complaint','Billing error','2025-02-04','Resolved'),(5,5,'Complaint','No supply','2025-02-05','Resolved'),(6,6,'Complaint','Overcharge','2025-02-06','Resolved'),(7,7,'Complaint','Frequent outages','2025-02-07','Pending'),(8,8,'Complaint','Meter reading error','2025-02-08','Resolved'),(9,9,'Complaint','Service delay','2025-02-09','Pending'),(10,10,'Complaint','Wrong bill','2025-02-10','Resolved'),(11,11,'Complaint','Power surge','2025-02-11','Resolved'),(12,12,'Complaint','Billing dispute','2025-02-12','Resolved'),(13,13,'Complaint','No response','2025-02-13','Pending'),(14,14,'Complaint','Meter fault','2025-02-14','Resolved'),(15,15,'Complaint','High rates','2025-02-15','Pending'),(16,1,'Support','Billing query','2025-02-01','Open'),(17,2,'Support','Meter failure','2025-02-02','Closed'),(18,3,'Support','Payment issue','2025-02-03','Open'),(19,4,'Support','Service disruption','2025-02-04','Closed'),(20,5,'Support','High bill complaint','2025-02-05','Open'),(21,6,'Support','Support delay','2025-02-06','Closed'),(22,7,'Support','Outage report','2025-02-07','Open'),(23,8,'Support','Billing error','2025-02-08','Closed'),(24,9,'Support','Meter reading dispute','2025-02-09','Open'),(25,10,'Support','Payment not updated','2025-02-10','Closed'),(26,11,'Support','Service request','2025-02-11','Open'),(27,12,'Support','Penalty query','2025-02-12','Closed'),(28,13,'Support','Tariff question','2025-02-13','Open'),(29,14,'Support','Outage follow-up','2025-02-14','Closed'),(30,15,'Support','General inquiry','2025-02-15','Open'),(31,4,'Support','dbxcvbvb','2025-04-06','Open'),(32,4,'Support','dbxcvbvb','2025-04-06','Open'),(47,1,'Feedback','Good service','2025-02-01','Resolved'),(48,2,'Feedback','Slow response','2025-02-02','Resolved'),(49,3,'Feedback','Friendly staff','2025-02-03','Resolved'),(50,4,'Feedback','Needs improvement','2025-02-04','Resolved'),(51,5,'Feedback','Reliable power','2025-02-05','Resolved'),(52,6,'Feedback','Billing issues','2025-02-06','Resolved'),(53,7,'Feedback','Great support','2025-02-07','Resolved'),(54,8,'Feedback','Poor communication','2025-02-08','Resolved'),(55,9,'Feedback','Fast fixes','2025-02-09','Resolved'),(56,10,'Feedback','High costs','2025-02-10','Resolved'),(57,11,'Feedback','Excellent','2025-02-11','Resolved'),(58,12,'Feedback','Average service','2025-02-12','Resolved'),(59,13,'Feedback','Very good','2025-02-13','Resolved'),(60,14,'Feedback','Bad experience','2025-02-14','Resolved'),(61,15,'Feedback','Satisfactory','2025-02-15','Resolved'),(62,1,'Complaint','asdfghj','2025-04-16','Resolved'),(63,1,'Feedback','sdfgnbvcsxz','2025-04-16','Resolved'),(64,1,'Support','sdertyjkmhngbfds','2025-04-16','Closed');
/*!40000 ALTER TABLE `Customer_Interaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Meter`
--

DROP TABLE IF EXISTS `Meter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Meter` (
  `meter_id` int NOT NULL AUTO_INCREMENT,
  `cust_id` int DEFAULT NULL,
  `meter_number` varchar(50) NOT NULL,
  `installation_date` date NOT NULL,
  PRIMARY KEY (`meter_id`),
  UNIQUE KEY `meter_number` (`meter_number`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `meter_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `Customer` (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Meter`
--

LOCK TABLES `Meter` WRITE;
/*!40000 ALTER TABLE `Meter` DISABLE KEYS */;
INSERT INTO `Meter` VALUES (1,1,'MTR000001','2025-01-01'),(2,2,'MTR000002','2025-01-02'),(3,3,'MTR000003','2025-01-03'),(4,4,'MTR000004','2025-01-04'),(5,5,'MTR000005','2025-01-05'),(6,6,'MTR000006','2025-01-06'),(7,7,'MTR000007','2025-01-07'),(8,8,'MTR000008','2025-01-08'),(9,9,'MTR000009','2025-01-09'),(10,10,'MTR000010','2025-01-10'),(11,11,'MTR000011','2025-01-11'),(12,12,'MTR000012','2025-01-12'),(13,13,'MTR000013','2025-01-13'),(14,14,'MTR000014','2025-01-14'),(15,15,'MTR000015','2025-01-15');
/*!40000 ALTER TABLE `Meter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Meter_Readings`
--

DROP TABLE IF EXISTS `Meter_Readings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Meter_Readings` (
  `reading_id` int NOT NULL AUTO_INCREMENT,
  `meter_id` int DEFAULT NULL,
  `reading_date` date NOT NULL,
  `units_consumed` int NOT NULL,
  PRIMARY KEY (`reading_id`),
  KEY `meter_id` (`meter_id`),
  CONSTRAINT `meter_readings_ibfk_1` FOREIGN KEY (`meter_id`) REFERENCES `Meter` (`meter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Meter_Readings`
--

LOCK TABLES `Meter_Readings` WRITE;
/*!40000 ALTER TABLE `Meter_Readings` DISABLE KEYS */;
INSERT INTO `Meter_Readings` VALUES (1,1,'2025-02-01',100),(2,2,'2025-02-01',120),(3,3,'2025-02-01',90),(4,4,'2025-02-01',110),(5,5,'2025-02-01',130),(6,6,'2025-02-01',95),(7,7,'2025-02-01',115),(8,8,'2025-02-01',125),(9,9,'2025-02-01',105),(10,10,'2025-02-01',135),(11,11,'2025-02-01',85),(12,12,'2025-02-01',140),(13,13,'2025-02-01',150),(14,14,'2025-02-01',80),(15,15,'2025-02-01',145),(16,1,'2025-04-09',20),(17,1,'2025-02-01',100),(18,2,'2025-02-01',120),(19,3,'2025-02-01',90),(20,4,'2025-02-01',110),(21,5,'2025-02-01',130),(22,6,'2025-02-01',95),(23,7,'2025-02-01',115),(24,8,'2025-02-01',125),(25,9,'2025-02-01',105),(26,10,'2025-02-01',135),(27,11,'2025-02-01',85),(28,12,'2025-02-01',140),(29,13,'2025-02-01',150),(30,14,'2025-02-01',80),(31,15,'2025-02-01',145),(32,1,'2025-04-09',20),(48,10,'2025-04-15',12),(49,11,'2025-04-08',22),(50,7,'2025-04-07',122),(51,1,'2025-04-16',12);
/*!40000 ALTER TABLE `Meter_Readings` ENABLE KEYS */;
UNLOCK TABLES;
 
--
-- Table structure for table `Notification`
--

DROP TABLE IF EXISTS `Notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Notification` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `cust_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `notification_date` date NOT NULL,
  `status` enum('Sent','Pending') DEFAULT 'Pending',
  PRIMARY KEY (`notification_id`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `Customer` (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Notification`
--

LOCK TABLES `Notification` WRITE;
/*!40000 ALTER TABLE `Notification` DISABLE KEYS */;
INSERT INTO `Notification` VALUES (1,1,'Bill due soon','2025-02-10','Pending'),(2,2,'Payment received','2025-02-11','Sent'),(3,3,'Meter reading scheduled','2025-02-12','Pending'),(4,4,'Complaint resolved','2025-02-13','Sent'),(5,5,'Bill overdue','2025-02-14','Pending'),(6,6,'Payment confirmed','2025-02-15','Sent'),(7,7,'Outage alert','2025-02-16','Pending'),(8,8,'Feedback received','2025-02-17','Sent'),(9,9,'Service update','2025-02-18','Pending'),(10,10,'Bill issued','2025-02-19','Sent'),(11,11,'Maintenance notice','2025-02-20','Pending'),(12,12,'Payment reminder','2025-02-21','Sent'),(13,13,'New tariff rates','2025-02-22','Pending'),(14,14,'Support request','2025-02-23','Sent'),(15,15,'Penalty applied','2025-02-24','Pending'),(16,1,'New complaint submitted.','2025-04-16','Pending');
/*!40000 ALTER TABLE `Notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_History`
--

DROP TABLE IF EXISTS `Payment_History`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Payment_History` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `payment_id` int DEFAULT NULL,
  `cust_id` int DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `cust_id` (`cust_id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `Customer` (`cust_id`),
  CONSTRAINT `payment_history_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `Payments` (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_History`
--

LOCK TABLES `Payment_History` WRITE;
/*!40000 ALTER TABLE `Payment_History` DISABLE KEYS */;
INSERT INTO `Payment_History` VALUES (1,1,1,15.00,'2025-02-10'),(2,2,2,18.00,'2025-02-11'),(3,3,3,13.50,'2025-02-12'),(4,4,4,16.50,'2025-02-13'),(5,5,5,19.50,'2025-02-14'),(6,6,6,14.25,'2025-02-15'),(7,7,7,17.25,'2025-02-16'),(8,8,8,18.75,'2025-02-17'),(9,9,9,15.75,'2025-02-18'),(10,10,10,20.25,'2025-02-19'),(11,11,11,12.75,'2025-02-20'),(12,12,12,21.00,'2025-02-21'),(13,13,13,22.50,'2025-02-22'),(14,14,14,12.00,'2025-02-23'),(15,15,15,21.75,'2025-02-24'),(16,1,1,15.00,'2025-02-10'),(17,2,2,18.00,'2025-02-11'),(18,3,3,13.50,'2025-02-12'),(19,4,4,16.50,'2025-02-13'),(20,5,5,19.50,'2025-02-14'),(21,6,6,14.25,'2025-02-15'),(22,7,7,17.25,'2025-02-16'),(23,8,8,18.75,'2025-02-17'),(24,9,9,15.75,'2025-02-18'),(25,10,10,20.25,'2025-02-19'),(26,11,11,12.75,'2025-02-20'),(27,12,12,21.00,'2025-02-21'),(28,13,13,22.50,'2025-02-22'),(29,14,14,12.00,'2025-02-23'),(30,15,15,21.75,'2025-02-24'),(31,16,4,16.50,'2025-04-06');
/*!40000 ALTER TABLE `Payment_History` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payments`
--

DROP TABLE IF EXISTS `Payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `bill_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `Bills` (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payments`
--

LOCK TABLES `Payments` WRITE;
/*!40000 ALTER TABLE `Payments` DISABLE KEYS */;
INSERT INTO `Payments` VALUES (1,1,15.00,'2025-02-10'),(2,2,18.00,'2025-02-11'),(3,3,13.50,'2025-02-12'),(4,4,16.50,'2025-02-13'),(5,5,19.50,'2025-02-14'),(6,6,14.25,'2025-02-15'),(7,7,17.25,'2025-02-16'),(8,8,18.75,'2025-02-17'),(9,9,15.75,'2025-02-18'),(10,10,20.25,'2025-02-19'),(11,11,12.75,'2025-02-20'),(12,12,21.00,'2025-02-21'),(13,13,22.50,'2025-02-22'),(14,14,12.00,'2025-02-23'),(15,15,21.75,'2025-02-24'),(16,4,16.50,'2025-04-06');
/*!40000 ALTER TABLE `Payments` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_payment_insert` AFTER INSERT ON `payments` FOR EACH ROW BEGIN
    INSERT INTO Payment_History (payment_id, cust_id, amount, payment_date)
    VALUES (NEW.payment_id, NEW.cust_id, NEW.amount, NEW.payment_date);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Penalty`
--

DROP TABLE IF EXISTS `Penalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Penalty` (
  `penalty_id` int NOT NULL AUTO_INCREMENT,
  `bill_id` int DEFAULT NULL,
  `penalty_amount` decimal(10,2) NOT NULL,
  `penalty_date` date NOT NULL,
  PRIMARY KEY (`penalty_id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `penalty_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `Bills` (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Penalty`
--

LOCK TABLES `Penalty` WRITE;
/*!40000 ALTER TABLE `Penalty` DISABLE KEYS */;
INSERT INTO `Penalty` VALUES (1,1,1.50,'2025-02-16'),(2,2,1.80,'2025-02-16'),(3,3,1.35,'2025-02-16'),(4,4,1.65,'2025-02-16'),(5,5,1.95,'2025-02-16'),(6,6,1.43,'2025-02-16'),(7,7,1.73,'2025-02-16'),(8,8,1.88,'2025-02-16'),(9,9,1.58,'2025-02-16'),(10,10,2.03,'2025-02-16'),(11,11,1.28,'2025-02-16'),(12,12,2.10,'2025-02-16'),(13,13,2.25,'2025-02-16'),(14,14,1.20,'2025-02-16'),(15,15,2.18,'2025-02-16');
/*!40000 ALTER TABLE `Penalty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tariff`
--

DROP TABLE IF EXISTS `Tariff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tariff` (
  `tariff_id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  PRIMARY KEY (`tariff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tariff`
--

LOCK TABLES `Tariff` WRITE;
/*!40000 ALTER TABLE `Tariff` DISABLE KEYS */;
INSERT INTO `Tariff` VALUES (1,'Domestic',0.15),(2,'Domestic Low',0.10),(3,'Domestic Medium',0.15),(4,'Domestic High',0.20),(5,'Commercial Low',0.25),(6,'Commercial Medium',0.30),(7,'Commercial High',0.35),(8,'Industrial Low',0.40),(9,'Industrial Medium',0.45),(10,'Industrial High',0.50),(11,'Rural Low',0.08),(12,'Rural Medium',0.12),(13,'Rural High',0.18),(14,'Special Low',0.22),(15,'Special Medium',0.28),(16,'Special High',0.32),(17,'low level',0.65);
/*!40000 ALTER TABLE `Tariff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `customer_bill_summary`
--

/*!50001 DROP VIEW IF EXISTS `customer_bill_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `customer_bill_summary` AS select `c`.`cust_id` AS `cust_id`,`c`.`cust_name` AS `cust_name`,count(`b`.`bill_id`) AS `total_bills`,sum(`b`.`amount`) AS `total_amount`,sum((case when (`b`.`status` = 'Pending') then `b`.`amount` else 0 end)) AS `pending_amount` from ((`customer` `c` left join `account` `a` on((`c`.`cust_id` = `a`.`cust_id`))) left join `bills` `b` on((`a`.`account_id` = `b`.`account_id`))) group by `c`.`cust_id`,`c`.`cust_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-25  8:56:42
