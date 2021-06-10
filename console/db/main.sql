-- MySQL dump 10.13  Distrib 5.7.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sr-cms-1
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
INSERT INTO `banner` VALUES (2,'r','slider_home','2019-09-22 10:30:00','2021-02-16 22:58:06'),(3,'qwe','slider_about','2019-09-22 10:30:00','2021-06-10 18:55:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner_group`
--

LOCK TABLES `banner_group` WRITE;
/*!40000 ALTER TABLE `banner_group` DISABLE KEYS */;
INSERT INTO `banner_group` VALUES (7,3,'{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"qwdq\", \"en\": \"qwdq\", \"ru\": \"qwdq\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"qwdq\", \"en\": \"qwdq\", \"ru\": \"qwdq\"}','/uploads/media/flags/ag.png',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block`
--

LOCK TABLES `block` WRITE;
/*!40000 ALTER TABLE `block` DISABLE KEYS */;
INSERT INTO `block` VALUES (13,3,8,'\"title all\"',0),(14,3,9,'{\"de\": \"title de\", \"en\": \"title en\", \"ru\": \"title ru\"}',1),(15,3,12,'[]',2),(16,3,13,'{\"de\": [\"/uploaded/1592682565__DA3TQ3PeeFoXaic.png\"], \"en\": [], \"ru\": []}',3),(17,3,14,'[{\"image\": \"/uploads/media/flags/ag.png\", \"is_available\": \"0\"}, {\"image\": \"/uploads/media/flags/bb.png\", \"is_available\": \"1\"}]',4),(18,3,15,'{\"de\": [], \"en\": [{\"title\": \"asd\", \"description\": \"<p>asd</p>\\r\\n<p>asd wdwd</p>\"}, {\"title\": \"qwe\", \"description\": \"<p>qwe</p>\\r\\n<p>qwe</p>\"}], \"ru\": []}',5);
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
INSERT INTO `block_page` VALUES (3,'{\"de\": \"Page 1\", \"en\": \"Page 1\", \"ru\": \"Page 1\"}','page-1','2020-06-15 22:20:00','2021-02-11 10:35:08');
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
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (2,'{\"en\": \"fefs\", \"ru\": \"dde\"}','dde',1,'/uploads/media/flags/ch.png','{\"en\": \"h6h5h5\\r\\n\\r\\nh5 6h5\", \"ru\": \"\"}','{\"en\": \"<p>h56h56 </p><p>h56 h5</p><p>6 </p>\", \"ru\": \"\"}','[]','2018-10-19 14:45:00','2018-10-15 15:13:00','2021-03-28 19:24:26'),(8,'{\"de\": \"blog de\", \"en\": \"Blog en\", \"ru\": \"blog ru\"}','blog-en',NULL,'/uploads/media/flags/be.png','{\"en\": \"fwef\", \"ru\": \"\"}','{\"en\": \"<p>fw</p>\\r\\n<p><img src=\\\"/uploaded/editor/6022cac2b5197.png\\\" alt=\\\"6022cac2b5197.png\\\" style=\\\"width:308px;height:132px;\\\" width=\\\"308\\\" height=\\\"132\\\" /></p>\\r\\n<p class=\\\"qwez\\\" style=\\\"color:#ff0000;\\\">ef</p>\\r\\n<p>wefw</p>\", \"ru\": \"\"}','[]','2019-09-22 20:17:00','1970-01-01 03:00:00','2021-06-10 15:49:28');
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
INSERT INTO `blog_category` VALUES (1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/Blog/1537547338_I9HiIO.png','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-06-14 14:40:14'),(2,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2018-10-15 11:17:00','2020-06-14 14:40:24'),(3,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','/uploads/media/image-1.png','{\"de\": \"\", \"en\": \"<p>dawdawdawd</p>\\r\\n<p>awdwa</p>\\r\\n<p>d wadawd</p>\\r\\ndaw d awd awd\", \"ru\": \"\"}','2018-10-15 11:17:00','2021-05-10 04:07:16');
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
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tag`
--

LOCK TABLES `blog_tag` WRITE;
/*!40000 ALTER TABLE `blog_tag` DISABLE KEYS */;
INSERT INTO `blog_tag` VALUES (4,'йцууй йу','2020-06-14 22:58:38','2020-09-12 15:00:00'),(5,'уйцу','2020-06-14 22:58:38','2020-09-12 15:00:00'),(6,'dqwd','2020-06-14 22:58:38','2020-09-12 15:00:00'),(10,'vvcx','2020-06-14 22:58:38','2020-09-12 15:00:00'),(12,'qw','2020-06-14 22:58:38','2020-09-12 15:00:00'),(14,'2rr','2020-06-14 22:58:38','2020-09-12 15:00:00'),(15,'1ferf','2020-06-14 22:58:38','2020-09-12 15:00:00'),(16,'ferf4','2020-06-14 22:58:38','2020-09-12 15:00:00'),(17,'ff3f3','2020-06-14 22:58:38','2020-09-12 15:00:00'),(18,'wfw','2020-06-14 22:58:38','2020-09-12 15:00:00'),(19,'wefz3','2020-06-14 22:58:38','2020-09-12 15:00:00'),(20,'tag 1 en','2020-06-14 22:58:38','2020-09-12 15:00:00'),(21,'tag 2 en','2020-06-14 22:58:38','2020-09-12 15:00:00'),(22,'tag 1 ru','2020-06-14 22:58:38','2020-09-12 15:00:00'),(23,'tag 2 ru','2020-06-14 22:58:38','2020-09-12 15:00:00'),(24,'one','2020-06-14 22:58:38','2020-09-12 15:00:00'),(25,'zzze','2020-06-14 22:58:38','2020-09-12 15:00:00'),(26,'уйц','2020-06-14 22:58:38','2020-09-12 15:00:00'),(27,'вфвф','2020-06-14 22:58:38','2020-09-12 15:00:00'),(28,'eeee','2020-06-14 22:58:38','2020-09-12 15:00:00'),(29,'awdwda','2020-06-14 22:58:38','2020-09-12 15:00:00'),(30,'zczcdzc','2020-06-14 22:58:38','2020-09-12 15:00:00');
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
INSERT INTO `blog_tag_ref` VALUES (8,5,'ru'),(2,5,'ru'),(2,6,'ru'),(2,14,'en'),(2,16,'en'),(2,15,'en'),(8,4,'en'),(8,10,'en');
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
) ENGINE=InnoDB AUTO_INCREMENT=613 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action`
--

LOCK TABLES `log_action` WRITE;
/*!40000 ALTER TABLE `log_action` DISABLE KEYS */;
INSERT INTO `log_action` VALUES (168,1,'created','User',5,'2020-10-29 11:27:57'),(170,1,'updated','User',5,'2020-10-29 11:28:14'),(171,1,'updated','User',5,'2020-10-29 11:28:19'),(172,1,'deleted','User',5,'2020-10-29 11:28:27'),(173,1,'updated','User',1,'2020-10-29 12:41:10'),(174,1,'updated','User',1,'2020-10-29 12:42:41'),(175,1,'updated','User',1,'2020-10-29 12:43:06'),(176,1,'updated','User',1,'2020-10-31 14:40:51'),(177,1,'updated','User',1,'2020-10-31 14:58:25'),(178,1,'updated','User',1,'2020-10-31 14:59:42'),(179,1,'updated','User',1,'2020-10-31 15:00:14'),(182,1,'updated','User',1,'2020-11-01 06:35:29'),(183,1,'updated','User',1,'2020-11-01 06:35:40'),(184,1,'updated','User',1,'2020-11-01 06:35:47'),(186,1,'updated','Product',3,'2020-11-01 06:36:00'),(187,1,'updated','User',2,'2020-11-01 07:18:48'),(188,1,'updated','User',2,'2020-11-01 07:18:56'),(189,1,'created','User',4,'2020-11-01 07:24:04'),(191,1,'updated','User',4,'2020-11-01 07:24:20'),(192,1,'deleted','User',4,'2020-11-01 07:24:26'),(194,1,'updated','Product',3,'2020-11-01 11:21:24'),(195,1,'updated','User',1,'2020-11-03 03:58:43'),(196,1,'updated','User',1,'2020-11-03 03:59:06'),(197,1,'updated','User',1,'2020-11-03 04:00:09'),(198,1,'updated','User',1,'2020-11-03 04:00:14'),(199,1,'updated','User',1,'2020-11-03 04:00:20'),(200,1,'updated','User',1,'2020-11-03 04:00:32'),(201,1,'updated','User',1,'2020-11-03 09:59:51'),(202,1,'updated','User',1,'2020-11-03 10:00:00'),(203,1,'updated','User',1,'2020-11-03 18:05:40'),(204,1,'updated','User',1,'2020-11-05 12:48:48'),(205,1,'updated','User',1,'2020-11-05 12:48:59'),(207,1,'updated','User',1,'2020-11-11 20:27:54'),(208,1,'updated','User',1,'2020-11-29 04:04:03'),(209,1,'updated','User',1,'2020-11-29 04:11:22'),(210,1,'updated','User',1,'2020-11-29 04:15:05'),(211,1,'updated','User',1,'2020-11-29 04:15:11'),(212,1,'updated','Product',3,'2020-11-29 06:23:19'),(213,1,'updated','Product',3,'2020-12-21 04:03:56'),(214,1,'updated','Product',3,'2020-12-21 04:07:16'),(215,1,'updated','Product',3,'2020-12-21 04:08:06'),(216,1,'updated','Product',3,'2020-12-21 04:08:19'),(217,1,'updated','User',1,'2021-01-19 14:48:27'),(218,1,'updated','User',1,'2021-01-19 14:51:29'),(219,1,'updated','User',1,'2021-01-20 11:55:24'),(220,1,'updated','User',1,'2021-01-20 19:34:16'),(221,1,'updated','Product',3,'2021-01-21 07:34:02'),(222,1,'updated','User',1,'2021-01-23 11:34:03'),(228,1,'updated','User',1,'2021-01-23 11:42:34'),(230,1,'updated','User',1,'2021-01-23 16:46:50'),(231,1,'updated','User',1,'2021-01-23 16:46:58'),(233,1,'updated','User',1,'2021-01-23 18:04:52'),(234,1,'updated','User',1,'2021-01-23 18:07:18'),(236,1,'updated','User',1,'2021-01-23 18:09:04'),(237,1,'updated','User',1,'2021-01-23 18:12:34'),(239,1,'updated','User',1,'2021-01-23 18:12:42'),(240,1,'updated','Product',3,'2021-01-23 18:25:09'),(242,1,'updated','Product',3,'2021-01-23 18:26:14'),(245,1,'updated','Product',3,'2021-01-23 18:27:14'),(246,1,'updated','Product',3,'2021-01-23 18:27:40'),(247,1,'updated','Product',3,'2021-01-23 18:27:53'),(251,1,'updated','Product',3,'2021-01-24 20:49:28'),(252,1,'updated','Product',3,'2021-01-24 21:13:29'),(254,1,'updated','Product',3,'2021-01-24 21:13:48'),(255,1,'updated','Product',3,'2021-01-24 21:13:56'),(259,1,'updated','User',1,'2021-01-24 21:42:51'),(261,1,'updated','User',1,'2021-01-24 21:43:32'),(263,1,'updated','User',1,'2021-01-24 21:44:14'),(267,1,'updated','User',1,'2021-01-24 21:44:47'),(268,1,'updated','User',1,'2021-01-24 21:45:02'),(269,1,'updated','User',1,'2021-01-24 21:45:06'),(271,1,'updated','User',1,'2021-01-24 21:46:06'),(273,1,'updated','User',1,'2021-01-24 21:46:41'),(275,1,'updated','User',1,'2021-01-24 21:47:37'),(276,1,'updated','User',1,'2021-01-24 21:47:39'),(278,1,'updated','User',1,'2021-01-24 21:48:27'),(279,1,'updated','User',1,'2021-01-24 21:48:31'),(281,1,'updated','User',1,'2021-01-24 21:50:59'),(282,1,'updated','User',1,'2021-01-24 21:51:01'),(283,1,'updated','User',1,'2021-01-24 21:51:20'),(284,1,'updated','User',1,'2021-01-24 21:51:57'),(285,1,'updated','User',1,'2021-01-24 21:52:06'),(289,1,'updated','User',1,'2021-01-24 21:59:00'),(292,1,'updated','User',1,'2021-01-24 22:43:26'),(295,1,'updated','User',1,'2021-01-24 22:57:26'),(296,1,'updated','User',1,'2021-01-24 22:57:29'),(298,1,'updated','User',1,'2021-01-24 22:58:23'),(301,1,'updated','User',1,'2021-01-24 23:00:10'),(302,1,'updated','User',1,'2021-01-24 23:00:14'),(303,1,'updated','User',1,'2021-01-25 10:56:28'),(304,1,'updated','User',1,'2021-01-25 10:56:40'),(305,1,'updated','User',1,'2021-01-25 10:57:05'),(307,1,'updated','User',1,'2021-01-25 10:57:31'),(308,1,'updated','User',1,'2021-01-25 10:58:34'),(309,1,'updated','User',1,'2021-01-25 10:59:10'),(311,1,'updated','User',1,'2021-01-25 11:02:15'),(312,1,'updated','User',1,'2021-02-02 14:59:58'),(313,1,'updated','User',1,'2021-02-02 15:16:49'),(315,1,'updated','Product',3,'2021-02-02 16:16:29'),(316,1,'updated','Product',3,'2021-02-02 16:16:32'),(317,1,'updated','Product',3,'2021-02-02 16:16:37'),(318,1,'updated','Product',3,'2021-02-02 16:16:49'),(319,1,'created','Product',4,'2021-02-02 16:17:08'),(321,1,'deleted','Product',4,'2021-02-02 16:17:22'),(322,1,'updated','Product',3,'2021-02-02 16:34:38'),(323,1,'updated','Product',3,'2021-02-02 16:34:44'),(324,1,'updated','Product',2,'2021-02-02 16:35:07'),(325,1,'updated','Product',2,'2021-02-03 17:56:37'),(326,1,'updated','Product',2,'2021-02-03 17:58:30'),(327,1,'updated','Product',2,'2021-02-03 17:58:59'),(328,1,'updated','Product',2,'2021-02-03 17:59:14'),(329,1,'updated','Product',2,'2021-02-03 18:01:06'),(330,1,'updated','Product',2,'2021-02-03 18:02:00'),(331,1,'updated','Product',2,'2021-02-03 18:03:31'),(332,1,'updated','Product',2,'2021-02-03 18:08:36'),(333,1,'updated','Product',2,'2021-02-03 18:10:13'),(334,1,'updated','Product',2,'2021-02-03 18:10:43'),(335,1,'updated','Product',2,'2021-02-03 18:11:33'),(341,1,'updated','User',1,'2021-02-03 18:35:43'),(343,1,'updated','User',1,'2021-02-03 18:36:18'),(344,1,'updated','Product',3,'2021-02-03 18:53:02'),(345,1,'updated','Product',3,'2021-02-03 19:10:26'),(346,1,'updated','Product',2,'2021-02-03 19:11:21'),(347,1,'updated','Product',2,'2021-02-03 19:17:22'),(348,1,'updated','Product',2,'2021-02-03 19:17:33'),(349,1,'updated','Product',2,'2021-02-03 19:17:54'),(352,1,'updated','Product',2,'2021-02-03 19:18:41'),(353,1,'updated','User',1,'2021-02-03 19:28:33'),(354,1,'updated','User',1,'2021-02-03 19:31:16'),(355,1,'updated','Product',2,'2021-02-03 19:31:51'),(356,1,'updated','Product',2,'2021-02-03 19:32:19'),(357,1,'updated','Product',2,'2021-02-03 19:33:16'),(359,1,'updated','Product',3,'2021-02-04 12:12:21'),(361,1,'updated','Product',2,'2021-02-04 21:37:34'),(362,1,'updated','Product',2,'2021-02-04 21:37:42'),(363,1,'updated','Product',2,'2021-02-04 21:37:48'),(364,1,'updated','Product',2,'2021-02-04 21:38:01'),(365,1,'updated','Product',2,'2021-02-04 21:38:15'),(366,NULL,'created','User',2,'2021-02-04 22:28:02'),(367,1,'deleted','User',2,'2021-02-04 22:31:03'),(368,NULL,'created','User',3,'2021-02-04 22:31:30'),(369,1,'deleted','User',3,'2021-02-04 22:32:14'),(370,NULL,'created','User',4,'2021-02-04 22:32:29'),(374,NULL,'updated','User',4,'2021-02-04 22:58:37'),(375,1,'deleted','User',4,'2021-02-04 22:58:42'),(377,1,'updated','Product',2,'2021-02-05 08:54:13'),(378,1,'updated','Product',2,'2021-02-08 20:34:42'),(379,1,'updated','Product',2,'2021-02-08 21:19:43'),(380,NULL,'created','User',2,'2021-02-08 22:12:38'),(381,1,'updated','User',1,'2021-02-08 22:27:25'),(382,1,'updated','User',1,'2021-02-08 22:27:34'),(394,NULL,'updated','User',2,'2021-02-08 22:38:38'),(396,NULL,'updated','User',2,'2021-02-08 22:39:07'),(397,NULL,'updated','User',2,'2021-02-08 22:40:02'),(398,NULL,'updated','User',2,'2021-02-08 22:40:16'),(403,1,'updated','Product',3,'2021-02-08 23:20:45'),(404,1,'deleted','User',2,'2021-02-08 23:23:53'),(406,1,'updated','User',1,'2021-02-09 16:06:32'),(408,1,'updated','User',1,'2021-02-09 17:18:18'),(410,1,'updated','User',1,'2021-02-09 17:19:13'),(411,1,'updated','User',1,'2021-02-09 17:19:27'),(412,1,'updated','User',1,'2021-02-09 17:19:36'),(414,1,'updated','User',1,'2021-02-09 17:20:18'),(415,1,'updated','User',1,'2021-02-09 17:28:32'),(416,1,'updated','User',1,'2021-02-09 17:28:39'),(417,1,'updated','User',1,'2021-02-09 17:28:45'),(418,1,'updated','User',1,'2021-02-09 17:29:04'),(421,1,'updated','User',1,'2021-02-09 17:29:19'),(422,1,'updated','User',1,'2021-02-09 17:29:34'),(426,1,'updated','User',1,'2021-02-09 17:36:47'),(429,1,'updated','User',1,'2021-02-11 09:02:40'),(431,1,'updated','Product',2,'2021-02-13 22:10:47'),(436,1,'updated','Product',3,'2021-02-13 22:18:04'),(437,1,'updated','Product',3,'2021-02-13 22:18:13'),(441,1,'updated','Product',3,'2021-02-17 00:12:31'),(442,1,'updated','User',1,'2021-02-17 19:48:14'),(443,1,'updated','Product',3,'2021-02-18 01:42:36'),(444,1,'updated','Product',2,'2021-02-18 01:42:42'),(445,1,'updated','Product',3,'2021-02-18 02:13:42'),(446,1,'updated','Product',3,'2021-02-18 02:14:03'),(447,1,'updated','Product',3,'2021-02-18 02:14:28'),(448,1,'updated','Product',2,'2021-02-18 18:53:33'),(449,1,'updated','Product',2,'2021-02-18 18:53:38'),(451,1,'created','User',2,'2021-02-19 01:12:50'),(452,1,'updated','User',2,'2021-02-19 01:12:54'),(453,1,'deleted','User',2,'2021-02-19 01:12:58'),(454,1,'created','Product',4,'2021-02-19 01:32:24'),(456,1,'deleted','Product',4,'2021-02-19 01:33:01'),(459,1,'updated','User',1,'2021-02-20 05:23:34'),(460,1,'updated','User',1,'2021-02-20 05:23:47'),(461,1,'updated','User',1,'2021-02-20 05:23:53'),(462,1,'updated','User',1,'2021-02-20 05:24:00'),(463,1,'updated','User',1,'2021-02-20 05:24:05'),(464,1,'updated','User',1,'2021-02-20 05:26:42'),(465,1,'updated','User',1,'2021-02-20 05:26:50'),(466,1,'updated','User',1,'2021-02-20 05:27:18'),(467,1,'updated','User',1,'2021-02-20 05:27:23'),(468,1,'updated','User',1,'2021-02-20 05:27:51'),(469,1,'updated','User',1,'2021-02-20 05:28:03'),(470,1,'updated','User',1,'2021-02-20 05:28:07'),(472,1,'updated','User',1,'2021-02-20 05:53:32'),(473,1,'updated','User',1,'2021-02-20 05:53:36'),(474,1,'created','User',2,'2021-02-20 06:34:19'),(475,1,'updated','User',2,'2021-02-20 06:34:30'),(476,1,'updated','User',2,'2021-02-20 06:34:47'),(477,1,'updated','User',2,'2021-02-20 06:34:52'),(479,1,'updated','User',2,'2021-02-20 06:36:05'),(481,1,'updated','User',2,'2021-02-20 06:36:30'),(482,1,'updated','User',2,'2021-02-20 06:36:34'),(483,1,'deleted','User',2,'2021-02-20 06:36:43'),(484,1,'updated','Product',3,'2021-02-20 06:42:17'),(485,1,'updated','User',1,'2021-02-21 21:35:59'),(486,1,'updated','User',1,'2021-02-21 21:35:59'),(487,1,'updated','User',1,'2021-02-21 21:36:04'),(488,1,'updated','User',1,'2021-02-21 21:36:26'),(489,1,'updated','User',1,'2021-02-21 21:36:30'),(490,1,'updated','User',1,'2021-02-21 21:36:33'),(491,1,'updated','User',1,'2021-02-21 21:36:37'),(492,1,'updated','User',1,'2021-02-21 21:37:23'),(493,1,'updated','User',1,'2021-02-21 21:37:33'),(495,1,'updated','User',1,'2021-02-21 21:38:27'),(496,1,'updated','User',1,'2021-02-21 21:38:34'),(497,1,'updated','User',1,'2021-02-21 21:38:42'),(498,1,'updated','User',1,'2021-02-21 21:38:49'),(499,1,'updated','User',1,'2021-02-21 21:38:58'),(500,1,'updated','User',1,'2021-02-21 21:39:06'),(501,1,'updated','User',1,'2021-02-21 21:39:13'),(502,1,'updated','User',1,'2021-02-21 21:39:33'),(506,1,'created','User',2,'2021-02-21 22:09:03'),(507,1,'deleted','User',2,'2021-02-21 22:09:18'),(508,1,'updated','User',1,'2021-02-21 22:20:46'),(510,1,'updated','User',1,'2021-02-21 22:21:24'),(511,1,'updated','User',1,'2021-02-21 22:21:31'),(515,1,'updated','User',1,'2021-02-21 22:22:03'),(516,1,'updated','User',1,'2021-02-21 22:22:08'),(517,1,'updated','User',1,'2021-03-03 07:10:25'),(518,1,'updated','User',1,'2021-03-03 07:10:44'),(519,1,'updated','Product',3,'2021-03-28 21:26:49'),(520,1,'updated','Product',3,'2021-03-28 21:29:01'),(521,1,'updated','Product',3,'2021-03-28 21:29:07'),(523,1,'updated','Product',3,'2021-03-28 21:29:57'),(524,1,'updated','User',1,'2021-03-28 21:48:20'),(525,1,'updated','Product',3,'2021-03-28 22:31:35'),(527,1,'updated','Product',2,'2021-03-28 22:33:58'),(529,1,'updated','Product',3,'2021-03-28 22:56:59'),(530,1,'updated','Product',3,'2021-03-28 23:08:57'),(532,1,'updated','Product',3,'2021-03-28 23:11:43'),(533,1,'updated','Product',3,'2021-03-28 23:13:53'),(534,1,'updated','Product',2,'2021-03-28 23:16:02'),(535,1,'updated','Product',2,'2021-03-28 23:18:34'),(547,1,'updated','Product',3,'2021-03-28 23:28:01'),(548,1,'updated','Product',3,'2021-03-28 23:28:01'),(549,1,'updated','Product',3,'2021-03-28 23:28:06'),(550,1,'updated','Product',3,'2021-03-28 23:28:07'),(551,1,'updated','Product',3,'2021-03-28 23:28:10'),(552,1,'updated','Product',3,'2021-03-28 23:28:10'),(553,1,'updated','Product',3,'2021-03-28 23:28:20'),(554,1,'updated','Product',3,'2021-03-28 23:28:34'),(555,1,'updated','Product',3,'2021-03-28 23:28:34'),(556,1,'updated','Product',3,'2021-03-28 23:29:50'),(558,1,'updated','Product',3,'2021-03-28 23:29:54'),(560,1,'updated','Product',3,'2021-03-28 23:30:00'),(562,1,'updated','Product',3,'2021-03-28 23:30:35'),(564,1,'updated','Product',3,'2021-03-28 23:31:18'),(565,1,'updated','Product',3,'2021-03-28 23:31:53'),(566,1,'updated','Product',3,'2021-03-28 23:51:49'),(567,1,'updated','Product',3,'2021-03-28 23:52:07'),(568,1,'updated','Product',3,'2021-03-28 23:57:54'),(569,1,'updated','Product',3,'2021-03-29 00:02:33'),(570,1,'updated','Product',3,'2021-03-29 00:03:10'),(573,1,'updated','Product',3,'2021-03-29 00:04:19'),(575,1,'updated','Product',3,'2021-03-29 00:05:04'),(576,1,'updated','Product',3,'2021-03-29 00:05:21'),(578,1,'updated','Product',3,'2021-03-29 00:05:37'),(579,1,'updated','Product',3,'2021-03-29 00:06:46'),(581,1,'updated','Product',3,'2021-03-29 00:06:58'),(582,1,'updated','Product',3,'2021-03-29 00:07:08'),(583,1,'updated','Product',3,'2021-03-29 00:07:17'),(584,1,'updated','Product',3,'2021-03-29 02:40:42'),(585,1,'updated','Product',3,'2021-03-30 03:27:58'),(586,1,'updated','Product',3,'2021-03-30 07:52:02'),(593,1,'updated','Product',3,'2021-03-30 23:42:06'),(594,1,'updated','Product',3,'2021-03-30 23:42:10'),(595,1,'updated','Product',2,'2021-03-30 23:42:54'),(596,1,'updated','Product',3,'2021-03-30 23:44:29'),(597,1,'updated','Product',2,'2021-03-30 23:45:28'),(598,1,'updated','Product',2,'2021-03-30 23:45:31'),(599,1,'updated','Product',3,'2021-05-09 03:00:29'),(603,1,'created','Product',4,'2021-05-09 03:11:46'),(604,1,'updated','Product',4,'2021-05-09 03:11:55'),(605,1,'deleted','Product',4,'2021-05-09 03:12:04'),(606,1,'updated','User',1,'2021-05-09 03:49:35'),(608,1,'updated','User',1,'2021-05-09 03:49:51'),(610,1,'updated','User',1,'2021-05-09 03:50:31'),(611,1,'updated','User',1,'2021-05-09 03:50:33'),(612,1,'updated','User',1,'2021-05-14 05:14:02');
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
) ENGINE=InnoDB AUTO_INCREMENT=855 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action_attr`
--

LOCK TABLES `log_action_attr` WRITE;
/*!40000 ALTER TABLE `log_action_attr` DISABLE KEYS */;
INSERT INTO `log_action_attr` VALUES (300,168,'username','\"\"','\"wqqwqdwd\"'),(301,168,'role','\"\"','\"admin\"'),(302,168,'email','\"\"','\"qwdqw@dqdqwd.vrev\"'),(303,168,'design_theme','\"\"','\"nav_full\"'),(304,168,'design_font','\"\"','\"oswald\"'),(305,170,'design_font','\"oswald\"','\"roboto\"'),(306,171,'design_font','\"roboto\"','\"oswald\"'),(307,172,'username','\"wqqwqdwd\"','\"\"'),(308,172,'role','\"admin\"','\"\"'),(309,172,'email','\"qwdqw@dqdqwd.vrev\"','\"\"'),(310,172,'design_theme','\"nav_full\"','\"\"'),(311,172,'design_font','\"oswald\"','\"\"'),(312,173,'design_theme','\"nav_full\"','\"nav_left\"'),(313,173,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(314,174,'design_theme','\"nav_left\"','\"nav_full\"'),(315,174,'design_font','\"ibm_plex_sans\"','\"montserrat\"'),(316,175,'design_font','\"montserrat\"','\"oswald\"'),(317,176,'design_theme','\"nav_full\"','\"nav_left\"'),(318,176,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(319,176,'design_border_radius','\"\"','\"15\"'),(320,177,'design_theme','\"nav_left\"','\"nav_full\"'),(321,177,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(322,177,'design_border_radius','15','\"\"'),(323,178,'design_theme','\"nav_full\"','\"nav_left\"'),(324,178,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(325,178,'design_border_radius','\"\"','\"15\"'),(326,179,'design_border_radius','15','\"20\"'),(327,182,'full_name','\"Administrator 1\"','\"Administrator 12\"'),(328,183,'username','\"admin\"','\"admin2\"'),(329,183,'full_name','\"Administrator 12\"','\"Administrator\"'),(330,184,'username','\"admin2\"','\"admin\"'),(331,186,'options_tmp','[\"Opt 1 en\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]'),(332,187,'username','\"test\"','\"test4\"'),(333,188,'username','\"test4\"','\"test\"'),(334,189,'username','\"\"','\"qwe\"'),(335,189,'role','\"\"','\"admin\"'),(336,189,'email','\"\"','\"qwe@qwe.qwe\"'),(337,189,'design_theme','\"\"','\"nav_full\"'),(338,189,'design_font','\"\"','\"oswald\"'),(339,189,'full_name','\"\"','\"qwe qwe\"'),(340,191,'full_name','\"qwe qwe\"','\"qwezzz\"'),(341,192,'username','\"qwe\"','\"\"'),(342,192,'role','\"admin\"','\"\"'),(343,192,'email','\"qwe@qwe.qwe\"','\"\"'),(344,192,'design_theme','\"nav_full\"','\"\"'),(345,192,'design_font','\"oswald\"','\"\"'),(346,192,'full_name','\"qwezzz\"','\"\"'),(347,194,'name','{\"de\": \"das\", \"en\": \"das\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}'),(348,195,'design_theme','\"nav_full\"','\"nav_left\"'),(349,195,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(350,195,'design_border_radius','\"\"','\"15\"'),(351,196,'design_border_radius','15','\"10\"'),(352,197,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(353,198,'design_font','\"oswald\"','\"roboto\"'),(354,199,'design_font','\"roboto\"','\"montserrat\"'),(355,200,'design_theme','\"nav_left\"','\"nav_full\"'),(356,200,'design_font','\"montserrat\"','\"oswald\"'),(357,200,'design_border_radius','10','\"\"'),(358,201,'design_theme','\"nav_full\"','\"nav_left\"'),(359,202,'design_theme','\"nav_left\"','\"nav_full\"'),(360,203,'design_theme','\"nav_full\"','\"nav_left\"'),(361,203,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(362,204,'design_theme','\"nav_left\"','\"nav_full\"'),(363,205,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(364,207,'design_theme','\"nav_left\"','\"nav_full\"'),(365,208,'design_theme','\"nav_full\"','\"nav_left\"'),(366,209,'design_theme','\"nav_left\"','\"nav_full\"'),(367,210,'design_theme','\"nav_full\"','\"nav_left\"'),(368,211,'design_theme','\"nav_left\"','\"nav_full\"'),(369,212,'images','[]','[\"/uploaded/2020-11-29/5c70ace731882c790548336d99fc9608.png\"]'),(370,213,'discount','\"\"','\"43\"'),(371,214,'discount','43','\"\"'),(372,215,'price','\"\"','\"12\"'),(373,216,'discount','\"\"','\"40\"'),(374,217,'design_theme','\"nav_full\"','\"nav_left\"'),(375,217,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(376,217,'design_border_radius','\"\"','\"15\"'),(377,218,'design_theme','\"nav_left\"','\"nav_full\"'),(378,218,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(379,218,'design_border_radius','15','\"\"'),(380,219,'design_theme','\"nav_full\"','\"nav_left\"'),(381,219,'design_font','\"oswald\"','\"ibm_plex_sans\"'),(382,219,'design_border_radius','\"\"','\"10\"'),(383,220,'design_theme','\"nav_left\"','\"nav_full\"'),(384,220,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(385,220,'design_border_radius','10','\"\"'),(386,221,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 1\", \"Opt 4\"]','[]'),(387,222,'email','\"admin@local.host\"','\"admin@local.hostz\"'),(388,228,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(389,230,'email','\"admin@local.host\"','\"admin@local.hostz\"'),(390,231,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(391,233,'email','\"admin@local.host\"','\"admin@local.hostf\"'),(392,234,'email','\"admin@local.hostf\"','\"admin@local.host\"'),(393,236,'email','\"admin@local.hostz\"','\"admin@local.host\"'),(394,237,'phone','\"2231\"','\"\"'),(395,239,'phone','\"\"','\"2231\"'),(396,240,'brand_id','\"\"','\"\"'),(397,240,'quantity','\"\"','\"\"'),(398,240,'options_tmp','[]','[]'),(399,242,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(400,245,'main_category_id','\"Cat 1-1\"','\"Cat 1-1\"'),(401,245,'price','12','\"12\"'),(402,245,'discount','40','\"40\"'),(403,245,'variations_tmp','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]'),(404,245,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(405,245,'related_tmp','[\"Prod 1\"]','[\"Prod 1\"]'),(406,246,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(407,247,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(408,247,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 3\"]'),(409,251,'images','[]','[\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"]'),(410,252,'options_tmp','[]','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]'),(411,254,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(412,254,'options_tmp','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]','[]'),(413,255,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(414,255,'options_tmp','[]','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]'),(415,259,'full_name','\"Administrator\"','\"123\"'),(416,261,'full_name','\"123\"','\"Administrator\"'),(417,263,'full_name','\"Administrator\"','\"Administratorz\"'),(418,267,'full_name','\"Administratorz\"','\"Administrator\"'),(419,268,'full_name','\"Administrator\"','\"Administratorz\"'),(420,269,'full_name','\"Administratorz\"','\"Administrator\"'),(421,271,'full_name','\"Administrator\"','\"Administratorz\"'),(422,273,'full_name','\"Administratorz\"','\"Administrator\"'),(423,275,'full_name','\"Administrator\"','\"Administratorz\"'),(424,276,'full_name','\"Administratorz\"','\"Administrator\"'),(425,278,'full_name','\"Administrator\"','\"Administrator1123\"'),(426,279,'full_name','\"Administrator1123\"','\"Administrator\"'),(427,281,'full_name','\"Administrator\"','\"Administratorz\"'),(428,282,'full_name','\"Administratorz\"','\"Administrator\"'),(429,283,'image','\"\"','\"/files/profile/2021-01-24/f363c1939a9f33f0e2d39a680318ee94.png\"'),(430,284,'image','\"/files/profile/2021-01-24/f363c1939a9f33f0e2d39a680318ee94.png\"','\"/files/profile/2021-01-24/9a5436951afe19e7f29f14030e802258.png\"'),(431,285,'image','\"/files/profile/2021-01-24/9a5436951afe19e7f29f14030e802258.png\"','\"/files/profile/2021-01-24/47f2502a419ce1b87ea90e0a3c282ccb.png\"'),(432,289,'full_name','\"Administrator\"','\"Administratorz\"'),(433,292,'full_name','\"Administratorz\"','\"Administrator\"'),(434,295,'full_name','\"Administrator\"','\"admin\"'),(435,296,'full_name','\"admin\"','\"Administrator\"'),(436,298,'image','\"/files/profile/2021-01-24/47f2502a419ce1b87ea90e0a3c282ccb.png\"','\"/files/profile/2021-01-24/0253ff3f08197990c7b25d988626e6e3.png\"'),(437,301,'full_name','\"Administrator\"','\"zAdministrator\"'),(438,302,'full_name','\"zAdministrator\"','\"Administrator\"'),(439,303,'address','\"addr\"','\"addr <div>asd</div>\"'),(440,304,'address','\"addr asd\"','\"addr \\\" asd\"'),(441,305,'phone','\"2231\"','\"2231\\\" asd\"'),(442,307,'address','\"addr \\\" asd\"','\"addr <div>asd</div>\"'),(443,308,'phone','\"2231\\\" asd\"','\"addr <div>asd</div>\"'),(444,309,'address','\"addr <div>asd</div>\"','\"addr\"'),(445,311,'phone','\"addr &lt;div&gt;asd&lt;/div&gt;\"','\"123\"'),(446,312,'design_theme','\"nav_full\"','\"nav_left\"'),(447,313,'design_theme','\"nav_left\"','\"nav_full\"'),(448,315,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\"]'),(449,315,'options_tmp','[\"Opt 1 en\", \"Opt 1\", \"Opt 3\"]','[]'),(450,316,'categories_tmp','[\"Cat 1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(451,317,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(452,318,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(453,319,'name','\"\"','{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}'),(454,319,'slug','\"\"','\"qwe\"'),(455,319,'short_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(456,319,'full_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(457,319,'price','\"\"','\"2\"'),(458,319,'main_category_id','\"\"','\"Cat 1-1\"'),(459,319,'categories_tmp','[]','[\"Cat 2\", \"Cat 3\"]'),(460,319,'options_tmp','[]','[\"Opt 2\"]'),(461,321,'name','{\"de\": \"qwe\", \"en\": \"qwe\", \"ru\": \"qwe\"}','\"\"'),(462,321,'slug','\"qwe\"','\"\"'),(463,321,'short_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(464,321,'full_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(465,321,'main_category_id','\"Cat 1-1\"','\"\"'),(466,321,'price','2','\"\"'),(467,321,'categories_tmp','[\"Cat 2\", \"Cat 3\"]','[]'),(468,321,'options_tmp','[\"Opt 2\"]','[]'),(469,322,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]'),(470,322,'related_tmp','[\"Prod 1\"]','[]'),(471,323,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 1-1\"]','[\"Cat 1\", \"Cat 1-1\"]'),(472,324,'related_tmp','[]','[\"das 2\"]'),(473,325,'quantity','3','1'),(474,325,'variations_tmp','[{\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[]'),(475,325,'categories_tmp','[\"Cat 1\", \"Cat 2\", \"Cat 3\"]','[]'),(476,325,'options_tmp','[\"Opt 4\"]','[]'),(477,325,'related_tmp','[\"das 2\"]','[]'),(478,326,'quantity','1','3'),(479,327,'quantity','3','5'),(480,328,'quantity','5','7'),(481,329,'quantity','3','1'),(482,330,'quantity','3','1'),(483,331,'quantity','3','1'),(484,332,'quantity','3','1'),(485,333,'quantity','3','1'),(486,334,'quantity','3','1'),(487,335,'quantity','3','1'),(492,341,'phone','\"123\"','\"1234\"'),(493,343,'phone','\"1234\"','\"123\"'),(494,344,'quantity','3','1'),(495,344,'variations_tmp','[{\"Sku\": \"frf\", \"Price\": 43, \"Quantity\": 3}, {\"Sku\": null, \"Price\": null, \"Quantity\": null}]','[]'),(496,344,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(497,345,'quantity','1','3'),(498,346,'quantity','3','1'),(499,347,'quantity','1','3'),(500,348,'quantity','3','\"\"'),(501,349,'quantity','\"\"','3'),(504,352,'quantity','3','1'),(505,353,'design_border_radius','\"\"','\"10\"'),(506,354,'design_border_radius','10','\"\"'),(507,355,'quantity','1','3'),(508,356,'quantity','3','1'),(509,357,'quantity','1','3'),(510,359,'quantity','3','2'),(511,361,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(512,362,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(513,363,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(514,363,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[]'),(515,364,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(516,364,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(517,365,'variations_tmp','[]','[{\"SKU\": null, \"Price\": null, \"Quantity\": null}]'),(518,366,'username','\"\"','\"qwe\"'),(519,366,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(520,366,'role','\"\"','\"registered\"'),(521,366,'full_name','\"\"','\"qwe\"'),(522,367,'username','\"qwe\"','\"\"'),(523,367,'role','\"registered\"','\"\"'),(524,367,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(525,367,'design_theme','\"nav_left\"','\"\"'),(526,367,'design_font','\"ibm_plex_sans\"','\"\"'),(527,367,'full_name','\"qwe\"','\"\"'),(528,368,'username','\"\"','\"qwe\"'),(529,368,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(530,368,'role','\"\"','\"registered\"'),(531,368,'full_name','\"\"','\"qweqwe\"'),(532,369,'username','\"qwe\"','\"\"'),(533,369,'role','\"registered\"','\"\"'),(534,369,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(535,369,'design_theme','\"nav_left\"','\"\"'),(536,369,'design_font','\"ibm_plex_sans\"','\"\"'),(537,369,'full_name','\"qweqwe\"','\"\"'),(538,370,'username','\"\"','\"qwe\"'),(539,370,'email','\"\"','\"alinsky.dmitry@gmail.com\"'),(540,370,'role','\"\"','\"registered\"'),(541,370,'full_name','\"\"','\"qweqweqweqqr\"'),(542,374,'phone','\"\"','\"222\"'),(543,375,'username','\"qwe\"','\"\"'),(544,375,'role','\"registered\"','\"\"'),(545,375,'email','\"alinsky.dmitry@gmail.com\"','\"\"'),(546,375,'design_theme','\"nav_left\"','\"\"'),(547,375,'design_font','\"ibm_plex_sans\"','\"\"'),(548,375,'full_name','\"qweqweqweqqr\"','\"\"'),(549,375,'phone','\"222\"','\"\"'),(550,377,'variations_tmp','[{\"SKU\": \"\", \"Price\": 21, \"Quantity\": 2}]','[]'),(551,378,'quantity','3','1'),(552,378,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(553,378,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[]'),(554,379,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(555,379,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(556,380,'username','\"\"','\"test\"'),(557,380,'email','\"\"','\"asd@asd.asd\"'),(558,380,'role','\"\"','\"registered\"'),(559,380,'full_name','\"\"','\"zzz\"'),(560,381,'full_name','\"Administrator\"','\"Administratorz\"'),(561,382,'full_name','\"Administratorz\"','\"Administrator\"'),(562,394,'image','\"\"','\"admin\"'),(563,396,'image','\"admin\"','\"adminz\"'),(564,397,'image','\"adminz\"','\"site/logout\"'),(565,398,'image','\"site/logout\"','\"/logout\"'),(566,403,'related_tmp','[]','[\"Prod 1\"]'),(567,404,'username','\"test\"','\"\"'),(568,404,'role','\"registered\"','\"\"'),(569,404,'email','\"asd@asd.asd\"','\"\"'),(570,404,'design_theme','\"nav_left\"','\"\"'),(571,404,'design_font','\"ibm_plex_sans\"','\"\"'),(572,404,'full_name','\"zzz\"','\"\"'),(573,404,'image','\"/logout\"','\"\"'),(574,406,'image','\"\"','\"/files/profile/2021-02-09/3672a7e9629f2af8a15f68e38ad0c559.png\"'),(575,408,'image','\"/files/profile/2021-02-09/3672a7e9629f2af8a15f68e38ad0c559.png\"','{\"name\": \"Screenshot_1.png\", \"size\": 26266, \"type\": \"image/png\", \"error\": 0, \"tempName\": \"C:\\\\Work\\\\OpenServer\\\\userdata\\\\php_upload\\\\phpE97E.tmp\"}'),(576,410,'image','\"\"','\"/files/profile/2021-02-09/d104aa275050eb8906cbd434cb20ba04.png\"'),(577,411,'image','\"\"','\"/files/profile/2021-02-09/734a5aedc2efceff27e13a1d8f990ec2.png\"'),(578,412,'image','\"/files/profile/2021-02-09/734a5aedc2efceff27e13a1d8f990ec2.png\"','\"/files/profile/2021-02-09/da8a54a9442e1148d48cb1f028cb85f7.png\"'),(579,414,'image','\"/files/profile/2021-02-09/da8a54a9442e1148d48cb1f028cb85f7.png\"','\"/files/profile/2021-02-09/81ba2f566ca62fc555142a087d7e68a2.png\"'),(580,415,'phone','\"123\"','\"123 wew\"'),(581,416,'phone','\"123 wew\"','\"123\"'),(582,417,'image','\"/files/profile/2021-02-09/81ba2f566ca62fc555142a087d7e68a2.png\"','\"/files/profile/2021-02-09/75a15505518a1fce903bb96421493938.png\"'),(583,418,'image','\"\"','\"/files/profile/2021-02-09/035197e3d171ae9857d6207a00cc65bd.png\"'),(584,421,'image','\"/files/profile/2021-02-09/035197e3d171ae9857d6207a00cc65bd.png\"','\"/files/profile/2021-02-09/14fbcbf89dd853995c4a29cef9366eef.png\"'),(585,422,'image','\"/files/profile/2021-02-09/14fbcbf89dd853995c4a29cef9366eef.png\"','\"/files/profile/2021-02-09/1e9117279a43c52f0d860da13d715a38.png\"'),(586,426,'image','\"/files/profile/2021-02-09/1e9117279a43c52f0d860da13d715a38.png\"','\"/files/profile/2021-02-09/836a471bae9d73ca3475a9f795a02277.png\"'),(587,429,'address','\"addr\"','\"addr awd\"'),(588,431,'quantity','1','3'),(589,431,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(590,431,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[]'),(591,436,'brand_id','\"Brand 1\"','\"Brand 2\"'),(592,437,'brand_id','\"Brand 2\"','\"\"'),(593,441,'brand_id','\"\"','\"Brand 3\"'),(594,442,'design_theme','\"nav_full\"','\"nav_left\"'),(595,443,'quantity','1','\"3\"'),(596,444,'quantity','\"\"','\"3\"'),(597,445,'categories_tmp','[]','[\"Cat 1-1\"]'),(598,445,'options_tmp','[]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]'),(599,446,'variations_tmp','[]','[{\"SKU\": null, \"Price\": null, \"Quantity\": null}]'),(600,447,'variations_tmp','[{\"SKU\": \"\", \"Price\": 123, \"Quantity\": null}]','[]'),(601,448,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(602,448,'options_tmp','[]','[\"Opt 2\", \"Opt 3\", \"Opt 1\"]'),(603,449,'variations_tmp','[]','[{\"SKU\": null, \"Price\": null, \"Quantity\": null}]'),(604,451,'username','\"\"','\"dwadawd\"'),(605,451,'email','\"\"','\"asd@asd.asd\"'),(606,451,'role','\"\"','\"admin\"'),(607,451,'design_theme','\"\"','\"nav_left\"'),(608,451,'design_font','\"\"','\"roboto\"'),(609,451,'full_name','\"\"','\"dqwdqw\"'),(610,452,'role','\"admin\"','\"registered\"'),(611,453,'username','\"dwadawd\"','\"\"'),(612,453,'email','\"asd@asd.asd\"','\"\"'),(613,453,'role','\"registered\"','\"\"'),(614,453,'design_theme','\"nav_left\"','\"\"'),(615,453,'design_font','\"roboto\"','\"\"'),(616,453,'full_name','\"dqwdqw\"','\"\"'),(617,454,'name','\"\"','{\"de\": \"zzz\", \"en\": \"zzz\", \"ru\": \"zzz\"}'),(618,454,'slug','\"\"','\"zzz\"'),(619,454,'brand_id','\"\"','\"Brand 2\"'),(620,454,'short_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(621,454,'full_description','\"\"','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}'),(622,454,'sku','\"\"','\"523523\"'),(623,454,'quantity','\"\"','\"333\"'),(624,454,'price','\"\"','\"100\"'),(625,454,'main_category_id','\"\"','\"Cat 1-1\"'),(626,456,'name','{\"de\": \"zzz\", \"en\": \"zzz\", \"ru\": \"zzz\"}','\"\"'),(627,456,'slug','\"zzz\"','\"\"'),(628,456,'short_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(629,456,'full_description','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','\"\"'),(630,456,'brand_id','\"Brand 2\"','\"\"'),(631,456,'main_category_id','\"Cat 1-1\"','\"\"'),(632,456,'price','100','\"\"'),(633,456,'quantity','333','\"\"'),(634,456,'sku','\"523523\"','\"\"'),(636,459,'design_theme','\"nav_left\"','\"nav_full\"'),(637,460,'design_font','\"roboto\"','\"ibm_plex_sans\"'),(638,461,'design_font','\"ibm_plex_sans\"','\"montserrat\"'),(639,462,'design_font','\"montserrat\"','\"oswald\"'),(640,463,'design_font','\"oswald\"','\"roboto\"'),(641,464,'design_theme','\"nav_full\"','\"nav_left\"'),(642,465,'design_font','\"roboto\"','\"montserrat\"'),(643,466,'design_font','\"montserrat\"','\"roboto\"'),(644,467,'design_theme','\"nav_left\"','\"nav_full\"'),(645,467,'design_font','\"roboto\"','\"ibm_plex_sans\"'),(646,468,'design_font','\"ibm_plex_sans\"','\"oswald\"'),(647,469,'design_font','\"oswald\"','\"roboto\"'),(648,470,'design_font','\"roboto\"','\"oswald\"'),(649,472,'design_font','\"oswald\"','\"roboto\"'),(650,473,'design_font','\"roboto\"','\"oswald\"'),(651,474,'username','\"\"','\"wdawda\"'),(652,474,'email','\"\"','\"qwe@qweqwe.qweqwe\"'),(653,474,'role','\"\"','\"admin\"'),(654,474,'design_theme','\"\"','\"nav_left\"'),(655,474,'design_font','\"\"','\"roboto\"'),(656,474,'full_name','\"\"','\"qwdqwd\"'),(657,475,'role','\"admin\"','\"registered\"'),(658,476,'username','\"wdawda\"','\"qweqweqwe\"'),(659,477,'role','\"registered\"','\"admin\"'),(660,479,'role','\"admin\"','\"registered\"'),(661,481,'role','\"registered\"','\"admin\"'),(662,482,'role','\"admin\"','\"registered\"'),(663,483,'username','\"qweqweqwe\"','\"\"'),(664,483,'email','\"qwe@qweqwe.qweqwe\"','\"\"'),(665,483,'role','\"registered\"','\"\"'),(666,483,'design_theme','\"nav_left\"','\"\"'),(667,483,'design_font','\"roboto\"','\"\"'),(668,483,'full_name','\"qwdqwd\"','\"\"'),(669,484,'name','{\"de\": \"das\", \"en\": \"das 2\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 23\", \"ru\": \"das\"}'),(670,485,'design_theme','\"\"','\"nav_left\"'),(671,485,'design_font','\"\"','\"roboto\"'),(672,486,'design_theme','\"\"','\"nav_left\"'),(673,486,'design_font','\"\"','\"roboto\"'),(674,487,'design_theme','\"\"','\"nav_left\"'),(675,487,'design_font','\"\"','\"roboto\"'),(676,488,'design_theme','\"\"','\"nav_full\"'),(677,488,'design_font','\"\"','\"roboto\"'),(678,489,'design_theme','\"\"','\"nav_left\"'),(679,489,'design_font','\"\"','\"roboto\"'),(680,490,'design_theme','\"\"','\"nav_full\"'),(681,490,'design_font','\"\"','\"roboto\"'),(682,491,'design_theme','\"\"','\"nav_full\"'),(683,491,'design_font','\"\"','\"oswald\"'),(684,492,'design_theme','\"\"','\"nav_full\"'),(685,492,'design_font','\"\"','\"oswald\"'),(686,493,'design_theme','\"\"','\"nav_full\"'),(687,493,'design_font','\"\"','\"oswald\"'),(688,495,'phone','\"123\"','\"123 2\"'),(689,496,'design_theme','\"nav_full\"','\"nav_left\"'),(690,497,'design_theme','\"nav_left\"','\"nav_full\"'),(691,498,'design_border_radius','\"\"','\"02\"'),(692,499,'design_border_radius','2','\"1\"'),(693,500,'design_border_radius','1','\"\"'),(694,501,'design_border_radius','\"\"','\"111\"'),(695,502,'design_border_radius','111','\"\"'),(696,506,'username','\"\"','\"qwe\"'),(697,506,'email','\"\"','\"qwe@qweqwe.qweqw\"'),(698,506,'role','\"\"','\"admin\"'),(699,506,'full_name','\"\"','\"wdqw\"'),(700,506,'phone','\"\"','\"dqwdqwd\"'),(701,506,'design_theme','\"\"','\"nav_left\"'),(702,506,'design_font','\"\"','\"roboto\"'),(703,507,'username','\"qwe\"','\"\"'),(704,507,'email','\"qwe@qweqwe.qweqw\"','\"\"'),(705,507,'role','\"admin\"','\"\"'),(706,507,'full_name','\"wdqw\"','\"\"'),(707,507,'phone','\"dqwdqwd\"','\"\"'),(708,507,'design_theme','\"nav_left\"','\"\"'),(709,507,'design_font','\"roboto\"','\"\"'),(710,508,'phone','\"123 2\"','\"123 22\"'),(711,510,'address','\"addr awd\"','\"addr awd qw\"'),(712,511,'address','\"addr awd qw\"','\"addr awd\"'),(713,515,'design_font','\"oswald\"','\"roboto\"'),(714,516,'design_font','\"roboto\"','\"oswald\"'),(715,517,'design_theme','\"nav_full\"','\"nav_left\"'),(716,518,'design_theme','\"nav_left\"','\"nav_full\"'),(717,519,'variations_tmp','[]','[{\"SKU\": \"wefw\", \"Name\": \"qwe\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 634}]'),(718,520,'categories_tmp','[\"Cat 1-1\"]','[\"Cat 3\", \"Cat 1-1\"]'),(719,520,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 4\"]'),(720,521,'options_tmp','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 4\"]','[\"Opt 1 en\", \"Opt 3\", \"Opt 2\", \"Opt 3\", \"Opt 4\"]'),(721,523,'variations_tmp','[{\"SKU\": \"wefw\", \"Name\": \"qwe\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 634}]','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 634}]'),(722,524,'image','\"\"','\"/uploaded/profile/2021-03-28/50fdbc8a477209ef2065a019122e7feb.png\"'),(723,525,'price','12','\"253\"'),(724,525,'discount','40','\"23\"'),(725,525,'quantity','3','\"5\"'),(726,525,'sku','\"dqw\"','\"wefw\"'),(727,525,'variations_tmp','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 634}]','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 5}]'),(728,527,'full_description','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"fsefesfse<p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"<p>fsefesfse</p><p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}'),(729,529,'discount','23','\"20\"'),(730,529,'variations_tmp','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 23, \"Quantity\": 5}]','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 20, \"Quantity\": 5}]'),(731,530,'variations_tmp','[{\"SKU\": \"wefw\", \"Name\": \"qwe z\", \"Price\": 253, \"Discount\": 20, \"Quantity\": 5}]','[]'),(732,532,'price','253','\"100\"'),(733,532,'discount','20','\"10\"'),(734,532,'quantity','5','\"15\"'),(735,532,'sku','\"wefw\"','\"Variation 1\"'),(736,532,'variations_tmp','[]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(737,533,'quantity','15','\"5\"'),(738,534,'categories_tmp','[\"Cat 1\", \"Cat 1-1\"]','[]'),(739,534,'options_tmp','[\"Opt 2\", \"Opt 3\", \"Opt 1\"]','[]'),(740,535,'categories_tmp','[]','[\"Cat 1\", \"Cat 1-1\"]'),(741,547,'quantity','5','15'),(742,548,'price','100','150'),(743,548,'discount','10','\"\"'),(744,548,'quantity','15','5'),(745,548,'sku','\"Variation 1\"','\"Variation 2\"'),(746,549,'price','150','100'),(747,549,'discount','\"\"','10'),(748,549,'sku','\"Variation 2\"','\"Variation 1\"'),(749,550,'price','100','150'),(750,550,'discount','10','\"\"'),(751,550,'quantity','5','4'),(752,550,'sku','\"Variation 1\"','\"Variation 2\"'),(753,551,'price','150','100'),(754,551,'discount','\"\"','10'),(755,551,'quantity','4','15'),(756,551,'sku','\"Variation 2\"','\"Variation 1\"'),(757,552,'price','100','150'),(758,552,'discount','10','\"\"'),(759,552,'quantity','15','5'),(760,552,'sku','\"Variation 1\"','\"Variation 2\"'),(761,553,'price','150','\"100\"'),(762,553,'discount','\"\"','\"10\"'),(763,553,'quantity','5','\"15\"'),(764,553,'sku','\"Variation 2\"','\"Variation 1\"'),(765,554,'quantity','15','5'),(766,555,'price','100','150'),(767,555,'discount','10','\"\"'),(768,555,'quantity','5','4'),(769,555,'sku','\"Variation 1\"','\"Variation 2\"'),(770,556,'price','150','100'),(771,556,'discount','\"\"','10'),(772,556,'quantity','4','15'),(773,556,'sku','\"Variation 2\"','\"Variation 1\"'),(774,558,'quantity','15','5'),(775,560,'quantity','5','15'),(776,562,'quantity','15','5'),(777,564,'price','100','\"150\"'),(778,564,'discount','10','\"\"'),(779,564,'quantity','5','\"4\"'),(780,564,'sku','\"Variation 1\"','\"Variation 2\"'),(781,564,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 5}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 4}]','[{\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 4}]'),(782,565,'variations_tmp','[{\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 4}]','[]'),(783,566,'price','150','\"100\"'),(784,566,'discount','\"\"','\"10\"'),(785,566,'quantity','15','\"10\"'),(786,566,'sku','\"Variation 2\"','\"Variation 1\"'),(787,566,'variations_tmp','[]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 10}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(788,567,'quantity','10','\"15\"'),(789,567,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 10}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(790,568,'discount','10','\"30\"'),(791,568,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 30, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(792,569,'discount','30','\"10\"'),(793,569,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 30, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(794,570,'discount','10','\"20\"'),(795,570,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 20, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(797,573,'quantity','15','5'),(798,575,'discount','20','\"10\"'),(799,575,'quantity','5','\"15\"'),(800,575,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 20, \"Quantity\": 5}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 4}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(801,576,'quantity','15','25'),(802,578,'discount','10','\"20\"'),(803,578,'quantity','25','\"15\"'),(804,578,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 25}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 6}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 20, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(805,579,'quantity','15','5'),(806,581,'discount','20','\"10\"'),(807,581,'quantity','5','\"15\"'),(808,581,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 20, \"Quantity\": 5}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 4}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]'),(809,582,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}, {\"SKU\": \"Variation 2\", \"Name\": \"Variation 2\", \"Price\": 150, \"Discount\": null, \"Quantity\": 5}]','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}]'),(810,583,'variations_tmp','[{\"SKU\": \"Variation 1\", \"Name\": \"Variation 1\", \"Price\": 100, \"Discount\": 10, \"Quantity\": 15}]','[]'),(811,584,'price','100','\"22\"'),(812,584,'discount','10','\"\"'),(813,584,'quantity','15','\"14\"'),(814,584,'sku','\"Variation 1\"','\"qqwdqwd\"'),(815,584,'variations_tmp','[]','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": null, \"Quantity\": 14}]'),(816,585,'name','{\"de\": \"das\", \"en\": \"das 23\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 234\", \"ru\": \"das\"}'),(817,585,'quantity','25','\"14\"'),(818,586,'name','{\"de\": \"das\", \"en\": \"das 234\", \"ru\": \"das\"}','{\"de\": \"das\", \"en\": \"das 23\", \"ru\": \"das\"}'),(819,593,'discount','\"\"','\"4\"'),(820,593,'variations_tmp','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": 0, \"Quantity\": 14}]','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": 4, \"Quantity\": 14}]'),(821,594,'discount','4','\"40\"'),(822,594,'variations_tmp','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": 4, \"Quantity\": 14}]','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": 40, \"Quantity\": 14}]'),(823,595,'discount','\"\"','\"20\"'),(824,596,'price','22','\"18\"'),(825,596,'discount','40','\"50\"'),(826,596,'variations_tmp','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 22, \"Discount\": 40, \"Quantity\": 14}]','[{\"SKU\": \"qqwdqwd\", \"Name\": \"qwe\", \"Price\": 18, \"Discount\": 50, \"Quantity\": 14}]'),(827,597,'discount','20','\"\"'),(828,598,'discount','\"\"','\"20\"'),(829,599,'related_ids','[]','[\"2\"]'),(830,603,'name','\"\"','{\"en\": \"qwe\", \"ru\": \"qwe\"}'),(831,603,'slug','\"\"','\"qwe\"'),(832,603,'brand_id','\"\"','\"Brand 2\"'),(833,603,'short_description','\"\"','{\"en\": \"\", \"ru\": \"\"}'),(834,603,'full_description','\"\"','{\"en\": \"\", \"ru\": \"\"}'),(835,603,'price','\"\"','\"123\"'),(836,603,'quantity','\"\"','\"4\"'),(837,603,'sku','\"\"','\"14141\"'),(838,603,'main_category_id','\"\"','\"Cat 1\"'),(839,604,'related_ids','[]','[\"2\", \"3\"]'),(840,605,'name','{\"en\": \"qwe\", \"ru\": \"qwe\"}','\"\"'),(841,605,'slug','\"qwe\"','\"\"'),(842,605,'short_description','{\"en\": \"\", \"ru\": \"\"}','\"\"'),(843,605,'full_description','{\"en\": \"\", \"ru\": \"\"}','\"\"'),(844,605,'brand_id','\"Brand 2\"','\"\"'),(845,605,'main_category_id','\"Cat 1\"','\"\"'),(846,605,'price','123','\"\"'),(847,605,'quantity','4','\"\"'),(848,605,'sku','\"14141\"','\"\"'),(849,605,'related_ids','[\"2\", \"3\"]','\"\"'),(850,606,'full_name','\"Administrator\"','\"Administrator q\"'),(851,608,'full_name','\"Administrator q\"','\"Administrator\"'),(852,610,'full_name','\"Administrator\"','\"Administrator q\"'),(853,611,'full_name','\"Administrator q\"','\"Administrator\"'),(854,612,'design_theme','\"nav_full\"','\"nav_left\"');
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
INSERT INTO `menu` VALUES (1,1,1,8,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','null','2020-09-12 15:00:00','2020-09-12 15:00:00'),(5,1,2,3,1,'{\"de\": \"2\", \"en\": \"2\", \"ru\": \"2\"}','{\"de\": \"\", \"en\": \"dawd\", \"ru\": \"\"}','2020-09-12 15:00:00','2020-10-02 23:25:55'),(25,1,4,7,1,'{\"de\": \"3\", \"en\": \"3\", \"ru\": \"3\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-02-24 07:39:47'),(26,1,5,6,2,'{\"de\": \"3-1\", \"en\": \"3-1\", \"ru\": \"3-1\"}','{\"de\": \"/qwe\", \"en\": \"/qwe\", \"ru\": \"/qwe\"}','2020-09-12 15:00:00','2021-02-24 07:39:08');
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
  `status` enum('new','confirmed','payed','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
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
INSERT INTO `order` VALUES (1,NULL,'qwe','qwe@qwe.qwe','1312','312e2d12d','pickup','cash',10,135,2,'new','b73ee5098adc9ba00c5e7e1f36c92318','2021-03-30 23:43:00','2021-05-09 07:53:13');
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
INSERT INTO `page` VALUES (1,'{\"de\": \"qweq\", \"en\": \"qweq\", \"ru\": \"qweq\"}','qweq','/uploads/media/svg_html.svg','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2021-02-13 19:55:00','2021-02-16 17:20:28');
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
INSERT INTO `product` VALUES (2,'{\"de\": \"Prod 1\", \"en\": \"Prod 1\", \"ru\": \"Prod 1\"}','prod-1','{\"de\": \"fsrrf\", \"en\": \"fsrrf\", \"ru\": \"fsrrf\"}','{\"de\": \"fsefesfse<p>fsefsef</p>\", \"en\": \"<p>fsefesfse</p><p>fsefsef</p>\", \"ru\": \"fsefesfse<p>fsefsef</p>\"}','[]',2,121,23,20,3,'qwe','[]','2020-06-14 20:19:00','2021-05-09 03:11:20'),(3,'{\"de\": \"das\", \"en\": \"das 23\", \"ru\": \"das\"}','das','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','[\"/uploaded/2021-01-24/b6a7c4bc88a3b25b0b186d671ec20362.png\", \"/uploaded/2021-01-24/315184c21ef85a3b40d8cc72c7f26978.png\"]',3,123,18,50,14,'qqwdqwd','[\"2\"]','2020-08-31 15:48:00','2021-05-09 03:05:26');
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
INSERT INTO `product_brand` VALUES (1,'Brand 1','brand-1','','2020-06-14 17:24:44','2020-06-14 17:24:44'),(2,'Brand 2','brand-2','','2020-06-14 17:24:00','2021-03-28 23:41:45'),(3,'Brand 3','brand-3','/uploads/images/logo.png','2020-06-14 17:24:00','2021-03-09 15:18:38');
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
  `expanded` tinyint(1) NOT NULL DEFAULT '1',
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
INSERT INTO `product_category` VALUES (1,1,1,10,0,0,'{\"de\": \"Root\", \"en\": \"Root\", \"ru\": \"Корень\"}','',NULL,'null','2020-09-12 15:00:00','2020-09-12 15:00:00'),(120,1,2,5,1,1,'{\"de\": \"Cat 1\", \"en\": \"Cat 1\", \"ru\": \"Cat 1\"}','cat-1','/uploads/media/svg_image.svg','{\"de\": \"dawda<p>da</p>\", \"en\": \"<p>dawda</p><p>da</p>\", \"ru\": \"dawda<p>da</p>\"}','2020-09-12 15:00:00','2021-05-09 02:51:12'),(121,1,6,7,1,1,'{\"de\": \"Cat 2\", \"en\": \"Cat 2\", \"ru\": \"Cat 2\"}','cat-2','','{\"de\": \"fsefs<p>efsefs</p>\", \"en\": \"fsefs<p>efsefs</p>\", \"ru\": \"fsefs<p>efsefs</p>\"}','2020-09-12 15:00:00','2021-05-09 02:51:25'),(122,1,8,9,1,1,'{\"de\": \"Cat 3\", \"en\": \"Cat 3\", \"ru\": \"Cat 3\"}','cat-3','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-06-10 16:28:33'),(123,1,3,4,2,1,'{\"de\": \"Cat 1-1\", \"en\": \"Cat 1-1\", \"ru\": \"Cat 1-1\"}','cat-1-1','','{\"de\": \"\", \"en\": \"\", \"ru\": \"\"}','2020-09-12 15:00:00','2021-02-03 19:52:28');
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
INSERT INTO `product_category_ref` VALUES (3,123),(3,122),(2,120),(2,123);
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
INSERT INTO `product_option_ref` VALUES (3,1),(3,3),(3,5),(3,10),(3,9);
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
  `view_filter` tinyint(1) NOT NULL DEFAULT '0',
  `view_compare` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `view_filter` (`view_filter`) USING BTREE,
  KEY `view_compare` (`view_compare`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specification`
--

LOCK TABLES `product_specification` WRITE;
/*!40000 ALTER TABLE `product_specification` DISABLE KEYS */;
INSERT INTO `product_specification` VALUES (1,'{\"de\": \"Attr 1\", \"en\": \"Attr 1\", \"ru\": \"Attr 1\"}',1,0,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(2,'{\"de\": \"Attr 2\", \"en\": \"Attr 2\", \"ru\": \"Attr 2\"}',1,1,'2020-09-12 15:00:00','2020-09-12 15:00:00'),(3,'{\"de\": \"Attr 3\", \"en\": \"Attr 3\", \"ru\": \"Attr 3\"}',0,0,'2020-09-12 15:00:00','2021-02-08 21:19:22');
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
INSERT INTO `product_specification_option` VALUES (1,1,'{\"de\": \"Opt 1 de\", \"en\": \"Opt 1 en\", \"ru\": \"Opt 1 ru\"}',0),(2,1,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(3,1,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(4,2,'{\"de\": \"Opt 1\", \"en\": \"Opt 1\", \"ru\": \"Opt 1\"}',0),(5,2,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(6,2,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(7,3,'{\"de\": \"Opt 1\", \"en\": \"Opt 1\", \"ru\": \"Opt 1\"}',0),(8,3,'{\"de\": \"Opt 2\", \"en\": \"Opt 2\", \"ru\": \"Opt 2\"}',1),(9,3,'{\"de\": \"Opt 3\", \"en\": \"Opt 3\", \"ru\": \"Opt 3\"}',2),(10,3,'{\"de\": \"Opt 4\", \"en\": \"Opt 4\", \"ru\": \"Opt 4\"}',3);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variation`
--

LOCK TABLES `product_variation` WRITE;
/*!40000 ALTER TABLE `product_variation` DISABLE KEYS */;
INSERT INTO `product_variation` VALUES (9,3,'{\"en\": \"qwe\", \"ru\": \"qwe\"}',18,50,14,'qqwdqwd','[\"/uploaded/2021-03-31/083783da3d497411fd0f404cf250f840.png\", \"/uploaded/2021-03-31/2d9a0b9339236b6b457980adb2be78a7.png\"]',0);
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
  `lang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_class` (`model_class`,`model_id`,`lang`)
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo_meta`
--

LOCK TABLES `seo_meta` WRITE;
/*!40000 ALTER TABLE `seo_meta` DISABLE KEYS */;
INSERT INTO `seo_meta` VALUES (36,'Staticpage',16,'en','{\"head\": \"<meta property=\\\"page\\\" value=\\\"456\\\">\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(368,'Blog',8,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(373,'SeoMeta',373,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(374,'ProductBrand',3,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(375,'Blog',2,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(376,'Product',3,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(377,'Product',2,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(378,'ProductBrand',2,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(379,'ProductCategory',120,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(380,'BlogCategory',3,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}'),(381,'ProductCategory',122,'en','{\"head\": \"\", \"body_top\": \"\", \"body_bottom\": \"\"}');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticpage`
--

LOCK TABLES `staticpage` WRITE;
/*!40000 ALTER TABLE `staticpage` DISABLE KEYS */;
INSERT INTO `staticpage` VALUES (16,'home','Home','site/index',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticpage_block`
--

LOCK TABLES `staticpage_block` WRITE;
/*!40000 ALTER TABLE `staticpage_block` DISABLE KEYS */;
INSERT INTO `staticpage_block` VALUES (45,16,'title','Title','\"qwe\"','text_input','[]',0,'First',0),(46,16,'description','Description','{\"en\": \"<p>qweq we</p>\"}','text_editor','[]',0,'First',1);
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
INSERT INTO `system_language` VALUES (1,'English','en','/uploads/media/flags/gb.png',1,1,'2019-12-26 06:14:00','2021-02-28 16:34:58'),(2,'Russian','ru','/uploads/media/flags/ru.png',1,0,'2020-11-29 06:56:09','2020-11-29 06:56:09'),(4,'German','de','/uploads/media/flags/de.png',1,0,'2021-05-09 04:03:55','2021-05-09 04:03:55');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (3,'site_name','Site name','SpeedRunner CMS','text_input',0),(6,'site_logo','Logo','/uploads/logo.svg','file_manager',1),(7,'admin_email','Email','admin@localhost.loc','text_input',4),(10,'delete_model_file','Delete file after removing record','1','checkbox',5),(11,'site_favicon','Favicon','/uploads/logo.svg','file_manager',2),(12,'image_placeholder','Placeholder for images','/uploads/placeholder-image.png','file_manager',3);
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
INSERT INTO `translation_message` VALUES (1,'de',''),(1,'en','ID'),(1,'ru','ID'),(2,'de',''),(2,'en','Username'),(2,'ru','Логин'),(3,'de',''),(3,'en','Role'),(3,'ru','Роль'),(4,'de',''),(4,'en','Email'),(4,'ru','Email'),(5,'de',''),(5,'en','New password'),(5,'ru','Новый пароль'),(6,'de',''),(6,'en','Theme'),(6,'ru','Тема'),(7,'de',''),(7,'en','Font'),(7,'ru','Шрифт'),(8,'de',''),(8,'en','Border radius'),(8,'ru','Радиус границ'),(9,'de',''),(9,'en','Full name'),(9,'ru','Ф.И.О.'),(10,'de',''),(10,'en','Phone'),(10,'ru','Телефон'),(11,'de',''),(11,'en','Address'),(11,'ru','Адрес'),(12,'de',''),(12,'en','Image'),(12,'ru','Изображение'),(13,'en','Created'),(13,'ru','Создано'),(14,'en','Updated'),(14,'ru','Изменено'),(15,'de',''),(15,'en','Users'),(15,'ru','Пользователи'),(16,'de',''),(16,'en','Create'),(16,'ru','Создание'),(17,'en','Admin'),(17,'ru','Администратор'),(18,'en','Registered'),(18,'ru','Зарегистрированный'),(19,'de',''),(19,'en','Delete all'),(19,'ru','Удалить все'),(20,'de',''),(20,'en','Are you sure?'),(20,'ru','Вы уверены?'),(21,'de',''),(21,'en','RBAC'),(21,'ru','Менеджер ролей'),(22,'de',''),(22,'en','Static pages'),(22,'ru','Статичные страницы'),(23,'de',''),(23,'en','Content'),(23,'ru','Контент'),(24,'de',''),(24,'en','Menu'),(24,'ru','Меню'),(25,'de',''),(25,'en','Pages'),(25,'ru','Страницы'),(26,'de',''),(26,'en','Banners'),(26,'ru','Баннеры'),(27,'de',''),(27,'en','Blocks'),(27,'ru','Блоки'),(28,'de',''),(28,'en','Types'),(28,'ru','Типы'),(29,'de',''),(29,'en','Blogs'),(29,'ru','Блоги'),(30,'de',''),(30,'en','Categories'),(30,'ru','Категории'),(31,'de',''),(31,'en','Tags'),(31,'ru','Теги'),(32,'de',''),(32,'en','Comments'),(32,'ru','Комментарии'),(33,'de',''),(33,'en','Rates'),(33,'ru','Оценки'),(34,'de',''),(34,'en','Products'),(34,'ru','Продукты'),(35,'de',''),(35,'en','Brands'),(35,'ru','Бренды'),(36,'de',''),(36,'en','Specifications'),(36,'ru','Характеристики'),(37,'de',''),(37,'en','Orders'),(37,'ru','Заказы'),(38,'de',''),(38,'en','System'),(38,'ru','Система'),(39,'de',''),(39,'en','Settings'),(39,'ru','Настройки'),(40,'de',''),(40,'en','Languages'),(40,'ru','Языки'),(41,'de',''),(41,'en','Translations'),(41,'ru','Переводы'),(42,'de',''),(42,'en','Log actions'),(42,'ru','Лог действий'),(43,'de',''),(43,'en','Cache'),(43,'ru','Кэш'),(44,'de',''),(44,'en','Remove thumbs'),(44,'ru','Удалить миниатюры'),(45,'de',''),(45,'en','Clear'),(45,'ru','Очистить'),(46,'en','Speedrunner'),(46,'ru','Speedrunner'),(47,'de',''),(47,'en','Information'),(47,'ru','Информация'),(48,'de',''),(48,'en','Functions'),(48,'ru','Функции'),(49,'en','Change password'),(49,'ru','Сменить пароль'),(50,'de',''),(50,'en','Logout'),(50,'ru','Выйти'),(51,'de',''),(51,'en','No notifications'),(51,'ru','Нет уведомлений'),(52,'de',''),(52,'en','Bookmarks'),(52,'ru','Вкладки'),(53,'de',''),(53,'en','Add'),(53,'ru','Добавление'),(54,'de',''),(54,'en','Home'),(54,'ru','Главная'),(55,'en','RBAC'),(55,'ru','Менеджер ролей'),(56,'en','Routes'),(56,'ru','Маршруты'),(57,'en','Rules'),(57,'ru','Правила'),(58,'en','Roles'),(58,'ru','Роли'),(59,'en','Assignments'),(59,'ru','Привязки'),(60,'en','Permissions'),(60,'ru','Права'),(61,'en','Static page: {label}'),(61,'ru','Статичная страница: {label}'),(62,'de',''),(62,'en','Save'),(62,'ru','Сохранить'),(63,'de',''),(63,'en','SEO meta'),(63,'ru','SEO мета'),(64,'de',''),(64,'en','Name'),(64,'ru','Название'),(65,'en','Label'),(65,'ru','Лейбл'),(66,'en','Value'),(66,'ru','Значение'),(67,'en','Type'),(67,'ru','Тип'),(68,'en','Browse'),(68,'ru','Просмотр'),(69,'en','Error'),(69,'ru','Ошибка'),(70,'en','Tree'),(70,'ru','Дерево'),(71,'en','Search'),(71,'ru','Поиск'),(72,'en','Left'),(72,'ru','Слева'),(73,'en','Right'),(73,'ru','Справа'),(74,'en','Depth'),(74,'ru','Глубина'),(75,'en','Expanded'),(75,'ru','Развёрнуто'),(76,'en','Url'),(76,'ru','Ссылка'),(77,'en','Parent'),(77,'ru','Родитель'),(78,'de',''),(78,'en','Slug'),(78,'ru','Ссылка'),(79,'en','Description'),(79,'ru','Описание'),(80,'en','Location'),(80,'ru','Локация'),(81,'en','Groups'),(81,'ru','Группы'),(82,'en','Slider home'),(82,'ru','Слайдер на главной странице'),(83,'en','Slider about'),(83,'ru','Слайдер на странице \"о компании\"'),(84,'en','Save & reload'),(84,'ru','Сохранить и перезагрузить'),(85,'en','Profile'),(85,'ru','Профиль'),(86,'en','Design'),(86,'ru','Дизайн'),(87,'en','Field must contain only alphabet and numerical chars'),(87,'ru','Поле должно содержать только буквы и цифры'),(88,'en','Full menu'),(88,'ru','Полное меню'),(89,'en','Left menu'),(89,'ru','Меню слева'),(94,'en','Routes'),(94,'ru','Маршруты'),(95,'en','Refresh'),(95,'ru','Обновить'),(96,'en','Search for available'),(96,'ru','Поиск доступных'),(97,'en','Include'),(97,'ru','Включить'),(98,'en','Assign'),(98,'ru','Привязка'),(99,'en','Exclude'),(99,'ru','Исключить'),(100,'en','Remove'),(100,'ru','Удаление'),(101,'en','Search for assigned'),(101,'ru','Поиск привязок'),(102,'en','Rules'),(102,'ru','Правила'),(103,'en','Create'),(103,'ru','Создание'),(104,'en','Name'),(104,'ru','Название'),(105,'en','Roles'),(105,'ru','Роли'),(106,'en','Rule name'),(106,'ru','Название правила'),(107,'en','Select rule'),(107,'ru','Выберите правило'),(108,'en','Description'),(108,'ru','Описание'),(109,'en','Assignments'),(109,'ru','Привязки'),(110,'en','Permissions'),(110,'ru','Права'),(111,'en','General'),(111,'ru','Основной'),(112,'en','Class name'),(112,'ru','Название класса'),(113,'en','Update: {name}'),(113,'ru','Редактирование: {name}'),(114,'en','View: {name}'),(114,'ru','Отображение: {name}'),(115,'en','Assignment'),(115,'ru','Привязка'),(116,'en','Type'),(116,'ru','Тип'),(117,'en','Data'),(117,'ru','Данные'),(118,'en','Assignment: {username}'),(118,'ru','Привязка: {username}'),(119,'en','Record has been saved'),(119,'ru','Запись сохранена'),(120,'en','Delete'),(120,'ru','Удалить'),(121,'en','Delete with children'),(121,'ru','Удалить с дочерними'),(122,'en','Record has been deleted'),(122,'ru','Запись удалена'),(123,'en','Banner'),(123,'ru','Баннер'),(124,'en','Text 1'),(124,'ru','Текст 1'),(125,'en','Text 2'),(125,'ru','Текст 2'),(126,'en','Text 3'),(126,'ru','Текст 3'),(127,'en','Link'),(127,'ru','Ссылка'),(128,'en','Has translation'),(128,'ru','Имеется перевод'),(129,'en','Block types'),(129,'ru','Блочные типы'),(130,'en','Block pages'),(130,'ru','Блочные страницы'),(131,'en','Assign'),(131,'ru','Привязка'),(132,'de',''),(132,'en','Category'),(132,'ru','Категория'),(135,'de',''),(135,'en','Images'),(135,'ru','Изображения'),(136,'en','Published'),(136,'ru','Опубликовано'),(137,'en','Blog categories'),(137,'ru','Категории блогов'),(138,'en','Blog tags'),(138,'ru','Теги блогов'),(139,'en','Blog'),(139,'ru','Блог'),(140,'en','User'),(140,'ru','Пользователь'),(141,'en','Text'),(141,'ru','Текст'),(142,'en','Status'),(142,'ru','Статус'),(143,'en','Blog comments'),(143,'ru','Комментарии к блогам'),(144,'en','New'),(144,'ru','Новый'),(145,'en','Mark'),(145,'ru','Оценка'),(146,'en','Blog rates'),(146,'ru','Оценки блогов'),(147,'en','Update: {label}'),(147,'ru','Редактирование: {label}'),(148,'en','Used'),(148,'ru','Использовано'),(149,'en','Assign: {name}'),(149,'ru','Привязка: {name}'),(150,'en','Page'),(150,'ru','Страница'),(151,'en','Comments & rates: {name}'),(151,'ru','Комментарии и оценки: {name}'),(152,'en','Comment: {id}'),(152,'ru','Комментарий: {id}'),(153,'en','Brand'),(153,'ru','Бренд'),(154,'en','Main category'),(154,'ru','Главная категория'),(155,'en','Price'),(155,'ru','Цена'),(156,'en','Discount'),(156,'ru','Скидка'),(157,'en','Quantity'),(157,'ru','Количество'),(158,'en','SKU'),(158,'ru','Артикул'),(159,'en','Options'),(159,'ru','Опции'),(160,'en','Related'),(160,'ru','Сопутствующие'),(161,'en','Variations'),(161,'ru','Вариации'),(162,'en','Total price'),(162,'ru','Итоговая стоимость'),(163,'en','Product categories'),(163,'ru','Категории продуктов'),(164,'en','Product brands'),(164,'ru','Бренды продуктов'),(165,'en','Product'),(165,'ru','Продукт'),(166,'en','Products comments'),(166,'ru','Комментарии к продуктам'),(167,'en','Product rates'),(167,'ru','Оценки продуктов'),(168,'en','E-mail'),(168,'ru','E-mail'),(169,'en','Delivery type'),(169,'ru','Тип доставки'),(170,'en','Payment type'),(170,'ru','Тип оплаты'),(171,'en','Total quantity'),(171,'ru','Общее количество'),(172,'en','Delivery price'),(172,'ru','Стоимость доставки'),(173,'en','Key'),(173,'ru','Ключ'),(174,'en','Pickup'),(174,'ru','Самовывоз'),(175,'en','Delivery'),(175,'ru','Доставка'),(176,'en','Cash'),(176,'ru','Наличные'),(177,'en','Bank card'),(177,'ru','Банковская карта'),(178,'en','Confirmed'),(178,'ru','Подтверждено'),(179,'en','Payed'),(179,'ru','Оплачено'),(180,'en','Completed'),(180,'ru','Завершено'),(181,'en','Canceled'),(181,'ru','Отменено'),(182,'en','Stock'),(182,'ru','Склад'),(183,'en','Categories & Specifications'),(183,'ru','Категории и характеристики'),(184,'en','Specification'),(184,'ru','Характеристика'),(185,'en','Option'),(185,'ru','Опция'),(186,'en','Use in filter'),(186,'ru','Использовать в фильтре'),(187,'en','Use in compare'),(187,'ru','Использовать при сравнении'),(188,'en','Use in detail page'),(188,'ru','Использовать в детальной странице'),(189,'en','Product specifications'),(189,'ru','Характеристики продуктов'),(190,'en','Checkout price'),(190,'ru','Сумма к оплате'),(191,'en','Order №{order_id}'),(191,'ru','Заказ №{order_id}'),(192,'en','View: {id}'),(192,'ru','Отображение: {id}'),(193,'en','Total'),(193,'ru','Итого'),(194,'en','Person'),(194,'ru','Человек'),(195,'en','Order'),(195,'ru','Заказ'),(196,'en','Products price: {price} сум'),(196,'ru','Цена за продукцию: {price} сум'),(197,'en','Delivery price: {price} сум'),(197,'ru','Стоимость доставки: {price} сум'),(198,'en','Total price: {price} сум'),(198,'ru','Итоговая цена: {price} сум'),(199,'en','System settings'),(199,'ru','Системные настройки'),(200,'en','Code'),(200,'ru','Код'),(201,'en','Active'),(201,'ru','Активный'),(202,'en','Main'),(202,'ru','Главный'),(203,'en','System languages'),(203,'ru','Системные языки'),(204,'en','Action'),(204,'ru','Действие'),(205,'en','Old value'),(205,'ru','Старое значение'),(206,'en','New value'),(206,'ru','Новое значение'),(207,'en','Deleted'),(207,'ru','Удалено'),(208,'en','View'),(208,'ru','Отображение'),(209,'en','Process has been completed'),(209,'ru','Процесс завершён'),(210,'en','Message'),(210,'ru','Сообщение'),(211,'en','Translation sources'),(211,'ru','Исходники переводов'),(212,'en','Log actions #{id}'),(212,'ru','Лог действий #{id}'),(213,'en','Update: {message}'),(213,'ru','Редактирование: {message}'),(229,'en','Sign in'),(229,'ru','Авторизация'),(230,'en','Password'),(230,'ru','Пароль'),(231,'en','Remember me'),(231,'ru','Запомнить меня'),(232,'en','{attribute} is incorrect'),(232,'ru','{attribute} заполнен неверно'),(233,'en','Model class'),(233,'ru','Класс модели'),(234,'en','Model ID'),(234,'ru','ID модели'),(235,'en','Language'),(235,'ru','Язык'),(236,'en','Update: {username}'),(236,'ru','Редактирование: {username}'),(237,'en','This username has already been taken'),(237,'ru','Данный логин уже занят'),(238,'en','This email has already been taken'),(238,'ru','Данный email уже занят'),(239,'en','There is no user with this email address'),(239,'ru','Пользователь с данным email адресом не найден'),(240,'en','Login'),(240,'ru','Авторизация'),(241,'en','Password changing'),(241,'ru','Изменение пароля'),(242,'de',''),(242,'en','Update'),(242,'ru','Редактирование'),(243,'en','System translations'),(243,'ru','Системные переводы'),(244,'de',''),(244,'en','Short description'),(244,'ru','Краткое описание'),(245,'de',''),(245,'en','Full description'),(245,'ru','Полное описание'),(246,'en','Sku'),(246,'ru','Артикул'),(247,'en','Submit'),(247,'ru','Отправить'),(248,'en','An error occurred'),(248,'ru','Произошла ошибка'),(249,'en','Update: {id}'),(249,'ru','Редактирование: {id}'),(268,'en','Update: {value}'),(268,'ru','Редактирование: {value}'),(269,'en','An error occurred'),(269,'ru','Произошла ошибка'),(270,'en','{length} symbols'),(270,'ru','{length} символов'),(311,'en','Save &amp; update'),(311,'ru','Сохранить и редактировать'),(395,'en',''),(395,'ru',''),(396,'en',''),(396,'ru',''),(397,'de',''),(397,'en',''),(397,'ru',''),(398,'de',''),(398,'en',''),(398,'ru',''),(399,'de',''),(399,'en',''),(399,'ru',''),(400,'de',''),(400,'en',''),(400,'ru',''),(401,'de',''),(401,'en',''),(401,'ru',''),(402,'de',''),(402,'en',''),(402,'ru',''),(403,'en',''),(403,'ru',''),(404,'en',''),(404,'ru',''),(405,'en',''),(405,'ru',''),(406,'en',''),(406,'ru',''),(407,'en',''),(407,'ru',''),(408,'en',''),(408,'ru',''),(409,'en',''),(409,'ru',''),(410,'en',''),(410,'ru',''),(411,'de',''),(411,'en',''),(411,'ru',''),(412,'de',''),(412,'en',''),(412,'ru',''),(413,'en',''),(413,'ru',''),(414,'en',''),(414,'ru',''),(415,'en',''),(415,'ru',''),(416,'en',''),(416,'ru',''),(417,'en',''),(417,'ru',''),(418,'en',''),(418,'ru',''),(419,'en',''),(419,'ru',''),(420,'en',''),(420,'ru',''),(421,'de',''),(421,'en',''),(421,'ru',''),(422,'de',''),(422,'en',''),(422,'ru',''),(423,'de',''),(423,'en',''),(423,'ru',''),(424,'de',''),(424,'en',''),(424,'ru',''),(425,'de',''),(425,'en',''),(425,'ru',''),(426,'de',''),(426,'en',''),(426,'ru',''),(427,'de',''),(427,'en',''),(427,'ru','');
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
) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translation_source`
--

LOCK TABLES `translation_source` WRITE;
/*!40000 ALTER TABLE `translation_source` DISABLE KEYS */;
INSERT INTO `translation_source` VALUES (1,'app','Id'),(2,'app','Username'),(3,'app','Role'),(4,'app','Email'),(5,'app','New password'),(6,'app','Theme'),(7,'app','Font'),(8,'app','Border radius'),(9,'app','Full name'),(10,'app','Phone'),(11,'app','Address'),(12,'app','Image'),(13,'app','Created'),(14,'app','Updated'),(15,'app','Users'),(16,'app','Create'),(17,'app','Admin'),(18,'app','Registered'),(19,'app','Delete all'),(20,'app','Are you sure?'),(21,'app','RBAC'),(22,'app','Static pages'),(23,'app','Content'),(24,'app','Menu'),(25,'app','Pages'),(26,'app','Banners'),(27,'app','Blocks'),(28,'app','Types'),(29,'app','Blogs'),(30,'app','Categories'),(31,'app','Tags'),(32,'app','Comments'),(33,'app','Rates'),(34,'app','Products'),(35,'app','Brands'),(36,'app','Specifications'),(37,'app','Orders'),(38,'app','System'),(39,'app','Settings'),(40,'app','Languages'),(41,'app','Translations'),(42,'app','Log actions'),(43,'app','Cache'),(44,'app','Remove thumbs'),(45,'app','Clear'),(46,'app','Speedrunner'),(47,'app','Information'),(48,'app','Functions'),(49,'app','Change password'),(50,'app','Logout'),(51,'app','No notifications'),(52,'app','Bookmarks'),(53,'app','Add'),(54,'app','Home'),(55,'yii2mod.rbac','RBAC'),(56,'app','Routes'),(57,'app','Rules'),(58,'app','Roles'),(59,'app','Assignments'),(60,'app','Permissions'),(61,'app','Static page: {label}'),(62,'app','Save'),(63,'app','SEO meta'),(64,'app','Name'),(65,'app','Label'),(66,'app','Value'),(67,'app','Type'),(68,'app','Browse'),(69,'app','Error'),(70,'app','Tree'),(71,'app','Search'),(72,'app','Lft'),(73,'app','Rgt'),(74,'app','Depth'),(75,'app','Expanded'),(76,'app','Url'),(77,'app','Parent'),(78,'app','Slug'),(79,'app','Description'),(80,'app','Location'),(81,'app','Groups'),(82,'app','Slider home'),(83,'app','Slider about'),(84,'app','Save & reload'),(85,'app','Profile'),(86,'app','Design'),(87,'app','Field must contain only alphabet and numerical chars'),(88,'app','Full menu'),(89,'app','Left menu'),(94,'yii2mod.rbac','Routes'),(95,'yii2mod.rbac','Refresh'),(96,'yii2mod.rbac','Search for available'),(97,'app','Include'),(98,'yii2mod.rbac','Assign'),(99,'app','Exclude'),(100,'yii2mod.rbac','Remove'),(101,'yii2mod.rbac','Search for assigned'),(102,'yii2mod.rbac','Rules'),(103,'yii2mod.rbac','Create'),(104,'yii2mod.rbac','Name'),(105,'yii2mod.rbac','Roles'),(106,'yii2mod.rbac','Rule Name'),(107,'yii2mod.rbac','Select Rule'),(108,'yii2mod.rbac','Description'),(109,'yii2mod.rbac','Assignments'),(110,'yii2mod.rbac','Permissions'),(111,'app','General'),(112,'yii2mod.rbac','Class Name'),(113,'app','Update: {name}'),(114,'app','View: {name}'),(115,'app','Assignment'),(116,'yii2mod.rbac','Type'),(117,'yii2mod.rbac','Data'),(118,'yii2mod.rbac','Assignment: {username}'),(119,'app','Record has been saved'),(120,'app','Delete'),(121,'app','Delete with children'),(122,'app','Record has been deleted'),(123,'app','Banner'),(124,'app','Text 1'),(125,'app','Text 2'),(126,'app','Text 3'),(127,'app','Link'),(128,'app','Has translation'),(129,'app','Block types'),(130,'app','Block pages'),(131,'app','Assign'),(132,'app','Category'),(135,'app','Images'),(136,'app','Published'),(137,'app','Blog categories'),(138,'app','Blog tags'),(139,'app','Blog'),(140,'app','User'),(141,'app','Text'),(142,'app','Status'),(143,'app','Blog comments'),(144,'app','New'),(145,'app','Mark'),(146,'app','Blog rates'),(147,'app','Update: {label}'),(148,'app','Used'),(149,'app','Assign: {name}'),(150,'app','Page'),(151,'app','Comments & rates: {name}'),(152,'app','Comment: {id}'),(153,'app','Brand'),(154,'app','Main category'),(155,'app','Price'),(156,'app','Discount'),(157,'app','Quantity'),(158,'app','SKU'),(159,'app','Options'),(160,'app','Related'),(161,'app','Variations'),(162,'app','Total price'),(163,'app','Product categories'),(164,'app','Product brands'),(165,'app','Product'),(166,'app','Products comments'),(167,'app','Product rates'),(168,'app','E-mail'),(169,'app','Delivery type'),(170,'app','Payment type'),(171,'app','Total quantity'),(172,'app','Delivery price'),(173,'app','Key'),(174,'app','Pickup'),(175,'app','Delivery'),(176,'app','Cash'),(177,'app','Bank card'),(178,'app','Confirmed'),(179,'app','Payed'),(180,'app','Completed'),(181,'app','Canceled'),(182,'app','Stock'),(183,'app','Categories & Specifications'),(184,'app','Specification'),(185,'app','Option'),(186,'app','Use in filter'),(187,'app','Use in compare'),(188,'app','Use in detail page'),(189,'app','Product specifications'),(190,'app','Checkout price'),(191,'app','Order №{order_id}'),(192,'app','View: {id}'),(193,'app','Total'),(194,'app','Person'),(195,'app','Order'),(196,'app','Products price: {price} сум'),(197,'app','Delivery price: {price} сум'),(198,'app','Total price: {price} сум'),(199,'app','System settings'),(200,'app','Code'),(201,'app','Active'),(202,'app','Main'),(203,'app','System languages'),(204,'app','Action'),(205,'app','Old value'),(206,'app','New value'),(207,'app','Deleted'),(208,'app','View'),(209,'app','Process has been completed'),(210,'app','Message'),(211,'app','Translation sources'),(212,'app','Log actions #{id}'),(213,'app','Update: {message}'),(229,'app','Sign in'),(230,'app','Password'),(231,'app','Remember me'),(232,'app','{attribute} is incorrect'),(233,'app','Model class'),(234,'app','Model id'),(235,'app','Language'),(236,'app','Update: {username}'),(237,'app','This username has already been taken'),(238,'app','This email has already been taken'),(239,'app','There is no user with this email address'),(240,'app','Login'),(241,'app','Password changing'),(242,'app','Update'),(243,'app','System translations'),(244,'app','Short description'),(245,'app','Full description'),(246,'app','Sku'),(247,'app','Submit'),(248,'app','An error occured'),(249,'app','Update: {id}'),(268,'app','Update: {value}'),(269,'app','An error occurred'),(270,'app','{length} symbols'),(311,'app','Save & update'),(395,'app','Import'),(396,'app','Export'),(397,'app','SEO'),(398,'app','Meta'),(399,'app','Files'),(400,'app','Created at'),(401,'app','Updated at'),(402,'app','Published at'),(403,'app','Values will be taken automatically from the first variation (if any)'),(404,'app','Variation: {value}'),(405,'app','Chackout price'),(406,'app','Online'),(407,'app_notification','You have new order'),(408,'app','Clear all'),(409,'app','Files update'),(410,'app','Files have been updated'),(411,'app','Show {quantity} records'),(412,'app','Actions'),(413,'app',NULL),(414,'app','Save & create'),(415,'app','One of these attributes is required: {value}'),(416,'app','Contact'),(417,'app_email','Feedback'),(418,'app','contact_success_alert'),(419,'app','Profile update'),(420,'app','Profile has been updated'),(421,'app',NULL),(422,'app','Variation'),(423,'app','File manager'),(424,'app','Parameter not found'),(425,'app','Input type'),(426,'app','View in filter'),(427,'app','View in compare');
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
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@local.host','admin','/uploaded/profile/2021-03-28/50fdbc8a477209ef2065a019122e7feb.png','UCulO9_kZAeG3HXhoatTjNuO4TegI2cX','$2y$13$NWy1SYbvEvRvTY8hiNtb3.inOPW9ELPTupFlbT9W7oIEWsTeVfwDC',NULL,'2020-02-21 04:58:00','2021-05-14 05:14:02');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_design`
--

DROP TABLE IF EXISTS `user_design`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_design` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `design_theme` enum('nav_left','nav_full') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nav_left',
  `design_font` enum('roboto','oswald','montserrat','ibm_plex_sans') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'roboto',
  `design_border_radius` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_design_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_design`
--

LOCK TABLES `user_design` WRITE;
/*!40000 ALTER TABLE `user_design` DISABLE KEYS */;
INSERT INTO `user_design` VALUES (1,1,'nav_left','oswald',0);
/*!40000 ALTER TABLE `user_design` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (4,1,'Administrator','123 22','addr awd');
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-10 23:58:46
