-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2021 at 06:46 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodzone_upload`
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
(1, 'admin%40foodzone.com', 'Master', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '1234561234', '1605348961154.php', 1, '2019-07-14 15:06:58', '2020-11-14 15:46:01');

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
  `payment_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=> COD, 2=>Stripe, 3=>Paypal',
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
(1, 'Foodzone', '1615901640725.png', '1234567890', 'Foodzone', '', '', 587, '', '', '', 'Food+Zone', '', '', '', 'sandbox', '', '', '', 10.00, 1, '0000-00-00 00:00:00', '2021-09-19 08:44:48', 'USD', 9.99, '', '', '', 10.00, 1000, '', '', 'v9.0', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_drivers_review`
--
ALTER TABLE `tbl_drivers_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_driver_orders`
--
ALTER TABLE `tbl_driver_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_earnings`
--
ALTER TABLE `tbl_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_owner`
--
ALTER TABLE `tbl_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_restaurants`
--
ALTER TABLE `tbl_restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_restaurants_review`
--
ALTER TABLE `tbl_restaurants_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subcategories`
--
ALTER TABLE `tbl_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_addresses`
--
ALTER TABLE `tbl_user_addresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
