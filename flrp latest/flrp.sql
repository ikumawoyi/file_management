-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: flrp
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

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
-- Table structure for table `archives`
--

DROP TABLE IF EXISTS `archives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archives` (
  `docid` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `filepath` varchar(80) NOT NULL,
  PRIMARY KEY (`docid`,`version`),
  UNIQUE KEY `archives_filepath_uindex` (`filepath`),
  CONSTRAINT `archives_documents_id_fk` FOREIGN KEY (`docid`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archives`
--

LOCK TABLES `archives` WRITE;
/*!40000 ALTER TABLE `archives` DISABLE KEYS */;
/*!40000 ALTER TABLE `archives` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `categories` VALUES ('cbn','Central Bank',NULL,'Central Bank of Nigeria',1),('cbn-acts','Acts','cbn','Acts about the CBN',1),('cbn-circulars','Circulars','cbn','Circulars from the CBN',1),('dmo','DMO',NULL,'Debt Management Office',1),('dmo-acts','Acts','dmo',NULL,1),('dmo-press','Press Releases','dmo','DMO press releases',1),('int','International Regulations',NULL,'International Regulations',1),('int-icma','ICMA','int','International Capital Markets Association',1),('int-icma-pry','Primary Markets','int-icma',NULL,1),('int-icma-sec','Secondary Markets','int-icma',NULL,1),('MoF','Ministry of Finance',NULL,NULL,1),('na-ac-fi-cap','Capital Markets','na-ac-fin',NULL,1),('na-ac-fin','Financial Services','nass-acts',NULL,1),('na-bi-avi','Aviation','nass-bills','Bills impacting the Nigerian aviation industry.',1),('na-bi-fin','Financial Services','nass-bills','Financial services laws of Nigeria',1),('na-bi-fin-cap','Capital Markets','na-bi-fin',NULL,1),('na-bi-fin-tax','Taxation','na-bi-fin',NULL,1),('nass','National Assembly',NULL,'Bills and acts of the National Assembly of Nigeria',1),('nass-acts','Acts','nass','Acts of the national assembly',1),('nass-bills','Bills','nass','Bills of the national assembly',1),('nass-pub','Public Hearings','nass','Public proceedings of the national assembly',1),('PenCom','National Pension Commission',NULL,NULL,1),('PR','Presidency',NULL,NULL,1),('pres-press','Press Releases','presidency',NULL,1),('pres-speech','Speeches','presidency',NULL,1),('presidency','Presidency',NULL,NULL,0),('Rpt','Reports',NULL,NULL,1),('sec','SEC',NULL,'Security and exchange commission',1),('sec-codes','Codes','sec','Codes of SEC',1),('sec-rules','Rules','sec','Rules of SEC',1);
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archive` varchar(180) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_category_index` (`category`),
  CONSTRAINT `documents_categories_code_fk` FOREIGN KEY (`category`) REFERENCES `categories` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES ('http://sec.gov.ng/wp-content/uploads/2017/07/June-2017-SEC-Executed-Rules-Regulations.pdf','sec-rules','New rules and amendments as at June 2017\r\n','New rules and amendments as at June 2017',1,1,NULL),('http://sec.gov.ng/wp-content/uploads/2017/11/SEC-APPROVED-RULES-NOV-2017_BATCH-1.pdf','sec-rules','New rules and amendments as at 22 November 2017-Fixed Income Primary Issuance Fees\r\n','New rules and amendments as at 22 November 2017-Fixed Income Primary Issuance Fees',1,2,NULL),('http://sec.gov.ng/wp-content/uploads/2017/11/SEC-APPROVED-RULES-NOV-2017_BATCH-B.pdf','sec-rules','New rules and amendments as at 22 November 2017- Rules on the regulation of Revenue Bonds and Sundry Amendments\r\n','New rules and amendments as at 22 November 2017- Rules on the regulation of Revenue Bonds and Sundry Amendments',1,3,NULL),('http://www.cbn.gov.ng/Out/2017/CCD/STMA%20ACT,%202017.pdf','cbn-acts','secured transactions in movable asset','secured trans',0,4,NULL),('http://www.dmo.gov.ng/news-and-events/dmo-in-the-news/dmo-inspects-roads-financed-by-sukuk-dualization-of-abuja-abaji-lokoja-road-sect-i','dmo-press','DMO inspects Roads financed by Sukuk - Dualization of Abuja to Abaji to Lokoja Road Sect. I\r\n','DMO inspects Roads financed by Sukuk - Dualization of Abuja to Abaji to Lokoja Road Sect. I',1,5,NULL),('http://www.dmo.gov.ng/news-and-events/dmo-in-the-news/dmo-lists-n100bn-sovereign-sukuk-on-the-fmdq-otc-securities-exchange','dmo-press','DMO Lists N100bn Sovereign Sukuk on The FMDQ OTC Securities Exchange\r\n','DMO Lists N100bn Sovereign Sukuk on The FMDQ OTC Securities Exchange',1,6,NULL),('http://www.dmo.gov.ng/news-and-events/dmo-in-the-news/dmo-lists-n100bn-sovereign-sukuk-on-the-nigerian-stock-exchange','dmo-press','DMO Lists N100bn Sovereign Sukuk on The NSE','DMO Lists N100bn Sovereign Sukuk on The Nigerian Stock Exchange',1,7,NULL),('http://www.dmo.gov.ng/news-and-events/dmo-in-the-news/press-release-using-sukuk-to-finance-infrastructure-dmo-inspects-roads-financed-by-sukuk','dmo-press','Press Release: Using Sukuk to Finance Infrastructure - DMO inspects Roads financed by Sukuk\r\n','Press Release: Using Sukuk to Finance Infrastructure - DMO inspects Roads financed by Sukuk',1,8,NULL),('http://www.dmo.gov.ng/news-and-events/dmo-in-the-news/usd300-million-diaspora-bond-issuance-refutal-of-publication-in-the-punch-newspaper-of-february-8-2018','dmo','USD300 Million Diaspora Bond Issuance - Refutal of Publication in the Punch Newspaper of February 8, 2018\r\n','USD300 Million Diaspora Bond Issuance - Refutal of Publication in the Punch Newspaper of February 8, 2018',1,9,NULL),('http://www.icmagroup.org/assets/documents/Legal/Rulebook/ICMA-Circular-No2-March-1-2017-re-buy-in-and-sell-out-010317.pdf','int-icma-sec','ICMA announces an update of its Buy-in Rules\r\n','ICMA announces an update of its Buy-in Rules',1,10,NULL),('http://www.lawnigeria.com/LFN/B/Banks-and-Other-Financial-Institutions-Act.php','cbn-acts','Banks and Other Financial Institutions (Amendment) Act, 2004\r\n','Banks and Other Financial Institutions (Amendment) Act, 2004',1,11,NULL),('http://www.nassnig.org/document/download/5758','na-ac-fi-cap','Companies and Allied Matters Act (CAMA), Cap C20, LFN 2004','Companies and Allied Matters Act (CAMA), Cap C20, LFN 2004',1,12,NULL),('http://www.nassnig.org/document/download/5822','cbn-acts','CBN Act, 2007\r\n','CBN Act, 2007',1,13,NULL),('http://www.nassnig.org/document/download/8713','na-bi-avi','This Bill seeks to amend the Civil Aviation Act No 6, 2006, to provide for the payment of all monies received by the Commission into the Federation Account in accordance with Section 162 of the Constitution of the Federal Republic of Nigeria 1999 (As amended)','Civil Aviation (Amendment) Bill, 2017',1,14,NULL),('https://nass.gov.ng/document/download/5758','na-ac-fi-cap','Companies and Allied Matters Act (CAMA), Cap C20, LFN 2004','Companies and Allied Matters Act (CAMA), Cap C20, LFN 2004',1,15,NULL),('https://statehouse.gov.ng/news/press-release-president-buhari-approves-retirement-dismissal-of-justices/','pres-press','President Buhari Approves Retirement, Dismissal of Justices\r\n','President Buhari Approves Retirement, Dismissal of Justices',1,16,NULL),('https://statehouse.gov.ng/news/remarks-davos-africa-prefers-fair-trade-to-marshall-plans-vp-osinbajo/','pres-speech','Remarks @ Davos: Africa Prefers Fair Trade to Marshall Plans â€“ VP Osinbajo\r\n','Remarks @ Davos: Africa Prefers Fair Trade to Marshall Plans â€“ VP Osinbajo',1,17,NULL),('https://statehouse.gov.ng/news/speech-president-buharis-address-at-the-30th-ordinary-session-of-assembly-of-heads-of-state-and-government-of-the-african-union/','pres-speech','President Buhariâ€™s Address At the 30th Ordinary Session of Assembly of Heads of State and Government of the African Union','President Buhariâ€™s Address At the 30th Ordinary Session of Assembly of Heads of State and Government of the African Union',1,18,NULL),('https://statehouse.gov.ng/news/speech-vp-osinbajos-address-at-the-commissioning-of-the-new-nestle-factory-in-agbara-ogun-state/','pres-press','VP Osinbajoâ€™s Address at the Commissioning of the New Nestle Factory in Agbara, Ogun State\r\n','VP Osinbajoâ€™s Address at the Commissioning of the New Nestle Factory in Agbara, Ogun State',1,19,NULL),('https://statehouse.gov.ng/news/statement-by-president-buhari-on-the-continental-free-trade-agreement-cfta-delivered-at-the-30th-au-summit/','pres-speech','Statement by President Buhari on the Continental Free Trade Agreement (CFTA), delivered at the 30th AU Summit\r\n','Statement by President Buhari on the Continental Free Trade Agreement (CFTA), delivered at the 30th AU Summit',1,20,NULL),('https://statehouse.gov.ng/news/vp-osinbajos-address-at-the-southwest-regional-summit-in-oshogbo-osun-state/','pres-speech','VP Osinbajoâ€™s Address at the Southwest Regional Summit in Oshogbo, Osun State','VP Osinbajoâ€™s Address at the Southwest Regional Summit in Oshogbo, Osun State',1,21,NULL),('https://www.cbn.gov.ng/Out/2012/CCD/Circular%20on%20Compliance%20with%20the%20Revised%20Guidelines%20for%20PMBs.pdf','cbn-circulars','Re: Circular on Complaince with the Revised Guidelines for Primary Mortgage Banks (December 2012)\r\n','Re: Circular on Complaince with the Revised Guidelines for Primary Mortgage Banks (December 2012)',0,22,NULL),('https://www.cbn.gov.ng/out/2016/ccd/circular%20on%20externalisation.pdf','cbn-circulars','Externalisation of Differentials on OTC FX Futures Contracts for Foreign Portfolio Investors (June 2016)\r\n','Externalisation of Differentials on OTC FX Futures Contracts for Foreign Portfolio Investors (June 2016)',1,23,NULL),('https://www.icmagroup.org/Regulatory-Policy-and-Market-Practice/Primary-Markets/ipma-handbook-home/','int-icma-pry','ICMA Primary Markets Handbook\r\n','ICMA Primary Markets Handbook',1,24,NULL),('https://www.icmagroup.org/Regulatory-Policy-and-Market-Practice/Secondary-Markets/ICMA-Rule-Book/','int-icma-sec','ICMAâ€™s rules and recommendations for the secondary marketÂ \r\n','ICMAâ€™s rules and recommendations for the secondary marketÂ ',1,25,NULL),('https://www.icmagroup.org/Regulatory-Policy-and-Market-Practice/Secondary-Markets/secondary-markets-regulation/csdr-settlement-discipline/','int-icma-sec','CSDR settlement discipline\r\n','CSDR settlement discipline',1,26,NULL),('https://www.icmagroup.org/Regulatory-Policy-and-Market-Practice/Secondary-Markets/secondary-markets-regulation/mar-investment-recommendations/','int-icma-sec','MAR/Investment recommendations\r\n','MAR/Investment recommendations',1,27,NULL),('https://www.icmagroup.org/Regulatory-Policy-and-Market-Practice/Secondary-Markets/secondary-markets-regulation/mifid-ii-r/','int-icma-sec','MiFID II/R implementation in Secondary markets\r\n','MiFID II/R implementation in Secondary markets',1,28,NULL),('http://sec.gov.ng/code-of-conduct-for-shareholders-associations/','sec-codes','Code of Corporate Governance for Shareholders Associations\r\n','Code of Corporate Governance for Shareholders Associations',1,29,NULL),('http://sec.gov.ng/files/New%20rules%20April%202015/Update%2017APR2015/AMENDMENTS_17415.pdf','sec-rules','Sundry Amendments to SEC Rules and Regulations_April 13, 2015\r\n','Sundry Amendments to SEC Rules and Regulations_April 13, 2015',1,30,NULL),('http://sec.gov.ng/files/New%20rules%20April%202015/Update%2017APR2015/CODE%20OF%20CONDUCT%20FOR%20RATING%20AGENCIES_17415.pdf','sec-codes','Code of Conduct for Rating Agencies_April 13, 2015\r\n','Code of Conduct for Rating Agencies_April 13, 2015',1,31,NULL),('http://sec.gov.ng/files/New%20rules%20April%202015/Update%2017APR2015/CODE%20OF%20CONDUCT%20FOR%20TRUSTEES_17415.pdf','sec-codes','Code of Conduct for Trustees_April 13, 2015','Code of Conduct for Trustees_April 13, 2015',1,32,NULL),('http://sec.gov.ng/sec-nigerias-consolidated-rules-and-regulations-as-at-2013/','sec-rules','SEC Nigeriaâ€™s Consolidated Rules and Regulations as at 2013\r\n','SEC Nigeriaâ€™s Consolidated Rules and Regulations as at 2013',1,33,NULL),('http://sec.gov.ng/wp-content/uploads/2016/06/CODE-OF-CORPORATE-GOVERNANCE_web-optimized.pdf','sec-codes','Code of Corporate Governance for Public Companies_4 AprilÂ 2011\r\n','Code of Corporate Governance for Public Companies_4 AprilÂ 2011',1,34,NULL);
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
INSERT INTO `users` VALUES ('adakolejoy1996@gmail.com','Joy','2bd5b4feab558d72a6adc9482ba854da1d48ba1c8db2a27696ae25a6baa1b5d8',0,'Trusoft limited',1),('adewale@trusoftng.com','adewale','151e9a89ad466bf672a735c27d70bfcfda829c916da56f786013fbea5786280c',0,'Trusoft limited',1),('admin@fmdqotc.com','FLRP Admin','7c27de70e2bb238d2bd8b143af1197e27eaf24a3090d72303c4dfb0a18e27922',1,'FMDQ',1),('janel.origho@fmdqotc.com','Janel Origho','299b25dadb7596d99396b75645f9c93eb8376b27653409637bf4ce9b92a3c49f',1,'FMDQ',1),('olayide.omotoso@fmdqotc.com','Olayide Omotoso','debece296f6eda39a9c29081d5728c1367f00ccdcc90aa758e55267f02b20c12',0,'FMDQ',1),('oyekan.oluwatobi.adebayo@gmail.com','oyekan','7dfb34a014fcda1f4465cd2b616eabe4e6c75d23f2034f92c9958964c332e588',0,'Trusoft limited',1),('tobainocycle@gmail.com','oluwatobi','becd00f8bcdda7aca4de8b594a664b82fa32b73779964ce5319abf6ee6f418d0',1,'Trusoft limited',1),('tolumania@gmail.com','Tolu Ogunremi','409a14887e0958f1efcd8de91a587561397bfcc5d994b9d6cfc2d758c8b49296',1,'Trusoft Limited',0),('user@fmdqotc.com','FMDQ FLRP','7c27de70e2bb238d2bd8b143af1197e27eaf24a3090d72303c4dfb0a18e27922',0,'FMDQ',1);
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

-- Dump completed on 2018-08-07 10:42:33
