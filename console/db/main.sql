-- MySQL dump 10.13  Distrib 5.7.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sr-cms-1
-- ------------------------------------------------------
-- Server version	5.7.33

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
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` enum('slider_home','slider_about') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` VALUES (2,'r','slider_home','2019-09-22 10:30:00','2022-03-23 06:34:02'),(3,'qwe','slider_about','2019-09-22 10:30:00','2021-10-31 16:57:32');
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner_group`
--

DROP TABLE IF EXISTS `banner_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner_group` (
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
  CONSTRAINT `banner_group_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner_group`
--

LOCK TABLES `banner_group` WRITE;
/*!40000 ALTER TABLE `banner_group` DISABLE KEYS */;
INSERT INTO `banner_group` VALUES (7,3,'{\"de\": \"e\", \"en\": \"q\", \"ru\": \"w\"}','{\"de\": \"qwdq\", \"en\": \"qwdq\", \"ru\": \"qwdq\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"qwdq\", \"en\": \"qwdq\", \"ru\": \"qwdq\"}','/uploads/media/flags/ag.png',0),(8,3,'{\"de\": \"eee\", \"en\": \"qqq\", \"ru\": \"www\"}','{\"de\": \"dqwd\\r\\nqwdqw\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/svg_text.svg',1),(9,2,'{\"de\": \"eee\", \"en\": \"qqq\", \"ru\": \"www\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','/uploads/media/WebP.webp',0);
/*!40000 ALTER TABLE `banner_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block`
--

DROP TABLE IF EXISTS `block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `value` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`) USING BTREE,
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `block_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `block_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `block_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `block_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block`
--

