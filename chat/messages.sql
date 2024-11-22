-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2013 at 03:26 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `messages`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--



CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,        -- Store user ID for identifying sender
  `user_type` ENUM('mentor', 'student') NOT NULL,  -- Store user type
  `appointment_id` INT(11) NOT NULL, -- To associate messages with specific appointments
  `message` VARCHAR(255) NOT NULL,
  `textcolor` VARCHAR(20) NOT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- To track when the message was sent
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user`, `message`, `textcolor`) VALUES
(1, 'Argie Policarpio', 'I made this chat application', '#40F2FF');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
