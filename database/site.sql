-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2021 at 07:41 AM
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
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `primary_phone` varchar(255) DEFAULT NULL,
  `secondary_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_time` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `contact_person`, `primary_phone`, `secondary_phone`, `address`, `website`, `industry`, `created_time`, `created_by`, `is_deleted`, `deleted_time`, `deleted_by`) VALUES
(1, 'BBS', 'Steven Suanuqe', '9928283', '', 'Alabang Muntinlupa', 'www.bbs.com', 'Hospitality', '2021-02-19 06:40:37', 1, 0, NULL, NULL),
(2, 'ADB Inc.', 'Billy Joe', '464584', '', 'Makati', 'www.adb.com', 'IT', '2021-02-05 08:22:00', 1, 0, NULL, NULL),
(3, 'New Era Comp', 'Newton', '90384', '', 'New York', 'www.neweracomp.com', 'Recruitment', '2021-02-05 08:23:00', 1, 0, NULL, NULL),
(4, 'Del Me', 'None', '', '', 'Not existing', 'www.missing.com', 'Nowhere', '2021-02-05 08:24:00', 1, 1, '2021-02-05 16:25:00', 1),
(5, 'New Company', 'Contact', '34234', '34003', 'BGC', 'www.new-company.com', 'Recruitment', '2021-02-19 06:40:37', 1, 1, '2021-02-19 14:40:37', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `company_list`
-- (See below for the actual view)
--
CREATE TABLE `company_list` (
`id` int(11)
,`name` varchar(255)
,`contact_person` varchar(255)
,`primary_phone` varchar(255)
,`secondary_phone` varchar(255)
,`address` varchar(255)
,`website` varchar(500)
,`industry` varchar(255)
,`active` bigint(21)
,`on_hold` bigint(21)
,`closed` bigint(21)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `job_order`
--

CREATE TABLE `job_order` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_function` text,
  `requirement` text,
  `min_salary` float DEFAULT NULL,
  `max_salary` float DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `employment_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_time` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `slots_available` int(11) DEFAULT NULL,
  `priority_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_order`
--

INSERT INTO `job_order` (`id`, `title`, `company_id`, `job_function`, `requirement`, `min_salary`, `max_salary`, `location`, `employment_type`, `status`, `created_time`, `created_by`, `is_deleted`, `deleted_time`, `deleted_by`, `slots_available`, `priority_level`) VALUES
(1, 'Software Developer', 1, 'Lorem Ipsum', 'Lorem Ipsum', 90000, 150000, 'BGC', 1, 1, '2021-02-05 16:21:00', 1, 0, '0000-00-00 00:00:00', 0, 5, 1),
(2, 'Business Analyst', 2, 'Lorem Ipsum', 'Lorem Ipsum', 50000, 90000, NULL, 1, 1, '2021-02-05 16:22:00', 1, 0, '0000-00-00 00:00:00', 0, 2, 2),
(3, 'Quality Assurance', 1, 'Lorem Ipsum', 'Lorem Ipsum', 30000, 70000, NULL, 1, 1, '2021-02-05 16:24:00', 1, 0, '0000-00-00 00:00:00', 0, 1, 3),
(4, 'Compliance Officer', 2, 'Lorem Ipsum', 'Lorem Ipsum', 50000, 90000, NULL, 2, 1, '2021-02-05 16:25:00', 1, 1, '2021-02-05 17:25:00', 0, 1, 4),
(5, 'Compliance Officer III', 2, 'Lorem Ipsum', 'Lorem Ipsum', 50000, 90000, NULL, 2, 1, '2021-02-19 14:40:37', 1, 1, '2021-02-19 14:40:38', 1, 2, 4);

-- --------------------------------------------------------

--
-- Stand-in structure for view `job_order_list`
-- (See below for the actual view)
--
CREATE TABLE `job_order_list` (
`id` int(11)
,`title` varchar(255)
,`company` varchar(255)
,`status` varchar(7)
,`employment_type` varchar(11)
,`job_function` text
,`requirement` text
,`min_salary` float
,`max_salary` float
,`location` varchar(255)
,`slots_available` int(11)
,`priority_level` int(11)
,`is_deleted` tinyint(1)
,`skills` text
,`recruiters` text
,`users` text
);

-- --------------------------------------------------------

--
-- Table structure for table `job_order_skill`
--

CREATE TABLE `job_order_skill` (
  `job_order_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_order_skill`
--

INSERT INTO `job_order_skill` (`job_order_id`, `skill_id`, `years_of_experience`) VALUES
(1, 1, 8),
(1, 2, 7),
(1, 3, 6),
(1, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `job_order_user`
--

CREATE TABLE `job_order_user` (
  `job_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_order_user`
--

INSERT INTO `job_order_user` (`job_order_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_time` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `name`, `category_id`, `is_deleted`, `deleted_time`, `deleted_by`, `created_by`, `created_time`) VALUES
(1, 'Javascript', 1, 0, NULL, NULL, 1, '2021-02-05 08:20:00'),
(2, 'Scrum', 1, 1, '2021-02-05 10:21:00', 1, 1, '2021-02-05 08:21:00'),
(3, 'Go', 1, 0, NULL, NULL, NULL, '2021-02-05 08:20:00'),
(4, 'Indexing', 2, 0, NULL, NULL, NULL, '2021-02-05 08:20:00'),
(5, 'HTML', 1, 1, '2021-02-19 06:40:38', 1, NULL, '2021-02-19 06:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `skill_category`
--

CREATE TABLE `skill_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `skill_category`
--

INSERT INTO `skill_category` (`id`, `name`, `is_deleted`) VALUES
(1, 'Uncategorized', 0),
(2, 'Accounting', 0),
(3, 'Finance', 0),
(4, 'Others', 0);

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
(1, 'admin', '$2y$10$1VVQ4bCXDCVTb.GyUAAXOeYhvK3nNoxQf4yNvgRUUiPtoX.bnUD0q', 1, 1, 0, 'admin@test.com', '999999', 'Super Admin', 'CPU', '1990-01-01'),
(2, 'steven', '$2y$10$Dz9s4seakAWPD6htZqEBl.4m41GHTAkUHM1jZGHRCTsqRptopf4Gu', 2, 1, 0, 'steven@test.com', '0977', 'Steven Villarosa', 'Muntinlupa', '1991-05-18'),
(3, 'guest', '$2y$10$QYPXXTrS2vnD9X1wDXOMRekJHE3uYeGjW1F7xkDHWCIupwhY698Yy', 2, 1, 0, 'guest@test.com', '1234', 'Your guest', 'NCR', '1992-10-03'),
(4, 'dummy', '$2y$10$fROE1G61WQkjkcfKgwKCkOU2ER/J9GX84yzmtqcOtA4aO4aIQ94BK', 2, 3, 0, 'dummy@test.com', '321', 'Dummy user', 'Nowhere', '1993-07-08'),
(5, 'user4', '$2y$10$ebPBUGWqei7y/fXL7hhRvuqi1eBVtufUR619tNuV7NqbF7cDZoMOu', 1, 1, 0, 'user4@test.com', '999999', 'User 4', 'Here', '1999-03-05'),
(6, 'ashketchup', '$2y$10$fBl5Gdk95HiDmeSz0Exr0uem1N4rlHqR5ldxw0SD896nntgte4JlG', 2, 2, 0, 'updated@test.com', '000', 'Updated User', 'I am a new creation', '2000-01-01'),
(7, 'updateProfTest', '$2y$10$UoOkybkrbxpYiJ5MqWRn3uu1gdB1rl0fnjQRv4uYi9GWyKvHAfuMS', 2, 1, 0, 'updatedtest@test.com', '55555', 'Profile Updated', 'I am nowwhere', '2002-02-02'),
(8, 'test_getUCount', '$2y$10$M5Kl9q77nqtvtkVVlTsLtO2DfXHJFhllieTT9sfX3ZasRXIcFNQoq', 1, 1, 0, 'getUserCount@test.com', '002943', 'Test GetUserCount', 'Test Address', '1989-03-02'),
(9, 'deletedUsr', '$2y$10$fUXFI.JaqUm5sNz2gfNeyOS03yluF.qEGnxu7kOx6ND.Yq2vZ4TzC', 2, 3, 0, 'user4@test.com', '999999', 'User 4', 'Here', '1999-03-05');

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
-- Structure for view `company_list`
--
DROP TABLE IF EXISTS `company_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_list`  AS  select `c`.`id` AS `id`,`c`.`name` AS `name`,`c`.`contact_person` AS `contact_person`,`c`.`primary_phone` AS `primary_phone`,`c`.`secondary_phone` AS `secondary_phone`,`c`.`address` AS `address`,`c`.`website` AS `website`,`c`.`industry` AS `industry`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 1) and (`jo`.`is_deleted` <> 1))) AS `active`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 2) and (`jo`.`is_deleted` <> 1))) AS `on_hold`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 3) and (`jo`.`is_deleted` <> 1))) AS `closed`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`is_deleted` <> 1))) AS `total` from `company` `c` where (`c`.`is_deleted` <> 1) ;

