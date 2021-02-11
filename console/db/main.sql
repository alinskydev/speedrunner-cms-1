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
INSERT INTO `Banner` VALUES (2,'r','slider_home','2019-09-22 10:30:00','2020-10-29 00:31:12'),(3,'qwe','slider_about','2019-09-22 10:30:00','2021-02-10 19:02:41');
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
  `banner_id` int(11) NOT NULL,
  `text_1` json NOT NULL,
  `text_2` json NOT NULL,
  `text_3` json NOT NULL,
  `link` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `banner_id` (`banner_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `bannergroup_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `Banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BannerGroup`
--

LOCK TABLES `BannerGroup` WRITE;
/*!40000 ALTER TABLE `BannerGroup` DISABLE KEYS */;
INSERT INTO `BannerGroup` VALUES (5,3,'{\"de\": \"qwe\", \"en\": \"awda\", \"ru\": \"qwe\"}','{\"de\": \"fe\", \"en\": \"fef\", \"ru\": \"fe\"}','{\"de\": \"\", \"en\": \"gr\", \"ru\": \"\"}','{\"de\": \"fwef\", \"en\": \"fwef\", \"ru\": \"fwef\"}','/uploads/Screenshot_2.png',0),(6,3,'{\"de\": \"\", \"en\": \"gergerg\", \"ru\": \"\"}','{\"de\": \"fewf\", \"en\": \"\", \"ru\": \"fewf\"}','{\"de\": \"fwe\", \"en\": \"fwe\", \"ru\": \"fwe\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/jpg.jpg',1),(12,2,'{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}','{\"de\": \"rwer\", \"en\": \"rwer\", \"ru\": \"rwer\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/jpg.jpg',0);
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
  KEY `page_id` (`page_id`) USING BTREE,
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `block_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `BlockPage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `block_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `BlockType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Block`
--

LOCK TABLES `Block` WRITE;
/*!40000 ALTER TABLE `Block` DISABLE KEYS */;
INSERT INTO `Block` VALUES (13,3,8,'\"title all\"',0),(14,3,9,'{\"de\": \"title de\", \"en\": \"title en\", \"ru\": \"title ru\"}',1),(15,3,12,'[]',2),(16,3,13,'{\"de\": [\"/uploaded/1592682565__DA3TQ3PeeFoXaic.png\"], \"en\": [], \"ru\": []}',3),(17,3,14,'[{\"image\": \"/uploads/media/jpg.jpg\", \"is_available\": \"0\"}, {\"image\": \"\", \"is_available\": \"1\"}]',4),(18,3,15,'{\"de\": [], \"en\": [{\"title\": \"asd\", \"description\": \"<p>asd</p><p>asd wdwd</p>\"}, {\"title\": \"qwe\", \"description\": \"<p>qwe</p><p>qwe</p>\"}], \"ru\": []}',5);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockPage`
--

LOCK TABLES `BlockPage` WRITE;
/*!40000 ALTER TABLE `BlockPage` DISABLE KEYS */;
INSERT INTO `BlockPage` VALUES (3,'{\"de\": \"Page 1\", \"en\": \"Page 1\", \"ru\": \"Page 1\"}','page-1','2020-06-15 22:20:00','2021-02-11 10:35:08');
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
  `type` enum('text_input','text_area','checkbox','elfinder','imperavi','files','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockType`
--

LOCK TABLES `BlockType` WRITE;
/*!40000 ALTER TABLE `BlockType` DISABLE KEYS */;
INSERT INTO `BlockType` VALUES (8,'title_1','Title 1','text_input','[]','/uploads/media/image.png',0,'2020-09-12 15:00:00'),(9,'title_2','Title 2','text_input','[]','/uploads/media/svg_image.svg',1,'2020-09-12 15:00:00'),(10,'description_1','Description 1','text_area','[]','/uploads/media/jpg.jpg',0,'2020-09-12 15:00:00'),(11,'description_2','Description 2','imperavi','[]','/uploads/images/logo.png',1,'2020-09-12 15:00:00'),(12,'images_1','Images 1','files','[]','/uploads/images/editor/5ba26895f4021.png',0,'2020-09-12 15:00:00'),(13,'images_2','Images 2','files','[]','/uploads/images/editor/5bc44f0c699b4.png',1,'2020-09-12 15:00:00'),(14,'groups_1','Groups 1','groups','[{\"name\": \"is_available\", \"type\": \"checkbox\", \"label\": \"Available\"}, {\"name\": \"image\", \"type\": \"elfinder\", \"label\": \"Image\"}]','/uploads/images/flags/au.png',0,'2020-09-12 15:00:00'),(15,'groups_2','Groups 2','groups','[{\"name\": \"title\", \"type\": \"text_input\", \"label\": \"Title\"}, {\"name\": \"description\", \"type\": \"imperavi\", \"label\": \"Description\"}]','/uploads/images/flags/br.png',1,'2020-09-13 02:55:52');
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
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `BlogCategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blog`
--

LOCK TABLES `Blog` WRITE;
/*!40000 ALTER TABLE `Blog` DISABLE KEYS */;
INSERT INTO `Blog` VALUES (2,'{\"en\": \"fefs\", \"ru\": \"dde\"}','dde',1,'','{\"en\": \"h6h5h5\\r\\n\\r\\nh5 6h5\", \"ru\": \"\"}','{\"en\": \"h56h56 <p>h56 h5</p><p>6 </p>\", \"ru\": \"\"}','[]','2018-10-19 14:45:00','2018-10-15 15:13:00','2021-02-05 20:07:15'),(8,'{\"de\": \"blog de\", \"en\": \"Blog en\", \"ru\": \"blog ru\"}','blog-en',NULL,'','{\"en\": \"fwef\", \"ru\": \"\"}','{\"en\": \"fwefw\\r\\n<p class=\\\"qwe\\\">ef\\r\\n</p>\\r\\n<p>wefw\\r\\n</p>\", \"ru\": \"\"}','[\"/uploaded/2021-01-04/1927f163191b9630f33c51688fbaa851.png\"]','2019-09-22 20:17:00','1970-01-01 03:00:00','2021-02-11 13:41:16');
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
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `status` (`status`),
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
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
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
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `tag_id` (`tag_id`) USING BTREE,
  CONSTRAINT `blogtagref_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `Blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blogtagref_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `BlogTag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTagRef`
--

LOCK TABLES `BlogTagRef` WRITE;
/*!40000 ALTER TABLE `BlogTagRef` DISABLE KEYS */;
INSERT INTO `BlogTagRef` VALUES (8,5,'ru'),(2,5,'ru'),(2,6,'ru'),(2,14,'en'),(2,16,'en'),(2,15,'en'),(8,4,'en'),(8,10,'en');
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
  CONSTRAINT `logaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogAction`
--

LOCK TABLES `LogAction` WRITE;
/*!40000 ALTER TABLE `LogAction` DISABLE KEYS */;
INSERT INTO `LogAction` VALUES (168,1,'created','User',5,'2020-10-29 11:27:57'),(170,1,'updated','User',5,'2020-10-29 11:28:14'),(171,1,'updated','User',5,'2020-10-29 11:28:19'),(172,1,'deleted','User',5,'2020-10-29 11:28:27'),(173,1,'updated','User',1,'2020-10-29 12:41:10'),(174,1,'updated','User',1,'2020-10-29 12:42:41'),(175,1,'updated','User',1,'2020-10-29 12:43:06'),(176,1,'updated','User',1,'2020-10-31 14:40:51'),(177,1,'updated','User',1,'2020-10-31 14:58:25'),(178,1,'updated','User',1,'2020-10-31 14:59:42'),(179,1,'updated','User',1,'2020-10-31 15:00:14'),(182,1,'updated','User',1,'2020-11-01 06:35:29'),(183,1,'updated','User',1,'2020-11-01 06:35:40'),(184,1,'updated','User',1,'2020-11-01 06:35:47'),(186,1,'updated','Product',3,'2020-11-01 06:36:00'),(187,1,'updated','User',2,'2020-11-01 07:18:48'),(188,1,'updated','User',2,'2020-11-01 07:18:56'),(189,1,'created','User',4,'2020-11-01 07:24:04'),(191,1,'updated','User',4,'2020-11-01 07:24:20'),(192,1,'deleted','User',4,'2020-11-01 07:24:26'),(194,1,'updated','Product',3,'2020-11-01 11:21:24'),(195,1,'updated','User',1,'2020-11-03 03:58:43'),(196,1,'updated','User',1,'2020-11-03 03:59:06'),(197,1,'updated','User',1,'2020-11-03 04:00:09'),(198,1,'updated','User',1,'2020-11-03 04:00:14'),(199,1,'updated','User',1,'2020-11-03 04:00:20'),(200,1,'updated','User',1,'2020-11-03 04:00:32'),(201,1,'updated','User',1,'2020-11-03 09:59:51'),(202,1,'updated','User',1,'2020-11-03 10:00:00'),(203,1,'updated','User',1,'2020-11-03 18:05:40'),(204,1,'updated','User',1,'2020-11-05 12:48:48'),(205,1,'updated','User',1,'2020-11-05 12:48:59'),(207,1,'updated','User',1,'2020-11-11 20:27:54'),(208,1,'updated','User',1,'2020-11-29 04:04:03'),(209,1,'updated','User',1,'2020-11-29 04:11:22'),(210,1,'updated','User',1,'2020-11-29 04:15:05'),(211,1,'updated','User',1,'2020-11-29 04:15:11'),(212,1,'updated','Product',3,'2020-11-29 06:23:19'),(213,1,'updated','Product',3,'2020-12-21 04:03:56'),(214,1,'updated','Product',3,'2020-12-21 04:07:16'),(215,1,'updated','Product',3,'2020-12-21 04:08:06'),(216,1,'updated','Product',3,'2020-12-21 04:08:19'),(217,1,'updated','User',1,'2021-01-19 14:48:27'),(218,1,'updated','User',1,'2021-01-19 14:51:29'),(219,1,'updated','User',1,'2021-01-20 11:55:24'),(220,1,'updated','User',1,'2021-01-20 19:34:16'),(221,1,'updated','Product',3,'2021-01-21 07:34:02'),(222,1,'updated','User',1,'2021-01-23 11:34:03'),(228,1,'updated','User',1,'2021-01-23 11:42:34'),(230,1,'updated','User',1,'2021-01-23 16:46:50'),(231,1,'updated','User',1,'2021-01-23 16:46:58'),(233,1,'updated','User',1,'2021-01-23 18:04:52'),(234,1,'updated','User',1,'2021-01-23 18:07:18'),(236,1,'updated','User',1,'2021-01-23 18:09:04'),(237,1,'updated','User',1,'2021-01-23 18:12:34'),(239,1,'updated','User',1,'2021-01-23 18:12:42'),(240,1,'updated','Product',3,'2021-01-23 18:25:09'),(242,1,'updated','Product',3,'2021-01-23 18:26:14'),(245,1,'updated','Product',3,'2021-01-23 18:27:14'),(246,1,'updated','Product',3,'2021-01-23 18:27:40'),(247,1,'updated','Product',3,'2021-01-23 18:27:53'),(251,1,'updated','Product',3,'2021-01-24 20:49:28'),(252,1,'updated','Product',3,'2021-01-24 21:13:29'),(254,1,'updated','Product',3,'2021-01-24 21:13:48'),(255,1,'updated','Product',3,'2021-01-24 21:13:56'),(259,1,'updated','User',1,'2021-01-24 21:42:51'),(261,1,'updated','User',1,'2021-01-24 21:43:32'),(263,1,'updated','User',1,'2021-01-24 21:44:14'),(267,1,'updated','User',1,'2021-01-24 21:44:47'),(268,1,'updated','User',1,'2021-01-24 21:45:02'),(269,1,'updated','User',1,'2021-01-24 21:45:06'),(271,1,'updated','User',1,'2021-01-24 21:46:06'),(273,1,'updated','User',1,'2021-01-24 21:46:41'),(275,1,'updated','User',1,'2021-01-24 21:47:37'),(276,1,'updated','User',1,'2021-01-24 21:47:39'),(278,1,'updated','User',1,'2021-01-24 21:48:27'),(279,1,'updated','User',1,'2021-01-24 21:48:31'),(281,1,'updated','User',1,'2021-01-24 21:50:59'),(282,1,'updated','User',1,'2021-01-24 21:51:01'),(283,1,'updated','User',1,'2021-01-24 21:51:20'),(284,1,'updated','User',1,'2021-01-24 21:51:57'),(285,1,'updated','User',1,'2021-01-24 21:52:06'),(289,1,'updated','User',1,'2021-01-24 21:59:00'),(292,1,'updated','User',1,'2021-01-24 22:43:26'),(295,1,'updated','User',1,'2021-01-24 22:57:26'),(296,1,'updated','User',1,'2021-01-24 22:57:29'),(298,1,'updated','User',1,'2021-01-24 22:58:23'),(301,1,'updated','User',1,'2021-01-24 23:00:10'),(302,1,'updated','User',1,'2021-01-24 23:00:14'),(303,1,'updated','User',1,'2021-01-25 10:56:28'),(304,1,'updated','User',1,'2021-01-25 10:56:40'),(305,1,'updated','User',1,'2021-01-25 10:57:05'),(307,1,'updated','User',1,'2021-01-25 10:57:31'),(308,1,'updated','User',1,'2021-01-25 10:58:34'),(309,1,'updated','User',1,'2021-01-25 10:59:10'),(311,1,'updated','User',1,'2021-01-25 11:02:15'),(312,1,'updated','User',1,'2021-02-02 14:59:58'),(313,1,'updated','User',1,'2021-02-02 15:16:49'),(315,1,'updated','Product',3,'2021-02-02 16:16:29'),(316,1,'updated','Product',3,'2021-02-02 16:16:32'),(317,1,'updated','Product',3,'2021-02-02 16:16:37'),(318,1,'updated','Product',3,'2021-02-02 16:16:49'),(319,1,'created','Product',4,'2021-02-02 16:17:08'),(321,1,'deleted','Product',4,'2021-02-02 16:17:22'),(322,1,'updated','Product',3,'2021-02-02 16:34:38'),(323,1,'updated','Product',3,'2021-02-02 16:34:44'),(324,1,'updated','Product',2,'2021-02-02 16:35:07'),(325,1,'updated','Product',2,'2021-02-03 17:56:37'),(326,1,'updated','Product',2,'2021-02-03 17:58:30'),(327,1,'updated','Product',2,'2021-02-03 17:58:59'),(328,1,'updated','Product',2,'2021-02-03 17:59:14'),(329,1,'updated','Product',2,'2021-02-03 18:01:06'),(330,1,'updated','Product',2,'2021-02-03 18:02:00'),(331,1,'updated','Product',2,'2021-02-03 18:03:31'),(332,1,'updated','Product',2,'2021-02-03 18:08:36'),(333,1,'updated','Product',2,'2021-02-03 18:10:13'),(334,1,'updated','Product',2,'2021-02-03 18:10:43'),(335,1,'updated','Product',2,'2021-02-03 18:11:33'),(341,1,'updated','User',1,'2021-02-03 18:35:43'),(343,1,'updated','User',1,'2021-02-03 18:36:18'),(344,1,'updated','Product',3,'2021-02-03 18:53:02'),(345,1,'updated','Product',3,'2021-02-03 19:10:26'),(346,1,'updated','Product',2,'2021-02-03 19:11:21'),(347,1,'updated','Product',2,'2021-02-03 19:17:22'),(348,1,'updated','Product',2,'2021-02-03 19:17:33'),(349,1,'updated','Product',2,'2021-02-03 19:17:54'),(352,1,'updated','Product',2,'2021-02-03 19:18:41'),(353,1,'updated','User',1,'2021-02-03 19:28:33'),(354,1,'updated','User',1,'2021-02-03 19:31:16'),(355,1,'updated','Product',2,'2021-02-03 19:31:51'),(356,1,'updated','Product',2,'2021-02-03 19:32:19'),(357,1,'updated','Product',2,'2021-02-03 19:33:16'),(359,1,'updated','Product',3,'2021-02-04 12:12:21'),(361,1,'updated','Product',2,'2021-02-04 21:37:34'),(362,1,'updated','Product',2,'2021-02-04 21:37:42'),(363,1,'updated','Product',2,'2021-02-04 21:37:48'),(364,1,'updated','Product',2,'2021-02-04 21:38:01'),(365,1,'updated','Product',2,'2021-02-04 21:38:15'),(366,NULL,'created','User',2,'2021-02-04 22:28:02'),(367,1,'deleted','User',2,'2021-02-04 22:31:03'),(368,NULL,'created','User',3,'2021-02-04 22:31:30'),(369,1,'deleted','User',3,'2021-02-04 22:32:14'),(370,NULL,'created','User',4,'2021-02-04 22:32:29'),(374,NULL,'updated','User',4,'2021-02-04 22:58:37'),(375,1,'deleted','User',4,'2021-02-04 22:58:42'),(377,1,'updated','Product',2,'2021-02-05 08:54:13'),(378,1,'updated','Product',2,'2021-02-08 20:34:42'),(379,1,'updated','Product',2,'2021-02-08 21:19:43'),(380,NULL,'created','User',2,'2021-02-08 22:12:38'),(381,1,'updated','User',1,'2021-02-08 22:27:25'),(382,1,'updated','User',1,'2021-02-08 22:27:34'),(394,NULL,'updated','User',2,'2021-02-08 22:38:38'),(396,NULL,'updated','User',2,'2021-02-08 22:39:07'),(397,NULL,'updated','User',2,'2021-02-08 22:40:02'),(398,NULL,'updated','User',2,'2021-02-08 22:40:16'),(403,1,'updated','Product',3,'2021-02-08 23:20:45'),(404,1,'deleted','User',2,'2021-02-08 23:23:53'),(406,1,'updated','User',1,'2021-02-09 16:06:32'),(408,1,'updated','User',1,'2021-02-09 17:18:18'),(410,1,'updated','User',1,'2021-02-09 17:19:13'),(411,1,'updated','User',1,'2021-02-09 17:19:27'),(412,1,'updated','User',1,'2021-02-09 17:19:36'),(414,1,'updated','User',1,'2021-02-09 17:20:18'),(415,1,'updated','User',1,'2021-02-09 17:28:32'),(416,1,'updated','User',1,'2021-02-09 17:28:39'),(417,1,'updated','User',1,'2021-02-09 17:28:45'),(418,1,'updated','User',1,'2021-02-09 17:29:04'),(421,1,'updated','User',1,'2021-02-09 17:29:19'),(422,1,'updated','User',1,'2021-02-09 17:29:34'),(426,1,'updated','User',1,'2021-02-09 17:36:47'),(429,1,'updated','User',1,'2021-02-11 09:02:40');
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
  KEY `action_id` (`action_id`) USING BTREE,
  CONSTRAINT `logactionattr_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `LogAction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=588 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LogActionAttr`
--

LOCK TABLES `LogActionAttr` WRITE;
/*!40000 ALTER TABLE `LogActionAttr` DISABLE KEYS */;
INSERT INTO `LogActionAttr` VALUES (300,168,'username','\"\"','\"wqqwqdwd\"'),(301,168,'role','\"\"','\"admin\"'),(302,168,'email','\"\"','\"qwdqw@dqdqwd.vrev\"'),(303,168,'design_theme','\"\"','\"nav_full\"'),(304,168,'design_font','\"\"','\"oswald\"'),(305,170,'design_font','\"oswald\"','\"roboto\"'),(306,171,'design_font','\"roboto\"','\"oswald\"'),(307,172,'username','\"wqqwqdwd\"','\"\"'),(308,172,'role','\"admin\"','\"\"'),(309,172,'email','\"qwdqw@dqdqwd.vrev\"','\"\"'),(310,172,'design_theme','\"nav_full\"','\"\"'),(311,172,'design_font','\"oswald\"','\"\"'),(312,173,'design_theme','\"nav_full\"','\"nav_left\"'),(313,173,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(314,174,'design_theme','\"nav_left\"','\"nav_full\"'),(315,174,'design_font','\"ibm_plex_sans\"','\"montserrat\"'),(316,175,'design_font','\"montserrat\"','\"oswald\"'),(317,176,'design_theme','\"nav_full\"','\"nav_left\"'),(318,176,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(319,176,'design_border_radius','\"\"','\"15\"'),(320,177,'design_theme','\"nav_left\"','\"nav_full\"'),(321,177,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(322,177,'design_border_radius','15','\"\"'),(323,178,'design_theme','\"nav_full\"','\"nav_left\"'),(324,178,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(325,178,'design_border_radius','\"\"','\"15\"'),(326,179,'design_border_radius','15','\"20\"'),(327,182,'full_name','\"Administrator 1\"','\"Administrator 12\"'),(328,183,'username','\"admin\"','\"admin2\"'),(329,183,'full_name','\"Administrator 12\"','\"Administrator\"'),(330,184,'username','\"admin2\"','\"admin\"'),(331,186,'options_tmp','[\"Opt 1 en\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]'),(332,187,'username','\"test\"','\"test4\"'),(333,188,'username','\"test4\"','\"test\"'),(334,189,'username','\"\"','\"qwe\"'),(335,189,'role','\"\"','\"admin\"'),(336,189,'email','\"\"','\"qwe@qwe.qwe\"'),(337,189,'design_theme','\"\"','\"nav_full\"'),(338,189,'design_font','\"\"','\"oswald\"'),(339,189,'full_name','\"\"','\"qwe qwe\"'),(340,191,'full_name','\"qwe qwe\"','\"qwezzz\"'),(341,192,'username','\"qwe\"','\"\"'),(342,192,'role','\"admin\"','\"\"'),(343,192,'email','\"qwe@qwe.qwe\"','\"\"'),(344,192,'design_theme','\"nav_full\"','\"\"'),(345,192,'design_font','\"oswald\"','\"\"'),(346,192,'full_name','\"qwezzz\"','\"\"'),(347,194,'name','{\"de\": \"das\", \"en\": \"das\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}'),(348,195,'design_theme','\"nav_full\"','\"nav_left\"'),(349,195,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(350,195,'design_border_radius','\"\"','\"15\"'),(351,196,'design_border_radius','15','\"10\"'),(352,197,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(353,198,'design_font','\"oswald\"','\"roboto\"'),(354,199,'design_font','\"roboto\"','\"montserrat\"'),(355,200,'design_theme','\"nav_left\"','\"nav_full\"'),(356,200,'design_font','\"montserrat\"','\"oswald\"'),(357,200,'design_border_radius','10','\"\"'),(358,201,'design_theme','\"nav_full\"','\"nav_left\"'),(359,202,'design_theme','\"nav_left\"','\"nav_full\"'),(360,203,'design_theme','\"nav_full\"','\"nav_left\"'),(361,203,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(362,204,'design_theme','\"nav_left\"','\"nav_full\"'),(363,205,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(364,207,'design_theme','\"nav_left\"','\"nav_full\"'),(365,208,'design_theme','\"nav_full\"','\"nav_left\"'),(366,209,'design_theme','\"nav_left\"','\"nav_full\"'),(367,210,'design_theme','\"nav_full\"','\"nav_left\"'),(368,211,'design_theme','\"nav_left\"','\"nav_full\"'),(369,212,'images','[]','[\"/uploaded/2020-11-29/5c70ace731882c790548336d99fc9608.png\"]'),(370,213,'discount','\"\"','\"43\"'),(371,214,'discount','43','\"\"'),(372,215,'price','\"\"','\"12\"'),(373,216,'discount','\"\"','\"40\"'),(374,217,'design_theme','\"nav_full\"','\"nav_left\"'),(375,217,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(376,217,'design_border_radius','\"\"','\"15\"'),(377,218,'design_theme','\"nav_left\"','\"nav_full\"'),(378,218,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(379,218,'design_border_radius','15','\"\"'),(380,219,'design_theme','\"nav_full\"','\"nav_left\"'),(381,219,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(382,219,'design_border_radius','\"\"','\"10\"'),(383,220,'design_theme','\"nav_left\"','\"nav_full\"'),(384,220,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(385,220,'design_border_radius','10','\"\"'),(386,221,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]','[]'),(387,222,'email','\"admin@local.host\"','\"admin@local.hostz\"'),(388,228,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(389,230,'email','\"admin@local.host\"','\"admin@local.hostz\"'),(390,231,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(391,233,'email','\"admin@local.host\"','\"admin@local.hostf\"'),(392,234,'email','\"admin@local.hostf\"','\"admin@local.host\"'),(393,236,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(394,237,'phone','\"2231\"','\"\"'),(395,239,'phone','\"\"','\"2231\"'),(396,240,'brand_id','\"\"','\"\"'),(397,240,'quantity','\"\"','\"\"'),(398,240,'options_tmp','[]','[]'),(399,242,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(400,245,'main_category_id','\"Cat 1-1\"','\"Cat 1-1\"'),(401,245,'price','12','\"12\"'),(402,245,'discount','40','\"40\"'),(403,245,'variations_tmp','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]'),(404,245,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(405,245,'related_tmp','[\"Prod 1\"]','[\"Prod 1\"]'),(406,246,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(407,247,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(408,247,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 3\"]'),(409,251,'images','[]','[\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"]'),(410,252,'options_tmp','[]','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]'),(411,254,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(412,254,'options_tmp','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]','[]'),(413,255,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(414,255,'options_tmp','[]','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]'),(415,259,'full_name','\"Administrator\"','\"123\"'),(416,261,'full_name','\"123\"','\"Administrator\"'),(417,263,'full_name','\"Administrator\"','\"Administratorz\"'),(418,267,'full_name','\"Administratorz\"','\"Administrator\"'),(419,268,'full_name','\"Administrator\"','\"Administratorz\"'),(420,269,'full_name','\"Administratorz\"','\"Administrator\"'),(421,271,'full_name','\"Administrator\"','\"Administratorz\"'),(422,273,'full_name','\"Administratorz\"','\"Administrator\"'),(423,275,'full_name','\"Administrator\"','\"Administratorz\"'),(424,276,'full_name','\"Administratorz\"','\"Administrator\"'),(425,278,'full_name','\"Administrator\"','\"Administrator1123\"'),(426,279,'full_name','\"Administrator1123\"','\"Administrator\"'),(427,281,'full_name','\"Administrator\"','\"Administratorz\"'),(428,282,'full_name','\"Administratorz\"','\"Administrator\"'),(429,283,'image','\"\"','\"/files/profile/2021-01-24/f363c1939a9f33f0e2d39a680318ee94.png\"'),(430,284,'image','\"/files/profile/2021-01-24/f363c1939a9f33f0e2d39a680318ee94.png\"','\"/files/profile/2021-01-24/9a5436951afe19e7f29f14030e802258.png\"'),(431,285,'image','\"/files/profile/2021-01-24/9a5436951afe19e7f29f14030e802258.png\"','\"/files/profile/2021-01-24/47f2502a419ce1b87ea90e0a3c282ccb.png\"'),(432,289,'full_name','\"Administrator\"','\"Administratorz\"'),(433,292,'full_name','\"Administratorz\"','\"Administrator\"'),(434,295,'full_name','\"Administrator\"','\"admin\"'),(435,296,'full_name','\"admin\"','\"Administrator\"'),(436,298,'image','\"/files/profile/2021-01-24/47f2502a419ce1b87ea90e0a3c282ccb.png\"','\"/files/profile/2021-01-24/0253ff3f08197990c7b25d988626e6e3.png\"'),(437,301,'full_name','\"Administrator\"','\"zAdministrator\"'),(438,302,'full_name','\"zAdministrator\"','\"Administrator\"'),(439,303,'address','\"addr\"','\"addr <div>asd</div>\"'),(440,304,'address','\"addr asd\"','\"addr \\\" asd\"'),(441,305,'phone','\"2231\"','\"2231\\\" asd\"'),(442,307,'address','\"addr \\\" asd\"','\"addr <div>asd</div>\"'),(443,308,'phone','\"2231\\\" asd\"','\"addr <div>asd</div>\"'),(444,309,'address','\"addr <div>asd</div>\"','\"addr\"'),(445,311,'phone','\"addr &lt;div&gt;asd&lt;/div&gt;\"','\"123\"'),(446,312,'design_theme','\"nav_full\"','\"nav_left\"'),(447,313,'design_theme','\"nav_left\"','\"nav_full\"'),(448,315,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\"]'),(449,315,'options_tmp','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]','[]'),(450,316,'categories_tmp','[\"Cat 1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(451,317,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(452,318,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(453,319,'name','\"\"','{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}'),(454,319,'slug','\"\"','\"qwe\"'),(455,319,'short_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(456,319,'full_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(457,319,'price','\"\"','\"2\"'),(458,319,'main_category_id','\"\"','\"Cat 1-1\"'),(459,319,'categories_tmp','[]','[\"Cat 2\", \"Cat 3\"]'),(460,319,'options_tmp','[]','[\"Opt 2\"]'),(461,321,'name','{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}','\"\"'),(462,321,'slug','\"qwe\"','\"\"'),(463,321,'short_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(464,321,'full_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(465,321,'main_category_id','\"Cat 1-1\"','\"\"'),(466,321,'price','2','\"\"'),(467,321,'categories_tmp','[\"Cat 2\", \"Cat 3\"]','[]'),(468,321,'options_tmp','[\"Opt 2\"]','[]'),(469,322,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(470,322,'related_tmp','[\"Prod 1\"]','[]'),(471,323,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(472,324,'related_tmp','[]','[\"das 2\"]'),(473,325,'quantity','3','1'),(474,325,'variations_tmp','[{\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[]'),(475,325,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 3\"]','[]'),(476,325,'options_tmp','[\"Opt 4\"]','[]'),(477,325,'related_tmp','[\"das 2\"]','[]'),(478,326,'quantity','1','3'),(479,327,'quantity','3','5'),(480,328,'quantity','5','7'),(481,329,'quantity','3','1'),(482,330,'quantity','3','1'),(483,331,'quantity','3','1'),(484,332,'quantity','3','1'),(485,333,'quantity','3','1'),(486,334,'quantity','3','1'),(487,335,'quantity','3','1'),(492,341,'phone','\"123\"','\"1234\"'),(493,343,'phone','\"1234\"','\"123\"'),(494,344,'quantity','3','1'),(495,344,'variations_tmp','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[]'),(496,344,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(497,345,'quantity','1','3'),(498,346,'quantity','3','1'),(499,347,'quantity','1','3'),(500,348,'quantity','3','\"\"'),(501,349,'quantity','\"\"','3'),(504,352,'quantity','3','1'),(505,353,'design_border_radius','\"\"','\"10\"'),(506,354,'design_border_radius','10','\"\"'),(507,355,'quantity','1','3'),(508,356,'quantity','3','1'),(509,357,'quantity','1','3'),(510,359,'quantity','3','2'),(511,361,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(512,362,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(513,363,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(514,363,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[]'),(515,364,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(516,364,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(517,365,'variations_tmp','[]','[{\"SKU\": null, \"Price\": null, \"Quantity\": null}]'),(518,366,'username','\"\"','\"qwe\"'),(519,366,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(520,366,'role','\"\"','\"registered\"'),(521,366,'full_name','\"\"','\"qwe\"'),(522,367,'username','\"qwe\"','\"\"'),(523,367,'role','\"registered\"','\"\"'),(524,367,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(525,367,'design_theme','\"nav_left\"','\"\"'),(526,367,'design_font','\"ibm_plex_sans\"','\"\"'),(527,367,'full_name','\"qwe\"','\"\"'),(528,368,'username','\"\"','\"qwe\"'),(529,368,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(530,368,'role','\"\"','\"registered\"'),(531,368,'full_name','\"\"','\"qweqwe\"'),(532,369,'username','\"qwe\"','\"\"'),(533,369,'role','\"registered\"','\"\"'),(534,369,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(535,369,'design_theme','\"nav_left\"','\"\"'),(536,369,'design_font','\"ibm_plex_sans\"','\"\"'),(537,369,'full_name','\"qweqwe\"','\"\"'),(538,370,'username','\"\"','\"qwe\"'),(539,370,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(540,370,'role','\"\"','\"registered\"'),(541,370,'full_name','\"\"','\"qweqweqweqqr\"'),(542,374,'phone','\"\"','\"222\"'),(543,375,'username','\"qwe\"','\"\"'),(544,375,'role','\"registered\"','\"\"'),(545,375,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(546,375,'design_theme','\"nav_left\"','\"\"'),(547,375,'design_font','\"ibm_plex_sans\"','\"\"'),(548,375,'full_name','\"qweqweqweqqr\"','\"\"'),(549,375,'phone','\"222\"','\"\"'),(550,377,'variations_tmp','[{\"SKU\": \"\", \"Price\": 21, \"Quantity\": 2}]','[]'),(551,378,'quantity','3','1'),(552,378,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(553,378,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[]'),(554,379,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(555,379,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(556,380,'username','\"\"','\"test\"'),(557,380,'email','\"\"','\"asd@asd.asd\"'),(558,380,'role','\"\"','\"registered\"'),(559,380,'full_name','\"\"','\"zzz\"'),(560,381,'full_name','\"Administrator\"','\"Administratorz\"'),(561,382,'full_name','\"Administratorz\"','\"Administrator\"'),(562,394,'image','\"\"','\"admin\"'),(563,396,'image','\"admin\"','\"adminz\"'),(564,397,'image','\"adminz\"','\"site/logout\"'),(565,398,'image','\"site/logout\"','\"/logout\"'),(566,403,'related_tmp','[]','[\"Prod 1\"]'),(567,404,'username','\"test\"','\"\"'),(568,404,'role','\"registered\"','\"\"'),(569,404,'email','\"asd@asd.asd\"','\"\"'),(570,404,'design_theme','\"nav_left\"','\"\"'),(571,404,'design_font','\"ibm_plex_sans\"','\"\"'),(572,404,'full_name','\"zzz\"','\"\"'),(573,404,'image','\"/logout\"','\"\"'),(574,406,'image','\"\"','\"/files/profile/2021-02-09/3672a7e9629f2af8a15f68e38ad0c559.png\"'),(575,408,'image','\"/files/profile/2021-02-09/3672a7e9629f2af8a15f68e38ad0c559.png\"','{\"name\": \"Screenshot_1.png\", \"size\": 26266, \"type\": \"image/png\", \"error\": 0, \"tempName\": \"C:\\\\Work\\\\OpenServer\\\\userdata\\\\php_upload\\\\phpE97E.tmp\"}'),(576,410,'image','\"\"','\"/files/profile/2021-02-09/d104aa275050eb8906cbd434cb20ba04.png\"'),(577,411,'image','\"\"','\"/files/profile/2021-02-09/734a5aedc2efceff27e13a1d8f990ec2.png\"'),(578,412,'image','\"/files/profile/2021-02-09/734a5aedc2efceff27e13a1d8f990ec2.png\"','\"/files/profile/2021-02-09/da8a54a9442e1148d48cb1f028cb85f7.png\"'),(579,414,'image','\"/files/profile/2021-02-09/da8a54a9442e1148d48cb1f028cb85f7.png\"','\"/files/profile/2021-02-09/81ba2f566ca62fc555142a087d7e68a2.png\"'),(580,415,'phone','\"123\"','\"123 wew\"'),(581,416,'phone','\"123 wew\"','\"123\"'),(582,417,'image','\"/files/profile/2021-02-09/81ba2f566ca62fc555142a087d7e68a2.png\"','\"/files/profile/2021-02-09/75a15505518a1fce903bb96421493938.png\"'),(583,418,'image','\"\"','\"/files/profile/2021-02-09/035197e3d171ae9857d6207a00cc65bd.png\"'),(584,421,'image','\"/files/profile/2021-02-09/035197e3d171ae9857d6207a00cc65bd.png\"','\"/files/profile/2021-02-09/14fbcbf89dd853995c4a29cef9366eef.png\"'),(585,422,'image','\"/files/profile/2021-02-09/14fbcbf89dd853995c4a29cef9366eef.png\"','\"/files/profile/2021-02-09/1e9117279a43c52f0d860da13d715a38.png\"'),(586,426,'image','\"/files/profile/2021-02-09/1e9117279a43c52f0d860da13d715a38.png\"','\"/files/profile/2021-02-09/836a471bae9d73ca3475a9f795a02277.png\"'),(587,429,'address','\"addr\"','\"addr awd\"');
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
  KEY `tree` (`tree`),
  KEY `lft` (`lft`)
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
  KEY `status` (`status`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
INSERT INTO `Order` VALUES (3,1,'qwe','qwe@qwe.qwe','12','eqwdqwdqwdqw\r\ndqwdqwd wqdqw','pickup','cash',2,48,NULL,'payed','1892bb70d5c653ce1101bb75d22f1e06','2021-02-03 18:15:00','2021-02-08 20:34:42');
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
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  CONSTRAINT `orderproduct_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orderproduct_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderProduct`
--

LOCK TABLES `OrderProduct` WRITE;
/*!40000 ALTER TABLE `OrderProduct` DISABLE KEYS */;
INSERT INTO `OrderProduct` VALUES (4,3,2,'{\"id\": 3, \"sku\": \"dqw\", \"name\": \"das 2\", \"slug\": \"das\", \"price\": 12, \"images\": [\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"], \"created\": \"31.08.2020 15:48\", \"updated\": \"02.02.2021 16:34\", \"brand_id\": null, \"discount\": 40, \"quantity\": 3, \"full_description\": \"\", \"main_category_id\": 123, \"short_description\": \"\"}',12,2,48,0);
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
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `quantity` int(11) NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `sku_2` (`sku`),
  KEY `brand_id` (`brand_id`) USING BTREE,
  KEY `main_category_id` (`main_category_id`) USING BTREE,
  KEY `sku` (`sku`),
  KEY `price` (`price`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`main_category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `ProductBrand` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES (2,'{\"de\": \"Prod 1\", \"en\": \"Prod 1\", \"ru\": \"Prod 1\"}','prod-1','{\"de\": \"fsrrf\", \"en\": \"fsrrf\", \"ru\": \"fsrrf\"}','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"fsefesfse<p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}','[]',NULL,121,23,NULL,1,'qwe','2020-06-14 20:19:00','2021-02-08 21:19:43'),(3,'{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}','das','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','[\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"]',NULL,123,12,40,3,'dqw','2020-08-31 15:48:00','2021-02-08 23:20:45');
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
  KEY `slug` (`slug`),
  KEY `lft` (`lft`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategory`
--

LOCK TABLES `ProductCategory` WRITE;
/*!40000 ALTER TABLE `ProductCategory` DISABLE KEYS */;
INSERT INTO `ProductCategory` VALUES (1,1,1,10,0,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','',NULL,'null','2020-09-12 15:00:00','2020-09-12 15:00:00'),(120,1,2,5,1,1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/media/svg_image.svg','{\"de\": \"dawda<p>da</p>\", \"en\": \"dawda<p>da</p>\", \"ru\": \"dawda<p>da</p>\"}','2020-09-12 15:00:00','2021-02-10 19:23:15'),(121,1,6,7,1,1,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"fsefs<p>efsefs</p>\", \"en\": \"fsefs<p>efsefs</p>\", \"ru\": \"fsefs<p>efsefs</p>\"}','2020-09-12 15:00:00','2021-02-02 16:34:16'),(122,1,8,9,1,1,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-01-18 08:28:19'),(123,1,3,4,2,1,'{\"de\": \"Cat 1-1\", \"en\": \"Cat 1-1\", \"ru\": \"Cat 1-1\"}','cat-1-1','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-02-03 19:52:28');
/*!40000 ALTER TABLE `ProductCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategoryRef`
--

DROP TABLE IF EXISTS `ProductCategoryRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategoryRef` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `productcategoryref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productcategoryref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategoryRef`
--

LOCK TABLES `ProductCategoryRef` WRITE;
/*!40000 ALTER TABLE `ProductCategoryRef` DISABLE KEYS */;
INSERT INTO `ProductCategoryRef` VALUES (2,120),(2,123);
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
  KEY `specification_id` (`specification_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `productcategoryspecificationref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ProductCategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productcategoryspecificationref_ibfk_3` FOREIGN KEY (`specification_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategorySpecificationRef`
--

LOCK TABLES `ProductCategorySpecificationRef` WRITE;
/*!40000 ALTER TABLE `ProductCategorySpecificationRef` DISABLE KEYS */;
INSERT INTO `ProductCategorySpecificationRef` VALUES (122,3),(123,1),(123,2);
/*!40000 ALTER TABLE `ProductCategorySpecificationRef` ENABLE KEYS */;
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
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `option_id` (`option_id`) USING BTREE,
  CONSTRAINT `productoptionref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productoptionref_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `ProductSpecificationOption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductOptionRef`
--

LOCK TABLES `ProductOptionRef` WRITE;
/*!40000 ALTER TABLE `ProductOptionRef` DISABLE KEYS */;
INSERT INTO `ProductOptionRef` VALUES (2,1),(2,3),(2,5);
/*!40000 ALTER TABLE `ProductOptionRef` ENABLE KEYS */;
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
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `related_id` (`related_id`) USING BTREE,
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
  PRIMARY KEY (`id`),
  KEY `use_filter` (`use_filter`),
  KEY `use_compare` (`use_compare`),
  KEY `use_detail` (`use_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductSpecification`
--

LOCK TABLES `ProductSpecification` WRITE;
/*!40000 ALTER TABLE `ProductSpecification` DISABLE KEYS */;
INSERT INTO `ProductSpecification` VALUES (1,'{\"de\": \"Attr 1\", \"en\": \"Attr 1\", \"ru\": \"Attr 1\"}',1,0,1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(2,'{\"de\": \"Attr 2\", \"en\": \"Attr 2\", \"ru\": \"Attr 2\"}',1,1,0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(3,'{\"de\": \"Attr 3\", \"en\": \"Attr 3\", \"ru\": \"Attr 3\"}',0,0,1,'2020-09-12 15:00:00','2021-02-08 21:19:22');
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
  `specification_id` int(11) NOT NULL,
  `name` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `specification_id` (`specification_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `productspecificationoption_ibfk_1` FOREIGN KEY (`specification_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `specification_id` (`specification_id`) USING BTREE,
  KEY `option_id` (`option_id`) USING BTREE,
  KEY `sku` (`sku`),
  KEY `sort` (`sort`),
  CONSTRAINT `productvariation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productvariation_ibfk_2` FOREIGN KEY (`specification_id`) REFERENCES `ProductSpecification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productvariation_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `ProductSpecificationOption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductVariation`
--

LOCK TABLES `ProductVariation` WRITE;
/*!40000 ALTER TABLE `ProductVariation` DISABLE KEYS */;
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
  KEY `model_class` (`model_class`,`model_id`,`lang`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SeoMeta`
--

LOCK TABLES `SeoMeta` WRITE;
/*!40000 ALTER TABLE `SeoMeta` DISABLE KEYS */;
INSERT INTO `SeoMeta` VALUES (1,'Blog',8,'en','{\"title\": \"rsg awd\", \"og:image\": \"/uploads/media/svg_html.svg\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(5,'Product',3,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(6,'Staticpage',16,'en','{\"title\": \"qwe en\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(11,'BlockPage',3,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(12,'ProductCategory',122,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(14,'ProductCategory',123,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(16,'ProductCategory',121,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(17,'Product',2,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(18,'Blog',2,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(20,'Blog',8,'ru','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(21,'ProductCategory',120,'en','{\"title\": \"\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(32,'Staticpage',16,'ru','{\"title\": \"qwe ru\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}'),(33,'Staticpage',16,'de','{\"title\": \"qwe de\", \"og:image\": \"\", \"og:title\": \"\", \"description\": \"\", \"og:description\": \"\"}');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Staticpage`
--

LOCK TABLES `Staticpage` WRITE;
/*!40000 ALTER TABLE `Staticpage` DISABLE KEYS */;
INSERT INTO `Staticpage` VALUES (16,'home','Home',1);
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
  `staticpage_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  `type` enum('text_input','text_area','checkbox','elfinder','imperavi','files','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `part_index` int(11) NOT NULL,
  `part_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `staticpage_id` (`staticpage_id`) USING BTREE,
  KEY `part_index` (`part_index`),
  KEY `name` (`name`),
  CONSTRAINT `staticpageblock_ibfk_1` FOREIGN KEY (`staticpage_id`) REFERENCES `Staticpage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticpageBlock`
--

LOCK TABLES `StaticpageBlock` WRITE;
/*!40000 ALTER TABLE `StaticpageBlock` DISABLE KEYS */;
INSERT INTO `StaticpageBlock` VALUES (45,16,'title','Title','\"qwe\"','text_input','[]',0,'First',0),(46,16,'description','Description','{\"en\": \"<p>qweq we</p>\"}','imperavi','[]',0,'First',1);
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
  `type` enum('text_input','text_area','checkbox','elfinder','imperavi') COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `SystemSettings` VALUES (3,'site_name','Site name','SpeedRunner CMS','text_input',0),(6,'site_logo','Logo','/uploads/logo.svg','elfinder',1),(7,'admin_email','Email','admin@localhost.loc','text_input',3),(10,'delete_model_file','Delete file after removing record','1','checkbox',4),(11,'site_favicon','Favicon','/uploads/logo.svg','elfinder',2);
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
  CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `TranslationSource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationMessage`
--

LOCK TABLES `TranslationMessage` WRITE;
/*!40000 ALTER TABLE `TranslationMessage` DISABLE KEYS */;
INSERT INTO `TranslationMessage` VALUES (1,'de',''),(1,'en','ID'),(1,'ru','ID'),(2,'de',''),(2,'en','Username'),(2,'ru','Логин'),(3,'de',''),(3,'en','Role'),(3,'ru','Роль'),(4,'de',''),(4,'en','Email'),(4,'ru','Email'),(5,'de',''),(5,'en','New password'),(5,'ru','Новый пароль'),(6,'de',''),(6,'en','Theme'),(6,'ru','Тема'),(7,'de',''),(7,'en','Font'),(7,'ru','Шрифт'),(8,'de',''),(8,'en','Border radius'),(8,'ru','Радиус границ'),(9,'de',''),(9,'en','Full name'),(9,'ru','Ф.И.О.'),(10,'de',''),(10,'en','Phone'),(10,'ru','Телефон'),(11,'de',''),(11,'en','Address'),(11,'ru','Адрес'),(12,'de',''),(12,'en','Image'),(12,'ru','Изображение'),(13,'de',''),(13,'en','Created'),(13,'ru','Создано'),(14,'de',''),(14,'en','Updated'),(14,'ru','Изменено'),(15,'de',''),(15,'en','Users'),(15,'ru','Пользователи'),(16,'de',''),(16,'en','Create'),(16,'ru','Создание'),(17,'de',''),(17,'en','Admin'),(17,'ru','Администратор'),(18,'de',''),(18,'en','Registered'),(18,'ru','Зарегистрированный'),(19,'de',''),(19,'en','Delete all'),(19,'ru','Удалить все'),(20,'de',''),(20,'en','Are you sure?'),(20,'ru','Вы уверены?'),(21,'de',''),(21,'en','RBAC'),(21,'ru','Менеджер ролей'),(22,'de',''),(22,'en','Static pages'),(22,'ru','Статичные страницы'),(23,'de',''),(23,'en','Content'),(23,'ru','Контент'),(24,'de',''),(24,'en','Menu'),(24,'ru','Меню'),(25,'de',''),(25,'en','Pages'),(25,'ru','Страницы'),(26,'de',''),(26,'en','Banners'),(26,'ru','Баннеры'),(27,'de',''),(27,'en','Blocks'),(27,'ru','Блоки'),(28,'de',''),(28,'en','Types'),(28,'ru','Типы'),(29,'de',''),(29,'en','Blogs'),(29,'ru','Блоги'),(30,'de',''),(30,'en','Categories'),(30,'ru','Категории'),(31,'de',''),(31,'en','Tags'),(31,'ru','Теги'),(32,'de',''),(32,'en','Comments'),(32,'ru','Комментарии'),(33,'de',''),(33,'en','Rates'),(33,'ru','Оценки'),(34,'de',''),(34,'en','Products'),(34,'ru','Продукты'),(35,'de',''),(35,'en','Brands'),(35,'ru','Бренды'),(36,'de',''),(36,'en','Specifications'),(36,'ru','Характеристики'),(37,'de',''),(37,'en','Orders'),(37,'ru','Заказы'),(38,'de',''),(38,'en','System'),(38,'ru','Система'),(39,'de',''),(39,'en','Settings'),(39,'ru','Настройки'),(40,'de',''),(40,'en','Languages'),(40,'ru','Языки'),(41,'de',''),(41,'en','Translations'),(41,'ru','Переводы'),(42,'de',''),(42,'en','Log actions'),(42,'ru','Лог действий'),(43,'de',''),(43,'en','Cache'),(43,'ru','Кэш'),(44,'de',''),(44,'en','Remove thumbs'),(44,'ru','Удалить миниатюры'),(45,'de',''),(45,'en','Clear'),(45,'ru','Очистить'),(46,'de',''),(46,'en','Speedrunner'),(46,'ru','Speedrunner'),(47,'de',''),(47,'en','Information'),(47,'ru','Информация'),(48,'de',''),(48,'en','Functions'),(48,'ru','Функции'),(49,'de',''),(49,'en','Change password'),(49,'ru','Сменить пароль'),(50,'de',''),(50,'en','Logout'),(50,'ru','Выйти'),(51,'de',''),(51,'en','No notifications'),(51,'ru','Нет уведомлений'),(52,'de',''),(52,'en','Bookmarks'),(52,'ru','Вкладки'),(53,'de',''),(53,'en','Add'),(53,'ru','Добавление'),(54,'de',''),(54,'en','Home'),(54,'ru','Главная'),(55,'de',''),(55,'en','RBAC'),(55,'ru','Менеджер ролей'),(56,'de',''),(56,'en','Routes'),(56,'ru','Маршруты'),(57,'de',''),(57,'en','Rules'),(57,'ru','Правила'),(58,'de',''),(58,'en','Roles'),(58,'ru','Роли'),(59,'de',''),(59,'en','Assignments'),(59,'ru','Привязки'),(60,'de',''),(60,'en','Permissions'),(60,'ru','Права'),(61,'de',''),(61,'en','Static page: {label}'),(61,'ru','Статичная страница: {label}'),(62,'de',''),(62,'en','Save'),(62,'ru','Сохранить'),(63,'de',''),(63,'en','SEO meta'),(63,'ru','SEO мета'),(64,'de',''),(64,'en','Name'),(64,'ru','Название'),(65,'de',''),(65,'en','Label'),(65,'ru','Лейбл'),(66,'de',''),(66,'en','Value'),(66,'ru','Значение'),(67,'de',''),(67,'en','Type'),(67,'ru','Тип'),(68,'de',''),(68,'en','Browse'),(68,'ru','Просмотр'),(69,'de',''),(69,'en','Error'),(69,'ru','Ошибка'),(70,'de',''),(70,'en','Tree'),(70,'ru','Дерево'),(71,'de',''),(71,'en','Search'),(71,'ru','Поиск'),(72,'de',''),(72,'en','Left'),(72,'ru','Слева'),(73,'de',''),(73,'en','Right'),(73,'ru','Справа'),(74,'de',''),(74,'en','Depth'),(74,'ru','Глубина'),(75,'de',''),(75,'en','Expanded'),(75,'ru','Развёрнуто'),(76,'de',''),(76,'en','Url'),(76,'ru','Ссылка'),(77,'de',''),(77,'en','Parent'),(77,'ru','Родитель'),(78,'de',''),(78,'en','Slug'),(78,'ru','Ссылка'),(79,'de',''),(79,'en','Description'),(79,'ru','Описание'),(80,'de',''),(80,'en','Location'),(80,'ru','Локация'),(81,'de',''),(81,'en','Groups'),(81,'ru','Группы'),(82,'de',''),(82,'en','Slider home'),(82,'ru','Слайдер на главной странице'),(83,'de',''),(83,'en','Slider about'),(83,'ru','Слайдер на странице \"о компании\"'),(84,'de',''),(84,'en','Save & reload'),(84,'ru','Сохранить и перезагрузить'),(85,'de',''),(85,'en','Profile'),(85,'ru','Профиль'),(86,'de',''),(86,'en','Design'),(86,'ru','Дизайн'),(87,'de',''),(87,'en','Field must contain only alphabet and numerical chars'),(87,'ru','Поле должно содержать только буквы и цифры'),(88,'de',''),(88,'en','Full menu'),(88,'ru','Полное меню'),(89,'de',''),(89,'en','Left menu'),(89,'ru','Меню слева'),(94,'de',''),(94,'en','Routes'),(94,'ru','Маршруты'),(95,'de',''),(95,'en','Refresh'),(95,'ru','Обновить'),(96,'de',''),(96,'en','Search for available'),(96,'ru','Поиск доступных'),(97,'de',''),(97,'en','Include'),(97,'ru','Включить'),(98,'de',''),(98,'en','Assign'),(98,'ru','Привязать'),(99,'de',''),(99,'en','Exclude'),(99,'ru','Исключить'),(100,'de',''),(100,'en','Remove'),(100,'ru','Удаление'),(101,'de',''),(101,'en','Search for assigned'),(101,'ru','Поиск привязок'),(102,'de',''),(102,'en','Rules'),(102,'ru','Правила'),(103,'de',''),(103,'en','Create'),(103,'ru','Создание'),(104,'de',''),(104,'en','Name'),(104,'ru','Название'),(105,'de',''),(105,'en','Roles'),(105,'ru','Роли'),(106,'de',''),(106,'en','Rule name'),(106,'ru','Название правила'),(107,'de',''),(107,'en','Select rule'),(107,'ru','Выберите правило'),(108,'de',''),(108,'en','Description'),(108,'ru','Описание'),(109,'de',''),(109,'en','Assignments'),(109,'ru','Привязки'),(110,'de',''),(110,'en','Permissions'),(110,'ru','Права'),(111,'de',''),(111,'en','General'),(111,'ru','Основной'),(112,'de',''),(112,'en','Class name'),(112,'ru','Название класса'),(113,'de',''),(113,'en','Update: {name}'),(113,'ru','Редактирование: {name}'),(114,'de',''),(114,'en','View: {name}'),(114,'ru','Отображение: {name}'),(115,'de',''),(115,'en','Assignment'),(115,'ru','Привязка'),(116,'de',''),(116,'en','Type'),(116,'ru','Тип'),(117,'de',''),(117,'en','Data'),(117,'ru','Данные'),(118,'de',''),(118,'en','Assignment: {username}'),(118,'ru','Привязка: {username}'),(119,'de',''),(119,'en','Record has been saved'),(119,'ru','Запись сохранена'),(120,'de',''),(120,'en','Delete'),(120,'ru','Удалить'),(121,'de',''),(121,'en','Delete with children'),(121,'ru','Удалить с дочерними'),(122,'de',''),(122,'en','Record has been deleted'),(122,'ru','Запись удалена'),(123,'de',''),(123,'en','Banner'),(123,'ru','Баннер'),(124,'de',''),(124,'en','Text 1'),(124,'ru','Текст 1'),(125,'de',''),(125,'en','Text 2'),(125,'ru','Текст 2'),(126,'de',''),(126,'en','Text 3'),(126,'ru','Текст 3'),(127,'de',''),(127,'en','Link'),(127,'ru','Ссылка'),(128,'de',''),(128,'en','Has translation'),(128,'ru','Имеется перевод'),(129,'de',''),(129,'en','Block types'),(129,'ru','Блочные типы'),(130,'de',''),(130,'en','Block pages'),(130,'ru','Блочные страницы'),(131,'de',''),(131,'en','Assign'),(131,'ru','Привязка'),(132,'de',''),(132,'en','Category'),(132,'ru','Категория'),(135,'de',''),(135,'en','Images'),(135,'ru','Изображения'),(136,'de',''),(136,'en','Published'),(136,'ru','Опубликовано'),(137,'de',''),(137,'en','Blog categories'),(137,'ru','Категории блогов'),(138,'de',''),(138,'en','Blog tags'),(138,'ru','Теги блогов'),(139,'de',''),(139,'en','Blog'),(139,'ru','Блог'),(140,'de',''),(140,'en','User'),(140,'ru','Пользователь'),(141,'de',''),(141,'en','Text'),(141,'ru','Текст'),(142,'de',''),(142,'en','Status'),(142,'ru','Статус'),(143,'de',''),(143,'en','Blog comments'),(143,'ru','Комментарии к блогам'),(144,'de',''),(144,'en','New'),(144,'ru','Новый'),(145,'de',''),(145,'en','Mark'),(145,'ru','Оценка'),(146,'de',''),(146,'en','Blog rates'),(146,'ru','Оценки блогов'),(147,'de',''),(147,'en','Update: {label}'),(147,'ru','Редактирование: {label}'),(148,'de',''),(148,'en','Used'),(148,'ru','Использовано'),(149,'de',''),(149,'en','Assign: {name}'),(149,'ru','Привязка: {name}'),(150,'de',''),(150,'en','Page'),(150,'ru','Страница'),(151,'de',''),(151,'en','Comments & rates: {name}'),(151,'ru','Комментарии и оценки: {name}'),(152,'de',''),(152,'en','Comment: {id}'),(152,'ru','Комментарий: {id}'),(153,'de',''),(153,'en','Brand'),(153,'ru','Бренд'),(154,'de',''),(154,'en','Main category'),(154,'ru','Главная категория'),(155,'de',''),(155,'en','Price'),(155,'ru','Цена'),(156,'de',''),(156,'en','Discount'),(156,'ru','Скидка'),(157,'de',''),(157,'en','Quantity'),(157,'ru','Количество'),(158,'de',''),(158,'en','SKU'),(158,'ru','Артикул'),(159,'de',''),(159,'en','Options'),(159,'ru','Опции'),(160,'de',''),(160,'en','Related'),(160,'ru','Сопутствующие'),(161,'de',''),(161,'en','Variations'),(161,'ru','Вариации'),(162,'de',''),(162,'en','Total price'),(162,'ru','Итоговая стоимость'),(163,'de',''),(163,'en','Product categories'),(163,'ru','Категории продуктов'),(164,'de',''),(164,'en','Product brands'),(164,'ru','Бренды продуктов'),(165,'de',''),(165,'en','Product'),(165,'ru','Продукт'),(166,'de',''),(166,'en','Products comments'),(166,'ru','Комментарии к продуктам'),(167,'de',''),(167,'en','Product rates'),(167,'ru','Оценки продуктов'),(168,'de',''),(168,'en','E-mail'),(168,'ru','E-mail'),(169,'de',''),(169,'en','Delivery type'),(169,'ru','Тип доставки'),(170,'de',''),(170,'en','Payment type'),(170,'ru','Тип оплаты'),(171,'de',''),(171,'en','Total quantity'),(171,'ru','Общее количество'),(172,'de',''),(172,'en','Delivery price'),(172,'ru','Стоимость доставки'),(173,'de',''),(173,'en','Key'),(173,'ru','Ключ'),(174,'de',''),(174,'en','Pickup'),(174,'ru','Самовывоз'),(175,'de',''),(175,'en','Delivery'),(175,'ru','Доставка'),(176,'de',''),(176,'en','Cash'),(176,'ru','Наличные'),(177,'de',''),(177,'en','Bank card'),(177,'ru','Банковская карта'),(178,'de',''),(178,'en','Confirmed'),(178,'ru','Подтверждено'),(179,'de',''),(179,'en','Payed'),(179,'ru','Оплачено'),(180,'de',''),(180,'en','Completed'),(180,'ru','Завершено'),(181,'de',''),(181,'en','Canceled'),(181,'ru','Отменено'),(182,'de',''),(182,'en','Stock'),(182,'ru','Склад'),(183,'de',''),(183,'en','Categories & Specifications'),(183,'ru','Категории и характеристики'),(184,'de',''),(184,'en','Specification'),(184,'ru','Характеристика'),(185,'de',''),(185,'en','Option'),(185,'ru','Опция'),(186,'de',''),(186,'en','Use in filter'),(186,'ru','Использовать в фильтре'),(187,'de',''),(187,'en','Use in compare'),(187,'ru','Использовать при сравнении'),(188,'de',''),(188,'en','Use in detail page'),(188,'ru','Использовать в детальной странице'),(189,'de',''),(189,'en','Product specifications'),(189,'ru','Характеристики продуктов'),(190,'de',''),(190,'en','Checkout price'),(190,'ru','Сумма к оплате'),(191,'de',''),(191,'en','Order №{order_id}'),(191,'ru','Заказ №{order_id}'),(192,'de',''),(192,'en','View: {id}'),(192,'ru','Отображение: {id}'),(193,'de',''),(193,'en','Total'),(193,'ru','Итого'),(194,'de',''),(194,'en','Person'),(194,'ru','Человек'),(195,'de',''),(195,'en','Order'),(195,'ru','Заказ'),(196,'de',''),(196,'en','Products price: {price} сум'),(196,'ru','Цена за продукцию: {price} сум'),(197,'de',''),(197,'en','Delivery price: {price} сум'),(197,'ru','Стоимость доставки: {price} сум'),(198,'de',''),(198,'en','Total price: {price} сум'),(198,'ru','Итоговая цена: {price} сум'),(199,'de',''),(199,'en','System settings'),(199,'ru','Системные настройки'),(200,'de',''),(200,'en','Code'),(200,'ru','Код'),(201,'de',''),(201,'en','Active'),(201,'ru','Активный'),(202,'de',''),(202,'en','Main'),(202,'ru','Главный'),(203,'de',''),(203,'en','System languages'),(203,'ru','Системные языки'),(204,'de',''),(204,'en','Action'),(204,'ru','Действие'),(205,'de',''),(205,'en','Old value'),(205,'ru','Старое значение'),(206,'de',''),(206,'en','New value'),(206,'ru','Новое значение'),(207,'de',''),(207,'en','Deleted'),(207,'ru','Удалено'),(208,'de',''),(208,'en','View'),(208,'ru','Отображение'),(209,'de',''),(209,'en','Process has been completed'),(209,'ru','Процесс завершён'),(210,'de',''),(210,'en','Message'),(210,'ru','Сообщение'),(211,'de',''),(211,'en','Translation sources'),(211,'ru','Исходники переводов'),(212,'de',''),(212,'en','Log actions #{id}'),(212,'ru','Лог действий #{id}'),(213,'de',''),(213,'en','Update: {message}'),(213,'ru','Редактирование: {message}'),(229,'de',''),(229,'en','Sign in'),(229,'ru','Авторизация'),(230,'de',''),(230,'en','Password'),(230,'ru','Пароль'),(231,'de',''),(231,'en','Remember me'),(231,'ru','Запомнить меня'),(232,'de',''),(232,'en','{attribute} is incorrect'),(232,'ru','{attribute} заполнен неверно'),(233,'de',''),(233,'en','Model class'),(233,'ru','Класс модели'),(234,'de',''),(234,'en','Model ID'),(234,'ru','ID модели'),(235,'de',''),(235,'en','Language'),(235,'ru','Язык'),(236,'de',''),(236,'en','Update: {username}'),(236,'ru','Редактирование: {username}'),(237,'de',''),(237,'en','This username has already been taken'),(237,'ru','Данный логин уже занят'),(238,'de',''),(238,'en','This email has already been taken'),(238,'ru','Данный email уже занят'),(239,'de',''),(239,'en','There is no user with this email address'),(239,'ru','Пользователь с данным email адресом не найден'),(240,'de',''),(240,'en','Login'),(240,'ru','Авторизация'),(241,'de',''),(241,'en','Password changing'),(241,'ru','Изменение пароля'),(242,'de',''),(242,'en','Update'),(242,'ru','Редактирование'),(243,'de',''),(243,'en','System translations'),(243,'ru','Системные переводы'),(244,'de',''),(244,'en','Short description'),(244,'ru','Краткое описание'),(245,'de',''),(245,'en','Full description'),(245,'ru','Полное описание'),(246,'de',''),(246,'en','Sku'),(246,'ru','Артикул'),(247,'de',''),(247,'en','Submit'),(247,'ru','Отправить'),(248,'de',''),(248,'en','An error occurred'),(248,'ru','Произошла ошибка'),(249,'de',''),(249,'en','Update: {id}'),(249,'ru','Редактирование: {id}'),(268,'de',''),(268,'en','Update: {value}'),(268,'ru','Редактирование: {value}'),(269,'de',''),(269,'en','An error occurred'),(269,'ru','Произошла ошибка'),(270,'de',''),(270,'en','{length} symbols'),(270,'ru','{length} символов'),(271,'de',''),(271,'en',''),(271,'ru',''),(272,'de',''),(272,'en',''),(272,'ru',''),(273,'de',''),(273,'en',''),(273,'ru',''),(276,'de',''),(276,'en',''),(276,'ru',''),(277,'de',''),(277,'en',''),(277,'ru',''),(278,'de',''),(278,'en',''),(278,'ru',''),(279,'de',''),(279,'en',''),(279,'ru',''),(280,'de',''),(280,'en',''),(280,'ru',''),(281,'de',''),(281,'en',''),(281,'ru',''),(282,'de',''),(282,'en',''),(282,'ru',''),(283,'de',''),(283,'en',''),(283,'ru',''),(284,'de',''),(284,'en',''),(284,'ru',''),(285,'de',''),(285,'en',''),(285,'ru',''),(286,'de',''),(286,'en',''),(286,'ru',''),(287,'de',''),(287,'en',''),(287,'ru',''),(288,'de',''),(288,'en',''),(288,'ru',''),(289,'de',''),(289,'en',''),(289,'ru',''),(290,'de',''),(290,'en',''),(290,'ru',''),(291,'de',''),(291,'en',''),(291,'ru',''),(292,'de',''),(292,'en',''),(292,'ru',''),(293,'de',''),(293,'en',''),(293,'ru',''),(294,'de',''),(294,'en',''),(294,'ru',''),(296,'de',''),(296,'en',''),(296,'ru','');
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
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationSource`
--

LOCK TABLES `TranslationSource` WRITE;
/*!40000 ALTER TABLE `TranslationSource` DISABLE KEYS */;
INSERT INTO `TranslationSource` VALUES (1,'app','Id'),(2,'app','Username'),(3,'app','Role'),(4,'app','Email'),(5,'app','New password'),(6,'app','Theme'),(7,'app','Font'),(8,'app','Border radius'),(9,'app','Full name'),(10,'app','Phone'),(11,'app','Address'),(12,'app','Image'),(13,'app','Created'),(14,'app','Updated'),(15,'app','Users'),(16,'app','Create'),(17,'app','Admin'),(18,'app','Registered'),(19,'app','Delete all'),(20,'app','Are you sure?'),(21,'app','RBAC'),(22,'app','Static pages'),(23,'app','Content'),(24,'app','Menu'),(25,'app','Pages'),(26,'app','Banners'),(27,'app','Blocks'),(28,'app','Types'),(29,'app','Blogs'),(30,'app','Categories'),(31,'app','Tags'),(32,'app','Comments'),(33,'app','Rates'),(34,'app','Products'),(35,'app','Brands'),(36,'app','Specifications'),(37,'app','Orders'),(38,'app','System'),(39,'app','Settings'),(40,'app','Languages'),(41,'app','Translations'),(42,'app','Log actions'),(43,'app','Cache'),(44,'app','Remove thumbs'),(45,'app','Clear'),(46,'app','Speedrunner'),(47,'app','Information'),(48,'app','Functions'),(49,'app','Change password'),(50,'app','Logout'),(51,'app','No notifications'),(52,'app','Bookmarks'),(53,'app','Add'),(54,'app','Home'),(55,'yii2mod.rbac','RBAC'),(56,'app','Routes'),(57,'app','Rules'),(58,'app','Roles'),(59,'app','Assignments'),(60,'app','Permissions'),(61,'app','Static page: {label}'),(62,'app','Save'),(63,'app','SEO meta'),(64,'app','Name'),(65,'app','Label'),(66,'app','Value'),(67,'app','Type'),(68,'app','Browse'),(69,'app','Error'),(70,'app','Tree'),(71,'app','Search'),(72,'app','Lft'),(73,'app','Rgt'),(74,'app','Depth'),(75,'app','Expanded'),(76,'app','Url'),(77,'app','Parent'),(78,'app','Slug'),(79,'app','Description'),(80,'app','Location'),(81,'app','Groups'),(82,'app','Slider home'),(83,'app','Slider about'),(84,'app','Save & reload'),(85,'app','Profile'),(86,'app','Design'),(87,'app','Field must contain only alphabet and numerical chars'),(88,'app','Full menu'),(89,'app','Left menu'),(94,'yii2mod.rbac','Routes'),(95,'yii2mod.rbac','Refresh'),(96,'yii2mod.rbac','Search for available'),(97,'app','Include'),(98,'yii2mod.rbac','Assign'),(99,'app','Exclude'),(100,'yii2mod.rbac','Remove'),(101,'yii2mod.rbac','Search for assigned'),(102,'yii2mod.rbac','Rules'),(103,'yii2mod.rbac','Create'),(104,'yii2mod.rbac','Name'),(105,'yii2mod.rbac','Roles'),(106,'yii2mod.rbac','Rule Name'),(107,'yii2mod.rbac','Select Rule'),(108,'yii2mod.rbac','Description'),(109,'yii2mod.rbac','Assignments'),(110,'yii2mod.rbac','Permissions'),(111,'app','General'),(112,'yii2mod.rbac','Class Name'),(113,'app','Update: {name}'),(114,'app','View: {name}'),(115,'app','Assignment'),(116,'yii2mod.rbac','Type'),(117,'yii2mod.rbac','Data'),(118,'yii2mod.rbac','Assignment: {username}'),(119,'app','Record has been saved'),(120,'app','Delete'),(121,'app','Delete with children'),(122,'app','Record has been deleted'),(123,'app','Banner'),(124,'app','Text 1'),(125,'app','Text 2'),(126,'app','Text 3'),(127,'app','Link'),(128,'app','Has translation'),(129,'app','Block types'),(130,'app','Block pages'),(131,'app','Assign'),(132,'app','Category'),(135,'app','Images'),(136,'app','Published'),(137,'app','Blog categories'),(138,'app','Blog tags'),(139,'app','Blog'),(140,'app','User'),(141,'app','Text'),(142,'app','Status'),(143,'app','Blog comments'),(144,'app','New'),(145,'app','Mark'),(146,'app','Blog rates'),(147,'app','Update: {label}'),(148,'app','Used'),(149,'app','Assign: {name}'),(150,'app','Page'),(151,'app','Comments & rates: {name}'),(152,'app','Comment: {id}'),(153,'app','Brand'),(154,'app','Main category'),(155,'app','Price'),(156,'app','Discount'),(157,'app','Quantity'),(158,'app','SKU'),(159,'app','Options'),(160,'app','Related'),(161,'app','Variations'),(162,'app','Total price'),(163,'app','Product categories'),(164,'app','Product brands'),(165,'app','Product'),(166,'app','Products comments'),(167,'app','Product rates'),(168,'app','E-mail'),(169,'app','Delivery type'),(170,'app','Payment type'),(171,'app','Total quantity'),(172,'app','Delivery price'),(173,'app','Key'),(174,'app','Pickup'),(175,'app','Delivery'),(176,'app','Cash'),(177,'app','Bank card'),(178,'app','Confirmed'),(179,'app','Payed'),(180,'app','Completed'),(181,'app','Canceled'),(182,'app','Stock'),(183,'app','Categories & Specifications'),(184,'app','Specification'),(185,'app','Option'),(186,'app','Use in filter'),(187,'app','Use in compare'),(188,'app','Use in detail page'),(189,'app','Product specifications'),(190,'app','Checkout price'),(191,'app','Order №{order_id}'),(192,'app','View: {id}'),(193,'app','Total'),(194,'app','Person'),(195,'app','Order'),(196,'app','Products price: {price} сум'),(197,'app','Delivery price: {price} сум'),(198,'app','Total price: {price} сум'),(199,'app','System settings'),(200,'app','Code'),(201,'app','Active'),(202,'app','Main'),(203,'app','System languages'),(204,'app','Action'),(205,'app','Old value'),(206,'app','New value'),(207,'app','Deleted'),(208,'app','View'),(209,'app','Process has been completed'),(210,'app','Message'),(211,'app','Translation sources'),(212,'app','Log actions #{id}'),(213,'app','Update: {message}'),(229,'app','Sign in'),(230,'app','Password'),(231,'app','Remember me'),(232,'app','{attribute} is incorrect'),(233,'app','Model class'),(234,'app','Model id'),(235,'app','Language'),(236,'app','Update: {username}'),(237,'app','This username has already been taken'),(238,'app','This email has already been taken'),(239,'app','There is no user with this email address'),(240,'app','Login'),(241,'app','Password changing'),(242,'app','Update'),(243,'app','System translations'),(244,'app','Short description'),(245,'app','Full description'),(246,'app','Sku'),(247,'app','Submit'),(248,'app','An error occured'),(249,'app','Update: {id}'),(268,'app','Update: {value}'),(269,'app','An error occurred'),(270,'app','{length} symbols'),(271,'app_notification','You have new order'),(272,'app','Clear all'),(273,'app','All notifications removed'),(276,'app','Incorrect password'),(277,'app','Variation: {id}'),(278,'app','Variation: {value}'),(279,'app','Save & update'),(280,'app','Signup'),(281,'app','Confirm password'),(282,'app','You have been registered successfully'),(283,'app','Request reset password'),(284,'app','Send'),(285,'app_email','Password reset'),(286,'app','Check your email inbox for further instructions'),(287,'app','Reset password'),(288,'app','Wrong password reset token'),(289,'app_email','Feedback'),(290,'app','Thank you for contacting us. We will respond to you as soon as possible.'),(291,'app','New password saved'),(292,'app','Profile has been updated'),(293,'app','News'),(294,'app','Catalog'),(296,'app','Password has been changed');
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','registered') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_theme` enum('nav_full','nav_left') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nav_left',
  `design_font` enum('oswald','roboto','montserrat','ibm_plex_sans') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ibm_plex_sans',
  `design_border_radius` int(11) NOT NULL DEFAULT '15',
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'admin','admin@local.host','admin','/files/profile/2021-02-09/836a471bae9d73ca3475a9f795a02277.png','nav_full','oswald',0,'8Bw028wnjw5fNyLuU7xmR8xPiYkr0b9T','$2y$13$WBBtzL3B2Jo6tXftDJwZUO80GKsAYyAYYIgmTuaa4iplM81z5wbFK','YfhM8PI9OiR_2x7szrPFdjsXVKgiasyR_1613033787','2020-02-21 04:58:00','2021-02-11 11:55:27');
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
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_ibfk_1` (`user_id`),
  CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserProfile`
--

LOCK TABLES `UserProfile` WRITE;
/*!40000 ALTER TABLE `UserProfile` DISABLE KEYS */;
INSERT INTO `UserProfile` VALUES (4,1,'Administrator','123','addr awd');
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
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1537578127,1537578127),('admin',1,NULL,'admin',NULL,1537596415,1611322289),('registered',1,NULL,'registered',NULL,1585474124,1607506635);
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

-- Dump completed on 2021-02-11 20:47:42
