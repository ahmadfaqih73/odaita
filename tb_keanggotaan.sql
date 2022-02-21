-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jul 2021 pada 04.48
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gizi_balita`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_keanggotaan`
--

CREATE TABLE `tb_keanggotaan` (
  `id_keanggotaan` int(11) NOT NULL,
  `tipe` enum('Input','Output') NOT NULL,
  `variabel` enum('Usia','BB','TB','BB_TB','BB_U','TB_U') NOT NULL,
  `nm_keanggotaan` varchar(50) NOT NULL,
  `nama_fungsi` enum('Linear Naik','Segitiga','Linear Turun') NOT NULL,
  `nilai_batas_bawah_l` int(11) NOT NULL,
  `nilai_batas_tengah_l` int(11) NOT NULL,
  `nilai_batas_atas_l` int(11) NOT NULL,
  `nilai_batas_bawah_p` int(11) NOT NULL,
  `nilai_batas_tengah_p` int(11) NOT NULL,
  `nilai_batas_atas_p` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_keanggotaan`
--

INSERT INTO `tb_keanggotaan` (`id_keanggotaan`, `tipe`, `variabel`, `nm_keanggotaan`, `nama_fungsi`, `nilai_batas_bawah_l`, `nilai_batas_tengah_l`, `nilai_batas_atas_l`, `nilai_batas_bawah_p`, `nilai_batas_tengah_p`, `nilai_batas_atas_p`) VALUES
(1, 'Input', 'Usia', 'Bayi', 'Linear Turun', 0, 6, 11, 0, 6, 11),
(2, 'Input', 'Usia', 'Baduta', 'Segitiga', 9, 16, 23, 9, 16, 23),
(3, 'Input', 'Usia', 'Balita1', 'Segitiga', 21, 31, 41, 21, 31, 41),
(4, 'Input', 'Usia', 'Balita2', 'Linear Naik', 39, 49, 60, 39, 49, 60),
(5, 'Input', 'BB', 'Sangat Kurang', 'Linear Turun', 2, 4, 6, 2, 4, 6),
(6, 'Input', 'BB', 'Kurang', 'Segitiga', 4, 8, 12, 4, 8, 11),
(7, 'Input', 'BB', 'Normal', 'Segitiga', 8, 13, 18, 9, 13, 18),
(8, 'Input', 'BB', 'Lebih', 'Segitiga', 15, 18, 23, 15, 20, 24),
(9, 'Input', 'BB', 'Sangat Lebih', 'Linear Naik', 21, 23, 28, 22, 25, 28),
(10, 'Input', 'TB', 'Sangat Pendek', 'Linear Turun', 44, 48, 56, 43, 47, 55),
(11, 'Input', 'TB', 'Pendek', 'Segitiga', 48, 65, 80, 47, 64, 78),
(12, 'Input', 'TB', 'Normal', 'Segitiga', 66, 94, 126, 64, 92, 124),
(13, 'Input', 'TB', 'Tinggi', 'Linear Naik', 110, 126, 130, 108, 124, 130),
(14, 'Output', 'BB_TB', 'Gizi Buruk', 'Linear Turun', 3, 7, 10, 3, 6, 8),
(15, 'Output', 'BB_TB', 'Gizi Kurang', 'Segitiga', 7, 12, 14, 6, 9, 12),
(16, 'Output', 'BB_TB', 'Gizi Normal', 'Segitiga', 12, 19, 25, 10, 16, 24),
(17, 'Output', 'BB_TB', 'Beresiko Gizi Lebih', 'Segitiga', 21, 23, 27, 19, 22, 25),
(18, 'Output', 'BB_TB', 'Gizi Lebih', 'Segitiga', 25, 27, 29, 24, 26, 28),
(19, 'Output', 'BB_TB', 'Obesitas', 'Linear Naik', 28, 34, 40, 28, 32, 38),
(20, 'Output', 'BB_U', 'Bb Sangat Kurang', 'Linear Turun', 3, 6, 8, 4, 7, 9),
(21, 'Output', 'BB_U', 'Bb Kurang', 'Segitiga', 6, 8, 10, 7, 9, 11),
(22, 'Output', 'BB_U', 'Bb Normal', 'Segitiga', 8, 12, 18, 9, 13, 18),
(23, 'Output', 'BB_U', 'Resiko Bb Lebih', 'Linear Naik', 16, 24, 30, 16, 23, 30),
(24, 'Output', 'TB_U', 'Sangat Pendek', 'Linear Turun', 45, 56, 67, 44, 56, 66),
(25, 'Output', 'TB_U', 'Pendek', 'Segitiga', 56, 72, 88, 56, 72, 86),
(26, 'Output', 'TB_U', 'Normal', 'Segitiga', 72, 98, 124, 72, 95, 123),
(27, 'Output', 'TB_U', 'Tinggi', 'Linear Naik', 112, 124, 130, 112, 123, 130);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_keanggotaan`
--
ALTER TABLE `tb_keanggotaan`
  ADD PRIMARY KEY (`id_keanggotaan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_keanggotaan`
--
ALTER TABLE `tb_keanggotaan`
  MODIFY `id_keanggotaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
