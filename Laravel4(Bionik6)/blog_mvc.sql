-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 26 Septembre 2013 à 14:18
-- Version du serveur: 5.5.27
-- Version de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `blog_mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `post_count` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `post_count`) VALUES
(1, 'Category #1', 'category-1', '2'),
(2, 'Category #2', 'category-2', '2'),
(3, 'Category #3', 'category-3', '2');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `user_id`, `name`, `slug`, `content`, `created`) VALUES
(1, 1, 1, 'Space Pilot 3000', 'space-pilot-3000', 'I don''t want to be rescued. So I really am important? How I feel when I''m drunk is correct? Leela''s gonna kill me. It''s a T. It goes "tuh". File not found. She also liked to shut up!\r\n\r\n## The Why of Fry\r\n\r\nI love this planet! I''ve got wealth, fame, and access to the depths of sleaze that those things bring. You won''t have time for sleeping, soldier, not with all the bed making you''ll be doing. Alright, let''s mafia things up a bit. Joey, burn down the ship. Clamps, burn down the crew.\r\n\r\n*   So I really am important? How I feel when I''m drunk is correct?\r\n*   No! The cat shelter''s on to me.\r\n*   No, she''ll probably make me do it.\r\n\r\n### My Three Suns\r\n\r\nOK, this has gotta stop. I''m going to remind Fry of his humanity the way only a woman can. Why yes! Thanks for noticing. Now, now. Perfectly symmetrical violence never solved anything.\r\n\r\n#### A Clockwork Origin\r\n\r\nYou can see how I lived before I met you. Can we have Bender Burgers again? I guess because my parents keep telling me to be more ladylike. As though! Hey! I''m a porno-dealing monster, what do I care what you think? You know, I was God once.\r\n\r\n1.  You lived before you met me?!\r\n2.  They''re like sex, except I''m having them!\r\n3.  You, a bobsleder!? That I''d like to see!\r\n\r\n##### Leela''s Homeworld\r\n\r\nYep, I remember. They came in last at the Olympics, then retired to promote alcoholic beverages! Large bet on myself in round one. Actually, that''s still true. Ask her how her day was. In your time, yes, but nowadays shut up! Besides, these are adult stemcells, harvested from perfectly healthy adults whom I killed for their stemcells. Why not indeed!', '2013-09-22 18:00:00'),
(2, 2, 1, 'Rebirth', 'rebirth', 'Yep, I remember. They came in last at the Olympics, then retired to promote alcoholic beverages! You know, I was God once. That could be ''my'' beautiful soul sitting naked on a couch. If I could just learn to play this stupid thing. Okay, I like a challenge. I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n\r\n## I, Roommate\r\n\r\nNow, now. Perfectly symmetrical violence never solved anything. With a warning label this big, you know they gotta be fun! I''m Santa Claus!\r\n\r\n*   You guys realize you live in a sewer, right?\r\n*   Okay, I like a challenge.\r\n*   Robot 1-X, save my friends!  And Zoidberg!\r\n\r\n### Love and Rocket\r\n\r\nCan we have Bender Burgers again? This is the worst part. The calm before the battle. For one beautiful night I knew what it was like to be a grandmother. Subjugated, yet honored. You''ll have all the Slurm you can drink when you''re partying with Slurms McKenzie!\r\n\r\n#### War Is the H-Word\r\n\r\nYou know the worst thing about being a slave? They make you work, but they don''t pay you or let you go. Ooh, name it after me! Kids don''t turn rotten just from watching TV. You guys aren''t Santa! You''re not even robots. How dare you lie in front of Jesus?\r\n\r\n1.  Why yes! Thanks for noticing.\r\n2.  You guys aren''t Santa! You''re not even robots. How dare you lie in front of Jesus?\r\n3.  There''s no part of that sentence I didn''t like!\r\n4.  I had more, but you go ahead.\r\n5.  Bender, we''re trying our best.\r\n\r\n##### Anthology of Interest II\r\n\r\nGoodbye, cruel world. Goodbye, cruel lamp. Goodbye, cruel velvet drapes, lined with what would appear to be some sort of cruel muslin and the cute little pom-pom curtain pull cords. Cruel though they may be&hellip; It must be wonderful. Leela, are you alright? You got wanged on the head.', '2013-09-22 16:49:55'),
(3, 3, 1, 'Future Stock', 'future-stock', 'You, a bobsleder!? That I''d like to see! I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him. Robot 1-X, save my friends!  And Zoidberg! You know the worst thing about being a slave? They make you work, but they don''t pay you or let you go. OK, this has gotta stop. I''m going to remind Fry of his humanity the way only a woman can. Good news, everyone! There''s a report on TV with some very bad news!\r\n\r\n## Roswell That Ends Well\r\n\r\nWhy yes! Thanks for noticing. For the last time, I don''t like lilacs!  Your ''first'' wife was the one who liked lilacs! We''ll go deliver this crate like professionals, and then we''ll go home.\r\n\r\n*   Why yes! Thanks for noticing.\r\n*   That''s the ONLY thing about being a slave.\r\n*   OK, this has gotta stop. I''m going to remind Fry of his humanity the way only a woman can.\r\n*   It must be wonderful.\r\n\r\n### A Tale of Two Santas\r\n\r\nThis is the worst part. The calm before the battle. There''s no part of that sentence I didn''t like! Ask her how her day was.\r\n\r\n#### Bendless Love\r\n\r\nYour best is an idiot! Oh dear! She''s stuck in an infinite loop, and he''s an idiot! Well, that''s love for you. I''m sure those windmills will keep them cool. I had more, but you go ahead. Fry! Stay back! He''s too powerful! No, she''ll probably make me do it.\r\n\r\n1.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n2.  Kif might!\r\n3.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n4.  Goodbye, cruel world. Goodbye, cruel lamp. Goodbye, cruel velvet drapes, lined with what would appear to be some sort of cruel muslin and the cute little pom-pom curtain pull cords. Cruel though they may be&hellip;\r\n\r\n##### The Series Has Landed\r\n\r\nOoh, name it after me! In your time, yes, but nowadays shut up! Besides, these are adult stemcells, harvested from perfectly healthy adults whom I killed for their stemcells. No, of course not. It was&hellip; uh&hellip; porno. Yeah, that''s it. So I really am important? How I feel when I''m drunk is correct? I suppose I could part with ''one'' and still be feared&hellip; Well I''da done better, but it''s plum hard pleading a case while awaiting trial for that there incompetence.', '2013-09-22 16:52:52'),
(4, 1, 1, 'Parasites Lost', 'parasites-lost', 'I love this planet! I''ve got wealth, fame, and access to the depths of sleaze that those things bring. You, minion. Lift my arm. AFTER HIM! I don''t want to be rescued. I had more, but you go ahead. I''m Santa Claus! Hey! I''m a porno-dealing monster, what do I care what you think?\r\n\r\n## The Deep South\r\n\r\nOh dear! She''s stuck in an infinite loop, and he''s an idiot! Well, that''s love for you. I was having the most wonderful dream. Except you were there, and you were there, and you were there! File not found. Man, I''m sore all over. I feel like I just went ten rounds with mighty Thor. But, like most politicians, he promised more than he could deliver. I guess because my parents keep telling me to be more ladylike. As though!\r\n\r\n*   They''re like sex, except I''m having them!\r\n*   You know, I was God once.\r\n*   Then we''ll go with that data file!\r\n\r\n### Devil''s Hands are Idle Playthings\r\n\r\nActually, that''s still true. No, she''ll probably make me do it. Oh, I always feared he might run off like this. Why, why, why didn''t I break his legs? WINDMILLS DO NOT WORK THAT WAY! GOOD NIGHT! This is the worst part. The calm before the battle.\r\n\r\n#### The Deep South\r\n\r\nFor the last time, I don''t like lilacs!  Your ''first'' wife was the one who liked lilacs! Pansy. You know, I was God once.\r\n\r\n1.  You, a bobsleder!? That I''d like to see!\r\n2.  Well I''da done better, but it''s plum hard pleading a case while awaiting trial for that there incompetence.\r\n\r\n##### Bendin'' in the Wind\r\n\r\nI usually try to keep my sadness pent up inside where it can fester quietly as a mental illness. No, of course not. It was&hellip; uh&hellip; porno. Yeah, that''s it. Your best is an idiot! There''s no part of that sentence I didn''t like! They''re like sex, except I''m having them! I had more, but you go ahead.', '2013-09-22 16:53:16'),
(5, 2, 1, 'The Sting', 'the-sting', 'Your best is an idiot! Can we have Bender Burgers again? That could be ''my'' beautiful soul sitting naked on a couch. If I could just learn to play this stupid thing. You guys realize you live in a sewer, right? Now that the, uh, garbage ball is in space, Doctor, perhaps you can help me with my sexual inhibitions? I love this planet! I''ve got wealth, fame, and access to the depths of sleaze that those things bring.\r\n\r\n## Kif Gets Knocked Up A Notch\r\n\r\nLeela, are you alright? You got wanged on the head. Come, Comrade Bender! We must take to the streets! Man, I''m sore all over. I feel like I just went ten rounds with mighty Thor.\r\n\r\n*   I love this planet! I''ve got wealth, fame, and access to the depths of sleaze that those things bring.\r\n*   OK, this has gotta stop. I''m going to remind Fry of his humanity the way only a woman can.\r\n\r\n### Anthology of Interest I\r\n\r\nWe''re rescuing ya. I''m sure those windmills will keep them cool. Oh dear! She''s stuck in an infinite loop, and he''s an idiot! Well, that''s love for you. But I''ve never been to the moon!\r\n\r\n#### Lrrreconcilable Ndndifferences\r\n\r\nWe''ll go deliver this crate like professionals, and then we''ll go home. You are the last hope of the universe. Fatal. No! The cat shelter''s on to me. Fry! Stay back! He''s too powerful! So I really am important? How I feel when I''m drunk is correct?\r\n\r\n1.  I barely knew Philip, but as a clergyman I have no problem telling his most intimate friends all about him.\r\n2.  We can''t compete with Mom! Her company is big and evil! Ours is small and neutral!\r\n3.  Hello, little man. I will destroy you!\r\n\r\n##### Bendless Love\r\n\r\nHello, little man. I will destroy you! Ooh, name it after me! Well I''da done better, but it''s plum hard pleading a case while awaiting trial for that there incompetence. You know, I was God once. You won''t have time for sleeping, soldier, not with all the bed making you''ll be doing. With a warning label this big, you know they gotta be fun!', '2013-09-22 16:53:30');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$08$jDavuEkVJoIN8oZeuMjUfOteVaOyeu/FTvyH1cVXTlfd8KkoU6nM2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
