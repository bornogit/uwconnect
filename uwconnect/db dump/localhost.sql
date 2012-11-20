-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2012 at 06:07 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `connect`
--
CREATE DATABASE `connect` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `connect`;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `handle1` varchar(18) NOT NULL,
  `handle2` varchar(18) NOT NULL,
  `messages` text NOT NULL,
  PRIMARY KEY (`handle1`,`handle2`),
  KEY `handle1` (`handle1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `Handle` varchar(16) NOT NULL,
  `Message` text NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`Handle`, `Message`, `Time`, `id`) VALUES
('borno', 'sdfsdtest', '2012-11-15 15:47:49', 61),
('borno', 'tests', '2012-11-15 15:47:50', 62),
('borno', '1', '2012-11-15 15:53:12', 63),
('borno', 'new text', '2012-11-15 16:42:31', 71),
('borno', 'even newer', '2012-11-15 16:42:38', 72),
('borno', 'new text;;\n', '2012-11-15 16:47:11', 73),
('borno', 'new text2', '2012-11-15 16:46:30', 74),
('borno', 'can you see me?\n', '2012-11-15 16:49:30', 75),
('borno', 'Yes I can', '2012-11-15 16:49:38', 76),
('', 'dfd', '2012-11-15 23:09:02', 77),
(' borno', 'test', '2012-11-15 23:23:27', 78),
(' borno', '', '2012-11-15 23:37:58', 79),
(' borno', '', '2012-11-15 23:36:50', 80),
(' borno', '', '2012-11-15 23:37:05', 81),
(' borno', 'dfdsf', '2012-11-15 23:40:24', 82),
('borno', 'this is a brand new message\n', '2012-11-15 23:44:55', 83),
('new', 'can you see me now?', '2012-11-15 23:48:06', 84),
('borno', 'Yes I can .', '2012-11-15 23:48:16', 85),
('new', 'Great !', '2012-11-15 23:47:28', 86),
('new', 'logging out.!!', '2012-11-15 23:48:46', 87),
('zainab', 'bh\n', '2012-11-17 02:16:43', 88),
('zainab', 'lmlm\n', '2012-11-19 16:28:54', 89);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Handle` varchar(18) NOT NULL,
  `Password` text NOT NULL,
  `EMail` text NOT NULL,
  `FName` text NOT NULL,
  `LName` text NOT NULL,
  `IsConnected` tinyint(1) NOT NULL DEFAULT '0',
  `MsgId` bigint(20) NOT NULL,
  PRIMARY KEY (`Handle`),
  UNIQUE KEY `Handle` (`Handle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Handle`, `Password`, `EMail`, `FName`, `LName`, `IsConnected`, `MsgId`) VALUES
('abcd', '', '', '', '', 0, 0),
('asdfsdf', '0$fzSX8JzA0Vw', 'asdfsdf', '', '', 0, 0),
('borno', '0$2eQ.jdDCvbs', 'borno', 'borno', 'akhter', 0, 88),
('ds', '0$fzSX8JzA0Vw', '', '', '', 0, 0),
('fsdf', '0$V5jp2BvObrY', 'dfasdfas', 'adsf', 'adsf', 0, 0),
('new', '0$2eQ.jdDCvbs', 'zainab@cs.wisc.edu', 'new', 'user', 0, 88),
('t', '', '', '', '', 0, 0),
('zainab', '0$XC9bqmXte4U', 'zainabg@gmail.com', 'zainab', 'ghadiyali', 0, 89),
('zainab1', '0$DsnU65UIqEM', 'zainab@cs.wisc.edu', 'zainab', 'Ghadiyali', 0, 88);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`handle1`) REFERENCES `users` (`Handle`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
