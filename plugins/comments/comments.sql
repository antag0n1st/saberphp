-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2011 at 08:44 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filmiko`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username_avatar` varchar(510) COLLATE utf8_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_addresses` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(510) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `id_comment` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `item_id`, `comment`, `username`, `username_avatar`, `likes`, `dislikes`, `date_created`, `ip_addresses`, `url`) VALUES
(1, '1_movie', 'the comment for the movie avatar , that should be tested ', 'antagonist', '', 4, 3, '2011-08-27 21:04:30', '|192.168.16.1', NULL),
(2, '1_movie', 'an other comment , just for the record', 'antagonist', '', 11, 2, '2011-08-27 21:08:11', '|192.168.16.1', NULL),
(3, '3_movie', 'ajde da napravime test komentar\\n', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-03 17:45:27', '|192.168.16.1', NULL),
(4, '1_movie', '200 komentari', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-18 09:09:39', '|192.168.16.1', NULL),
(5, '1_movie', '"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-18 09:10:11', '|192.168.16.1', NULL),
(6, '1_movie', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-18 09:10:34', '|192.168.16.1', NULL),
(7, '1_movie', '"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-18 09:10:47', '|192.168.16.1', NULL),
(8, '1_movie', ' Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. ', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:26:32', '', NULL),
(9, '1_movie', ' ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupi', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:26:41', '', NULL),
(10, '1_movie', 'an happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever unde', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:26:47', '', NULL),
(11, '1_movie', 'oluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto 2011-09-18 09:10:34   (1)Antagonist Vs Protagonist "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying c', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:26:56', '', NULL),
(12, '1_movie', 'use it is pleasure, but because those who do not know how to pursue pleasure rationally encounter ', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:27:16', '', NULL),
(13, '1_movie', '<a href="http://www.google.com" target="_blank" rel="nofollow" >www.google.com</a> and some atempt for injection  and JS alert(yeah'');', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:40:12', '', NULL),
(14, '1_movie', '<a href="http://www.google.com" target="_blank" rel="nofollow" >www.google.com</a>', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:44:29', '', NULL),
(15, '1_movie', 'here we go , with a comment', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 1, 0, '2011-09-18 09:47:43', '|192.168.16.1', NULL),
(16, '1_movie', 'some other comment', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 09:48:28', '', NULL),
(17, '1_movie', 'some more accurate post , comment', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 11:54:11', '', NULL),
(18, '1_movie', 'yeah , ... I can comment all day ', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 11:58:16', '', NULL),
(19, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:07:06', '', NULL),
(20, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:07:46', '', NULL),
(21, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:07:55', '', NULL),
(22, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:08:00', '', NULL),
(23, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:08:38', '', NULL),
(24, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:10:00', '', NULL),
(25, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:10:37', '', NULL),
(26, '4_movie', '', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:11:49', '', NULL),
(27, '4_movie', ' ', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:13:30', '', NULL),
(28, '4_movie', ' ', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 0, 0, '2011-09-18 12:13:51', '', NULL),
(29, '6_post', 'lets ride', 'Antagonist Vs Protagonist', 'https://graph.facebook.com/100000549537389/picture', 2, 0, '2011-10-02 20:35:18', '|79.126.230.73', NULL),
(30, '59_movie', 'lala', '', '', 0, 0, '2011-10-09 18:15:59', '', NULL),
(31, '63_movie', 'hey man , what the fuck', 'kirca', 'http://92.53.35.178/movies.mk/images/avatars/angelina_jolie.jpg', 1, 0, '2011-10-29 19:15:13', '|192.168.16.1', NULL),
(32, '66_movie', 'Jake komentira :D', 'Jake', 'http://92.53.35.178/movies.mk/images/avatars/jake.jpg', 1, 0, '2011-10-29 19:21:01', '|79.126.229.182', NULL),
(33, '59_movie', 'e ova e dobar film , LA , la la la .... LA', 'po', 'http://92.53.35.178/movies.mk/images/avatars/angelina_jolie.jpg', 0, 0, '2011-10-29 19:28:16', '', NULL),
(34, '25_movie', 'my favorite', 'Vlado', 'http://92.53.35.178/movies.mk/images/avatars/brad_pitt.jpg', 1, 0, '2011-10-29 20:09:40', '|79.126.229.182', NULL),
(35, '58_movie', 'yeah komentar', 'petre', 'http://92.53.35.178/movies.mk/images/avatars/neytiri.jpg', 0, 0, '2011-10-30 13:08:54', '', NULL),
(36, '9_post', 'JA batka , nema zenska shto ne sum ja fatil za gz', 'naj jaci fraer', 'http://92.53.35.178/movies.mk/images/avatars/brad_pitt.jpg', 0, 0, '2011-10-30 13:25:17', '', ''),
(37, '9_post', 'seljacishte ni edno', 'zena mu', 'http://92.53.35.178/movies.mk/images/avatars/angelina_jolie.jpg', 0, 0, '2011-10-30 13:26:48', '', 'http://92.53.35.178/movies.mk/filmski-vesti/filmovi/megamind---genijalniot-nauchnik/9');
