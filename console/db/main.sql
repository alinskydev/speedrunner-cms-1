-- MySQL dump 10.13  Distrib 5.6.38, for Win32 (AMD64)
--
-- Host: localhost    Database: yii2
-- ------------------------------------------------------
-- Server version	5.6.38

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
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Banner`
--

LOCK TABLES `Banner` WRITE;
/*!40000 ALTER TABLE `Banner` DISABLE KEYS */;
INSERT INTO `Banner` VALUES (2,'r','slider_home','2019-09-22 10:30:32','2019-09-22 07:58:46'),(3,'qwe','slider_about','2019-09-22 10:30:00','2020-06-08 20:55:55');
/*!40000 ALTER TABLE `Banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BannerImage`
--

DROP TABLE IF EXISTS `BannerImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BannerImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BannerImage`
--

LOCK TABLES `BannerImage` WRITE;
/*!40000 ALTER TABLE `BannerImage` DISABLE KEYS */;
INSERT INTO `BannerImage` VALUES (1,2,'/uploads/media/svg.svg',0),(3,2,'/uploads/images/user2-160x160.png',1),(6,2,'/uploads/images/flags/ba.png',2),(16,3,'/uploads/media/jpg.jpg',0);
/*!40000 ALTER TABLE `BannerImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BannerImageTranslation`
--

DROP TABLE IF EXISTS `BannerImageTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BannerImageTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `text_1` varchar(1000) DEFAULT NULL,
  `text_2` varchar(1000) DEFAULT NULL,
  `text_3` varchar(1000) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BannerImageTranslation`
--

LOCK TABLES `BannerImageTranslation` WRITE;
/*!40000 ALTER TABLE `BannerImageTranslation` DISABLE KEYS */;
INSERT INTO `BannerImageTranslation` VALUES (1,1,'en','1','','',''),(2,1,'ru','','','',''),(3,1,'de','','','',''),(7,3,'en','2','','',''),(8,3,'ru','','','',''),(9,3,'de','','','',''),(16,6,'en','3','','',''),(17,6,'ru','7','','',''),(18,6,'de','7','','',''),(46,16,'en','w','','',''),(47,16,'ru','w','','',''),(48,16,'de','w','','','');
/*!40000 ALTER TABLE `BannerImageTranslation` ENABLE KEYS */;
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
  `value` text,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Block`
--

LOCK TABLES `Block` WRITE;
/*!40000 ALTER TABLE `Block` DISABLE KEYS */;
INSERT INTO `Block` VALUES (47,1,1,'',0),(48,1,5,'',3),(50,1,4,'',2),(51,1,8,'{\"1586669734849\":{\"title\":\"fsrfs\",\"short_description\":\"\",\"full_description\":\"\"}}',5),(52,1,2,'',6),(57,1,3,'',4),(59,1,7,'{\"1586668472275\":{\"title\":\"fwef\",\"description\":\"fwef\",\"image\":\"\\/uploads\\/images\\/flags\\/ad.png\"},\"1586668478275\":{\"title\":\"\",\"description\":\"\",\"image\":\"\\/uploads\\/images\\/logo.png\"}}',1);
/*!40000 ALTER TABLE `Block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockImage`
--

DROP TABLE IF EXISTS `BlockImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockImage`
--

LOCK TABLES `BlockImage` WRITE;
/*!40000 ALTER TABLE `BlockImage` DISABLE KEYS */;
/*!40000 ALTER TABLE `BlockImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockPage`
--

DROP TABLE IF EXISTS `BlockPage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockPage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockPage`
--

LOCK TABLES `BlockPage` WRITE;
/*!40000 ALTER TABLE `BlockPage` DISABLE KEYS */;
INSERT INTO `BlockPage` VALUES (1,'block-page-1','2019-03-12 17:36:00','2020-05-22 21:29:21');
/*!40000 ALTER TABLE `BlockPage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockPageTranslation`
--

DROP TABLE IF EXISTS `BlockPageTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockPageTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockPageTranslation`
--

LOCK TABLES `BlockPageTranslation` WRITE;
/*!40000 ALTER TABLE `BlockPageTranslation` DISABLE KEYS */;
INSERT INTO `BlockPageTranslation` VALUES (1,1,'en','Block page 1'),(2,1,'ru','Block page 1 ru'),(3,1,'de','Block page 1 de');
/*!40000 ALTER TABLE `BlockPageTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockTranslation`
--

DROP TABLE IF EXISTS `BlockTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockTranslation`
--

LOCK TABLES `BlockTranslation` WRITE;
/*!40000 ALTER TABLE `BlockTranslation` DISABLE KEYS */;
INSERT INTO `BlockTranslation` VALUES (64,47,'en',''),(66,50,'en',''),(67,51,'en','{\"1586669734849\":{\"title\":\"fsrfs\",\"short_description\":\"\",\"full_description\":\"\"}}'),(68,52,'en',''),(73,57,'en',''),(75,47,'ru',''),(77,50,'ru',''),(78,57,'ru',''),(79,51,'ru','{\"1586669734849\":{\"title\":\"dawd awd\",\"short_description\":\"\",\"full_description\":\"\"}}'),(80,52,'ru',''),(81,47,'de',''),(83,50,'de',''),(84,57,'de',''),(85,51,'de','null'),(86,52,'de','');
/*!40000 ALTER TABLE `BlockTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlockType`
--

DROP TABLE IF EXISTS `BlockType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlockType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `attrs` varchar(500) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `has_translation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlockType`
--

LOCK TABLES `BlockType` WRITE;
/*!40000 ALTER TABLE `BlockType` DISABLE KEYS */;
INSERT INTO `BlockType` VALUES (1,'title_1','Title 1','textInput',NULL,'/uploads/images/user2-160x160.png',1),(2,'title_2','Title 2','textInput',NULL,'/uploads/Blog/1537545068_77PEJQ.png',1),(3,'description_1','Description 1','CKEditor',NULL,'/uploads/Gallery/1539288264_17KLUj.png',1),(4,'description_2','Description 2','CKEditor',NULL,'/uploads/Blog/1538666020_R2Gs_A.png',1),(5,'images_1','Images 1','images',NULL,'',0),(6,'images_2','Images 2','images',NULL,'',0),(7,'groups_1','Groups 1','groups','{\"1575379517932\":{\"name\":\"title\",\"label\":\"Main title\",\"type\":\"textInput\"},\"1575379554951\":{\"name\":\"description\",\"label\":\"Main description\",\"type\":\"textArea\"},\"1575379559765\":{\"name\":\"image\",\"label\":\"Main image\",\"type\":\"ElFinder\"}}','',0),(8,'groups_2','Groups 2','groups','{\"1575379517932\":{\"name\":\"title\",\"label\":\"Another title\",\"type\":\"textInput\"},\"1575379554951\":{\"name\":\"short_description\",\"label\":\"Another short description\",\"type\":\"textArea\"},\"1575379559765\":{\"name\":\"full_description\",\"label\":\"Another full description\",\"type\":\"CKEditor\"}}','/uploads/media/jpg.jpg',1);
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
  `category_id` int(11) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `published` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blog`
--

LOCK TABLES `Blog` WRITE;
/*!40000 ALTER TABLE `Blog` DISABLE KEYS */;
INSERT INTO `Blog` VALUES (2,1,'blog-1-1','/uploads/Blog/1537547281_QKI6G9.png','2018-10-19 14:45:00','2018-10-15 15:13:00','2020-04-04 22:35:27'),(8,2,'rre-qwe','/uploads/images/editor/5bc44f0c699b4.png','2019-09-22 20:17:00','1970-01-01 03:00:00','2020-06-08 17:18:52');
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
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogCategory`
--

LOCK TABLES `BlogCategory` WRITE;
/*!40000 ALTER TABLE `BlogCategory` DISABLE KEYS */;
INSERT INTO `BlogCategory` VALUES (1,'cat-1','/uploads/Blog/1537547338_I9HiIO.png','2018-10-15 11:17:03','2018-10-30 10:37:03'),(2,'cat-2','','2018-10-15 11:17:06','2018-10-30 04:58:38'),(3,'cat-3','/uploads/media/image-1.png','2018-10-15 11:17:11','2019-11-28 10:31:51');
/*!40000 ALTER TABLE `BlogCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogCategoryTranslation`
--

DROP TABLE IF EXISTS `BlogCategoryTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogCategoryTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogCategoryTranslation`
--

LOCK TABLES `BlogCategoryTranslation` WRITE;
/*!40000 ALTER TABLE `BlogCategoryTranslation` DISABLE KEYS */;
INSERT INTO `BlogCategoryTranslation` VALUES (1,3,'en','cat 3',''),(2,3,'ru','cat 3',''),(3,3,'de','cat 1',NULL),(4,1,'en','cat 1','<p>qwdqwd</p>'),(5,1,'ru','cat 1',NULL),(6,1,'de','cat 1',NULL),(7,2,'en','cat 2','<p>qwd</p>'),(8,2,'ru','cat 2',NULL),(9,2,'de','cat 2',NULL);
/*!40000 ALTER TABLE `BlogCategoryTranslation` ENABLE KEYS */;
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
  `user_id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'new',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogComment`
