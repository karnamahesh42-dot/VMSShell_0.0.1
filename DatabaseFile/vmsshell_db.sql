-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 11:34 AM
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
-- Database: `vmsshell_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `is_active`, `created_at`) VALUES
(1, 'UKMPL', 1, '2025-12-27 16:56:32'),
(2, 'DHPL', 1, '2025-12-27 16:56:32'),
(3, 'ETPL', 1, '2025-12-27 16:56:32'),
(4, 'Eenadu', 1, '2025-12-27 16:56:32'),
(5, 'ETV Bharat', 1, '2025-12-27 16:56:32'),
(6, 'Priya Foods', 1, '2025-12-27 16:56:32'),
(7, 'Wellness Center', 1, '2025-12-27 16:56:32'),
(8, 'Ramoji Foundation', 1, '2025-12-27 16:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `company_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `company_id`) VALUES
(1, 'IT', NULL),
(2, 'Finance', NULL),
(3, 'HR', NULL),
(4, 'Procurement', NULL),
(5, 'Stores', NULL),
(6, 'Security', NULL),
(7, 'Maya', NULL),
(8, 'Tourism', NULL),
(9, 'Events', NULL),
(10, 'Films', NULL),
(11, 'CMD Secretariat', NULL),
(12, 'MD Secretariat', NULL),
(13, 'Director Secretariat', NULL),
(14, 'Agro', NULL),
(15, 'GMHK', NULL),
(16, 'Staff Canteen', NULL),
(17, 'Priya Dairy', NULL),
(18, 'Civil', NULL),
(19, 'Electrical', NULL),
(20, 'Mechanical', NULL),
(21, 'Hospital', NULL),
(22, 'Universal Travels', NULL),
(23, 'Publicity', NULL),
(24, 'Tou-Electrical', NULL),
(25, 'Tou-Mechanical', NULL),
(26, 'Tou-Finance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expired_visitor_passes`
--

CREATE TABLE `expired_visitor_passes` (
  `id` int(11) NOT NULL,
  `visitor_request_id` int(11) NOT NULL,
  `v_code` varchar(50) DEFAULT NULL,
  `header_code` varchar(50) DEFAULT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expired_visitor_passes`
--

INSERT INTO `expired_visitor_passes` (`id`, `visitor_request_id`, `v_code`, `header_code`, `expired_at`, `created_at`) VALUES
(1, 1, NULL, 'GV000001', '2025-12-31 15:13:34', '2025-12-31 15:13:34'),
(2, 2, NULL, 'GV000002', '2026-01-03 10:20:40', '2026-01-03 10:20:40'),
(3, 3, NULL, 'GV000003', '2026-01-03 10:20:40', '2026-01-03 10:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `purposes`
--

CREATE TABLE `purposes` (
  `id` int(11) NOT NULL,
  `purpose_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purposes`
--

INSERT INTO `purposes` (`id`, `purpose_name`, `status`) VALUES
(1, 'General Visit', 1),
(2, 'Location Recce', 1),
(3, 'Wedding', 1),
(4, 'Vendor Visit', 1),
(5, 'Delivery', 1),
(6, 'Meeting', 1),
(7, 'Interview', 1),
(8, 'Document Submission', 1),
(9, 'Verification / Approval', 1),
(10, 'Event Visit', 1),
(11, 'Tourism Visit', 1),
(12, 'Personal Visit', 1),
(13, 'Site Inspection', 1),
(14, 'Maintenance / Service', 1),
(15, 'Travel Agents', 1),
(16, 'Local Villagers', 1),
(17, 'EVENTS Artist', 1),
(18, 'Cooperate Recti', 1),
(19, 'Politicians', 1),
(20, 'EVENT CREW', 1),
(21, 'Films Recti', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reference_person_role` enum('Supervisor','Manager','Mediator','Other') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`id`, `name`, `email`, `phone`, `address`, `description`, `reference_person_role`, `status`, `created_by`, `created_at`) VALUES
(1, 'Mahesh', 'satisht@gmail.com', '8919146333', 'Test', 'Test \r\nDescription', 'Manager', 1, 5, '2025-11-26 11:52:14'),
(2, 'Sathish', 'satish@gmail.com', '8919146333', 'kakinada', 'reference Person', 'Mediator', 1, 5, '2025-11-26 12:12:04'),
(3, 'sreenivas', 'srenivas@gmai.com', '8919146333', 'kakinada', 'abc', 'Manager', 1, 5, '2025-11-27 12:01:19'),
(4, 'Krishna V', 'krishnadvasireddy@gmail.com', '9100060606', 'abnc', 'xyz', 'Manager', 1, 5, '2025-11-28 12:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `reference_visitor_requests`
--

CREATE TABLE `reference_visitor_requests` (
  `id` int(11) NOT NULL,
  `rvr_code` varchar(10) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `visit_date` date NOT NULL,
  `visitor_count` int(11) DEFAULT 1,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(2, 'admin'),
(4, 'security'),
(1, 'superadmin'),
(3, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `security_gate_logs`
--

CREATE TABLE `security_gate_logs` (
  `id` int(11) NOT NULL,
  `visitor_request_id` int(11) NOT NULL,
  `v_code` varchar(10) NOT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_by` int(5) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `hash_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT current_timestamp(),
  `email` varchar(150) NOT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `employee_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `priority`, `name`, `company_name`, `department_id`, `username`, `password`, `role_id`, `active`, `hash_key`, `created_at`, `created_by`, `email`, `last_login_at`, `employee_code`) VALUES
(1, 0, 'Super Admin', 'UKMPL', 1, 'superadmin', '274d015c638f62ba24b19ca23c9c9503', 1, 1, 'HASHKEY123', '2025-11-20 09:28:43', NULL, 'developers@ramojifilmcity.com', '2026-01-05 11:57:41', '2523011'),
(5, 2, 'Sreenivas', 'UKMPL', 1, 'sreenivas', '5f3dd4f062ed308119614e7e3e82d4c1', 2, 1, 'HASHKEY123', '2025-11-21 05:54:24', 1, 'ukmledp@ramojifilmcity.com', NULL, '12345678'),
(6, 10, 'Prakash', 'UKMPL', 3, 'hruser2', '1b0041377a27ec89d4ff989d048f5e85', 3, 1, 'HASHKEY123', '2025-11-21 22:15:08', 1, 'prakash@gmail.com', NULL, '789654159'),
(7, 0, 'Prasad ', 'UKMPL', 3, 'hrhod', 'f271d1efdfba760f7145d4436f845b8e', 2, 1, 'HASHKEY123', '2025-11-22 05:56:17', 1, 'prasad@gmail.com', NULL, '951357456'),
(8, 10, 'Sury kumar', 'UKMPL', 1, 'suryakumar', '45b97ac60ca6e41341d1bfe4f39d5227', 3, 1, 'HASHKEY123', '2025-11-24 00:22:13', 1, 'kumar@gmail.com', NULL, '87456321'),
(9, 10, 'Radhika', 'UKMPL', 2, 'radhika', '2a14558094169ea7f79f928213fd9a20', 3, 1, 'HASHKEY123', '2025-11-24 03:40:59', 1, 'radhika@gmail.com', '2026-01-01 15:43:59', '951456357'),
(10, 10, 'Sailesh Kumar', 'UKMPL', 2, 'sailesh', '439dd07182ce0dcd1f225293d85be464', 2, 1, 'HASHKEY123', '2025-11-27 23:56:49', 5, 'miscentraloffice@ramojifilmcity.com', NULL, '741963258'),
(11, 2, 'Satish Kumar', 'UKMPL', 2, 'satish', '135c44d20155d3a67bc984f17492a3d3', 2, 1, 'HASHKEY123', '2025-11-30 09:57:12', 5, 'gmaccounts@ramojifilmcity.com', '2025-12-30 11:11:30', '321987456'),
(12, 10, 'pallam raju', 'UKMPL', 3, 'hruser', '5980d6ad05354bd8681adff071323804', 3, 1, 'HASHKEY123', '2025-11-30 15:37:58', 5, 'raju@gmail.com', NULL, '456812397'),
(13, 10, 'khan', 'UKMPL', 6, 'security', '7f56499c9bcb7018d17adba024f12b36', 4, 1, NULL, '2025-12-01 10:32:56', 5, 'khan@gmail.com', '2026-01-03 17:15:52', '89595875'),
(14, 10, 'Kumar', 'UKMPL', 5, 'kumar', 'b9b580e1f1d30f72a52c9696dfa3c1a3', 3, 0, NULL, '2025-12-02 03:46:21', 5, 'kumar@gmail.com', NULL, '53532581'),
(15, 10, 'Mahesh Karna', 'UKMPL', 1, 'mahesh', 'b9a7b941299a521d0a5abb9cee30bfec', 3, 1, 'HASHKEY123', '2025-12-09 11:46:10', 1, 'karnamahesh42@gmail.com', NULL, '123456'),
(16, 3, 'Lokesh', 'UKMPL', 2, 'lokesh', 'd273c8b0aa7f42e27fe0ea75f896167a', 2, 1, 'HASHKEY123', '2025-12-12 15:37:09', 1, 'lokesh@gmail.com', NULL, '87456321'),
(18, 1, 'K Ravindara Rao', 'UKMPL', 2, 'kravindra', '6c185769e88bffa03bed6a8129277205', 2, 1, 'HASHKEY123', '2025-12-13 09:29:06', 1, 'ravindra@gmail.com', NULL, '789564264'),
(19, 1, 'Krishna Vasireddy', 'UKMPL', 1, 'krishna', '130f10ca4711756506b4ac65a3e002c6', 2, 1, 'HASHKEY123', '2025-12-16 08:54:25', 1, 'krishna@gmail.com', NULL, '12345678'),
(20, 10, 'kalapana', 'UKMPL', 4, 'kalapana', '7070f111b4631c091525ab32cf50d225', 3, 1, 'HASHKEY123', '2025-12-26 05:21:07', 1, 'kalapana@gmail.com', NULL, '12345678985'),
(21, 10, 'P Ramanjaneyulu ', 'Eenadu', 2, 'rama', 'a6a7a63c51d014449351318a744711e0', 2, 1, 'HASHKEY123', '2025-12-27 18:11:48', 1, 'ramanajaneyulu@gmail.com', NULL, '78954682'),
(22, 10, 'Soujanya', 'Eenadu', 2, 'soujanya', '27c8134aa75e222dc87397b6b7684bce', 3, 1, 'HASHKEY123', '2025-12-27 18:13:14', 1, 'soujanya@gmail.com', NULL, '78954685'),
(23, 10, 'Highway Gate', 'UKMPL', 6, 'highwaygate', '5794fb47bf7c6ac709beed684978f395', 4, 1, 'HASHKEY123', '2025-12-29 04:28:09', 1, 'securityhighwaygate.central@ramojifilmcity.com', NULL, '25000001'),
(24, 10, 'VIP Gate', 'UKMPL', 6, 'vipgate', '4f3c6a2b587c8b04d9160b694a721b17', 4, 1, 'HASHKEY123', '2025-12-29 04:32:01', 1, 'securityvipgate.central@ramojifilmcity.com', NULL, '2500002'),
(25, 10, 'Material Gate', 'UKMPL', 6, 'materialgate', '378eb7d7c86bd0dec523dc6e0ff0a8ed', 4, 1, 'HASHKEY123', '2025-12-29 04:36:55', 1, 'security.central@ramojifilmcity.com', NULL, 'materialgate'),
(26, 10, 'Material Gate New', 'UKMPL', 6, 'materialgatenew', '528ae4f158c02d05bcc58fefacd07154', 4, 1, 'HASHKEY123', '2025-12-29 04:39:14', 1, 'securitynew.central@ramojifilmcity.com', NULL, '2500003'),
(27, 10, 'Personnel Gate', 'UKMPL', 6, 'personnelgate', '5c201f2a8b29f2f522206bdf202d842e', 4, 1, 'HASHKEY123', '2025-12-29 04:41:14', 1, 'securitypersonnelgate.central@ramojifilmcity.com', NULL, '2500004'),
(28, 10, 'Rear Gate', 'UKMPL', 6, 'reargate', '93ff3ead6029e5a7560078e53d875c82', 4, 1, 'HASHKEY123', '2025-12-29 04:44:31', 1, 'securityreargate.central@ramojifilmcity.com', NULL, '2500005'),
(29, 10, 'Mythological City Gate', 'UKMPL', 6, 'mythologicalcitygate', 'abdfb10b479c0b20f5f3660dbcd29f3e', 4, 1, 'HASHKEY123', '2025-12-29 04:46:09', 1, 'securitymythological.central@ramojifilmcity.com', NULL, '2500006'),
(30, 10, 'Polkampally Gate', 'UKMPL', 6, 'polkampallygate', '96907dc9aa2fb78ad4fc14738c437290', 4, 1, 'HASHKEY123', '2025-12-29 04:47:39', 1, 'securitypolkampally.central@ramojifilmcity.com', NULL, '2500006'),
(31, 2, 'Butchi Raju MV', 'UKMPL', 6, 'butchiraju', '21a030f11877520feeda6c3720a7b6a1', 2, 1, 'HASHKEY123', '2025-12-29 06:35:14', 1, 'cmvigilance@ramojifilmcity.com', NULL, '2500008'),
(32, 10, 'P Sripal', 'UKMPL', 6, 'sripal', '95d56f5aa5ede4debd142848963f68ed', 3, 1, 'HASHKEY123', '2025-12-29 06:41:19', 1, 'security1.central@ramojifilmcity.com', '2025-12-29 12:17:52', '2500009'),
(33, 1, 'M. Poornachandra Rao', 'UKMPL', 10, 'poorna', '82065af6c5d8a70b314f17a7c66e6fea', 2, 1, 'HASHKEY123', '2025-12-29 06:57:22', 1, 'poorna.rfcfilms@ramojifilmcity.com', NULL, '25000010'),
(34, 10, 'Mahender Kumar', 'UKMPL', 10, 'mahender', 'f0342f62375bec6e19774e1d1b95512a', 3, 1, 'HASHKEY123', '2025-12-29 07:05:57', 1, 'hodmaya@ramojifilmcity.com', NULL, '25000011'),
(35, 10, 'Chandana', 'UKMPL', 9, 'chandana', '9ea518e05e961cebe0cab81e85dec868', 3, 1, 'HASHKEY123', '2025-12-29 07:07:15', 1, 'ramojievents@ramojifilmcity.com', NULL, '25000012'),
(36, 10, 'Ch. Pavan Kumar', 'UKMPL', 9, 'pavankumarch', '5bbcfc68c11bffb83a469da0124e1f43', 2, 1, 'HASHKEY123', '2025-12-29 07:09:25', 1, 'pavankumar.ch@ramojifilmcity.com', NULL, '25000013'),
(37, 1, 'A NALINI MOHAN', 'UKMPL', 18, 'nalinimohan', '41c5c1a0e0a77c9a468398f8faf401cc', 2, 1, 'HASHKEY123', '2025-12-31 11:20:16', 1, 'nalinimohan.a@ramojifilmcity.com', NULL, '9394450446'),
(38, 10, 'Y SRINIVAS RAO', 'UKMPL', 18, 'ysrinivasrao', 'dcc3d07a4b74b4b2bc454dca152eeaea', 3, 1, 'HASHKEY123', '2025-12-31 11:22:10', 1, 'srinivas.y@ramojifilmcity.com', NULL, '9100058167'),
(39, 11, 'P  SAMBASIVA RAO', 'UKMPL', 18, 'psambasivarao', '7a3a4796d4a74c4bc6b2bfd7d47d763f', 3, 1, 'HASHKEY123', '2025-12-31 11:25:39', 1, 'sambasivarao.p@ramojifilmcity.com', NULL, '9848471871'),
(40, 12, 'S BHEESHMA', 'UKMPL', 18, ' sbheeshma', 'bbf21d34cef1587af75ed8246ee619c4', 3, 1, 'HASHKEY123', '2025-12-31 11:51:03', 1, 'bheeshma.s@ramojifilmcity.com', NULL, '9394450441'),
(41, 13, 'R SREENIVAS', 'UKMPL', 18, 'rsreenivas', '720afcf5428889ae862488291b0d19ac', 3, 1, 'HASHKEY123', '2025-12-31 11:53:22', 1, 'harmony@ramojifilmcity.com', NULL, '8008044166'),
(42, 4, '  R Sudhakar', 'UKMPL', 12, '  rsudhakar', 'd16172c0c276c66646a2c28422bd2ee0', 2, 1, 'HASHKEY123', '2026-01-01 08:28:13', 1, 'sudhakar.r@ramojifilmcity.com', NULL, '8008009981'),
(43, 1, 'Vijayeswari Cherukuri', 'UKMPL', 12, 'vijayeswari ', '627e757702087f0a4aff0c94415d4789', 2, 1, 'HASHKEY123', '2026-01-01 08:31:16', 1, 'md@ramojifilmcity.com', '2026-01-01 16:01:27', '99999'),
(44, 10, 'Sravanthi', 'UKMPL', 12, 'sravanthi', '63322b097f81712d17a1069aa9a301e9', 3, 1, 'HASHKEY123', '2026-01-01 09:35:26', 1, 'mdoffice@ramojifilmcity.com', '2026-01-01 15:56:06', '9394270099'),
(45, 10, 'G Robin', 'UKMPL', 19, 'grobin', 'c28399c84cd1f0a7417d32358cefa191', 3, 1, 'HASHKEY123', '2026-01-01 13:00:00', 1, 'manager.electrical@ramojifilmcity.com', NULL, '9394450446'),
(46, 11, 'B Kesava Rao', 'UKMPL', 19, 'bkesavarao', 'ed5335b6a45b459f170cd62382a506a7', 3, 1, 'HASHKEY123', '2026-01-01 13:01:35', 1, 'fountains@ramojifilmcity.com', NULL, '9394489035'),
(47, 12, 'G  RamaKrishna Reddy', 'UKMPL', 19, 'gramakrishnareddy', '799c163f93311d07bbb74c5e80e942bb', 3, 1, 'HASHKEY123', '2026-01-01 13:10:05', 1, 'substations.electrical@ramojifilmcity.com', NULL, '9394489045');

-- --------------------------------------------------------

--
-- Table structure for table `user_hashkeys`
--

CREATE TABLE `user_hashkeys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `pass_key` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_password_vault`
--

CREATE TABLE `user_password_vault` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `password_enc` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_password_vault`
--

INSERT INTO `user_password_vault` (`id`, `user_id`, `password_enc`, `created_at`) VALUES
(1, 20, 'kalapana@123', '2025-12-26 10:51:07'),
(2, 5, 'sreenivas@321', '2025-12-26 11:26:51'),
(3, 1, 'superadmin@123', '2025-12-26 11:27:38'),
(4, 21, 'rama@123', '2025-12-27 23:41:48'),
(5, 22, 'soujanya@123', '2025-12-27 23:43:14'),
(6, 23, 'highwaygate@123', '2025-12-29 09:58:09'),
(7, 24, 'vipgate@123', '2025-12-29 10:02:01'),
(8, 25, 'materialgate@123', '2025-12-29 10:06:55'),
(9, 26, 'materialgatenew@123', '2025-12-29 10:09:14'),
(10, 27, 'personnelgate@123', '2025-12-29 10:11:14'),
(11, 28, 'reargate@123', '2025-12-29 10:14:31'),
(12, 29, 'mythologicalcitygate@123', '2025-12-29 10:16:09'),
(13, 30, 'polkampallygate@123', '2025-12-29 10:17:39'),
(14, 31, 'butchiraju@123', '2025-12-29 12:05:14'),
(15, 32, 'sripal@123', '2025-12-29 12:11:19'),
(16, 33, 'poorna@123', '2025-12-29 12:27:22'),
(17, 34, 'mahender@123', '2025-12-29 12:35:57'),
(18, 35, 'chandana@123', '2025-12-29 12:37:15'),
(19, 36, 'pavankumarch@123', '2025-12-29 12:39:25'),
(20, 37, 'nalinimohan@123', '2025-12-31 16:50:16'),
(21, 38, 'ysrinivasrao@123', '2025-12-31 16:52:10'),
(22, 39, 'psambasivarao@123', '2025-12-31 16:55:39'),
(23, 40, ' sbheeshma@123', '2025-12-31 17:21:03'),
(24, 41, 'rsreenivas@123', '2025-12-31 17:23:22'),
(25, 42, '  rsudhakar@123', '2026-01-01 13:58:13'),
(26, 43, 'vijayeswari', '2026-01-01 14:01:16'),
(27, 44, 'sravanthi@123', '2026-01-01 15:05:26'),
(28, 45, 'grobin@123', '2026-01-01 18:30:00'),
(29, 46, 'bkesavarao@123', '2026-01-01 18:31:35'),
(30, 47, 'gramakrishnareddy@123', '2026-01-01 18:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `request_header_id` int(11) DEFAULT NULL,
  `v_code` varchar(10) NOT NULL,
  `group_code` varchar(20) NOT NULL,
  `visitor_name` varchar(200) NOT NULL,
  `visitor_email` varchar(200) NOT NULL,
  `visitor_phone` varchar(50) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `visit_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `expected_from` time DEFAULT NULL,
  `expected_to` time DEFAULT NULL,
  `host_user_id` int(11) NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `meeting_status` tinyint(1) NOT NULL DEFAULT 0,
  `meeting_completed_at` datetime DEFAULT NULL,
  `validity` int(2) NOT NULL DEFAULT 1,
  `securityCheckStatus` tinyint(1) NOT NULL DEFAULT 0,
  `spendTime` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `proof_id_type` varchar(100) DEFAULT NULL,
  `proof_id_number` varchar(100) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `vehicle_id_proof` varchar(255) DEFAULT NULL,
  `visitor_id_proof` varchar(255) DEFAULT NULL,
  `visit_time` time DEFAULT NULL,
  `v_phopto_path` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `request_header_id`, `v_code`, `group_code`, `visitor_name`, `visitor_email`, `visitor_phone`, `purpose`, `visit_date`, `description`, `expected_from`, `expected_to`, `host_user_id`, `reference_id`, `status`, `meeting_status`, `meeting_completed_at`, `validity`, `securityCheckStatus`, `spendTime`, `created_by`, `created_at`, `updated_at`, `proof_id_type`, `proof_id_number`, `qr_code`, `vehicle_no`, `vehicle_type`, `vehicle_id_proof`, `visitor_id_proof`, `visit_time`, `v_phopto_path`) VALUES
(1, 1, 'V000001', 'GV000001', 'Krishna Vasireddy', 'krishna.vasireddy@gmail.com', '9100060606', 'General Visit', '2025-12-30', 'Meeting On Sap', NULL, NULL, 9, NULL, 'approved', 0, NULL, 0, 0, NULL, 9, '2025-12-30 11:10:55', '2025-12-31 15:13:34', 'Aadhar Card', '565468-8878629-987727', 'visitor_V000001_qr.png', 'TS07HS5099', 'Car', '', '', '11:30:00', ''),
(2, 2, 'V000002', 'GV000002', 'Krishna Vasireddy', 'krishna.vasireddy@gmail.com', '9100060606', 'Meeting', '2026-01-01', 'Meeting', NULL, NULL, 9, NULL, 'pending', 0, NULL, 0, 0, NULL, 9, '2026-01-01 15:44:47', '2026-01-03 10:20:40', 'Aadhar Card', '7896542458', '', 'TS09EF7856', 'Car', '', '', '18:43:00', ''),
(3, 3, 'V000003', 'GV000003', 'Krishna Vasireddy', 'krishna.vasireddy@gmail.com', '9100060606', 'Meeting', '2026-01-01', 'Meeting', NULL, NULL, 44, NULL, 'pending', 0, NULL, 0, 0, NULL, 44, '2026-01-01 15:47:57', '2026-01-03 10:20:40', 'Aadhar Card', '12355697567828', '', '', '', '', '', '15:47:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` int(11) NOT NULL,
  `visitor_request_id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `performed_by` int(11) NOT NULL,
  `performed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `visitor_request_id`, `action_type`, `old_status`, `new_status`, `remarks`, `performed_by`, `performed_at`) VALUES
(1, 1, 'Created', NULL, 'pending', '--', 9, '2025-12-30 11:10:55'),
(2, 1, 'approved', 'pending', 'approved', NULL, 11, '2025-12-30 11:11:41'),
(3, 2, 'Created', NULL, 'pending', '--', 9, '2026-01-01 15:44:47'),
(4, 3, 'Created', NULL, 'pending', '--', 44, '2026-01-01 15:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_request_header`
--

CREATE TABLE `visitor_request_header` (
  `id` int(11) NOT NULL,
  `header_code` varchar(50) NOT NULL,
  `requested_by` varchar(100) NOT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `requested_date` date NOT NULL,
  `requested_time` time NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `total_visitors` int(11) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `updated_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_request_header`
--

INSERT INTO `visitor_request_header` (`id`, `header_code`, `requested_by`, `referred_by`, `requested_date`, `requested_time`, `department`, `purpose`, `description`, `email`, `total_visitors`, `status`, `updated_by`, `remarks`, `created_at`, `updated_at`, `company`) VALUES
(1, 'GV000001', '9', 11, '2025-12-30', '11:30:00', 'Finance', 'General Visit', 'Meeting On Sap', 'krishna.vasireddy@gmail.com', 1, 'approved', NULL, NULL, '2025-12-30 11:10:55', '2025-12-30 11:11:41', 'UKMPL'),
(2, 'GV000002', '9', 18, '2026-01-01', '18:43:00', 'Finance', 'Meeting', 'Meeting', 'krishna.vasireddy@gmail.com', 1, 'pending', NULL, '', '2026-01-01 15:44:47', '2026-01-01 15:44:47', 'UKMPL'),
(3, 'GV000003', '44', 43, '2026-01-01', '15:47:00', 'MD Secretariat', 'Meeting', 'Meeting', 'krishna.vasireddy@gmail.com', 1, 'pending', NULL, '', '2026-01-01 15:47:57', '2026-01-01 15:47:57', 'UKMPL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `expired_visitor_passes`
--
ALTER TABLE `expired_visitor_passes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purposes`
--
ALTER TABLE `purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `reference_visitor_requests`
--
ALTER TABLE `reference_visitor_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rvr_code` (`rvr_code`),
  ADD KEY `reference_id` (`reference_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `security_gate_logs`
--
ALTER TABLE `security_gate_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitor_request_id` (`visitor_request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `user_hashkeys`
--
ALTER TABLE `user_hashkeys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_password_vault`
--
ALTER TABLE `user_password_vault`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `v_code` (`v_code`),
  ADD KEY `host_user_id` (`host_user_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `fk_visitors_header` (`request_header_id`);

--
-- Indexes for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_request_id` (`visitor_request_id`);

--
-- Indexes for table `visitor_request_header`
--
ALTER TABLE `visitor_request_header`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `expired_visitor_passes`
--
ALTER TABLE `expired_visitor_passes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purposes`
--
ALTER TABLE `purposes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reference_visitor_requests`
--
ALTER TABLE `reference_visitor_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `security_gate_logs`
--
ALTER TABLE `security_gate_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_hashkeys`
--
ALTER TABLE `user_hashkeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_password_vault`
--
ALTER TABLE `user_password_vault`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visitor_request_header`
--
ALTER TABLE `visitor_request_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `reference_visitor_requests`
--
ALTER TABLE `reference_visitor_requests`
  ADD CONSTRAINT `reference_visitor_requests_ibfk_1` FOREIGN KEY (`reference_id`) REFERENCES `reference` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_hashkeys`
--
ALTER TABLE `user_hashkeys`
  ADD CONSTRAINT `user_hashkeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`host_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `visitors_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
