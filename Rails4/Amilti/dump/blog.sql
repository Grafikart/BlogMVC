CREATE DATABASE  IF NOT EXISTS `blog_mvc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `blog_mvc`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: blog_mvc
-- ------------------------------------------------------
-- Server version	5.6.12

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `posts_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Category #1','category-1',2),(2,'Category #2','category-2',2),(3,'Category #3','category-3',2),(4,'Category #4','category-4',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'sssss','ssss@gmail.com','sssssss','2014-02-11 14:25:34','2014-02-11 14:25:34',6),(3,'sssss','test@gmail.com','sssss','2014-02-11 17:57:00','2014-02-11 17:57:00',6);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendly_id_slugs`
--

DROP TABLE IF EXISTS `friendly_id_slugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendly_id_slugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `sluggable_id` int(11) NOT NULL,
  `sluggable_type` varchar(50) DEFAULT NULL,
  `scope` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_friendly_id_slugs_on_slug_and_sluggable_type_and_scope` (`slug`,`sluggable_type`,`scope`),
  KEY `index_friendly_id_slugs_on_sluggable_id` (`sluggable_id`),
  KEY `index_friendly_id_slugs_on_slug_and_sluggable_type` (`slug`,`sluggable_type`),
  KEY `index_friendly_id_slugs_on_sluggable_type` (`sluggable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendly_id_slugs`
--

LOCK TABLES `friendly_id_slugs` WRITE;
/*!40000 ALTER TABLE `friendly_id_slugs` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendly_id_slugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_posts_on_user_id` (`user_id`),
  KEY `index_posts_on_category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Space Pilot 3000','space-pilot-3000','I don\'t want to be rescued. So I really am important? How I feel when I\'m drunk is correct? Leela\'s gonna kill me. It\'s a T. It goes \"tuh\". File not found. She also liked to shut up!\r\n\r\n## The Why of Fry\r\n\r\nI love this planet! I\'ve got wealth, fame, and access to the depths of sleaze that those things bring. You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. Alright, let\'s mafia things up a bit. Joey, burn down the ship. Clamps, burn down the crew.\r\n\r\n*   So I really am important? How I feel when I\'m drunk is correct?\r\n*   No! The cat shelter\'s on to me.\r\n*   No, she\'ll probably make me do it.\r\n\r\n### My Three Suns\r\n\r\nOK, this has gotta stop. I\'m going to remind Fry of his humanity the way only a woman can. Why yes! Thanks for noticing. Now, now. Perfectly symmetrical violence never solved anything.\r\n\r\n#### A Clockwork Origin\r\n\r\nYou can see how I lived before I met you. Can we have Bender Burgers again? I guess because my parents keep telling me to be more ladylike. As though! Hey! I\'m a porno-dealing monster, what do I care what you think? You know, I was God once.\r\n\r\n1.  You lived before you met me?!\r\n2.  They\'re like sex, except I\'m having them!\r\n3.  You, a bobsleder!? That I\'d like to see!\r\n\r\n##### Leela\'s Homeworld\r\n\r\nYep, I remember. They came in last at the Olympics, then retired to promote alcoholic beverages! Large bet on myself in round one. Actually, that\'s still true. Ask her how her day was. In your time, yes, but nowadays shut up! Besides, these are adult stemcells, harvested from perfectly healthy adults whom I killed for their stemcells. Why not indeed!','2014-02-10 12:52:02','2014-02-10 12:52:02',1,1),(2,'Rebirth','rebirth','Yep, I remember. They came in last at the Olympics, then retired to promote alcoholic beverages! You know, I was God once. That could be \'my\' beautiful soul sitting naked on a couch. If I could just learn to play this stupid thing. Okay, I like a challenge. I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n \r\n ## I, Roommate\r\n \r\n Now, now. Perfectly symmetrical violence never solved anything. With a warning label this big, you know they gotta be fun! I\'m Santa Claus!\r\n \r\n *   You guys realize you live in a sewer, right?\r\n *   Okay, I like a challenge.\r\n *   Robot 1-X, save my friends!  And Zoidberg!\r\n \r\n ### Love and Rocket\r\n \r\n Can we have Bender Burgers again? This is the worst part. The calm before the battle. For one beautiful night I knew what it was like to be a grandmother. Subjugated, yet honored. You\'ll have all the Slurm you can drink when you\'re partying with Slurms McKenzie!\r\n \r\n #### War Is the H-Word\r\n \r\n You know the worst thing about being a slave? They make you work, but they don\'t pay you or let you go. Ooh, name it after me! Kids don\'t turn rotten just from watching TV. You guys aren\'t Santa! You\'re not even robots. How dare you lie in front of Jesus?\r\n \r\n 1.  Why yes! Thanks for noticing.\r\n 2.  You guys aren\'t Santa! You\'re not even robots. How dare you lie in front of Jesus?\r\n 3.  There\'s no part of that sentence I didn\'t like!\r\n 4.  I had more, but you go ahead.\r\n 5.  Bender, we\'re trying our best.\r\n \r\n ##### Anthology of Interest II\r\n \r\n Goodbye, cruel world. Goodbye, cruel lamp. Goodbye, cruel velvet drapes, lined with what would appear to be some sort of cruel muslin and the cute little pom-pom curtain pull cords. Cruel though they may be&hellip; It must be wonderful. Leela, are you alright? You got wanged on the head.','2014-02-10 12:54:29','2014-02-10 12:55:12',1,2),(3,'Future Stock','future-stock','You, a bobsleder!? That I\'d like to see! I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him. Robot 1-X, save my friends!  And Zoidberg! You know the worst thing about being a slave? They make you work, but they don\'t pay you or let you go. OK, this has gotta stop. I\'m going to remind Fry of his humanity the way only a woman can. Good news, everyone! There\'s a report on TV with some very bad news!\r\n \r\n ## Roswell That Ends Well\r\n \r\n Why yes! Thanks for noticing. For the last time, I don\'t like lilacs!  Your \'first\' wife was the one who liked lilacs! We\'ll go deliver this crate like professionals, and then we\'ll go home.\r\n \r\n *   Why yes! Thanks for noticing.\r\n *   That\'s the ONLY thing about being a slave.\r\n *   OK, this has gotta stop. I\'m going to remind Fry of his humanity the way only a woman can.\r\n *   It must be wonderful.\r\n \r\n ### A Tale of Two Santas\r\n \r\n This is the worst part. The calm before the battle. There\'s no part of that sentence I didn\'t like! Ask her how her day was.\r\n \r\n #### Bendless Love\r\n \r\n Your best is an idiot! Oh dear! She\'s stuck in an infinite loop, and he\'s an idiot! Well, that\'s love for you. I\'m sure those windmills will keep them cool. I had more, but you go ahead. Fry! Stay back! He\'s too powerful! No, she\'ll probably make me do it.\r\n \r\n 1.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n 2.  Kif might!\r\n 3.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n 4.  Goodbye, cruel world. Goodbye, cruel lamp. Goodbye, cruel velvet drapes, lined with what would appear to be some sort of cruel muslin and the cute little pom-pom curtain pull cords. Cruel though they may be&hellip;\r\n \r\n ##### The Series Has Landed\r\n \r\n Ooh, name it after me! In your time, yes, but nowadays shut up! Besides, these are adult stemcells, harvested from perfectly healthy adults whom I killed for their stemcells. No, of course not. It was&hellip; uh&hellip; porno. Yeah, that\'s it. So I really am important? How I feel when I\'m drunk is correct? I suppose I could part with \'one\' and still be feared&hellip; Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence.','2014-02-10 12:56:02','2014-02-10 12:57:20',1,3),(4,'Parasites Lost','parasites-lost','I love this planet! I\'ve got wealth, fame, and access to the depths of sleaze that those things bring. You, minion. Lift my arm. AFTER HIM! I don\'t want to be rescued. I had more, but you go ahead. I\'m Santa Claus! Hey! I\'m a porno-dealing monster, what do I care what you think?\r\n\r\n## The Deep South\r\n\r\nOh dear! She\'s stuck in an infinite loop, and he\'s an idiot! Well, that\'s love for you. I was having the most wonderful dream. Except you were there, and you were there, and you were there! File not found. Man, I\'m sore all over. I feel like I just went ten rounds with mighty Thor. But, like most politicians, he promised more than he could deliver. I guess because my parents keep telling me to be more ladylike. As though!\r\n\r\n*   They\'re like sex, except I\'m having them!\r\n*   You know, I was God once.\r\n*   Then we\'ll go with that data file!\r\n\r\n### Devil\'s Hands are Idle Playthings\r\n\r\nActually, that\'s still true. No, she\'ll probably make me do it. Oh, I always feared he might run off like this. Why, why, why didn\'t I break his legs? WINDMILLS DO NOT WORK THAT WAY! GOOD NIGHT! This is the worst part. The calm before the battle.\r\n\r\n#### The Deep South\r\n\r\nFor the last time, I don\'t like lilacs!  Your \'first\' wife was the one who liked lilacs! Pansy. You know, I was God once.\r\n\r\n1.  You, a bobsleder!? That I\'d like to see!\r\n2.  Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence.\r\n\r\n##### Bendin\' in the Wind\r\n\r\nI usually try to keep my sadness pent up inside where it can fester quietly as a mental illness. No, of course not. It was&hellip; uh&hellip; porno. Yeah, that\'s it. Your best is an idiot! There\'s no part of that sentence I didn\'t like! They\'re like sex, except I\'m having them! I had more, but you go ahead.','2014-02-10 12:56:44','2014-02-10 12:56:44',1,1),(5,'The Sting','the-sting','Your best is an idiot! Can we have Bender Burgers again? That could be \'my\' beautiful soul sitting naked on a couch. If I could just learn to play this stupid thing. You guys realize you live in a sewer, right? Now that the, uh, garbage ball is in space, Doctor, perhaps you can help me with my sexual inhibitions? I love this planet! I\'ve got wealth, fame, and access to the depths of sleaze that those things bring.\r\n\r\n## Kif Gets Knocked Up A Notch\r\n\r\nLeela, are you alright? You got wanged on the head. Come, Comrade Bender! We must take to the streets! Man, I\'m sore all over. I feel like I just went ten rounds with mighty Thor.\r\n\r\n*   I love this planet! I\'ve got wealth, fame, and access to the depths of sleaze that those things bring.\r\n*   OK, this has gotta stop. I\'m going to remind Fry of his humanity the way only a woman can.\r\n\r\n### Anthology of Interest I\r\n\r\nWe\'re rescuing ya. I\'m sure those windmills will keep them cool. Oh dear! She\'s stuck in an infinite loop, and he\'s an idiot! Well, that\'s love for you. But I\'ve never been to the moon!\r\n\r\n#### Lrrreconcilable Ndndifferences\r\n\r\nWe\'ll go deliver this crate like professionals, and then we\'ll go home. You are the last hope of the universe. Fatal. No! The cat shelter\'s on to me. Fry! Stay back! He\'s too powerful! So I really am important? How I feel when I\'m drunk is correct?\r\n\r\n1.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n2.  We can\'t compete with Mom! Her company is big and evil! Ours is small and neutral!\r\n3.  Hello, little man. I will destroy you!\r\n\r\n##### Bendless Love\r\n\r\nHello, little man. I will destroy you! Ooh, name it after me! Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence. You know, I was God once. You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. With a warning label this big, you know they gotta be fun!','2014-02-10 12:57:07','2014-02-10 12:58:17',1,2),(6,'The Route of All Evil','the-route-of-all-evil','Five hours? Aw, man! Couldn\'t you just get me the death penalty? Daylight and everything. What\'s with you kids? Every other day it\'s food, food, food. Alright, I\'ll get you some stupid food.\r\n\r\n## Bendin\' in the Wind\r\n\r\n<img src=\"http://lorempicsum.com/futurama/200/150/1\" class=\"img-thumbnail\" style=\"float:left; margin-right:10px;\">\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, modi, libero, earum, fugiat beatae ipsa quae accusamus eligendi minima eos sint consequuntur voluptate nihil inventore voluptatum? Possimus neque similique quam.\r\n\r\nNemo, aliquam non nulla corporis veritatis molestiae omnis nobis dolores dicta dolorum accusamus porro ipsum rem tempora maxime quisquam accusantium facilis saepe consequatur qui doloribus iusto distinctio perspiciatis modi voluptatum?\r\n\r\nIllum temporibus natus cumque recusandae non fugiat quisquam fuga repellendus. Quas, esse, a rem possimus vero sequi fugit non dolor corrupti in similique repudiandae excepturi quidem perspiciatis soluta amet qui?\r\n\r\n*   Fetal stemcells, aren\'t those controversial?\r\n*   Yes! In your face, Gandhi!\r\n*   The key to victory is discipline, and that means a well made bed. You will practice until you can make your bed in your sleep.\r\n\r\n### Why Must I Be a Crustacean in Love?\r\n\r\n<img src=\"http://lorempicsum.com/futurama/200/150/2\" class=\"img-thumbnail\" style=\"float:right; margin-left:10px;\">\r\n\r\nWe\'re rescuing ya. I\'m Santa Claus! Have you ever tried just turning off the TV, sitting down with your children, and hitting them? Calculon is gonna kill us and it\'s all everybody else\'s fault! I just want to talk. It has nothing to do with mating. Fry, that doesn\'t make sense. Ummm&hellip;to eBay?\r\n\r\n#### Attack of the Killer App\r\n\r\nWhy would I want to know that? It\'s toe-tappingly tragic! You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. I\'ve got to find a way to escape the horrible ravages of youth. Suddenly, I\'m going to the bathroom like clockwork, every three hours. And those jerks at Social Security stopped sending me checks. Now \'I\'\' have to pay \'\'them\'! I was all of history\'s great robot actors - Acting Unit 0.8; Thespomat; David Duchovny! Five hours? Aw, man! Couldn\'t you just get me the death penalty?\r\n\r\n1.  But, like most politicians, he promised more than he could deliver.\r\n2.  Calculon is gonna kill us and it\'s all everybody else\'s fault!\r\n3.  Bender?! You stole the atom.\r\n\r\n##### A Tale of Two Santas\r\n\r\nKif might! I wish! It\'s a nickel. OK, this has gotta stop. I\'m going to remind Fry of his humanity the way only a woman can. Kif, I have mated with a woman. Inform the men. Look, everyone wants to be like Germany, but do we really have the pure strength of \'will\'?','2014-02-10 12:58:55','2014-02-10 12:58:55',1,3);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL,
  UNIQUE KEY `unique_schema_migrations` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_migrations`
--

LOCK TABLES `schema_migrations` WRITE;
/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
INSERT INTO `schema_migrations` VALUES ('20140204134339'),('20140204135654'),('20140204135938'),('20140204142548'),('20140204193234'),('20140204194007'),('20140205124912'),('20140205173632'),('20140205211813'),('20140205212123'),('20140205212526'),('20140205212853'),('20140205213038'),('20140205220344'),('20140211175505');
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `encrypted_password` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_sent_at` datetime DEFAULT NULL,
  `remember_created_at` datetime DEFAULT NULL,
  `sign_in_count` int(11) NOT NULL DEFAULT '0',
  `current_sign_in_at` datetime DEFAULT NULL,
  `last_sign_in_at` datetime DEFAULT NULL,
  `current_sign_in_ip` varchar(255) DEFAULT NULL,
  `last_sign_in_ip` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_users_on_email` (`email`),
  UNIQUE KEY `index_users_on_reset_password_token` (`reset_password_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@admin.fr','$2a$10$oyOsiWPbBL.5Sdehx9nEGeZVsK9c70WumhXNNjA93k5YFn2ZdGViC','admin',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,'2014-02-04 13:54:37','2014-02-04 13:54:37');
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

-- Dump completed on 2014-02-12 12:57:03
