-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: scheduler.db
-- Generation Time: Dec 11, 2013 at 02:44 AM
-- Server version: 5.3.12-MariaDB
-- PHP Version: 5.3.27-nfsn1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE IF NOT EXISTS `availability` (
  `userid` int(5) NOT NULL,
  `day` smallint(1) NOT NULL,
  `avail_start` decimal(10,0) NOT NULL,
  `avail_stop` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blank`
--

CREATE TABLE IF NOT EXISTS `blank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blank`
--

INSERT INTO `blank` (`id`, `name`, `day`, `start_time`, `end_time`, `username`) VALUES
(1, '  ', NULL, NULL, NULL, '  ');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `is_manager` tinyint(1) NOT NULL,
  `manager` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`,`address`),
  KEY `email_2` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `first_name`, `last_name`, `email`, `phone`, `address`, `password`, `notes`, `checked`, `is_manager`, `manager`) VALUES
(1, 'brett', 'Brett', 'Carter', 'brett.carter@wsu.edu', '214-748-3647', '1234 Place ln', 'brettsucks', '<notes>', 1, 0, 'tester'),
(2, 'david', 'David', 'Parrott', 'david.m.parrott@wsu.edu', '123-456-7890', '1234 Place ln', 'davidrules', '<notes>', 1, 1, 'tester'),
(3, 'joe', 'Joe', 'Smith', 'joe.smith@wsu.edu', '360-123-4567', '1234 Place Ln', 'eatatjoes', 'joe is a swell guy', 1, 0, 'tester'),
(4, 'alex', 'Alex', 'Johnson', 'alex.johnson@wsu.edu', '360-123-4567', '1234 Place Ln', 'alex', 'likes coffee', 1, 0, 'tester'),
(5, 'sue', 'Sue', 'Sanders', 'sue.sanders@wsu.edu', '360-123-4567', '1234 Place Ln', 'sue', 'has a dog', 1, 0, 'tester'),
(6, 'tim', 'Tim', 'Larson', 'tim.larson@wsu.edu', '360-123-4567', '1234 Place Ln', 'tim', 'new hire', 1, 0, 'tester'),
(7, 'bill', 'Bill', 'Roberts', 'bill.roberts@wsu.edu', '360-123-4567', '1234 Place Ln', 'bill', 'also works from home', 1, 0, 'tester'),
(8, 'daryl', 'Daryl', 'Arnold', 'daryl.arnold@wsu.edu', '360-123-4567', '1234 Place Ln', 'daryl', '<notes>', 1, 0, 'tester'),
(9, 'nancy', 'Nancy', 'Botwin', 'nancy.botwin@wsu.edu', '360-123-4567', '1234 Place Ln', 'nancy', 'Has a home business', 1, 0, 'tester'),
(10, 'mavis', 'Mavis', 'Kelly', 'mavis.kelly@wsu.edu', '360-123-4567', '1234 Place Ln', 'mavis', '<notes>', 1, 0, 'tester'),
(11, 'tester', 'Test', 'Test', 'test@test.com', '123456789', '1234 place ln', '1q2w3e', '', 0, 1, 'tester'),
(12, 'mike', 'Mikhail', 'G', 'mike@wsu.edu', '3609036261', 'address', '1q2w3e', 'HATES cheese', 0, 0, 'tester'),
(13, 'qwas', 'sdfg', 'sdg', 'poisdjfg@wer.net', '1232345', 'address', '1q2w3e', '', 0, 1, 'tester'),
(14, 'elvis', 'Evlis', 'Presley', 'elvis@wsu.edu', '1234556788', '1234 place ln', '1q2w3e', 'Hail to the king, baby', 0, 0, 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `name`, `day`, `start_time`, `end_time`) VALUES
(1, 'Brett', 1, 8, 9),
(2, 'Joe', 1, 9, 12),
(3, 'Alex', 1, 12, 15),
(4, 'Sue', 1, 15, 18),
(5, 'Tim', 2, 8, 13),
(6, 'Bill', 2, 13, 15),
(7, 'Tim', 2, 15, 18),
(8, 'Daryl', 3, 8, 12),
(9, 'Sue', 3, 12, 14),
(10, 'Nancy', 3, 15, 18),
(11, 'Brett', 3, 14, 15),
(12, 'Brett', 4, 8, 12),
(13, 'Nancy', 4, 12, 15),
(14, 'David', 4, 15, 18),
(15, 'Joe', 5, 8, 15),
(16, 'Mavis', 5, 15, 17);

-- --------------------------------------------------------

--
-- Table structure for table `tester_members`
--

