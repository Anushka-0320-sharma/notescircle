-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 16, 2026 at 11:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notescircle`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `created_at`) VALUES
(1, 9, 'Uploaded a new note', '2026-03-12 05:08:47'),
(2, 9, 'User logged in', '2026-03-12 08:19:46'),
(3, 9, 'Uploaded note: html', '2026-03-12 08:28:44'),
(4, 9, 'Uploaded note: HTML', '2026-03-12 08:31:36'),
(5, 10, 'User logged in', '2026-03-12 08:32:40'),
(6, 10, 'Uploaded note: CSS', '2026-03-12 08:33:45'),
(7, 9, 'User logged in', '2026-03-12 08:34:32'),
(8, 9, 'Submitted feedback for note: CSS', '2026-03-12 08:38:24'),
(9, 10, 'User logged in', '2026-03-12 08:39:29'),
(10, 10, 'Submitted feedback for note: HTML', '2026-03-12 08:39:47'),
(11, 10, 'Submitted feedback for note: English', '2026-03-12 08:40:30'),
(12, 10, 'Submitted feedback for note: Maths', '2026-03-12 08:40:46'),
(13, 10, 'Submitted feedback for note: html', '2026-03-12 08:40:59'),
(14, 11, 'User logged in', '2026-03-12 08:45:34'),
(15, 11, 'Submitted feedback for note: Maths', '2026-03-12 08:46:07'),
(16, 11, 'Uploaded note: PHP', '2026-03-12 08:49:05'),
(17, 11, 'Submitted feedback for note: HTML', '2026-03-12 08:49:39'),
(18, 11, 'Downloaded note ID 26', '2026-03-12 08:51:57'),
(19, 11, 'Downloaded note ID 24', '2026-03-12 08:52:00'),
(20, 11, 'Downloaded note ID 26', '2026-03-12 08:52:15'),
(21, 0, 'Admin deleted note: English', '2026-03-12 08:54:37'),
(22, 0, 'Admin deleted note: html', '2026-03-12 08:56:32'),
(23, 11, 'Uploaded note: delete', '2026-03-12 08:58:24'),
(24, 0, 'Admin deleted note: delete', '2026-03-12 08:59:00'),
(25, 11, 'Uploaded note: Java', '2026-03-12 10:06:08'),
(26, 10, 'User logged in', '2026-03-13 05:38:33'),
(27, 10, 'Downloaded note ID 26', '2026-03-13 06:30:29'),
(28, 10, 'Downloaded note ID 27', '2026-03-13 09:35:33'),
(29, 10, 'Downloaded note ID 27', '2026-03-13 10:16:44'),
(30, 10, 'Downloaded note ID 27', '2026-03-13 10:17:09'),
(31, 9, 'User logged in', '2026-03-15 06:23:26'),
(32, 9, 'Submitted feedback for note: PHP', '2026-03-15 07:38:12'),
(33, 9, 'Downloaded note ID 29', '2026-03-15 15:27:06'),
(34, 9, 'Downloaded note ID 27', '2026-03-15 15:27:08'),
(35, 14, 'User logged in', '2026-03-16 06:42:33'),
(36, 14, 'Submitted feedback for note: Java', '2026-03-16 06:43:30'),
(37, 14, 'Uploaded note: movie', '2026-03-16 06:44:50'),
(38, 9, 'User logged in', '2026-03-16 08:57:49'),
(39, 9, 'Submitted feedback for note: movie', '2026-03-16 09:14:52'),
(40, 9, 'User logged in', '2026-03-16 10:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin123', '2026-01-20 12:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `download_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `downloaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`download_id`, `user_id`, `note_id`, `downloaded_at`) VALUES
(9, 10, 26, '2026-03-13 06:30:29'),
(10, 10, 27, '2026-03-13 09:35:33'),
(11, 10, 27, '2026-03-13 10:16:44'),
(12, 10, 27, '2026-03-13 10:17:09'),
(13, 9, 29, '2026-03-15 15:27:06'),
(14, 9, 27, '2026-03-15 15:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `rating` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `message`, `rating`, `created_at`, `note_id`) VALUES
(4, 9, 'very good', 4, '0000-00-00 00:00:00', 26),
(5, 10, 'good', 3, '0000-00-00 00:00:00', 25),
(6, 10, 'good', 3, '0000-00-00 00:00:00', 23),
(7, 10, 'well done', 2, '0000-00-00 00:00:00', 1),
(8, 10, 'nice', 5, '0000-00-00 00:00:00', 24),
(11, 9, 'cvn', 3, '2026-03-15 07:38:12', 27),
(12, 14, 'huppp', 1, '2026-03-16 06:43:30', 29),
(13, 9, 'new', 5, '2026-03-16 09:14:52', 30);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_name` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `downloads` int(11) DEFAULT 0,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `user_id`, `title`, `content`, `created_at`, `updated_at`, `file_name`, `category`, `cover_image`, `tags`, `downloads`, `status`) VALUES
(1, 9, 'Maths', 'These are my maths notes.', '2026-03-12 03:31:11', '2026-03-12 03:31:11', '1773286271_ConfirmationPage-250400539321.pdf', 'BCA', '1773286271_cover_Gift.jpeg', NULL, 0, 'active'),
(25, 9, 'HTML', 'this is an html', '2026-03-12 08:31:36', '2026-03-15 15:40:07', '1773304296_2312.png', 'Coding', '1773304296_cover_6336.jpeg', '#html', 0, 'active'),
(26, 10, 'CSS', 'this is css ', '2026-03-12 08:33:45', '2026-03-12 08:33:45', '1773304425_5998.jpg', 'CSS', '1773304425_cover_7856.jpg', '#css', 3, 'active'),
(30, 14, 'movie', '', '2026-03-16 06:44:50', '2026-03-16 06:44:50', '1773643490_3774.jpg', 'Coding', '1773643490_cover_7325.jpeg', '#css', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `save_notes`
--

CREATE TABLE `save_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note_id` int(11) DEFAULT NULL,
  `saved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `save_notes`
--

INSERT INTO `save_notes` (`id`, `user_id`, `note_id`, `saved_at`) VALUES
(1, 7, 13, '2026-03-11 10:27:37'),
(2, 9, 26, '2026-03-12 14:08:53'),
(3, 10, 25, '2026-03-12 14:11:04'),
(4, 10, 24, '2026-03-12 14:11:06'),
(5, 10, 23, '2026-03-12 14:11:09'),
(6, 10, 1, '2026-03-12 14:11:11'),
(14, 10, 27, '2026-03-13 15:47:11'),
(15, 9, 27, '2026-03-15 20:57:10'),
(16, 9, 29, '2026-03-15 20:57:11'),
(17, 14, 1, '2026-03-16 12:13:38'),
(18, 14, 25, '2026-03-16 12:13:41'),
(19, 14, 29, '2026-03-16 12:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `profile_photo`) VALUES
(9, 'Anu', 'anushkasharma200704@gmail.com', '$2y$10$yx8fzRwVuWmxYHB6MPevq.foMalloSfqXLZuElJFUQ.PWMs7t31xm', '2026-03-15 14:59:26', '1773586766_profile.jpg'),
(10, 'Manzil', 'anu@gmail.com', '$2y$10$vcfW2iLnKdN1aQ.HUKaqk.H1XWFVWyZoParP7Y1i7ZUn3fX/hLSCe', '2026-03-13 10:48:39', '1773398919_profile.png'),
(12, 'kanya', 'kanya123@gmail.com', '$2y$10$L81Bl//myj6C3MTwjB0l.emsugPNKB5vZCo5S1997ZmhP21goiBwq', '2026-03-16 06:29:10', NULL),
(13, 'bob', 'bob@gmail.com', '$2y$10$xSXFLzU0nCwrb6gO5TmcSOsD6FSo0tsRpwSirnIklj3A15wH0V0fa', '2026-03-16 06:29:53', NULL),
(14, 'Katrina', 'katrina@gmail.com', '$2y$10$VDBZb8XbbGE9wbuV3bi3AuOvqUqoilcdiuWMRGI0l99CMlP6cu3HS', '2026-03-16 06:45:08', '1773643508_profile.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`download_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `save_notes`
--
ALTER TABLE `save_notes`
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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `save_notes`
--
ALTER TABLE `save_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
