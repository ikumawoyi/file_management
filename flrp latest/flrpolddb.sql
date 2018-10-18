-- MySQL dump 10.13  Distrib 5.7.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: flrp
-- ------------------------------------------------------
-- Server version	5.7.18

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `parent` varchar(20) DEFAULT NULL,
  `description` varchar(350) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`code`),
  UNIQUE KEY `categories_name_parent_uindex` (`name`,`parent`),
  KEY `categories_categories_code_fk` (`parent`),
  CONSTRAINT `categories_categories_code_fk` FOREIGN KEY (`parent`) REFERENCES `categories` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES ('cbn','Central Bank',NULL,'Central Bank of Nigeria',1),('cbn-acts','Acts','cbn','Acts about the CBN',1),('cbn-circulars','Circulars','cbn','Circulars from the CBN',1),('dmo','DMO',NULL,'Debt Management Office',1),('dmo-press','Press Releases','dmo','DMO press releases',1),('int','International Regulations',NULL,'International Regulations',1),('int-icma','ICMA','int','International Capital Markets Association',1),('int-icma-pry','Primary Markets','int-icma',NULL,1),('int-icma-sec','Secondary Markets','int-icma',NULL,1),('na-ac-fi-cap','Capital Markets','na-ac-fin',NULL,1),('na-ac-fin','Financial Services','nass-acts',NULL,1),('na-bi-avi','Aviation','nass-bills','Bills impacting the Nigerian aviation industry.',1),('na-bi-fin','Financial Services','nass-bills','Financial services laws of Nigeria',1),('na-bi-fin-cap','Capital Markets','na-bi-fin',NULL,1),('na-bi-fin-tax','Taxation','na-bi-fin',NULL,1),('nass','National Assembly',NULL,'Bills and acts of the National Assembly of Nigeria',1),('nass-acts','Acts','nass','Acts of the national assembly',1),('nass-bills','Bills','nass','Bills of the national assembly',1),('nass-pub','Public Hearings','nass','Public proceedings of the national assembly',1),('pres-press','Press Releases','presidency',NULL,1),('pres-speech','Speeches','presidency',NULL,1),('presidency','Presidency',NULL,NULL,1),('sec','SEC',NULL,'Security and exchange commission',1),('sec-codes','Codes','sec','Codes of SEC',1),('sec-rules','Rules','sec','Rules of SEC',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `path` varchar(180) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(1250) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`path`),
  UNIQUE KEY `documents_path_uindex` (`path`),
  KEY `documents_category_index` (`category`),
  CONSTRAINT `documents_categories_code_fk` FOREIGN KEY (`category`) REFERENCES `categories` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES ('http://www.nassnig.org/document/download/8713','na-bi-avi','This Bill seeks to amend the Civil Aviation Act No 6, 2006, to provide for the payment of all monies received by the Commission into the Federation Account in accordance with Section 162 of the Constitution of the Federal Republic of Nigeria 1999 (As amended)','Civil Aviation (Amendment) Bill, 2017',1);
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `email` varchar(75) NOT NULL,
  `fullname` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isadmin` tinyint(1) DEFAULT '0',
  `organization` varchar(60) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('adewale@gmail.com','Adewale','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',0,'Trusoft Limited',1),('charlesadeleke@gmail.com','Charles Adeleke','dd17f9c058bd202cc3ff0390ce47af683784a9644936e46d5c19f31a9e91f434',0,'Trusoft Limited',1),('johnayo@gmail.com','John Adokie','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',0,'Trusoft Limited',1),('olawale@yahoo.com','Adeola Olawale','$2y$10$tBB/F8pWzbsezfhOx0GEgON1U1S.ws.Xd3s3zsSR0Yq/BDV5OD.Pu',0,'Trusoft Limited',1),('olayide@fmdqotc.com','Olayide Omotoso','19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd',0,'FMDQ',1),('tolumania@gmail.com','Tolu Ogunremi','409a14887e0958f1efcd8de91a587561397bfcc5d994b9d6cfc2d758c8b49296',1,'Trusoft Limited',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-18 15:14:37
