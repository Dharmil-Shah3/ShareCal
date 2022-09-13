-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2022 at 10:26 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cal`
--

-- --------------------------------------------------------

--
-- Table structure for table `main_table`
--

CREATE TABLE `main_table` (
  `id` int(4) UNSIGNED NOT NULL,
  `u_name` varchar(34) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_table`
--

INSERT INTO `main_table` (`id`, `u_name`, `password`, `mail`) VALUES
(1, 'Dharmil Shah', '999999999', 'dha8866@gmail.com'),
(2, 'Hiren', '999999999', 'hiren99@gmail.com'),
(3, 'Jagat', '55555555', 'jagatpandya57@gmail.com'),
(5, 'Dharmik Borisagar', 'dharmik33', 'dharmikborisagar313@gmail.com'),
(6, 'Harsh Galani', '999999999', 'harsh48@gmail.com'),
(7, 'Dhruvin', '999999999', 'dhruvin38@gmail.com'),
(9, 'Dhruv', '999999999', 'dhruv37@gmail.com'),
(10, 'Kevin', '999999999', 'kevin55@gmail.com'),
(11, 'Faizan 69', '999999999', 'faizan69@gmail.com'),
(12, 'Zaid Multani', '999999999', 'zaid23@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `main_table`
--
ALTER TABLE `main_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `main_table`
--
ALTER TABLE `main_table`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
