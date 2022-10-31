-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2022 at 01:17 AM
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
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `scoreteam1_score` int(11) NOT NULL,
  `scoreteam2_score` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `team1_id`, `team2_id`, `scoreteam1_score`, `scoreteam2_score`, `date`) VALUES
(1, 1, 2, 10, 2, '2022-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  `gameid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `amount`, `userid`, `teamid`, `gameid`) VALUES
(1, 5, 17, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `players` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`players`)),
  `team_goals` int(11) NOT NULL DEFAULT 0,
  `team_assists` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `players`, `team_goals`, `team_assists`) VALUES
(1, 'Team1', '{\"1\":{\"goals\":0,\"assists\":0},\"2\":{\"goals\":0,\"assists\":0},\"3\":{\"goals\":0,\"assists\":0},\"4\":{\"goals\":0,\"assists\":0},\"5\":{\"goals\":0,\"assists\":0},\"6\":{\"goals\":0,\"assists\":0},\"35\":{\"goals\":0,\"assists\":0},\"7\":{\"goals\":0,\"assists\":0},\"8\":{\"goals\":0,\"assists\":0},\"9\":{\"goals\":0,\"assists\":0}}', 0, 0),
(2, 'Team2', '{\"1\":{\"goals\":0,\"assists\":0},\"2\":{\"goals\":0,\"assists\":0},\"3\":{\"goals\":0,\"assists\":0},\"4\":{\"goals\":0,\"assists\":0},\"5\":{\"goals\":0,\"assists\":0},\"6\":{\"goals\":0,\"assists\":0},\"17\":{\"goals\":3,\"assists\":1},\"7\":{\"goals\":0,\"assists\":0},\"8\":{\"goals\":0,\"assists\":0},\"9\":{\"goals\":0,\"assists\":0}}', 3, 1),
(3, 'Team3', '{\"1\":{\"goals\":0,\"assists\":0},\"2\":{\"goals\":0,\"assists\":0},\"3\":{\"goals\":0,\"assists\":0},\"4\":{\"goals\":0,\"assists\":0},\"5\":{\"goals\":0,\"assists\":0},\"6\":{\"goals\":0,\"assists\":0},\"17\":{\"goals\":16,\"assists\":5},\"7\":{\"goals\":0,\"assists\":0},\"8\":{\"goals\":0,\"assists\":0},\"9\":{\"goals\":0,\"assists\":0}}', 0, 0);

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
(23, 'Jacobus', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 3),
(32, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 4),
(53, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 69, NULL, 4),
(63, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(65, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(66, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(67, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 5, NULL, 1),
(69, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(72, 'messi', 'messi@football.spain', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 26543, 643624264, NULL, 0),
(73, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(74, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(75, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(76, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(77, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(78, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(79, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(81, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(82, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(83, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(84, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(85, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(86, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(87, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(88, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(89, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(90, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(91, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(92, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(93, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(94, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(95, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(96, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(97, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(98, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(100, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(101, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(102, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(103, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(104, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(105, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(106, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(107, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(108, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 420, NULL, 1),
(109, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(110, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(111, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 5, NULL, 0),
(112, '123456', 'asd@asd.asd', '$2y$10$Ngn7uxgtMVW1OwKpv6la6eh1oDca0gwHLxUd4GNJphukfNcRdiqMq', 1, 0, NULL, 0),
(113, 'dswadwa', 'dwadw@dad.dd', '$2y$10$IRb7mEz3LsBJKmjzBxC40OuxIDUgNyDOGg9.ncWt22FGnSAxbjIfy', 0, 0, NULL, 0),
(114, 'Rosux', 'uwu@uwu.uwu', '$2y$10$ysLdWOVasxvgR7eKYKlPgu3R9yrDApx2Nh33PIKSvJY58VzQWfMh6', 69, 5, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
