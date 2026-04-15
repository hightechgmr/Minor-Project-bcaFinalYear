-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 09:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tictactoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_status`
--

CREATE TABLE `login_status` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_status`
--

INSERT INTO `login_status` (`ID`, `username`, `password`) VALUES
(1, 'Admin', 'admin'),
(2, 'Admin', 'admin'),
(3, 'Admin', 'admin'),
(4, 'Admin', 'admin'),
(5, 'JatinPant', 'Jatin'),
(6, 'JatinPant', 'Jatin'),
(7, 'JatinPant', 'Jatin'),
(8, 'JatinPant', 'Jatin'),
(9, 'JatinPant', 'Jatin'),
(10, 'Admin', 'admin'),
(11, 'Admin', 'admin'),
(12, 'Admin', 'admin'),
(13, 'Admin', 'admin'),
(14, 'Admin', 'admin'),
(15, 'Admin', 'admin'),
(16, 'Admin', 'admin'),
(17, 'JatinPant', 'Jatin'),
(18, 'JatinPant', 'Jatin'),
(19, 'JatinPant', 'Jatin'),
(20, 'JatinPant', 'Jatin'),
(21, 'JatinPant', 'Jatin'),
(22, 'JatinPant', 'Jatin'),
(23, 'Admin', 'admin'),
(24, 'JatinPant', 'Jatin'),
(25, 'JatinPant', 'Jatin'),
(26, 'JatinPant', 'Jatin'),
(27, 'JatinPant', 'Jatin'),
(28, 'JatinPant', 'Jatin'),
(29, 'Admin', 'admin'),
(30, 'Admin', 'admin'),
(31, 'Admin', 'admin'),
(32, 'Admin', 'admin'),
(33, 'Admin', 'admin'),
(34, 'JatinPant', 'Jatin');

-- --------------------------------------------------------

--
-- Table structure for table `scorecard`
--

CREATE TABLE `scorecard` (
  `s.no` int(11) NOT NULL,
  `game_name` varchar(50) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `total_matches` int(11) DEFAULT 0,
  `won` int(11) NOT NULL DEFAULT 0,
  `lost` int(11) NOT NULL DEFAULT 0,
  `against` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scorecard`
--

INSERT INTO `scorecard` (`s.no`, `game_name`, `user_name`, `total_matches`, `won`, `lost`, `against`) VALUES
(1, 'tictactoe', 'JatinPant', 1, 1, 0, 'HP'),
(2, 'tictactoe', 'Admin', 8, 5, 2, 'VV'),
(4, 'tictactoe', 'JatinPant', 3, 2, 1, 'F1'),
(5, 'tictactoe', 'Admin', 4, 2, 1, 'HP'),
(6, 'tictactoe', 'Admin', 2, 1, 1, 'JatinPant');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `gender`) VALUES
(1, 'Admin', 'admin', 'M'),
(2, 'JatinPant', 'Jatin', 'M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_status`
--
ALTER TABLE `login_status`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `scorecard`
--
ALTER TABLE `scorecard`
  ADD PRIMARY KEY (`s.no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_status`
--
ALTER TABLE `login_status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `scorecard`
--
ALTER TABLE `scorecard`
  MODIFY `s.no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
