-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 02:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `operating_system` varchar(50) DEFAULT NULL,
  `processor` varchar(50) DEFAULT NULL,
  `memory` int(11) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `computers`
--

INSERT INTO `computers` (`id`, `computer_name`, `model`, `operating_system`, `processor`, `memory`, `available`, `created_at`) VALUES
(1, 'Lab1-PC01', 'Dell OptiPlex 7090', 'Windows 11 Pro', 'Intel i5-11400', 16, 1, '2026-03-31 00:27:04'),
(2, 'Lab1-PC02', 'HP EliteDesk 800 G6', 'Windows 10 Pro', 'Intel i7-10700', 32, 1, '2026-03-31 00:27:04'),
(3, 'Lab1-PC03', 'Lenovo ThinkCentre M80s', 'Windows 11 Pro', 'Intel i5-12500', 16, 0, '2026-03-31 00:27:04'),
(4, 'Lab1-PC04', 'Dell OptiPlex 7090', 'Windows 11 Pro', 'Intel i5-11400', 8, 1, '2026-03-31 00:27:04'),
(5, 'Lab1-PC05', 'HP EliteDesk 800 G6', 'Windows 10 Pro', 'Intel i7-10700', 16, 1, '2026-03-31 00:27:04'),
(6, 'Lab2-PC01', 'Apple Mac mini M2', 'macOS Ventura', 'Apple M2', 16, 1, '2026-03-31 00:27:04'),
(7, 'Lab2-PC02', 'Dell OptiPlex 7090', 'Windows 11 Pro', 'Intel i5-11400', 32, 1, '2026-03-31 00:27:04'),
(8, 'Lab2-PC03', 'Lenovo ThinkCentre M80s', 'Windows 11 Pro', 'Intel i7-12700', 16, 0, '2026-03-31 00:27:04'),
(9, 'Lab2-PC04', 'HP EliteDesk 800 G6', 'Windows 10 Pro', 'Intel i5-11500', 16, 1, '2026-03-31 00:27:04'),
(10, 'Lab2-PC05', 'Dell OptiPlex 7090', 'Windows 11 Pro', 'Intel i5-11400', 16, 1, '2026-03-31 00:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `computer_id` int(11) NOT NULL,
  `reported_by` varchar(50) DEFAULT NULL,
  `reported_date` datetime DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `urgency` enum('Low','Medium','High') DEFAULT 'Medium',
  `status` enum('Open','In Progress','Resolved') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `computer_id` (`computer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`computer_id`) REFERENCES `computers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
