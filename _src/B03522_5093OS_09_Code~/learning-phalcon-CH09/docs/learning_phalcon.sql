-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: learning_phalcon
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1-log

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
-- Table structure for table `acl_access_list`
--

DROP TABLE IF EXISTS `acl_access_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_access_list` (
  `roles_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `resources_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `access_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `allowed` smallint(3) NOT NULL,
  PRIMARY KEY (`roles_name`,`resources_name`,`access_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_resources`
--

DROP TABLE IF EXISTS `acl_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_resources` (
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_resources_accesses`
--

DROP TABLE IF EXISTS `acl_resources_accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_resources_accesses` (
  `resources_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `access_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`resources_name`,`access_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_roles`
--

DROP TABLE IF EXISTS `acl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_roles` (
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_roles_inherits`
--

DROP TABLE IF EXISTS `acl_roles_inherits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_roles_inherits` (
  `roles_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `roles_inherit` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`roles_name`,`roles_inherit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_user_id` int(11) NOT NULL,
  `article_is_published` tinyint(1) NOT NULL DEFAULT '0',
  `article_created_at` datetime NOT NULL,
  `article_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `article_user_id` (`article_user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`article_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `article_category_article`
--

DROP TABLE IF EXISTS `article_category_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category_article` (
  `article_id` int(11) NOT NULL,
  `category_id` smallint(5) NOT NULL,
  UNIQUE KEY `article_id` (`article_id`,`category_id`),
  KEY `idx_article_id` (`article_id`),
  KEY `idx_category_id` (`category_id`),
  CONSTRAINT `article_category_article_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `article_category_article_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `article_hashtag_article`
--

DROP TABLE IF EXISTS `article_hashtag_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_hashtag_article` (
  `article_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL,
  UNIQUE KEY `article_id` (`article_id`,`hashtag_id`),
  KEY `idx_aha_article_id` (`article_id`),
  KEY `idx_aha_hashtag_id` (`hashtag_id`),
  CONSTRAINT `article_hashtag_article_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `article_hashtag_article_ibfk_2` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `article_translation`
--

DROP TABLE IF EXISTS `article_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_translation_article_id` int(11) NOT NULL,
  `article_translation_short_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `article_translation_long_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `article_translation_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `article_translation_description` text COLLATE utf8_unicode_ci NOT NULL,
  `article_translation_lang` char(2) COLLATE utf8_unicode_ci DEFAULT 'en',
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_translation_article_id_2` (`article_translation_article_id`,`article_translation_lang`),
  KEY `id` (`id`),
  KEY `article_translation_article_id` (`article_translation_article_id`),
  CONSTRAINT `fk_article_id` FOREIGN KEY (`article_translation_article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `category_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `category_created_at` datetime NOT NULL,
  `category_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_is_active` (`category_is_active`),
  KEY `category_created_at` (`category_created_at`),
  KEY `category_updated_at` (`category_updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_translation`
--

DROP TABLE IF EXISTS `category_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_translation` (
  `category_translation_category_id` smallint(5) NOT NULL,
  `category_translation_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `category_translation_slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_translation_lang` char(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_translation_category_id`),
  UNIQUE KEY `category_translation_slug` (`category_translation_slug`),
  UNIQUE KEY `category_translation_category_id` (`category_translation_category_id`,`category_translation_lang`),
  KEY `category_translation_locale` (`category_translation_lang`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_translation_category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hashtag`
--

DROP TABLE IF EXISTS `hashtag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hashtag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `hashtag_created_at` datetime NOT NULL,
  `hashtag_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `user_is_active` tinyint(1) NOT NULL DEFAULT '0',
  `user_created_at` datetime NOT NULL,
  `user_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`user_email`),
  KEY `idx_is_active` (`user_is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_failed_logins`
--

DROP TABLE IF EXISTS `user_failed_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_failed_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` char(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `attempted` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`user_id`),
  CONSTRAINT `user_failed_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_profile_user_id` int(11) NOT NULL,
  `user_profile_location` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_profile_created_at` datetime NOT NULL,
  `user_profile_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_profile_user_id` (`user_profile_user_id`),
  CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_profile_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_remember_tokens`
--

DROP TABLE IF EXISTS `user_remember_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_remember_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` char(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_remember_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `article_translation` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `user_id_2` (`user_id`,`user_role`),
  KEY `user_role` (`user_role`),
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`user_role`) REFERENCES `acl_roles` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_success_logins`
--

DROP TABLE IF EXISTS `user_success_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_success_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` char(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`user_id`),
  CONSTRAINT `user_success_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-12 18:24:17
