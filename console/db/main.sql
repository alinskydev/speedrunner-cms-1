-- MySQL dump 10.13  Distrib 5.7.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sr-cms
-- ------------------------------------------------------
-- Server version	5.7.29

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
-- Table structure for table `Banner`
--

DROP TABLE IF EXISTS `Banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` enum('slider_home','slider_about') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Banner`
--

LOCK TABLES `Banner` WRITE;
/*!40000 ALTER TABLE `Banner` DISABLE KEYS */;
INSERT INTO `Banner` VALUES (2,'r','slider_home','2019-09-22 10:30:00','2020-10-29 00:31:12'),(3,'qwe','slider_about','2019-09-22 10:30:00','2020-10-26 02:37:23');
/*!40000 ALTER TABLE `Banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BannerGroup`
--

DROP TABLE IF EXISTS `BannerGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BannerGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `text_1` json NOT NULL,
  `text_2` json NOT NULL,
  `text_3` json NOT NULL,
  `link` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bannerimage_ibfk_1` (`item_id`),
  KEY `sort` (`sort`),
  CONSTRAINT `bannergroup_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `Banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BannerGroup`
--

LOCK TABLES `BannerGroup` WRITE;
/*!40000 ALTER TABLE `BannerGroup` DISABLE KEYS */;
INSERT INTO `BannerGroup` VALUES (5,3,'{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}','{\"de\": \"fe\", \"en\": \"fef\", \"ru\": \"fe\"}','{\"de\": \"\", \"en\": \"gr\", \"ru\": \"\"}','{\"de\": \"fwef\", \"en\": \"fwef\", \"ru\": \"fwef\"}','/uploads/media/svg_html.svg',0),(6,3,'{\"de\": \"\", \"en\": \"gergerg\", \"ru\": \"\"}','{\"de\": \"fewf\", \"en\": \"\", \"ru\": \"fewf\"}','{\"de\": \"fwe\", \"en\": \"fwe\", \"ru\": \"fwe\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/jpg.jpg',1),(12,2,'{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}','{\"de\": \"rwer\", \"en\": \"rwer\", \"ru\": \"rwer\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/jpg.jpg',0);
/*!40000 ALTER TABLE `BannerGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Block`
--

DROP TABLE IF EXISTS `Block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `value` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `block_ibfk_2` (`type_id`),
  KEY `block_ibfk_1` (`page_id`),
  KEY `sort` (`sort`),
  CONSTRAINT `block_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `BlockPage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `block_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `BlockType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Block`
--

LOCK TABLES `Block` WRITE;
/*!40000 ALTER TABLE `Block` DISABLE KEYS */;
INSERT INTO `Block` VALUES (13,3,8,'\"title all\"',0),(14,3,9,'{\"de\": \"title de\", \"en\": \"title en\", \"ru\": \"title ru\"}',1),(15,3,12,'[]',2),(16,3,13,'{\"de\": [\"/uploaded/1592682565__DA3TQ3PeeFoXaic.png\"], \"en\": [], \"ru\": [\"/uploaded/1592682558_znAQz4xyZeevl9oU.png\"]}',3),(17,3,14,'[{\"image\": \"/uploads/media/jpg.jpg\", \"is_available\": \"0\"}, {\"image\": \"/uploads/images/logo.png\", \"is_available\": \"1\"}]',4),(18,3,15,'{\"de\": [], \"en\": [{\"title\": \"asd\", \"description\": \"<p>asd</p><p>asd</p>\"}, {\"title\": \"qwe\", \"description\": \"<p>qwe</p><p>qwe</p>\"}], \"ru\": []}',5);
/*!40000 ALTER TABLE `Block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockPage`
--

DROP TABLE IF EXISTS `BlockPage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockPage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockPage`
--

LOCK TABLES `BlockPage` WRITE;
/*!40000 ALTER TABLE `BlockPage` DISABLE KEYS */;
INSERT INTO `BlockPage` VALUES (3,'{\"de\": \"Page 1\", \"en\": \"Page 1\", \"ru\": \"Page 1\"}','page-1','2020-06-15 22:20:00','2020-10-12 08:46:17');
/*!40000 ALTER TABLE `BlockPage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockType`
--

DROP TABLE IF EXISTS `BlockType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('textInput','textArea','checkbox','CKEditor','ElFinder','images','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockType`
--

LOCK TABLES `BlockType` WRITE;
/*!40000 ALTER TABLE `BlockType` DISABLE KEYS */;
INSERT INTO `BlockType` VALUES (8,'title_1','Title 1','textInput','[]','/uploads/media/image.png',0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(9,'title_2','Title 2','textInput','[]','/uploads/media/svg_image.svg',1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(10,'description_1','Description 1','textArea','[]','/uploads/media/jpg.jpg',0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(11,'description_2','Description 2','CKEditor','[]','/uploads/images/logo.png',1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(12,'images_1','Images 1','images','[]','/uploads/images/editor/5ba26895f4021.png',0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(13,'images_2','Images 2','images','[]','/uploads/images/editor/5bc44f0c699b4.png',1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(14,'groups_1','Groups 1','groups','[{\"name\": \"is_available\", \"type\": \"checkbox\", \"label\": \"Available\"}, {\"name\": \"image\", \"type\": \"ElFinder\", \"label\": \"Image\"}]','/uploads/images/flags/au.png',0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(15,'groups_2','Groups 2','groups','[{\"name\": \"title\", \"type\": \"textInput\", \"label\": \"Title\"}, {\"name\": \"description\", \"type\": \"CKEditor\", \"label\": \"Description\"}]','/uploads/images/flags/br.png',1,'2020-09-12 15:00:00','2020-09-13 02:55:52');
/*!40000 ALTER TABLE `BlockType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Blog`
--

DROP TABLE IF EXISTS `Blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` json NOT NULL,
  `full_description` json NOT NULL,
  `images` json NOT NULL,
  `published` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `blog_ibfk_1` (`category_id`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `BlogCategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blog`
--

LOCK TABLES `Blog` WRITE;
/*!40000 ALTER TABLE `Blog` DISABLE KEYS */;
INSERT INTO `Blog` VALUES (2,'{\"en\": \"fefs\", \"ru\": \"dde\"}','dde',1,'','{\"en\": \"h6h5h5\\r\\n\\r\\nh5 6h5\", \"ru\": \"\"}','{\"en\": \"h56h56 <p>h56 h5</p><p>6 </p>\", \"ru\": \"\"}','[]','2018-10-19 14:45:00','2018-10-15 15:13:00','2020-09-27 14:45:05'),(8,'{\"de\": \"blog de\", \"en\": \"blog en\", \"ru\": \"blog ru\"}','blog-en',NULL,'/uploads/media/image.png','{\"en\": \"fwef\", \"ru\": \"\"}','{\"en\": \"fwefw<p>ef</p><p>wefw</p>\", \"ru\": \"\"}','[\"/uploaded/2020-11-29/50537e590363b28e52ee2c50601cebcc.png\"]','2019-09-22 20:17:00','1970-01-01 03:00:00','2020-11-29 06:28:02');
/*!40000 ALTER TABLE `Blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogCategory`
--

DROP TABLE IF EXISTS `BlogCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogCategory`
--

LOCK TABLES `BlogCategory` WRITE;
/*!40000 ALTER TABLE `BlogCategory` DISABLE KEYS */;
INSERT INTO `BlogCategory` VALUES (1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/Blog/1537547338_I9HiIO.png','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-06-14 14:40:14'),(2,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-06-14 14:40:24'),(3,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','/uploads/media/image-1.png','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-09-21 07:36:07');
/*!40000 ALTER TABLE `BlogCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogComment`
--

DROP TABLE IF EXISTS `BlogComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogComment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blogcomment_ibfk_1` (`blog_id`),
  KEY `blogcomment_ibfk_2` (`user_id`),
  CONSTRAINT `blogcomment_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `Blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blogcomment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogComment`
--

LOCK TABLES `BlogComment` WRITE;
/*!40000 ALTER TABLE `BlogComment` DISABLE KEYS */;
INSERT INTO `BlogComment` VALUES (1,2,1,'eqwdq\r\ndqd','new','2020-06-02 20:04:00');
/*!40000 ALTER TABLE `BlogComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogRate`
--

DROP TABLE IF EXISTS `BlogRate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogRate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mark` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blograte_ibfk_1` (`blog_id`),
  KEY `blograte_ibfk_2` (`user_id`),
  CONSTRAINT `blograte_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `Blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blograte_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogRate`
--

LOCK TABLES `BlogRate` WRITE;
/*!40000 ALTER TABLE `BlogRate` DISABLE KEYS */;
/*!40000 ALTER TABLE `BlogRate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogTag`
--

DROP TABLE IF EXISTS `BlogTag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogTag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTag`
--

LOCK TABLES `BlogTag` WRITE;
/*!40000 ALTER TABLE `BlogTag` DISABLE KEYS */;
INSERT INTO `BlogTag` VALUES (4,'йцууй йу','2020-06-14 22:58:38','2020-09-12 15:00:00'),(5,'уйцу','2020-06-14 22:58:38','2020-09-12 15:00:00'),(6,'dqwd','2020-06-14 22:58:38','2020-09-12 15:00:00'),(10,'vvcx','2020-06-14 22:58:38','2020-09-12 15:00:00'),(12,'qw','2020-06-14 22:58:38','2020-09-12 15:00:00'),(14,'2rr','2020-06-14 22:58:38','2020-09-12 15:00:00'),(15,'1ferf','2020-06-14 22:58:38','2020-09-12 15:00:00'),(16,'ferf4','2020-06-14 22:58:38','2020-09-12 15:00:00'),(17,'ff3f3','2020-06-14 22:58:38','2020-09-12 15:00:00'),(18,'wfw','2020-06-14 22:58:38','2020-09-12 15:00:00'),(19,'wefz3','2020-06-14 22:58:38','2020-09-12 15:00:00'),(20,'tag 1 en','2020-06-14 22:58:38','2020-09-12 15:00:00'),(21,'tag 2 en','2020-06-14 22:58:38','2020-09-12 15:00:00'),(22,'tag 1 ru','2020-06-14 22:58:38','2020-09-12 15:00:00'),(23,'tag 2 ru','2020-06-14 22:58:38','2020-09-12 15:00:00'),(24,'one','2020-06-14 22:58:38','2020-09-12 15:00:00'),(25,'zzze','2020-06-14 22:58:38','2020-09-12 15:00:00'),(26,'уйц','2020-06-14 22:58:38','2020-09-12 15:00:00'),(27,'вфвф','2020-06-14 22:58:38','2020-09-12 15:00:00'),(28,'eeee','2020-06-14 22:58:38','2020-09-12 15:00:00'),(29,'awdwda','2020-06-14 22:58:38','2020-09-12 15:00:00'),(30,'zczcdzc','2020-06-14 22:58:38','2020-09-12 15:00:00');
/*!40000 ALTER TABLE `BlogTag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogTagRef`
--

DROP TABLE IF EXISTS `BlogTagRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogTagRef` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `lang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `blogtagref_ibfk_2` (`tag_id`),
  KEY `blogtagref_ibfk_1` (`blog_id`),
  CONSTRAINT `blogtagref_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `Blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blogtagref_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `BlogTag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTagRef`
--

LOCK TABLES `BlogTagRef` WRITE;
/*!40000 ALTER TABLE `BlogTagRef` DISABLE KEYS */;
INSERT INTO `BlogTagRef` VALUES (8,5,'ru'),(2,5,'ru'),(2,6,'ru'),(8,4,'en'),(8,6,'en');
/*!40000 ALTER TABLE `BlogTagRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LogAction`
--

DROP TABLE IF EXISTS `LogAction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LogAction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('created','updated','deleted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `model_class` (`model_class`),
  KEY `model_id` (`model_id`),
  CONSTRAINT `logaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogAction`
--

LOCK TABLES `LogAction` WRITE;
/*!40000 ALTER TABLE `LogAction` DISABLE KEYS */;
INSERT INTO `LogAction` VALUES (168,1,'created','User',5,'2020-10-29 11:27:57'),(170,1,'updated','User',5,'2020-10-29 11:28:14'),(171,1,'updated','User',5,'2020-10-29 11:28:19'),(172,1,'deleted','User',5,'2020-10-29 11:28:27'),(173,1,'updated','User',1,'2020-10-29 12:41:10'),(174,1,'updated','User',1,'2020-10-29 12:42:41'),(175,1,'updated','User',1,'2020-10-29 12:43:06'),(176,1,'updated','User',1,'2020-10-31 14:40:51'),(177,1,'updated','User',1,'2020-10-31 14:58:25'),(178,1,'updated','User',1,'2020-10-31 14:59:42'),(179,1,'updated','User',1,'2020-10-31 15:00:14'),(182,1,'updated','User',1,'2020-11-01 06:35:29'),(183,1,'updated','User',1,'2020-11-01 06:35:40'),(184,1,'updated','User',1,'2020-11-01 06:35:47'),(186,1,'updated','Product',3,'2020-11-01 06:36:00'),(187,1,'updated','User',2,'2020-11-01 07:18:48'),(188,1,'updated','User',2,'2020-11-01 07:18:56'),(189,1,'created','User',4,'2020-11-01 07:24:04'),(191,1,'updated','User',4,'2020-11-01 07:24:20'),(192,1,'deleted','User',4,'2020-11-01 07:24:26'),(194,1,'updated','Product',3,'2020-11-01 11:21:24'),(195,1,'updated','User',1,'2020-11-03 03:58:43'),(196,1,'updated','User',1,'2020-11-03 03:59:06'),(197,1,'updated','User',1,'2020-11-03 04:00:09'),(198,1,'updated','User',1,'2020-11-03 04:00:14'),(199,1,'updated','User',1,'2020-11-03 04:00:20'),(200,1,'updated','User',1,'2020-11-03 04:00:32'),(201,1,'updated','User',1,'2020-11-03 09:59:51'),(202,1,'updated','User',1,'2020-11-03 10:00:00'),(203,1,'updated','User',1,'2020-11-03 18:05:40'),(204,1,'updated','User',1,'2020-11-05 12:48:48'),(205,1,'updated','User',1,'2020-11-05 12:48:59'),(207,1,'updated','User',1,'2020-11-11 20:27:54'),(208,1,'updated','User',1,'2020-11-29 04:04:03'),(209,1,'updated','User',1,'2020-11-29 04:11:22'),(210,1,'updated','User',1,'2020-11-29 04:15:05'),(211,1,'updated','User',1,'2020-11-29 04:15:11'),(212,1,'updated','Product',3,'2020-11-29 06:23:19'),(213,1,'updated','Product',3,'2020-12-21 04:03:56'),(214,1,'updated','Product',3,'2020-12-21 04:07:16'),(215,1,'updated','Product',3,'2020-12-21 04:08:06'),(216,1,'updated','Product',3,'2020-12-21 04:08:19');
/*!40000 ALTER TABLE `LogAction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LogActionAttr`
--

DROP TABLE IF EXISTS `LogActionAttr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LogActionAttr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_old` json NOT NULL,
  `value_new` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `logactionattr_ibfk_1` (`action_id`),
  CONSTRAINT `logactionattr_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `LogAction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogActionAttr`
--

LOCK TABLES `LogActionAttr` WRITE;
/*!40000 ALTER TABLE `LogActionAttr` DISABLE KEYS */;
INSERT INTO `LogActionAttr` VALUES (300,168,'username','\"\"','\"wqqwqdwd\"'),(301,168,'role','\"\"','\"admin\"'),(302,168,'email','\"\"','\"qwdqw@dqdqwd.vrev\"'),(303,168,'design_theme','\"\"','\"nav_full\"'),(304,168,'design_font','\"\"','\"oswald\"'),(305,170,'design_font','\"oswald\"','\"roboto\"'),(306,171,'design_font','\"roboto\"','\"oswald\"'),(307,172,'username','\"wqqwqdwd\"','\"\"'),(308,172,'role','\"admin\"','\"\"'),(309,172,'email','\"qwdqw@dqdqwd.vrev\"','\"\"'),(310,172,'design_theme','\"nav_full\"','\"\"'),(311,172,'design_font','\"oswald\"','\"\"'),(312,173,'design_theme','\"nav_full\"','\"nav_left\"'),(313,173,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(314,174,'design_theme','\"nav_left\"','\"nav_full\"'),(315,174,'design_font','\"ibm_plex_sans\"','\"montserrat\"'),(316,175,'design_font','\"montserrat\"','\"oswald\"'),(317,176,'design_theme','\"nav_full\"','\"nav_left\"'),(318,176,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(319,176,'design_border_radius','\"\"','\"15\"'),(320,177,'design_theme','\"nav_left\"','\"nav_full\"'),(321,177,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(322,177,'design_border_radius','15','\"\"'),(323,178,'design_theme','\"nav_full\"','\"nav_left\"'),(324,178,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(325,178,'design_border_radius','\"\"','\"15\"'),(326,179,'design_border_radius','15','\"20\"'),(327,182,'full_name','\"Administrator 1\"','\"Administrator 12\"'),(328,183,'username','\"admin\"','\"admin2\"'),(329,183,'full_name','\"Administrator 12\"','\"Administrator\"'),(330,184,'username','\"admin2\"','\"admin\"'),(331,186,'options_tmp','[\"Opt 1 en\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]'),(332,187,'username','\"test\"','\"test4\"'),(333,188,'username','\"test4\"','\"test\"'),(334,189,'username','\"\"','\"qwe\"'),(335,189,'role','\"\"','\"admin\"'),(336,189,'email','\"\"','\"qwe@qwe.qwe\"'),(337,189,'design_theme','\"\"','\"nav_full\"'),(338,189,'design_font','\"\"','\"oswald\"'),(339,189,'full_name','\"\"','\"qwe qwe\"'),(340,191,'full_name','\"qwe qwe\"','\"qwezzz\"'),(341,192,'username','\"qwe\"','\"\"'),(342,192,'role','\"admin\"','\"\"'),(343,192,'email','\"qwe@qwe.qwe\"','\"\"'),(344,192,'design_theme','\"nav_full\"','\"\"'),(345,192,'design_font','\"oswald\"','\"\"'),(346,192,'full_name','\"qwezzz\"','\"\"'),(347,194,'name','{\"de\": \"das\", \"en\": \"das\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}'),(348,195,'design_theme','\"nav_full\"','\"nav_left\"'),(349,195,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(350,195,'design_border_radius','\"\"','\"15\"'),(351,196,'design_border_radius','15','\"10\"'),(352,197,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(353,198,'design_font','\"oswald\"','\"roboto\"'),(354,199,'design_font','\"roboto\"','\"montserrat\"'),(355,200,'design_theme','\"nav_left\"','\"nav_full\"'),(356,200,'design_font','\"montserrat\"','\"oswald\"'),(357,200,'design_border_radius','10','\"\"'),(358,201,'design_theme','\"nav_full\"','\"nav_left\"'),(359,202,'design_theme','\"nav_left\"','\"nav_full\"'),(360,203,'design_theme','\"nav_full\"','\"nav_left\"'),(361,203,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(362,204,'design_theme','\"nav_left\"','\"nav_full\"'),(363,205,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(364,207,'design_theme','\"nav_left\"','\"nav_full\"'),(365,208,'design_theme','\"nav_full\"','\"nav_left\"'),(366,209,'design_theme','\"nav_left\"','\"nav_full\"'),(367,210,'design_theme','\"nav_full\"','\"nav_left\"'),(368,211,'design_theme','\"nav_left\"','\"nav_full\"'),(369,212,'images','[]','[\"/uploaded/2020-11-29/5c70ace731882c790548336d99fc9608.png\"]'),(370,213,'discount','\"\"','\"43\"'),(371,214,'discount','43','\"\"'),(372,215,'price','\"\"','\"12\"'),(373,216,'discount','\"\"','\"40\"');
/*!40000 ALTER TABLE `LogActionAttr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Menu`
--

DROP TABLE IF EXISTS `Menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree` int(11) NOT NULL DEFAULT '1',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `expanded` tinyint(1) NOT NULL DEFAULT '1',
  `name` json NOT NULL,
  `url` json NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree` (`tree`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Menu`
--

LOCK TABLES `Menu` WRITE;
/*!40000 ALTER TABLE `Menu` DISABLE KEYS */;
INSERT INTO `Menu` VALUES (1,1,1,14,0,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','null','2020-09-12 15:00:00','2020-09-12 15:00:00'),(2,1,2,7,1,0,'{\"de\": \"1 de\", \"en\": \"1 en\", \"ru\": \"1 ru\"}','{\"de\": \"\", \"en\": \"cecwe\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(3,1,3,4,2,1,'{\"de\": \"1-1\", \"en\": \"1-1\", \"ru\": \"1-1\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(4,1,5,6,2,1,'{\"de\": \"1-2\", \"en\": \"1-2\", \"ru\": \"1-2\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(5,1,8,9,1,1,'{\"de\": \"2\", \"en\": \"2\", \"ru\": \"2\"}','{\"de\": \"\", \"en\": \"dawd\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-10-02 23:25:55'),(25,1,10,13,1,1,'{\"de\": \"3\", \"en\": \"3\", \"ru\": \"3\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(26,1,11,12,2,1,'{\"de\": \"3-1\", \"en\": \"3-1\", \"ru\": \"3-1\"}','{\"de\": \"/qwe\", \"en\": \"/qwe\", \"ru\": \"/qwe\"}','2020-09-12 15:00:00','2020-12-03 09:56:08');
/*!40000 ALTER TABLE `Menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order`
--

DROP TABLE IF EXISTS `Order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_type` enum('pickup','delivery') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cash','bank_card') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_quantity` int(11) NOT NULL DEFAULT '0',
  `total_price` bigint(20) NOT NULL DEFAULT '0',
  `delivery_price` bigint(20) DEFAULT NULL,
  `status` enum('new','confirmed','payed','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
/*!40000 ALTER TABLE `Order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrderProduct`
--

DROP TABLE IF EXISTS `OrderProduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_json` json NOT NULL,
  `price` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  CONSTRAINT `orderproduct_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orderproduct_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderProduct`
--

LOCK TABLES `OrderProduct` WRITE;
/*!40000 ALTER TABLE `OrderProduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrderProduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` json NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` json NOT NULL,
  `full_description` json NOT NULL,
  `images` json NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `main_category_id` int(11) DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `discount` tinyint(3) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `product_ibfk_1` (`brand_id`),
  KEY `product_ibfk_2` (`main_category_id`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`main_category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `ProductBrand` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES (2,'{\"de\": \"Prod 1\", \"en\": \"Prod 1\", \"ru\": \"Prod 1\"}','prod-1','{\"de\": \"fsrrf\", \"en\": \"fsrrf\", \"ru\": \"fsrrf\"}','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"fsefesfse<p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}','[]',NULL,121,23,NULL,NULL,'','2020-06-14 20:19:00','2020-10-25 17:31:28'),(3,'{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}','das','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','[\"/uploaded/2020-11-29/5c70ace731882c790548336d99fc9608.png\"]',NULL,123,12,40,NULL,'','2020-08-31 15:48:00','2020-12-21 04:09:02');
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductBrand`
--

DROP TABLE IF EXISTS `ProductBrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductBrand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductBrand`
--

LOCK TABLES `ProductBrand` WRITE;
/*!40000 ALTER TABLE `ProductBrand` DISABLE KEYS */;
INSERT INTO `ProductBrand` VALUES (1,'{\"de\": \"Brand 1\", \"en\": \"Brand 1\", \"ru\": \"Brand 1\"}','brand-1','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-06-14 17:24:44','2020-06-14 17:24:44'),(2,'{\"de\": \"Brand 2\", \"en\": \"Brand 2\", \"ru\": \"Brand 2\"}','brand-2','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-06-14 17:24:49','2020-06-14 17:24:49'),(3,'{\"de\": \"Brand 3\", \"en\": \"Brand 3\", \"ru\": \"Brand 3\"}','brand-3','/uploads/images/logo.png','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-06-14 17:24:00','2020-06-14 17:25:09');
/*!40000 ALTER TABLE `ProductBrand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategory`
--

DROP TABLE IF EXISTS `ProductCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree` int(11) NOT NULL DEFAULT '1',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `expanded` tinyint(1) NOT NULL DEFAULT '1',
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree` (`tree`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategory`
--

LOCK TABLES `ProductCategory` WRITE;
/*!40000 ALTER TABLE `ProductCategory` DISABLE KEYS */;
INSERT INTO `ProductCategory` VALUES (1,1,1,10,0,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','',NULL,'null','2020-09-12 15:00:00','2020-09-12 15:00:00'),(120,1,2,5,1,1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/media/jpg.jpg','{\"de\": \"dawda<p>da</p>\", \"en\": \"dawda<p>da</p>\", \"ru\": \"dawda<p>da</p>\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(121,1,6,7,1,1,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"fsefs<p>efsefs</p>\", \"en\": \"fsefs<p>efsefs</p>\", \"ru\": \"fsefs<p>efsefs</p>\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(122,1,8,9,1,1,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00'),(123,1,3,4,2,1,'{\"de\": \"Cat 1-1\", \"en\": \"Cat 1-1\", \"ru\": \"Cat 1-1\"}','cat-1-1','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-09-12 15:00:00');
/*!40000 ALTER TABLE `ProductCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategoryRef`
--

DROP TABLE IF EXISTS `ProductCategoryRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategoryRef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productcategoryref_ibfk_1` (`product_id`),
  KEY `productcategoryref_ibfk_2` (`category_id`),
  CONSTRAINT `productcategoryref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productcategoryref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategoryRef`
--

LOCK TABLES `ProductCategoryRef` WRITE;
/*!40000 ALTER TABLE `ProductCategoryRef` DISABLE KEYS */;
INSERT INTO `ProductCategoryRef` VALUES (4,2,121),(5,2,122),(6,2,120),(19,3,120),(20,3,123);
/*!40000 ALTER TABLE `ProductCategoryRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategorySpecificationRef`
--

DROP TABLE IF EXISTS `ProductCategorySpecificationRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategorySpecificationRef` (
  `category_id` int(11) NOT NULL,
  `specification_id` int(11) NOT NULL,
  KEY `productcategoryattributeref_ibfk_1` (`specification_id`),
  KEY `productcategoryattributeref_ibfk_2` (`category_id`),
  CONSTRAINT `productcategoryspecificationref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productcategoryspecificationref_ibfk_3` FOREIGN KEY (`specification_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategorySpecificationRef`
--

LOCK TABLES `ProductCategorySpecificationRef` WRITE;
/*!40000 ALTER TABLE `ProductCategorySpecificationRef` DISABLE KEYS */;
INSERT INTO `ProductCategorySpecificationRef` VALUES (122,3),(123,2),(123,1),(123,3);
/*!40000 ALTER TABLE `ProductCategorySpecificationRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductComment`
--

DROP TABLE IF EXISTS `ProductComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductComment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productcomment_ibfk_1` (`product_id`),
  KEY `productcomment_ibfk_2` (`user_id`),
  CONSTRAINT `productcomment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productcomment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductComment`
--

LOCK TABLES `ProductComment` WRITE;
/*!40000 ALTER TABLE `ProductComment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductOptionRef`
--

DROP TABLE IF EXISTS `ProductOptionRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductOptionRef` (
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  KEY `productoptionref_ibfk_1` (`product_id`),
  KEY `productoptionref_ibfk_3` (`option_id`),
  CONSTRAINT `productoptionref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productoptionref_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `ProductSpecificationOption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductOptionRef`
--

LOCK TABLES `ProductOptionRef` WRITE;
/*!40000 ALTER TABLE `ProductOptionRef` DISABLE KEYS */;
INSERT INTO `ProductOptionRef` VALUES (2,10),(3,1),(3,5),(3,6),(3,7),(3,10),(3,3);
/*!40000 ALTER TABLE `ProductOptionRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductRate`
--

DROP TABLE IF EXISTS `ProductRate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductRate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mark` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productrate_ibfk_1` (`product_id`),
  KEY `productrate_ibfk_2` (`user_id`),
  CONSTRAINT `productrate_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productrate_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductRate`
--

LOCK TABLES `ProductRate` WRITE;
/*!40000 ALTER TABLE `ProductRate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductRate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductRelatedRef`
--

DROP TABLE IF EXISTS `ProductRelatedRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductRelatedRef` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  KEY `productrelatedref_ibfk_1` (`product_id`),
  KEY `productrelatedref_ibfk_2` (`related_id`),
  CONSTRAINT `productrelatedref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productrelatedref_ibfk_2` FOREIGN KEY (`related_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductRelatedRef`
--

LOCK TABLES `ProductRelatedRef` WRITE;
/*!40000 ALTER TABLE `ProductRelatedRef` DISABLE KEYS */;
INSERT INTO `ProductRelatedRef` VALUES (3,2);
/*!40000 ALTER TABLE `ProductRelatedRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductSpecification`
--

DROP TABLE IF EXISTS `ProductSpecification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductSpecification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `use_filter` tinyint(1) NOT NULL DEFAULT '0',
  `use_compare` tinyint(1) NOT NULL DEFAULT '0',
  `use_detail` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductSpecification`
--

LOCK TABLES `ProductSpecification` WRITE;
/*!40000 ALTER TABLE `ProductSpecification` DISABLE KEYS */;
INSERT INTO `ProductSpecification` VALUES (1,'{\"de\": \"Attr 1\", \"en\": \"Attr 1\", \"ru\": \"Attr 1\"}',1,0,1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(2,'{\"de\": \"Attr 2\", \"en\": \"Attr 2\", \"ru\": \"Attr 2\"}',1,1,0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(3,'{\"de\": \"Attr 3\", \"en\": \"Attr 3\", \"ru\": \"Attr 3\"}',0,0,1,'2020-09-12 15:00:00','2020-09-12 15:00:00');
/*!40000 ALTER TABLE `ProductSpecification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductSpecificationOption`
--

DROP TABLE IF EXISTS `ProductSpecificationOption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductSpecificationOption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `name` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productattributeoption_ibfk_1` (`item_id`),
  KEY `sort` (`sort`),
  CONSTRAINT `productspecificationoption_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductSpecificationOption`
--

LOCK TABLES `ProductSpecificationOption` WRITE;
/*!40000 ALTER TABLE `ProductSpecificationOption` DISABLE KEYS */;
INSERT INTO `ProductSpecificationOption` VALUES (1,1,'{\"de\": \"Opt 1 de\", \"en\": \"Opt 1 en\", \"ru\": \"Opt 1 ru\"}',0),(2,1,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(3,1,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(4,2,'{\"de\": \"Opt 1\", \"en\": \"Opt 1\", \"ru\": \"Opt 1\"}',0),(5,2,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(6,2,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(7,3,'{\"de\": \"Opt 1\", \"en\": \"Opt 1\", \"ru\": \"Opt 1\"}',0),(8,3,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(9,3,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(10,3,'{\"de\": \"Opt 4\", \"en\": \"Opt 4\", \"ru\": \"Opt 4\"}',3);
/*!40000 ALTER TABLE `ProductSpecificationOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductVariation`
--

DROP TABLE IF EXISTS `ProductVariation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductVariation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `specification_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `price` bigint(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json NOT NULL,
  `sort` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productvariation_ibfk_1` (`product_id`),
  KEY `productvariation_ibfk_2` (`specification_id`),
  KEY `productvariation_ibfk_3` (`option_id`),
  KEY `sort` (`sort`),
  CONSTRAINT `productvariation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productvariation_ibfk_2` FOREIGN KEY (`specification_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productvariation_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `ProductSpecificationOption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductVariation`
--

LOCK TABLES `ProductVariation` WRITE;
/*!40000 ALTER TABLE `ProductVariation` DISABLE KEYS */;
INSERT INTO `ProductVariation` VALUES (6,2,3,7,NULL,NULL,NULL,'[]',0,'2020-09-12 15:00:00','2020-10-25 17:31:28'),(8,3,1,1,43,3,'frf','[]',0,'2020-09-12 21:56:00','2020-12-21 04:09:02'),(9,3,2,4,NULL,NULL,NULL,'[]',1,'2020-09-19 13:12:00','2020-12-21 04:09:02');
/*!40000 ALTER TABLE `ProductVariation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SeoMeta`
--

DROP TABLE IF EXISTS `SeoMeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SeoMeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL,
  `lang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`),
  KEY `model_class` (`model_class`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SeoMeta`
--

LOCK TABLES `SeoMeta` WRITE;
/*!40000 ALTER TABLE `SeoMeta` DISABLE KEYS */;
INSERT INTO `SeoMeta` VALUES (1,'Blog',8,'en','{\"title\": \"rsg\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(5,'Product',3,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(6,'Staticpage',16,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}');
/*!40000 ALTER TABLE `SeoMeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Staticpage`
--

DROP TABLE IF EXISTS `Staticpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Staticpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_seo_meta` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Staticpage`
--

LOCK TABLES `Staticpage` WRITE;
/*!40000 ALTER TABLE `Staticpage` DISABLE KEYS */;
INSERT INTO `Staticpage` VALUES (16,'home','Home',1,'2020-11-11 20:18:00');
/*!40000 ALTER TABLE `Staticpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticpageBlock`
--

DROP TABLE IF EXISTS `StaticpageBlock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticpageBlock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  `type` enum('textInput','textArea','checkbox','CKEditor','ElFinder','images','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `part_index` int(11) NOT NULL,
  `part_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `staticpageblock_ibfk_1` (`item_id`),
  CONSTRAINT `staticpageblock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `Staticpage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticpageBlock`
--

LOCK TABLES `StaticpageBlock` WRITE;
/*!40000 ALTER TABLE `StaticpageBlock` DISABLE KEYS */;
INSERT INTO `StaticpageBlock` VALUES (45,16,'title','Title','{\"en\": \"\"}','textInput','[]',0,'First',1),(46,16,'description','Description','{\"en\": \"\"}','CKEditor','[]',0,'First',1);
/*!40000 ALTER TABLE `StaticpageBlock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SystemLanguage`
--

DROP TABLE IF EXISTS `SystemLanguage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SystemLanguage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`is_active`),
  KEY `is_main` (`is_main`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SystemLanguage`
--

LOCK TABLES `SystemLanguage` WRITE;
/*!40000 ALTER TABLE `SystemLanguage` DISABLE KEYS */;
INSERT INTO `SystemLanguage` VALUES (1,'English','en','/uploads/media/flags/gb.png',1,1,'2019-12-26 06:14:00','2020-10-25 17:40:54'),(2,'Russian','ru','/uploads/media/flags/ru.png',1,0,'2020-11-29 06:56:09','2020-11-29 06:56:09'),(3,'German','de','/uploads/media/flags/de.png',1,0,'2020-11-29 06:56:39','2020-11-29 06:56:39');
/*!40000 ALTER TABLE `SystemLanguage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SystemSettings`
--

DROP TABLE IF EXISTS `SystemSettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SystemSettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('textInput','textArea','checkbox','CKEditor','ElFinder','images','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SystemSettings`
--

LOCK TABLES `SystemSettings` WRITE;
/*!40000 ALTER TABLE `SystemSettings` DISABLE KEYS */;
INSERT INTO `SystemSettings` VALUES (3,'site_name','Site name','SpeedRunner','textInput',0),(6,'site_logo','Logo','/uploads/media/image.png','ElFinder',1),(7,'admin_email','Email','admin@localhost.loc','textInput',3),(10,'delete_model_file','Delete file after removing record','1','checkbox',4),(11,'site_favicon','Favicon','/uploads/media/image.png','ElFinder',2);
/*!40000 ALTER TABLE `SystemSettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TranslationMessage`
--

DROP TABLE IF EXISTS `TranslationMessage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TranslationMessage` (
  `id` int(11) NOT NULL,
  `language` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `TranslationSource` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationMessage`
--

LOCK TABLES `TranslationMessage` WRITE;
/*!40000 ALTER TABLE `TranslationMessage` DISABLE KEYS */;
INSERT INTO `TranslationMessage` VALUES (1,'de',''),(1,'en',''),(1,'ru',''),(2,'de',''),(2,'en',''),(2,'ru',''),(3,'de',''),(3,'en',''),(3,'ru',''),(4,'de',''),(4,'en',''),(4,'ru',''),(5,'de',''),(5,'en',''),(5,'ru',''),(6,'de',''),(6,'en',''),(6,'ru',''),(7,'de',''),(7,'en',''),(7,'ru',''),(8,'de',''),(8,'en',''),(8,'ru',''),(9,'de',''),(9,'en',''),(9,'ru',''),(10,'de',''),(10,'en',''),(10,'ru',''),(11,'de',''),(11,'en',''),(11,'ru',''),(12,'de',''),(12,'en',''),(12,'ru',''),(13,'de',''),(13,'en',''),(13,'ru',''),(14,'de',''),(14,'en',''),(14,'ru',''),(15,'de',''),(15,'en',''),(15,'ru',''),(16,'de',''),(16,'en',''),(16,'ru',''),(17,'de',''),(17,'en',''),(17,'ru',''),(18,'de',''),(18,'en',''),(18,'ru',''),(19,'de',''),(19,'en',''),(19,'ru',''),(20,'de',''),(20,'en',''),(20,'ru',''),(21,'de',''),(21,'en',''),(21,'ru',''),(22,'de',''),(22,'en',''),(22,'ru',''),(23,'de',''),(23,'en',''),(23,'ru',''),(24,'de',''),(24,'en',''),(24,'ru',''),(25,'de',''),(25,'en',''),(25,'ru',''),(26,'de',''),(26,'en',''),(26,'ru',''),(27,'de',''),(27,'en',''),(27,'ru',''),(28,'de',''),(28,'en',''),(28,'ru',''),(29,'de',''),(29,'en',''),(29,'ru',''),(30,'de',''),(30,'en',''),(30,'ru',''),(31,'de',''),(31,'en',''),(31,'ru',''),(32,'de',''),(32,'en',''),(32,'ru',''),(33,'de',''),(33,'en',''),(33,'ru',''),(34,'de',''),(34,'en',''),(34,'ru',''),(35,'de',''),(35,'en',''),(35,'ru',''),(36,'de',''),(36,'en',''),(36,'ru',''),(37,'de',''),(37,'en',''),(37,'ru',''),(38,'de',''),(38,'en',''),(38,'ru',''),(39,'de',''),(39,'en',''),(39,'ru',''),(40,'de',''),(40,'en',''),(40,'ru',''),(41,'de',''),(41,'en',''),(41,'ru',''),(42,'de',''),(42,'en',''),(42,'ru',''),(43,'de',''),(43,'en',''),(43,'ru',''),(44,'de',''),(44,'en',''),(44,'ru',''),(45,'de',''),(45,'en',''),(45,'ru',''),(46,'de',''),(46,'en',''),(46,'ru',''),(47,'de',''),(47,'en',''),(47,'ru',''),(48,'de',''),(48,'en',''),(48,'ru',''),(49,'de',''),(49,'en',''),(49,'ru',''),(50,'de',''),(50,'en',''),(50,'ru',''),(51,'de',''),(51,'en',''),(51,'ru',''),(52,'de',''),(52,'en',''),(52,'ru',''),(53,'de',''),(53,'en',''),(53,'ru',''),(54,'de',''),(54,'en',''),(54,'ru',''),(55,'de',''),(55,'en',''),(55,'ru',''),(56,'de',''),(56,'en',''),(56,'ru',''),(57,'de',''),(57,'en',''),(57,'ru',''),(58,'de',''),(58,'en',''),(58,'ru',''),(59,'de',''),(59,'en',''),(59,'ru',''),(60,'de',''),(60,'en',''),(60,'ru',''),(61,'de',''),(61,'en',''),(61,'ru',''),(62,'de',''),(62,'en',''),(62,'ru',''),(63,'de',''),(63,'en',''),(63,'ru',''),(64,'de',''),(64,'en',''),(64,'ru',''),(65,'de',''),(65,'en',''),(65,'ru',''),(66,'de',''),(66,'en',''),(66,'ru',''),(67,'de',''),(67,'en',''),(67,'ru',''),(68,'de',''),(68,'en',''),(68,'ru',''),(69,'de',''),(69,'en',''),(69,'ru',''),(70,'de',''),(70,'en',''),(70,'ru',''),(71,'de',''),(71,'en',''),(71,'ru',''),(72,'de',''),(72,'en',''),(72,'ru',''),(73,'de',''),(73,'en',''),(73,'ru',''),(74,'de',''),(74,'en',''),(74,'ru',''),(75,'de',''),(75,'en',''),(75,'ru',''),(76,'de',''),(76,'en',''),(76,'ru',''),(77,'de',''),(77,'en',''),(77,'ru',''),(78,'de',''),(78,'en',''),(78,'ru',''),(79,'de',''),(79,'en',''),(79,'ru',''),(80,'de',''),(80,'en',''),(80,'ru',''),(81,'de',''),(81,'en',''),(81,'ru',''),(82,'de',''),(82,'en',''),(82,'ru',''),(83,'de',''),(83,'en',''),(83,'ru',''),(84,'de',''),(84,'en',''),(84,'ru',''),(85,'de',''),(85,'en',''),(85,'ru',''),(86,'de',''),(86,'en',''),(86,'ru',''),(87,'de',''),(87,'en',''),(87,'ru',''),(88,'de',''),(88,'en',''),(88,'ru',''),(89,'de',''),(89,'en',''),(89,'ru',''),(90,'de',''),(90,'en',''),(90,'ru',''),(91,'de',''),(91,'en',''),(91,'ru',''),(92,'de',''),(92,'en',''),(92,'ru',''),(93,'de',''),(93,'en',''),(93,'ru',''),(94,'de',''),(94,'en',''),(94,'ru',''),(95,'de',''),(95,'en',''),(95,'ru',''),(96,'de',''),(96,'en',''),(96,'ru',''),(97,'de',''),(97,'en',''),(97,'ru',''),(98,'de',''),(98,'en',''),(98,'ru',''),(99,'de',''),(99,'en',''),(99,'ru',''),(100,'de',''),(100,'en',''),(100,'ru',''),(101,'de',''),(101,'en',''),(101,'ru',''),(102,'de',''),(102,'en',''),(102,'ru',''),(103,'de',''),(103,'en',''),(103,'ru',''),(104,'de',''),(104,'en',''),(104,'ru',''),(105,'de',''),(105,'en',''),(105,'ru',''),(106,'de',''),(106,'en',''),(106,'ru',''),(107,'de',''),(107,'en',''),(107,'ru',''),(108,'de',''),(108,'en',''),(108,'ru',''),(109,'de',''),(109,'en',''),(109,'ru',''),(110,'de',''),(110,'en',''),(110,'ru',''),(111,'de',''),(111,'en',''),(111,'ru',''),(112,'de',''),(112,'en',''),(112,'ru',''),(113,'de',''),(113,'en',''),(113,'ru',''),(114,'de',''),(114,'en',''),(114,'ru',''),(115,'de',''),(115,'en',''),(115,'ru',''),(116,'de',''),(116,'en',''),(116,'ru',''),(117,'de',''),(117,'en',''),(117,'ru',''),(118,'de',''),(118,'en',''),(118,'ru',''),(119,'de',''),(119,'en',''),(119,'ru',''),(120,'de',''),(120,'en',''),(120,'ru',''),(121,'de',''),(121,'en',''),(121,'ru',''),(122,'de',''),(122,'en',''),(122,'ru',''),(123,'de',''),(123,'en',''),(123,'ru',''),(124,'de',''),(124,'en',''),(124,'ru',''),(125,'de',''),(125,'en',''),(125,'ru',''),(126,'de',''),(126,'en',''),(126,'ru',''),(127,'de',''),(127,'en',''),(127,'ru',''),(128,'de',''),(128,'en',''),(128,'ru',''),(129,'de',''),(129,'en',''),(129,'ru',''),(130,'de',''),(130,'en',''),(130,'ru',''),(131,'de',''),(131,'en',''),(131,'ru',''),(132,'de',''),(132,'en',''),(132,'ru',''),(133,'de',''),(133,'en',''),(133,'ru',''),(134,'de',''),(134,'en',''),(134,'ru',''),(135,'de',''),(135,'en',''),(135,'ru',''),(136,'de',''),(136,'en',''),(136,'ru',''),(137,'de',''),(137,'en',''),(137,'ru',''),(138,'de',''),(138,'en',''),(138,'ru',''),(139,'de',''),(139,'en',''),(139,'ru',''),(140,'de',''),(140,'en',''),(140,'ru',''),(141,'de',''),(141,'en',''),(141,'ru',''),(142,'de',''),(142,'en',''),(142,'ru',''),(143,'de',''),(143,'en',''),(143,'ru',''),(144,'de',''),(144,'en',''),(144,'ru',''),(145,'de',''),(145,'en',''),(145,'ru',''),(146,'de',''),(146,'en',''),(146,'ru',''),(147,'de',''),(147,'en',''),(147,'ru',''),(148,'de',''),(148,'en',''),(148,'ru',''),(149,'de',''),(149,'en',''),(149,'ru',''),(150,'de',''),(150,'en',''),(150,'ru',''),(151,'de',''),(151,'en',''),(151,'ru',''),(152,'de',''),(152,'en',''),(152,'ru',''),(153,'de',''),(153,'en',''),(153,'ru',''),(154,'de',''),(154,'en',''),(154,'ru',''),(155,'de',''),(155,'en',''),(155,'ru',''),(156,'de',''),(156,'en',''),(156,'ru',''),(157,'de',''),(157,'en',''),(157,'ru',''),(158,'de',''),(158,'en',''),(158,'ru',''),(159,'de',''),(159,'en',''),(159,'ru',''),(160,'de',''),(160,'en',''),(160,'ru',''),(161,'de',''),(161,'en',''),(161,'ru',''),(162,'de',''),(162,'en',''),(162,'ru',''),(163,'de',''),(163,'en',''),(163,'ru',''),(164,'de',''),(164,'en',''),(164,'ru',''),(165,'de',''),(165,'en',''),(165,'ru',''),(166,'de',''),(166,'en',''),(166,'ru',''),(167,'de',''),(167,'en',''),(167,'ru',''),(168,'de',''),(168,'en',''),(168,'ru',''),(169,'de',''),(169,'en',''),(169,'ru',''),(170,'de',''),(170,'en',''),(170,'ru',''),(171,'de',''),(171,'en',''),(171,'ru',''),(172,'de',''),(172,'en',''),(172,'ru',''),(173,'de',''),(173,'en',''),(173,'ru',''),(174,'de',''),(174,'en',''),(174,'ru',''),(175,'de',''),(175,'en',''),(175,'ru',''),(176,'de',''),(176,'en',''),(176,'ru',''),(177,'de',''),(177,'en',''),(177,'ru',''),(178,'de',''),(178,'en',''),(178,'ru',''),(179,'de',''),(179,'en',''),(179,'ru',''),(180,'de',''),(180,'en',''),(180,'ru',''),(181,'de',''),(181,'en',''),(181,'ru',''),(182,'de',''),(182,'en',''),(182,'ru',''),(183,'de',''),(183,'en',''),(183,'ru',''),(184,'de',''),(184,'en',''),(184,'ru',''),(185,'de',''),(185,'en',''),(185,'ru',''),(186,'de',''),(186,'en',''),(186,'ru',''),(187,'de',''),(187,'en',''),(187,'ru',''),(188,'de',''),(188,'en',''),(188,'ru',''),(189,'de',''),(189,'en',''),(189,'ru',''),(190,'de',''),(190,'en',''),(190,'ru',''),(191,'de',''),(191,'en',''),(191,'ru',''),(192,'de',''),(192,'en',''),(192,'ru',''),(193,'de',''),(193,'en',''),(193,'ru',''),(194,'de',''),(194,'en',''),(194,'ru',''),(195,'de',''),(195,'en',''),(195,'ru',''),(196,'de',''),(196,'en',''),(196,'ru',''),(197,'de',''),(197,'en',''),(197,'ru',''),(198,'de',''),(198,'en',''),(198,'ru',''),(199,'de',''),(199,'en',''),(199,'ru',''),(200,'de',''),(200,'en',''),(200,'ru',''),(201,'de',''),(201,'en',''),(201,'ru',''),(202,'de',''),(202,'en',''),(202,'ru',''),(203,'de',''),(203,'en',''),(203,'ru',''),(204,'de',''),(204,'en',''),(204,'ru',''),(205,'en',''),(206,'en',''),(207,'en',''),(208,'en',''),(209,'en',''),(210,'de',''),(210,'en',''),(210,'ru',''),(211,'de',''),(211,'en',''),(211,'ru',''),(212,'de',''),(212,'en',''),(212,'ru',''),(213,'de',''),(213,'en',''),(213,'ru',''),(214,'de',''),(214,'en',''),(214,'ru',''),(215,'de',''),(215,'en',''),(215,'ru',''),(216,'de',''),(216,'en',''),(216,'ru',''),(217,'de',''),(217,'en',''),(217,'ru',''),(218,'de',''),(218,'en',''),(218,'ru',''),(219,'de',''),(219,'en',''),(219,'ru',''),(220,'de',''),(220,'en',''),(220,'ru',''),(221,'de',''),(221,'en',''),(221,'ru',''),(222,'de',''),(222,'en',''),(222,'ru',''),(223,'de',''),(223,'en',''),(223,'ru',''),(224,'de',''),(224,'en',''),(224,'ru',''),(225,'de',''),(225,'en',''),(225,'ru',''),(226,'de',''),(226,'en',''),(226,'ru',''),(227,'de',''),(227,'en',''),(227,'ru',''),(228,'de',''),(228,'en',''),(228,'ru',''),(229,'de',''),(229,'en',''),(229,'ru',''),(230,'de',''),(230,'en',''),(230,'ru',''),(231,'de',''),(231,'en',''),(231,'ru',''),(232,'de',''),(232,'en',''),(232,'ru',''),(233,'de',''),(233,'en',''),(233,'ru',''),(234,'de',''),(234,'en',''),(234,'ru',''),(235,'de',''),(235,'en',''),(235,'ru',''),(236,'de',''),(236,'en',''),(236,'ru',''),(237,'de',''),(237,'en',''),(237,'ru',''),(238,'de',''),(238,'en',''),(238,'ru',''),(239,'de',''),(239,'en',''),(239,'ru',''),(240,'de',''),(240,'en',''),(240,'ru',''),(241,'de',''),(241,'en',''),(241,'ru',''),(242,'de',''),(242,'en',''),(242,'ru',''),(243,'de',''),(243,'en',''),(243,'ru',''),(244,'de',''),(244,'en',''),(244,'ru',''),(245,'de',''),(245,'en',''),(245,'ru',''),(246,'de',''),(246,'en',''),(246,'ru',''),(247,'de',''),(247,'en',''),(247,'ru',''),(248,'de',''),(248,'en',''),(248,'ru','');
/*!40000 ALTER TABLE `TranslationMessage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TranslationSource`
--

DROP TABLE IF EXISTS `TranslationSource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TranslationSource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationSource`
--

LOCK TABLES `TranslationSource` WRITE;
/*!40000 ALTER TABLE `TranslationSource` DISABLE KEYS */;
INSERT INTO `TranslationSource` VALUES (1,'app','Id'),(2,'app','Name'),(3,'app','Slug'),(4,'app','Short Description'),(5,'app','Full Description'),(6,'app','Images'),(7,'app','Brand'),(8,'app','Main category'),(9,'app','Price'),(10,'app','Sale'),(11,'app','Quantity'),(12,'app','SKU'),(13,'app','Created'),(14,'app','Updated'),(15,'app','Categories'),(16,'app','Options'),(17,'app','Related'),(18,'app','Variations'),(19,'app','Products'),(20,'app','Create'),(21,'app','Delete all'),(22,'app','Are you sure?'),(23,'app','Home'),(24,'app','Users'),(25,'app','RBAC'),(26,'app','Static pages'),(27,'app','Content'),(28,'app','Menu'),(29,'app','Pages'),(30,'app','Blocks'),(31,'app','Types'),(32,'app','Blogs'),(33,'app','Tags'),(34,'app','Comments'),(35,'app','Rates'),(36,'app','Brands'),(37,'app','Specifications'),(38,'app','Orders'),(39,'app','Media'),(40,'app','Banners'),(41,'app','Gallery'),(42,'app','System'),(43,'app','Settings'),(44,'app','Languages'),(45,'app','Translations'),(46,'app','Cache'),(47,'app','Remove thumbs'),(48,'app','Clear'),(49,'app','Speedrunner'),(50,'app','Information'),(51,'app','Functions'),(52,'app','Bookmarks'),(53,'app','Add'),(54,'app','Admin'),(55,'app','Registered'),(56,'app','Profile'),(57,'app','Logout'),(58,'app','Username'),(59,'app','Role'),(60,'app','Email'),(61,'app','New password'),(62,'app','Theme'),(63,'app','Font'),(64,'app','Border radius'),(65,'app','Full name'),(66,'app','Phone'),(67,'app','Address'),(68,'app','Image'),(69,'app','Category'),(70,'app','Published'),(71,'app','Update: {name}'),(72,'app','Save & reload'),(73,'app','Save'),(74,'app','SEO meta'),(75,'app','Browse'),(76,'app','Error'),(77,'app','Record has been saved'),(78,'app','Update: {username}'),(79,'app','Design'),(80,'app','Field must contain only alphabet and numerical chars'),(81,'app','Full menu'),(82,'app','Left menu'),(83,'app','Oswald'),(84,'app','Roboto'),(85,'app','Montserrat'),(86,'app','IBM Plex Sans'),(87,'app','Static page: {location}'),(88,'app','Label'),(89,'app','Value'),(90,'app','Type'),(91,'app','Title'),(92,'app','Is available'),(93,'app','Description'),(94,'app','Has translation'),(95,'app','Block types'),(96,'app','Update: {label}'),(97,'app','Block pages'),(98,'app','Assign'),(99,'app','Page'),(100,'app','Available'),(101,'app','Blog categories'),(102,'app','Product categories'),(103,'app','Tree'),(104,'app','Product brands'),(105,'app','Lft'),(106,'app','Rgt'),(107,'app','Depth'),(108,'app','Expanded'),(109,'app','Parent'),(110,'app','User'),(111,'app','E-mail'),(112,'app','Delivery type'),(113,'app','Payment type'),(114,'app','Total quantity'),(115,'app','Total price'),(116,'app','Delivery price'),(117,'app','Status'),(118,'app','Key'),(119,'app','Pickup'),(120,'app','Delivery'),(121,'app','Cash'),(122,'app','Bank card'),(123,'app','New'),(124,'app','Confirmed'),(125,'app','Payed'),(126,'app','Completed'),(127,'app','Canceled'),(128,'app','Products price'),(129,'app','Link'),(130,'app','Galleries'),(131,'app','Location'),(132,'app','Groups'),(133,'app','Slider home'),(134,'app','Slider about'),(135,'app','Stock'),(136,'app','Categories & Specifications'),(137,'app','Specification'),(138,'app','Option'),(139,'app','Update'),(140,'app','Delete'),(141,'app','Update: {id}'),(142,'app','Product'),(143,'app','Sku'),(144,'app','Record has been deleted'),(145,'app','Delete with children'),(146,'app','View: {id}'),(147,'app','Total'),(148,'app','Person'),(149,'app','Order'),(150,'app','Banner'),(151,'app','Text 1'),(152,'app','Text 2'),(153,'app','Text 3'),(154,'app','System settings'),(155,'app','Code'),(156,'app','Active'),(157,'app','Main'),(158,'app','System languages'),(159,'app','Process has been completed'),(160,'app','You cannot change role for this user'),(161,'app','This username has already been taken'),(162,'app','This email has already been taken'),(163,'app','There is no user with this email address'),(164,'app','Log actions'),(165,'app','Пользователь'),(166,'app','Тип'),(167,'app','Действие'),(168,'app','Создано'),(169,'app','Значения (старые)'),(170,'app','Значения (новые)'),(171,'app','Лог действий'),(172,'app','Изменено'),(173,'app','Удалено'),(174,'app','Бухгалтерия'),(175,'app','Аккаунты'),(176,'app','Action'),(177,'app','Old value'),(178,'app','New value'),(179,'app','Deleted'),(180,'app','View'),(181,'app','Log actions #{id}'),(182,'app','Blog'),(183,'app','Url'),(184,'app','Bookmark has been added'),(185,'app','Bookmark has been deleted'),(186,'app','Change password'),(187,'app','Password changing'),(188,'app','Password has been changed'),(189,'app','Search'),(190,'app','Сategories'),(191,'app','{length} symbols'),(192,'app','Text'),(193,'app','Mark'),(194,'app','Comments & rates: {name}'),(195,'app','Title 1'),(196,'app','Title 2'),(197,'app','Images 1'),(198,'app','Images 2'),(199,'app','{attribute} is incorrect'),(200,'app_notification','You have new order'),(201,'app','No notifications'),(202,'app','Sign in'),(203,'app','Password'),(204,'app','Remember me'),(205,'app','Blog comments'),(206,'app','Model class'),(207,'app','Model id'),(208,'app','Language'),(209,'app','Static page: {label}'),(210,'app','Message'),(211,'app','Translation sources'),(212,'yii2mod.rbac','Rules'),(213,'yii2mod.rbac','RBAC'),(214,'yii2mod.rbac','Create'),(215,'yii2mod.rbac','Name'),(216,'app','Routes'),(217,'app','Rules'),(218,'app','Roles'),(219,'app','Assignments'),(220,'app','Permissions'),(221,'yii2mod.rbac','Routes'),(222,'yii2mod.rbac','Refresh'),(223,'yii2mod.rbac','Search for available'),(224,'app','Include'),(225,'yii2mod.rbac','Assign'),(226,'app','Exclude'),(227,'yii2mod.rbac','Remove'),(228,'yii2mod.rbac','Search for assigned'),(229,'yii2mod.rbac','Roles'),(230,'yii2mod.rbac','Rule Name'),(231,'yii2mod.rbac','Select Rule'),(232,'yii2mod.rbac','Description'),(233,'app','General'),(234,'yii2mod.rbac','Type'),(235,'yii2mod.rbac','Data'),(236,'app','You cannot delete this record'),(237,'yii2mod.rbac','Assignments'),(238,'yii2mod.rbac','Permissions'),(239,'app','View: {name}'),(240,'yii2mod.rbac','Class Name'),(241,'app','Assignment'),(242,'yii2mod.rbac','Assignment: {username}'),(243,'app','Login'),(244,'app','Confirm password'),(245,'app','Profile saved'),(246,'app','Wrong password reset token'),(247,'app','Password reset token cannot be blank'),(248,'app','Discount');
/*!40000 ALTER TABLE `TranslationSource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','registered') COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `design_theme` enum('nav_full','nav_left') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nav_left',
  `design_font` enum('oswald','roboto','montserrat','ibm_plex_sans') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ibm_plex_sans',
  `design_border_radius` int(11) NOT NULL DEFAULT '15',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'admin','admin','WudOvU-q_Oxth8_vGzexS7-aqBidUE1k','$2y$13$soaIiqO9peegeTcgqOgCV.x9SWqQ82UXNNXKTx/w1BeyGHupbgtJ.','nzROrR5Spm1pqlxn8gDaslHW09s560dN_1580274498','admin@local.host','nav_full','oswald',0,'2020-02-21 04:58:00','2020-12-11 22:38:21');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserNotification`
--

DROP TABLE IF EXISTS `UserNotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserNotification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_id` int(11) NOT NULL,
  `params` json NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `usernotification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserNotification`
--

LOCK TABLES `UserNotification` WRITE;
/*!40000 ALTER TABLE `UserNotification` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserNotification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserProfile`
--

DROP TABLE IF EXISTS `UserProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserProfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_ibfk_1` (`user_id`),
  CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserProfile`
--

LOCK TABLES `UserProfile` WRITE;
/*!40000 ALTER TABLE `UserProfile` DISABLE KEYS */;
INSERT INTO `UserProfile` VALUES (4,1,'Administrator','2231','addr',NULL);
/*!40000 ALTER TABLE `UserProfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','1',1568293594);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1537578127,1537578127),('admin',1,NULL,'admin',NULL,1537596415,1607506632),('registered',1,NULL,'registered',NULL,1585474124,1607506635);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('admin','/*');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES ('admin',_binary 'O:27:\"yii2mod\\rbac\\rules\\UserRule\":3:{s:4:\"name\";s:5:\"admin\";s:9:\"createdAt\";i:1537596396;s:9:\"updatedAt\";i:1590419461;}',1537596396,1590419461),('registered',_binary 'O:27:\"yii2mod\\rbac\\rules\\UserRule\":3:{s:4:\"name\";s:10:\"registered\";s:9:\"createdAt\";i:1585474116;s:9:\"updatedAt\";i:1585474116;}',1585474116,1585474116);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1558534394),('m150425_012013_init',1558534406),('m150425_082737_redirects',1558534406);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-22 18:10:10
