-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 09:40 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tone_coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Coffee Series', 'coffee-series', '☕', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(2, 'Non Coffee', 'non-coffee', '🧋', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(3, 'Boba Gacor', 'boba-gacor', '🟤', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(4, 'Matcha Series', 'matcha-series', '🍵', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(5, 'Squash', 'squash', '🍹', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(6, 'Hot Coffee', 'hot-coffee', '🔥', 1, '2026-04-21 05:25:15', '2026-04-21 05:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('online','offline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `phone`, `vehicle_number`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', '081234567890', 'BP 1234 AB', NULL, 'offline', '2026-04-21 05:25:16', '2026-04-28 05:25:24'),
(2, 'Andi Pratama', '082345678901', 'BP 5678 CD', NULL, 'offline', '2026-04-21 05:25:16', '2026-04-28 05:25:13'),
(3, 'Fadel Muhammad', '081342674884', 'DP 2517 hr', 'couriers/r86Etr83ZwGvZKK0tCWDAC4oxrrLP28SJyUM3bvz.jpg', 'online', '2026-04-21 05:25:16', '2026-04-28 05:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `stock` int NOT NULL DEFAULT '100',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `image`, `is_available`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kopi Aren', 'kopi-aren-69e77abbf3060', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(2, 1, 'Kopi Regal Aren', 'kopi-regal-aren-69e77abc00a7f', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(3, 1, 'Kopi T.O', 'kopi-to-69e77abc0216f', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(4, 1, 'Kopi Susu Latte', 'kopi-susu-latte-69e77abc034e3', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(5, 1, 'Kopi Butterscotch', 'kopi-butterscotch-69e77abc0496e', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(6, 1, 'Kopi Caramel', 'kopi-caramel-69e77abc05ddb', 'Minuman segar dari ONE T.O Coffee', 15000.00, 'menus/TxDWWnOJxeKqVeulIsLAdqwX0S2SBXZ6DaXgMacq.jpg', 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:50:47'),
(7, 1, 'Kopi Banana Latte', 'kopi-banana-latte-69e77abc071f2', 'Minuman segar dari ONE T.O Coffee', 15000.00, 'menus/ED9souFDMm7tKgrSqwMdIqa745rONaEonh2VIcK7.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 02:08:18'),
(8, 1, 'Kopi Pandanos', 'kopi-pandanos-69e77abc08584', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(9, 1, 'Peach Americano', 'peach-americano-69e77abc09876', 'Minuman segar dari ONE T.O Coffee', 15000.00, 'menus/EsbHaRdgmQhVW8HVUGl2Crjkm3oWvYYKLZAQl20u.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 02:31:38'),
(10, 1, 'Americano Ice', 'americano-ice-69e77abc0ad1d', 'Minuman segar dari ONE T.O Coffee', 13000.00, 'menus/aK9Wl5uFvTAHsQg1fyb1qCNWYI8NV4TA5JTWKhZi.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 02:12:15'),
(11, 2, 'Coklat', 'coklat-69e77abc0c115', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(12, 2, 'Coklat Gacor', 'coklat-gacor-69e77abc0d4a9', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(13, 2, 'Taro', 'taro-69e77abc0e811', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(14, 2, 'Cotton Candy', 'cotton-candy-69e77abc0fe44', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(15, 2, 'Greentea', 'greentea-69e77abc11161', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(16, 2, 'Thaitea', 'thaitea-69e77abc1242e', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(17, 2, 'Milo', 'milo-69e77abc136a5', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(18, 2, 'Milo Tea', 'milo-tea-69e77abc14c1b', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(19, 2, 'Redvelvet', 'redvelvet-69e77abc16023', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(20, 2, 'Vanila Manggo', 'vanila-manggo-69e77abc172ec', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(21, 2, 'Lemontea', 'lemontea-69e77abc1861e', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(22, 2, 'Milk Oreo', 'milk-oreo-69e77abc199e2', 'Minuman segar dari ONE T.O Coffee', 10000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(23, 2, 'Cappucino', 'cappucino-69e77abc1ac9b', 'Minuman segar dari ONE T.O Coffee', 10000.00, 'menus/LUL8e9xhkaiDYCQF5XTdQn6fWkYKrTGFadka2N3h.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 03:25:07'),
(24, 3, 'Brown Sugar Boba', 'brown-sugar-boba-69e77abc1bda8', 'Minuman segar dari ONE T.O Coffee', 15000.00, 'menus/DsKLBgJQfZx3b5J9IcmEcAIIvFaLhgVakfOn9DsI.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 03:21:57'),
(25, 3, 'Coklat Boba', 'coklat-boba-69e77abc1d01a', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(26, 3, 'Coklat Gacor Boba', 'coklat-gacor-boba-69e77abc1e528', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(27, 3, 'Taro Boba', 'taro-boba-69e77abc1f8fd', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(28, 3, 'Cotton Candy Boba', 'cotton-candy-boba-69e77abc20c26', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(29, 3, 'Greentea Boba', 'greentea-boba-69e77abc21f51', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(30, 3, 'Thaitea Boba', 'thaitea-boba-69e77abc234d2', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(31, 3, 'Milo Boba', 'milo-boba-69e77abc247d2', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(32, 3, 'Milotea Boba', 'milotea-boba-69e77abc25b9c', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(33, 3, 'Redvelvet Boba', 'redvelvet-boba-69e77abc26c8d', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(34, 3, 'Vanila Manggo Boba', 'vanila-manggo-boba-69e77abc2815c', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(35, 3, 'Milk Oreo Boba', 'milk-oreo-boba-69e77abc29461', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(36, 3, 'Cappucino Boba', 'cappucino-boba-69e77abc2a79c', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(37, 4, 'Japanese Matcha', 'japanese-matcha-69e77abc2bcba', 'Minuman segar dari ONE T.O Coffee', 18000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(38, 4, 'Japanese Strawberry Matcha', 'japanese-strawberry-matcha-69e77abc2d10a', 'Minuman segar dari ONE T.O Coffee', 18000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(39, 4, 'Greentea Matcha', 'greentea-matcha-69e77abc2e445', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(40, 5, 'Manggo Squash', 'manggo-squash-69e77abc2f77e', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(41, 5, 'Sipaling Biru', 'sipaling-biru-69e77abc309a5', 'Minuman segar dari ONE T.O Coffee', 15000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(42, 6, 'Kopi Susu Hot', 'kopi-susu-hot-69e77abc31d62', 'Minuman segar dari ONE T.O Coffee', 13000.00, NULL, 1, 100, '2026-04-21 05:25:16', '2026-04-21 05:25:16'),
(43, 6, 'Americano Hot', 'americano-hot-69e77abc32f20', 'Minuman segar dari ONE T.O Coffee', 13000.00, 'menus/8Xazitgv3CFuLYhFhihHxdcmAe3PO8WlovobXpAQ.png', 1, 100, '2026-04-21 05:25:16', '2026-05-07 02:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_18_064438_create_categories_table', 1),
(5, '2026_04_18_064555_create_menus_table', 1),
(6, '2026_04_18_064619_create_couriers_table', 1),
(7, '2026_04_18_065625_add_is_admin_to_users_table', 1),
(8, '2026_04_18_070520_create_orders_table', 1),
(9, '2026_04_18_070840_create_order_items_table', 1),
(10, '2026_04_18_070947_create_payments_table', 1),
(11, '2026_05_01_033230_add_order_type_to_orders_table', 2),
(12, '2026_05_14_075438_add_location_to_orders_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `courier_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','shipped','ready','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_type` enum('delivery','takeaway') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'delivery',
  `pickup_time` time DEFAULT NULL,
  `pickup_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT '5000.00',
  `total_amount` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `distance_km` decimal(8,2) DEFAULT NULL,
  `shipping_cost` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `courier_id`, `order_number`, `status`, `order_type`, `pickup_time`, `pickup_name`, `delivery_address`, `delivery_name`, `delivery_phone`, `subtotal`, `delivery_fee`, `total_amount`, `notes`, `created_at`, `updated_at`, `latitude`, `longitude`, `distance_km`, `shipping_cost`) VALUES
(1, 6, 2, 'TO-112A1328', 'processing', 'delivery', NULL, NULL, 'palopo', 'Admin ONE T.O', '081342674884', 28000.00, 5000.00, 33000.00, 'jangan bawa kurirnya', '2026-04-21 05:52:18', '2026-04-26 02:45:39', NULL, NULL, NULL, 0),
(2, 6, 2, 'TO-18884CDA', 'completed', 'delivery', NULL, NULL, 'palopo', 'Padel', '081342674884', 13000.00, 5000.00, 18000.00, 'bebas', '2026-04-21 05:54:16', '2026-04-28 04:58:40', NULL, NULL, NULL, 0),
(3, 6, 2, 'TO-49D5C0E7', 'processing', 'delivery', NULL, NULL, 'Palopo, jln datuk sulaiman no.5', 'Fadel Muhammad nya admin', '081342674884', 40000.00, 5000.00, 45000.00, 'di depan rumahnya putri dakka', '2026-04-28 04:14:21', '2026-04-28 05:22:05', NULL, NULL, NULL, 0),
(4, 6, 2, 'TO-5144FCCE', 'pending', 'delivery', NULL, NULL, 'Jln, Ponegoro no.12', 'Uci cantik pake BANGET', '081342674884', 25000.00, 5000.00, 30000.00, 'di depan rumahnya putri sambo', '2026-04-28 05:24:36', '2026-04-28 05:24:36', NULL, NULL, NULL, 0),
(5, 6, 3, 'TO-81AE4D63', 'pending', 'delivery', NULL, NULL, 'palopo', 'Uci cantik pake BANGET', '012341521661', 30000.00, 5000.00, 35000.00, 'jangan mi bawa sama baristanya', '2026-04-28 05:37:30', '2026-04-28 05:37:30', NULL, NULL, NULL, 0),
(6, 6, 3, 'TO-D460634C', 'cancelled', 'delivery', NULL, NULL, 'jln. ndakutaumi, depan sdn 313 kaliba, dekat rumahnya putri dakka', 'MAS ADIT DREAMY', '012341521661', 23000.00, 5000.00, 28000.00, 'ndausah pake gula amernya', '2026-04-30 19:25:58', '2026-04-30 19:29:25', NULL, NULL, NULL, 0),
(7, 6, NULL, 'TO-31DC9B4F', 'completed', 'takeaway', '13:30:00', 'Admin ONE T.O', 'Ambil di tempat', 'Admin ONE T.O', '-', 51000.00, 0.00, 51000.00, 'jangan bawa baristanya', '2026-04-30 20:59:09', '2026-04-30 21:13:16', NULL, NULL, NULL, 0),
(8, 6, 3, 'TO-C6A0FBAF', 'processing', 'delivery', NULL, 'Admin ONE T.O', 'palopo, depan lapangan pancasila', 'adit jomox', '0812345678910', 13000.00, 10000.00, 23000.00, 'jangan bawa kurirnya', '2026-04-30 21:38:50', '2026-04-30 22:27:19', NULL, NULL, NULL, 0),
(9, 6, 3, 'TO-8973014E', 'completed', 'delivery', NULL, 'Admin ONE T.O', 'palopo', 'Admin ONE T.O', '0812345678910', 15000.00, 10000.00, 25000.00, 'dekat rumah mas amba loh ya', '2026-04-30 22:30:47', '2026-04-30 22:40:40', NULL, NULL, NULL, 0),
(10, 8, 3, 'TO-EE3959AE', 'pending', 'delivery', NULL, 'bucici', 'palopo', 'bucici', '012341521661', 15000.00, 10000.00, 25000.00, 'jangan terlalu manis', '2026-05-03 21:30:11', '2026-05-03 21:30:11', NULL, NULL, NULL, 0),
(11, 10, 3, 'TO-2FD86389', 'processing', 'delivery', NULL, 'orangkedua', 'jjjjj', 'orangkedua', '012341521661', 26000.00, 10000.00, 36000.00, 'jangan bawa baristanya', '2026-05-07 23:38:37', '2026-05-13 22:17:45', NULL, NULL, NULL, 0),
(12, 8, 3, 'TO-EB58399B', 'pending', 'delivery', NULL, 'bucici', 'jln Andi tadda, palopo', 'bucici', '081233422665', 15000.00, 10000.00, 25000.00, 'love u', '2026-05-15 08:49:57', '2026-05-15 08:49:57', NULL, NULL, NULL, 0),
(13, 8, 3, 'TO-10B17B44', 'pending', 'delivery', NULL, 'bucici', 'jln Datuk sulaiman no.5', 'bucici', '081233422665', 23000.00, 10000.00, 33000.00, 'iya', '2026-05-15 08:59:55', '2026-05-15 08:59:55', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `menu_name`, `menu_price`, `quantity`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'Cotton Candy', 13000.00, 1, 13000.00, NULL, '2026-04-21 05:52:18', '2026-04-21 05:52:18'),
(2, 1, 6, 'Kopi Caramel', 15000.00, 1, 15000.00, NULL, '2026-04-21 05:52:18', '2026-04-21 05:52:18'),
(3, 2, 43, 'Americano Hot', 13000.00, 1, 13000.00, NULL, '2026-04-21 05:54:16', '2026-04-21 05:54:16'),
(4, 3, 24, 'Brown Sugar Boba', 15000.00, 2, 30000.00, NULL, '2026-04-28 04:14:21', '2026-04-28 04:14:21'),
(5, 3, 23, 'Cappucino', 10000.00, 1, 10000.00, NULL, '2026-04-28 04:14:21', '2026-04-28 04:14:21'),
(6, 4, 11, 'Coklat', 10000.00, 1, 10000.00, NULL, '2026-04-28 05:24:36', '2026-04-28 05:24:36'),
(7, 4, 5, 'Kopi Butterscotch', 15000.00, 1, 15000.00, NULL, '2026-04-28 05:24:36', '2026-04-28 05:24:36'),
(8, 5, 5, 'Kopi Butterscotch', 15000.00, 2, 30000.00, NULL, '2026-04-28 05:37:30', '2026-04-28 05:37:30'),
(9, 6, 10, 'Americano Ice', 13000.00, 1, 13000.00, NULL, '2026-04-30 19:25:58', '2026-04-30 19:25:58'),
(10, 6, 15, 'Greentea', 10000.00, 1, 10000.00, NULL, '2026-04-30 19:25:58', '2026-04-30 19:25:58'),
(11, 7, 12, 'Coklat Gacor', 15000.00, 1, 15000.00, NULL, '2026-04-30 20:59:09', '2026-04-30 20:59:09'),
(12, 7, 25, 'Coklat Boba', 13000.00, 1, 13000.00, NULL, '2026-04-30 20:59:09', '2026-04-30 20:59:09'),
(13, 7, 11, 'Coklat', 10000.00, 1, 10000.00, NULL, '2026-04-30 20:59:09', '2026-04-30 20:59:09'),
(14, 7, 36, 'Cappucino Boba', 13000.00, 1, 13000.00, NULL, '2026-04-30 20:59:09', '2026-04-30 20:59:09'),
(15, 8, 43, 'Americano Hot', 13000.00, 1, 13000.00, NULL, '2026-04-30 21:38:50', '2026-04-30 21:38:50'),
(16, 9, 28, 'Cotton Candy Boba', 15000.00, 1, 15000.00, NULL, '2026-04-30 22:30:47', '2026-04-30 22:30:47'),
(17, 10, 24, 'Brown Sugar Boba', 15000.00, 1, 15000.00, NULL, '2026-05-03 21:30:11', '2026-05-03 21:30:11'),
(18, 11, 43, 'Americano Hot', 13000.00, 1, 13000.00, NULL, '2026-05-07 23:38:37', '2026-05-07 23:38:37'),
(19, 11, 10, 'Americano Ice', 13000.00, 1, 13000.00, NULL, '2026-05-07 23:38:37', '2026-05-07 23:38:37'),
(20, 12, 24, 'Brown Sugar Boba', 15000.00, 1, 15000.00, NULL, '2026-05-15 08:49:57', '2026-05-15 08:49:57'),
(21, 13, 23, 'Cappucino', 10000.00, 1, 10000.00, NULL, '2026-05-15 08:59:55', '2026-05-15 08:59:55'),
(22, 13, 25, 'Coklat Boba', 13000.00, 1, 13000.00, NULL, '2026-05-15 08:59:55', '2026-05-15 08:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('adit@gmail.com', '$2y$12$qWEdXQaUuzfWAvTaI9XTuOsjhjJXxyxc33E/R4MbZwD5hScxGVIvG', '2026-05-13 20:00:12'),
('kenzorazor2112@gmail.com', '$2y$12$tK9f7hNm1xohpOmuCYRkweQ1FWV2JdvkYgbWSwAA0VysJhrIwk7XW', '2026-05-13 20:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `method` enum('cash','qris') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `proof_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `amount`, `status`, `proof_image`, `notes`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'cash', 33000.00, 'success', NULL, NULL, '2026-04-26 02:45:39', '2026-04-21 05:52:18', '2026-04-26 02:45:39'),
(2, 2, 'qris', 18000.00, 'success', NULL, NULL, '2026-04-26 02:45:35', '2026-04-21 05:54:16', '2026-04-26 02:45:35'),
(3, 3, 'cash', 45000.00, 'success', NULL, NULL, '2026-04-28 05:22:05', '2026-04-28 04:14:21', '2026-04-28 05:22:05'),
(4, 4, 'qris', 30000.00, 'pending', NULL, NULL, NULL, '2026-04-28 05:24:36', '2026-04-28 05:24:36'),
(5, 5, 'cash', 35000.00, 'pending', NULL, NULL, NULL, '2026-04-28 05:37:30', '2026-04-28 05:37:30'),
(6, 6, 'qris', 28000.00, 'success', 'payments/6r31EOtgPmOLqoKwhFE0MT1mnIouSwiRsDX6CHbT.jpg', NULL, '2026-04-30 19:28:49', '2026-04-30 19:25:58', '2026-04-30 19:28:49'),
(7, 7, 'cash', 51000.00, 'pending', NULL, NULL, NULL, '2026-04-30 20:59:09', '2026-04-30 20:59:09'),
(8, 8, 'cash', 23000.00, 'success', NULL, NULL, '2026-04-30 22:27:18', '2026-04-30 21:38:50', '2026-04-30 22:27:18'),
(9, 9, 'cash', 25000.00, 'success', NULL, NULL, '2026-04-30 22:32:09', '2026-04-30 22:30:47', '2026-04-30 22:32:09'),
(10, 10, 'cash', 25000.00, 'pending', NULL, NULL, NULL, '2026-05-03 21:30:11', '2026-05-03 21:30:11'),
(11, 11, 'cash', 36000.00, 'success', NULL, NULL, '2026-05-13 22:17:44', '2026-05-07 23:38:37', '2026-05-13 22:17:44'),
(12, 12, 'cash', 25000.00, 'pending', NULL, NULL, NULL, '2026-05-15 08:49:57', '2026-05-15 08:49:57'),
(13, 13, 'cash', 33000.00, 'pending', NULL, NULL, NULL, '2026-05-15 08:59:55', '2026-05-15 08:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5cOFMbAR7rMihTRABHHAonM20PcHwocs1AZfbuq1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI3Vnk3VVM3SWd5NTd6Yzg2Q05KUzRKeGNIYnJ0S0FNRjFNdDlrRGNyIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC90b25lLWNvZmZlZVwvcHVibGljIiwicm91dGUiOiJob21lIn19', 1778744528),
('9YBI0pmP02MMueSVsLz4eVyH9nX8LIneFpiR0KKY', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'eyJfdG9rZW4iOiJpUzdNZEg1RW9Iajk3VkIzQ0ozcHFXb056dEdldTloVFJ5YnNoWXBSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvdG9uZS1jb2ZmZWVcL3B1YmxpYyIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1778863514),
('DSF94pcTlkFxHYYdlD3x6fzJgyqxWRjOfIQxbk7I', 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQdldBNEFLM014V2FJVTdHTlVnbHV4SjhFTFVGVmxiN3ZVWGNQdnd0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvdG9uZS1jb2ZmZWVcL3B1YmxpY1wvcGF5bWVudFwvMTMiLCJyb3V0ZSI6InBheW1lbnQuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo4fQ==', 1778864428);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `phone`, `address`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 0, NULL, NULL, '2026-04-17 23:16:21', '$2y$12$ODMCl4p2KfBk7KzSpWXYTuZJxL6cQed0htjHRCQDF3WAWmPVJagAC', 'OnJuJmhPdr', '2026-04-17 23:16:21', '2026-04-17 23:16:21'),
(2, 'Fadel', 'kenzorazor2112@gmail.com', 0, NULL, NULL, NULL, '$2y$12$YuN/nNWCiWhasGbutwPjZuE4I5j/WHyMCz9EDZCBJuFcrHeqtO1sG', NULL, '2026-04-21 04:47:49', '2026-04-21 04:47:49'),
(3, 'Fadel', 'anonymousid2112@gmail.com', 0, NULL, NULL, NULL, '$2y$12$g/npCFiKkgKDBC3qgfv.W.HYuWMKta6J9h/ahWiOQIr6wTjlREhBi', NULL, '2026-04-21 04:48:22', '2026-04-21 04:48:22'),
(4, 'uci', 'awokawok@gmail.com', 0, NULL, NULL, NULL, '$2y$12$gZu8k3LcjKtf1Gs8hiKIP.AtjFPP5fwiBN6/PBlHoVTZE6Y4JWN2i', NULL, '2026-04-21 05:01:56', '2026-04-21 05:01:56'),
(5, 'ucindut', 'ucindut@gmail.com', 0, NULL, NULL, NULL, '$2y$12$vyGnX1lAbOm/0fKdA5HAxemb8zZCRRogpAJ3KUIejmPYacqODSyBm', NULL, '2026-04-21 05:04:11', '2026-04-21 05:04:11'),
(6, 'Admin ONE T.O', 'admin@oneto.com', 1, NULL, NULL, NULL, '$2y$12$psq//FRcMc44QtvUWNHSYekLVJuTaiuSDr9rX/FTEts8KuenCMU/i', NULL, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(7, 'Customer Test', 'customer@oneto.com', 0, NULL, NULL, NULL, '$2y$12$qQ.cnG94xv3qDTg505rUrOld0ja12Xfb/6pLQ94u2BxeQI5NNKoHu', NULL, '2026-04-21 05:25:15', '2026-04-21 05:25:15'),
(8, 'bucici', 'adit@gmail.com', 0, NULL, NULL, NULL, '$2y$12$H9sQ2e6D57fvRm/JXbqMh.CMhZLFwVjX2G6RJ3qv30BohuEdGO0rS', NULL, '2026-05-03 21:29:01', '2026-05-03 21:29:01'),
(9, 'Fadel Muhammad A.', 'fadelmuh021@gmail.com', 0, NULL, NULL, NULL, '$2y$12$ibjHlBjtBYned3skptM5vOyg6PIQ4yWzN8wUOcIeK.ukmnU6U3bFy', NULL, '2026-05-07 02:49:24', '2026-05-07 02:49:24'),
(10, 'orangkedua', 'orang@gmail.com', 0, NULL, NULL, NULL, '$2y$12$m31iAJwULP4kAxKSEHmFv.sFV8NuTAKIwuEh/063KAaXbh1loe1BS', NULL, '2026-05-07 23:07:52', '2026-05-07 23:07:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_slug_unique` (`slug`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_courier_id_foreign` (`courier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