LOCK TABLES `block` WRITE;
/*!40000 ALTER TABLE `block` DISABLE KEYS */;
INSERT INTO `block` VALUES (19,3,9,'{\"en\": \"\"}',1),(20,3,8,'\"\"',0),(21,3,12,'[]',2),(22,3,13,'[]',3),(23,3,14,'[]',4),(24,3,15,'{\"en\": []}',5);
/*!40000 ALTER TABLE `block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_page`
--

DROP TABLE IF EXISTS `block_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_page`
--

LOCK TABLES `block_page` WRITE;
/*!40000 ALTER TABLE `block_page` DISABLE KEYS */;
INSERT INTO `block_page` VALUES (3,'{\"de\": \"zxc\", \"en\": \"qwe\", \"ru\": \"asd\"}','page-1','2020-06-15 22:20:00','2021-11-11 02:39:52');
/*!40000 ALTER TABLE `block_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_type`
--

DROP TABLE IF EXISTS `block_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('text_input','text_area','checkbox','file_manager','text_editor','files','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_type`
--

LOCK TABLES `block_type` WRITE;
/*!40000 ALTER TABLE `block_type` DISABLE KEYS */;
INSERT INTO `block_type` VALUES (8,'title_1','Title 1','text_input','[]','/uploads/media/image.png',0,'2020-09-12 15:00:00'),(9,'title_2','Title 2','text_input','[]','/uploads/media/svg_image.svg',1,'2020-09-12 15:00:00'),(10,'description_1','Description 1','text_area','[]','/uploads/media/jpg.jpg',0,'2020-09-12 15:00:00'),(11,'description_2','Description 2','text_editor','[]','/uploads/images/logo.png',1,'2020-09-12 15:00:00'),(12,'images_1','Images 1','files','[]','/uploads/images/editor/5ba26895f4021.png',0,'2020-09-12 15:00:00'),(13,'images_2','Images 2','files','[]','/uploads/images/editor/5bc44f0c699b4.png',1,'2020-09-12 15:00:00'),(14,'groups_1','Groups 1','groups','[{\"name\": \"is_available\", \"label\": \"Available\", \"input_type\": \"checkbox\"}, {\"name\": \"image\", \"label\": \"Image\", \"input_type\": \"file_manager\"}]','/uploads/images/flags/au.png',0,'2020-09-12 15:00:00'),(15,'groups_2','Groups 2','groups','[{\"name\": \"title\", \"label\": \"Title\", \"input_type\": \"text_input\"}, {\"name\": \"description\", \"label\": \"Description\", \"input_type\": \"text_editor\"}]','/uploads/images/flags/br.png',1,'2020-09-13 02:55:52');
/*!40000 ALTER TABLE `block_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` json NOT NULL,
  `full_description` json NOT NULL,
  `images` json NOT NULL,
  `published_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`) USING BTREE,
  KEY `published_at` (`published_at`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (2,'{\"de\": \"fsdf\", \"en\": \"fefs\", \"ru\": \"dde\"}','fefs',1,'/uploads/media/flags/ch.png','{\"de\": \"\", \"en\": \"h6h5h5\\r\\n\\r\\nh5 6h5\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"<p>h56h56</p>\\r\\n<p>h56 h5</p>\\r\\n<p>6</p>\", \"ru\": \"\"}','[]','2018-10-16 23:45:00','2018-10-15 15:13:00','2022-03-16 02:13:44'),(8,'{\"de\": \"Blog de\", \"en\": \"Blog en\", \"ru\": \"Blog ru\"}','blog-en',NULL,'/uploads/media/flags/be.png','{\"de\": \"\", \"en\": \"fwef\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"<video width=\\\"300\\\" height=\\\"150\\\"><source src=\\\"/uploaded/2021-10-18/5e84dfb16af83bd6f676343259b59918.mp4\\\">\\r\\n  </video>\", \"ru\": \"\"}','[]','2019-09-22 20:17:00','1970-01-01 03:00:00','2022-03-14 18:31:58'),(9,'{\"de\": \"zxc\", \"en\": \"qwe\", \"ru\": \"asd\"}','qwe',1,'/uploads/media/svg_image.svg','{\"de\": \"\", \"en\": \"qwdqw\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"qwdqwd\", \"ru\": \"\"}','[]','2022-03-02 09:48:00','2022-03-02 09:48:00','2022-03-16 03:34:45');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_category`
--

DROP TABLE IF EXISTS `blog_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_category`
--

LOCK TABLES `blog_category` WRITE;
/*!40000 ALTER TABLE `blog_category` DISABLE KEYS */;
INSERT INTO `blog_category` VALUES (1,'{\"de\": \"Cat 1 de\", \"en\": \"Cat 1 en\", \"ru\": \"Cat 1 ru\"}','cat-1','/uploads/Blog/1537547338_I9HiIO.png','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2022-03-05 15:39:21'),(2,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-06-14 14:40:24'),(3,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','/uploads/media/image-1.png','{\"de\": \"\", \"en\": \"<p>dawdawdawd</p>\\r\\n<p>awdwa</p>\\r\\n<p>d wadawd</p>\\r\\ndaw d awd awd\", \"ru\": \"\"}','2018-10-15 11:17:00','2021-05-10 04:07:16');
/*!40000 ALTER TABLE `blog_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_comment`
--

DROP TABLE IF EXISTS `blog_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `status` (`status`),
  CONSTRAINT `blog_comment_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blog_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_comment`
--

LOCK TABLES `blog_comment` WRITE;
/*!40000 ALTER TABLE `blog_comment` DISABLE KEYS */;
INSERT INTO `blog_comment` VALUES (1,2,1,'eqwdq\r\ndqd','published','2020-06-02 20:04:00');
/*!40000 ALTER TABLE `blog_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_rate`
--

DROP TABLE IF EXISTS `blog_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mark` tinyint(2) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `blog_rate_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blog_rate_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_rate`
--

LOCK TABLES `blog_rate` WRITE;
/*!40000 ALTER TABLE `blog_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_tag`
--

DROP TABLE IF EXISTS `blog_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tag`
--

LOCK TABLES `blog_tag` WRITE;
/*!40000 ALTER TABLE `blog_tag` DISABLE KEYS */;
INSERT INTO `blog_tag` VALUES (4,'йцууй йу','2020-06-14 22:58:38'),(5,'уйцу','2020-06-14 22:58:38'),(6,'dqwd','2020-06-14 22:58:38'),(10,'vvcx','2020-06-14 22:58:38'),(12,'qw','2020-06-14 22:58:38'),(14,'2rr','2020-06-14 22:58:38'),(15,'1ferf','2020-06-14 22:58:38'),(16,'ferf4','2020-06-14 22:58:38'),(17,'ff3f3','2020-06-14 22:58:38'),(18,'wfw','2020-06-14 22:58:38'),(19,'wefz3','2020-06-14 22:58:38'),(20,'tag 1 en','2020-06-14 22:58:38'),(21,'tag 2 en','2020-06-14 22:58:38'),(22,'tag 1 ru','2020-06-14 22:58:38'),(23,'tag 2 ru','2020-06-14 22:58:38'),(24,'one','2020-06-14 22:58:38'),(25,'zzze','2020-06-14 22:58:38'),(26,'уйц','2020-06-14 22:58:38'),(27,'вфвф','2020-06-14 22:58:38'),(28,'eeee','2020-06-14 22:58:38'),(29,'awdwda','2020-06-14 22:58:38'),(30,'zczcdzc','2020-06-14 22:58:38');
/*!40000 ALTER TABLE `blog_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_tag_ref`
--

DROP TABLE IF EXISTS `blog_tag_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_tag_ref` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `blog_id` (`blog_id`) USING BTREE,
  KEY `tag_id` (`tag_id`) USING BTREE,
  CONSTRAINT `blog_tag_ref_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `blog_tag_ref_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `blog_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tag_ref`
--

LOCK TABLES `blog_tag_ref` WRITE;
/*!40000 ALTER TABLE `blog_tag_ref` DISABLE KEYS */;
INSERT INTO `blog_tag_ref` VALUES (8,5,'ru'),(2,5,'ru'),(2,6,'ru');
/*!40000 ALTER TABLE `blog_tag_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_action`
--

DROP TABLE IF EXISTS `log_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('created','updated','deleted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `model_class` (`model_class`),
  CONSTRAINT `log_action_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action`
--

LOCK TABLES `log_action` WRITE;
/*!40000 ALTER TABLE `log_action` DISABLE KEYS */;
INSERT INTO `log_action` VALUES (1,1,'updated','Product',3,'2021-11-01 04:00:15'),(3,1,'updated','Product',3,'2021-11-01 04:01:26'),(4,1,'updated','Product',3,'2021-11-01 04:01:47'),(5,1,'updated','Product',3,'2021-11-01 04:01:59'),(6,1,'updated','Product',3,'2021-11-01 04:02:18'),(9,1,'updated','Product',3,'2021-11-01 04:03:59'),(10,1,'updated','Product',3,'2021-11-01 04:04:12'),(11,1,'updated','Product',3,'2021-11-01 04:04:26'),(12,1,'updated','Product',3,'2021-11-01 04:04:31'),(13,1,'updated','Product',3,'2021-11-01 04:04:38'),(14,1,'updated','Product',3,'2021-11-01 04:04:44'),(15,1,'updated','Product',3,'2021-11-01 04:04:50'),(16,1,'updated','Product',3,'2021-11-01 04:05:55'),(28,1,'updated','Product',3,'2021-11-01 04:13:40'),(29,1,'updated','Product',3,'2021-11-01 04:16:55'),(31,1,'updated','Product',3,'2021-11-01 04:18:33'),(32,1,'updated','Product',3,'2021-11-01 04:20:54'),(33,1,'updated','Product',3,'2021-11-01 04:21:45'),(34,1,'updated','Product',3,'2021-11-01 04:22:26'),(35,1,'updated','Product',3,'2021-11-01 04:27:20'),(36,1,'updated','Product',3,'2021-11-01 04:56:26'),(37,1,'updated','Product',3,'2021-11-01 04:56:30'),(38,NULL,'created','User',4,'2022-03-02 09:42:22'),(40,4,'updated','User',4,'2022-03-10 17:41:38'),(41,4,'updated','User',4,'2022-03-10 17:41:47'),(47,4,'updated','User',4,'2022-03-10 17:54:08'),(48,4,'updated','User',4,'2022-03-10 17:55:43'),(52,4,'updated','User',4,'2022-03-10 17:58:36'),(62,4,'updated','User',4,'2022-03-10 18:34:41'),(63,4,'updated','User',4,'2022-03-10 18:37:30'),(64,4,'updated','User',4,'2022-03-10 19:06:13'),(65,4,'updated','User',4,'2022-03-15 22:20:01'),(67,4,'updated','User',4,'2022-03-15 22:21:15'),(68,4,'updated','User',4,'2022-03-15 22:22:16'),(69,4,'updated','User',4,'2022-03-16 23:17:21'),(70,1,'updated','Product',2,'2022-03-23 06:45:00'),(71,1,'updated','Product',2,'2022-03-23 07:13:21');
/*!40000 ALTER TABLE `log_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_action_attr`
--

DROP TABLE IF EXISTS `log_action_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_action_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_old` json NOT NULL,
  `value_new` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`) USING BTREE,
  CONSTRAINT `log_action_attr_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `log_action` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action_attr`
--

LOCK TABLES `log_action_attr` WRITE;
/*!40000 ALTER TABLE `log_action_attr` DISABLE KEYS */;
INSERT INTO `log_action_attr` VALUES (1,1,'name','{\"de\": \"das\", \"en\": \"das 23\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"qwe\", \"ru\": \"das\"}'),(2,1,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 4\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(3,3,'name','{\"de\": \"das\", \"en\": \"qwe\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"qwe\", \"ru\": \"asd\"}'),(4,4,'name','{\"de\": \"das\", \"en\": \"qwe\", \"ru\": \"asd\"}','{\"de\": \"zxc\", \"en\": \"qwe\", \"ru\": \"asd\"}'),(5,5,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[\"Opt 1 en\", \"Opt 2\", \"Opt 3\", \"Opt 2\"]'),(6,6,'options_tmp','[\"Opt 1 en\", \"Opt 2\", \"Opt 3\", \"Opt 2\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(7,9,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 5\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 4\", \"Opt 5\"]'),(8,10,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 4\", \"Opt 5\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 5\"]'),(9,11,'slug','\"das\"','\"dasw\"'),(10,12,'slug','\"dasw\"','\"qwe\"'),(11,13,'slug','\"qwe\"','\"das\"'),(12,14,'brand_id','\"3\"','\"1\"'),(13,15,'brand_id','\"1\"','\"3\"'),(14,16,'full_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \" dqwd\", \"ru\": \"\"}'),(15,28,'brand_id','\"Brand 1\"','\"Brand 3\"'),(16,29,'brand_id','\"Brand 3\"','\"Brand 2\"'),(17,31,'brand_id','\"Brand 3\"','\"Brand 1\"'),(18,32,'brand_id','\"Brand 1\"','\"Brand 3\"'),(19,33,'variations_tmp','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": \"18\", \"Discount\": \"50\", \"Quantity\": \"14\"}]','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qqq\", \"Price\": \"18\", \"Discount\": \"50\", \"Quantity\": \"14\"}, {\"SKU\": \"zfzfzfze\", \"Name\": \"aaa\", \"Price\": \"42\", \"Discount\": \"0\", \"Quantity\": \"1\"}]'),(20,34,'related_ids','[\"2\"]','[]'),(21,35,'related_ids','[]','[\"2\"]'),(22,36,'related_ids','[\"2\"]','[]'),(23,37,'related_ids','[]','[\"2\"]'),(24,38,'username','\"\"','\"mobile\"'),(25,38,'email','\"\"','\"mobile@local.host\"'),(26,38,'full_name','\"\"','\"Mobile\"'),(27,38,'phone','\"\"','\"123\"'),(28,40,'full_name','\"Mobile\"','\"Mobile 321\"'),(29,41,'full_name','\"Mobile 321\"','\"Mobile\"'),(30,47,'image','\"\"','\"/data/user/0/com.example.speedrunner/cache/file_picker/Screenshot_1643722330.png\"'),(31,48,'image','\"\"','\"Instance of \'Future\'\"'),(32,52,'image','\"\"','\"qwe\"'),(33,62,'image','\"\"','\"/uploaded/profile/2022-03-10/5ec794ff4a12c9b08ac6083f428550f3.png\"'),(34,63,'image','\"/uploaded/profile/2022-03-10/5ec794ff4a12c9b08ac6083f428550f3.png\"','\"/uploaded/profile/2022-03-10/f40ddc4d3c2c7c62f5eb550da4a6313a.png\"'),(35,64,'image','\"\"','\"/uploaded/profile/2022-03-10/2b13667f7ade0951c9e6effd5adbc4ac.png\"'),(36,65,'image','\"\"','\"/uploaded/profile/2022-03-15/74092bf0b5b15159529018b5278196ec.png\"'),(37,67,'image','\"\"','\"/uploaded/profile/2022-03-15/1dfe2d9b0dc19bcdaa7d07bea2f3e4c9.png\"'),(38,68,'image','\"\"','\"/uploaded/profile/2022-03-15/b18fa622299016ffe0be3f7155f540b7.png\"'),(39,69,'image','\"\"','\"/uploaded/profile/2022-03-16/35f32610ef125dd5f981e78087ef6687.png\"'),(40,70,'full_description','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"<p>fsefesfse</p><p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}','{\"de\": \"fsefesfse\\r\\n<p>fsefsef</p>\", \"en\": \"<p>fsefesfse</p>\\r\\n<p>fsefsef</p>\", \"ru\": \"fsefesfse\\r\\n<p>fsefsef</p>\"}'),(41,70,'price','\"23\"','\"12\"'),(42,70,'discount','\"20\"','\"\"'),(43,70,'sku','\"qwe\"','\"we\"'),(44,70,'variations_tmp','[]','[{\"SKU\": \"we\", \"Name\": \"qwe\", \"Price\": \"12\", \"Discount\": \"0\", \"Quantity\": \"3\"}]'),(45,71,'variations_tmp','[{\"SKU\": \"we\", \"Name\": \"qwe\", \"Price\": \"12\", \"Discount\": \"0\", \"Quantity\": \"3\"}]','[]');
/*!40000 ALTER TABLE `log_action_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree` int(11) NOT NULL DEFAULT '1',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `name` json NOT NULL,
  `url` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree` (`tree`),
  KEY `lft` (`lft`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,1,1,8,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','[]','2020-09-12 15:00:00','2020-09-12 15:00:00'),(5,1,2,3,1,'{\"de\": \"2 de\", \"en\": \"2 en\", \"ru\": \"2 ru\"}','{\"de\": \"\", \"en\": \"dawd\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-11-01 03:50:34'),(25,1,4,7,1,'{\"de\": \"3\", \"en\": \"3\", \"ru\": \"3\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-02-24 07:39:47'),(26,1,5,6,2,'{\"de\": \"3-1\", \"en\": \"3-1\", \"ru\": \"3-1\"}','{\"de\": \"/qwe\", \"en\": \"/qwe\", \"ru\": \"/qwe\"}','2020-09-12 15:00:00','2021-02-24 07:39:08');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
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

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_type` enum('pickup','delivery') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cash','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_quantity` int(11) NOT NULL DEFAULT '0',
  `total_price` bigint(20) NOT NULL DEFAULT '0',
  `delivery_price` bigint(20) NOT NULL DEFAULT '0',
  `status` enum('new','confirmed','paid','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,NULL,'qwe','qwe@qwe.qwe','1312','312e2d12d','pickup','cash',10,135,2,'new','b73ee5098adc9ba00c5e7e1f36c92318','2021-03-30 23:43:00','2021-06-27 14:45:05');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `product_json` json NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `discount` tinyint(3) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `variation_id` (`variation_id`),
  KEY `sort` (`sort`) USING BTREE,
  CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`variation_id`) REFERENCES `product_variation` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (1,1,2,NULL,'{\"id\": 2, \"sku\": \"qwe\", \"name\": \"Prod 1\", \"slug\": \"prod-1\", \"brand\": {\"id\": 2, \"name\": \"Brand 2\", \"slug\": \"brand-2\", \"image\": \"\", \"created_at\": \"14.06.2020 17:24\", \"updated_at\": \"28.03.2021 23:41\"}, \"price\": 23, \"images\": [], \"brand_id\": 2, \"discount\": 20, \"quantity\": 3, \"created_at\": \"14.06.2020 20:19\", \"updated_at\": \"30.03.2021 23:42\", \"mainCategory\": {\"id\": 121, \"lft\": 6, \"rgt\": 7, \"name\": \"Cat 2\", \"slug\": \"cat-2\", \"tree\": 1, \"depth\": 1, \"image\": \"\", \"expanded\": 1, \"created_at\": \"12.09.2020 15:00\", \"updated_at\": \"02.02.2021 16:34\", \"description\": \"fsefs<p>efsefs</p>\"}, \"full_description\": \"<p>fsefesfse</p><p>fsefsef</p>\", \"main_category_id\": 121, \"short_description\": \"fsrrf\"}',NULL,23,20,5,90,0),(2,1,3,9,'{\"id\": 3, \"sku\": \"qqwdqwd\", \"name\": \"das 23\", \"slug\": \"das\", \"brand\": {\"id\": 3, \"name\": \"Brand 3\", \"slug\": \"brand-3\", \"image\": \"/uploads/images/logo.png\", \"created_at\": \"14.06.2020 17:24\", \"updated_at\": \"09.03.2021 15:18\"}, \"price\": 18, \"images\": [\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"], \"brand_id\": 3, \"discount\": 50, \"quantity\": 14, \"variation\": {\"id\": 9, \"sku\": \"qqwdqwd\", \"name\": \"qwe\", \"sort\": 0, \"price\": 18, \"images\": [\"/uploaded/2021-03-30/8c4faf9deacd91add2d3302d94ddeb5f.png\", \"/uploaded/2021-03-30/6f73d12048e75782320485f878905a63.png\", \"/uploaded/2021-03-30/e42438cc44dd5457451f7ea9f7d9d52c.png\"], \"discount\": 50, \"quantity\": 14, \"product_id\": 3}, \"created_at\": \"31.08.2020 15:48\", \"updated_at\": \"30.03.2021 23:44\", \"mainCategory\": {\"id\": 123, \"lft\": 3, \"rgt\": 4, \"name\": \"Cat 1-1\", \"slug\": \"cat-1-1\", \"tree\": 1, \"depth\": 2, \"image\": \"\", \"expanded\": 1, \"created_at\": \"12.09.2020 15:00\", \"updated_at\": \"03.02.2021 19:52\", \"description\": \"\"}, \"full_description\": \"\", \"main_category_id\": 123, \"short_description\": \"\"}','/uploaded/2021-03-30/3011614bdaf8acd9553cdfaa194a5b5c.png',18,50,5,45,1);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'{\"de\": \"eee\", \"en\": \"qqq\", \"ru\": \"www\"}','qqq','/uploads/media/jpg.jpg','{\"de\": \"eee\", \"en\": \"qqq\", \"ru\": \"www\"}','2021-02-13 19:55:00','2022-03-23 07:30:10');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` json NOT NULL,
  `full_description` json NOT NULL,
  `images` json NOT NULL,
  `brand_id` int(11) NOT NULL,
  `main_category_id` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `discount` tinyint(3) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `related_ids` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `sku` (`sku`),
  KEY `brand_id` (`brand_id`) USING BTREE,
  KEY `main_category_id` (`main_category_id`) USING BTREE,
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`main_category_id`) REFERENCES `product_category` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `product_brand` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'{\"de\": \"Prod 1\", \"en\": \"Prod 1\", \"ru\": \"Prod 1\"}','prod-1','{\"de\": \"fsrrf\", \"en\": \"fsrrf\", \"ru\": \"fsrrf\"}','{\"de\": \"fsefesfse\\r\\n<p>fsefsef</p>\", \"en\": \"<p>fsefesfse</p>\\r\\n<p>fsefsef</p>\", \"ru\": \"fsefesfse\\r\\n<p>fsefsef</p>\"}','[]',2,121,12,0,3,'we','[]','2020-06-14 20:19:00','2022-03-23 07:13:21'),(3,'{\"de\": \"zxc\", \"en\": \"qwe\", \"ru\": \"asd\"}','das','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"dqwd\", \"ru\": \"\"}','[\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"]',3,123,18,50,14,'qqwdqwd','[\"2\"]','2020-08-31 15:48:00','2021-11-01 04:56:30');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_brand`
--

DROP TABLE IF EXISTS `product_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_brand`
--

LOCK TABLES `product_brand` WRITE;
/*!40000 ALTER TABLE `product_brand` DISABLE KEYS */;
INSERT INTO `product_brand` VALUES (1,'Brand 1','brand-1','','2020-06-14 17:24:44','2020-06-14 17:24:44'),(2,'Brand 2','brand-2','','2020-06-14 17:24:00','2021-03-28 23:41:45'),(3,'Brand 3','brand-3','/uploads/media/jpg.jpg','2020-06-14 17:24:00','2021-10-31 23:44:42');
/*!40000 ALTER TABLE `product_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree` int(11) NOT NULL DEFAULT '1',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `name` json NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree` (`tree`),
  KEY `slug` (`slug`),
  KEY `lft` (`lft`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,1,1,10,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','[]',NULL,'[]','2020-09-12 15:00:00','2020-09-12 15:00:00'),(120,1,2,5,1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/media/svg_image.svg','{\"de\": \"dawda<p>da</p>\", \"en\": \"<p>dawda</p><p>da</p>\", \"ru\": \"dawda<p>da</p>\"}','2020-09-12 15:00:00','2021-05-09 02:51:12'),(121,1,6,7,1,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"fsefs<p>efsefs</p>\", \"en\": \"fsefs<p>efsefs</p>\", \"ru\": \"fsefs<p>efsefs</p>\"}','2020-09-12 15:00:00','2021-05-09 02:51:25'),(122,1,8,9,1,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-06-10 16:28:33'),(123,1,3,4,2,'{\"de\": \"Cat 1-1\", \"en\": \"Cat 1-1\", \"ru\": \"Cat 1-1\"}','cat-1-1','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-02-03 19:52:28');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category_ref`
--

DROP TABLE IF EXISTS `product_category_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category_ref` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `product_category_ref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_category_ref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category_ref`
--

LOCK TABLES `product_category_ref` WRITE;
/*!40000 ALTER TABLE `product_category_ref` DISABLE KEYS */;
INSERT INTO `product_category_ref` VALUES (3,123),(3,122),(2,120),(2,123),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(3,120),(2,120),(2,120);
/*!40000 ALTER TABLE `product_category_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category_specification_ref`
--

DROP TABLE IF EXISTS `product_category_specification_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category_specification_ref` (
  `category_id` int(11) NOT NULL,
  `specification_id` int(11) NOT NULL,
  KEY `specification_id` (`specification_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `product_category_specification_ref_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_category_specification_ref_ibfk_3` FOREIGN KEY (`specification_id`) REFERENCES `product_specification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category_specification_ref`
--

LOCK TABLES `product_category_specification_ref` WRITE;
/*!40000 ALTER TABLE `product_category_specification_ref` DISABLE KEYS */;
INSERT INTO `product_category_specification_ref` VALUES (123,1),(123,2),(122,1);
/*!40000 ALTER TABLE `product_category_specification_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_option_ref`
--

DROP TABLE IF EXISTS `product_option_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_option_ref` (
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `option_id` (`option_id`) USING BTREE,
  CONSTRAINT `product_option_ref_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_option_ref_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `product_specification_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_option_ref`
--

LOCK TABLES `product_option_ref` WRITE;
/*!40000 ALTER TABLE `product_option_ref` DISABLE KEYS */;
INSERT INTO `product_option_ref` VALUES (3,1),(3,3),(3,5);
/*!40000 ALTER TABLE `product_option_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_specification`
--

DROP TABLE IF EXISTS `product_specification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_specification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `show_in_filter` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_compare` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `show_in_filter` (`show_in_filter`),
  KEY `show_in_compare` (`show_in_compare`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specification`
--

LOCK TABLES `product_specification` WRITE;
/*!40000 ALTER TABLE `product_specification` DISABLE KEYS */;
INSERT INTO `product_specification` VALUES (1,'{\"de\": \"Attr 1\", \"en\": \"Attr 1\", \"ru\": \"Attr 1\"}',1,0,'2020-09-12 15:00:00','2021-08-30 06:08:42'),(2,'{\"de\": \"Attr 2\", \"en\": \"Attr 2\", \"ru\": \"Attr 2\"}',1,1,'2020-09-12 15:00:00','2021-11-01 04:03:03'),(3,'{\"de\": \"Attr 3\", \"en\": \"Attr 3\", \"ru\": \"Attr 3\"}',0,0,'2020-09-12 15:00:00','2021-11-01 04:03:37');
/*!40000 ALTER TABLE `product_specification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_specification_option`
--

DROP TABLE IF EXISTS `product_specification_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_specification_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specification_id` int(11) NOT NULL,
  `name` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `specification_id` (`specification_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `product_specification_option_ibfk_1` FOREIGN KEY (`specification_id`) REFERENCES `product_specification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specification_option`
--

LOCK TABLES `product_specification_option` WRITE;
/*!40000 ALTER TABLE `product_specification_option` DISABLE KEYS */;
INSERT INTO `product_specification_option` VALUES (1,1,'{\"de\": \"Opt 1 de\", \"en\": \"Opt 1 en\", \"ru\": \"Opt 1 ru\"}',0),(2,1,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(3,1,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(4,2,'{\"de\": \"Opt 4\", \"en\": \"Opt 4\", \"ru\": \"Opt 4\"}',0),(5,2,'{\"de\": \"Opt 5\", \"en\": \"Opt 5\", \"ru\": \"Opt 5\"}',1),(6,2,'{\"de\": \"Opt 6\", \"en\": \"Opt 6\", \"ru\": \"Opt 6\"}',2),(7,3,'{\"de\": \"Opt 7\", \"en\": \"Opt 7\", \"ru\": \"Opt 7\"}',0),(8,3,'{\"de\": \"Opt 8\", \"en\": \"Opt 8\", \"ru\": \"Opt 8\"}',1),(9,3,'{\"de\": \"Opt 9\", \"en\": \"Opt 9\", \"ru\": \"Opt 9\"}',2),(10,3,'{\"de\": \"Opt 10\", \"en\": \"Opt 10\", \"ru\": \"Opt 10\"}',3);
/*!40000 ALTER TABLE `product_specification_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variation`
--

DROP TABLE IF EXISTS `product_variation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` json NOT NULL,
  `price` bigint(20) NOT NULL,
  `discount` tinyint(3) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` json NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sort` (`sort`),
  CONSTRAINT `product_variation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variation`
--

LOCK TABLES `product_variation` WRITE;
/*!40000 ALTER TABLE `product_variation` DISABLE KEYS */;
INSERT INTO `product_variation` VALUES (9,3,'{\"de\": \"eee\", \"en\": \"qqq\", \"ru\": \"www\"}',18,50,14,'qqwdqwd','[\"/uploaded/2021-03-31/083783da3d497411fd0f404cf250f840.png\", \"/uploaded/2021-03-31/2d9a0b9339236b6b457980adb2be78a7.png\"]',0),(10,3,'{\"de\": \"ddd\", \"en\": \"aaa\", \"ru\": \"sss\"}',42,0,1,'zfzfzfze','[]',1);
/*!40000 ALTER TABLE `product_variation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo_meta`
--

DROP TABLE IF EXISTS `seo_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL DEFAULT '0',
  `value` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_class` (`model_class`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo_meta`
--

LOCK TABLES `seo_meta` WRITE;
/*!40000 ALTER TABLE `seo_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staticpage`
--

DROP TABLE IF EXISTS `staticpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staticpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_seo_meta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticpage`
--

LOCK TABLES `staticpage` WRITE;
/*!40000 ALTER TABLE `staticpage` DISABLE KEYS */;
INSERT INTO `staticpage` VALUES (17,'home','Home','site/index',1);
/*!40000 ALTER TABLE `staticpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staticpage_block`
--

DROP TABLE IF EXISTS `staticpage_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staticpage_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staticpage_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  `input_type` enum('text_input','text_area','checkbox','file_manager','text_editor','files','groups') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attrs` json NOT NULL,
  `part_index` int(11) NOT NULL,
  `part_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_translation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `staticpage_id` (`staticpage_id`) USING BTREE,
  KEY `name` (`name`),
  CONSTRAINT `staticpage_block_ibfk_1` FOREIGN KEY (`staticpage_id`) REFERENCES `staticpage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticpage_block`
--

LOCK TABLES `staticpage_block` WRITE;
/*!40000 ALTER TABLE `staticpage_block` DISABLE KEYS */;
INSERT INTO `staticpage_block` VALUES (47,17,'slider','Slider','[\"/uploaded/2022-03-02/c3764441d9fb6e3b9f07d65afbff6902.png\", \"/uploaded/2022-03-02/31b291bbca76f027e900bc9efd6f342d.png\", \"/uploaded/2022-03-02/29fcd3c1867165c69a9c48463ddd0a59.png\"]','files','[]',0,'Slider',0),(48,17,'about_title','Title','{\"en\": \"qwe en\"}','text_input','[]',1,'About',1),(49,17,'about_description','Description','{\"en\": \"qqq\\r\\nwww\\r\\neee\"}','text_area','[]',1,'About',1),(50,17,'banner','Banner','\"/uploads/media/WebP.webp\"','file_manager','[]',2,'Banner',0);
/*!40000 ALTER TABLE `staticpage_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_language`
--

DROP TABLE IF EXISTS `system_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`is_active`),
  KEY `is_main` (`is_main`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_language`
--

LOCK TABLES `system_language` WRITE;
/*!40000 ALTER TABLE `system_language` DISABLE KEYS */;
INSERT INTO `system_language` VALUES (1,'English','en','/uploads/media/flags/gb.png',1,1,'2019-12-26 06:14:00','2021-11-11 03:48:05'),(2,'Russian','ru','/uploads/media/flags/ru.png',1,0,'2020-11-29 06:56:00','2021-11-11 03:48:01'),(4,'German','de','/uploads/media/flags/de.png',1,0,'2021-05-09 04:03:00','2022-03-02 10:38:49');
/*!40000 ALTER TABLE `system_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('text_input','text_area','checkbox','file_manager','text_editor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (3,'site_name','Site name','SpeedRunner CMS','text_input',0),(6,'site_logo','Logo','/uploads/logo.svg','file_manager',1),(7,'admin_email','Email','admin@localhost.loc','text_input',4),(10,'delete_model_file','Delete file after removing record','1','checkbox',6),(11,'site_favicon','Favicon','/uploads/logo.svg','file_manager',2),(12,'image_placeholder','Placeholder for images','/uploads/placeholder-image.png','file_manager',3),(13,'head_scripts','Head scripts (analytics, tags, etc.)','','text_area',5);
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translation_message`
--

DROP TABLE IF EXISTS `translation_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translation_message` (
  `id` int(11) NOT NULL,
  `language` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `translation_source` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translation_message`
--

LOCK TABLES `translation_message` WRITE;
/*!40000 ALTER TABLE `translation_message` DISABLE KEYS */;
INSERT INTO `translation_message` VALUES (1,'de',''),(1,'en','ID'),(1,'ru','ID'),(2,'de',''),(2,'en','Username'),(2,'ru','Логин'),(3,'de',''),(3,'en','Role'),(3,'ru','Роль'),(4,'de',''),(4,'en','Email'),(4,'ru','Email'),(5,'de',''),(5,'en','New password'),(5,'ru','Новый пароль'),(6,'de',''),(6,'en','Theme'),(6,'ru','Тема'),(7,'de',''),(7,'en','Font'),(7,'ru','Шрифт'),(8,'de',''),(8,'en','Border radius'),(8,'ru','Радиус границ'),(9,'de',''),(9,'en','Full name'),(9,'ru','Ф.И.О.'),(10,'de',''),(10,'en','Phone'),(10,'ru','Телефон'),(11,'de',''),(11,'en','Address'),(11,'ru','Адрес'),(12,'de',''),(12,'en','Image'),(12,'ru','Изображение'),(13,'de',''),(13,'en','Created'),(13,'ru','Создано'),(14,'de',''),(14,'en','Updated'),(14,'ru','Изменено'),(15,'de',''),(15,'en','Users'),(15,'ru','Пользователи'),(16,'de',''),(16,'en','Create'),(16,'ru','Создание'),(17,'en','Admin'),(17,'ru','Администратор'),(18,'en','Registered'),(18,'ru','Зарегистрированный'),(19,'de',''),(19,'en','Delete all'),(19,'ru','Удалить все'),(20,'de',''),(20,'en','Are you sure?'),(20,'ru','Вы уверены?'),(21,'de',''),(21,'en','RBAC'),(21,'ru','Менеджер ролей'),(22,'de',''),(22,'en','Static pages'),(22,'ru','Статичные страницы'),(23,'de',''),(23,'en','Content'),(23,'ru','Контент'),(24,'de',''),(24,'en','Menu'),(24,'ru','Меню'),(25,'de',''),(25,'en','Pages'),(25,'ru','Страницы'),(26,'de',''),(26,'en','Banners'),(26,'ru','Баннеры'),(27,'de',''),(27,'en','Blocks'),(27,'ru','Блоки'),(28,'de',''),(28,'en','Types'),(28,'ru','Типы'),(29,'de',''),(29,'en','Blogs'),(29,'ru','Блоги'),(30,'de',''),(30,'en','Categories'),(30,'ru','Категории'),(31,'de',''),(31,'en','Tags'),(31,'ru','Теги'),(32,'de',''),(32,'en','Comments'),(32,'ru','Комментарии'),(33,'de',''),(33,'en','Rates'),(33,'ru','Оценки'),(34,'de',''),(34,'en','Products'),(34,'ru','Продукты'),(35,'de',''),(35,'en','Brands'),(35,'ru','Бренды'),(36,'de',''),(36,'en','Specifications'),(36,'ru','Характеристики'),(37,'de',''),(37,'en','Orders'),(37,'ru','Заказы'),(38,'de',''),(38,'en','System'),(38,'ru','Система'),(39,'de',''),(39,'en','Settings'),(39,'ru','Настройки'),(40,'de',''),(40,'en','Languages'),(40,'ru','Языки'),(41,'de',''),(41,'en','Translations'),(41,'ru','Переводы'),(42,'de',''),(42,'en','Log actions'),(42,'ru','Лог действий'),(43,'de',''),(43,'en','Cache'),(43,'ru','Кэш'),(44,'de',''),(44,'en','Remove thumbs'),(44,'ru','Удалить миниатюры'),(45,'de',''),(45,'en','Clear'),(45,'ru','Очистить'),(46,'en','Speedrunner'),(46,'ru','Speedrunner'),(47,'de',''),(47,'en','Information'),(47,'ru','Информация'),(48,'de',''),(48,'en','Functions'),(48,'ru','Функции'),(49,'en','Change password'),(49,'ru','Сменить пароль'),(50,'de',''),(50,'en','Logout'),(50,'ru','Выйти'),(51,'de',''),(51,'en','No notifications'),(51,'ru','Нет уведомлений'),(52,'de',''),(52,'en','Bookmarks'),(52,'ru','Вкладки'),(53,'de',''),(53,'en','Add'),(53,'ru','Добавление'),(54,'de',''),(54,'en','Home'),(54,'ru','Главная'),(55,'en','RBAC'),(55,'ru','Менеджер ролей'),(56,'en','Routes'),(56,'ru','Маршруты'),(57,'en','Rules'),(57,'ru','Правила'),(58,'de',''),(58,'en','Roles'),(58,'ru','Роли'),(59,'en','Assignments'),(59,'ru','Привязки'),(60,'en','Permissions'),(60,'ru','Права'),(61,'de',''),(61,'en','Static page: {label}'),(61,'ru','Статичная страница: {label}'),(62,'de',''),(62,'en','Save'),(62,'ru','Сохранить'),(63,'de',''),(63,'en','SEO meta'),(63,'ru','SEO мета'),(64,'de',''),(64,'en','Name'),(64,'ru','Название'),(65,'en','Label'),(65,'ru','Лейбл'),(66,'en','Value'),(66,'ru','Значение'),(67,'de',''),(67,'en','Type'),(67,'ru','Тип'),(68,'de',''),(68,'en','Browse'),(68,'ru','Просмотр'),(69,'en','Error'),(69,'ru','Ошибка'),(70,'de',''),(70,'en','Tree'),(70,'ru','Дерево'),(71,'de',''),(71,'en','Search'),(71,'ru','Поиск'),(72,'en','Left'),(72,'ru','Слева'),(73,'en','Right'),(73,'ru','Справа'),(74,'en','Depth'),(74,'ru','Глубина'),(75,'en','Expanded'),(75,'ru','Развёрнуто'),(76,'de',''),(76,'en','Url'),(76,'ru','Ссылка'),(77,'de',''),(77,'en','Parent'),(77,'ru','Родитель'),(78,'de',''),(78,'en','Slug'),(78,'ru','Ссылка'),(79,'de',''),(79,'en','Description'),(79,'ru','Описание'),(80,'en','Location'),(80,'ru','Локация'),(81,'en','Groups'),(81,'ru','Группы'),(82,'en','Slider home'),(82,'ru','Слайдер на главной странице'),(83,'en','Slider about'),(83,'ru','Слайдер на странице \"о компании\"'),(84,'en','Save & reload'),(84,'ru','Сохранить и перезагрузить'),(85,'en','Profile'),(85,'ru','Профиль'),(86,'en','Design'),(86,'ru','Дизайн'),(87,'en','Field must contain only alphabet and numerical chars'),(87,'ru','Поле должно содержать только буквы и цифры'),(88,'en','Full menu'),(88,'ru','Полное меню'),(89,'en','Left menu'),(89,'ru','Меню слева'),(94,'en','Routes'),(94,'ru','Маршруты'),(95,'en','Refresh'),(95,'ru','Обновить'),(96,'en','Search for available'),(96,'ru','Поиск доступных'),(97,'en','Include'),(97,'ru','Включить'),(98,'en','Assign'),(98,'ru','Привязка'),(99,'en','Exclude'),(99,'ru','Исключить'),(100,'en','Remove'),(100,'ru','Удаление'),(101,'en','Search for assigned'),(101,'ru','Поиск привязок'),(102,'en','Rules'),(102,'ru','Правила'),(103,'en','Create'),(103,'ru','Создание'),(104,'en','Name'),(104,'ru','Название'),(105,'en','Roles'),(105,'ru','Роли'),(106,'en','Rule name'),(106,'ru','Название правила'),(107,'en','Select rule'),(107,'ru','Выберите правило'),(108,'en','Description'),(108,'ru','Описание'),(109,'en','Assignments'),(109,'ru','Привязки'),(110,'en','Permissions'),(110,'ru','Права'),(111,'en','General'),(111,'ru','Основной'),(112,'en','Class name'),(112,'ru','Название класса'),(113,'en','Update: {name}'),(113,'ru','Редактирование: {name}'),(114,'en','View: {name}'),(114,'ru','Отображение: {name}'),(115,'en','Assignment'),(115,'ru','Привязка'),(116,'en','Type'),(116,'ru','Тип'),(117,'en','Data'),(117,'ru','Данные'),(118,'en','Assignment: {username}'),(118,'ru','Привязка: {username}'),(119,'de',''),(119,'en','Record has been saved'),(119,'ru','Запись сохранена'),(120,'de',''),(120,'en','Delete'),(120,'ru','Удалить'),(121,'de',''),(121,'en','Delete with children'),(121,'ru','Удалить с дочерними'),(122,'en','Record has been deleted'),(122,'ru','Запись удалена'),(123,'en','Banner'),(123,'ru','Баннер'),(124,'en','Text 1'),(124,'ru','Текст 1'),(125,'en','Text 2'),(125,'ru','Текст 2'),(126,'en','Text 3'),(126,'ru','Текст 3'),(127,'de',''),(127,'en','Link'),(127,'ru','Ссылка'),(128,'de',''),(128,'en','Has translation'),(128,'ru','Имеется перевод'),(129,'en','Block types'),(129,'ru','Блочные типы'),(130,'en','Block pages'),(130,'ru','Блочные страницы'),(131,'en','Assign'),(131,'ru','Привязка'),(132,'de',''),(132,'en','Category'),(132,'ru','Категория'),(135,'de',''),(135,'en','Images'),(135,'ru','Изображения'),(136,'en','Published'),(136,'ru','Опубликовано'),(137,'en','Blog categories'),(137,'ru','Категории блогов'),(138,'en','Blog tags'),(138,'ru','Теги блогов'),(139,'en','Blog'),(139,'ru','Блог'),(140,'de',''),(140,'en','User'),(140,'ru','Пользователь'),(141,'en','Text'),(141,'ru','Текст'),(142,'en','Status'),(142,'ru','Статус'),(143,'en','Blog comments'),(143,'ru','Комментарии к блогам'),(144,'en','New'),(144,'ru','Новый'),(145,'en','Mark'),(145,'ru','Оценка'),(146,'en','Blog rates'),(146,'ru','Оценки блогов'),(147,'en','Update: {label}'),(147,'ru','Редактирование: {label}'),(148,'en','Used'),(148,'ru','Использовано'),(149,'en','Assign: {name}'),(149,'ru','Привязка: {name}'),(150,'en','Page'),(150,'ru','Страница'),(151,'en','Comments & rates: {name}'),(151,'ru','Комментарии и оценки: {name}'),(152,'en','Comment: {id}'),(152,'ru','Комментарий: {id}'),(153,'de',''),(153,'en','Brand'),(153,'ru','Бренд'),(154,'de',''),(154,'en','Main category'),(154,'ru','Главная категория'),(155,'de',''),(155,'en','Price'),(155,'ru','Цена'),(156,'de',''),(156,'en','Discount'),(156,'ru','Скидка'),(157,'de',''),(157,'en','Quantity'),(157,'ru','Количество'),(158,'de',''),(158,'en','SKU'),(158,'ru','Артикул'),(159,'de',''),(159,'en','Options'),(159,'ru','Опции'),(160,'de',''),(160,'en','Related'),(160,'ru','Сопутствующие'),(161,'de',''),(161,'en','Variations'),(161,'ru','Вариации'),(162,'en','Total price'),(162,'ru','Итоговая стоимость'),(163,'en','Product categories'),(163,'ru','Категории продуктов'),(164,'en','Product brands'),(164,'ru','Бренды продуктов'),(165,'en','Product'),(165,'ru','Продукт'),(166,'en','Products comments'),(166,'ru','Комментарии к продуктам'),(167,'en','Product rates'),(167,'ru','Оценки продуктов'),(168,'en','E-mail'),(168,'ru','E-mail'),(169,'en','Delivery type'),(169,'ru','Тип доставки'),(170,'en','Payment type'),(170,'ru','Тип оплаты'),(171,'en','Total quantity'),(171,'ru','Общее количество'),(172,'en','Delivery price'),(172,'ru','Стоимость доставки'),(173,'en','Key'),(173,'ru','Ключ'),(174,'en','Pickup'),(174,'ru','Самовывоз'),(175,'en','Delivery'),(175,'ru','Доставка'),(176,'en','Cash'),(176,'ru','Наличные'),(177,'en','Bank card'),(177,'ru','Банковская карта'),(178,'en','Confirmed'),(178,'ru','Подтверждено'),(179,'en','Payed'),(179,'ru','Оплачено'),(180,'en','Completed'),(180,'ru','Завершено'),(181,'en','Canceled'),(181,'ru','Отменено'),(182,'en','Stock'),(182,'ru','Склад'),(183,'en','Categories & Specifications'),(183,'ru','Категории и характеристики'),(184,'en','Specification'),(184,'ru','Характеристика'),(185,'en','Option'),(185,'ru','Опция'),(186,'en','Use in filter'),(186,'ru','Использовать в фильтре'),(187,'en','Use in compare'),(187,'ru','Использовать при сравнении'),(188,'en','Use in detail page'),(188,'ru','Использовать в детальной странице'),(189,'en','Product specifications'),(189,'ru','Характеристики продуктов'),(190,'en','Checkout price'),(190,'ru','Сумма к оплате'),(191,'en','Order №{order_id}'),(191,'ru','Заказ №{order_id}'),(192,'en','View: {id}'),(192,'ru','Отображение: {id}'),(193,'en','Total'),(193,'ru','Итого'),(194,'en','Person'),(194,'ru','Человек'),(195,'en','Order'),(195,'ru','Заказ'),(196,'en','Products price: {price} сум'),(196,'ru','Цена за продукцию: {price} сум'),(197,'en','Delivery price: {price} сум'),(197,'ru','Стоимость доставки: {price} сум'),(198,'en','Total price: {price} сум'),(198,'ru','Итоговая цена: {price} сум'),(199,'en','System settings'),(199,'ru','Системные настройки'),(200,'de',''),(200,'en','Code'),(200,'ru','Код'),(201,'de',''),(201,'en','Active'),(201,'ru','Активный'),(202,'de',''),(202,'en','Main'),(202,'ru','Главный'),(203,'de',''),(203,'en','System languages'),(203,'ru','Системные языки'),(204,'de',''),(204,'en','Action'),(204,'ru','Действие'),(205,'de',''),(205,'en','Old value'),(205,'ru','Старое значение'),(206,'de',''),(206,'en','New value'),(206,'ru','Новое значение'),(207,'de',''),(207,'en','Deleted'),(207,'ru','Удалено'),(208,'de',''),(208,'en','View'),(208,'ru','Отображение'),(209,'de',''),(209,'en','Process has been completed'),(209,'ru','Процесс завершён'),(210,'de',''),(210,'en','Message'),(210,'ru','Сообщение'),(211,'en','Translation sources'),(211,'ru','Исходники переводов'),(212,'en','Log actions #{id}'),(212,'ru','Лог действий #{id}'),(213,'en','Update: {message}'),(213,'ru','Редактирование: {message}'),(229,'en','Sign in'),(229,'ru','Авторизация'),(230,'en','Password'),(230,'ru','Пароль'),(231,'en','Remember me'),(231,'ru','Запомнить меня'),(232,'en','{attribute} is incorrect'),(232,'ru','{attribute} заполнен неверно'),(233,'en','Model class'),(233,'ru','Класс модели'),(234,'en','Model ID'),(234,'ru','ID модели'),(235,'en','Language'),(235,'ru','Язык'),(236,'en','Update: {username}'),(236,'ru','Редактирование: {username}'),(237,'en','This username has already been taken'),(237,'ru','Данный логин уже занят'),(238,'en','This email has already been taken'),(238,'ru','Данный email уже занят'),(239,'en','There is no user with this email address'),(239,'ru','Пользователь с данным email адресом не найден'),(240,'en','Login'),(240,'ru','Авторизация'),(241,'en','Password changing'),(241,'ru','Изменение пароля'),(242,'de',''),(242,'en','Update'),(242,'ru','Редактирование'),(243,'en','System translations'),(243,'ru','Системные переводы'),(244,'de',''),(244,'en','Short description'),(244,'ru','Краткое описание'),(245,'de',''),(245,'en','Full description'),(245,'ru','Полное описание'),(246,'en','Sku'),(246,'ru','Артикул'),(247,'en','Submit'),(247,'ru','Отправить'),(248,'en','An error occurred'),(248,'ru','Произошла ошибка'),(249,'en','Update: {id}'),(249,'ru','Редактирование: {id}'),(268,'de',''),(268,'en','Update: {value}'),(268,'ru','Редактирование: {value}'),(269,'en','An error occurred'),(269,'ru','Произошла ошибка'),(270,'en','{length} symbols'),(270,'ru','{length} символов'),(311,'de',''),(311,'en','Save &amp; update'),(311,'ru','Сохранить и редактировать'),(395,'de',''),(395,'en',''),(395,'ru',''),(396,'de',''),(396,'en',''),(396,'ru',''),(397,'de',''),(397,'en',''),(397,'ru',''),(398,'de',''),(398,'en',''),(398,'ru',''),(399,'de',''),(399,'en',''),(399,'ru',''),(400,'de',''),(400,'en',''),(400,'ru',''),(401,'de',''),(401,'en',''),(401,'ru',''),(402,'de',''),(402,'en',''),(402,'ru',''),(403,'en',''),(403,'ru',''),(404,'en',''),(404,'ru',''),(405,'en',''),(405,'ru',''),(406,'en',''),(406,'ru',''),(407,'en',''),(407,'ru',''),(408,'en',''),(408,'ru',''),(409,'en',''),(409,'ru',''),(410,'en',''),(410,'ru',''),(411,'de',''),(411,'en',''),(411,'ru',''),(412,'de',''),(412,'en',''),(412,'ru',''),(413,'en',''),(413,'ru',''),(414,'en',''),(414,'ru',''),(415,'en',''),(415,'ru',''),(416,'en',''),(416,'ru',''),(417,'en',''),(417,'ru',''),(418,'en',''),(418,'ru',''),(419,'en',''),(419,'ru',''),(420,'en',''),(420,'ru',''),(422,'de',''),(422,'en',''),(422,'ru',''),(423,'de',''),(423,'en',''),(423,'ru',''),(424,'de',''),(424,'en',''),(424,'ru',''),(425,'de',''),(425,'en',''),(425,'ru',''),(426,'de',''),(426,'en',''),(426,'ru',''),(427,'de',''),(427,'en',''),(427,'ru',''),(428,'de',''),(428,'en',''),(428,'ru',''),(429,'de',''),(429,'en',''),(429,'ru',''),(430,'de',''),(430,'en',''),(430,'ru',''),(431,'de',''),(431,'en',''),(431,'ru',''),(432,'de',''),(432,'en',''),(432,'ru',''),(433,'de',''),(433,'en',''),(433,'ru',''),(434,'de',''),(434,'en',''),(434,'ru',''),(435,'de',''),(435,'en',''),(435,'ru',''),(436,'de',''),(436,'en',''),(436,'ru',''),(438,'de',''),(438,'en',''),(438,'ru',''),(440,'de',''),(440,'en',''),(440,'ru',''),(441,'de',''),(441,'en',''),(441,'ru',''),(442,'de',''),(442,'en',''),(442,'ru',''),(444,'de',''),(444,'en',''),(444,'ru',''),(445,'de',''),(445,'en',''),(445,'ru',''),(446,'de',''),(446,'en',''),(446,'ru',''),(447,'de',''),(447,'en',''),(447,'ru',''),(448,'de',''),(448,'en',''),(448,'ru',''),(449,'de',''),(449,'en',''),(449,'ru',''),(450,'de',''),(450,'en',''),(450,'ru',''),(451,'de',''),(451,'en',''),(451,'ru',''),(452,'de',''),(452,'en',''),(452,'ru',''),(453,'de',''),(453,'en',''),(453,'ru',''),(454,'de',''),(454,'en',''),(454,'ru',''),(462,'de',''),(462,'en',''),(462,'ru',''),(463,'de',''),(463,'en',''),(463,'ru',''),(464,'de',''),(464,'en',''),(464,'ru',''),(465,'de',''),(465,'en',''),(465,'ru',''),(466,'de',''),(466,'en',''),(466,'ru',''),(467,'de',''),(467,'en',''),(467,'ru',''),(468,'de',''),(468,'en',''),(468,'ru',''),(469,'de',''),(469,'en',''),(469,'ru','');
/*!40000 ALTER TABLE `translation_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translation_source`
--

DROP TABLE IF EXISTS `translation_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translation_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=470 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translation_source`
--

LOCK TABLES `translation_source` WRITE;
/*!40000 ALTER TABLE `translation_source` DISABLE KEYS */;
INSERT INTO `translation_source` VALUES (1,'app','Id'),(2,'app','Username'),(3,'app','Role'),(4,'app','Email'),(5,'app','New password'),(6,'app','Theme'),(7,'app','Font'),(8,'app','Border radius'),(9,'app','Full name'),(10,'app','Phone'),(11,'app','Address'),(12,'app','Image'),(13,'app','Created'),(14,'app','Updated'),(15,'app','Users'),(16,'app','Create'),(17,'app','Admin'),(18,'app','Registered'),(19,'app','Delete all'),(20,'app','Are you sure?'),(21,'app','RBAC'),(22,'app','Static pages'),(23,'app','Content'),(24,'app','Menu'),(25,'app','Pages'),(26,'app','Banners'),(27,'app','Blocks'),(28,'app','Types'),(29,'app','Blogs'),(30,'app','Categories'),(31,'app','Tags'),(32,'app','Comments'),(33,'app','Rates'),(34,'app','Products'),(35,'app','Brands'),(36,'app','Specifications'),(37,'app','Orders'),(38,'app','System'),(39,'app','Settings'),(40,'app','Languages'),(41,'app','Translations'),(42,'app','Log actions'),(43,'app','Cache'),(44,'app','Remove thumbs'),(45,'app','Clear'),(46,'app','Speedrunner'),(47,'app','Information'),(48,'app','Functions'),(49,'app','Change password'),(50,'app','Logout'),(51,'app','No notifications'),(52,'app','Bookmarks'),(53,'app','Add'),(54,'app','Home'),(55,'yii2mod.rbac','RBAC'),(56,'app','Routes'),(57,'app','Rules'),(58,'app','Roles'),(59,'app','Assignments'),(60,'app','Permissions'),(61,'app','Static page: {label}'),(62,'app','Save'),(63,'app','SEO meta'),(64,'app','Name'),(65,'app','Label'),(66,'app','Value'),(67,'app','Type'),(68,'app','Browse'),(69,'app','Error'),(70,'app','Tree'),(71,'app','Search'),(72,'app','Lft'),(73,'app','Rgt'),(74,'app','Depth'),(75,'app','Expanded'),(76,'app','Url'),(77,'app','Parent'),(78,'app','Slug'),(79,'app','Description'),(80,'app','Location'),(81,'app','Groups'),(82,'app','Slider home'),(83,'app','Slider about'),(84,'app','Save & reload'),(85,'app','Profile'),(86,'app','Design'),(87,'app','Field must contain only alphabet and numerical chars'),(88,'app','Full menu'),(89,'app','Left menu'),(94,'yii2mod.rbac','Routes'),(95,'yii2mod.rbac','Refresh'),(96,'yii2mod.rbac','Search for available'),(97,'app','Include'),(98,'yii2mod.rbac','Assign'),(99,'app','Exclude'),(100,'yii2mod.rbac','Remove'),(101,'yii2mod.rbac','Search for assigned'),(102,'yii2mod.rbac','Rules'),(103,'yii2mod.rbac','Create'),(104,'yii2mod.rbac','Name'),(105,'yii2mod.rbac','Roles'),(106,'yii2mod.rbac','Rule Name'),(107,'yii2mod.rbac','Select Rule'),(108,'yii2mod.rbac','Description'),(109,'yii2mod.rbac','Assignments'),(110,'yii2mod.rbac','Permissions'),(111,'app','General'),(112,'yii2mod.rbac','Class Name'),(113,'app','Update: {name}'),(114,'app','View: {name}'),(115,'app','Assignment'),(116,'yii2mod.rbac','Type'),(117,'yii2mod.rbac','Data'),(118,'yii2mod.rbac','Assignment: {username}'),(119,'app','Record has been saved'),(120,'app','Delete'),(121,'app','Delete with children'),(122,'app','Record has been deleted'),(123,'app','Banner'),(124,'app','Text 1'),(125,'app','Text 2'),(126,'app','Text 3'),(127,'app','Link'),(128,'app','Has translation'),(129,'app','Block types'),(130,'app','Block pages'),(131,'app','Assign'),(132,'app','Category'),(135,'app','Images'),(136,'app','Published'),(137,'app','Blog categories'),(138,'app','Blog tags'),(139,'app','Blog'),(140,'app','User'),(141,'app','Text'),(142,'app','Status'),(143,'app','Blog comments'),(144,'app','New'),(145,'app','Mark'),(146,'app','Blog rates'),(147,'app','Update: {label}'),(148,'app','Used'),(149,'app','Assign: {name}'),(150,'app','Page'),(151,'app','Comments & rates: {name}'),(152,'app','Comment: {id}'),(153,'app','Brand'),(154,'app','Main category'),(155,'app','Price'),(156,'app','Discount'),(157,'app','Quantity'),(158,'app','SKU'),(159,'app','Options'),(160,'app','Related'),(161,'app','Variations'),(162,'app','Total price'),(163,'app','Product categories'),(164,'app','Product brands'),(165,'app','Product'),(166,'app','Products comments'),(167,'app','Product rates'),(168,'app','E-mail'),(169,'app','Delivery type'),(170,'app','Payment type'),(171,'app','Total quantity'),(172,'app','Delivery price'),(173,'app','Key'),(174,'app','Pickup'),(175,'app','Delivery'),(176,'app','Cash'),(177,'app','Bank card'),(178,'app','Confirmed'),(179,'app','Payed'),(180,'app','Completed'),(181,'app','Canceled'),(182,'app','Stock'),(183,'app','Categories & Specifications'),(184,'app','Specification'),(185,'app','Option'),(186,'app','Use in filter'),(187,'app','Use in compare'),(188,'app','Use in detail page'),(189,'app','Product specifications'),(190,'app','Checkout price'),(191,'app','Order №{order_id}'),(192,'app','View: {id}'),(193,'app','Total'),(194,'app','Person'),(195,'app','Order'),(196,'app','Products price: {price} сум'),(197,'app','Delivery price: {price} сум'),(198,'app','Total price: {price} сум'),(199,'app','System settings'),(200,'app','Code'),(201,'app','Active'),(202,'app','Main'),(203,'app','System languages'),(204,'app','Action'),(205,'app','Old value'),(206,'app','New value'),(207,'app','Deleted'),(208,'app','View'),(209,'app','Process has been completed'),(210,'app','Message'),(211,'app','Translation sources'),(212,'app','Log actions #{id}'),(213,'app','Update: {message}'),(229,'app','Sign in'),(230,'app','Password'),(231,'app','Remember me'),(232,'app','{attribute} is incorrect'),(233,'app','Model class'),(234,'app','Model id'),(235,'app','Language'),(236,'app','Update: {username}'),(237,'app','This username has already been taken'),(238,'app','This email has already been taken'),(239,'app','There is no user with this email address'),(240,'app','Login'),(241,'app','Password changing'),(242,'app','Update'),(243,'app','System translations'),(244,'app','Short description'),(245,'app','Full description'),(246,'app','Sku'),(247,'app','Submit'),(248,'app','An error occured'),(249,'app','Update: {id}'),(268,'app','Update: {value}'),(269,'app','An error occurred'),(270,'app','{length} symbols'),(311,'app','Save & update'),(395,'app','Import'),(396,'app','Export'),(397,'app','SEO'),(398,'app','Meta'),(399,'app','Files'),(400,'app','Created at'),(401,'app','Updated at'),(402,'app','Published at'),(403,'app','Values will be taken automatically from the first variation (if any)'),(404,'app','Variation: {value}'),(405,'app','Chackout price'),(406,'app','Online'),(407,'app_notification','You have new order'),(408,'app','Clear all'),(409,'app','Files update'),(410,'app','Files have been updated'),(411,'app','Show {quantity} records'),(412,'app','Actions'),(413,'app',NULL),(414,'app','Save & create'),(415,'app','One of these attributes is required: {value}'),(416,'app','Contact'),(417,'app_email','Feedback'),(418,'app','contact_success_alert'),(419,'app','Profile update'),(420,'app','Profile has been updated'),(422,'app','Variation'),(423,'app','File manager'),(424,'app','Parameter not found'),(425,'app','Input type'),(426,'app','View in filter'),(427,'app','View in compare'),(428,'app','Incorrect {attribute}'),(429,'app','Wrong password reset token'),(430,'app','Signup'),(431,'app','Confirm password'),(432,'app','Reset password request'),(433,'app','Send'),(434,'app','You cannot change {attribute}'),(435,'app','Order №{id}'),(436,'app','{price} $'),(438,'app','Status has been changed'),(440,'app','User roles'),(441,'app','Translations import'),(442,'app','File'),(444,'app','Namez'),(445,'app','Catalog'),(446,'app','Set main'),(447,'app','Main language has been changed'),(448,'app',NULL),(449,'app','Test {test}'),(450,'app','Test \"{test}\"'),(451,'app_email','Password reset'),(452,'app','reset_password_request_success_alert'),(453,'app','Translations export'),(454,'app_mail','Feedback'),(462,'app','Paid'),(463,'app',NULL),(464,'app','Show in filter'),(465,'app','Show in compare'),(466,'app','Field must be unique and contain only alphabet and numerical chars'),(467,'app','Field must be unique and contain only alphabet chars and digits'),(468,'app','Field must contain only alphabet chars and digits'),(469,'app','Assign: {value}');
/*!40000 ALTER TABLE `translation_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin',1,'admin@local.host','/uploaded/profile/2021-03-28/50fdbc8a477209ef2065a019122e7feb.png','93e2b1f1c35849b456cde2dc7d4456dc','$2y$13$hW20udyA8aCCnQk6kD.xZOI86pkpiBH9xGtUcdrX.AY6dFx4T99d.','19c68e0cce41320fd414ed41fa5288f6','2020-02-21 04:58:00','2021-09-06 10:47:22'),(3,'test',2,'test@local.host',NULL,'0baba9612434da1191a886ced000df09','$2y$13$u/VOjBlVrOJnlJ1QIPyyZu5ZVIIBDitZHGzpW.WDnfU0Q0LzKQjQy',NULL,'2021-06-27 10:36:00','2021-10-03 23:28:00'),(4,'mobile',NULL,'mobile@local.host','','a0f1865d4301cc28c28b5ea2d1a562c1','$2y$13$e5VkLrUidKAZ57pRjMFG/O/1fzPQewiiTu1d6p5bsznR/urbjn612',NULL,'2022-03-02 09:42:00','2022-03-16 23:17:20');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notification`
--

DROP TABLE IF EXISTS `user_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_id` int(11) NOT NULL,
  `params` json NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notification`
--

LOCK TABLES `user_notification` WRITE;
/*!40000 ALTER TABLE `user_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (4,1,'Administrator','123 22','addr awd'),(6,3,'Test','',''),(7,4,'Mobile','123','');
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `routes` json NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'{\"de\": \"Admin\", \"en\": \"Admin\", \"ru\": \"Admin\"}','[]','2021-06-27 06:27:00','2021-06-27 12:19:04'),(2,'{\"de\": \"test\", \"en\": \"Test\", \"ru\": \"test\"}','[\"banner/banner/index\", \"banner/banner/update\", \"block/page/index\", \"block/page/delete\", \"block/page/create\", \"block/page/update\", \"block/page/file-sort\", \"block/page/file-delete\", \"blog/blog/index\", \"blog/blog/update\", \"blog/blog/delete\", \"blog/blog/file-sort\", \"blog/blog/file-delete\", \"blog/blog/view\", \"blog/category/index\", \"blog/category/create\", \"blog/category/update\", \"blog/category/delete\", \"blog/tag/index\", \"blog/tag/delete\", \"order/order/index\", \"order/order/create\", \"order/order/update\", \"order/order/delete\", \"system/language/index\", \"system/language/create\", \"system/language/update\", \"system/language/delete\", \"system/language/set-main\", \"translation/source/index\", \"translation/source/update\", \"translation/source/import\", \"user/user/profile-update\"]','2021-06-27 10:06:00','2022-03-23 08:13:22');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-24 11:00:08
