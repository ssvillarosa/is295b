-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2021 at 12:00 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is295b`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `failed_login` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `status`, `failed_login`, `email`, `contact_number`, `name`, `address`, `birthday`) VALUES
(1, 'admin', '$2y$10$VewyuVO32pKqc7NHAAvJNO1uvI8p4vv6ckcl/P0EqEAMX66EeolkW', 1, 1, 0, 'admin@test.com', '999999', 'Super Admin', 'CPU', '1990-01-01');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_search_table`
-- (See below for the actual view)
--
CREATE TABLE `user_search_table` (
`id` int(11)
,`username` varchar(255)
,`password` varchar(255)
,`role` varchar(9)
,`status` varchar(7)
,`email` varchar(255)
,`contact_number` varchar(255)
,`name` varchar(255)
,`address` varchar(255)
,`birthday` date
);

-- --------------------------------------------------------

--
-- Structure for view `user_search_table`
--
DROP TABLE IF EXISTS `user_search_table`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_search_table`  AS  select `user`.`id` AS `id`,`user`.`username` AS `username`,`user`.`password` AS `password`,(case when (`user`.`role` = 1) then 'Admin' when (`user`.`role` = 2) then 'Recruiter' else 'Unknown' end) AS `role`,(case when (`user`.`status` = 1) then 'Active' when (`user`.`status` = 2) then 'Blocked' else 'Unknown' end) AS `status`,`user`.`email` AS `email`,`user`.`contact_number` AS `contact_number`,`user`.`name` AS `name`,`user`.`address` AS `address`,`user`.`birthday` AS `birthday` from `user` where (`user`.`status` <> 3) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
