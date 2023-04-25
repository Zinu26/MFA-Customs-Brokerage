-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2023 at 11:22 AM
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
-- Database: `mfa`
--

-- --------------------------------------------------------

--
-- Table structure for table `consignees`
--

CREATE TABLE `consignees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tin` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consignees`
--

INSERT INTO `consignees` (`id`, `name`, `tin`, `contact`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MHYLINK TRADING', '146647938000', '9245646', 'mhylink.trading@gmail.com', '35 G. Miranda St., Cor G. Marcelo St., Dizon Compound Brgy., Maysan Valenzuela City.', 0, '2023-04-03 16:00:00', NULL),
(2, 'MEGAMAX CONCEPTS INC.', '002786064000', '0', 'lai@megamaxconcepts.com', 'Lot 4 F2 F3 F. Pasco Avenue, Santolan, Pasig City 1610', 0, '2023-04-07 16:00:00', NULL),
(3, 'INFANTS PRODUCTS GALLERY CORP.', '223768948000', '0', 'ipgc.infants@growwithme.ph', '1601 Tanbel Center Bldg., E. Rodriguez Sr. Blvd., Pinagkaisahan, Quezon City, Philippines', 0, '2023-04-07 16:00:00', NULL),
(4, 'MANUCHAR PHILIPPINES INC.', '006974110000', '0', 'roxxane.bajaro@manuchar.com', 'Unit 801, 8/F The Trade and Financial Tower 7th ave. Cor 32nd St., Bonifacio Global City, Taguig Cit', 0, '2023-04-07 16:00:00', NULL),
(5, 'SEI DYNAMICS INC', '009942474000', '0', 'accounting@solanda.com', 'GROUND FLOOR MOUNT SEA RESORT BLDG. 163 MARSEILLA ST. BAGBAG 2 ROSARIO CAVITE', 0, '2023-04-07 16:00:00', NULL),
(6, 'DREAM VOLTS MARKETING', '104006732000', '0', 'jane.rawbites.com.ph', '88A Apo St. Brgy. Lourdes 1114 Quezon City, Philippines', 0, '2023-04-07 16:00:00', NULL),
(7, 'METRO HUE-TECH CHEMICAL CO. INC.', '215843356000', '0', 'imports.metrohue.com.ph', '103 PROGRESS AVE., PH.1 GIZ, CARMEL RAY INDL. PARK, CANLUBANG, CALAMBA LAGUNA', 0, '2023-04-07 16:00:00', NULL),
(8, 'ISOURCE MARKETING ENTERPRISES CORP', '008826753000', '0', 'imports@isource.com.ph', '1601 E.RODRIGUEZ SR.BLVD PINAGKAISA HAN QUEZON CIT', 0, '2023-04-07 16:00:00', NULL),
(9, 'MENS GALLERY CORPORATION', '003940759000', '0', 'ipgc.mensgallery@growwithme.ph', '1601 Tanbel Centre E. Rodriguez Pinagkaisahan, Quezon City, Philippines', 0, '2023-04-07 16:00:00', NULL),
(10, 'TERRY SELECTION INC.', '203632078000', '0', 'terrys.import@terryselection.com', 'UNIT 104, BLDG. 1, OPVI CENTRE, 229 5 PASONG TAMO EXT. MAKATI', 0, '2023-04-07 16:00:00', NULL),
(11, 'CBH INC.', '004616195000', '0', 'libertykao@yahoo.com', 'EASTCHEM BLDG. 3RD FLOOR NO. 14 ILA NG ILANG ST. NEW MANILA QUEZON CITY', 0, '2023-04-07 16:00:00', NULL),
(12, 'ICOOL REFRIGERATION CORPORATION', '008337101000', '0', 'icoolrefrigeration@yahoo.com', '148 V. CRUZ BARANGAY MAYTUNAS SAN JUAN', 0, '2023-04-07 16:00:00', NULL),
(13, 'PHIL. BIOCHEM PRODUCTS INC.', '007025011000', '0', 'libertykao@yahoo.com', 'EASTCHEM BLDG. 3RD FLOOR NO. 14 ILA NG ILANG ST. NEW MANILA QUEZON CITY', 0, '2023-04-07 16:00:00', NULL),
(14, 'TOPFIL INDUSTRIES INC.', '000240160000', '0', 'topfil89@gmail.com', '59 MH DEL PILAR ST ARKONG BATO VALENZUELA', 0, '2023-04-07 16:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consignees`
--
ALTER TABLE `consignees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consignees`
--
ALTER TABLE `consignees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
