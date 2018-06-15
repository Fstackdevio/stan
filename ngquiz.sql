-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2018 at 09:22 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matric` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `level` int(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `access` int(3) NOT NULL,
  `course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`_id`, `firstname`, `lastname`, `email`, `matric`, `department`, `college`, `level`, `role`, `date_created`, `date_modified`, `created_by`, `fullName`, `username`, `password`, `active`, `access`, `course`) VALUES
(1, 'admin', 'monestara', 'admin@stan.com', 'null', 'administrative', 'engineering', 1, 'admin', '2018-05-28 16:09:13', '2018-06-02 21:06:15', 'adeojo emmanuel', 'adeojo emmanuel', 'admin', '$2a$10$0312b44a43bac64f1b8c4eaklUow743sKKPNQ98lJeg9vugKB0Y4y', 1, 1, 'mat222');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(255) NOT NULL,
  `staff_id` int(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `duration`, `staff_id`, `date_created`, `date_modified`) VALUES
(1, 'mat 222', 30, 1, '2018-05-24 10:04:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `duration` int(255) NOT NULL,
  `instructions` varchar(255) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`_id`, `name`, `pwd`, `duration`, `instructions`, `disabled`, `unit`, `instructor`, `date_created`, `date_modified`) VALUES
(1, 'mat222', 'mag', 10, 'answer all question', 0, '3', 'adebimpe', '2018-05-25 07:39:00', '2018-05-25 07:39:00'),
(3, 'CSC 313', 'happy', 60, 'Attempt all 70 questions in 1 hour', 0, '3', 'Ms. Ashley Paige', '2018-05-25 09:14:19', '2018-05-25 09:14:19'),
(4, 'Select a course', 'Neutralize', 60, '', 0, '0', 'Mr admin', '2018-05-25 09:15:58', '2018-05-25 09:15:58'),
(5, 'csc 421', 'jjg', 60, 'careful before you jam wall', 1, '3', 'Mr robinsin', '2018-05-28 17:33:30', '2018-05-28 17:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(255) NOT NULL,
  `qid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_id` int(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `qid`, `name`, `course_id`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 1, '1', 0, '4', '3', '2', '1', '4'),
(2, 2, '1', 0, '1', '3', '4', '2', '1'),
(3, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(4, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(5, 1, '1', 0, '4', '3', '2', '1', '4'),
(6, 2, '1', 0, '1', '3', '4', '2', '1'),
(7, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(8, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(9, 1, '1', 0, '4', '3', '2', '1', '4'),
(10, 2, '1', 0, '1', '3', '4', '2', '1'),
(11, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(12, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(13, 1, '1', 0, '4', '3', '2', '1', '4'),
(14, 2, '1', 0, '1', '3', '4', '2', '1'),
(15, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(16, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(17, 1, '3', 0, '4', '3', '2', '1', '4'),
(18, 2, '3', 0, '1', '3', '4', '2', '1'),
(19, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(20, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(21, 1, '3', 0, '4', '3', '2', '1', '4'),
(22, 2, '3', 0, '1', '3', '4', '2', '1'),
(23, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(24, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(25, 1, '1', 0, '4', '3', '2', '1', '4'),
(26, 2, '1', 0, '1', '3', '4', '2', '1'),
(27, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(28, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(29, 1, '3', 0, '4', '3', '2', '1', '4'),
(30, 2, '3', 0, '1', '3', '4', '2', '1'),
(31, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(32, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(33, 1, '3', 0, '4', '3', '2', '1', '4'),
(34, 2, '3', 0, '1', '3', '4', '2', '1'),
(35, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(36, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(37, 1, '3', 0, '4', '3', '2', '1', '4'),
(38, 2, '3', 0, '1', '3', '4', '2', '1'),
(39, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(40, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(41, 1, '1', 0, '4', '3', '2', '1', '4'),
(42, 2, '1', 0, '1', '3', '4', '2', '1'),
(43, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(44, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(45, 1, '', 0, '4', '3', '2', '1', '4'),
(46, 2, '', 0, '1', '3', '4', '2', '1'),
(47, 3, '', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(48, 4, '', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(49, 1, '3', 0, '4', '3', '2', '1', '4'),
(50, 2, '3', 0, '1', '3', '4', '2', '1'),
(51, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(52, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(53, 1, '1', 0, '4', '3', '2', '1', '4'),
(54, 2, '1', 0, '1', '3', '4', '2', '1'),
(55, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(56, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(57, 1, '3', 0, '4', '3', '2', '1', '4'),
(58, 2, '3', 0, '1', '3', '4', '2', '1'),
(59, 3, '3', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(60, 4, '3', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(61, 1, '1', 0, '4', '3', '2', '1', '4'),
(62, 2, '1', 0, '1', '3', '4', '2', '1'),
(63, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(64, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(65, 1, '1', 0, '4', '3', '2', '1', '4'),
(66, 2, '1', 0, '1', '3', '4', '2', '1'),
(67, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(68, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(69, 1, '1', 0, '4', '3', '2', '1', '4'),
(70, 2, '1', 0, '1', '3', '4', '2', '1'),
(71, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(72, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(73, 1, '1', 0, '4', '3', '2', '1', '4'),
(74, 2, '1', 0, '1', '3', '4', '2', '1'),
(75, 3, '1', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(76, 4, '1', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(77, 1, '', 0, '4', '3', '2', '1', '4'),
(78, 2, '', 0, '1', '3', '4', '2', '1'),
(79, 3, '', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(80, 4, '', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai'),
(81, 1, '', 0, '4', '3', '2', '1', '4'),
(82, 2, '', 0, '1', '3', '4', '2', '1'),
(83, 3, '', 0, 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo'),
(84, 4, '', 0, 'jay jay', 'bobby', 'papa', 'fatai', 'fatai');

-- --------------------------------------------------------

--
-- Table structure for table `outcomes`
--

CREATE TABLE `outcomes` (
  `_id` int(50) NOT NULL,
  `exam_id` int(50) NOT NULL,
  `std_id` int(50) NOT NULL,
  `score` varchar(255) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `course_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outcomes`
--

INSERT INTO `outcomes` (`_id`, `exam_id`, `std_id`, `score`, `valid`, `created_on`, `modified_on`, `course_id`) VALUES
(1, 0, 0, '', 0, '2018-06-15 16:10:07', '2018-06-15 16:10:07', 0),
(2, 0, 0, '', 0, '2018-06-15 17:15:35', '2018-06-15 17:15:35', 0),
(3, 0, 0, '', 0, '2018-06-15 17:22:15', '2018-06-15 17:22:15', 0),
(4, 0, 1, '0', 1, '2018-06-15 17:47:28', '2018-06-15 17:47:28', 3),
(5, 0, 1, '0', 1, '2018-06-15 18:00:50', '2018-06-15 18:00:50', 1),
(6, 0, 1, '0', 1, '2018-06-15 19:55:17', '2018-06-15 19:55:17', 1),
(7, 0, 1, '0', 1, '2018-06-15 19:55:42', '2018-06-15 19:55:42', 1),
(8, 0, 1, '0', 1, '2018-06-15 19:57:50', '2018-06-15 19:57:50', 1),
(9, 0, 1, '0', 1, '2018-06-15 20:01:51', '2018-06-15 20:01:51', 1),
(10, 0, 1, '0', 1, '2018-06-15 20:05:31', '2018-06-15 20:05:31', 1),
(11, 0, 1, '0', 1, '2018-06-15 20:06:10', '2018-06-15 20:06:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `method`, `uri`, `api_key`, `date_added`, `date_updated`) VALUES
(1, ' Net Banking', '', '', '2018-06-09 14:41:26', '0000-00-00 00:00:00'),
(2, 'Cash On Delivery', '', '', '2018-06-09 14:41:26', '0000-00-00 00:00:00'),
(3, 'EMI Conversion', '', '', '2018-06-09 14:41:55', '0000-00-00 00:00:00'),
(4, 'Debit/Credit Card', '', '', '2018-06-09 14:41:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pref_resource`
--

CREATE TABLE `pref_resource` (
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `extras` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(255) NOT NULL,
  `qid` int(255) NOT NULL,
  `course_id` int(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` varchar(255) NOT NULL,
  `explanation` varchar(255) NOT NULL,
  `isAnswered` tinyint(1) NOT NULL DEFAULT '0',
  `picked` varchar(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `qid`, `course_id`, `question`, `name`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation`, `isAnswered`, `picked`, `date_modified`, `date_added`) VALUES
(1, 1, 1, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:24'),
(2, 2, 1, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:24'),
(3, 3, 1, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:24'),
(4, 4, 1, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:24'),
(5, 1, 1, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', 'answer all question', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:46'),
(6, 2, 1, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', 'answer all question', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:46'),
(7, 3, 1, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'answer all question', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:46'),
(8, 4, 1, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'answer all question', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:30:46'),
(9, 1, 1, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', 'basic explanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:11'),
(10, 2, 1, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', 'basic explanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:11'),
(11, 3, 1, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'basic explanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:11'),
(12, 4, 1, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'basic explanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:11'),
(13, 1, 1, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', 'basicexplanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:35'),
(14, 2, 1, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', 'basicexplanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:35'),
(15, 3, 1, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'basicexplanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:35'),
(16, 4, 1, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'basicexplanation', 0, '', '0000-00-00 00:00:00', '2018-06-04 21:59:35'),
(17, 1, 3, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', 'basic test', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:12'),
(18, 2, 3, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', 'basic test', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:12'),
(19, 3, 3, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'basic test', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:12'),
(20, 4, 3, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'basic test', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:12'),
(21, 1, 3, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:23'),
(22, 2, 3, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:23'),
(23, 3, 3, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:23'),
(24, 4, 3, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:01:23'),
(25, 1, 1, 'what is 2+2 ?', '', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:04:16'),
(26, 2, 1, 'what  is 3-2 ?', '', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:04:16'),
(27, 3, 1, 'who is the best footballer', '', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:04:16'),
(28, 4, 1, 'who is the governor of kwara', '', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:04:16'),
(29, 1, 3, 'what is 2+2 ?', '', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:08:02'),
(30, 2, 3, 'what  is 3-2 ?', '', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:08:02'),
(31, 3, 3, 'who is the best footballer', '', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:08:02'),
(32, 4, 3, 'who is the governor of kwara', '', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-04 22:08:02'),
(33, 1, 3, 'what is 2+2 ?', 't5estv', '4', '3', '2', '1', '4', 'simple test 4', 0, '', '0000-00-00 00:00:00', '2018-06-05 04:24:30'),
(34, 2, 3, 'what  is 3-2 ?', 't5estv', '1', '3', '4', '2', '1', 'simple test 4', 0, '', '0000-00-00 00:00:00', '2018-06-05 04:24:30'),
(35, 3, 3, 'who is the best footballer', 't5estv', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'simple test 4', 0, '', '0000-00-00 00:00:00', '2018-06-05 04:24:30'),
(36, 4, 3, 'who is the governor of kwara', 't5estv', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'simple test 4', 0, '', '0000-00-00 00:00:00', '2018-06-05 04:24:30'),
(37, 1, 3, 'what is 2+2 ?', 'main course', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 05:36:10'),
(38, 2, 3, 'what  is 3-2 ?', 'main course', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 05:36:10'),
(39, 3, 3, 'who is the best footballer', 'main course', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 05:36:10'),
(40, 4, 3, 'who is the governor of kwara', 'main course', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 05:36:10'),
(41, 1, 1, 'what is 2+2 ?', 'tes', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:04:42'),
(42, 2, 1, 'what  is 3-2 ?', 'tes', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:04:42'),
(43, 3, 1, 'who is the best footballer', 'tes', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:04:42'),
(44, 4, 1, 'who is the governor of kwara', 'tes', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:04:42'),
(45, 1, 0, 'what is 2+2 ?', 'kmk', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:16:45'),
(46, 2, 0, 'what  is 3-2 ?', 'kmk', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:16:45'),
(47, 3, 0, 'who is the best footballer', 'kmk', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:16:45'),
(48, 4, 0, 'who is the governor of kwara', 'kmk', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:16:45'),
(49, 1, 3, 'what is 2+2 ?', 'ts', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:25:29'),
(50, 2, 3, 'what  is 3-2 ?', 'ts', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:25:29'),
(51, 3, 3, 'who is the best footballer', 'ts', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:25:29'),
(52, 4, 3, 'who is the governor of kwara', 'ts', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:25:29'),
(53, 1, 1, 'what is 2+2 ?', 'mathematics', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:27:22'),
(54, 2, 1, 'what  is 3-2 ?', 'mathematics', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:27:22'),
(55, 3, 1, 'who is the best footballer', 'mathematics', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:27:22'),
(56, 4, 1, 'who is the governor of kwara', 'mathematics', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:27:22'),
(57, 1, 3, 'what is 2+2 ?', 'null', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:29:14'),
(58, 2, 3, 'what  is 3-2 ?', 'null', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:29:14'),
(59, 3, 3, 'who is the best footballer', 'null', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:29:14'),
(60, 4, 3, 'who is the governor of kwara', 'null', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:29:14'),
(61, 1, 1, 'what is 2+2 ?', '', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:30:39'),
(62, 2, 1, 'what  is 3-2 ?', '', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:30:39'),
(63, 3, 1, 'who is the best footballer', '', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:30:39'),
(64, 4, 1, 'who is the governor of kwara', '', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:30:39'),
(65, 1, 1, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:33:44'),
(66, 2, 1, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:33:44'),
(67, 3, 1, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:33:44'),
(68, 4, 1, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 06:33:44'),
(69, 1, 1, 'what is 2+2 ?', 'tes', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:01:51'),
(70, 2, 1, 'what  is 3-2 ?', 'tes', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:01:51'),
(71, 3, 1, 'who is the best footballer', 'tes', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:01:51'),
(72, 4, 1, 'who is the governor of kwara', 'tes', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:01:51'),
(73, 1, 1, 'what is 2+2 ?', 'tes', '4', '3', '2', '1', '4', 'test', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:02:29'),
(74, 2, 1, 'what  is 3-2 ?', 'tes', '1', '3', '4', '2', '1', 'test', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:02:29'),
(75, 3, 1, 'who is the best footballer', 'tes', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', 'test', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:02:29'),
(76, 4, 1, 'who is the governor of kwara', 'tes', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', 'test', 0, '', '0000-00-00 00:00:00', '2018-06-05 19:02:29'),
(77, 1, 0, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 21:28:32'),
(78, 2, 0, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 21:28:32'),
(79, 3, 0, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 21:28:32'),
(80, 4, 0, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-05 21:28:32'),
(81, 1, 0, 'what is 2+2 ?', 'test', '4', '3', '2', '1', '4', '', 0, '', '0000-00-00 00:00:00', '2018-06-06 20:06:32'),
(82, 2, 0, 'what  is 3-2 ?', 'test', '1', '3', '4', '2', '1', '', 0, '', '0000-00-00 00:00:00', '2018-06-06 20:06:32'),
(83, 3, 0, 'who is the best footballer', 'test', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '', 0, '', '0000-00-00 00:00:00', '2018-06-06 20:06:32'),
(84, 4, 0, 'who is the governor of kwara', 'test', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '', 0, '', '0000-00-00 00:00:00', '2018-06-06 20:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(255) NOT NULL,
  `reg_no` int(255) NOT NULL,
  `matric_no` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `reg_no`, `matric_no`, `firstname`, `lastname`, `password`, `date_added`, `date_modified`) VALUES
(1, 1601376, '16', 'joshua', 'musa', '$2y$10$g0XJna/RlkQX2j9ozwA0tuNPZtDb5qPOcakKGNjiceRo.niC13c8m', '2018-05-24 09:56:59', '0000-00-00 00:00:00'),
(2, 1601376, '16CD004618', 'joshua', 'musa', '$2y$10$F0ZpVZ91GlAIjwq/ka4DQ.rTAEpvuBpO9YvdORUvz4d.8PxVgqoc2', '2018-05-24 09:56:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `level` int(255) NOT NULL,
  `hall` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `reg_number` int(255) NOT NULL,
  `matric` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `active` int(2) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`_id`, `firstname`, `lastname`, `username`, `othername`, `fullName`, `college`, `department`, `level`, `hall`, `room`, `reg_number`, `matric`, `email`, `phone`, `active`, `created_by`, `ip_address`, `date_created`, `date_modified`) VALUES
(1, 'emmanuel', 'adeojo', 'emmanuel.adeojo', 'ibukunoluwa', 'adeojo ibukunoluwa emmanuel', 'cse', 'computer science', 300, 'daniel hall', 'g207', 1300890, '13bd002644', 'adeojo.emmanuel@lmu.edu.ng', '08125442337', 1, 'admin', '192.168.7.1', '2018-05-25 07:38:02', '2018-05-25 07:38:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outcomes`
--
ALTER TABLE `outcomes`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `outcomes`
--
ALTER TABLE `outcomes`
  MODIFY `_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