--

LOCK TABLES `BlogComment` WRITE;
/*!40000 ALTER TABLE `BlogComment` DISABLE KEYS */;
INSERT INTO `BlogComment` VALUES (1,2,1,'eqwdq\r\ndqd','new','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `BlogComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogImage`
--

DROP TABLE IF EXISTS `BlogImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogImage`
--

LOCK TABLES `BlogImage` WRITE;
/*!40000 ALTER TABLE `BlogImage` DISABLE KEYS */;
INSERT INTO `BlogImage` VALUES (1,2,'/uploads/Blog/1559086459_m1WC9Y.png',0),(5,8,'/uploaded/1580265197_C6M4JrIf.png',1),(6,8,'/uploaded/9e-21SHG_1582258824.png',0);
/*!40000 ALTER TABLE `BlogImage` ENABLE KEYS */;
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
  `user_id` int(11) NOT NULL,
  `mark` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTag`
--

LOCK TABLES `BlogTag` WRITE;
/*!40000 ALTER TABLE `BlogTag` DISABLE KEYS */;
INSERT INTO `BlogTag` VALUES (4,'йцууй йу','0000-00-00 00:00:00'),(5,'уйцу','0000-00-00 00:00:00'),(6,'dqwd','0000-00-00 00:00:00'),(10,'vvcx','0000-00-00 00:00:00'),(12,'qw','0000-00-00 00:00:00'),(14,'2rr','0000-00-00 00:00:00'),(15,'1ferf','0000-00-00 00:00:00'),(16,'ferf4','0000-00-00 00:00:00'),(17,'ff3f3','0000-00-00 00:00:00'),(18,'wfw','0000-00-00 00:00:00'),(19,'wefz3','0000-00-00 00:00:00'),(20,'tag 1 en','0000-00-00 00:00:00'),(21,'tag 2 en','0000-00-00 00:00:00'),(22,'tag 1 ru','0000-00-00 00:00:00'),(23,'tag 2 ru','0000-00-00 00:00:00'),(24,'one','0000-00-00 00:00:00'),(25,'zzze','2019-03-17 16:59:56'),(26,'уйц','2019-04-07 16:23:57'),(27,'вфвф','2019-04-07 16:23:57'),(28,'eeee','2019-07-17 15:58:59'),(29,'awdwda','2019-09-27 18:49:17'),(30,'zczcdzc','2019-09-27 18:49:17');
/*!40000 ALTER TABLE `BlogTag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogTagRef`
--

DROP TABLE IF EXISTS `BlogTagRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogTagRef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTagRef`
--

LOCK TABLES `BlogTagRef` WRITE;
/*!40000 ALTER TABLE `BlogTagRef` DISABLE KEYS */;
INSERT INTO `BlogTagRef` VALUES (82,8,4,'en'),(83,8,6,'en'),(85,8,5,'ru');
/*!40000 ALTER TABLE `BlogTagRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogTranslation`
--

DROP TABLE IF EXISTS `BlogTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTranslation`
--

LOCK TABLES `BlogTranslation` WRITE;
/*!40000 ALTER TABLE `BlogTranslation` DISABLE KEYS */;
INSERT INTO `BlogTranslation` VALUES (4,2,'en','blog 1-1','<p>qwe</p>','<p>qwdq</p>'),(5,2,'ru','blog 1-1','<p>qwe</p>','<p>qwdq</p>'),(6,2,'de','blog 1-1','<p>qwe</p>','<p>qwdq</p>'),(22,8,'en','rre qwe w','dwdawd\r\nwdawd','<p>dqwdq wd qwd qwd qwd</p>'),(23,8,'ru','rre','',''),(24,8,'de','rre','','');
/*!40000 ALTER TABLE `BlogTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gallery`
--

DROP TABLE IF EXISTS `Gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gallery`
--

LOCK TABLES `Gallery` WRITE;
/*!40000 ALTER TABLE `Gallery` DISABLE KEYS */;
INSERT INTO `Gallery` VALUES (11,'Gallery','gallery','2019-12-26 06:30:00','2020-06-08 20:58:19');
/*!40000 ALTER TABLE `Gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GalleryImage`
--

DROP TABLE IF EXISTS `GalleryImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GalleryImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GalleryImage`
--

LOCK TABLES `GalleryImage` WRITE;
/*!40000 ALTER TABLE `GalleryImage` DISABLE KEYS */;
/*!40000 ALTER TABLE `GalleryImage` ENABLE KEYS */;
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
  `expanded` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tree` (`tree`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Menu`
--

LOCK TABLES `Menu` WRITE;
/*!40000 ALTER TABLE `Menu` DISABLE KEYS */;
INSERT INTO `Menu` VALUES (1,1,1,18,0,0),(2,1,2,7,1,1),(3,1,3,4,2,1),(4,1,5,6,2,1),(5,1,8,11,1,0),(6,1,9,10,2,0),(7,1,12,15,1,1),(8,1,13,14,2,0);
/*!40000 ALTER TABLE `Menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MenuTranslation`
--

DROP TABLE IF EXISTS `MenuTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MenuTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MenuTranslation`
--

LOCK TABLES `MenuTranslation` WRITE;
/*!40000 ALTER TABLE `MenuTranslation` DISABLE KEYS */;
INSERT INTO `MenuTranslation` VALUES (1,1,'en','Root',''),(2,1,'ru','Root',''),(3,1,'de','Root',''),(75,2,'en','1','/blog'),(76,2,'ru','1',''),(77,2,'de','1',''),(78,2,'en','1','/blog'),(79,3,'en','1-1',''),(80,3,'ru','1-1',''),(81,3,'de','1-1',''),(82,3,'en','1-1',''),(83,4,'en','1-2',''),(84,4,'ru','1-2',''),(85,4,'de','1-2',''),(86,4,'en','1-2',''),(87,5,'en','2',''),(88,5,'ru','2',''),(89,5,'de','2',''),(90,5,'en','2',''),(91,6,'en','2-1',''),(92,6,'ru','2-1',''),(93,6,'de','2-1',''),(94,6,'en','2-1',''),(95,7,'en','3',''),(96,7,'ru','3',''),(97,7,'de','3',''),(98,7,'en','3',''),(99,8,'en','3-1',''),(100,8,'ru','3-1',''),(101,8,'de','3-1',''),(102,8,'en','3-1','');
/*!40000 ALTER TABLE `MenuTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PageTranslation`
--

DROP TABLE IF EXISTS `PageTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PageTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PageTranslation`
--

LOCK TABLES `PageTranslation` WRITE;
/*!40000 ALTER TABLE `PageTranslation` DISABLE KEYS */;
/*!40000 ALTER TABLE `PageTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL,
  `main_category_id` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `sale` decimal(11,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `brand_id` (`brand_id`),
  KEY `main_category_id` (`main_category_id`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES (12,1,89,'obj-1',125.00,0.00,NULL,'',1,'2018-12-05 14:37:22','2019-09-25 17:52:02'),(13,2,118,'obj-2',212344.00,NULL,NULL,'',1,'2018-12-05 16:45:00','2020-05-22 18:37:48');
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductAttribute`
--

DROP TABLE IF EXISTS `ProductAttribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductAttribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `use_filter` tinyint(1) DEFAULT NULL,
  `use_compare` tinyint(1) DEFAULT NULL,
  `use_detail` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductAttribute`
--

LOCK TABLES `ProductAttribute` WRITE;
/*!40000 ALTER TABLE `ProductAttribute` DISABLE KEYS */;
INSERT INTO `ProductAttribute` VALUES (8,'attr_1','checkbox',0,1,1),(9,'attr_2','select',1,1,1),(10,'attr_4','select',1,1,0);
/*!40000 ALTER TABLE `ProductAttribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductAttributeOption`
--

DROP TABLE IF EXISTS `ProductAttributeOption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductAttributeOption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductAttributeOption`
--

LOCK TABLES `ProductAttributeOption` WRITE;
/*!40000 ALTER TABLE `ProductAttributeOption` DISABLE KEYS */;
INSERT INTO `ProductAttributeOption` VALUES (86,8,0),(88,8,1),(89,10,0),(90,10,1),(91,9,0),(92,9,1),(93,9,2);
/*!40000 ALTER TABLE `ProductAttributeOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductAttributeOptionTranslation`
--

DROP TABLE IF EXISTS `ProductAttributeOptionTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductAttributeOptionTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductAttributeOptionTranslation`
--

LOCK TABLES `ProductAttributeOptionTranslation` WRITE;
/*!40000 ALTER TABLE `ProductAttributeOptionTranslation` DISABLE KEYS */;
INSERT INTO `ProductAttributeOptionTranslation` VALUES (173,86,'en','111'),(174,86,'ru','222'),(175,86,'de','333'),(179,88,'en','444'),(180,88,'ru','555'),(181,88,'de','666'),(182,89,'en','dawdfref'),(183,89,'ru','dawd'),(184,89,'de',' awd a'),(185,90,'en','dwd'),(186,90,'ru','dwdw'),(187,90,'de','dd3d3'),(188,91,'en','dawd'),(189,91,'ru','wdawd'),(190,91,'de','awdaw'),(191,92,'en','adaw'),(192,92,'ru','dawda'),(193,92,'de','wdawd'),(194,93,'en','dawdawd'),(195,93,'ru','awdaw'),(196,93,'de','wda');
/*!40000 ALTER TABLE `ProductAttributeOptionTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductAttributeTranslation`
--

DROP TABLE IF EXISTS `ProductAttributeTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductAttributeTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductAttributeTranslation`
--

LOCK TABLES `ProductAttributeTranslation` WRITE;
/*!40000 ALTER TABLE `ProductAttributeTranslation` DISABLE KEYS */;
INSERT INTO `ProductAttributeTranslation` VALUES (16,8,'en','attr 1'),(17,8,'ru','attr 1'),(18,8,'de','attr 1'),(19,9,'en','attr 2'),(20,9,'ru','attr 2'),(21,9,'de','attr 2'),(22,10,'en','attr 4'),(23,10,'ru','attr 4'),(24,10,'de','attr 4');
/*!40000 ALTER TABLE `ProductAttributeTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductBrand`
--

DROP TABLE IF EXISTS `ProductBrand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductBrand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductBrand`
--

LOCK TABLES `ProductBrand` WRITE;
/*!40000 ALTER TABLE `ProductBrand` DISABLE KEYS */;
INSERT INTO `ProductBrand` VALUES (1,'brand-1','/uploads/Gallery/1539288264_17KLUj.png','0000-00-00 00:00:00','2019-02-23 17:32:32'),(2,'brand-2','/uploads/Gallery/1539588385_CnNzFQ.png','0000-00-00 00:00:00','2019-02-23 17:32:30'),(3,'brand-3','/uploads/Gallery/1539588385_UiDKI5.png','0000-00-00 00:00:00','2019-02-23 17:32:28');
/*!40000 ALTER TABLE `ProductBrand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductBrandTranslation`
--

DROP TABLE IF EXISTS `ProductBrandTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductBrandTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductBrandTranslation`
--

LOCK TABLES `ProductBrandTranslation` WRITE;
/*!40000 ALTER TABLE `ProductBrandTranslation` DISABLE KEYS */;
INSERT INTO `ProductBrandTranslation` VALUES (1,1,'en','brand 1 en',''),(2,1,'ru','brand 1 ru',''),(3,1,'de','brand 1 de',''),(4,2,'en','brand 2','<p>qweqwe</p><p>eqw</p>'),(5,2,'ru','brand 2','<p>qweqwe</p><p>eqw</p>'),(6,2,'de','brand 2','<p>qweqwe</p><p>eqw</p>'),(7,3,'en','brand 3','<p>wqd</p>'),(8,3,'ru','brand 3',''),(9,3,'de','brand 3','');
/*!40000 ALTER TABLE `ProductBrandTranslation` ENABLE KEYS */;
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
  `expanded` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(100) DEFAULT NULL,
  `full_url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `full_url` (`full_url`),
  KEY `tree` (`tree`),
  KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategory`
--

LOCK TABLES `ProductCategory` WRITE;
/*!40000 ALTER TABLE `ProductCategory` DISABLE KEYS */;
INSERT INTO `ProductCategory` VALUES (1,1,1,14,0,0,'',NULL,NULL),(88,1,4,11,1,1,'cat-1','cat-1',''),(89,1,12,13,1,0,'cat-2','cat-2',''),(101,1,5,8,2,1,'cat-1-1','cat-1/cat-1-1',''),(102,1,9,10,2,1,'cat-1-2','cat-1/cat-1-2',''),(118,1,6,7,3,1,'cat-1-1-1','cat-1/cat-1-1/cat-1-1-1','');
/*!40000 ALTER TABLE `ProductCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategoryAttributeRef`
--

DROP TABLE IF EXISTS `ProductCategoryAttributeRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategoryAttributeRef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategoryAttributeRef`
--

LOCK TABLES `ProductCategoryAttributeRef` WRITE;
/*!40000 ALTER TABLE `ProductCategoryAttributeRef` DISABLE KEYS */;
INSERT INTO `ProductCategoryAttributeRef` VALUES (31,66,8),(32,66,9),(33,118,8),(34,118,9);
/*!40000 ALTER TABLE `ProductCategoryAttributeRef` ENABLE KEYS */;
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
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategoryRef`
--

LOCK TABLES `ProductCategoryRef` WRITE;
/*!40000 ALTER TABLE `ProductCategoryRef` DISABLE KEYS */;
INSERT INTO `ProductCategoryRef` VALUES (46,19,64),(51,20,64),(56,21,64),(61,22,64),(66,23,64),(71,24,64),(76,25,64),(81,26,64),(91,28,64),(110,13,66),(118,13,62),(122,12,63),(124,12,62),(128,12,89),(132,12,101),(133,12,102),(139,13,118),(141,13,101),(142,13,89);
/*!40000 ALTER TABLE `ProductCategoryRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductCategoryTranslation`
--

DROP TABLE IF EXISTS `ProductCategoryTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategoryTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductCategoryTranslation`
--

LOCK TABLES `ProductCategoryTranslation` WRITE;
/*!40000 ALTER TABLE `ProductCategoryTranslation` DISABLE KEYS */;
INSERT INTO `ProductCategoryTranslation` VALUES (1,1,'en','Root',''),(2,1,'ru','Root',''),(3,1,'de','Root',''),(153,88,'en','cat 1',''),(154,88,'ru','cat 1',''),(155,88,'de','cat 1',''),(156,89,'en','cat 2',''),(157,89,'ru','cat 2',''),(158,89,'de','cat 2',''),(192,101,'en','cat 1-1',''),(193,101,'ru','cat 1-1',''),(194,101,'de','cat 1-1',''),(195,102,'en','cat 1-2',''),(196,102,'ru','cat 1-2',''),(197,102,'de','cat 1-2',''),(207,118,'en','cat 1-1-1',''),(208,118,'ru','cat 1-1-1',''),(209,118,'de','cat 1-1-1','');
/*!40000 ALTER TABLE `ProductCategoryTranslation` ENABLE KEYS */;
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
  `user_id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'new',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductComment`
--

LOCK TABLES `ProductComment` WRITE;
/*!40000 ALTER TABLE `ProductComment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductImage`
--

DROP TABLE IF EXISTS `ProductImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductImage`
--

LOCK TABLES `ProductImage` WRITE;
/*!40000 ALTER TABLE `ProductImage` DISABLE KEYS */;
INSERT INTO `ProductImage` VALUES (13,12,'/uploads/Product/1544954748_mgyI22.png',0),(15,12,'/uploads/Product/1544954748_vvgcJg.png',2),(17,13,'/uploaded/1577331277_HeEijG4N.png',1);
/*!40000 ALTER TABLE `ProductImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductOptionRef`
--

DROP TABLE IF EXISTS `ProductOptionRef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductOptionRef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `option_id` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductOptionRef`
--

LOCK TABLES `ProductOptionRef` WRITE;
/*!40000 ALTER TABLE `ProductOptionRef` DISABLE KEYS */;
INSERT INTO `ProductOptionRef` VALUES (4,13,9,92),(7,13,8,0),(9,13,8,88);
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
  `user_id` int(11) NOT NULL,
  `mark` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `related_id` (`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductRelatedRef`
--

LOCK TABLES `ProductRelatedRef` WRITE;
/*!40000 ALTER TABLE `ProductRelatedRef` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductRelatedRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductTranslation`
--

DROP TABLE IF EXISTS `ProductTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductTranslation`
--

LOCK TABLES `ProductTranslation` WRITE;
/*!40000 ALTER TABLE `ProductTranslation` DISABLE KEYS */;
INSERT INTO `ProductTranslation` VALUES (28,12,'en','obj 1','<p>dqw</p>','<p>dqw</p>'),(29,12,'ru','obj 1','<p>dqw</p>','<p>dqw</p>'),(30,12,'de','obj 1','<p>dqw</p>','<p>dqw</p>'),(31,13,'en','obj 2 en','<p>dqw</p>',''),(32,13,'ru','obj 2 ru','<p>dqw</p>',''),(33,13,'de','obj 2','<p>dqw</p>','');
/*!40000 ALTER TABLE `ProductTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductVariation`
--

DROP TABLE IF EXISTS `ProductVariation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductVariation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductVariation`
--

LOCK TABLES `ProductVariation` WRITE;
/*!40000 ALTER TABLE `ProductVariation` DISABLE KEYS */;
INSERT INTO `ProductVariation` VALUES (22,12,8,88,11.00,'qwe'),(23,13,8,86,1231.00,'wqwqd');
/*!40000 ALTER TABLE `ProductVariation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductVariationImage`
--

DROP TABLE IF EXISTS `ProductVariationImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductVariationImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductVariationImage`
--

LOCK TABLES `ProductVariationImage` WRITE;
/*!40000 ALTER TABLE `ProductVariationImage` DISABLE KEYS */;
INSERT INTO `ProductVariationImage` VALUES (1,23,'/uploads/ProductVariation/1569599558_c6ENc0.png',0);
/*!40000 ALTER TABLE `ProductVariationImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SeoMeta`
--

DROP TABLE IF EXISTS `SeoMeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SeoMeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_class` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`),
  KEY `model_class` (`model_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SeoMeta`
--

LOCK TABLES `SeoMeta` WRITE;
/*!40000 ALTER TABLE `SeoMeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `SeoMeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticPage`
--

DROP TABLE IF EXISTS `StaticPage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticPage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `has_seo_meta` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticPage`
--

LOCK TABLES `StaticPage` WRITE;
/*!40000 ALTER TABLE `StaticPage` DISABLE KEYS */;
INSERT INTO `StaticPage` VALUES (10,'home',1),(11,'about',1);
/*!40000 ALTER TABLE `StaticPage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticPageBlock`
--

DROP TABLE IF EXISTS `StaticPageBlock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticPageBlock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` text,
  `type` varchar(100) NOT NULL,
  `attrs` varchar(500) DEFAULT NULL,
  `part_index` int(11) NOT NULL,
  `part_name` varchar(100) NOT NULL,
  `has_translation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticPageBlock`
--

LOCK TABLES `StaticPageBlock` WRITE;
/*!40000 ALTER TABLE `StaticPageBlock` DISABLE KEYS */;
INSERT INTO `StaticPageBlock` VALUES (5,10,'first_title','Title','fwfwwe s s2 ц','textInput',NULL,0,'First',1),(6,10,'first_image','Image','/uploads/media/Screenshot_3.png','ElFinder',NULL,0,'First',0),(7,10,'second_images','Images','','images',NULL,1,'Second',0),(8,10,'third_groups','Groups','{\"1586629157906\":{\"title\":\"qwe\",\"description\":\"<p>qwe<\\/p><p>qwe<\\/p>\",\"image\":\"\\/uploads\\/media\\/Screenshot_3.png\"},\"1586629169729\":{\"title\":\"asd\",\"description\":\"<p>asdasdadsar r <\\/p>\",\"image\":\"\\/uploads\\/images\\/logo.png\"}}','groups','{\"1575379517932\":{\"name\":\"title\",\"label\":\"Заголовок\",\"type\":\"textInput\"},\"1575379554951\":{\"name\":\"description\",\"label\":\"Описание\",\"type\":\"CKEditor\"},\"1575379559765\":{\"name\":\"image\",\"label\":\"Изображение\",\"type\":\"ElFinder\"}}',2,'Third',1),(9,11,'slider_title','Title',NULL,'textArea',NULL,0,'Slider',0),(10,11,'slider_groups','Images','null','groups','{\"1586660977313\":{\"name\":\"link\",\"label\":\"Link\",\"type\":\"textInput\"},\"1586660989322\":{\"name\":\"image\",\"label\":\"Image\",\"type\":\"ElFinder\"},\"1586660999229\":{\"name\":\"background\",\"label\":\"Background\",\"type\":\"ElFinder\"},\"1586661015777\":{\"name\":\"description\",\"label\":\"Short description\",\"type\":\"CKEditor\"},\"1586661031881\":{\"name\":\"is_visible\",\"label\":\"Is visible\",\"type\":\"checkbox\"}}',0,'Slider',1),(11,11,'about_description','Description',NULL,'CKEditor',NULL,1,'About',1);
/*!40000 ALTER TABLE `StaticPageBlock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticPageBlockImage`
--

DROP TABLE IF EXISTS `StaticPageBlockImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticPageBlockImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticPageBlockImage`
--

LOCK TABLES `StaticPageBlockImage` WRITE;
/*!40000 ALTER TABLE `StaticPageBlockImage` DISABLE KEYS */;
INSERT INTO `StaticPageBlockImage` VALUES (12,8,'',0),(13,7,'/uploaded/1586618404_zkiEiwpAg4jbhwCk.png',1),(15,7,'/uploaded/1586618404_zLPB-LtAZrI46K3i.png',0);
/*!40000 ALTER TABLE `StaticPageBlockImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticPageBlockTranslation`
--

DROP TABLE IF EXISTS `StaticPageBlockTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticPageBlockTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticPageBlockTranslation`
--

LOCK TABLES `StaticPageBlockTranslation` WRITE;
/*!40000 ALTER TABLE `StaticPageBlockTranslation` DISABLE KEYS */;
INSERT INTO `StaticPageBlockTranslation` VALUES (4,5,'en','fwfwwe s s2 ц'),(5,5,'ru','fsrfs'),(6,5,'de','vsrvs'),(7,6,'en',''),(8,7,'en',NULL),(9,8,'en','{\"1586629157906\":{\"title\":\"qwe\",\"description\":\"<p>qwe<\\/p><p>qwe<\\/p>\",\"image\":\"\\/uploads\\/media\\/Screenshot_3.png\"},\"1586629169729\":{\"title\":\"asd\",\"description\":\"<p>asdasdadsar r <\\/p>\",\"image\":\"\\/uploads\\/images\\/logo.png\"}}'),(10,8,'ru','null'),(11,8,'de','null'),(12,10,'en','null'),(13,11,'en',NULL);
/*!40000 ALTER TABLE `StaticPageBlockTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SystemLanguage`
--

DROP TABLE IF EXISTS `SystemLanguage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SystemLanguage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `weight` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SystemLanguage`
--

LOCK TABLES `SystemLanguage` WRITE;
/*!40000 ALTER TABLE `SystemLanguage` DISABLE KEYS */;
INSERT INTO `SystemLanguage` VALUES (1,'en','English','/uploads/images/flags/gb.png',1,1,'2019-12-26 01:14:43'),(2,'ru','Russian','/uploads/images/flags/ru.png',0,1,'2019-07-16 18:18:10'),(3,'de','German','/uploads/images/flags/de.png',0,1,'2020-04-04 17:34:02');
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
  `name` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` varchar(1000) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SystemSettings`
--

LOCK TABLES `SystemSettings` WRITE;
/*!40000 ALTER TABLE `SystemSettings` DISABLE KEYS */;
INSERT INTO `SystemSettings` VALUES (3,'site_name','Site name','SpeedRunner','textInput',0),(6,'site_logo','Logo','/uploads/images/logo.png','ElFinder',1),(7,'admin_email','Email','admin@localhost.loc','textInput',2),(9,'use_mobile_grid','Adaptive tables in mobile','0','checkbox',5),(10,'delete_model_file','Delete file after removing record','1','checkbox',4),(11,'use_frontend_cache','Use cache','0','checkbox',3);
/*!40000 ALTER TABLE `SystemSettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TranslationMessage`
--

DROP TABLE IF EXISTS `TranslationMessage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TranslationMessage` (
  `counter` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '0',
  `translation` text,
  PRIMARY KEY (`id`,`language_id`),
  KEY `counter` (`counter`),
  CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `TranslationSource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationMessage`
--

LOCK TABLES `TranslationMessage` WRITE;
/*!40000 ALTER TABLE `TranslationMessage` DISABLE KEYS */;
INSERT INTO `TranslationMessage` VALUES (3,1,1,''),(1,1,2,''),(2,1,3,''),(6,2,1,''),(4,2,2,''),(5,2,3,''),(9,3,1,''),(7,3,2,''),(8,3,3,''),(12,4,1,''),(10,4,2,''),(11,4,3,''),(15,5,1,''),(13,5,2,''),(14,5,3,''),(18,6,1,''),(16,6,2,''),(17,6,3,''),(21,7,1,''),(19,7,2,''),(20,7,3,''),(24,8,1,''),(22,8,2,''),(23,8,3,''),(27,9,1,''),(25,9,2,''),(26,9,3,''),(30,10,1,''),(28,10,2,''),(29,10,3,''),(33,11,1,''),(31,11,2,''),(32,11,3,''),(36,12,1,''),(34,12,2,''),(35,12,3,''),(39,13,1,''),(37,13,2,''),(38,13,3,''),(42,14,1,''),(40,14,2,''),(41,14,3,''),(45,15,1,''),(43,15,2,''),(44,15,3,''),(48,16,1,''),(46,16,2,''),(47,16,3,''),(51,17,1,''),(49,17,2,''),(50,17,3,''),(54,18,1,''),(52,18,2,''),(53,18,3,''),(57,19,1,''),(55,19,2,''),(56,19,3,''),(60,20,1,''),(58,20,2,''),(59,20,3,''),(63,21,1,''),(61,21,2,''),(62,21,3,''),(66,22,1,''),(64,22,2,''),(65,22,3,''),(69,23,1,''),(67,23,2,''),(68,23,3,''),(72,24,1,''),(70,24,2,''),(71,24,3,''),(75,25,1,''),(73,25,2,''),(74,25,3,''),(78,26,1,''),(76,26,2,''),(77,26,3,''),(81,27,1,''),(79,27,2,''),(80,27,3,''),(84,28,1,''),(82,28,2,''),(83,28,3,''),(87,29,1,''),(85,29,2,''),(86,29,3,''),(90,30,1,''),(88,30,2,''),(89,30,3,''),(93,31,1,''),(91,31,2,''),(92,31,3,''),(96,32,1,''),(94,32,2,''),(95,32,3,''),(99,33,1,''),(97,33,2,''),(98,33,3,''),(102,34,1,''),(100,34,2,''),(101,34,3,''),(105,35,1,''),(103,35,2,''),(104,35,3,''),(108,36,1,''),(106,36,2,''),(107,36,3,''),(111,37,1,''),(109,37,2,''),(110,37,3,''),(114,38,1,''),(112,38,2,''),(113,38,3,''),(117,39,1,''),(115,39,2,''),(116,39,3,''),(120,40,1,''),(118,40,2,''),(119,40,3,''),(123,41,1,''),(121,41,2,''),(122,41,3,''),(126,42,1,''),(124,42,2,''),(125,42,3,''),(129,43,1,''),(127,43,2,''),(128,43,3,''),(132,44,1,''),(130,44,2,''),(131,44,3,''),(135,45,1,''),(133,45,2,''),(134,45,3,''),(138,46,1,''),(136,46,2,''),(137,46,3,''),(141,47,1,''),(139,47,2,''),(140,47,3,''),(144,48,1,''),(142,48,2,''),(143,48,3,''),(147,49,1,''),(145,49,2,''),(146,49,3,''),(150,50,1,''),(148,50,2,''),(149,50,3,''),(153,51,1,''),(151,51,2,''),(152,51,3,''),(156,52,1,''),(154,52,2,''),(155,52,3,''),(159,53,1,''),(157,53,2,''),(158,53,3,''),(162,54,1,''),(160,54,2,''),(161,54,3,''),(165,55,1,''),(163,55,2,''),(164,55,3,''),(168,56,1,''),(166,56,2,''),(167,56,3,''),(171,57,1,''),(169,57,2,''),(170,57,3,''),(174,58,1,''),(172,58,2,''),(173,58,3,''),(177,59,1,''),(175,59,2,''),(176,59,3,''),(180,60,1,''),(178,60,2,''),(179,60,3,''),(183,61,1,''),(181,61,2,''),(182,61,3,''),(186,62,1,''),(184,62,2,''),(185,62,3,''),(189,63,1,''),(187,63,2,''),(188,63,3,''),(192,64,1,''),(190,64,2,''),(191,64,3,''),(195,65,1,''),(193,65,2,''),(194,65,3,''),(198,66,1,''),(196,66,2,''),(197,66,3,''),(201,67,1,''),(199,67,2,''),(200,67,3,''),(204,68,1,''),(202,68,2,''),(203,68,3,''),(207,69,1,''),(205,69,2,''),(206,69,3,''),(210,70,1,''),(208,70,2,''),(209,70,3,''),(213,71,1,''),(211,71,2,''),(212,71,3,''),(216,72,1,''),(214,72,2,''),(215,72,3,''),(219,73,1,''),(217,73,2,''),(218,73,3,''),(222,74,1,''),(220,74,2,''),(221,74,3,''),(225,75,1,''),(223,75,2,''),(224,75,3,''),(228,76,1,''),(226,76,2,''),(227,76,3,''),(231,77,1,''),(229,77,2,''),(230,77,3,''),(234,78,1,''),(232,78,2,''),(233,78,3,''),(237,79,1,''),(235,79,2,''),(236,79,3,''),(240,80,1,''),(238,80,2,''),(239,80,3,''),(243,81,1,''),(241,81,2,''),(242,81,3,''),(246,82,1,''),(244,82,2,''),(245,82,3,''),(249,83,1,''),(247,83,2,''),(248,83,3,''),(252,84,1,''),(250,84,2,''),(251,84,3,''),(255,85,1,''),(253,85,2,''),(254,85,3,''),(258,86,1,''),(256,86,2,''),(257,86,3,''),(261,87,1,''),(259,87,2,''),(260,87,3,''),(264,88,1,''),(262,88,2,''),(263,88,3,''),(267,89,1,''),(265,89,2,''),(266,89,3,''),(270,90,1,''),(268,90,2,''),(269,90,3,''),(273,91,1,''),(271,91,2,''),(272,91,3,''),(276,92,1,''),(274,92,2,''),(275,92,3,''),(279,93,1,''),(277,93,2,''),(278,93,3,''),(282,94,1,''),(280,94,2,''),(281,94,3,''),(285,95,1,''),(283,95,2,''),(284,95,3,''),(288,96,1,''),(286,96,2,''),(287,96,3,''),(291,97,1,''),(289,97,2,''),(290,97,3,''),(294,98,1,''),(292,98,2,''),(293,98,3,''),(297,99,1,''),(295,99,2,''),(296,99,3,''),(300,100,1,''),(298,100,2,''),(299,100,3,''),(303,101,1,''),(301,101,2,''),(302,101,3,''),(306,102,1,''),(304,102,2,''),(305,102,3,''),(309,103,1,''),(307,103,2,''),(308,103,3,''),(312,104,1,''),(310,104,2,''),(311,104,3,''),(315,105,1,''),(313,105,2,''),(314,105,3,''),(318,106,1,''),(316,106,2,''),(317,106,3,''),(321,107,1,''),(319,107,2,''),(320,107,3,''),(324,108,1,''),(322,108,2,''),(323,108,3,''),(327,109,1,''),(325,109,2,''),(326,109,3,''),(330,110,1,''),(328,110,2,''),(329,110,3,''),(333,111,1,''),(331,111,2,''),(332,111,3,''),(336,112,1,''),(334,112,2,''),(335,112,3,''),(339,113,1,''),(337,113,2,''),(338,113,3,''),(342,114,1,''),(340,114,2,''),(341,114,3,''),(345,115,1,''),(343,115,2,''),(344,115,3,''),(348,116,1,''),(346,116,2,''),(347,116,3,''),(351,117,1,''),(349,117,2,''),(350,117,3,''),(354,118,1,'Home_pg en'),(352,118,2,'Home_pg ru'),(353,118,3,'Home_pg de'),(357,119,1,''),(355,119,2,''),(356,119,3,''),(360,120,1,''),(358,120,2,''),(359,120,3,''),(363,121,1,''),(361,121,2,''),(362,121,3,''),(366,122,1,''),(364,122,2,''),(365,122,3,''),(369,123,1,''),(367,123,2,''),(368,123,3,''),(372,124,1,''),(370,124,2,''),(371,124,3,''),(375,125,1,''),(373,125,2,''),(374,125,3,''),(378,126,1,''),(376,126,2,''),(377,126,3,''),(381,127,1,''),(379,127,2,''),(380,127,3,''),(384,128,1,''),(382,128,2,''),(383,128,3,''),(387,129,1,''),(385,129,2,''),(386,129,3,''),(390,130,1,''),(388,130,2,''),(389,130,3,''),(393,131,1,''),(391,131,2,''),(392,131,3,''),(396,132,1,''),(394,132,2,''),(395,132,3,''),(399,133,1,''),(397,133,2,''),(398,133,3,''),(402,134,1,''),(400,134,2,''),(401,134,3,''),(405,135,1,''),(403,135,2,''),(404,135,3,''),(408,136,1,''),(406,136,2,''),(407,136,3,''),(411,137,1,''),(409,137,2,''),(410,137,3,''),(414,138,1,''),(412,138,2,''),(413,138,3,''),(417,139,1,''),(415,139,2,''),(416,139,3,''),(420,140,1,''),(418,140,2,''),(419,140,3,''),(423,141,1,''),(421,141,2,''),(422,141,3,''),(426,142,1,''),(424,142,2,''),(425,142,3,''),(429,143,1,''),(427,143,2,''),(428,143,3,''),(432,144,1,''),(430,144,2,''),(431,144,3,''),(435,145,1,''),(433,145,2,''),(434,145,3,''),(438,146,1,''),(436,146,2,''),(437,146,3,''),(441,147,1,''),(439,147,2,''),(440,147,3,''),(444,148,1,''),(442,148,2,''),(443,148,3,''),(447,149,1,''),(445,149,2,''),(446,149,3,''),(450,150,1,''),(448,150,2,''),(449,150,3,''),(453,151,1,''),(451,151,2,''),(452,151,3,''),(456,152,1,''),(454,152,2,''),(455,152,3,''),(459,153,1,''),(457,153,2,''),(458,153,3,''),(462,154,1,''),(460,154,2,''),(461,154,3,''),(465,155,1,''),(463,155,2,''),(464,155,3,''),(468,156,1,''),(466,156,2,''),(467,156,3,''),(471,157,1,''),(469,157,2,''),(470,157,3,''),(474,158,1,''),(472,158,2,''),(473,158,3,''),(477,159,1,''),(475,159,2,''),(476,159,3,''),(480,160,1,''),(478,160,2,''),(479,160,3,''),(483,161,1,''),(481,161,2,''),(482,161,3,''),(486,162,1,''),(484,162,2,''),(485,162,3,''),(489,163,1,''),(487,163,2,''),(488,163,3,''),(492,164,1,''),(490,164,2,''),(491,164,3,''),(495,165,1,''),(493,165,2,''),(494,165,3,''),(498,166,1,''),(496,166,2,''),(497,166,3,''),(501,167,1,''),(499,167,2,''),(500,167,3,''),(504,168,1,''),(502,168,2,''),(503,168,3,''),(507,169,1,''),(505,169,2,''),(506,169,3,''),(510,170,1,''),(508,170,2,''),(509,170,3,''),(513,171,1,''),(511,171,2,''),(512,171,3,''),(516,172,1,''),(514,172,2,''),(515,172,3,''),(519,173,1,''),(517,173,2,''),(518,173,3,''),(522,174,1,''),(520,174,2,''),(521,174,3,''),(525,175,1,''),(523,175,2,''),(524,175,3,''),(528,176,1,''),(526,176,2,''),(527,176,3,''),(531,177,1,''),(529,177,2,''),(530,177,3,''),(534,178,1,''),(532,178,2,''),(533,178,3,''),(537,179,1,''),(535,179,2,''),(536,179,3,''),(540,180,1,''),(538,180,2,''),(539,180,3,''),(543,181,1,''),(541,181,2,''),(542,181,3,''),(546,182,1,''),(544,182,2,''),(545,182,3,''),(549,183,1,''),(547,183,2,''),(548,183,3,''),(552,184,1,''),(550,184,2,''),(551,184,3,''),(555,185,1,''),(553,185,2,''),(554,185,3,''),(558,186,1,''),(556,186,2,''),(557,186,3,''),(561,187,1,''),(559,187,2,''),(560,187,3,''),(564,188,1,''),(562,188,2,''),(563,188,3,''),(567,189,1,''),(565,189,2,''),(566,189,3,''),(570,190,1,''),(568,190,2,''),(569,190,3,''),(573,191,1,''),(571,191,2,''),(572,191,3,''),(576,192,1,''),(574,192,2,''),(575,192,3,''),(579,193,1,''),(577,193,2,''),(578,193,3,''),(582,194,1,''),(580,194,2,''),(581,194,3,''),(585,195,1,''),(583,195,2,''),(584,195,3,''),(588,196,1,''),(586,196,2,''),(587,196,3,''),(591,197,1,''),(589,197,2,''),(590,197,3,''),(594,198,1,''),(592,198,2,''),(593,198,3,''),(597,199,1,''),(595,199,2,''),(596,199,3,''),(600,200,1,''),(598,200,2,''),(599,200,3,''),(603,201,1,''),(601,201,2,''),(602,201,3,''),(606,202,1,''),(604,202,2,''),(605,202,3,''),(609,203,1,''),(607,203,2,''),(608,203,3,''),(612,204,1,''),(610,204,2,''),(611,204,3,''),(615,205,1,''),(613,205,2,''),(614,205,3,''),(618,206,1,''),(616,206,2,''),(617,206,3,''),(621,207,1,''),(619,207,2,''),(620,207,3,''),(624,208,1,''),(622,208,2,''),(623,208,3,''),(627,209,1,''),(625,209,2,''),(626,209,3,''),(630,210,1,''),(628,210,2,''),(629,210,3,''),(633,211,1,''),(631,211,2,''),(632,211,3,''),(636,212,1,''),(634,212,2,''),(635,212,3,''),(639,213,1,''),(637,213,2,''),(638,213,3,''),(642,214,1,''),(640,214,2,''),(641,214,3,''),(645,215,1,''),(643,215,2,''),(644,215,3,''),(648,216,1,''),(646,216,2,''),(647,216,3,''),(651,217,1,''),(649,217,2,''),(650,217,3,''),(654,218,1,''),(652,218,2,''),(653,218,3,''),(657,219,1,''),(655,219,2,''),(656,219,3,''),(660,220,1,''),(658,220,2,''),(659,220,3,''),(663,221,1,''),(661,221,2,''),(662,221,3,''),(666,222,1,''),(664,222,2,''),(665,222,3,''),(669,223,1,''),(667,223,2,''),(668,223,3,''),(672,224,1,''),(670,224,2,''),(671,224,3,''),(675,225,1,''),(673,225,2,''),(674,225,3,''),(678,226,1,''),(676,226,2,''),(677,226,3,''),(681,227,1,''),(679,227,2,''),(680,227,3,''),(684,228,1,''),(682,228,2,''),(683,228,3,''),(687,229,1,''),(685,229,2,''),(686,229,3,''),(690,230,1,''),(688,230,2,''),(689,230,3,''),(693,231,1,''),(691,231,2,''),(692,231,3,''),(696,232,1,''),(694,232,2,''),(695,232,3,''),(699,233,1,''),(697,233,2,''),(698,233,3,''),(702,234,1,''),(700,234,2,''),(701,234,3,''),(705,235,1,''),(703,235,2,''),(704,235,3,''),(708,236,1,''),(706,236,2,''),(707,236,3,''),(711,237,1,''),(709,237,2,''),(710,237,3,''),(714,238,1,''),(712,238,2,''),(713,238,3,''),(717,239,1,''),(715,239,2,''),(716,239,3,''),(720,240,1,''),(718,240,2,''),(719,240,3,''),(723,241,1,''),(721,241,2,''),(722,241,3,''),(726,242,1,''),(724,242,2,''),(725,242,3,''),(729,243,1,''),(727,243,2,''),(728,243,3,''),(732,244,1,''),(730,244,2,''),(731,244,3,''),(735,245,1,''),(733,245,2,''),(734,245,3,''),(738,246,1,''),(736,246,2,''),(737,246,3,''),(741,247,1,''),(739,247,2,''),(740,247,3,''),(744,248,1,''),(742,248,2,''),(743,248,3,''),(747,249,1,''),(745,249,2,''),(746,249,3,''),(750,250,1,''),(748,250,2,''),(749,250,3,''),(753,251,1,''),(751,251,2,''),(752,251,3,''),(756,252,1,''),(754,252,2,''),(755,252,3,''),(759,253,1,''),(757,253,2,''),(758,253,3,''),(762,254,1,''),(760,254,2,''),(761,254,3,''),(765,255,1,''),(763,255,2,''),(764,255,3,''),(768,256,1,''),(766,256,2,''),(767,256,3,''),(771,257,1,''),(769,257,2,''),(770,257,3,''),(774,258,1,''),(772,258,2,''),(773,258,3,''),(777,259,1,''),(775,259,2,''),(776,259,3,''),(780,260,1,''),(778,260,2,''),(779,260,3,''),(783,261,1,''),(781,261,2,''),(782,261,3,''),(786,262,1,''),(784,262,2,''),(785,262,3,''),(789,263,1,''),(787,263,2,''),(788,263,3,''),(792,264,1,''),(790,264,2,''),(791,264,3,''),(795,265,1,''),(793,265,2,''),(794,265,3,''),(798,266,1,''),(796,266,2,''),(797,266,3,''),(801,267,1,''),(799,267,2,''),(800,267,3,''),(804,268,1,''),(802,268,2,''),(803,268,3,''),(807,269,1,''),(805,269,2,''),(806,269,3,''),(810,270,1,''),(808,270,2,''),(809,270,3,''),(813,271,1,''),(811,271,2,''),(812,271,3,''),(816,272,1,''),(814,272,2,''),(815,272,3,''),(819,273,1,''),(817,273,2,''),(818,273,3,''),(822,274,1,''),(820,274,2,''),(821,274,3,''),(825,275,1,''),(823,275,2,''),(824,275,3,''),(828,276,1,''),(826,276,2,''),(827,276,3,''),(831,277,1,''),(829,277,2,''),(830,277,3,''),(834,278,1,''),(832,278,2,''),(833,278,3,''),(837,279,1,''),(835,279,2,''),(836,279,3,''),(840,280,1,''),(838,280,2,''),(839,280,3,''),(843,281,1,''),(841,281,2,''),(842,281,3,''),(846,282,1,''),(844,282,2,''),(845,282,3,''),(849,283,1,''),(847,283,2,''),(848,283,3,''),(852,284,1,''),(850,284,2,''),(851,284,3,''),(855,285,1,''),(853,285,2,''),(854,285,3,''),(858,286,1,''),(856,286,2,''),(857,286,3,''),(861,287,1,''),(859,287,2,''),(860,287,3,''),(864,288,1,''),(862,288,2,''),(863,288,3,''),(867,289,1,''),(865,289,2,''),(866,289,3,''),(870,290,1,''),(868,290,2,''),(869,290,3,''),(873,291,1,''),(871,291,2,''),(872,291,3,''),(876,292,1,''),(874,292,2,''),(875,292,3,''),(879,293,1,''),(877,293,2,''),(878,293,3,''),(882,294,1,''),(880,294,2,''),(881,294,3,''),(885,295,1,''),(883,295,2,''),(884,295,3,''),(888,296,1,''),(886,296,2,''),(887,296,3,''),(891,297,1,''),(889,297,2,''),(890,297,3,''),(894,298,1,''),(892,298,2,''),(893,298,3,''),(897,299,1,''),(895,299,2,''),(896,299,3,''),(900,300,1,''),(898,300,2,''),(899,300,3,''),(903,301,1,''),(901,301,2,''),(902,301,3,''),(906,302,1,''),(904,302,2,''),(905,302,3,''),(909,303,1,''),(907,303,2,''),(908,303,3,''),(912,304,1,''),(910,304,2,''),(911,304,3,''),(915,305,1,''),(913,305,2,''),(914,305,3,''),(918,306,1,''),(916,306,2,''),(917,306,3,''),(921,307,1,''),(919,307,2,''),(920,307,3,'');
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
  `category` varchar(32) NOT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=308 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TranslationSource`
--

LOCK TABLES `TranslationSource` WRITE;
/*!40000 ALTER TABLE `TranslationSource` DISABLE KEYS */;
INSERT INTO `TranslationSource` VALUES (1,'app','Actions'),(2,'app','DELETE ALL'),(3,'app','Navigation'),(4,'app','Dashboard'),(5,'app','Users'),(6,'app','Permissions'),(7,'app','Routes'),(8,'app','Rules'),(9,'app','Roles'),(10,'app','Assignments'),(11,'app','Menu'),(12,'app','Static Pages'),(13,'app','Home'),(14,'app','Blocks'),(15,'app','Types'),(16,'app','Pages'),(17,'app','Blogs'),(18,'app','Categories'),(19,'app','Tags'),(20,'app','Comments'),(21,'app','Rates'),(22,'app','Products'),(23,'app','Brands'),(24,'app','Attributes'),(25,'app','Media'),(26,'app','Banners'),(27,'app','Gallery'),(28,'app','System'),(29,'app','Settings'),(30,'app','Languages'),(31,'app','Translations'),(32,'app','File manager'),(33,'app','Cache'),(34,'app','Refresh routes'),(35,'app','Remove thumbs'),(36,'app','Clear'),(37,'app','Information'),(38,'app','Help'),(39,'app','Gratitude'),(40,'app','Logout'),(41,'i18n-dot','Change'),(42,'i18n-dot','Loading...'),(43,'i18n-dot','Empty'),(44,'app','ID'),(45,'app','Username'),(46,'app','Role'),(47,'app','Email'),(48,'app','New password'),(49,'app','Full name'),(50,'app','Phone'),(51,'app','Address'),(52,'app','Created'),(53,'app','Updated'),(54,'app','Category'),(55,'app','Name'),(56,'app','Short Description'),(57,'app','Full Description'),(58,'app','Url'),(59,'app','Image'),(60,'app','Published'),(61,'app','Published from'),(62,'app','Published to'),(63,'app','Images'),(64,'app','Create'),(65,'app','Search'),(66,'app','Blog'),(67,'app','Block page'),(68,'app','Contact'),(69,'app','Signup'),(70,'app','Login'),(71,'app','Update: {name}'),(72,'app','General'),(73,'app','SEO meta'),(74,'app','Save'),(75,'app','SAVE'),(76,'app','SAVE & RELOAD'),(77,'app','SAVE & CREATE'),(78,'app','Record successfully updated'),(79,'app','Id'),(80,'app','Description'),(81,'app','System settings'),(82,'app','System Settings'),(83,'app','Label'),(84,'app','Value'),(85,'app','Type'),(86,'app','Sort'),(87,'app','Code'),(88,'app','Main'),(89,'app','Active'),(90,'app','Updated At'),(91,'app','System Languages'),(92,'app','Menus'),(93,'app','Tree'),(94,'app','Lft'),(95,'app','Rgt'),(96,'app','Depth'),(97,'app','Expanded'),(98,'app','Parent'),(99,'yii2mod.rbac','Routes'),(100,'yii2mod.rbac','Assignments'),(101,'yii2mod.rbac','Roles'),(102,'yii2mod.rbac','Permissions'),(103,'yii2mod.rbac','Rules'),(104,'yii2mod.rbac','Refresh'),(105,'yii2mod.rbac','Search for available'),(106,'yii2mod.rbac','Assign'),(107,'yii2mod.rbac','Remove'),(108,'yii2mod.rbac','Search for assigned'),(109,'app','Admin'),(110,'app','Registered'),(111,'app','Save link'),(112,'app','Create bookmark'),(113,'app','Update: {username}'),(114,'app','Profile'),(115,'app','Zzzs'),(116,'app','Record successfully created'),(117,'app','Record successfully deleted'),(118,'app','Home_pg'),(119,'app','test'),(120,'app','Password'),(121,'app','Remember me'),(122,'app','Reset password'),(123,'speedrunner','General'),(124,'speedrunner','Controller'),(125,'speedrunner','Model'),(126,'speedrunner','View'),(127,'speedrunner','Use'),(128,'speedrunner','Module name'),(129,'speedrunner','Generate files'),(130,'speedrunner','Controller name'),(131,'speedrunner','Controller actions'),(132,'speedrunner','Table name'),(133,'speedrunner','With translation'),(134,'speedrunner','Has SEO meta'),(135,'speedrunner','Model relations'),(136,'speedrunner','View relations'),(137,'speedrunner','Attributes fields'),(138,'speedrunner','Name'),(139,'speedrunner','Type'),(140,'speedrunner','Condition (from)'),(141,'speedrunner','Condition (to)'),(142,'speedrunner','Variable name'),(143,'speedrunner','Value'),(144,'speedrunner','GO'),(145,'app','Static pages'),(146,'app','Content'),(147,'app','Static Page: {location}'),(148,'app','Заголовок'),(149,'app','Описание'),(150,'app','Изображение'),(151,'app','Item ID'),(152,'app','User ID'),(153,'app','Text'),(154,'app','Status'),(155,'app','Item name'),(156,'app','Mark'),(157,'app','Comments & rates: {name}'),(158,'app','Successfully completed'),(159,'app','Use in filter'),(160,'app','Use in compare'),(161,'app','Use in detail page'),(162,'app','Options'),(163,'app','Product Attributes'),(164,'app','Field must contain only alphabet and numerical chars'),(165,'app','Has translation'),(166,'app','Block Types'),(167,'app','Block Pages'),(168,'app','Assign'),(169,'app','Page'),(170,'app','Краткое описание'),(171,'app','Полное описание'),(172,'speedrunner','Attribute'),(173,'speedrunner','GridView'),(174,'speedrunner','Label'),(175,'speedrunner','I18N'),(176,'speedrunner','Attrs (for \"groups\" type)'),(177,'speedrunner','Image'),(178,'speedrunner','Blocks'),(179,'speedrunner','Page name'),(180,'app','Part name'),(181,'app','Brand ID'),(182,'app','Main category'),(183,'app','Price'),(184,'app','Sale'),(185,'app','Quantity'),(186,'app','Sku'),(187,'app','Is Active'),(188,'app','Related'),(189,'app','Variations'),(190,'app','Stock'),(191,'app','Categories & Attributes'),(192,'app','Choose attribute'),(193,'app','Choose option'),(194,'app','Attribute'),(195,'app','Option'),(196,'app','GO'),(197,'app','Generate'),(198,'app','Controller'),(199,'app','Model'),(200,'app','View'),(201,'app','Use'),(202,'speedrunner','Module config'),(203,'app','Generator'),(204,'app','SpeedRunner'),(205,'app','Location'),(206,'app','Slider home'),(207,'app','Slider about'),(208,'app','Text 1'),(209,'app','Text 2'),(210,'app','Text 3'),(211,'app','Link'),(212,'app','Assign: {name}'),(213,'app','Used'),(214,'app','Update: {label}'),(215,'app','Blog Categories'),(216,'app','Blog comments'),(217,'app','User'),(218,'app','New'),(219,'app','Comment: {id}'),(220,'app','Blog Comments'),(221,'app','Product'),(222,'app','Products Comments'),(223,'app','Blog Rates'),(224,'app','Product Rates'),(225,'app','Blog Tags'),(226,'app','Galleries'),(227,'app','Message'),(228,'app','Translation Sources'),(229,'app','Update: {message}'),(230,'app','Prodile'),(231,'app','Zzz Categories'),(232,'app','Delete'),(233,'app','Delete with children'),(234,'app','Product Categories'),(235,'app','Url must be unique'),(236,'app','Full url'),(237,'app','Add'),(238,'app','Update'),(239,'app','Variation edit'),(240,'app','Attribute ID'),(241,'app','Option ID'),(242,'app','Update: {id}'),(243,'speedrunner','Duplicate types'),(244,'speedrunner','Module name (from)'),(245,'speedrunner','Module name (to)'),(246,'app','Sign In'),(247,'app','Sign in'),(248,'app','Incorrect username or password.'),(249,'app','Parameter not found'),(250,'app','Successfully changed'),(251,'app','SpeedRunner Gii'),(252,'app','Module Generator'),(253,'app','Module Duplicator'),(254,'app','Page Generator'),(255,'app','Block Generator'),(256,'app','Bookmarks'),(257,'app','Theme changed'),(258,'app','Bookmark has been added'),(259,'yii2mod.rbac','Create'),(260,'yii2mod.rbac','Name'),(261,'yii2mod.rbac','Action'),(262,'app','Bookmark has been deleted'),(263,'app','Theme has been changed'),(264,'app','API Generator'),(265,'app','E-mail'),(266,'app','Confirm password'),(267,'speedrunner','Module'),(268,'app','This username has already been taken.'),(269,'app','This email has already been taken.'),(270,'app','There is no user with this email address.'),(271,'app','Record has been updated'),(272,'app','Record has been created'),(273,'app','Record has been deleted'),(274,'app','Functions'),(275,'app','Include'),(276,'app','Exclude'),(277,'yii2mod.rbac','Create Rule'),(278,'yii2mod.rbac','Class Name'),(279,'yii2mod.rbac','Rule Name'),(280,'yii2mod.rbac','Select Rule'),(281,'yii2mod.rbac','Description'),(282,'yii2mod.rbac','Rule : {0}'),(283,'yii2mod.rbac','Update'),(284,'yii2mod.rbac','Delete'),(285,'yii2mod.rbac','Are you sure to delete this item?'),(286,'app','View: {name}'),(287,'yii2mod.rbac','Create Role'),(288,'yii2mod.rbac','Type'),(289,'yii2mod.rbac','Data'),(290,'yii2mod.rbac','Role : {0}'),(291,'app','Assignment'),(292,'yii2mod.rbac','Assignment : {0}'),(293,'yii2mod.rbac','Item has been removed.'),(294,'app','RBAC'),(295,'yii2mod.rbac','RBAC'),(296,'app','Error'),(297,'app','Main title'),(298,'app','Main description'),(299,'app','Main image'),(300,'app','Another title'),(301,'app','Another short description'),(302,'app','Another full description'),(303,'app','Browse'),(304,'app','Process has been completed'),(305,'app','Short description'),(306,'app','Full description'),(307,'app','Category id');
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
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'admin','admin','wzBIN8RcuSL0fZFI5PMBiHLqCMpuNCsk','$2y$13$oRL5/P2KfK1SNl4hZq9nQeMIVYwG7E06PMG7bWNJb3z8LTyegVw8W','nzROrR5Spm1pqlxn8gDaslHW09s560dN_1580274498','admin@local.host','2020-02-21 04:58:00','2020-05-24 17:59:05');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserProfile`
--

DROP TABLE IF EXISTS `UserProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserProfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserProfile`
--

LOCK TABLES `UserProfile` WRITE;
/*!40000 ALTER TABLE `UserProfile` DISABLE KEYS */;
INSERT INTO `UserProfile` VALUES (4,1,'Administrator','2231','addr');
/*!40000 ALTER TABLE `UserProfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Zzz`
--

DROP TABLE IF EXISTS `Zzz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Zzz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Zzz`
--

LOCK TABLES `Zzz` WRITE;
/*!40000 ALTER TABLE `Zzz` DISABLE KEYS */;
/*!40000 ALTER TABLE `Zzz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ZzzCategory`
--

DROP TABLE IF EXISTS `ZzzCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZzzCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ZzzCategory`
--

LOCK TABLES `ZzzCategory` WRITE;
/*!40000 ALTER TABLE `ZzzCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ZzzCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ZzzCategoryTranslation`
--

DROP TABLE IF EXISTS `ZzzCategoryTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZzzCategoryTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ZzzCategoryTranslation`
--

LOCK TABLES `ZzzCategoryTranslation` WRITE;
/*!40000 ALTER TABLE `ZzzCategoryTranslation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ZzzCategoryTranslation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ZzzImage`
--

DROP TABLE IF EXISTS `ZzzImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZzzImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ZzzImage`
--

LOCK TABLES `ZzzImage` WRITE;
/*!40000 ALTER TABLE `ZzzImage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ZzzImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ZzzTranslation`
--

DROP TABLE IF EXISTS `ZzzTranslation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZzzTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ZzzTranslation`
--

LOCK TABLES `ZzzTranslation` WRITE;
/*!40000 ALTER TABLE `ZzzTranslation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ZzzTranslation` ENABLE KEYS */;
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
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1537578127,1537578127),('admin',1,'admin','admin',NULL,1537596415,1590420290),('registered',1,'registered','registered',NULL,1585474124,1585474124);
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
INSERT INTO `auth_rule` VALUES ('admin','O:27:\"yii2mod\\rbac\\rules\\UserRule\":3:{s:4:\"name\";s:5:\"admin\";s:9:\"createdAt\";i:1537596396;s:9:\"updatedAt\";i:1590419461;}',1537596396,1590419461),('registered','O:27:\"yii2mod\\rbac\\rules\\UserRule\":3:{s:4:\"name\";s:10:\"registered\";s:9:\"createdAt\";i:1585474116;s:9:\"updatedAt\";i:1585474116;}',1585474116,1585474116);
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

-- Dump completed on 2020-06-11  1:20:42
