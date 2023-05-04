-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2021 at 03:06 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rhdmzyzf`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phoneNum` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `adharNumber` varchar(50) DEFAULT NULL,
  `annualIncome` varchar(50) DEFAULT NULL,
  `agent` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''No'', ''1''=>''Yes''',
  `dob` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'', ''1''=>''Active''',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '	''0'' => ''Not Deleted'', ''1'' => ''Deleted''',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `name`, `email`, `phoneNum`, `password`, `occupation`, `adharNumber`, `annualIncome`, `agent`, `dob`, `address`, `status`, `is_deleted`, `createdAt`, `updateAt`) VALUES
(1, 'Arghya ', 'arghya@gmail.com ', '1234562341', '25d55ad283aa400af464c76d713c07ad', 'Worker ', '123456 ', '1000 ', '1', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-21 16:04:08', '2021-12-23 11:18:38'),
(2, 'Arghya ', 'arghya1@gmail.com ', '1234562322', '7e8feb2276322ecddd4423b649dfd4d9', 'Worker ', '123456 ', '1000 ', '1', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-21 16:04:36', '2021-12-23 11:18:43'),
(3, 'Arghya ', 'arghya@gmail.com ', '1232756234', '7e8feb2276322ecddd4423b649dfd4d9', 'Worker ', '123456 ', '1000 ', '0', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-21 16:38:42', '2021-12-23 11:18:52'),
(4, 'Arghya ', 'arghya121@gmail.com ', '1234056232', '7e8feb2276322ecddd4423b649dfd4d9', 'Worker ', '123456 ', '1000 ', '0', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-23 11:13:20', '2021-12-23 11:18:58'),
(5, 'Arghya ', 'arghya11@gmail.com ', '1234569234', '123456 ', 'Worker ', '123456 ', '1000 ', '1', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-23 11:20:03', '2021-12-23 11:20:03'),
(7, 'Arghya2', 'arghya12@gmail.com ', '1234569235', 'b843ba8185b6d9df212ccc518f37e8e4', 'Worker ', '123456 ', '1000 ', '1', '13-10-1992 ', 'kolkata', '1', '0', '2021-12-23 12:54:01', '2021-12-23 12:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

CREATE TABLE `insurance` (
  `id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `insuranceType` varchar(100) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `duration` varchar(150) DEFAULT NULL COMMENT 'Months',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'', ''1''=>''Active''',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0'' => ''Not Deleted'', ''1'' => ''Deleted''',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`id`, `amount`, `insuranceType`, `agent_id`, `duration`, `status`, `is_deleted`, `createdAt`, `updateAt`) VALUES
(1, 400, 'ABC', 2, '24', '1', '0', '2021-12-23 10:42:57', '2021-12-23 11:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `loanType` varchar(100) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `rateInterest` float DEFAULT NULL,
  `duration` varchar(150) DEFAULT NULL COMMENT 'Months',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'', ''1''=>''Active''',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0'' => ''Not Deleted'', ''1'' => ''Deleted''',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `amount`, `loanType`, `agent_id`, `rateInterest`, `duration`, `status`, `is_deleted`, `createdAt`, `updateAt`) VALUES
(1, 300, 'Personal', 1, 10, '12', '1', '0', '2021-12-23 05:25:44', '2021-12-23 11:08:25'),
(2, 200, 'Personal', 1, 10, '12', '1', '0', '2021-12-23 05:44:48', '2021-12-23 05:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `fromAccount` varchar(200) DEFAULT NULL,
  `toAccount` varchar(200) DEFAULT NULL,
  `status` enum('1','2') NOT NULL COMMENT '''1''=>''Send'', ''2''=>''Received''',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0'' => ''Not Deleted'', ''1'' => ''Deleted''',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `loan_id`, `insurance_id`, `amount`, `fromAccount`, `toAccount`, `status`, `is_deleted`, `createdAt`, `updateAt`) VALUES
(1, 2, NULL, 300, '99999', '12345', '1', '0', '2021-12-23 05:46:13', '2021-12-23 13:13:44'),
(2, 2, NULL, 20, '12345', '99999', '2', '1', '2021-12-23 05:51:22', '2021-12-23 13:13:17'),
(3, 2, NULL, 20, '12345', '99999', '2', '0', '2021-12-23 05:52:22', '2021-12-23 13:13:10'),
(4, NULL, 1, 20, '23123', '99999', '2', '0', '2021-12-23 10:45:05', '2021-12-23 10:45:05'),
(5, NULL, 1, 20, '23123', '99999', '2', '0', '2021-12-23 10:55:46', '2021-12-23 10:55:46'),
(6, NULL, 1, 20, '23123', '99999', '2', '0', '2021-12-23 10:55:56', '2021-12-23 10:55:56'),
(7, NULL, 1, 20, '23123', '99999', '2', '0', '2021-12-23 13:13:49', '2021-12-23 13:13:49'),
(8, 2, NULL, 20, '12345', '99999', '2', '0', '2021-12-23 13:14:04', '2021-12-23 13:14:28'),
(9, 2, NULL, 20, '99999', '12345', '2', '0', '2021-12-23 13:23:41', '2021-12-23 13:23:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance`
--
ALTER TABLE `insurance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `insurance`
--
ALTER TABLE `insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
