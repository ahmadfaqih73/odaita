-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2021 at 03:54 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calender`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(126) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(24) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `create_by` int(15) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `minggu1` date DEFAULT NULL,
  `minggu2` date DEFAULT NULL,
  `minggu3` date DEFAULT NULL,
  `minggu4` date DEFAULT NULL,
  `minggu5` date DEFAULT NULL,
  `jml_minggu` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `description`, `color`, `start_date`, `end_date`, `create_at`, `create_by`, `modified_at`, `minggu1`, `minggu2`, `minggu3`, `minggu4`, `minggu5`, `jml_minggu`) VALUES
(56, NULL, NULL, NULL, NULL, NULL, '2021-01-16 01:52:58', 3, '2021-04-29 02:16:07', '2021-01-02', NULL, NULL, '2021-04-23', NULL, 4),
(57, NULL, NULL, NULL, NULL, NULL, '2021-01-16 02:02:41', 2, '2021-04-16 02:03:14', '2021-01-02', NULL, '2021-01-14', NULL, NULL, 4),
(58, NULL, NULL, NULL, NULL, NULL, '2021-02-16 02:02:54', 2, NULL, '2021-02-05', NULL, NULL, NULL, NULL, 4),
(59, NULL, NULL, NULL, NULL, NULL, '2021-01-21 16:22:30', 4, '2021-04-22 01:17:03', '2021-04-21', '2021-04-22', NULL, NULL, NULL, 4),
(63, NULL, NULL, NULL, NULL, NULL, '2021-02-10 01:07:48', 4, '2021-04-22 01:12:59', NULL, '2021-04-14', '2021-04-23', NULL, NULL, 4),
(64, NULL, NULL, NULL, NULL, NULL, '2021-03-11 01:38:59', 4, '2021-04-22 01:57:18', '2021-03-09', '2021-03-17', NULL, NULL, NULL, 4),
(65, NULL, NULL, NULL, NULL, NULL, '2021-04-22 03:01:51', 4, NULL, NULL, NULL, '2021-04-22', NULL, NULL, 4),
(66, NULL, NULL, NULL, NULL, NULL, '2021-04-29 01:39:20', 3, NULL, NULL, NULL, NULL, '2021-04-21', NULL, 4),
(67, NULL, NULL, NULL, NULL, NULL, '2021-05-01 00:53:40', 3, '2021-05-01 01:12:02', '2021-05-01', '2021-05-22', '2021-05-14', '2021-05-21', NULL, 4),
(68, NULL, NULL, NULL, NULL, NULL, '2021-05-01 01:48:25', 4, '2021-05-02 22:34:26', '2021-05-01', '2021-05-02', NULL, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(2) NOT NULL,
  `kelas` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`) VALUES
(1, 'XI IPA 1'),
(2, 'XI IPA 2'),
(3, 'XI IPA 3'),
(4, 'XI IPA 4'),
(5, 'XI IPA 5'),
(6, 'XI IPA 6'),
(7, 'XI IPA 7'),
(8, 'XI IPS 1'),
(9, 'XI IPS 2'),
(10, 'XI IPS 3'),
(37, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(15) NOT NULL,
  `nisn` varchar(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `kelas` int(2) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `role` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nisn`, `username`, `nama_siswa`, `kelas`, `password`, `role`) VALUES
(1, '0', 'admin', 'Sekolah', 37, '12345', '2'),
(2, '25031999', 'ajipratama', 'Aji Pratama', 2, '12345', '1'),
(3, '15121998', 'bruno', 'Bruno Fernandes', 2, '12345', '1'),
(4, '1234', 'lindelof', 'lindelof', 2, '12345', '1'),
(5, '1234', 'baily', 'baily', 2, '12345', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas` (`kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`kelas`) REFERENCES `kelas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
