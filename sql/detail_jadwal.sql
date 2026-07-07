-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2026 at 06:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwalguru`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_jadwal`
--

CREATE TABLE `detail_jadwal` (
  `Id_jadwal` int DEFAULT NULL,
  `Kd_mapel` varchar(5) DEFAULT NULL,
  `Kd_guru` varchar(5) DEFAULT NULL,
  `Hari` varchar(15) DEFAULT NULL,
  `Jam_mulai` time DEFAULT NULL,
  `Jam_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_jadwal`
--

INSERT INTO `detail_jadwal` (`Id_jadwal`, `Kd_mapel`, `Kd_guru`, `Hari`, `Jam_mulai`, `Jam_selesai`) VALUES
(NULL, NULL, NULL, 'rabu', '09:30:00', '10:30:00'),
(12, 'M-002', 'G-002', 'rabu', '08:00:00', '09:00:00'),
(NULL, NULL, NULL, 'rabu', '09:30:00', '10:30:00'),
(14, 'M-002', 'G-002', 'Senin', '12:28:00', '12:30:00'),
(15, 'M-001', 'G-002', 'Jumat', '12:33:00', '12:33:00'),
(16, 'M-003', 'G-002', 'Kamis', '13:33:00', '14:34:00'),
(16, 'M-001', 'G-002', 'Kamis', '17:33:00', '18:34:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_jadwal`
--
ALTER TABLE `detail_jadwal`
  ADD KEY `dmpl` (`Kd_mapel`),
  ADD KEY `dguru` (`Kd_guru`),
  ADD KEY `djadwl` (`Id_jadwal`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_jadwal`
--
ALTER TABLE `detail_jadwal`
  ADD CONSTRAINT `dguru` FOREIGN KEY (`Kd_guru`) REFERENCES `guru` (`Kd_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `djadwl` FOREIGN KEY (`Id_jadwal`) REFERENCES `jadwal_kelas` (`Id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dmpl` FOREIGN KEY (`Kd_mapel`) REFERENCES `mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
