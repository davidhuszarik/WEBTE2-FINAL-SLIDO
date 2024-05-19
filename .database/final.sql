-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 08, 2024 at 01:40 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final`
--
CREATE DATABASE IF NOT EXISTS `final` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `final`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
                           `id` bigint NOT NULL,
                           `period_id` bigint NOT NULL,
                           `user_id` bigint DEFAULT NULL,
                           `type` enum('single_choice','multi_choice','open') NOT NULL,
                           `free_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                           `vote_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
                           `id` bigint NOT NULL,
                           `question_id` bigint NOT NULL,
                           `value_en` varchar(64) NOT NULL,
                           `value_sk` varchar(64) NOT NULL,
                           `is_correct` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

DROP TABLE IF EXISTS `periods`;
CREATE TABLE `periods` (
                           `id` bigint NOT NULL,
                           `question_id` bigint DEFAULT NULL,
                           `title_en` varchar(64) NOT NULL,
                           `title_sk` varchar(64) NOT NULL,
                           `content_en` text NOT NULL,
                           `content_sk` text NOT NULL,
                           `type` enum('single_choice','multi_choice','open') NOT NULL,
                           `start_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `end_timestamp` timestamp NOT NULL COMMENT 'This must be set a adequately large timestamp from start timestamp by default if not set',
                           `code` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picked_static_options`
--

DROP TABLE IF EXISTS `picked_static_options`;
CREATE TABLE `picked_static_options` (
                                         `answer_id` bigint NOT NULL,
                                         `static_option_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
                             `id` bigint NOT NULL,
                             `user_id` bigint NOT NULL,
                             `title_en` varchar(64) NOT NULL,
                             `title_sk` varchar(64) NOT NULL,
                             `content_en` text NOT NULL,
                             `content_sk` text NOT NULL,
                             `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `type` enum('single_choice','multi_choice','open') NOT NULL DEFAULT 'single_choice'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `static_options`
--

DROP TABLE IF EXISTS `static_options`;
CREATE TABLE `static_options` (
                                  `id` bigint NOT NULL,
                                  `period_id` bigint NOT NULL,
                                  `value_en` varchar(64) NOT NULL,
                                  `value_sk` varchar(64) NOT NULL,
                                  `is_correct` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
                        `id` bigint NOT NULL,
                        `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                        `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                        `hashed_password` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                        `salt` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'spVj3cUa',
                        `google_2FA_secret` varchar(21) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                        `access_token` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                        `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_answer_period` (`period_id`),
    ADD KEY `fk_answer_user` (`user_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_option_question` (`question_id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `code` (`code`),
    ADD KEY `fk_period_question` (`question_id`);

--
-- Indexes for table `picked_static_options`
--
ALTER TABLE `picked_static_options`
    ADD PRIMARY KEY (`answer_id`,`static_option_id`),
    ADD KEY `fk_pickedStaticOption_answer` (`answer_id`),
    ADD KEY `fk_pickedStaticOption_optionStatic` (`static_option_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_question_user` (`user_id`);

--
-- Indexes for table `static_options`
--
ALTER TABLE `static_options`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_staticOption_period` (`period_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `username` (`username`),
    ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `static_options`
--
ALTER TABLE `static_options`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
    ADD CONSTRAINT `fk_answer_period` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
    ADD CONSTRAINT `fk_answer_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
    ADD CONSTRAINT `fk_option_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `periods`
--
ALTER TABLE `periods`
    ADD CONSTRAINT `fk_period_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `picked_static_options`
--
ALTER TABLE `picked_static_options`
    ADD CONSTRAINT `fk_pickedStaticOption_answer` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
    ADD CONSTRAINT `fk_pickedStaticOption_optionStatic` FOREIGN KEY (`static_option_id`) REFERENCES `static_options` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
    ADD CONSTRAINT `fk_question_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `static_options`
--
ALTER TABLE `static_options`
    ADD CONSTRAINT `fk_staticOption_period` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `clearOldAccessTokens`$$
CREATE DEFINER=`Tim5`@`%` EVENT `clearOldAccessTokens` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-04-28 22:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `user`
                                                                                                                                                    SET access_token = NULL
                                                                                                                                                    WHERE TIMESTAMPDIFF(HOUR, last_access, NOW()) >= 24$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
