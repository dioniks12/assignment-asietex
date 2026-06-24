-- Database: assignment_asietex
-- ------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `assignment_asietex` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `assignment_asietex`;

-- ------------------------------------------------------
-- Table structure for table `users`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
('1', 'Budi Santoso', 'manager@gmail.com', NULL, '$2y$12$GN98BoroR6SfmFTgUJpNE.AhAYO6IwbxYGmhqOGRPmUZQLAJKvlNi', 'manajer', NULL, '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('2', 'Agus Wijaya', 'admin@gmail.com', NULL, '$2y$12$4JsT1l4ny.QfxbbeWQk6Ze8Ds25T4//j5yF.CwqpNiGQ0LJwfTgyy', 'admin_gudang', NULL, '2026-06-24 12:12:48', '2026-06-24 12:12:48');

-- ------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- Table structure for table `sessions`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- Table structure for table `categories`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `categories`
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
('1', 'Cotton', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('2', 'Polyester', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('3', 'Silk', '2026-06-24 12:12:48', '2026-06-24 12:12:48');

-- ------------------------------------------------------
-- Table structure for table `suppliers`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `suppliers`
INSERT INTO `suppliers` (`id`, `name`, `contact`, `address`, `created_at`, `updated_at`) VALUES
('1', 'PT Asietex Cottonindo', '+62 811-2233-4455', 'Jl. Raya Karawang Barat No. 12, Karawang, Jawa Barat', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('2', 'Indo Filament Corp', '+62 812-3456-7890', 'Kawasan Industri Jababeka Phase III, Cikarang, Bekasi', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('3', 'Sumatra Silk Mills', '+62 813-9876-5432', 'Jl. Jenderal Sudirman No. 89, Medan, Sumatera Utara', '2026-06-24 12:12:48', '2026-06-24 12:12:48');

-- ------------------------------------------------------
-- Table structure for table `products`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `current_stock` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `category_id`, `name`, `color`, `unit`, `current_stock`, `created_at`, `updated_at`) VALUES
('1', '1', 'Cotton Yarn 30S', 'Super White', 'kg', '120', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('2', '2', 'Polyester DTY 150/48', 'Navy Blue', 'kg', '5', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('3', '3', 'Mulberry Raw Silk Yarn', 'Natural White', 'roll', '45', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('4', '1', 'Viscose Rayon Fiber', 'Bright White', 'kg', '80', '2026-06-24 12:12:48', '2026-06-24 12:12:48');

-- ------------------------------------------------------
-- Table structure for table `transactions`
-- ------------------------------------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('in','out','return') NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `supplier_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_product_id_foreign` (`product_id`),
  KEY `transactions_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `transactions`
INSERT INTO `transactions` (`id`, `type`, `product_id`, `supplier_id`, `quantity`, `transaction_date`, `notes`, `created_at`, `updated_at`) VALUES
('1', 'in', '1', '1', '150', '2026-06-21 12:12:48', 'Initial bulk purchase Cotton Yarn 30S', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('2', 'out', '1', NULL, '30', '2026-06-22 12:12:48', 'Sent to weaving department', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('3', 'in', '2', '2', '15', '2026-06-20 12:12:48', 'Restock Polyester DTY', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('4', 'out', '2', NULL, '10', '2026-06-23 12:12:48', 'Sent to knitting department', '2026-06-24 12:12:48', '2026-06-24 12:12:48'),
('5', 'in', '3', '3', '45', '2026-06-24 06:12:48', 'Imported Mulberry Raw Silk', '2026-06-24 12:12:48', '2026-06-24 12:12:48');

