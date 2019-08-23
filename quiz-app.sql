-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 23, 2019 at 11:58 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `a` varchar(45) NOT NULL,
  `b` varchar(45) NOT NULL,
  `c` varchar(45) NOT NULL,
  `d` varchar(45) NOT NULL,
  `e` varchar(45) NOT NULL,
  `answer` varchar(45) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`, `a`, `b`, `c`, `d`, `e`, `answer`) VALUES
(1, 'Who was the first man to fly around the earth with a spaceship?', 'Alan Shepard', 'Torricelli', 'Alexander Fleming', 'Gagarin', 'Neil Armstrong', 'Gagarin'),
(2, 'What color is cobalt?', 'Black', 'Brown', 'Silver', 'Crimson-red', 'Blue', 'Blue'),
(3, 'Which unit indicates the light intensity?', 'Lux', 'Candela', 'Watt', 'Volt', 'Hertz', 'Candela'),
(4, 'What is the lightest existing metal?', 'Copper', 'Silver', 'Aluminium', 'Potassium', 'Mercury', 'Aluminium'),
(5, 'What are the three primary colors?', 'Blue, yellow and red', 'Blue, green and red', 'Cyan, magenta and yellow', 'Purple, orange and green', 'Purple, Pink and brown', 'Blue, yellow and red');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `marks` double NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `marks`) VALUES
(1, 'Osusara Kammalawatta', 'osusarak@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 5),
(2, 'Sanduni Maduhansini', 'srsmsone@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 5),
(3, 'Dummy User 1', 'dummy@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 3),
(4, 'Viduranga Kariyawasam', 'vidurangak@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2),
(7, 'Harendu Santhila', 'harendu@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
