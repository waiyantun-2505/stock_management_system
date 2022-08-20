-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2021 at 10:02 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', '090909090', 'Yangon', '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(2, 'Mandalay', '090909090', 'Mandalay', '2020-12-24 07:02:54', '2020-12-24 07:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Category1', '2020-12-24 07:02:49', '2020-12-24 07:02:49'),
(2, 'Category2', '2020-12-24 07:02:49', '2020-12-24 07:02:49'),
(3, 'Category3', '2020-12-24 07:02:49', '2020-12-24 07:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `region_id`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', 1, '2020-12-24 07:02:49', '2020-12-24 07:02:49'),
(2, 'Mandalay', 1, '2020-12-24 07:02:49', '2020-12-24 07:02:49'),
(3, 'Pyin Oo Lwin', 1, '2020-12-24 07:02:49', '2020-12-24 07:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `creditpayments`
--

CREATE TABLE `creditpayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `creditsale_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creditsaledetails`
--

CREATE TABLE `creditsaledetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creditsale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sale_return` int(11) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creditsales`
--

CREATE TABLE `creditsales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `b_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `saledate` date NOT NULL,
  `credit_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `bonus` int(11) DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `payamount` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `way` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_gate` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_phone` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `city_id`, `phone`, `way`, `marketer_id`, `delivery_gate`, `delivery_phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Pwint Oo', 1, '097878787,0909090909', 'Than Lynn way', 1, 'Aung Myint', '0909090900,38993829', 'somewhere', '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(2, 'Shwe Light', 2, '097878787,0909090909', 'Pyay way', 2, 'Mingalar', '0909090900,38993829', 'somewhere', '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(3, 'Myo Ma', 3, '097878787,0909090909', 'May Myo way', 3, 'Yoma', '0909090900,38993829', 'somewhere', '2020-12-24 07:02:53', '2020-12-24 07:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketers`
--

CREATE TABLE `marketers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketers`
--

INSERT INTO `marketers` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Wai Yan Tun', '2020-12-24 07:02:47', '2020-12-24 07:02:47'),
(2, 'Pai Phyo', '2020-12-24 07:02:47', '2020-12-24 07:02:47'),
(3, 'Shwe Sin', '2020-12-24 07:02:47', '2020-12-24 07:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2018_06_17_154307_create_marketers_table', 1),
(3, '2019_07_01_120749_create_regions_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_04_08_112834_create_categories_table', 1),
(6, '2020_04_08_113407_create_subcategories_table', 1),
(7, '2020_04_08_113740_create_cities_table', 1),
(8, '2020_04_08_115251_create_customers_table', 1),
(9, '2020_04_08_122336_create_products_table', 1),
(10, '2020_04_09_064021_create_branches_table', 1),
(11, '2020_04_09_064022_create_orders_table', 1),
(12, '2020_04_09_064707_create_orderdetails_table', 1),
(13, '2020_04_09_071102_create_stocks_table', 1),
(14, '2020_04_09_071539_create_sales_table', 1),
(15, '2020_04_09_073221_create_saledetails_table', 1),
(16, '2020_04_21_123057_create_transfers_table', 1),
(17, '2020_04_21_130041_create_transferdetails_table', 1),
(18, '2020_05_21_060030_create_wayouts_table', 1),
(19, '2020_05_21_060129_create_wayoutdetails_table', 1),
(20, '2020_05_21_060155_create_wayins_table', 1),
(21, '2020_05_21_060238_create_wayindetails_table', 1),
(22, '2020_05_21_060314_create_waysales_table', 1),
(23, '2020_05_21_060332_create_waysaledetails_table', 1),
(24, '2020_06_15_062647_create_waystockadds_table', 1),
(25, '2020_06_15_062831_create_waystockadddetails_table', 1),
(26, '2020_07_01_121303_create_creditsales_table', 1),
(27, '2020_07_01_121558_create_creditsaledetails_table', 1),
(28, '2020_07_09_171736_create_promotions_table', 1),
(29, '2020_07_10_064453_create_creditpayments_table', 1),
(30, '2020_07_13_205313_create_promotiondetails_table', 1),
(31, '2020_08_09_114204_create_waycreditsales_table', 1),
(32, '2020_08_09_114246_create_waycreditsaledetails_table', 1),
(33, '2020_08_10_144615_create_waycreditpayments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `order_return` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suppliername` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderdate` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_no` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `order_price` double(8,2) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code_no`, `name`, `subcategory_id`, `order_price`, `sale_price`, `created_at`, `updated_at`) VALUES
(1, 'P0001', 'C1S1 product 1', 2, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55'),
(2, 'P0002', 'C1S1 product 2', 2, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55'),
(3, 'P0002', 'C2S2 product 1', 3, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55'),
(4, 'P0003', 'C2S2 product 2', 3, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55'),
(5, 'P0003', 'C3S3 product 1', 4, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55'),
(6, 'P0004', 'C3S3 product 2', 4, 10.01, 16000, '2020-12-24 07:02:55', '2020-12-24 07:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `promotiondetails`
--

CREATE TABLE `promotiondetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotiondetails`
--

INSERT INTO `promotiondetails` (`id`, `voucher_no`, `promotion_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'W-1', 1, 4, 1, '2020-12-24 07:21:20', '2020-12-24 07:21:20'),
(2, 'W-1', 1, 5, 1, '2020-12-24 07:21:20', '2020-12-24 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 'Hello', '2020-12-24', '2020-12-31', '2020-12-24 07:20:06', '2020-12-24 07:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', '2020-12-24 07:02:48', '2020-12-24 07:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `saledetails`
--

CREATE TABLE `saledetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sale_return` int(11) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saledetails`
--

INSERT INTO `saledetails` (`id`, `sale_id`, `product_id`, `sale_return`, `return_date`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 10, 160000, '2021-06-19 23:49:32', '2021-06-19 23:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `b_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `saledate` date NOT NULL,
  `total_amount` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `bonus` int(11) DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `b_short`, `voucher_no`, `customer_id`, `branch_id`, `saledate`, `total_amount`, `discount`, `bonus`, `balance`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Y', 1, 1, 1, '2021-06-20', 160000, 10, 1000, 143000, 'Active', '2021-06-19 23:49:32', '2021-06-19 23:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `quantity`, `product_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 190, 1, 1, '2020-12-24 07:02:56', '2021-06-19 23:49:32'),
(2, 200, 2, 1, '2020-12-24 07:02:56', '2020-12-24 07:20:37'),
(3, 200, 3, 1, '2020-12-24 07:02:56', '2020-12-24 07:20:37'),
(4, 200, 4, 1, '2020-12-24 07:02:57', '2020-12-24 07:20:37'),
(5, 200, 5, 1, '2020-12-24 07:02:57', '2020-12-24 07:20:37'),
(6, 300, 6, 1, '2020-12-24 07:02:57', '2020-12-24 07:02:57'),
(7, 300, 1, 2, '2020-12-24 07:02:57', '2020-12-24 07:02:57'),
(8, 300, 2, 2, '2020-12-24 07:02:57', '2020-12-24 07:02:57'),
(9, 300, 3, 2, '2020-12-24 07:02:57', '2020-12-24 07:02:57'),
(10, 300, 4, 2, '2020-12-24 07:02:58', '2020-12-24 07:02:58'),
(11, 300, 5, 2, '2020-12-24 07:02:58', '2020-12-24 07:02:58'),
(12, 300, 6, 2, '2020-12-24 07:02:59', '2020-12-24 07:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Category1 Subcategory 1', 1, '2020-12-24 07:02:51', '2020-12-24 07:02:51'),
(2, 'Category1 Subcategory 2', 1, '2020-12-24 07:02:51', '2020-12-24 07:02:51'),
(3, 'Category1 Subcategory 3', 1, '2020-12-24 07:02:51', '2020-12-24 07:02:51'),
(4, 'Category2 Subcategory 1', 2, '2020-12-24 07:02:51', '2020-12-24 07:02:51'),
(5, 'Category2 Subcategory 2', 2, '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(6, 'Category2 Subcategory 3', 2, '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(7, 'Category3 Subcategory 1', 3, '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(8, 'Category3 Subcategory 2', 3, '2020-12-24 07:02:53', '2020-12-24 07:02:53'),
(9, 'Category3 Subcategory 3', 3, '2020-12-24 07:02:53', '2020-12-24 07:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `transferdetails`
--

CREATE TABLE `transferdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_date` date NOT NULL,
  `from_branch` bigint(20) UNSIGNED NOT NULL,
  `to_branch` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waycreditpayments`
--

CREATE TABLE `waycreditpayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waycreditsaledetails`
--

CREATE TABLE `waycreditsaledetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waycreditsale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waycreditsaledetails`
--

INSERT INTO `waycreditsaledetails` (`id`, `waycreditsale_id`, `product_id`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 160000, '2020-12-24 07:21:20', '2020-12-24 07:21:20'),
(2, 1, 2, 10, 160000, '2020-12-24 07:21:20', '2020-12-24 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `waycreditsales`
--

CREATE TABLE `waycreditsales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `b_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wayout_id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `waysale_date` date NOT NULL,
  `credit_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `bonus` int(11) DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `payamount` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waycreditsales`
--

INSERT INTO `waycreditsales` (`id`, `b_short`, `wayout_id`, `voucher_no`, `customer_id`, `waysale_date`, `credit_method`, `total_amount`, `discount`, `bonus`, `balance`, `payamount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'W', 1, 1, 1, '2020-12-24', 'credit', 320000, NULL, NULL, 320000, NULL, 'Active', '2020-12-24 07:21:20', '2020-12-24 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `wayindetails`
--

CREATE TABLE `wayindetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wayin_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wayins`
--

CREATE TABLE `wayins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wayout_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `wayin_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wayoutdetails`
--

CREATE TABLE `wayoutdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wayout_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `sale_quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wayoutdetails`
--

INSERT INTO `wayoutdetails` (`id`, `wayout_id`, `product_id`, `quantity`, `sale_quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 90, NULL, '2020-12-24 07:20:37', '2020-12-24 07:21:20'),
(2, 1, 2, 90, NULL, '2020-12-24 07:20:37', '2020-12-24 07:21:20'),
(3, 1, 3, 100, NULL, '2020-12-24 07:20:37', '2020-12-24 07:20:37'),
(4, 1, 4, 99, NULL, '2020-12-24 07:20:37', '2020-12-24 07:21:20'),
(5, 1, 5, 99, NULL, '2020-12-24 07:20:37', '2020-12-24 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `wayouts`
--

CREATE TABLE `wayouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `wayout_date` date NOT NULL,
  `way_cities` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `wayin_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wayouts`
--

INSERT INTO `wayouts` (`id`, `branch_id`, `wayout_date`, `way_cities`, `wayin_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-12-24', 'Way out One', 'Ongoing', 'Active', '2020-12-24 07:20:37', '2020-12-24 07:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `waysaledetails`
--

CREATE TABLE `waysaledetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waysale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waysales`
--

CREATE TABLE `waysales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `b_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `wayout_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `waysale_date` date NOT NULL,
  `total_amount` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `bonus` int(11) DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waystockadddetails`
--

CREATE TABLE `waystockadddetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waystockadd_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waystockadds`
--

CREATE TABLE `waystockadds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wayout_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `wayadd_date` date NOT NULL,
  `send_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_region_id_foreign` (`region_id`);

--
-- Indexes for table `creditpayments`
--
ALTER TABLE `creditpayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creditpayments_creditsale_id_foreign` (`creditsale_id`);

--
-- Indexes for table `creditsaledetails`
--
ALTER TABLE `creditsaledetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creditsaledetails_creditsale_id_foreign` (`creditsale_id`),
  ADD KEY `creditsaledetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `creditsales`
--
ALTER TABLE `creditsales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creditsales_customer_id_foreign` (`customer_id`),
  ADD KEY `creditsales_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_city_id_foreign` (`city_id`),
  ADD KEY `customers_marketer_id_foreign` (`marketer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketers`
--
ALTER TABLE `marketers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderdetails_order_id_foreign` (`order_id`),
  ADD KEY `orderdetails_product_id_foreign` (`product_id`),
  ADD KEY `orderdetails_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `promotiondetails`
--
ALTER TABLE `promotiondetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saledetails`
--
ALTER TABLE `saledetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saledetails_sale_id_foreign` (`sale_id`),
  ADD KEY `saledetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`),
  ADD KEY `stocks_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `transferdetails`
--
ALTER TABLE `transferdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transferdetails_transfer_id_foreign` (`transfer_id`),
  ADD KEY `transferdetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_from_branch_foreign` (`from_branch`),
  ADD KEY `transfers_to_branch_foreign` (`to_branch`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `waycreditpayments`
--
ALTER TABLE `waycreditpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waycreditsaledetails`
--
ALTER TABLE `waycreditsaledetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waycreditsaledetails_waycreditsale_id_foreign` (`waycreditsale_id`),
  ADD KEY `waycreditsaledetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `waycreditsales`
--
ALTER TABLE `waycreditsales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waycreditsales_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `wayindetails`
--
ALTER TABLE `wayindetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wayindetails_wayin_id_foreign` (`wayin_id`),
  ADD KEY `wayindetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `wayins`
--
ALTER TABLE `wayins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wayins_wayout_id_foreign` (`wayout_id`),
  ADD KEY `wayins_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `wayoutdetails`
--
ALTER TABLE `wayoutdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wayoutdetails_wayout_id_foreign` (`wayout_id`),
  ADD KEY `wayoutdetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `wayouts`
--
ALTER TABLE `wayouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wayouts_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `waysaledetails`
--
ALTER TABLE `waysaledetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waysaledetails_waysale_id_foreign` (`waysale_id`),
  ADD KEY `waysaledetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `waysales`
--
ALTER TABLE `waysales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waysales_customer_id_foreign` (`customer_id`),
  ADD KEY `waysales_wayout_id_foreign` (`wayout_id`);

--
-- Indexes for table `waystockadddetails`
--
ALTER TABLE `waystockadddetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waystockadddetails_waystockadd_id_foreign` (`waystockadd_id`),
  ADD KEY `waystockadddetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `waystockadds`
--
ALTER TABLE `waystockadds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waystockadds_wayout_id_foreign` (`wayout_id`),
  ADD KEY `waystockadds_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `creditpayments`
--
ALTER TABLE `creditpayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creditsaledetails`
--
ALTER TABLE `creditsaledetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creditsales`
--
ALTER TABLE `creditsales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketers`
--
ALTER TABLE `marketers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `promotiondetails`
--
ALTER TABLE `promotiondetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `saledetails`
--
ALTER TABLE `saledetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transferdetails`
--
ALTER TABLE `transferdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waycreditpayments`
--
ALTER TABLE `waycreditpayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waycreditsaledetails`
--
ALTER TABLE `waycreditsaledetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `waycreditsales`
--
ALTER TABLE `waycreditsales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wayindetails`
--
ALTER TABLE `wayindetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wayins`
--
ALTER TABLE `wayins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wayoutdetails`
--
ALTER TABLE `wayoutdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wayouts`
--
ALTER TABLE `wayouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `waysaledetails`
--
ALTER TABLE `waysaledetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waysales`
--
ALTER TABLE `waysales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waystockadddetails`
--
ALTER TABLE `waystockadddetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waystockadds`
--
ALTER TABLE `waystockadds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `creditpayments`
--
ALTER TABLE `creditpayments`
  ADD CONSTRAINT `creditpayments_creditsale_id_foreign` FOREIGN KEY (`creditsale_id`) REFERENCES `creditsales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `creditsaledetails`
--
ALTER TABLE `creditsaledetails`
  ADD CONSTRAINT `creditsaledetails_creditsale_id_foreign` FOREIGN KEY (`creditsale_id`) REFERENCES `creditsales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `creditsaledetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `creditsales`
--
ALTER TABLE `creditsales`
  ADD CONSTRAINT `creditsales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `creditsales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_marketer_id_foreign` FOREIGN KEY (`marketer_id`) REFERENCES `marketers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saledetails`
--
ALTER TABLE `saledetails`
  ADD CONSTRAINT `saledetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saledetails_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transferdetails`
--
ALTER TABLE `transferdetails`
  ADD CONSTRAINT `transferdetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transferdetails_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_from_branch_foreign` FOREIGN KEY (`from_branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_to_branch_foreign` FOREIGN KEY (`to_branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waycreditsaledetails`
--
ALTER TABLE `waycreditsaledetails`
  ADD CONSTRAINT `waycreditsaledetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waycreditsaledetails_waycreditsale_id_foreign` FOREIGN KEY (`waycreditsale_id`) REFERENCES `waycreditsales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waycreditsales`
--
ALTER TABLE `waycreditsales`
  ADD CONSTRAINT `waycreditsales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wayindetails`
--
ALTER TABLE `wayindetails`
  ADD CONSTRAINT `wayindetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wayindetails_wayin_id_foreign` FOREIGN KEY (`wayin_id`) REFERENCES `wayins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wayins`
--
ALTER TABLE `wayins`
  ADD CONSTRAINT `wayins_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wayins_wayout_id_foreign` FOREIGN KEY (`wayout_id`) REFERENCES `wayouts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wayoutdetails`
--
ALTER TABLE `wayoutdetails`
  ADD CONSTRAINT `wayoutdetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wayoutdetails_wayout_id_foreign` FOREIGN KEY (`wayout_id`) REFERENCES `wayouts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wayouts`
--
ALTER TABLE `wayouts`
  ADD CONSTRAINT `wayouts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waysaledetails`
--
ALTER TABLE `waysaledetails`
  ADD CONSTRAINT `waysaledetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waysaledetails_waysale_id_foreign` FOREIGN KEY (`waysale_id`) REFERENCES `waysales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waysales`
--
ALTER TABLE `waysales`
  ADD CONSTRAINT `waysales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waysales_wayout_id_foreign` FOREIGN KEY (`wayout_id`) REFERENCES `wayouts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waystockadddetails`
--
ALTER TABLE `waystockadddetails`
  ADD CONSTRAINT `waystockadddetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waystockadddetails_waystockadd_id_foreign` FOREIGN KEY (`waystockadd_id`) REFERENCES `waystockadds` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waystockadds`
--
ALTER TABLE `waystockadds`
  ADD CONSTRAINT `waystockadds_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waystockadds_wayout_id_foreign` FOREIGN KEY (`wayout_id`) REFERENCES `wayouts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
