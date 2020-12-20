-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 20, 2020 at 07:34 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

DROP TABLE IF EXISTS `developers`;
CREATE TABLE IF NOT EXISTS `developers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dev_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `dev_name`, `created_date`, `updated_date`) VALUES
(1, 'Dev 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Dev 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Dev 3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Dev 4', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
CREATE TABLE IF NOT EXISTS `issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `developer_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int(10) NOT NULL,
  `priority` text COLLATE utf8_unicode_ci NOT NULL,
  `region` text COLLATE utf8_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `target_version_id` int(10) NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `reviewer_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_devloper_id` (`developer_id`),
  KEY `reviewer_id` (`reviewer_id`),
  KEY `fk_target_version_id` (`target_version_id`) USING BTREE,
  KEY `fk_status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `issue_id`, `developer_id`, `reviewer_id`, `subject`, `description`, `status_id`, `priority`, `region`, `due_date`, `target_version_id`, `image`, `reviewer_comment`, `is_active`, `created_date`, `updated_date`) VALUES
(1, 'CR001', 3, 1, 'Could not save user from user screen', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'Medium', 'india,japan', '2020-12-15', 2, 'issue_img.png', 'User not able to save information', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'CR002', 3, 3, 'User not able to login', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'Medium', 'europe,india,japan', '2020-12-18', 4, 'issue_img.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'CR003', 3, 3, 'Email notifications are not coming', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'Low', 'china,europe,india,japan', '2020-12-18', 5, 'issue_img.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'CR004', 2, 3, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'Medium', 'europe,india', '2020-12-16', 5, 'issue_img.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'CR005', 2, 3, 'Lorem ipsum dolor sit amet, ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'Medium', 'china,europe', '2020-12-15', 4, 'issue_img.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'CR006', 4, 4, 'Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,', 'Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,', 1, 'Medium', 'india', '2020-12-08', 3, 'issue_img.png', 'Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,Lorem ipsum dolor sit amet,', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `issue_status`
--

DROP TABLE IF EXISTS `issue_status`;
CREATE TABLE IF NOT EXISTS `issue_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `issue_status`
--

INSERT INTO `issue_status` (`id`, `status_name`) VALUES
(1, 'New'),
(2, 'Assigned'),
(3, 'In-Progress'),
(4, 'Under-review'),
(5, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

DROP TABLE IF EXISTS `reviewer`;
CREATE TABLE IF NOT EXISTS `reviewer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reviewer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`id`, `reviewer_name`, `created_date`, `updated_date`) VALUES
(1, 'revi dev 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'revi dev 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'revi dev 3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'revi dev 4', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `target_versions`
--

DROP TABLE IF EXISTS `target_versions`;
CREATE TABLE IF NOT EXISTS `target_versions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `target_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `target_versions`
--

INSERT INTO `target_versions` (`id`, `target_version`) VALUES
(1, '1.0.0'),
(2, '1.0.1'),
(3, '1.1.0'),
(4, '1.1.1'),
(5, '1.1.2');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `fk_devloper_id` FOREIGN KEY (`developer_id`) REFERENCES `developers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
