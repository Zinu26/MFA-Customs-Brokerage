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
-- Table structure for table `consignees`
--

CREATE TABLE `consignees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tin` varchar(191) NOT NULL,
  `contact` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consignees`
--

INSERT INTO `consignees` (`id`, `user_id`, `tin`, `contact`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '146647938000', '9245646', '35 G. Miranda St., Cor G. Marcelo St., Dizon Compound Brgy., Maysan Valenzuela City.', 0, NULL, NULL),
(2, 4, '002786064000', '', 'Lot 4 F2 F3 F. Pasco Avenue, Santolan, Pasig City 1610', 0, NULL, NULL),
(3, 5, '223768948000', '', '1601 Tanbel Center Bldg., E. Rodriguez Sr. Blvd., Pinagkaisahan, Quezon City, Philippines', 0, NULL, NULL),
(4, 6, '006974110000', '', 'Unit 801, 8/F The Trade and Financial Tower 7th ave. Cor 32nd St., Bonifacio Global City, Taguig Cit', 0, NULL, NULL),
(5, 7, '009942474000', '', 'GROUND FLOOR MOUNT SEA RESORT BLDG. 163 MARSEILLA ST. BAGBAG 2 ROSARIO CAVITE', 0, NULL, NULL),
(6, 8, '104006732000', '', '88A Apo St. Brgy. Lourdes 1114 Quezon City, Philippines', 0, NULL, NULL),
(7, 9, '215843356000', '', '103 PROGRESS AVE., PH.1 GIZ, CARMEL RAY INDL. PARK, CANLUBANG, CALAMBA LAGUNA', 0, NULL, NULL),
(8, 10, '008826753000', '', '1601 E.RODRIGUEZ SR.BLVD PINAGKAISA HAN QUEZON CIT', 0, NULL, NULL),
(9, 11, '003940759000', '', '1601 Tanbel Centre E. Rodriguez Pinagkaisahan, Quezon City, Philippines', 0, NULL, NULL),
(10, 12, '203632078000', '', 'UNIT 104, BLDG. 1, OPVI CENTRE, 229 5 PASONG TAMO EXT. MAKATI', 0, NULL, NULL),
(11, 17, '004616195000', '', 'EASTCHEM BLDG. 3RD FLOOR NO. 14 ILA NG ILANG ST. NEW MANILA QUEZON CITY', 0, NULL, NULL),
(12, 18, '008337101000', '', '148 V. CRUZ BARANGAY MAYTUNAS SAN JUAN', 0, NULL, NULL),
(13, 19, '007025011000', '', 'EASTCHEM BLDG. 3RD FLOOR NO. 14 ILA NG ILANG ST. NEW MANILA QUEZON CITY', 0, NULL, NULL),
(14, 20, '000240160000', '', '59 MH DEL PILAR ST ARKONG BATO VALENZUELA', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consignees`
--
ALTER TABLE `consignees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consignees_tin_unique` (`tin`),
  ADD KEY `consignees_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consignees`
--
ALTER TABLE `consignees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consignees`
--
ALTER TABLE `consignees`
  ADD CONSTRAINT `consignees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
