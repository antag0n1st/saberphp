-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2012 at 05:10 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latin_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(510) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `category_name`, `latin_name`, `title`, `description`, `keywords`) VALUES
(1, 'category-name', 'category-name', 'category name', 'the desc of the category', 'category name keywords');

--
-- Table structure for table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(510) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `thumbnail_image_url` varchar(510) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post` mediumtext COLLATE utf8_unicode_ci,
  `keywords` varchar(510) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `author` int(10) unsigned DEFAULT NULL,
  `author_name` varchar(510) COLLATE utf8_unicode_ci NOT NULL,
  `release_date` date DEFAULT NULL,
  `is_released` int(10) unsigned DEFAULT NULL,
  `blog_categories_id` int(10) unsigned NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  `wp_id` int(11) NOT NULL,
  `permalink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_posts_FKIndex1` (`blog_categories_id`),
  KEY `release_date` (`release_date`),
  FULLTEXT KEY `title_ix_full` (`title`),
  FULLTEXT KEY `post_full_ix` (`post`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `description`, `thumbnail_image_url`, `post`, `keywords`, `date_created`, `author`, `author_name`, `release_date`, `is_released`, `blog_categories_id`, `enabled`, `wp_id`, `permalink`) VALUES
(1, 'the title it has', 'the desc', 'http://localhost/mvc/public/images/sample-1.jpg', '<p>	Lorem ipsum dolor sit amet</p><p>	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>	Duis aute irure dolor in reprehenderit<br />	in voluptate velit esse cillum dolore eu fugiat nulla pariatur<br />	Excepteur sint occaecat cupidatat non proident<br />	sunt in culpa qui officia deserunt mollit anim id est laborum.<br />	Consectetur adipisicing elit</p><p>	&nbsp;</p><p>	<img alt="" src="http://localhost/mvc/public/images/sample-5.jpg" style="float: left; width: 420px; height: 315px; " /></p><p>	<br />	Lorem ipsum dolor sit amet consectetur.<br />	Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam.</p><p>	Sed do eiusmod tempor incididunt<br />	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>	Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'Клучни Зборови', '2012-05-13 00:00:00', 1, '', '2012-05-13', 0, 1, 1, 0, 'the-title-it-has');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
