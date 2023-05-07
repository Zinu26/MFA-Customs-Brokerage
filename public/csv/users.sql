-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 07:54 PM
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
-- Database: `mfalaravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `isArchived` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `type`, `isArchived`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', 0, 0, '2023-05-06 09:35:14', '$2y$10$IJhaFejM7INrMl3Gefej2.nYZJPebFyFNJm9HHEGvjNVcA5eDmWcm', NULL, '2023-05-06 09:35:14', '2023-05-06 09:35:14'),
(2, 'User', 'User', 'user@user.com', 1, 0, '2023-05-06 09:35:14', '$2y$10$V.1jY5XMHPubjYUTJ3jfO.L6iE61NTn6wa40xPlKEYDYXPVlWL5o6', NULL, '2023-05-06 09:35:14', '2023-05-06 09:35:14'),
(3, 'MHYLINK TRADING', NULL, 'mhylink.trading@gmail.com', 2, 0, NULL, '146647938000', NULL, NULL, NULL),
(4, 'MEGAMAX CONCEPTS INC.', NULL, 'lai@megamaxconcepts.com', 2, 0, NULL, '002786064000', NULL, NULL, NULL),
(5, 'INFANTS PRODUCTS GALLERY CORP.', NULL, 'ipgc.infants@growwithme.ph', 2, 0, NULL, '223768948000', NULL, NULL, NULL),
(6, 'MANUCHAR PHILIPPINES INC.', NULL, 'roxxane.bajaro@manuchar.com', 2, 0, NULL, '006974110000', NULL, NULL, NULL),
(7, 'SEI DYNAMICS INC', NULL, 'accounting@solanda.com', 2, 0, NULL, '009942474000', NULL, NULL, NULL),
(8, 'DREAM VOLTS MARKETING', NULL, 'jane.rawbites.com.ph', 2, 0, NULL, '104006732000', NULL, NULL, NULL),
(9, 'METRO HUE-TECH CHEMICAL CO. INC.', NULL, 'imports.metrohue.com.ph', 2, 0, NULL, '215843356000', NULL, NULL, NULL),
(10, 'ISOURCE MARKETING ENTERPRISES CORP', NULL, 'imports@isource.com.ph', 2, 0, NULL, '008826753000', NULL, NULL, NULL),
(11, 'MENS GALLERY CORPORATION', NULL, 'ipgc.mensgallery@growwithme.ph', 2, 0, NULL, '003940759000', NULL, NULL, NULL),
(12, 'TERRY SELECTION INC.', NULL, 'terrys.import@terryselection.com', 2, 0, NULL, '203632078000', NULL, NULL, NULL),
(17, 'CBH INC.', NULL, 'libertykao@yahoo.com', 2, 0, NULL, '004616195000', NULL, NULL, NULL),
(18, 'ICOOL REFRIGERATION CORPORATION', NULL, 'icoolrefrigeration@yahoo.com', 2, 0, NULL, '008337101000', NULL, NULL, NULL),
(19, 'PHIL. BIOCHEM PRODUCTS INC.', NULL, 'libertykao@email.com', 2, 0, NULL, '007025011000', NULL, NULL, NULL),
(20, 'TOPFIL INDUSTRIES INC.', NULL, 'topfil89@gmail.com', 2, 0, NULL, '000240160000', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
