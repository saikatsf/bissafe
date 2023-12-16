-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 07:19 AM
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
-- Database: `bissafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_service`
--

CREATE TABLE `additional_service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit_id` tinyint(4) NOT NULL,
  `price` varchar(50) NOT NULL,
  `qty` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `additional_service`
--

INSERT INTO `additional_service` (`id`, `name`, `sector_id`, `category_id`, `unit_id`, `price`, `qty`, `user_id`, `created_at`, `del_action`) VALUES
(1, 'Service Name1', 1, 1, 1, '100', 1, 1, '2021-06-12 12:28:53', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `attachment_docs`
--

CREATE TABLE `attachment_docs` (
  `id` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `ref_type` varchar(50) NOT NULL,
  `ref_docs` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `sector_id`, `created_at`, `del_action`) VALUES
(1, 'Fan', 1, '2021-05-05 08:40:14', 'N'),
(2, 'Light', 1, '2021-05-05 08:40:14', 'N'),
(3, 'Carpentry', 2, '2021-05-05 08:41:37', 'N'),
(4, 'Plasterwork', 2, '2021-05-05 08:41:37', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `currency_id`, `created_at`, `del_action`) VALUES
(1, 'India', 1, '2021-04-07 10:42:28', 'N'),
(2, 'UK', 2, '2021-04-07 10:42:28', 'N'),
(3, 'United States', 2, '2021-06-06 00:17:51', 'N'),
(4, 'Estados Unidos', 0, '2021-08-05 23:13:31', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `symbol` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `symbol`, `created_at`, `del_action`) VALUES
(1, 'Rupee', '₹', '2021-04-07 10:41:35', 'N'),
(2, 'Pound', '£', '2021-04-07 10:41:57', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `emp_profile`
--

CREATE TABLE `emp_profile` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL COMMENT 'users->id (employee_id)',
  `company_id` int(11) NOT NULL COMMENT 'users->id (SP users->id)',
  `profile_pic` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `emp_profile`
--

INSERT INTO `emp_profile` (`id`, `employee_id`, `company_id`, `profile_pic`, `created_at`, `updated_at`, `del_action`) VALUES
(14, 96, 95, '', '2023-10-04 09:10:55', NULL, 'N'),
(15, 97, 95, '', '2023-10-04 09:20:40', NULL, 'N'),
(16, 98, 94, 'users_6521325e82883_98.png', '2023-10-07 06:26:38', NULL, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `estimator`
--

CREATE TABLE `estimator` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'SP user_id',
  `accepted_by` int(11) NOT NULL COMMENT 'CUstomer user_id',
  `accepted_at` datetime NOT NULL,
  `estimator_status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `estimator`
--

INSERT INTO `estimator` (`id`, `title`, `total_price`, `created_by`, `accepted_by`, `accepted_at`, `estimator_status`, `created_at`, `updated_at`, `del_action`) VALUES
(59, 'Shiv', 0.00, 94, 0, '0000-00-00 00:00:00', 'Pending', '2023-10-04 06:06:40', '0000-00-00 00:00:00', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `estimator_items`
--

CREATE TABLE `estimator_items` (
  `id` int(11) NOT NULL,
  `estimator_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` tinyint(4) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `job_type_id` tinyint(4) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `job_description` text NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `sector_id` tinyint(4) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `job_type_id`, `from_date`, `to_date`, `expiry_date`, `job_description`, `country_id`, `state_id`, `location`, `sector_id`, `category_id`, `user_id`, `created_at`, `del_action`) VALUES
(20, 'yes', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00', '2023-04-10 00:00:00', 'yes', 1, 7, 'Delhi - Mumbai Expressway', 1, 1, 94, '2023-10-04 06:04:59', 'N'),
(21, 'carpenter', 1, '2023-04-10 00:00:00', '2023-04-11 00:00:00', '2023-04-11 00:00:00', 'join', 1, 8, 'Kolkata West International City Road', 2, 3, 95, '2023-10-04 07:52:44', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `job_post_category`
--

CREATE TABLE `job_post_category` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job_post_category`
--

INSERT INTO `job_post_category` (`id`, `job_id`, `category_id`, `del_action`) VALUES
(25, 20, 1, 'N'),
(26, 21, 3, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `job_response`
--

CREATE TABLE `job_response` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `skills` varchar(250) NOT NULL,
  `experience` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0->pending, 1->job offered, 2->rejected by service provider, 3->Offer accepted, 4-> rejected by employee',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_response`
--

INSERT INTO `job_response` (`id`, `job_id`, `user_id`, `name`, `email`, `skills`, `experience`, `description`, `status`, `created_at`, `del_action`) VALUES
(5, 21, 100, 'test emp j', 'testempj@mail.com', 'test skill', 10, 'i want this job', 2, '2023-10-11 00:29:09', 'N'),
(6, 21, 100, 'test emp j', 'testempj@mail.com', 'test skill', 10, 'hi provider', 0, '2023-10-11 00:29:25', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id`, `name`, `created_at`, `del_action`) VALUES
(1, 'Pernament', '2021-05-08 08:10:12', 'N'),
(2, 'C2H', '2021-05-08 08:10:12', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `name`, `sector_id`, `category_id`, `user_id`, `total`, `created_at`, `del_action`) VALUES
(1, 'Testing Package', 1, 1, 1, '50', '2021-06-13 06:26:20', 'N'),
(2, 'Testing Package', 1, 1, 1, '50', '2021-06-13 06:54:44', 'N'),
(3, 'Testing Package', 1, 1, 1, '50', '2021-06-13 07:32:48', 'N'),
(4, 'ggg', 1, 1, 8, '50', '2021-08-08 14:40:44', 'N'),
(5, 'hello', 1, 1, 8, '60', '2021-08-08 14:49:03', 'N'),
(6, 'vhh', 1, 1, 8, '50', '2021-08-08 18:27:38', 'N'),
(7, 'electrical rewire', 1, 1, 8, '50', '2021-08-10 16:05:35', 'N'),
(8, 'hello', 2, 3, 15, '200.0', '2021-08-26 07:59:34', 'N'),
(9, 'new pack ', 1, 1, 15, '239.0', '2021-08-26 08:09:53', 'N'),
(10, 'good new', 2, 3, 15, '128.0', '2021-08-26 08:15:26', 'N'),
(11, 'good deal', 1, 1, 15, '100.0', '2021-08-26 08:55:42', 'N'),
(12, 'test package', 2, 3, 16, '25.0', '2021-09-14 05:12:02', 'N'),
(13, 'Test create package', 1, 1, 49, 'null', '2021-12-25 13:29:11', 'N'),
(14, 'test 2', 1, 3, 49, 'null', '2021-12-25 13:52:15', 'N'),
(15, 'package one', 2, 4, 63, '105.0', '2022-08-19 01:09:23', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` tinyint(4) NOT NULL,
  `price` varchar(50) NOT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `package_service`
--

INSERT INTO `package_service` (`id`, `package_id`, `service_id`, `qty`, `unit_id`, `price`, `del_action`) VALUES
(1, 1, 1, 2, 1, '20', 'N'),
(2, 1, 2, 2, 1, '30', 'N'),
(3, 2, 1, 2, 1, '20', 'N'),
(4, 2, 2, 2, 1, '30', 'N'),
(5, 3, 1, 2, 1, '20', 'N'),
(6, 3, 2, 2, 1, '30', 'N'),
(7, 4, 0, 1, 1, '65', 'N'),
(8, 5, 0, 1, 2, '100', 'N'),
(9, 6, 0, 1, 2, '100', 'N'),
(10, 6, 0, 1, 1, '65', 'N'),
(11, 8, 0, 2, 2, '100', 'N'),
(12, 8, 0, 2, 2, '100', 'N'),
(13, 9, 0, 1, 1, '100', 'N'),
(14, 9, 0, 2, 1, '139', 'N'),
(15, 10, 0, 2, 2, '100', 'N'),
(16, 10, 0, 1, 1, '28', 'N'),
(17, 11, 0, 1, 1, '100', 'N'),
(18, 12, 0, 1, 1, '25', 'N'),
(19, 15, 0, 2, 1, '50', 'N'),
(20, 15, 0, 1, 1, '55', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `package_total`
--

CREATE TABLE `package_total` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `total` varchar(50) NOT NULL,
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `package_total`
--

INSERT INTO `package_total` (`id`, `package_id`, `total`, `del_action`) VALUES
(1, 1, '50', 'N'),
(2, 2, '50', 'N'),
(3, 3, '50', 'N'),
(4, 4, '65.0', 'N'),
(5, 5, '100.0', 'N'),
(6, 6, '165.0', 'N'),
(7, 7, 'null', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `payment_milestone`
--

CREATE TABLE `payment_milestone` (
  `id` int(11) NOT NULL,
  `estimator_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `amt_percentage` tinyint(4) NOT NULL,
  `due_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment_milestone`
--

INSERT INTO `payment_milestone` (`id`, `estimator_id`, `title`, `amt_percentage`, `due_date`, `created_at`, `del_action`) VALUES
(1, 1, 'First Amount', 20, '2021-09-10', '2021-09-05 10:55:23', 'N'),
(2, 1, 'FInal', 80, '2021-12-12', '2021-09-05 10:55:23', 'N'),
(3, 47, 'First Amount', 20, '2021-09-10', '2021-09-12 05:01:31', 'N'),
(4, 47, 'FInal', 80, '2021-12-12', '2021-09-12 05:01:31', 'N'),
(5, 49, 'first ', 50, '2021-09-12', '2021-09-12 05:10:45', 'N'),
(6, 50, 'one payment ', 50, '2021-09-13', '2021-09-12 07:51:26', 'N'),
(7, 50, 'second payment ', 50, '2021-09-25', '2021-09-12 07:51:26', 'N'),
(8, 51, 'hello  1st pay', 50, '2021-09-13', '2021-09-12 08:06:07', 'N'),
(9, 51, '2nd payment ', 50, '2021-09-30', '2021-09-12 08:06:07', 'N'),
(10, 52, 'advance ', 20, '2021-09-12', '2021-09-12 08:42:11', 'N'),
(11, 53, 'mariposa', 10, '2021-09-12', '2021-09-12 22:39:26', 'N'),
(12, 54, 'first time ', 50, '2021-09-22', '2021-09-13 11:54:52', 'N'),
(13, 54, '2 ND pay ', 50, '2021-09-30', '2021-09-13 11:54:52', 'N'),
(14, 55, 'advance', 30, '2022-05-29', '2022-04-28 06:45:35', 'N'),
(15, 57, 'advance ', 20, '2022-06-15', '2022-05-15 00:28:19', 'N'),
(16, 58, 'advance pay', 20, '2022-10-30', '2022-09-30 11:45:57', 'N'),
(17, 58, 'after carpentry job ', 30, '2022-12-02', '2022-09-30 11:45:57', 'N'),
(18, 59, 'Hello', 40, '2023-10-04', '2023-10-04 06:06:40', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `payment_structure`
--

CREATE TABLE `payment_structure` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment_structure`
--

INSERT INTO `payment_structure` (`id`, `name`, `created_at`, `del_action`) VALUES
(1, '1000-5000', '2021-05-08 08:13:44', 'N'),
(2, '5000-10000', '2021-05-08 08:13:44', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `del_action`) VALUES
(1, 'Admin', '2021-03-21 22:46:31', 'N'),
(2, 'SP', '2021-03-21 22:46:31', 'N'),
(3, 'Emp', '2021-03-21 22:47:03', 'N'),
(4, 'Cus', '2021-03-21 22:48:01', 'N'),
(5, 'Job', '2021-03-21 22:48:01', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`id`, `name`, `created_at`, `del_action`) VALUES
(1, 'Electronics', '2021-05-05 08:38:32', 'N'),
(2, 'Construction', '2021-05-05 08:38:32', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price_type` enum('custom','recommended') NOT NULL,
  `unit_id` tinyint(4) NOT NULL,
  `price` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `service_type` enum('self','additional') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_profile`
--

CREATE TABLE `sp_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('0','1') NOT NULL COMMENT '0->Licensed, 1->Non-Licensed',
  `business_name` varchar(255) NOT NULL,
  `proof_number` varchar(50) NOT NULL,
  `expire_date` date NOT NULL,
  `alt_contact` varchar(15) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `business_year` char(5) NOT NULL,
  `website_url` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `business_type` int(11) NOT NULL DEFAULT 0 COMMENT '0->Construction, 1->Non-construction, 2->Both',
  `provider_status` int(11) NOT NULL DEFAULT 0 COMMENT '0->Inactive, 1->Active, 2->Rejected	',
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sp_profile`
--

INSERT INTO `sp_profile` (`id`, `user_id`, `user_type`, `business_name`, `proof_number`, `expire_date`, `alt_contact`, `country_id`, `state_id`, `address`, `city`, `business_year`, `website_url`, `logo`, `business_type`, `provider_status`, `del_action`) VALUES
(54, 94, '0', 'Demo', '8745', '2023-10-04', '+91', 1, 1, 'Varanasi', 'Varanasi', '1993', 'www.google.com', '', 0, 1, 'N'),
(55, 95, '0', 'Saikat Fouzdar Ltd.', '112233', '2023-10-04', '+91', 1, 1, 'RandomStreet', 'RandomCity', '10', 'saikatfouzdar.com', '', 2, 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N','') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `country_id`, `created_at`, `del_action`) VALUES
(1, 'UP', 1, '2021-04-07 10:43:06', 'N'),
(2, 'UK State', 2, '2021-04-07 10:43:06', 'N'),
(3, 'Uttar Pradesh', 0, '2021-06-06 06:25:10', 'N'),
(4, 'Delhi', 0, '2021-06-06 08:11:53', 'N'),
(5, 'California', 0, '2021-08-04 22:20:23', 'N'),
(6, 'Maharashtra', 0, '2021-08-26 02:01:51', 'N'),
(7, 'Madhya Pradesh', 0, '2023-10-04 06:04:59', 'N'),
(8, 'West Bengal', 0, '2023-10-04 07:52:44', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `user_id`, `created_at`, `del_action`) VALUES
(1, 'Quantity', 1, '2021-06-12 12:30:51', 'N'),
(2, 'Square Foot Each', 1, '2021-06-12 12:31:09', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'User->Id, Primary Key',
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `password` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0->Inactive, 1->Active',
  `added_by` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0->Self, 1->Admin',
  `role_id` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `del_action` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `contact_no`, `password`, `status`, `added_by`, `role_id`, `created_at`, `del_action`) VALUES
(1, 'Bissafe Admin', 'bissafeapp@gmail.com', '+919793077770', 'bissafepass', '1', '1', 1, '2023-10-04 04:27:02', 'N'),
(94, 'Ram', 'ram@gmail.comD', '+919793077770', NULL, '1', '0', 2, '2023-10-04 04:01:22', 'N'),
(95, 'Saikat Fouzdar', 'saikatf2021@gmail.com', '+919874808024', NULL, '1', '0', 2, '2023-10-04 07:36:47', 'N'),
(96, 'saikat emp', 'saikatenp@mail.com', '+919874563210', NULL, '0', '0', 3, '2023-10-04 09:10:55', 'N'),
(97, 'saikat second emp', 'saikatemp2@mail.com', '+911234567890', NULL, '0', '0', 3, '2023-10-04 09:20:40', 'N'),
(98, 'Shivam', 'Shivam', '+919616066107', NULL, '0', '0', 3, '2023-10-07 06:26:38', 'N'),
(100, 'test emp', 'testemp@mail.com', '9874880024', NULL, '1', '0', 3, '2023-10-10 15:30:19', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_service`
--
ALTER TABLE `additional_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attachment_docs`
--
ALTER TABLE `attachment_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_profile`
--
ALTER TABLE `emp_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimator`
--
ALTER TABLE `estimator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimator_items`
--
ALTER TABLE `estimator_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_post_category`
--
ALTER TABLE `job_post_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_response`
--
ALTER TABLE `job_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_type`
--
ALTER TABLE `job_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_total`
--
ALTER TABLE `package_total`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_milestone`
--
ALTER TABLE `payment_milestone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_structure`
--
ALTER TABLE `payment_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_profile`
--
ALTER TABLE `sp_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_service`
--
ALTER TABLE `additional_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attachment_docs`
--
ALTER TABLE `attachment_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_profile`
--
ALTER TABLE `emp_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `estimator`
--
ALTER TABLE `estimator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `estimator_items`
--
ALTER TABLE `estimator_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `job_post_category`
--
ALTER TABLE `job_post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `job_response`
--
ALTER TABLE `job_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `package_service`
--
ALTER TABLE `package_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `package_total`
--
ALTER TABLE `package_total`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_milestone`
--
ALTER TABLE `payment_milestone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_structure`
--
ALTER TABLE `payment_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sp_profile`
--
ALTER TABLE `sp_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User->Id, Primary Key', AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
