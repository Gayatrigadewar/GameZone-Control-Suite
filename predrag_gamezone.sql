-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 20, 2023 at 01:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `predrag_gamezone`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(46, 'dessert'),
(47, 'brunch'),
(49, 'ugb '),
(50, 'lunch'),
(52, 'Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `ib_acc_types`
--

CREATE TABLE `ib_acc_types` (
  `acctype_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `rate` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_acc_types`
--

INSERT INTO `ib_acc_types` (`acctype_id`, `name`, `description`, `rate`, `code`) VALUES
(1, '1 month membership', '<p>Savings accounts&nbsp;are typically the first official bank account anybody opens. Children may open an account with a parent to begin a pattern of saving. Teenagers open accounts to stash cash earned&nbsp;from a first job&nbsp;or household chores.</p><p>Savings accounts are an excellent place to park&nbsp;emergency cash. Opening a savings account also marks the beginning of your relationship with a financial institution. For example, when joining a credit union, your &ldquo;share&rdquo; or savings account establishes your membership.</p>', '20', 'ACC-CAT-4EZFO'),
(2, '3 month membership', '<p>Retirement accounts&nbsp;offer&nbsp;tax advantages. In very general terms, you get to&nbsp;avoid paying income tax on interest&nbsp;you earn from a savings account or CD each year. But you may have to pay taxes on those earnings at a later date. Still, keeping your money sheltered from taxes may help you over the long term. Most banks offer IRAs (both&nbsp;Traditional IRAs&nbsp;and&nbsp;Roth IRAs), and they may also provide&nbsp;retirement accounts for small businesses</p>', '10', 'ACC-CAT-1QYDV'),
(3, 'Regular user account', '<p><strong>Recurring deposit account or RD account</strong> is opened by those who want to save certain amount of money regularly for a certain period of time and earn a higher interest rate.&nbsp;In RD&nbsp;account a&nbsp;fixed amount is deposited&nbsp;every month for a specified period and the total amount is repaid with interest at the end of the particular fixed period.&nbsp;</p><p>The period of deposit is minimum six months and maximum ten years.&nbsp;The interest rates vary&nbsp;for different plans based on the amount one saves and the period of time and also on banks. No withdrawals are allowed from the RD account. However, the bank may allow to close the account before the maturity period.</p><p>These accounts can be opened in single or joint names. Banks are also providing the Nomination facility to the RD account holders.&nbsp;</p>', '15', 'ACC-CAT-VBQLE');

-- --------------------------------------------------------

--
-- Table structure for table `ib_admin`
--

CREATE TABLE `ib_admin` (
  `admin_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_admin`
--

INSERT INTO `ib_admin` (`admin_id`, `name`, `email`, `number`, `password`, `profile_pic`) VALUES
(2, 'System Administrator', 'admin@mail.com', 'iBank-ADM-0516', '903b21879b4a60fc9103c3334e4f6f62cf6c3a2d', 'admin-icn.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_bankaccounts`
--

CREATE TABLE `ib_bankaccounts` (
  `account_id` int(20) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_rates` varchar(200) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `acc_amount` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL,
  `client_email` varchar(200) NOT NULL,
  `client_adr` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_bankaccounts`
--

INSERT INTO `ib_bankaccounts` (`account_id`, `acc_name`, `account_number`, `acc_type`, `acc_rates`, `acc_status`, `acc_amount`, `client_id`, `client_name`, `client_national_id`, `client_phone`, `client_number`, `client_email`, `client_adr`, `created_at`) VALUES
(25, 'xyz', '209375618', '1 month membership ', '20', 'Active', '6974', '26', 'xyz', 'ppoo976r', '9955220011', 'iBank-CLIENT-5032', 'xyz@gmail.com', '', '2023-12-20 08:43:14.762908');

-- --------------------------------------------------------

--
-- Table structure for table `ib_clients`
--

CREATE TABLE `ib_clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `national_id` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL,
  `account_type` varchar(100) NOT NULL,
  `account_type_rates` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_clients`
--

INSERT INTO `ib_clients` (`client_id`, `name`, `national_id`, `phone`, `address`, `email`, `password`, `profile_pic`, `client_number`, `account_type`, `account_type_rates`) VALUES
(21, 'gayatrigadewar', '123', '9421008400', 'xyz', 'gayatrigadewar29@gmail.com', '776766528a28a7c46256a424602b5b2ad9812101', '', 'iBank-CLIENT-7429', '', 0),
(23, 'gayatri', '321', '09421008400', 'xyz', 'gayatri.pandurang2021@vitstudent.ac.in', '10470c3b4b1fed12c3baac014be15fac67c6e815', '', 'iBank-CLIENT-0264', '', 0),
(25, 'rohan', '11', '45248152', 'nanded', 'rohandevdhar915@gmail.com', '151a323b57b3b634559676e7b66162caaae4289a', '', 'iBank-CLIENT-5701', '', 0),
(26, 'xyz', 'ppoo976r', '9955220011', 'pqr', 'xyz@gmail.com', '18044f86e879e412318557b76565663a9ff0e376', '', 'iBank-CLIENT-5032', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ib_notifications`
--

CREATE TABLE `ib_notifications` (
  `notification_id` int(20) NOT NULL,
  `notification_details` text NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_notifications`
--

INSERT INTO `ib_notifications` (`notification_id`, `notification_details`, `created_at`) VALUES
(20, 'Amanda Stiefel Has Deposited $ 2658 To Bank Account 287359614', '2023-02-16 16:17:22.592127'),
(21, 'Liam Moore Has Deposited $ 5650 To Bank Account 719360482', '2023-02-16 16:29:14.930350'),
(22, 'Liam Moore Has Withdrawn $ 777 From Bank Account 719360482', '2023-02-16 16:29:38.233567'),
(23, 'Liam Moore Has Transfered $ 1256 From Bank Account 719360482 To Bank Account 287359614', '2023-02-16 16:30:15.575946'),
(24, 'John Doe Has Deposited $ 8550 To Bank Account 724310586', '2023-02-16 16:40:49.513943'),
(25, 'Liam Moore Has Deposited $ 600 To Bank Account 719360482', '2023-02-16 16:40:57.385035'),
(26, 'Liam Moore Has Withdrawn $ 120 From Bank Account 719360482', '2023-02-16 16:41:14.885825'),
(27, 'John Doe Has Transfered $ 100 From Bank Account 724310586 To Bank Account 719360482', '2023-02-16 16:41:38.821974'),
(28, 'Harry Den Has Deposited $ 6800 To Bank Account 357146928', '2023-02-16 16:44:09.250277'),
(29, 'Christine Moore Has Deposited $ 1000 To Bank Account 421873905', '2023-11-20 06:34:24.523234'),
(30, 'John Doe Has Deposited $ 1111 To Bank Account 724310586', '2023-11-22 08:19:36.194864'),
(31, 'John Doe Has Deposited $ 500 To Bank Account 724310586', '2023-11-22 08:20:53.675188'),
(32, 'gayatrigadewar Has Deposited $ 500 To Bank Account 846723915', '2023-11-22 08:41:52.035465'),
(33, 'gayatri Has Deposited $ 3000 To Bank Account 215986374', '2023-11-22 08:44:42.918799'),
(34, 'gayatri Has Withdrawn $ 500 From Bank Account 215986374', '2023-11-22 09:17:11.371578'),
(35, 'gayatri Has Withdrawn $ 500 From Bank Account 215986374', '2023-11-23 06:32:48.729440'),
(36, 'gayatri Has Deposited $ 400 To Bank Account 215986374', '2023-11-28 12:13:55.044780'),
(37, 'gayatri Has Deposited $ 400 To Bank Account 215986374', '2023-11-28 12:15:07.369309'),
(38, 'gayatri Has Deposited $ 400 To Bank Account 215986374', '2023-11-28 12:15:17.548713'),
(39, 'gayatri Has Deposited $ 200 To Bank Account 215986374', '2023-11-28 12:15:47.451494'),
(40, 'gayatri Has Deposited $ 1010 To Bank Account 215986374', '2023-11-29 05:32:56.451672'),
(41, 'gayatri Has Deposited $ 100 To Bank Account 215986374', '2023-11-29 06:31:30.574909'),
(42, 'gayatri Has Deposited $ 5000 To Bank Account 215986374', '2023-11-29 06:45:13.618648'),
(43, 'gayatri Has Deposited $ 100 To Bank Account 215986374', '2023-11-29 06:46:48.024115'),
(44, 'gayatri Has Deposited $ 50000 To Bank Account 215986374', '2023-11-29 06:49:50.916567'),
(45, 'gayatri Has Withdrawn $ 1 From Bank Account 215986374', '2023-11-29 06:57:24.353715'),
(46, 'gayatri Has Deposited $ 3000 To Bank Account 215986374', '2023-12-01 07:20:45.804163'),
(47, 'gayatri Has Deposited $ 500 To Bank Account 215986374', '2023-12-01 09:15:15.081824'),
(48, 'gayatri Has Deposited $ 700 To Bank Account 215986374', '2023-12-01 10:07:13.548348'),
(49, 'gayatri Has Deposited $ 1000 To Bank Account 215986374', '2023-12-01 11:04:01.367365'),
(50, 'gayatri Has Deposited $ 600 To Bank Account 215986374', '2023-12-01 12:11:24.835062'),
(51, 'gayatrigadewar Has Deposited $ 5000 To Bank Account 846723915', '2023-12-09 06:34:52.645773'),
(52, 'gayatrigadewar Has Deposited $ 500 To Bank Account 846723915', '2023-12-09 06:35:18.260469'),
(53, 'gayatri Has Deposited $ 3333 To Bank Account 215986374', '2023-12-09 06:37:05.560194'),
(54, 'rohan Has Deposited $ 1212 To Bank Account 513782064', '2023-12-09 06:37:42.384237'),
(55, 'rohan Has Deposited $ 33333 To Bank Account 850216973', '2023-12-09 06:39:09.382085'),
(56, 'rohan Has Deposited $ 1 To Bank Account 850216973', '2023-12-09 06:39:46.468808'),
(57, 'xyz Has Deposited $ 8888 To Bank Account 209375618', '2023-12-20 08:03:22.878016');

-- --------------------------------------------------------

--
-- Table structure for table `ib_order`
--

CREATE TABLE `ib_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(55) NOT NULL,
  `item_name` varchar(55) NOT NULL,
  `item_quantity` int(55) NOT NULL,
  `total_price` int(55) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ib_order`
--

INSERT INTO `ib_order` (`id`, `order_id`, `item_name`, `item_quantity`, `total_price`, `order_date`) VALUES
(1, '0', 'burger', 1, 350, '2023-12-20 06:02:50'),
(2, '0', 'tea', 10, 350, '2023-12-20 06:02:50'),
(3, 'ORDER_658283f98d229', 'burger', 1, 350, '2023-12-20 06:04:41'),
(4, 'ORDER_658283f98d229', 'tea', 10, 350, '2023-12-20 06:04:41'),
(5, 'ORDER_658283ff3f57d', 'burger', 1, 370, '2023-12-20 06:04:47'),
(6, 'ORDER_658283ff3f57d', 'tea', 12, 370, '2023-12-20 06:04:47'),
(7, '658284395b03e', 'burger', 1, 370, '2023-12-20 06:05:45'),
(8, '658284395b03e', 'tea', 12, 370, '2023-12-20 06:05:45'),
(9, '6582915587b33', 'burger', 8, 2780, '2023-12-20 07:01:41'),
(10, '6582915587b33', 'misal pav', 4, 2780, '2023-12-20 07:01:41'),
(11, '6582915587b33', 'pj', 1, 2780, '2023-12-20 07:01:41'),
(12, '6582a1eee5f9f', 'misal pav', 2, 240, '2023-12-20 08:12:30'),
(13, '6582a24b89af3', 'misal pav', 2, 540, '2023-12-20 08:14:03'),
(14, '6582a24b89af3', 'pj', 1, 540, '2023-12-20 08:14:03'),
(15, '6582a7a3b5dec', 'bhaji', 1, 437, '2023-12-20 08:36:51'),
(16, '6582a7a3b5dec', 'puri', 1, 437, '2023-12-20 08:36:51'),
(17, '6582a7a3b5dec', 'burger', 1, 437, '2023-12-20 08:36:51'),
(18, '6582a8910e642', 'bhaji', 1, 687, '2023-12-20 08:40:49'),
(19, '6582a8910e642', 'puri', 1, 687, '2023-12-20 08:40:49'),
(20, '6582a8910e642', 'burger', 2, 687, '2023-12-20 08:40:49'),
(21, '6582a922b99bd', 'tea', 1, 10, '2023-12-20 08:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `ib_staff`
--

CREATE TABLE `ib_staff` (
  `staff_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_staff`
--

INSERT INTO `ib_staff` (`staff_id`, `name`, `staff_number`, `phone`, `email`, `password`, `sex`, `profile_pic`) VALUES
(3, 'Staff ', 'iBank-STAFF-6785', '0704975742', 'staff@mail.com', '903b21879b4a60fc9103c3334e4f6f62cf6c3a2d', 'Male', 'user-profile-min.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_systems`
--

CREATE TABLE `ib_systems` (
  `system_name` varchar(11) NOT NULL,
  `price_per_hour` int(11) NOT NULL,
  `price_per_minute` int(11) NOT NULL,
  `room_no` varchar(11) NOT NULL,
  `system_id` varchar(55) NOT NULL,
  `status` varchar(11) NOT NULL,
  `sr_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ib_systems`
--

INSERT INTO `ib_systems` (`system_name`, `price_per_hour`, `price_per_minute`, `room_no`, `system_id`, `status`, `sr_no`) VALUES
('pc1', 60, 1, '1', 'LAPTOP-7PGQTNPI', '0', 148),
('pc2', 80, 1, '2', '', '0', 149),
('pc3', 55, 5, '1', '', '0', 150);

-- --------------------------------------------------------

--
-- Table structure for table `ib_systemsettings`
--

CREATE TABLE `ib_systemsettings` (
  `id` int(20) NOT NULL,
  `sys_name` longtext NOT NULL,
  `sys_tagline` longtext NOT NULL,
  `sys_logo` varchar(200) NOT NULL,
  `currency` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_systemsettings`
--

INSERT INTO `ib_systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`, `currency`) VALUES
(1, 'GameZone', '.', 'gmlogo.png.png', 'INR');

-- --------------------------------------------------------

--
-- Table structure for table `ib_transactions`
--

CREATE TABLE `ib_transactions` (
  `tr_id` int(20) NOT NULL,
  `tr_code` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) DEFAULT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_amount` varchar(200) NOT NULL,
  `tr_type` varchar(200) NOT NULL,
  `tr_status` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) DEFAULT NULL,
  `transaction_amt` varchar(200) NOT NULL,
  `withdraw_amount` varchar(200) NOT NULL,
  `client_phone` varchar(200) DEFAULT NULL,
  `receiving_acc_no` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `receiving_acc_name` varchar(200) DEFAULT NULL,
  `receiving_acc_holder` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_transactions`
--

INSERT INTO `ib_transactions` (`tr_id`, `tr_code`, `account_id`, `acc_name`, `account_number`, `acc_type`, `acc_amount`, `tr_type`, `tr_status`, `client_id`, `client_name`, `client_national_id`, `transaction_amt`, `withdraw_amount`, `client_phone`, `receiving_acc_no`, `created_at`, `receiving_acc_name`, `receiving_acc_holder`) VALUES
(101, 'KjDXFv7GkWRCiVZ3BJ1p', '25', 'xyz', '209375618', '1 month membership ', '', 'Deposit', 'Success ', '26', 'xyz', 'ppoo976r', '8888', '', '9955220011', '', '2023-12-20 08:03:22.876160', NULL, NULL),
(102, '', '', '', NULL, '', '', 'Food debit', '', '26', '', NULL, '687', '', NULL, '', '2023-12-20 08:40:49.065990', NULL, NULL),
(103, '', '', '', NULL, '', '', 'Foodorder debit', '', '26', '', NULL, '10', '', NULL, '', '2023-12-20 08:43:14.766303', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `login_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `logout_time` varchar(255) DEFAULT NULL,
  `system_id` varchar(255) DEFAULT NULL,
  `login_status` int(2) NOT NULL,
  `login_timer` varchar(50) NOT NULL DEFAULT current_timestamp(),
  `login_live_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_activity`
--

INSERT INTO `login_activity` (`login_id`, `client_id`, `login_time`, `logout_time`, `system_id`, `login_status`, `login_timer`, `login_live_status`) VALUES
(149, 21, '2023-12-20 06:09:53', '2023-12-20 13:32:22', 'LAPTOP-7PGQTNPI', 0, '2023-12-20 11:39:53', 0),
(150, 26, '2023-12-20 08:03:01', NULL, 'LAPTOP-7PGQTNPI', 1, '2023-12-20 13:33:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table ` ord`
--

CREATE TABLE ` ord` (
  `id` int(11) NOT NULL,
  `order_id` int(55) NOT NULL,
  `item_name` varchar(55) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `total_price` int(55) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table ` ord`
--

INSERT INTO ` ord` (`id`, `order_id`, `item_name`, `item_quantity`, `total_price`, `order_date`) VALUES
(1, 0, '', 0, 286, '2023-12-19 13:03:05'),
(2, 0, '', 0, 1230, '2023-12-19 13:15:04'),
(3, 0, '', 0, 160, '2023-12-19 13:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `system_id` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `mobile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `img_path` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= unavailable, 2 Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `price`, `img_path`, `status`) VALUES
(46, 50, 'burger', 250, 'burger.jpg', 1),
(47, 47, '', 0, 'burger.jpg', 1),
(48, 47, '', 0, 'Pizza.jpg', 1),
(49, 47, '', 0, 'Pizza.jpg', 1),
(52, 49, 'misal pav', 120, 'aditya-joshi-yKC0gjd0fUQ-unsplash.jpg', 1),
(53, 49, 'pj', 300, 'Pizza.jpg', 1),
(54, 52, 'tea', 10, 'Masala chai.JPG', 1),
(55, 47, 'puri', 88, '', 1),
(56, 47, 'bhaji', 99, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp_transaction`
--

CREATE TABLE `temp_transaction` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `deduction_amount` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_transaction`
--

INSERT INTO `temp_transaction` (`id`, `login_id`, `deduction_amount`, `client_id`) VALUES
(51, 135, '2', 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  ADD PRIMARY KEY (`acctype_id`);

--
-- Indexes for table `ib_admin`
--
ALTER TABLE `ib_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `ib_clients`
--
ALTER TABLE `ib_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `ib_order`
--
ALTER TABLE `ib_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ib_staff`
--
ALTER TABLE `ib_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `ib_systems`
--
ALTER TABLE `ib_systems`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table ` ord`
--
ALTER TABLE ` ord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_transaction`
--
ALTER TABLE `temp_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  MODIFY `acctype_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ib_admin`
--
ALTER TABLE `ib_admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  MODIFY `account_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ib_clients`
--
ALTER TABLE `ib_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  MODIFY `notification_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `ib_order`
--
ALTER TABLE `ib_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ib_staff`
--
ALTER TABLE `ib_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ib_systems`
--
ALTER TABLE `ib_systems`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  MODIFY `tr_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table ` ord`
--
ALTER TABLE ` ord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `temp_transaction`
--
ALTER TABLE `temp_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