-- --------------------------------------------------------

--
-- Structure for view `job_order_list`
--
DROP TABLE IF EXISTS `job_order_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `job_order_list`  AS  select `jo`.`id` AS `id`,`jo`.`title` AS `title`,`c`.`name` AS `company`,(case when (`jo`.`status` = 1) then 'Open' when (`jo`.`status` = 2) then 'On-hold' when (`jo`.`status` = 3) then 'Closed' else 'Unknown' end) AS `status`,(case when (`jo`.`employment_type` = 1) then 'Regular' when (`jo`.`employment_type` = 2) then 'Contractual' else 'Unknown' end) AS `employment_type`,`jo`.`job_function` AS `job_function`,`jo`.`requirement` AS `requirement`,`jo`.`min_salary` AS `min_salary`,`jo`.`max_salary` AS `max_salary`,`jo`.`location` AS `location`,`jo`.`slots_available` AS `slots_available`,`jo`.`priority_level` AS `priority_level`,`jo`.`is_deleted` AS `is_deleted`,(select group_concat(concat(`s`.`name`,'(',`jos`.`years_of_experience`,'y)') separator ', ') from (`job_order_skill` `jos` join `skill` `s` on((`jos`.`skill_id` = `s`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `skills`,(select group_concat(`u`.`name` separator ', ') from (`job_order_user` `jos` join `user` `u` on((`jos`.`user_id` = `u`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `recruiters`,(select group_concat(concat('(',`u`.`id`,')') separator ', ') from (`job_order_user` `jos` join `user` `u` on((`jos`.`user_id` = `u`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `users` from (`job_order` `jo` join `company` `c` on((`jo`.`company_id` = `c`.`id`))) ;

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
  ADD KEY `fk_activity_user` (`user_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_company_created_by_user` (`created_by`),
  ADD KEY `fk_company_deleted_by_user` (`deleted_by`);

--
-- Indexes for table `job_order`
--
ALTER TABLE `job_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_order_skill`
--
ALTER TABLE `job_order_skill`
  ADD PRIMARY KEY (`job_order_id`,`skill_id`),
  ADD KEY `job_order_id` (`job_order_id`),
  ADD KEY `fk_skill_job_order` (`skill_id`);

--
-- Indexes for table `job_order_user`
--
ALTER TABLE `job_order_user`
  ADD PRIMARY KEY (`job_order_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_skill_created_by_user` (`created_by`),
  ADD KEY `fk_skill_deleted_by_user` (`deleted_by`),
  ADD KEY `fk_skill_category` (`category_id`);

--
-- Indexes for table `skill_category`
--
ALTER TABLE `skill_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `skill_category`
--
ALTER TABLE `skill_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_created_by_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_company_deleted_by_user` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `job_order_skill`
--
ALTER TABLE `job_order_skill`
  ADD CONSTRAINT `fk_job_order_skill` FOREIGN KEY (`job_order_id`) REFERENCES `job_order` (`id`),
  ADD CONSTRAINT `fk_skill_job_order` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`);

--
-- Constraints for table `job_order_user`
--
ALTER TABLE `job_order_user`
  ADD CONSTRAINT `job_order_user_ibfk_1` FOREIGN KEY (`job_order_id`) REFERENCES `job_order` (`id`),
  ADD CONSTRAINT `job_order_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `skill`
--
ALTER TABLE `skill`
  ADD CONSTRAINT `fk_skill_category` FOREIGN KEY (`category_id`) REFERENCES `skill_category` (`id`),
  ADD CONSTRAINT `fk_skill_created_by_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_skill_deleted_by_user` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
