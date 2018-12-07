-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2017 at 07:37 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hetrotec_exams`
--

/*CREATE DATABASE IF NOT EXISTS `hetrotec_exams`;*/

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `IP` varbinary(16) NOT NULL,
  `last_login` timestamp NOT NULL,
  `browser_used` varchar(255) DEFAULT NULL,
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `is_admin` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;


--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `firstname`, `lastname`, `password`, `email`, `IP`, `last_login`, `is_blocked`, `is_admin`) VALUES
(1, 'HetroTech', 'Hetro', 'Tech', '$2y$10$lhiXdrMXPWgvoQCECLqNb.rl3hyRInqy5g4oMKjpVTYxtDOzO6Sma', 'default@default.com', '::1', '2027-05-28 15:15:14',  0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `questions` int(11) NOT NULL,
  `marks` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_category_title` (`category_id`,`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE IF NOT EXISTS `category_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_category_name` (`category_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `slot` time NOT NULL,
  `package` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_course_users` (`users_id`),
  KEY `fk_course_category` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `english_marks`
--

CREATE TABLE IF NOT EXISTS `english_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `positive` int(11) NOT NULL,
  `negative` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_english_marks` (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `english_questions`
--

CREATE TABLE IF NOT EXISTS `english_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question_direction` text NOT NULL,
  `question` text NOT NULL,
  `question_type` int(11) DEFAULT NULL,
  `img` tinyint(11) NOT NULL DEFAULT '0',
  `opt_1` text NOT NULL,
  `opt_2` text NOT NULL,
  `opt_3` text NOT NULL,
  `opt_4` text NOT NULL,
  `opt_5` text,
  `opt_6` text,
  `solution` text NOT NULL,
  `paragraph_id` int(11) DEFAULT '0',
  `question_category` varchar(255) DEFAULT NULL,
  `correct_opt` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `rel_number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_questions` (`question_id`,`category_id`),
  KEY `fk_english_category_1` (`category_id`),
  KEY `fk_english_questions_course` (`is_active`),
  KEY `fk_english_category_2` (`paragraph_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `paragraph_english`
--

CREATE TABLE IF NOT EXISTS `paragraph_english` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paragraph_text` text NOT NULL,
  `total` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `DOB` varchar(255) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `user_answers_english`
--

CREATE TABLE IF NOT EXISTS `user_answers_english` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `obtained` float NOT NULL,
  `opt_select` int(11) DEFAULT NULL,
  `elapsed` int(11) DEFAULT '0',
  `is_answered` tinyint(4) NOT NULL DEFAULT '0',
  `is_marked` tinyint(4) NOT NULL DEFAULT '0',
  `is_correct` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_question` (`users_id`,`question_id`),
  KEY `fk_user_answers_english_course` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `user_paper`
--

CREATE TABLE IF NOT EXISTS `user_paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `time_taken` int(11) NOT NULL,
  `is_attempted` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finish` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paper_users` (`users_id`),
  KEY `fk_paper_category` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
