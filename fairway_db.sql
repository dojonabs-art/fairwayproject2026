-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2026 at 09:29 AM
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
-- Database: `fairway_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `admission_no` varchar(20) DEFAULT NULL,
  `childName` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `className` varchar(20) NOT NULL,
  `parentName` varchar(100) NOT NULL,
  `parentPhone` varchar(20) NOT NULL,
  `homeaddress` text DEFAULT NULL,
  `status` varchar(40) DEFAULT 'Pending Headteacher Approval',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `admission_no`, `childName`, `date_of_birth`, `gender`, `className`, `parentName`, `parentPhone`, `homeaddress`, `status`, `created_at`) VALUES
(2, '', 'Namugonya Amina', '2007-03-01', 'Female', 'P.6', 'Vicky Wemesa Kutosi', '0779876543', 'kyebando', 'Pending Headteacher Approval', '2026-11-17 05:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `child_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date DEFAULT curdate(),
  `status` enum('pending','success','failed') DEFAULT 'success',
  `term` varchar(20) DEFAULT '2026-1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `child_name`, `amount`, `payment_date`, `status`, `term`, `created_at`) VALUES
(1, 'Kutosi Mathew', 250000.00, '2026-11-15', 'success', '2026-1', '2026-11-15 17:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `approved_by` varchar(50) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`, `status`, `approved_by`, `approved_at`) VALUES
(1, 'Kutosi Mathew', 'dojonabs@gmail.com', '$2y$10$6yS.ustR43VSJC8p4IDuG.nw.ic7RNXWsHSGDzg0wwVyZsJ9V4ST.', 'Teacher', '2026-11-14 06:58:19', 'rejected', NULL, NULL),
(2, 'DEBORAH', 'deborahfair@gmail.com', '$2y$10$Suz4x0QsKtVGsjEUoutphOXRUGJSKJK4r1d4.vDfndgvOsP3dFLuu', 'Secretary', '2026-11-14 08:34:37', 'pending', NULL, NULL),
(3, 'KUTOSI CHARLES', 'charles@gmail.com', '$2y$10$CM3F46L5L4drC0HJ/gg4JuI6oxaH98y9Rj9SFnj2.9TV.HTDxPg9y', 'Director', '2026-11-15 04:31:47', 'pending', NULL, NULL),
(4, 'James ', 'james@gmail.com', '$2y$10$PE.81RgWofAibRFYwzur1.lZbqwa5l7ERuE2MiExI1N1/fzvI5eHS', 'Headteacher', '2026-11-15 04:38:38', 'pending', NULL, NULL),
(5, 'florence', 'florence@gmail.com', '$2y$10$Qs9kwj1ghEqR/cfb5qniPeI485bwIypv05LqeGJuqu7.JFDYkEBKe', 'Bursar', '2026-11-15 17:49:12', 'pending', NULL, NULL),
(6, 'APIA MARGRET', 'apia@gmail.com', '$2y$10$m.JYA0D9.i20rVgLT.c.yOGj.TVollkAcXtWzGQw8TrBP5n5Sa2Ty', 'Teacher', '2026-11-15 20:32:41', 'active', NULL, '2026-11-16 00:13:43'),
(7, 'MOREEN', 'moreen@gmail.com', '$2y$10$ifvfpvFaRsWdiiy/f.r6s.GOIT5dpvimE3KuBVAkKrA5IrcaKEY8.', 'Teacher', '2026-11-15 21:20:32', 'pending', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
