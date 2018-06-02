-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2018 at 11:33 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

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
(1, 'admin', 'monestara', 'admin@stan.com', 'null', 'administrative', 'engineering', 1, 'admin', '2018-05-28 16:09:13', '2018-06-01 19:22:22', 'adeojo emmanuel', 'adeojo emmanuel', 'emmanuel.adeojo', '$2a$10$a5b3482b6dac8f83a7569uhi4/9m5S9PwS/Xwlwep5IG/OjPBlWTe', 1, 1, 'mat222');

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
  `course_id` int(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` varchar(255) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `course_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `date_modified`, `date_added`) VALUES
(1, 2, 'what is 2+2 ?', '4', '3', '2', '1', '4', '0000-00-00 00:00:00', '2018-05-31 19:35:40'),
(2, 2, 'what  is 3-2 ?', '1', '3', '4', '2', '1', '0000-00-00 00:00:00', '2018-05-31 19:35:40'),
(3, 2, 'who is the best footballer', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '0000-00-00 00:00:00', '2018-05-31 19:35:40'),
(4, 2, 'who is the governor of kwara', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '0000-00-00 00:00:00', '2018-05-31 19:35:40'),
(5, 2, 'what is 2+2 ?', '4', '3', '2', '1', '4', '0000-00-00 00:00:00', '2018-05-31 19:41:09'),
(6, 2, 'what  is 3-2 ?', '1', '3', '4', '2', '1', '0000-00-00 00:00:00', '2018-05-31 19:41:09'),
(7, 2, 'who is the best footballer', 'papa', 'jay jay', 'junior', 'ronaldo', 'ronaldo', '0000-00-00 00:00:00', '2018-05-31 19:41:09'),
(8, 2, 'who is the governor of kwara', 'jay jay', 'bobby', 'papa', 'fatai', 'fatai', '0000-00-00 00:00:00', '2018-05-31 19:41:09');

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
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
