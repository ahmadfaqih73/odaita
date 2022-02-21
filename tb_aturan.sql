-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jul 2021 pada 04.57
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
-- Struktur dari tabel `tb_aturan`
--

CREATE TABLE `tb_aturan` (
  `id_aturan` int(11) NOT NULL,
  `aturan_1` int(11) NOT NULL,
  `aturan_2` int(11) NOT NULL,
  `hasil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_aturan`
--

INSERT INTO `tb_aturan` (`id_aturan`, `aturan_1`, `aturan_2`, `hasil`) VALUES
(1, 1, 5, 21),
(2, 1, 6, 22),
(3, 1, 7, 23),
(4, 1, 8, 23),
(5, 1, 9, 23),
(21, 1, 10, 25),
(22, 1, 11, 26),
(23, 1, 12, 27),
(24, 1, 13, 27),
(6, 2, 5, 21),
(7, 2, 6, 22),
(8, 2, 7, 22),
(9, 2, 8, 23),
(10, 2, 9, 23),
(25, 2, 10, 25),
(26, 2, 11, 26),
(27, 2, 12, 27),
(28, 2, 13, 27),
(11, 3, 5, 20),
(12, 3, 6, 21),
(13, 3, 7, 22),
(14, 3, 8, 23),
(15, 3, 9, 23),
(29, 3, 10, 24),
(30, 3, 11, 25),
(31, 3, 12, 26),
(32, 3, 13, 27),
(16, 4, 5, 20),
(17, 4, 6, 20),
(18, 4, 7, 21),
(19, 4, 8, 22),
(20, 4, 9, 23),
(33, 4, 10, 24),
(34, 4, 11, 25),
(35, 4, 12, 26),
(36, 4, 13, 27),
(37, 5, 10, 15),
(38, 5, 11, 15),
(39, 5, 12, 15),
(40, 5, 13, 14),
(41, 6, 10, 15),
(42, 6, 11, 16),
(43, 6, 12, 15),
(44, 6, 13, 15),
(45, 7, 10, 18),
(46, 7, 11, 16),
(47, 7, 12, 16),
(48, 7, 13, 15),
(49, 8, 10, 19),
(50, 8, 11, 18),
(51, 8, 12, 17),
(52, 8, 13, 16),
(53, 9, 10, 19),
(54, 9, 11, 19),
(55, 9, 12, 17),
(56, 9, 13, 17);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD PRIMARY KEY (`id_aturan`),
  ADD KEY `aturan_1` (`aturan_1`,`aturan_2`,`hasil`),
  ADD KEY `aturan_2` (`aturan_2`),
  ADD KEY `hasil` (`hasil`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_aturan`
--
ALTER TABLE `tb_aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD CONSTRAINT `tb_aturan_ibfk_1` FOREIGN KEY (`aturan_1`) REFERENCES `tb_keanggotaan` (`id_keanggotaan`),
  ADD CONSTRAINT `tb_aturan_ibfk_2` FOREIGN KEY (`aturan_2`) REFERENCES `tb_keanggotaan` (`id_keanggotaan`),
  ADD CONSTRAINT `tb_aturan_ibfk_3` FOREIGN KEY (`hasil`) REFERENCES `tb_keanggotaan` (`id_keanggotaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
