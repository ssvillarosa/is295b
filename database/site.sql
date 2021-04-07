-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2021 at 11:53 AM
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
  `pipeline_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `activity_type` tinyint(4) NOT NULL,
  `activity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `applicant_skill`
--

CREATE TABLE `applicant_skill` (
  `applicant_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_time` datetime NOT NULL,
  `description` text NOT NULL,
  `is_public` tinyint(4) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `job_order_skill`
--

CREATE TABLE `job_order_skill` (
  `job_order_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_order_user`
--

CREATE TABLE `job_order_user` (
  `job_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pipeline`
--

CREATE TABLE `pipeline` (
  `id` int(11) NOT NULL,
  `job_order_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `is_email_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `confirmed_time` timestamp NULL DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `registration_skill`
--

CREATE TABLE `registration_skill` (
  `registration_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `years_of_experience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `skill_category`
--

CREATE TABLE `skill_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
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

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activity_updated_by_user` (`updated_by`),
  ADD KEY `fk_pipeline_activity` (`pipeline_id`);

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
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_activity` (`activity_id`),
  ADD KEY `fk_event_deleted_by_user` (`deleted_by`);

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
-- Indexes for table `pipeline`
--
ALTER TABLE `pipeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_job_order_pipeline` (`job_order_id`),
  ADD KEY `fk_applicant_pipeline` (`applicant_id`),
  ADD KEY `fk_pipeline_added_by` (`created_by`),
  ADD KEY `fk_pipeline_deleted_by` (`deleted_by`);

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
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activity_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pipeline`
--
ALTER TABLE `pipeline`
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
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_updated_by_user` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_pipeline_activity` FOREIGN KEY (`pipeline_id`) REFERENCES `pipeline` (`id`);

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
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_activity` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `fk_event_deleted_by_user` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`);

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
-- Constraints for table `pipeline`
--
ALTER TABLE `pipeline`
  ADD CONSTRAINT `fk_applicant_pipeline` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`id`),
  ADD CONSTRAINT `fk_job_order_pipeline` FOREIGN KEY (`job_order_id`) REFERENCES `job_order` (`id`),
  ADD CONSTRAINT `fk_pipeline_added_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_pipeline_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`);

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

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
