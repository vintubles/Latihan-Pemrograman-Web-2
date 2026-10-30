-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2026 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pendaftaran`
--

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `pekerjaan_ortu` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `mat` int(11) NOT NULL,
  `bing` int(11) NOT NULL,
  `umum` int(11) NOT NULL,
  `rata` decimal(5,2) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `tempat_tes` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `tgl_input`, `kode`, `nama`, `jk`, `asal_sekolah`, `pekerjaan_ortu`, `tempat_lahir`, `tgl_lahir`, `mat`, `bing`, `umum`, `rata`, `keterangan`, `tempat_tes`) VALUES
(1, '2026-03-05', 'A2', 'Wemmbu', 'Laki-Laki', 'SMAN 4 Unstbale', 'Pilot', 'Jakarta', '2004-08-02', 78, 100, 85, 87.67, 'Lulus', 'Gedung A'),
(2, '2026-07-04', 'V9', 'Nihilux', 'Laki-Laki', 'Planarcadia Academy', 'Aeon', 'Jakarta', '2005-12-04', 99, 98, 98, 98.33, 'Lulus', 'Viktor'),
(3, '2026-10-30', 'V78', 'Cristianosewwy', 'Laki-Laki', 'SMA Rongawi Indah 2', 'Usaha Nikel', 'Jakarta', '2026-10-17', 82, 90, 78, 83.33, 'Lulus', 'Viktor'),
(4, '2026-10-17', 'B79', 'ALVIN', 'Laki-Laki', 'SMAN 4 Unstbale', 'Usaha Nikel', 'Jakarta', '2026-10-15', 90, 78, 98, 88.67, 'Lulus', 'Gedung B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
