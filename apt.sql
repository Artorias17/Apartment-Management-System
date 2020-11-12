-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2020 at 10:33 PM
-- Server version: 10.5.6-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apt`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

CREATE TABLE `apartment` (
  `bno` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `apt_letter` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`bno`, `floor`, `apt_letter`, `rid`) VALUES
(4, 1, 'A', 100),
(4, 3, 'B', 103),
(13, 4, 'G', 107),
(13, 6, 'A', 108);

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `rid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phoneno` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`rid`, `rname`, `gender`, `phoneno`) VALUES
(100, 'Rhea of Thoroloand', 'Female', '02852651222'),
(103, 'Lord Gwyn', 'Male', '02025550154'),
(107, 'Laurentius', 'Male', '98797610981'),
(108, 'Donnie Murray', 'Male', '8122590915');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `gender`, `isAdmin`, `dateOfBirth`, `address`) VALUES
(2, 'Bruce Wayne', 'admin', 'admin', 'Male', 1, '1984-06-01', 'Aziz Cooperative Building, 118/a Shahabag Avenue (1st Flr), Dhaka'),
(5, 'Jon Snow', 'snow12', 'snow12', 'Male', 1, '2020-09-09', 'Winterfell');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `licence` varchar(50) NOT NULL,
  `vid` int(11) NOT NULL,
  `lot` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`licence`, `vid`, `lot`, `visit_id`) VALUES
('123 GVC', 69, 10, 34),
('123MVC', 71, 12, 36);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `vid` int(11) NOT NULL,
  `vname` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`vid`, `vname`, `gender`, `address`, `phone`) VALUES
(66, 'Onion Bro', 'Male', 'Firelink', '08001923458'),
(69, 'Quelana', 'Female', 'Izalith', '08001923458'),
(71, 'Jane Rayes', 'Female', '2970 Arron Smith Drive Pearl City', '8084534594'),
(72, 'Thalia Grace', 'Female', '123 Random Street, Dhaka', '01700000000'),
(73, 'Jane Doe', 'Female', '300 Arron Smith Drive, Pearl City, IL', '8084534594');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `visit_id` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival` date DEFAULT NULL,
  `departure` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`visit_id`, `vid`, `rid`, `reason`, `arrival`, `departure`) VALUES
(31, 66, 103, 'Enlightenment', '2020-09-09', '2020-09-25'),
(34, 69, 103, 'Just Visiting', '2020-09-09', '2020-09-09'),
(36, 71, 107, 'Visiting', '2020-09-09', '2020-09-11'),
(37, 72, 107, 'Visiting', '2020-09-10', '2020-09-11'),
(38, 73, 103, 'Just checking in', '2020-09-10', '2020-09-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartment`
--
ALTER TABLE `apartment`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vid`,`visit_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`vid`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
