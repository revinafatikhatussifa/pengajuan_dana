-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 09:44 AM
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
-- Database: `pengajuan_dana`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` float NOT NULL,
  `upload_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'diproses',
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id`, `user_id`, `name`, `file_url`, `type`, `size`, `upload_date`, `status`, `rejection_reason`) VALUES
(5, 5, 'WhatsApp_Image_2025-08-20_at_18_33_51_76c85f78.jpg', 'uploads/dokumen/WhatsApp_Image_2025-08-20_at_18_33_51_76c85f78.jpg', 'image/jpeg', 41.25, '2025-08-25 08:42:43', 'diproses', NULL),
(6, 5, 'WhatsApp_Image_2025-08-05_at_20_18_12_a9320b92.jpg', 'uploads/dokumen/WhatsApp_Image_2025-08-05_at_20_18_12_a9320b92.jpg', 'image/jpeg', 72.76, '2025-08-25 08:44:08', 'diproses', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `tempat_tujuan` varchar(255) DEFAULT NULL,
  `tgl_berangkat` datetime DEFAULT NULL,
  `tgl_pulang` datetime DEFAULT NULL,
  `status` enum('Diproses','Disetujui','Ditolak') NOT NULL,
  `dokumen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `user_id`, `nama`, `jabatan`, `tempat_tujuan`, `tgl_berangkat`, `tgl_pulang`, `status`, `dokumen`) VALUES
(17, 5, 'M. Fais Rizky', 'sales manager', 'sumatra utara', '2025-07-26 00:00:00', '2025-08-10 00:00:00', 'Ditolak', NULL),
(44, 5, 'Fazk', 'ceo', 'cina', '2026-01-10 00:00:00', '2027-01-31 00:00:00', 'Disetujui', NULL),
(45, 5, 'putra', 'manager', 'sulawesi', '2027-03-08 00:00:00', '2028-02-03 00:00:00', 'Diproses', NULL),
(46, 5, 'zaki', 'Direksi', 'kalimantan', '2028-06-14 00:00:00', '2029-06-17 00:00:00', 'Diproses', NULL),
(47, 5, 'amelia', 'staf', 'jakarta', '2030-06-10 00:00:00', '2031-10-06 00:00:00', 'Ditolak', NULL),
(49, 5, 'kldsfhl', 'sdnfkusj', 'dnvkjsd', '2030-09-23 00:00:00', '2031-09-24 00:00:00', 'Disetujui', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rincian`
--

CREATE TABLE `rincian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pengajuan_id` int(11) DEFAULT NULL,
  `nama_user` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `banyak` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rincian`
--

INSERT INTO `rincian` (`id`, `user_id`, `pengajuan_id`, `nama_user`, `keterangan`, `banyak`, `satuan`, `nominal`, `jumlah`, `created_at`) VALUES
(20, 5, NULL, 'jkbxscysdc', 'ndsmbcweiufw3ioesnx', 2, '300000', 600000.00, 1200000.00, '2025-08-25 02:19:42'),
(23, 5, NULL, 'ameliazahra', 'kos', 2, 'pp', 500000.00, 1000000.00, '2025-08-25 02:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `save`
--

CREATE TABLE `save` (
  `id` int(11) NOT NULL,
  `data_json` text NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role_id`, `date_created`, `image`, `is_active`) VALUES
(5, 'userTM', 'usr@gmail.com', '$2y$10$i5ProX523Hn1K.77vLZP0uMusnjV0yoSrLldt1NEQCFWwoL.XXKfu', 2, 1754621894, 'default.jpg', 1),
(6, 'adminTM', 'adm@gmail.com', '$2y$10$ojschVqw1Wp44Fje.R8Wye2/13V/7uReRI6Ulaj0FG2uD2g8fuBXy', 1, 1754639266, 'default.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rincian`
--
ALTER TABLE `rincian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rincian_ibfk_1` (`user_id`);

--
-- Indexes for table `save`
--
ALTER TABLE `save`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `rincian`
--
ALTER TABLE `rincian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `save`
--
ALTER TABLE `save`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rincian`
--
ALTER TABLE `rincian`
  ADD CONSTRAINT `rincian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
