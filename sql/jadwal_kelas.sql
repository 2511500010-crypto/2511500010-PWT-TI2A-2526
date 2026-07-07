-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2026 at 06:49 AM
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
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `Id_jadwal` int NOT NULL,
  `Id_kelas` int DEFAULT NULL,
  `Thn_ajaran` varchar(20) DEFAULT NULL,
  `Semester` enum('ganjil','genap') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`Id_jadwal`, `Id_kelas`, `Thn_ajaran`, `Semester`) VALUES
(12, 3, '2023/2024', 'ganjil'),
(14, 5, '2024/2025', 'genap'),
(15, 4, '2025/2026', 'genap'),
(16, 4, '2023/2024', 'ganjil');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`Id_jadwal`),
  ADD KEY `Id_kelas` (`Id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `Id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD CONSTRAINT `jadwal_kelas_ibfk_1` FOREIGN KEY (`Id_kelas`) REFERENCES `kelas` (`kd_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
