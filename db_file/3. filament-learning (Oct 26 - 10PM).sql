-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2024 at 06:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filament-learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist_channels`
--

CREATE TABLE `artist_channels` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `topic_channel_link` varchar(255) DEFAULT NULL,
  `yt_channel_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `label_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_first_name` varchar(255) DEFAULT NULL,
  `father_last_name` varchar(255) DEFAULT NULL,
  `mother_first_name` varchar(255) DEFAULT NULL,
  `mother_last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `aadhar_card_front` varchar(255) DEFAULT NULL,
  `aadhar_card_back` varchar(255) DEFAULT NULL,
  `pancard` varchar(255) DEFAULT NULL,
  `plan` enum('free','gold') NOT NULL DEFAULT 'free',
  `wallet_balance` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `label_name`, `email`, `password`, `remember_token`, `dob`, `father_first_name`, `father_last_name`, `mother_first_name`, `mother_last_name`, `phone`, `whatsapp`, `aadhar_card_front`, `aadhar_card_back`, `pancard`, `plan`, `wallet_balance`, `created_at`, `updated_at`) VALUES
(1, 'Arun', 'Kumar', NULL, 'customer@gmail.com', '$2y$12$oMzP9pGbtq2ZfBvvQT/Nl.mmdwOkw48MmAQwFffM2rVyZeeEb.F0i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'free', 0, '2024-10-24 10:24:14', '2024-10-24 10:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address1` longtext DEFAULT NULL,
  `address2` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE `labels` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_04_28_085104_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('kingomcn@gmail.com', '$2y$12$jx5jL60BXExyorgXg5DiTOS1kjkfCGKcghzH3qJB7Mc02HAl38BDG', '2024-06-15 07:26:51'),
('phpfact+test@gmail.com', '$2y$12$96HNT2EOU0Tcxb1u7CB.GunrJlwlA2OhZiaHbXxxCJZSBO.DPb84W', '2024-10-26 16:40:46'),
('rockkibeat@gmail.com', '$2y$12$.RONGKJrZDVrjDj.ZprwDu6g8PEJW54aQOjNoFg/63efIy0BxBwyG', '2024-10-17 16:08:53');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Create User', 'web', '2024-05-11 12:14:20', '2024-05-11 12:14:20'),
(2, 'Update User', 'web', '2024-05-11 12:14:30', '2024-05-11 12:14:30'),
(3, 'View User', 'web', '2024-05-11 12:14:47', '2024-05-11 12:18:52'),
(4, 'Delete User', 'web', '2024-05-11 12:16:02', '2024-05-11 12:16:02'),
(5, 'Restore User', 'web', '2024-05-11 12:16:10', '2024-05-11 12:16:10'),
(6, 'Force Delete User', 'web', '2024-05-11 12:16:26', '2024-05-11 12:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remove_copyright_requests`
--

CREATE TABLE `remove_copyright_requests` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `yt_video_link` varchar(255) NOT NULL,
  `provider` varchar(150) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-05-11 11:59:20', '2024-05-11 11:59:20'),
(2, 'Customer', 'web', '2024-05-11 11:59:27', '2024-05-11 11:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'address', '', '2024-05-12 16:49:58', '2024-05-12 16:49:58'),
(2, 'email', '', '2024-05-12 16:49:58', '2024-05-12 16:49:58'),
(3, 'phone', '', '2024-05-12 16:49:58', '2024-05-12 16:49:58'),
(4, 'telephone', '', '2024-05-12 16:49:58', '2024-05-12 16:49:58'),
(5, 'logo', 'assets/uploads/favicon.png', '2024-05-12 16:49:58', '2024-05-12 16:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `singers` longtext DEFAULT NULL,
  `lyrics` longtext DEFAULT NULL,
  `produser_name` varchar(255) NOT NULL,
  `composer` longtext DEFAULT NULL,
  `label_name` varchar(255) DEFAULT NULL,
  `label_id` int(11) NOT NULL,
  `publisher` longtext DEFAULT NULL,
  `copyright` longtext DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `song_path` varchar(255) DEFAULT NULL,
  `music_genre` varchar(150) NOT NULL,
  `music_sub_genre` varchar(150) NOT NULL,
  `music_mood` varchar(150) NOT NULL,
  `stream_store` tinyint(1) NOT NULL DEFAULT 0,
  `fb_ig_music` tinyint(1) NOT NULL DEFAULT 0,
  `yt_content_id` tinyint(1) NOT NULL DEFAULT 0,
  `caller_tune` tinyint(1) NOT NULL DEFAULT 0,
  `caller_tune_name` longtext DEFAULT NULL,
  `caller_tune_duration` longtext DEFAULT NULL,
  `explicit` tinyint(1) NOT NULL DEFAULT 0,
  `isrc_code` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reject_reason` longtext DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `reward` double NOT NULL DEFAULT 0,
  `is_added` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'phpfact@gmail.com', NULL, '$2y$12$oMzP9pGbtq2ZfBvvQT/Nl.mmdwOkw48MmAQwFffM2rVyZeeEb.F0i', 'vYk4pC7FbYC5b2tspz4uCnEi8HPeGOLd2sQrerl0BMd72ubXDjiy6JlrIPHH', '2024-05-11 11:56:39', '2024-05-11 11:56:39'),
(2, 'Arun', 'arun.kumar.2003.8574@gmail.com', NULL, '$2y$12$oMzP9pGbtq2ZfBvvQT/Nl.mmdwOkw48MmAQwFffM2rVyZeeEb.F0i', 'vYk4pC7FbYC5b2tspz4uCnEi8HPeGOLd2sQrerl0BMd72ubXDjiy6JlrIPHH', '2024-05-11 11:56:39', '2024-05-11 11:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `video_songs`
--

CREATE TABLE `video_songs` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `singers` longtext DEFAULT NULL,
  `produser_name` varchar(255) NOT NULL,
  `lyrics` longtext DEFAULT NULL,
  `composer` longtext DEFAULT NULL,
  `label_name` varchar(255) DEFAULT NULL,
  `label_id` int(11) DEFAULT NULL,
  `publisher` longtext DEFAULT NULL,
  `music_genre` varchar(150) NOT NULL,
  `music_sub_genre` varchar(150) NOT NULL,
  `music_mood` varchar(150) NOT NULL,
  `copyright` longtext DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `isrc_code` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reject_reason` longtext DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `reward` double NOT NULL DEFAULT 0,
  `is_added` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist_channels`
--
ALTER TABLE `artist_channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `remove_copyright_requests`
--
ALTER TABLE `remove_copyright_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `video_songs`
--
ALTER TABLE `video_songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist_channels`
--
ALTER TABLE `artist_channels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remove_copyright_requests`
--
ALTER TABLE `remove_copyright_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `video_songs`
--
ALTER TABLE `video_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
