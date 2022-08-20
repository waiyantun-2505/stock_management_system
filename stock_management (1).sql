-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2020 at 11:54 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

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
  `phone` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', 98474844, 'yangon yangon yangon yangon yangon', '2020-04-27 00:08:55', '2020-04-27 00:08:55'),
(2, 'Mandalay', 96473822, 'Mandalay Mandalay Mandalay', '2020-04-27 00:09:35', '2020-04-27 00:09:35');

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
(1, 'Electronic device', '2020-04-27 00:01:38', '2020-04-27 00:01:38'),
(2, 'Electronic device 2', '2020-04-27 00:01:47', '2020-04-27 00:01:47'),
(3, 'Electronic device 3', '2020-04-27 00:01:58', '2020-04-27 00:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yangon', '2020-04-29 08:31:09', '2020-04-29 08:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `city_id`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Agent', 1, 456555555, 'yangon Yangon Yangon', '2020-04-29 08:31:48', '2020-04-29 08:31:48');

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
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_04_08_112834_create_categories_table', 1),
(4, '2020_04_08_113407_create_subcategories_table', 1),
(5, '2020_04_08_113740_create_cities_table', 1),
(6, '2020_04_08_113741_create_ways_table', 1),
(7, '2020_04_08_115251_create_customers_table', 1),
(8, '2020_04_08_122336_create_products_table', 1),
(9, '2020_04_08_122337_create_waydetails_table', 1),
(10, '2020_04_09_064021_create_branches_table', 1),
(11, '2020_04_09_064022_create_orders_table', 1),
(12, '2020_04_09_064707_create_orderdetails_table', 1),
(13, '2020_04_09_071102_create_stocks_table', 1),
(14, '2020_04_09_071539_create_sales_table', 1),
(15, '2020_04_09_073221_create_saledetails_table', 1),
(16, '2020_04_21_123057_create_transfers_table', 1),
(17, '2020_04_21_130041_create_transferdetails_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `order_id`, `product_id`, `branch_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 31, 1, 2, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(2, 31, 1, 1, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(3, 31, 2, 2, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(4, 31, 2, 1, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(5, 31, 3, 2, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(6, 31, 3, 1, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(7, 31, 4, 2, 450, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(8, 31, 4, 1, 100, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(9, 31, 5, 1, 400, '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(10, 32, 1, 1, 100, '2020-04-28 03:15:37', '2020-04-28 03:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suppliername` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderdate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `suppliername`, `orderdate`, `created_at`, `updated_at`) VALUES
(31, 'Agent', '2020-04-28', '2020-04-28 03:12:52', '2020-04-28 03:12:52'),
(32, 'Yangon', '2020-04-28', '2020-04-28 03:15:37', '2020-04-28 03:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(1, 'E sub 1 Product 1', 1, '2020-04-27 00:04:12', '2020-04-27 00:04:12'),
(2, 'E sub 1 product 2', 1, '2020-04-27 00:04:57', '2020-04-27 00:04:57'),
(3, 'E sub 2 product 1', 2, '2020-04-27 00:05:12', '2020-04-27 00:05:12'),
(4, 'E sub 2 product 3', 2, '2020-04-27 00:05:29', '2020-04-27 00:05:29'),
(5, 'E2 sub 1 product 1', 3, '2020-04-27 00:07:32', '2020-04-27 00:07:32'),
(6, 'E2 sub 1 product 2', 3, '2020-04-27 00:07:51', '2020-04-27 00:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `saledetails`
--

CREATE TABLE `saledetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saledetails`
--

INSERT INTO `saledetails` (`id`, `sale_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 1, '2020-04-29 09:13:58', '2020-04-29 09:13:58'),
(2, 3, 1, 2, '2020-04-29 09:14:17', '2020-04-29 09:14:17'),
(3, 3, 2, 2, '2020-04-29 09:14:17', '2020-04-29 09:14:17'),
(4, 3, 4, 2, '2020-04-29 09:14:17', '2020-04-29 09:14:17'),
(5, 3, 5, 2, '2020-04-29 09:14:17', '2020-04-29 09:14:17'),
(6, 4, 4, 102, '2020-04-29 09:15:25', '2020-04-29 09:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `saledate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `branch_id`, `saledate`, `created_at`, `updated_at`) VALUES
(2, 1, 1, '2020-04-21', '2020-04-29 09:13:58', '2020-04-29 09:13:58'),
(3, 1, 1, '2020-04-29', '2020-04-29 09:14:17', '2020-04-29 09:14:17'),
(4, 1, 2, '2020-04-29', '2020-04-29 09:15:25', '2020-04-29 09:15:25');

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
(3, 450, 3, 1, '2020-04-27 00:11:06', '2020-04-28 03:12:52'),
(5, 448, 5, 1, '2020-04-27 00:11:20', '2020-04-29 09:14:17'),
(6, 48, 6, 1, '2020-04-27 00:11:20', '2020-04-29 09:13:58'),
(7, 450, 1, 2, '2020-04-27 00:16:17', '2020-04-28 03:12:52'),
(8, 450, 2, 2, '2020-04-27 00:16:17', '2020-04-28 03:12:52'),
(10, 450, 4, 2, '2020-04-27 00:16:17', '2020-04-29 09:15:25'),
(22, 548, 1, 1, '2020-04-28 00:02:38', '2020-04-29 09:14:17'),
(24, 448, 2, 1, '2020-04-28 03:01:28', '2020-04-29 09:14:17'),
(26, 450, 3, 2, '2020-04-28 03:05:20', '2020-04-28 03:12:52'),
(27, 448, 4, 1, '2020-04-28 03:05:20', '2020-04-29 09:14:17');

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
(1, 'E Sub 1', 1, '2020-04-27 00:03:11', '2020-04-27 00:03:11'),
(2, 'E Sub 2', 1, '2020-04-27 00:03:21', '2020-04-27 00:03:21'),
(3, 'E2 Sub 1', 2, '2020-04-27 00:03:38', '2020-04-27 00:03:38'),
(4, 'E2 sub 2', 2, '2020-04-27 00:03:50', '2020-04-27 00:03:50');

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

--
-- Dumping data for table `transferdetails`
--

INSERT INTO `transferdetails` (`id`, `transfer_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17'),
(2, 1, 2, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17'),
(3, 1, 3, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17'),
(4, 1, 4, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17'),
(5, 1, 5, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17'),
(6, 1, 6, 50, '2020-04-27 00:16:17', '2020-04-27 00:16:17');

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

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `transfer_date`, `from_branch`, `to_branch`, `created_at`, `updated_at`) VALUES
(1, '2020-04-27', 1, 2, '2020-04-27 00:16:17', '2020-04-27 00:16:17');

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
-- Table structure for table `waydetails`
--

CREATE TABLE `waydetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `way_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `wayout_qauntity` int(11) NOT NULL,
  `wayin_qauntity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ways`
--

CREATE TABLE `ways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wayout_date` date NOT NULL,
  `wayin_date` date DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_city_id_foreign` (`city_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
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
-- Indexes for table `waydetails`
--
ALTER TABLE `waydetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waydetails_way_id_foreign` (`way_id`),
  ADD KEY `waydetails_product_id_foreign` (`product_id`);

--
-- Indexes for table `ways`
--
ALTER TABLE `ways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ways_city_id_foreign` (`city_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `saledetails`
--
ALTER TABLE `saledetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transferdetails`
--
ALTER TABLE `transferdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waydetails`
--
ALTER TABLE `waydetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ways`
--
ALTER TABLE `ways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `waydetails`
--
ALTER TABLE `waydetails`
  ADD CONSTRAINT `waydetails_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waydetails_way_id_foreign` FOREIGN KEY (`way_id`) REFERENCES `ways` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ways`
--
ALTER TABLE `ways`
  ADD CONSTRAINT `ways_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
