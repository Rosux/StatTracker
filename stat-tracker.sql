-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2022 at 12:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stat-tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `players` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'null',
  `team_goals` int(11) NOT NULL DEFAULT 0,
  `team_assists` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `players`, `team_goals`, `team_assists`) VALUES
(26, 'AjaxIsSlecht', '{\"23\":{\"goals\":53135,\"assists\":13414}}', 0, 0),
(27, 'Queens', '{\"23\":{\"goals\":53154363463463,\"assists\":211134663463},\"32\":{\"goals\":0,\"assists\":0}}', 0, 0),
(28, 'HIHI', 'null', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `goals` int(32) NOT NULL DEFAULT 0,
  `assists` int(32) NOT NULL DEFAULT 0,
  `login_token` varchar(255) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `goals`, `assists`, `login_token`, `admin`) VALUES
(23, 'JacobusF', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 2147483647, 2147483647, NULL, 4),
(32, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 0),
(53, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(72, 'Messi', 'messi@football.spain', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 4),
(168, 'IamMe', 'me@me.me', '$2y$10$Bya7kZ.kxXo3/FGn53QX8u3Jq2.gr7OjTZOkLzFbEVmSHfPGvPhcy', 0, 0, NULL, 1),
(169, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(170, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(171, 'IamMe', 'me@me.me', '$2y$10$Bya7kZ.kxXo3/FGn53QX8u3Jq2.gr7OjTZOkLzFbEVmSHfPGvPhcy', 0, 0, NULL, 0),
(174, 'IamMe', 'me@me.me', '$2y$10$Bya7kZ.kxXo3/FGn53QX8u3Jq2.gr7OjTZOkLzFbEVmSHfPGvPhcy', 0, 0, NULL, 0),
(175, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(176, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(177, 'IamMe', 'me@me.me', '$2y$10$Bya7kZ.kxXo3/FGn53QX8u3Jq2.gr7OjTZOkLzFbEVmSHfPGvPhcy', 0, 0, NULL, 0),
(178, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1),
(179, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 0, 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
