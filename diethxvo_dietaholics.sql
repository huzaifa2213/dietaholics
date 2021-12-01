-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2021 at 04:05 AM
-- Server version: 10.3.31-MariaDB-log-cll-lve
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diethxvo_dietaholics`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `email`, `first_name`, `last_name`, `password`, `phone`, `image`, `status`, `created`, `updated`) VALUES
(1, 'admin%40admin.com', 'Master', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '1234561234', '1635025528_85e0524852050078d6f0.png', 1, '2019-07-14 15:06:58', '2021-10-23 16:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_featured` enum('0','1') NOT NULL DEFAULT '0',
  `slug_url` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `title`, `image`, `is_featured`, `slug_url`, `status`, `created`, `updated`, `deleted`) VALUES
(1, 'restaurant+', '1635027817_bf298b5dc7a9af32b6a4.jpg', '0', NULL, 1, '2021-10-23 17:23:37', '2021-10-23 17:23:37', NULL),
(2, 'Supplement', '1635027862_f8f8350c5c037016e4df.jpg', '0', NULL, 1, '2021-10-23 17:24:22', '2021-10-23 17:24:22', NULL),
(3, 'Machine', '1635027942_74d1a33a6cda6f6ace95.jpg', '0', NULL, 1, '2021-10-23 17:25:42', '2021-10-23 17:25:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `name`, `state_id`, `status`, `created`, `updated`, `deleted`) VALUES
(1, 'Karachi', 2, 1, '2021-10-23 17:20:32', '2021-10-23 17:20:32', NULL),
(2, 'Karachi', 4, 1, '2021-10-23 17:54:20', '2021-10-23 17:54:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`id`, `name`, `status`, `created`, `updated`, `deleted`) VALUES
(1, 'Pakistan', 1, '2021-10-23 17:19:41', '2021-10-23 17:19:41', NULL),
(2, 'kuwait', 9, '2021-10-23 17:37:53', '2021-11-02 10:06:16', '2021-11-02 10:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupons`
--

CREATE TABLE `tbl_coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `discount_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>flat amount, 1=>percentage',
  `discount` float(8,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `resaturant_ids` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_charges`
--

CREATE TABLE `tbl_delivery_charges` (
  `id` int(11) NOT NULL,
  `min_distance` float(8,1) NOT NULL DEFAULT 0.0,
  `max_distance` float(8,1) NOT NULL DEFAULT 0.0,
  `charges` float(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device_token`
--

CREATE TABLE `tbl_device_token` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `device_token` text NOT NULL,
  `is_last_login` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=>last login token, 0=>previous login token',
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_device_token`
--

INSERT INTO `tbl_device_token` (`id`, `user_id`, `device_token`, `is_last_login`, `status`, `created`, `updated`) VALUES
(1, 6, '', 1, 1, '2021-10-25 09:16:12', '2021-11-09 08:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drivers_company`
--

CREATE TABLE `tbl_drivers_company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_mobile_number` varchar(255) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `owner_id_number` varchar(255) NOT NULL,
  `company_email_id` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `license_number` varchar(255) NOT NULL,
  `company_contact_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_drivers_company`
--

INSERT INTO `tbl_drivers_company` (`id`, `company_name`, `owner_name`, `owner_mobile_number`, `restaurant_id`, `identity_number`, `owner_id_number`, `company_email_id`, `status`, `created`, `updated`, `license_number`, `company_contact_number`, `address`) VALUES
(1, 'cadreamers', 'dfasdfasd', '09654394558', 3, '4523452345234', '5345324523453', '58055581b7067e6ea1802270ddff3ed1', 1, '2021-11-26 09:31:18', '2021-11-26 09:31:18', '45345234', '+919717519768', '503 b\r\najay nagar ,ismailpur');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drivers_review`
--

CREATE TABLE `tbl_drivers_review` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `review` decimal(10,1) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver_orders`
--

CREATE TABLE `tbl_driver_orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>Assigned, 1=>accepted, 2=>rejected',
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_driver_orders`
--

INSERT INTO `tbl_driver_orders` (`id`, `order_id`, `driver_id`, `driver_status`, `status`, `created`, `updated`) VALUES
(2, 20, 1, 1, 1, '2021-11-08 13:41:04', '2021-11-08 13:41:40'),
(3, 30, 1, 1, 1, '2021-11-22 12:40:06', '2021-11-22 12:41:25'),
(4, 40, 1, 1, 1, '2021-11-26 12:05:07', '2021-11-26 12:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_earnings`
--

CREATE TABLE `tbl_earnings` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `restaurent_id` int(11) NOT NULL,
  `admin_charge_amount` float(16,2) NOT NULL,
  `owners_amount` float(16,2) NOT NULL,
  `total_amount` float(16,2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `payment_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>pending, 1=>Paid',
  `payment_date` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_earnings`
--

INSERT INTO `tbl_earnings` (`id`, `order_id`, `restaurent_id`, `admin_charge_amount`, `owners_amount`, `total_amount`, `status`, `created`, `payment_status`, `payment_date`, `updated`, `deleted`) VALUES
(18, 18, 3, 2.00, 18.00, 40.00, 1, '2021-11-02 12:04:53', 0, NULL, '2021-11-02 12:04:53', NULL),
(19, 19, 3, 2.00, 18.00, 40.00, 1, '2021-11-02 12:38:59', 0, NULL, '2021-11-02 12:38:59', NULL),
(20, 20, 3, 2.90, 26.10, 49.00, 1, '2021-11-08 11:34:35', 0, NULL, '2021-11-08 11:34:35', NULL),
(21, 21, 3, 2.90, 26.10, 49.00, 1, '2021-11-09 11:31:40', 0, NULL, '2021-11-09 11:31:40', NULL),
(22, 22, 7, 7.00, 63.00, 100.00, 1, '2021-11-09 11:35:04', 0, NULL, '2021-11-09 11:35:04', NULL),
(23, 23, 3, 2.90, 26.10, 49.00, 1, '2021-11-10 11:05:47', 0, NULL, '2021-11-10 11:05:47', NULL),
(24, 24, 3, 2.90, 26.10, 49.00, 1, '2021-11-11 08:49:40', 0, NULL, '2021-11-11 08:49:40', NULL),
(25, 25, 3, 2.90, 26.10, 49.00, 1, '2021-11-13 01:33:14', 0, NULL, '2021-11-13 01:33:14', NULL),
(26, 26, 3, 2.90, 26.10, 49.00, 1, '2021-11-13 01:38:34', 0, NULL, '2021-11-13 01:38:34', NULL),
(27, 27, 3, 2.90, 26.10, 49.00, 1, '2021-11-13 01:39:57', 0, NULL, '2021-11-13 01:39:57', NULL),
(28, 28, 3, 2.90, 26.10, 49.00, 1, '2021-11-13 01:40:31', 0, NULL, '2021-11-13 01:40:31', NULL),
(29, 29, 3, 2.90, 26.10, 49.00, 1, '2021-11-15 09:59:02', 0, NULL, '2021-11-15 09:59:02', NULL),
(30, 30, 3, 2.90, 26.10, 49.00, 1, '2021-11-15 10:10:26', 0, NULL, '2021-11-15 10:10:26', NULL),
(31, 31, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 07:38:39', 0, NULL, '2021-11-25 07:38:39', NULL),
(32, 32, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 08:08:51', 0, NULL, '2021-11-25 08:08:51', NULL),
(33, 33, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 22:39:49', 0, NULL, '2021-11-25 22:39:49', NULL),
(34, 34, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 22:44:31', 0, NULL, '2021-11-25 22:44:31', NULL),
(35, 35, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 22:49:55', 0, NULL, '2021-11-25 22:49:55', NULL),
(36, 36, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 22:51:53', 0, NULL, '2021-11-25 22:51:53', NULL),
(37, 37, 3, 2.90, 26.10, 49.00, 1, '2021-11-25 22:52:12', 0, NULL, '2021-11-25 22:52:12', NULL),
(38, 38, 3, 2.90, 26.10, 49.00, 1, '2021-11-26 07:47:44', 0, NULL, '2021-11-26 07:47:44', NULL),
(39, 39, 3, 2.90, 26.10, 49.00, 1, '2021-11-26 07:48:49', 0, NULL, '2021-11-26 07:48:49', NULL),
(40, 40, 3, 2.90, 26.10, 49.00, 1, '2021-11-26 07:51:16', 0, NULL, '2021-11-26 07:51:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>admin, 1=>order.',
  `type_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `title`, `description`, `status`, `created`, `updated`, `type`, `type_id`, `user_id`) VALUES
(41, 'Order+Placed', '', 1, '2021-11-02 08:51:25', '2021-11-02 08:51:25', 1, 17, 3),
(42, 'Order+Received', '', 1, '2021-11-02 08:51:25', '2021-11-02 08:51:25', 3, 17, 1),
(43, 'Order+Accepted', '', 1, '2021-11-02 08:52:31', '2021-11-02 08:52:31', 1, 17, 3),
(44, 'Order+Assigned', 'Order+%2317+has+been+assigned+to+you.', 1, '2021-11-02 08:53:20', '2021-11-02 08:53:20', 2, 17, 1),
(45, 'Order+picked+up', '', 1, '2021-11-02 08:57:34', '2021-11-02 08:57:34', 1, 17, 17),
(46, 'Order+Delivered', '', 1, '2021-11-02 09:04:02', '2021-11-02 09:04:02', 1, 17, 3),
(47, 'Order+Placed', '', 1, '2021-11-02 12:04:53', '2021-11-02 12:04:53', 1, 18, 4),
(48, 'Order+Received', '', 1, '2021-11-02 12:04:53', '2021-11-02 12:04:53', 3, 18, 3),
(49, 'Order+Placed', '', 1, '2021-11-02 12:38:57', '2021-11-02 12:38:57', 1, 19, 4),
(50, 'Order+Received', '', 1, '2021-11-02 12:38:58', '2021-11-02 12:38:58', 3, 19, 3),
(51, 'Order+Placed', '', 1, '2021-11-08 11:34:35', '2021-11-08 11:34:35', 1, 20, 5),
(52, 'Order+Received', '', 1, '2021-11-08 11:34:35', '2021-11-08 11:34:35', 3, 20, 3),
(53, 'Order+Assigned', 'Order+%2320+has+been+assigned+to+you.', 1, '2021-11-08 13:41:04', '2021-11-08 13:41:04', 2, 20, 1),
(54, 'Order+picked+up', '', 1, '2021-11-08 13:41:45', '2021-11-08 13:41:45', 1, 20, 20),
(55, 'hi+there+', 'hi+there+where+are+you+we+are+waiting+for+you+', 1, '2021-11-09 08:29:47', '2021-11-09 08:29:47', 0, 0, 0),
(56, 'hi', 'hi', 1, '2021-11-09 08:32:13', '2021-11-09 08:32:13', 0, 0, 0),
(57, 'Order+Delivered', '', 1, '2021-11-09 08:33:35', '2021-11-09 08:33:35', 1, 20, 5),
(58, 'Order+Placed', '', 1, '2021-11-09 11:31:40', '2021-11-09 11:31:40', 1, 21, 5),
(59, 'Order+Received', '', 1, '2021-11-09 11:31:40', '2021-11-09 11:31:40', 3, 21, 3),
(60, 'Order+Placed', '', 1, '2021-11-09 11:35:04', '2021-11-09 11:35:04', 1, 22, 1),
(61, 'Order+Placed', '', 1, '2021-11-10 11:05:47', '2021-11-10 11:05:47', 1, 23, 5),
(62, 'Order+Received', '', 1, '2021-11-10 11:05:47', '2021-11-10 11:05:47', 3, 23, 3),
(63, 'Order+Placed', '', 1, '2021-11-11 08:49:39', '2021-11-11 08:49:39', 1, 24, 5),
(64, 'Order+Received', '', 1, '2021-11-11 08:49:39', '2021-11-11 08:49:39', 3, 24, 3),
(65, 'Order+Placed', '', 1, '2021-11-13 01:33:14', '2021-11-13 01:33:14', 1, 25, 5),
(66, 'Order+Received', '', 1, '2021-11-13 01:33:14', '2021-11-13 01:33:14', 3, 25, 3),
(67, 'Order+Placed', '', 1, '2021-11-13 01:38:34', '2021-11-13 01:38:34', 1, 26, 5),
(68, 'Order+Received', '', 1, '2021-11-13 01:38:34', '2021-11-13 01:38:34', 3, 26, 3),
(69, 'Order+Placed', '', 1, '2021-11-13 01:39:56', '2021-11-13 01:39:56', 1, 27, 5),
(70, 'Order+Received', '', 1, '2021-11-13 01:39:56', '2021-11-13 01:39:56', 3, 27, 3),
(71, 'Order+Placed', '', 1, '2021-11-13 01:40:31', '2021-11-13 01:40:31', 1, 28, 5),
(72, 'Order+Received', '', 1, '2021-11-13 01:40:31', '2021-11-13 01:40:31', 3, 28, 3),
(73, 'Order+Placed', '', 1, '2021-11-15 09:59:02', '2021-11-15 09:59:02', 1, 29, 5),
(74, 'Order+Received', '', 1, '2021-11-15 09:59:02', '2021-11-15 09:59:02', 3, 29, 3),
(75, 'Order+Placed', '', 1, '2021-11-15 10:10:26', '2021-11-15 10:10:26', 1, 30, 5),
(76, 'Order+Received', '', 1, '2021-11-15 10:10:26', '2021-11-15 10:10:26', 3, 30, 3),
(77, 'Order+Assigned', 'Order+%2330+has+been+assigned+to+you.', 1, '2021-11-22 12:40:06', '2021-11-22 12:40:06', 2, 30, 1),
(78, 'Order+picked+up', '', 1, '2021-11-22 12:45:06', '2021-11-22 12:45:06', 1, 30, 30),
(79, 'Order+Placed', '', 1, '2021-11-25 07:38:39', '2021-11-25 07:38:39', 1, 31, 5),
(80, 'Order+Received', '', 1, '2021-11-25 07:38:39', '2021-11-25 07:38:39', 3, 31, 3),
(81, 'Order+Placed', '', 1, '2021-11-25 08:08:50', '2021-11-25 08:08:50', 1, 32, 5),
(82, 'Order+Received', '', 1, '2021-11-25 08:08:51', '2021-11-25 08:08:51', 3, 32, 3),
(83, 'Order+Placed', '', 1, '2021-11-25 22:39:49', '2021-11-25 22:39:49', 1, 33, 5),
(84, 'Order+Received', '', 1, '2021-11-25 22:39:49', '2021-11-25 22:39:49', 3, 33, 3),
(85, 'Order+Placed', '', 1, '2021-11-25 22:44:30', '2021-11-25 22:44:30', 1, 34, 5),
(86, 'Order+Received', '', 1, '2021-11-25 22:44:30', '2021-11-25 22:44:30', 3, 34, 3),
(87, 'Order+Placed', '', 1, '2021-11-25 22:49:55', '2021-11-25 22:49:55', 1, 35, 5),
(88, 'Order+Received', '', 1, '2021-11-25 22:49:55', '2021-11-25 22:49:55', 3, 35, 3),
(89, 'Order+Placed', '', 1, '2021-11-25 22:51:53', '2021-11-25 22:51:53', 1, 36, 5),
(90, 'Order+Received', '', 1, '2021-11-25 22:51:53', '2021-11-25 22:51:53', 3, 36, 3),
(91, 'Order+Placed', '', 1, '2021-11-25 22:52:12', '2021-11-25 22:52:12', 1, 37, 5),
(92, 'Order+Received', '', 1, '2021-11-25 22:52:12', '2021-11-25 22:52:12', 3, 37, 3),
(93, 'Order+Placed', '', 1, '2021-11-26 07:47:43', '2021-11-26 07:47:43', 1, 38, 5),
(94, 'Order+Received', '', 1, '2021-11-26 07:47:44', '2021-11-26 07:47:44', 3, 38, 3),
(95, 'Order+Placed', '', 1, '2021-11-26 07:48:49', '2021-11-26 07:48:49', 1, 39, 5),
(96, 'Order+Received', '', 1, '2021-11-26 07:48:49', '2021-11-26 07:48:49', 3, 39, 3),
(97, 'Order+Placed', '', 1, '2021-11-26 07:51:16', '2021-11-26 07:51:16', 1, 40, 5),
(98, 'Order+Received', '', 1, '2021-11-26 07:51:16', '2021-11-26 07:51:16', 3, 40, 3),
(99, 'Order+Delivered', '', 1, '2021-11-26 09:11:53', '2021-11-26 09:11:53', 1, 30, 5),
(100, 'Order+Assigned', 'Order+%2340+has+been+assigned+to+you.', 1, '2021-11-26 12:05:07', '2021-11-26 12:05:07', 2, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurent_id` int(11) NOT NULL,
  `total_price` float(16,2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `tip_price` float(16,2) NOT NULL,
  `discount_price` float(16,2) NOT NULL,
  `wallet_price` float(16,2) NOT NULL DEFAULT 0.00,
  `grand_total` float(16,2) NOT NULL DEFAULT 0.00,
  `payment_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=> COD, 2=>Stripe, 3=>Paypal,6=>cbk',
  `payment_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>pending, 1=>success, 2=>failed',
  `order_status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=>received, 2=>accepted, 3=>declined, 4=>on way, 5=>delivered',
  `signature` varchar(255) DEFAULT NULL,
  `isReviewed` tinyint(2) NOT NULL DEFAULT 0,
  `refund_amount` float(8,2) NOT NULL DEFAULT 0.00,
  `promo_code` varchar(30) NOT NULL,
  `admin_charge` float(8,2) NOT NULL DEFAULT 20.00,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `coutry` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `delivery_charges` float(8,2) NOT NULL DEFAULT 0.00,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `address_id`, `user_id`, `restaurent_id`, `total_price`, `status`, `created`, `updated`, `tip_price`, `discount_price`, `wallet_price`, `grand_total`, `payment_type`, `payment_status`, `order_status`, `signature`, `isReviewed`, `refund_amount`, `promo_code`, `admin_charge`, `address`, `city`, `state`, `coutry`, `pincode`, `latitude`, `longitude`, `name`, `email`, `phone`, `transaction_id`, `delivery_charges`, `deleted`) VALUES
(17, 2, 3, 2, 5.00, 9, '2021-11-02 08:51:25', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 5.00, 1, 1, 5, '6181455205e10.png', 1, 0.00, '', 0.00, 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan+Plot+R+683', 'Karachi', 'Sindh', NULL, '748600', '24.9669424', '67.05554189999998', 'Muhammad+Huzaifa', '', '03452796163', '', 0.00, '2021-11-02 10:06:52'),
(18, 3, 4, 3, 40.00, 1, '2021-11-02 12:04:53', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 40.00, 1, 1, 1, NULL, 0, 0.00, '', 0.00, 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan+Plot+R+683', 'Karachi', 'Sindh', NULL, '748600', '24.9670245', '67.05552210000002', 'Muhammad+Huzaifa', '', '03452796162', '', 0.00, NULL),
(19, 3, 4, 3, 40.00, 1, '2021-11-02 12:38:57', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 40.00, 1, 1, 1, NULL, 0, 0.00, '', 0.00, 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan+Plot+R+683', 'Karachi', 'Sindh', NULL, '748600', '24.9670245', '67.05552210000002', 'Muhammad+Huzaifa', '', '03452796162', '', 0.00, NULL),
(20, 4, 5, 3, 49.00, 1, '2021-11-08 11:34:35', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 3, 1, 5, '618a86bf0efe0.png', 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(21, 4, 5, 3, 49.00, 1, '2021-11-09 11:31:40', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 1, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(22, 1, 1, 7, 100.00, 1, '2021-11-09 11:35:04', '2021-11-26 07:52:03', 10.00, 0.00, 0.00, 100.00, 1, 1, 1, NULL, 0, 0.00, '', 2.00, 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan+Plot+R+683', 'Karachi', 'Sindh', NULL, '74600', '24.9669508', '67.05553500000002', 'muhammad+Huzaifa', '', '3452796162', '', 0.00, NULL),
(23, 4, 5, 3, 49.00, 1, '2021-11-10 11:05:47', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(24, 4, 5, 3, 49.00, 1, '2021-11-11 08:49:39', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(25, 4, 5, 3, 49.00, 1, '2021-11-13 01:33:14', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(26, 4, 5, 3, 49.00, 1, '2021-11-13 01:38:34', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(27, 4, 5, 3, 49.00, 1, '2021-11-13 01:39:56', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(28, 4, 5, 3, 49.00, 1, '2021-11-13 01:40:31', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(29, 4, 5, 3, 49.00, 1, '2021-11-15 09:59:02', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(30, 4, 5, 3, 49.00, 1, '2021-11-15 10:10:26', '2021-11-26 09:11:53', 0.00, 0.00, 0.00, 49.00, 6, 1, 5, '61a0f9390cde3.png', 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(31, 4, 5, 3, 49.00, 1, '2021-11-25 07:38:39', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(32, 4, 5, 3, 49.00, 1, '2021-11-25 08:08:50', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(33, 4, 5, 3, 49.00, 1, '2021-11-25 22:39:49', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(34, 4, 5, 3, 49.00, 1, '2021-11-25 22:44:30', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(35, 4, 5, 3, 49.00, 1, '2021-11-25 22:49:55', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(36, 4, 5, 3, 49.00, 1, '2021-11-25 22:51:53', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(37, 4, 5, 3, 49.00, 1, '2021-11-25 22:52:12', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(38, 4, 5, 3, 49.00, 1, '2021-11-26 07:47:43', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(39, 4, 5, 3, 49.00, 1, '2021-11-26 07:48:49', '2021-11-26 07:52:03', 0.00, 0.00, 0.00, 49.00, 6, 1, 1, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL),
(40, 4, 5, 3, 49.00, 1, '2021-11-26 07:51:16', '2021-11-26 09:53:15', 0.00, 0.00, 0.00, 49.00, 6, 1, 4, NULL, 0, 0.00, '', 9.00, 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan+Unnamed+Road', 'Chota+Sahiwal', 'Punjab', NULL, '786', '31.9760743', '72.33418269999999', 'Flutter+Developer+', '', '03097047641 ', '', 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` float(16,2) NOT NULL,
  `extra_note` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`id`, `order_id`, `product_id`, `product_price`, `extra_note`, `status`, `created`, `updated`, `product_quantity`) VALUES
(17, 17, 1, 10.00, '', 1, '2021-11-02 08:51:25', '2021-11-02 08:51:25', 1),
(18, 18, 2, 50.00, '', 1, '2021-11-02 12:04:53', '2021-11-02 12:04:53', 1),
(19, 19, 2, 50.00, '', 1, '2021-11-02 12:38:59', '2021-11-02 12:38:59', 1),
(20, 20, 2, 50.00, '', 1, '2021-11-08 11:34:35', '2021-11-08 11:34:35', 1),
(21, 21, 2, 50.00, '', 1, '2021-11-09 11:31:40', '2021-11-09 11:31:40', 1),
(22, 22, 1, 50.00, 'test', 1, '2021-11-09 11:35:04', '2021-11-09 11:35:04', 1),
(23, 22, 2, 40.00, 'test', 1, '2021-11-09 11:35:04', '2021-11-09 11:35:04', 1),
(24, 23, 2, 50.00, '', 1, '2021-11-10 11:05:47', '2021-11-10 11:05:47', 1),
(25, 24, 2, 50.00, '', 1, '2021-11-11 08:49:40', '2021-11-11 08:49:40', 1),
(26, 25, 2, 50.00, '', 1, '2021-11-13 01:33:14', '2021-11-13 01:33:14', 1),
(27, 26, 2, 50.00, '', 1, '2021-11-13 01:38:34', '2021-11-13 01:38:34', 1),
(28, 27, 2, 50.00, '', 1, '2021-11-13 01:39:57', '2021-11-13 01:39:57', 1),
(29, 28, 2, 50.00, '', 1, '2021-11-13 01:40:31', '2021-11-13 01:40:31', 1),
(30, 29, 2, 50.00, '', 1, '2021-11-15 09:59:02', '2021-11-15 09:59:02', 1),
(31, 30, 2, 50.00, '', 1, '2021-11-15 10:10:26', '2021-11-15 10:10:26', 1),
(32, 31, 2, 50.00, '', 1, '2021-11-25 07:38:39', '2021-11-25 07:38:39', 1),
(33, 32, 2, 50.00, '', 1, '2021-11-25 08:08:51', '2021-11-25 08:08:51', 1),
(34, 33, 2, 50.00, '', 1, '2021-11-25 22:39:49', '2021-11-25 22:39:49', 1),
(35, 34, 2, 50.00, '', 1, '2021-11-25 22:44:31', '2021-11-25 22:44:31', 1),
(36, 35, 2, 50.00, '', 1, '2021-11-25 22:49:55', '2021-11-25 22:49:55', 1),
(37, 36, 2, 50.00, '', 1, '2021-11-25 22:51:53', '2021-11-25 22:51:53', 1),
(38, 37, 2, 50.00, '', 1, '2021-11-25 22:52:12', '2021-11-25 22:52:12', 1),
(39, 38, 2, 50.00, '', 1, '2021-11-26 07:47:44', '2021-11-26 07:47:44', 1),
(40, 39, 2, 50.00, '', 1, '2021-11-26 07:48:49', '2021-11-26 07:48:49', 1),
(41, 40, 2, 50.00, '', 1, '2021-11-26 07:51:16', '2021-11-26 07:51:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_owner`
--

CREATE TABLE `tbl_owner` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `device_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_owner`
--

INSERT INTO `tbl_owner` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `image`, `reset_password_token`, `status`, `created`, `updated`, `city_id`, `state_id`, `country_id`, `pincode`, `address`, `device_token`) VALUES
(3, 'Demo', 'Resturant', '+96550159587', 'demo%40vendor.com', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, 1, '2021-11-02 10:37:38', '2021-11-27 12:52:10', 2, 4, 1, '74600', 'Flat%3AAA-310%2C+Maria+Hill+View%2C+Shadman+Town%2C+North+Nazimabad%0D%0AKarachi%2C+Sindh+74600%0D%0APakistan', 'dawB8UTERre46ME9RMkGs_:APA91bHogIkrWWm7ZnfmPodlCwimVZhZy_3PQXWZOt11huhHsopk7uFKedarA9qjk9PsZ0ajvZmRYTds0bgBGomvb6E_pTP01DCh-ZO7WnwWouh8lXGRrAeYD1-bGXh-Liy6VY_9TXiu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `title`, `description`, `status`, `created`, `updated`) VALUES
(1, 'About+Us', '%3Ch2%3EAbout+GROCERS%3C%2Fh2%3E%0D%0A%0D%0A%3Cp%3ECustomers+Deserve+Better%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cimg+alt%3D%22%22+src%3D%22http%3A%2F%2Flocalhost%2Fgrocery%2Fimages%2Fline.svg%22+%2F%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Vestibulum+ac+sodales+sapien.+Sed+pellentesque%2C+quam+in+ornare+tincidunt%2C+magna+augue+placerat+nunc%2C+ut+facilisis+nibh+ipsum+non+ipsum.+Cras+ac+eros+non+neque+viverra+consequat+sed+at+est.+Fusce+efficitur%2C+lacus+nec+dignissim+tincidunt%2C+diam+sapien+rhoncus+neque%2C+at+tristique+sapien+nibh+sed+neque.+Proin+in+neque+in+purus+luctus+facilisis.+Donec+viverra+ligula+quis+lorem+viverra+consequat.+Aliquam+condimentum+id+enim+volutpat+rutrum.+Donec+semper+iaculis+convallis.+Praesent+quis+elit+eget+ligula+facilisis+mattis.+Praesent+sed+euismod+dui.+Suspendisse+imperdiet+vel+quam+nec+venenatis.+Suspendisse+dictum+blandit+quam%2C+vitae+auctor+enim+gravida+et.+Sed+id+dictum+nibh.+Proin+egestas+massa+sit+amet+tincidunt+aliquet.%3C%2Fp%3E%0D%0A', 1, NULL, '2021-09-21 06:38:09'),
(2, 'Privacy+Policy', '%3Ch2%3EGROCERS+Privacy+Policy%3C%2Fh2%3E%0D%0A%0D%0A%3Cp%3EThese+Privacy+Policy+%28%26quot%3BPrivacy%26quot%3B%29+were+last+updated+on+May+16%2C+2020.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EPersonal+Information%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EWhat+information+is%2C+or+may+be%2C+collected+form+you%3F%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EHow+do+we+Collect+the+Information+%3F%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EHow+is+information+used+%3F%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EWith+whom+your+information+will+be+shared%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EWhat+Choice+are+available+to+you+regarding+collection%2C+use+and+distribution+of+your+information+%3F%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EHow+can+you+correct+inaccuracies+in+the+information%3F%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EPolicy+updates%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EContact+Information%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EInnovative+Retail+Concepts+Pvt+Ltd%2C%3Cbr+%2F%3E%0D%0A1st+Floor%2C+Sua+Road%2C+Ludhiana%2C%3Cbr+%2F%3E%0D%0ANear+Pakhowal+Road%2C+Punjab-141001+INDIA%3Cbr+%2F%3E%0D%0ATel.%3A+%2B91+8437176189%3Cbr+%2F%3E%0D%0AEmail+id%3A+customerservice%40grocerssupermarket.com%3C%2Fp%3E%0D%0A', 1, NULL, '2021-04-22 23:30:31'),
(3, 'Terms+conditions', '%3Ch2%3EGROCERS+Term+and+Conditions%3C%2Fh2%3E%0D%0A%0D%0A%3Cp%3EThese+Terms+of+Use+%28%26quot%3BTerms%26quot%3B%29+were+last+updated+on+May+16%2C+2020.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EPersonal+Information%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EServices+overview%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EEligibility%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELicense+%26amp%3B+Site+access%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EWith+whom+your+information+will+be+shared%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EAccount+%26amp%3B+Registration+Obligations%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EPricing%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ECancellation+by+Site+%2F+Customer%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EReturn+%26amp%3B+Refunds%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EYou+Agree+and+Confirm%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EContact+Information%3C%2Fp%3E%0D%0A%0D%0A%3Cul%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3ESed+ut+dui+et+tellus+euismod+accumsan.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3EAenean+sed+neque+vitae+nisi+commodo+ultricies+sed+ut+sapien.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3ESed+euismod+urna+vel+lacus+porta+imperdiet.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3EProin+id+neque+condimentum%2C+eleifend+ipsum+sed%2C+luctus+nisi.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3EUt+eu+sem+eget+dolor+bibendum+tempor.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3ESed+scelerisque+purus+id+nunc+semper%2C+in+elementum+quam+fringilla.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%09%3Cli%3E%0D%0A%09%3Cp%3EDonec+pulvinar+enim+vel+convallis+egestas.%3C%2Fp%3E%0D%0A%09%3C%2Fli%3E%0D%0A%3C%2Ful%3E%0D%0A%0D%0A%3Cp%3EModification+of+Terms+%26amp%3B+Conditions+of+Service%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EGoverning+Law+and+Jurisdiction%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ECopyright+%26amp%3B+Trademark%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EObjectionable+Material%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EIndemnity%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ETermination%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A', 1, NULL, '2021-04-22 23:30:54'),
(4, 'Refund+Policy', '%3Ch2%3EGROCERS+Refund+%26amp%3B+Return+Policy%3C%2Fh2%3E%0D%0A%0D%0A%3Cp%3EThese+Refund+%26amp%3B+Return+Policy+%28%26quot%3BRefund+-+Return%26quot%3B%29+were+last+updated+on+May+18%2C+2020.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EReturn+Policy%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ELorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Cras+rutrum+turpis+vitae+facilisis+tempus.+Donec+in+blandit+risus%2C+eget+pretium+mauris.+Aliquam+nec+venenatis+massa.+Ut+vel+nulla+id+velit+dictum+rutrum+nec+vel+ex.+Phasellus+sit+amet+faucibus+massa%2C+in+feugiat+augue.+Maecenas+eget+dapibus+turpis%2C+a+finibus+justo.+Suspendisse+pretium+lorem+non+lorem+faucibus%2C+non+sagittis+nisi+finibus.+Sed+efficitur+massa+ac+nibh+condimentum+interdum.+Orci+varius+natoque+penatibus+et+magnis+dis+parturient+montes%2C+nascetur+ridiculus+mus.+Suspendisse+luctus%2C+ex+ut+congue+interdum%2C+nibh+turpis+malesuada+orci%2C+vel+vulputate+arcu+velit+condimentum+orci.+Ut+sed+dictum+lacus.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ERefund+Policy%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EDonec+maximus+lorem+vitae+risus+molestie+sollicitudin.+Ut+sem+lorem%2C+consequat+et+tortor+sit+amet%2C+viverra+porttitor+erat.+Suspendisse+aliquet+arcu+vel+auctor+maximus.+Nunc+in+euismod+purus.+Aliquam+non+varius+quam.+Sed+eros+magna%2C+tempus+ullamcorper+auctor+vitae%2C+pretium+eu+elit.+Integer+sagittis+eu+purus+eget+venenatis.+Ut+rhoncus+tempor+velit+vitae+consequat.+Quisque+consequat%2C+enim+eu+cursus+eleifend%2C+velit+mi+viverra+arcu%2C+sed+elementum+dolor+odio+eget+neque.%3C%2Fp%3E%0D%0A', 1, NULL, '2021-04-22 23:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurants`
--

CREATE TABLE `tbl_restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `is_available` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=>Available, 0=>Unavailable',
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `banner_image` varchar(255) NOT NULL,
  `profile_image` text NOT NULL,
  `discount` float(16,2) NOT NULL DEFAULT 0.00,
  `discount_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0==>flat value, 1=>percentage',
  `average_price` float(16,2) NOT NULL DEFAULT 0.00,
  `slug_url` varchar(255) DEFAULT NULL,
  `is_featured` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_restaurants`
--

INSERT INTO `tbl_restaurants` (`id`, `name`, `phone`, `email`, `address`, `pincode`, `country_id`, `state_id`, `city_id`, `latitude`, `longitude`, `owner_id`, `opening_time`, `closing_time`, `is_available`, `status`, `created`, `updated`, `banner_image`, `profile_image`, `discount`, `discount_type`, `average_price`, `slug_url`, `is_featured`, `deleted`) VALUES
(3, 'Demo+Resturant', '+96550159587', 'demo%40vendor.com', 'Flat%3AAA-310%2C+Maria+Hill+View%2C+Shadman+Town%2C+North+Nazimabad%0D%0AKarachi%2C+Sindh+74600%0D%0APakistan', '74600', 1, 4, 2, '24.9649826', '67.0573624', 3, '21:00:00', '09:00:00', 1, 1, '2021-11-02 10:39:32', '2021-11-02 10:39:32', '', '', 0.00, 0, 0.00, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurants_review`
--

CREATE TABLE `tbl_restaurants_review` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `review` decimal(10,1) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `website_name` varchar(255) NOT NULL,
  `website_logo` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `map_api_key` varchar(255) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_from_email` varchar(255) NOT NULL,
  `smtp_from_name` varchar(255) NOT NULL,
  `fcm_key` varchar(255) NOT NULL,
  `stripe_private_key` varchar(255) NOT NULL,
  `stripe_publish_key` varchar(255) NOT NULL,
  `braintree_environment` varchar(255) NOT NULL,
  `braintree_merchant_id` varchar(255) NOT NULL,
  `braintree_public_key` varchar(255) NOT NULL,
  `braintree_private_key` varchar(255) NOT NULL,
  `charge_from_owner` float(18,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `cancellation_charge` float(5,2) NOT NULL DEFAULT 10.00,
  `razorpay_key` varchar(255) NOT NULL,
  `razorpay_secret` varchar(255) NOT NULL,
  `payment_methods` varchar(255) NOT NULL,
  `service_charge` float(8,2) NOT NULL DEFAULT 0.00,
  `delivery_radius` int(11) NOT NULL DEFAULT 5,
  `facebook_app_id` varchar(255) DEFAULT NULL,
  `facebook_app_secret` varchar(255) DEFAULT NULL,
  `facebook_graph_version` varchar(20) NOT NULL DEFAULT 'v9.0',
  `google_client_id` varchar(255) DEFAULT NULL,
  `google_client_secret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `website_name`, `website_logo`, `phone`, `email`, `map_api_key`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_from_email`, `smtp_from_name`, `fcm_key`, `stripe_private_key`, `stripe_publish_key`, `braintree_environment`, `braintree_merchant_id`, `braintree_public_key`, `braintree_private_key`, `charge_from_owner`, `status`, `created`, `updated`, `currency`, `cancellation_charge`, `razorpay_key`, `razorpay_secret`, `payment_methods`, `service_charge`, `delivery_radius`, `facebook_app_id`, `facebook_app_secret`, `facebook_graph_version`, `google_client_id`, `google_client_secret`) VALUES
(1, 'Dietaholics', '1635026620_b98aa83faaf48aedc35c.jpeg', '1234567890', 'info%40dietaholics.com', 'AIzaSyCtv-ig64YziJiZE1VY09E0cMgjBwraQkM', 'dietaholics.com', 465, 'info%40dietaholics.com', 'Dietaholics.22', 'info%40dietaholics.com', 'Dietaholics', 'AAAAp6FZgVI:APA91bFjrAGZcKmU3qRM4NpwUehBAQJuD3Q7-ka53kIA0G8zXdQnoEkYNR4ppHpFIHO2GAEjZnNVoWazB9b8VAepLiVI7wQHGP_7xR_KvkQBkUjZk38Y9IiUV4IduY9FiViLcywPQV59', '', '', 'sandbox', 'wkq3z3kyk9x4j648', 'z8gtpycgrwh9jw8z', '179a1c6e2c9cf3849e0305fff6fd2d39', 10.00, 1, '0000-00-00 00:00:00', '2021-11-02 07:17:19', 'USD', 9.99, '', '', '', 10.00, 1000, '', '', 'v9.0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `name`, `country_id`, `status`, `created`, `updated`, `deleted`) VALUES
(1, 'Sindh', 1, 9, '2021-10-23 17:19:55', '2021-10-23 17:20:10', '2021-10-23 17:20:10'),
(3, 'farwiny', 2, 9, '2021-10-23 17:38:20', '2021-10-23 17:41:41', '2021-10-23 17:41:41'),
(4, 'Pakistan', 1, 1, '2021-10-23 17:53:51', '2021-10-24 17:26:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategories`
--

CREATE TABLE `tbl_subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=>veg, 2=>non-veg',
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `discount_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>flat amount, 1=>percentage',
  `discount` float(16,2) NOT NULL,
  `price` float(16,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subcategories`
--

INSERT INTO `tbl_subcategories` (`id`, `category_id`, `restaurant_id`, `title`, `type`, `description`, `image`, `discount_type`, `discount`, `price`, `status`, `created`, `updated`, `deleted`) VALUES
(1, 1, 2, 'Demo', 1, 'Demo', '1635169107_28b366a75c26b4b35cc5.jpg', 1, 5.00, 10.00, 1, '2021-10-25 08:38:27', '2021-10-25 08:38:27', NULL),
(2, 1, 3, 'Chineese+Food', 1, 'This+is+Fro+Demo+Purpose', '1635867989_5aed130bd7f38d5ea256.jpg', 1, 10.00, 50.00, 1, '2021-11-02 10:46:29', '2021-11-02 15:02:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) NOT NULL,
  `is_social_login` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>normal login, 1=>facebook, 2=>google',
  `social_id` varchar(255) NOT NULL DEFAULT '',
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0=>inactive, 1=>active, 2=>deleted',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `otp` varchar(255) NOT NULL,
  `user_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=>customer, 2=>driver',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `identity_number` varchar(255) DEFAULT NULL,
  `identity_image` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `license_image` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `is_available` tinyint(2) DEFAULT 0 COMMENT '0=>unavailable, 1)Avainlable',
  `wallet_amount` float(8,2) NOT NULL DEFAULT 0.00,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `is_social_login`, `social_id`, `fullname`, `email`, `password`, `phone`, `token`, `image`, `status`, `created`, `updated`, `last_login_date`, `otp`, `user_type`, `latitude`, `longitude`, `identity_number`, `identity_image`, `license_number`, `license_image`, `gender`, `age`, `date_of_birth`, `city_id`, `state_id`, `country_id`, `pincode`, `address`, `device_token`, `is_available`, `wallet_amount`, `deleted`) VALUES
(1, 0, '', 'Demo+Driver', 'demo%40driver.com', 'e10adc3949ba59abbe56e057f20f883e', '+96550159587', NULL, '', 1, '2021-10-25 08:42:29', '2021-11-27 12:53:24', NULL, '', 2, '24.9669327', '67.0555531', '4200123456', '1635169349_db09e4809ff519aa58b7.jpg', '4200123456', '1635169349_3d6d787d0419ef81beb6.jpg', 'Male', NULL, '1995-10-25', 2, 4, 1, '74600', 'Flat%3AAA-310%2C+Maria+Hill+View%2C+Shadman+Town%2C+North+Nazimabad%0D%0AKarachi%2C+Sindh+74600%0D%0APakistan', 'eDbXKMVAQDw:APA91bFbrZ0tqw4XVpxtvVq5Q87A4LmVjUapOL4HI4xcmyWDKzfYR9zyBmk3-uqelKHV3YIKqiL2aafxHRTcdqc_nvc2U_MHxNKv3W1eeaLzZPIo9Z1PUhJy5eR_K3xzR0eGdECsooO5', 1, 0.00, NULL),
(2, 0, '', 'muhammad+Huzaifa', 'democustomer%40gmail.con', 'e10adc3949ba59abbe56e057f20f883e', '3452796163', '1eghVz', '', 9, '2021-10-25 09:16:12', '2021-10-28 04:54:34', NULL, '', 1, '24.9669714', '67.05551739999999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, '2021-10-28 04:54:34'),
(3, 0, '', 'muhammad+Huzaifa', 'huzaifa.kamran1322%40gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '3452796163', 'FozZ9A', '', 1, '2021-10-28 04:55:12', '2021-11-03 11:33:40', NULL, '', 1, '29.3411107', '48.0736785', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL),
(4, 1, 'Fz9QlPRh1chEj8lSqiLT72h8bNA3', 'huzaifa', 'huzaifa.kamran1322%40gmail.com', '', '123456', 'GLQHEr', '', 1, '2021-10-29 06:28:15', '2021-11-02 12:38:12', NULL, '', 1, '24.9669852', '67.05551789999998', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL),
(5, 0, '', 'Flutter+Developer+', 'hr38202%40gmail.com', '2af9b1ba42dc5eb01743e6b3759b6e4b', '3097047461', '8MwIsP', '', 1, '2021-11-06 23:28:36', '2021-11-06 23:28:36', NULL, '', 1, '31.976073', '72.3341824', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL),
(6, 1, 'awbJNd2NjsS0WPOZXcDi9akhOMq1', 'essa', 'essata3mry%40gmail.com', '', '123456', 'ZdUQBu', '', 1, '2021-11-09 08:31:09', '2021-11-09 08:31:09', NULL, '', 1, '29.3407226', '48.0143286', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_addresses`
--

CREATE TABLE `tbl_user_addresses` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) NOT NULL,
  `pincode` varchar(30) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `isDefault` tinyint(2) NOT NULL DEFAULT 0,
  `address_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=>home, 1=>office, 2=>other'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_addresses`
--

INSERT INTO `tbl_user_addresses` (`id`, `user_id`, `name`, `phone`, `city`, `state`, `country`, `address_line_1`, `address_line_2`, `pincode`, `latitude`, `longitude`, `status`, `created`, `updated`, `isDefault`, `address_type`) VALUES
(1, 2, 'muhammad+Huzaifa', '3452796162', 'Karachi', 'Sindh', 'Pakistan', 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan', 'Plot+R+683', '74600', '24.9669508', '67.05553500000002', 1, '2021-10-25 09:17:47', '2021-10-25 09:17:47', 0, 0),
(2, 3, 'Muhammad+Huzaifa', '03452796163', 'Karachi', 'Sindh', 'Pakistan', 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan', 'Plot+R+683', '748600', '24.9669424', '67.05554189999998', 1, '2021-10-28 04:56:49', '2021-10-28 04:56:49', 0, 0),
(3, 4, 'Muhammad+Huzaifa', '03452796162', 'Karachi', 'Sindh', 'Pakistan', 'Plot+R+683%2C+Sector+10+North+Karachi+Twp%2C+Karachi%2C+Karachi+City%2C+Sindh%2C+Pakistan', 'Plot+R+683', '748600', '24.9670245', '67.05552210000002', 1, '2021-11-01 12:12:08', '2021-11-01 12:12:08', 0, 0),
(4, 5, 'Flutter+Developer+', '03097047641 ', 'Chota+Sahiwal', 'Punjab', 'Pakistan', 'Unnamed+Road%2C+Sahiwal%2C+Sargodha%2C+Punjab%2C+Pakistan', 'Unnamed+Road', '786', '31.9760743', '72.33418269999999', 1, '2021-11-06 23:30:03', '2021-11-06 23:30:03', 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_country`
--
ALTER TABLE `tbl_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupons`
--
ALTER TABLE `tbl_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_delivery_charges`
--
ALTER TABLE `tbl_delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_device_token`
--
ALTER TABLE `tbl_device_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_drivers_company`
--
ALTER TABLE `tbl_drivers_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_drivers_review`
--
ALTER TABLE `tbl_drivers_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_driver_orders`
--
ALTER TABLE `tbl_driver_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_earnings`
--
ALTER TABLE `tbl_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_owner`
--
ALTER TABLE `tbl_owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_restaurants`
--
ALTER TABLE `tbl_restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_restaurants_review`
--
ALTER TABLE `tbl_restaurants_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subcategories`
--
ALTER TABLE `tbl_subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_addresses`
--
ALTER TABLE `tbl_user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coupons`
--
ALTER TABLE `tbl_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery_charges`
--
ALTER TABLE `tbl_delivery_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_device_token`
--
ALTER TABLE `tbl_device_token`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_drivers_company`
--
ALTER TABLE `tbl_drivers_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_drivers_review`
--
ALTER TABLE `tbl_drivers_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_driver_orders`
--
ALTER TABLE `tbl_driver_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_earnings`
--
ALTER TABLE `tbl_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_owner`
--
ALTER TABLE `tbl_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_restaurants`
--
ALTER TABLE `tbl_restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_restaurants_review`
--
ALTER TABLE `tbl_restaurants_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_subcategories`
--
ALTER TABLE `tbl_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_user_addresses`
--
ALTER TABLE `tbl_user_addresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