CREATE TABLE IF NOT EXISTS `tester_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `is_manager` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`,`address`),
  KEY `email_2` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tester_members`
--

INSERT INTO `tester_members` (`id`, `username`, `first_name`, `last_name`, `email`, `phone`, `address`, `password`, `notes`, `checked`, `is_manager`) VALUES
(1, 'brett', 'Brett', 'Carter', 'brett.carter@wsu.edu', '214-748-3647', '1234 Place ln', 'brettsucks', '<notes>', 1, 0),
(2, 'david', 'David', 'Parrott', 'david.m.parrott@wsu.edu', '123-456-7890', '1234 Place ln', 'davidrules', '<notes>', 1, 1),
(3, 'joe', 'Joe', 'Smith', 'joe.smith@wsu.edu', '360-123-4567', '1234 Place Ln', 'eatatjoes', 'joe is a swell guy', 1, 0),
(4, 'alex', 'Alex', 'Johnson', 'alex.johnson@wsu.edu', '360-123-4567', '1234 Place Ln', 'alex', 'likes coffee', 1, 0),
(5, 'sue', 'Sue', 'Sanders', 'sue.sanders@wsu.edu', '360-123-4567', '1234 Place Ln', 'sue', 'has a dog', 1, 0),
(6, 'tim', 'Tim', 'Larson', 'tim.larson@wsu.edu', '360-123-4567', '1234 Place Ln', 'tim', 'new hire', 1, 0),
(7, 'bill', 'Bill', 'Roberts', 'bill.roberts@wsu.edu', '360-123-4567', '1234 Place Ln', 'bill', 'also works from home', 1, 0),
(8, 'daryl', 'Daryl', 'Arnold', 'daryl.arnold@wsu.edu', '360-123-4567', '1234 Place Ln', 'daryl', '<notes>', 1, 0),
(9, 'nancy', 'Nancy', 'Botwin', 'nancy.botwin@wsu.edu', '360-123-4567', '1234 Place Ln', 'nancy', 'Has a home business', 1, 0),
(10, 'mavis', 'Mavis', 'Kelly', 'mavis.kelly@wsu.edu', '360-123-4567', '1234 Place Ln', 'mavis', '<notes>', 1, 0),
(11, 'tester', 'Test', 'Test', 'test@test.com', '123456789', '1234 place ln', '1q2w3e', '', 0, 1),
(12, 'elvis', 'Evlis', 'Presley', 'elvis@wsu.edu', '1234556788', '1234 place ln', '1q2w3e', 'Hail to the king, baby', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tester_schedule_LIB102`
--

CREATE TABLE IF NOT EXISTS `tester_schedule_LIB102` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tester_schedule_LIB102`
--

INSERT INTO `tester_schedule_LIB102` (`id`, `name`, `day`, `start_time`, `end_time`, `username`) VALUES
(1, 'Brett', 1, 8, 9, 'brett'),
(2, 'Joe', 1, 9, 12, 'joe'),
(3, 'Alex', 1, 12, 15, 'alex'),
(4, 'Sue', 1, 15, 18, 'sue'),
(5, 'Tim', 2, 8, 13, 'tim'),
(6, 'Bill', 2, 13, 15, 'bill'),
(7, 'Tim', 2, 15, 18, 'tim'),
(8, 'Daryl', 3, 8, 12, 'daryl'),
(9, 'Sue', 3, 12, 14, 'sue'),
(10, 'Nancy', 3, 15, 18, 'nancy'),
(11, 'Brett', 3, 14, 15, 'brett'),
(12, 'Brett', 4, 8, 12, 'brett'),
(13, 'Nancy', 4, 12, 15, 'nancy'),
(14, 'David', 4, 15, 18, 'david'),
(15, 'Joe', 5, 8, 15, 'joe'),
(16, 'Mavis', 5, 15, 17, 'mavis'),
(19, 'Brett', 0, 8, 16, 'brett'),
(18, 'Daryl', 6, 5, 19, 'daryl');

-- --------------------------------------------------------

--
-- Table structure for table `tester_schedule_MMC123`
--

CREATE TABLE IF NOT EXISTS `tester_schedule_MMC123` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tester_schedule_MMC123`
--

INSERT INTO `tester_schedule_MMC123` (`id`, `name`, `day`, `start_time`, `end_time`, `username`) VALUES
(1, 'Brett', 1, 8, 9, 'brett'),
(2, 'Joe', 1, 9, 12, 'joe'),
(3, 'Alex', 1, 12, 15, 'alex'),
(4, 'Sue', 1, 15, 18, 'sue'),
(5, 'Tim', 2, 8, 13, 'tim'),
(6, 'Bill', 2, 13, 15, 'bill'),
(7, 'Tim', 2, 15, 18, 'tim'),
(8, 'Daryl', 3, 8, 12, 'daryl'),
(9, 'Sue', 3, 12, 14, 'sue'),
(10, 'Nancy', 3, 15, 18, 'nancy'),
(11, 'Brett', 3, 14, 15, 'brett'),
(12, 'Brett', 4, 8, 12, 'brett'),
(13, 'Nancy', 4, 12, 15, 'nancy'),
(14, 'David', 4, 15, 18, 'david'),
(15, 'Joe', 5, 8, 15, 'joe'),
(16, 'Mavis', 5, 15, 17, 'mavis'),
(17, 'Evlis', NULL, NULL, NULL, 'elvis');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
