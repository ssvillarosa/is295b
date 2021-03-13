-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2021 at 02:49 PM
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
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `civil_status` tinyint(4) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `failed_login` tinyint(4) NOT NULL DEFAULT '0',
  `primary_phone` varchar(255) NOT NULL,
  `secondary_phone` varchar(255) DEFAULT NULL,
  `work_phone` varchar(255) DEFAULT NULL,
  `best_time_to_call` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `can_relocate` tinyint(4) NOT NULL,
  `current_employer` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `current_pay` float NOT NULL,
  `desired_pay` float NOT NULL,
  `objectives` text,
  `educational_background` text,
  `professional_experience` text,
  `seminars_and_trainings` text,
  `is_deleted` tinyint(4) NOT NULL,
  `deleted_time` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`id`, `last_name`, `first_name`, `birthday`, `civil_status`, `email`, `password`, `status`, `failed_login`, `primary_phone`, `secondary_phone`, `work_phone`, `best_time_to_call`, `address`, `can_relocate`, `current_employer`, `source`, `current_pay`, `desired_pay`, `objectives`, `educational_background`, `professional_experience`, `seminars_and_trainings`, `is_deleted`, `deleted_time`, `deleted_by`, `created_by`, `created_time`) VALUES
(1, 'Villarosa', 'Steven', '1991-05-18', 1, 'steven@test.com', NULL, 1, 0, '1111', '2222', '3333', '2PM', 'Cavite', 1, 'Cnx', 'LinkedIn', 10000, 15000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-02-05 08:22:00'),
(2, 'Updated', 'Candidate', '1992-05-18', 2, 'updated_applicant@test.com', NULL, 1, 0, '000', '00', '000', '6AM', 'Here', 0, 'Company 1', 'Jobstreet', 15000, 20000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-02-05 08:22:00'),
(3, 'San Jose', 'Theresa', '1993-05-18', 3, 'tes_sanjose@test.com', NULL, 1, 0, '0000', '0000', '0000', '12PM', 'Laguna', 1, 'Amdocs', 'Job Fair', 25000, 30000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-02-05 08:22:00'),
(4, 'Deleted', 'Applicant', NULL, NULL, 'deleted_applicant@test.com', NULL, 1, 0, '1111', '2222', '3333', '2PM', 'Goner', 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2021-02-05 08:22:00'),
(5, 'New', 'Applicant', NULL, NULL, 'new_applicant@test.com', NULL, 1, 0, '1111', '2222', '3333', '2PM', 'Goner', 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, '2021-03-10 13:48:42', 1, 1, '2021-03-10 13:48:42');

-- --------------------------------------------------------

--
-- Stand-in structure for view `applicant_list`
-- (See below for the actual view)
--
CREATE TABLE `applicant_list` (
`id` int(11)
,`last_name` varchar(255)
,`first_name` varchar(255)
,`birthday` date
,`civil_status` varchar(7)
,`active_application` int(1)
,`email` varchar(255)
,`primary_phone` varchar(255)
,`secondary_phone` varchar(255)
,`work_phone` varchar(255)
,`best_time_to_call` varchar(255)
,`address` varchar(255)
,`can_relocate` varchar(7)
,`current_employer` varchar(255)
,`source` varchar(255)
,`current_pay` float
,`desired_pay` float
,`skills` text
,`objectives` text
,`educational_background` text
,`professional_experience` text
,`seminars_and_trainings` text
);

-- --------------------------------------------------------

--
-- Table structure for table `applicant_skill`
--

CREATE TABLE `applicant_skill` (
  `applicant_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_skill`
--

INSERT INTO `applicant_skill` (`applicant_id`, `skill_id`, `years_of_experience`) VALUES
(1, 1, 8),
(1, 2, 7),
(1, 3, 6),
(1, 4, 5);

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
(1, 'BBS', 'Steven Suanuqe', '9928283', '', 'Alabang Muntinlupa', 'www.bbs.com', 'Hospitality', '2021-03-10 13:48:43', 1, 0, NULL, NULL),
(2, 'ADB Inc.', 'Billy Joe', '464584', '', 'Makati', 'www.adb.com', 'IT', '2021-02-05 08:22:00', 1, 0, NULL, NULL),
(3, 'New Era Comp', 'Newton', '90384', '', 'New York', 'www.neweracomp.com', 'Recruitment', '2021-02-05 08:23:00', 1, 0, NULL, NULL),
(4, 'Del Me', 'None', '', '', 'Not existing', 'www.missing.com', 'Nowhere', '2021-02-05 08:24:00', 1, 1, '2021-02-05 16:25:00', 1),
(5, 'New Company', 'Contact', '34234', '34003', 'BGC', 'www.new-company.com', 'Recruitment', '2021-03-10 13:48:43', 1, 1, '2021-03-10 21:48:43', 1);

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
,`open` bigint(21)
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
(5, 'Compliance Officer III', 2, 'Lorem Ipsum', 'Lorem Ipsum', 50000, 90000, NULL, 2, 1, '2021-03-10 21:48:43', 1, 1, '2021-03-10 21:48:43', 1, 2, 4);

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
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `civil_status` tinyint(4) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `primary_phone` varchar(255) NOT NULL,
  `secondary_phone` varchar(255) DEFAULT NULL,
  `work_phone` varchar(255) DEFAULT NULL,
  `best_time_to_call` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `can_relocate` tinyint(4) NOT NULL,
  `current_employer` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `current_pay` float NOT NULL,
  `desired_pay` float NOT NULL,
  `objectives` text,
  `educational_background` text,
  `professional_experience` text,
  `seminars_and_trainings` text,
  `is_deleted` tinyint(4) NOT NULL,
  `deleted_time` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `approved_by` int(11) NOT NULL,
  `approved_time` timestamp NULL DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `status`, `last_name`, `first_name`, `birthday`, `civil_status`, `email`, `password`, `primary_phone`, `secondary_phone`, `work_phone`, `best_time_to_call`, `address`, `can_relocate`, `current_employer`, `source`, `current_pay`, `desired_pay`, `objectives`, `educational_background`, `professional_experience`, `seminars_and_trainings`, `is_deleted`, `deleted_time`, `deleted_by`, `approved_by`, `approved_time`, `created_time`) VALUES
(1, 1, 'RegistrationVillarosa', 'Steven', '1991-05-18', 1, 'steven.registration@test.com', NULL, '1111', '2222', '3333', '2PM', 'Cavite', 1, 'Cnx', 'LinkedIn', 10000, 15000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, '2021-02-05 08:22:00'),
(2, 1, 'Updated', 'Candidate', '1992-05-18', 2, 'updated_registration@test.com', 'hello', '000', '00', '000', '6AM', 'Here', 0, 'Company 1', 'Jobstreet', 15000, 20000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, '2021-02-05 08:22:00'),
(3, 1, 'Registration', 'Theresa', '1993-05-18', 3, 'tes_sanjose.registration@test.com', NULL, '0000', '0000', '0000', '12PM', 'Laguna', 1, 'Amdocs', 'Job Fair', 25000, 30000, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, '2021-02-05 08:22:00'),
(4, 1, 'Deleted', 'Registration', NULL, NULL, 'deleted_registration@test.com', NULL, '1111', '2222', '3333', '2PM', 'Goner', 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, '2021-02-05 08:22:00'),
(5, 1, 'New', 'Registration', NULL, NULL, 'new_registration@test.com', '$2y$10$jWnK3A00pYhp3u2QL3pENO0Er8V0d8VTlefSQkZVfCDrbNYCnrD2W', '1111', '2222', '3333', '2PM', 'Goner', 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, '2021-03-10 13:48:43', 1, 0, NULL, '2021-03-10 13:48:43');

-- --------------------------------------------------------

--
-- Stand-in structure for view `registration_list`
-- (See below for the actual view)
--
CREATE TABLE `registration_list` (
`id` int(11)
,`status` varchar(8)
,`last_name` varchar(255)
,`first_name` varchar(255)
,`birthday` date
,`civil_status` varchar(7)
,`active_application` int(1)
,`email` varchar(255)
,`primary_phone` varchar(255)
,`secondary_phone` varchar(255)
,`work_phone` varchar(255)
,`best_time_to_call` varchar(255)
,`address` varchar(255)
,`can_relocate` varchar(7)
,`current_employer` varchar(255)
,`source` varchar(255)
,`current_pay` float
,`desired_pay` float
,`skills` text
,`objectives` text
,`educational_background` text
,`professional_experience` text
,`seminars_and_trainings` text
);

-- --------------------------------------------------------

--
-- Table structure for table `registration_skill`
--

CREATE TABLE `registration_skill` (
  `registration_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration_skill`
--

INSERT INTO `registration_skill` (`registration_id`, `skill_id`, `years_of_experience`) VALUES
(1, 1, 8),
(1, 2, 7),
(1, 3, 6),
(1, 4, 5);

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
(5, 'HTML', 1, 1, '2021-03-10 13:48:44', 1, NULL, '2021-03-10 13:48:44');

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
(1, 'admin', '$2y$10$pJH5v0Edu10RvbD5YfjFs.rpmFr/4ujI6msTWHGtxPwKkE4f/ZZou', 1, 1, 0, 'admin@test.com', '999999', 'Super Admin', 'CPU', '1990-01-01'),
(2, 'steven', '$2y$10$ddIwXOPi142YlQyOYEPbpuj4RlThJK2OSrURSs2.t9c3skZFBXgiW', 2, 1, 0, 'steven@test.com', '0977', 'Steven Villarosa', 'Muntinlupa', '1991-05-18'),
(3, 'guest', '$2y$10$qgEq5A0FbNe9lCYD9DKwrugePK0Lhslx3HprEnO02IQp27pbSfxFy', 2, 1, 0, 'guest@test.com', '1234', 'Your guest', 'NCR', '1992-10-03'),
(4, 'dummy', '$2y$10$Xn6abdqAM2.6L3l5Yl6QMORfdk3riFAT.fK1aw/FX4Y.qgyahZSUS', 2, 3, 0, 'dummy@test.com', '321', 'Dummy user', 'Nowhere', '1993-07-08'),
(5, 'user4', '$2y$10$VYzMbiEX5MtofVn9qUpoEOIbA3S9YNLVHHruc.BiXNt2hkADRy0u.', 1, 1, 0, 'user4@test.com', '999999', 'User 4', 'Here', '1999-03-05'),
(6, 'ashketchup', '$2y$10$I2BaDFQLXbrSSrr.keBgbuVUN4NmdZXAqJBIbukRCQB3J.QAGuKlK', 2, 2, 0, 'updated@test.com', '000', 'Updated User', 'I am a new creation', '2000-01-01'),
(7, 'updateProfTest', '$2y$10$4n1exQ6Qgr/bRJjNJQmwhOdMUPcmMiNcQ80cR2TtxhDmnVewpyuRW', 2, 1, 0, 'updatedtest@test.com', '55555', 'Profile Updated', 'I am nowwhere', '2002-02-02'),
(8, 'test_getUCount', '$2y$10$n0ZL6VqgGFc3WJZcwoK1X.nVSHDxZ6dENDMKtQOS5581EQh/JLjsq', 1, 1, 0, 'getUserCount@test.com', '002943', 'Test GetUserCount', 'Test Address', '1989-03-02'),
(9, 'deletedUsr', '$2y$10$dc2vLv7V5iCqJi1Z1qObe.lLxKhMS5qNubmxUn6Avl5mk9.ofQmcW', 2, 3, 0, 'user4@test.com', '999999', 'User 4', 'Here', '1999-03-05');

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
-- Structure for view `applicant_list`
--
DROP TABLE IF EXISTS `applicant_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `applicant_list`  AS  select `a`.`id` AS `id`,`a`.`last_name` AS `last_name`,`a`.`first_name` AS `first_name`,`a`.`birthday` AS `birthday`,(case when (`a`.`civil_status` = 1) then 'Single' when (`a`.`civil_status` = 2) then 'Married' when (`a`.`civil_status` = 3) then 'Widowed' else 'Unknown' end) AS `civil_status`,0 AS `active_application`,`a`.`email` AS `email`,`a`.`primary_phone` AS `primary_phone`,`a`.`secondary_phone` AS `secondary_phone`,`a`.`work_phone` AS `work_phone`,`a`.`best_time_to_call` AS `best_time_to_call`,`a`.`address` AS `address`,(case when (`a`.`can_relocate` = 1) then 'Yes' when (`a`.`can_relocate` = 0) then 'No' else 'Unknown' end) AS `can_relocate`,`a`.`current_employer` AS `current_employer`,`a`.`source` AS `source`,`a`.`current_pay` AS `current_pay`,`a`.`desired_pay` AS `desired_pay`,(select group_concat(concat(`s`.`name`,'(',`ask`.`years_of_experience`,'y)') separator ', ') from (`applicant_skill` `ask` join `skill` `s` on((`ask`.`skill_id` = `s`.`id`))) where (`ask`.`applicant_id` = `a`.`id`)) AS `skills`,`a`.`objectives` AS `objectives`,`a`.`educational_background` AS `educational_background`,`a`.`professional_experience` AS `professional_experience`,`a`.`seminars_and_trainings` AS `seminars_and_trainings` from `applicant` `a` where (`a`.`is_deleted` <> 1) ;

-- --------------------------------------------------------

--
-- Structure for view `company_list`
--
DROP TABLE IF EXISTS `company_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_list`  AS  select `c`.`id` AS `id`,`c`.`name` AS `name`,`c`.`contact_person` AS `contact_person`,`c`.`primary_phone` AS `primary_phone`,`c`.`secondary_phone` AS `secondary_phone`,`c`.`address` AS `address`,`c`.`website` AS `website`,`c`.`industry` AS `industry`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 1) and (`jo`.`is_deleted` <> 1))) AS `open`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 2) and (`jo`.`is_deleted` <> 1))) AS `on_hold`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`status` = 3) and (`jo`.`is_deleted` <> 1))) AS `closed`,(select count(0) from `job_order` `jo` where ((`jo`.`company_id` = `c`.`id`) and (`jo`.`is_deleted` <> 1))) AS `total` from `company` `c` where (`c`.`is_deleted` <> 1) ;

-- --------------------------------------------------------

--
-- Structure for view `job_order_list`
--
DROP TABLE IF EXISTS `job_order_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `job_order_list`  AS  select `jo`.`id` AS `id`,`jo`.`title` AS `title`,`c`.`name` AS `company`,(case when (`jo`.`status` = 1) then 'Open' when (`jo`.`status` = 2) then 'On-hold' when (`jo`.`status` = 3) then 'Closed' else 'Unknown' end) AS `status`,(case when (`jo`.`employment_type` = 1) then 'Regular' when (`jo`.`employment_type` = 2) then 'Contractual' else 'Unknown' end) AS `employment_type`,`jo`.`job_function` AS `job_function`,`jo`.`requirement` AS `requirement`,`jo`.`min_salary` AS `min_salary`,`jo`.`max_salary` AS `max_salary`,`jo`.`location` AS `location`,`jo`.`slots_available` AS `slots_available`,`jo`.`priority_level` AS `priority_level`,`jo`.`is_deleted` AS `is_deleted`,(select group_concat(concat(`s`.`name`,'(',`jos`.`years_of_experience`,'y)') separator ', ') from (`job_order_skill` `jos` join `skill` `s` on((`jos`.`skill_id` = `s`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `skills`,(select group_concat(`u`.`name` separator ', ') from (`job_order_user` `jos` join `user` `u` on((`jos`.`user_id` = `u`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `recruiters`,(select group_concat(concat('(',`u`.`id`,')') separator ', ') from (`job_order_user` `jos` join `user` `u` on((`jos`.`user_id` = `u`.`id`))) where (`jos`.`job_order_id` = `jo`.`id`)) AS `users` from (`job_order` `jo` join `company` `c` on((`jo`.`company_id` = `c`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `registration_list`
--
DROP TABLE IF EXISTS `registration_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `registration_list`  AS  select `r`.`id` AS `id`,(case when (`r`.`status` = 1) then 'Pending' when (`r`.`status` = 2) then 'Approved' else 'Unknown' end) AS `status`,`r`.`last_name` AS `last_name`,`r`.`first_name` AS `first_name`,`r`.`birthday` AS `birthday`,(case when (`r`.`civil_status` = 1) then 'Single' when (`r`.`civil_status` = 2) then 'Married' when (`r`.`civil_status` = 3) then 'Widowed' else 'Unknown' end) AS `civil_status`,0 AS `active_application`,`r`.`email` AS `email`,`r`.`primary_phone` AS `primary_phone`,`r`.`secondary_phone` AS `secondary_phone`,`r`.`work_phone` AS `work_phone`,`r`.`best_time_to_call` AS `best_time_to_call`,`r`.`address` AS `address`,(case when (`r`.`can_relocate` = 1) then 'Yes' when (`r`.`can_relocate` = 0) then 'No' else 'Unknown' end) AS `can_relocate`,`r`.`current_employer` AS `current_employer`,`r`.`source` AS `source`,`r`.`current_pay` AS `current_pay`,`r`.`desired_pay` AS `desired_pay`,(select group_concat(concat(`s`.`name`,'(',`ask`.`years_of_experience`,'y)') separator ', ') from (`registration_skill` `ask` join `skill` `s` on((`ask`.`skill_id` = `s`.`id`))) where (`ask`.`registration_id` = `r`.`id`)) AS `skills`,`r`.`objectives` AS `objectives`,`r`.`educational_background` AS `educational_background`,`r`.`professional_experience` AS `professional_experience`,`r`.`seminars_and_trainings` AS `seminars_and_trainings` from `registration` `r` where ((`r`.`status` = 1) and (`r`.`is_deleted` <> 1)) ;

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
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_skill`
--
ALTER TABLE `applicant_skill`
  ADD PRIMARY KEY (`applicant_id`,`skill_id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `fk_skill_applicant` (`skill_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_skill`
--
ALTER TABLE `registration_skill`
  ADD PRIMARY KEY (`registration_id`,`skill_id`),
  ADD KEY `fk_skill_applicant` (`skill_id`),
  ADD KEY `applicant_id` (`registration_id`);

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
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
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
-- Constraints for table `applicant_skill`
--
ALTER TABLE `applicant_skill`
  ADD CONSTRAINT `fk_applicant_skill` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`id`),
  ADD CONSTRAINT `fk_skill_applicant` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`);

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
-- Constraints for table `registration_skill`
--
ALTER TABLE `registration_skill`
  ADD CONSTRAINT `fk_registration_skill` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`);

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
