-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 05:26 PM
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
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(1, 2, 1, 'a', '2025-11-12 23:10:23'),
(2, 2, 1, 'fgdfg', '2025-11-12 23:10:26'),
(3, 1, 2, 'jhkjh', '2025-11-12 23:10:36'),
(4, 1, 2, ';\'', '2025-11-12 23:10:43'),
(5, 1, 2, 'l;\'l;\'', '2025-11-12 23:10:46'),
(6, 1, 2, 'kaga anjir', '2025-11-12 23:10:50'),
(7, 1, 2, 'la lu gimana', '2025-11-12 23:10:56'),
(8, 1, 2, 'kok gitu', '2025-11-12 23:10:59'),
(9, 2, 1, 'halo', '2025-11-12 23:11:46'),
(10, 2, 1, 'halo pak', '2025-11-12 23:15:11'),
(11, 2, 1, 'kenapa pak', '2025-11-12 23:15:17'),
(12, 1, 2, 'anjing lu pak', '2025-11-12 23:15:24'),
(13, 1, 2, 'kok gitu pak', '2025-11-12 23:15:28'),
(14, 2, 1, 'kenapa pak', '2025-11-12 23:16:24'),
(15, 2, 1, 'kok gitu pak', '2025-11-12 23:16:28'),
(16, 1, 2, 'anjing lu pak', '2025-11-12 23:19:18'),
(17, 4, 3, 'as', '2025-11-12 23:24:06'),
(18, 5, 3, 'asd', '2025-11-12 23:24:29'),
(19, 4, 5, 'asd', '2025-11-12 23:24:37'),
(20, 4, 5, 'sd', '2025-11-12 23:24:44'),
(21, 4, 5, 'asd', '2025-11-12 23:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `profile_pic`) VALUES
(1, NULL, NULL, '$2y$10$PVw2UTms79acL1TKm9zSZe.vEdYQ09i9qCPMGzwvW1CyKR/eaoo8i', 'bd764bb25d49a05105060185774ba14cd2c846f7.jpg'),
(2, NULL, NULL, '$2y$10$ThXxbFIEnoWsKaAwdco1NeNbNUq12eXbysfQVkVNMPNQWoAYWbrre', '_ (2).jpeg'),
(3, 'asd', 'BAAA', '$2y$10$/5SpImPQu9SxB.jfc1fbfOKaapdYywfXGLB8Pu.8EyKLAjgdlULVy', 'default.png'),
(4, NULL, NULL, '$2y$10$YQM7VOcaWpcoh6OLLn1wZ.GAWaT2AWOavcMfIUmQVw9a2ErbELa1i', '_ (1).jpeg'),
(5, 's', 's', '$2y$10$BTDrZLV48AfX/QYxX7iYeO9qdV.ibbnGewI7tX7kFyL22ysjUrZsO', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
