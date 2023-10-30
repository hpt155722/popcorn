-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Oct 30, 2023 at 09:33 PM
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
-- Database: `popcorn`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `followID` int(11) DEFAULT NULL,
  `follower` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `dateFollowed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateLiked` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likeID`, `postID`, `userID`, `dateLiked`) VALUES
(7, 10, 26, '2023-10-28 15:47:26'),
(8, 9, 26, '2023-10-28 15:47:27'),
(14, 12, 1, '2023-10-28 16:13:21'),
(16, 12, 25, '2023-10-28 16:25:01'),
(17, 12, 26, '2023-10-28 16:25:27'),
(18, 1, 32, '2023-10-30 15:28:55'),
(19, 9, 32, '2023-10-30 15:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `message`, `datePosted`) VALUES
(1, 1, 'gosh my mom is such a peach', '2023-10-28 20:17:29'),
(9, 1, 'just made some cupcakes!! <3333', '2023-10-28 14:37:08'),
(10, 25, 'help me!! HELP ME!!!!!', '2023-10-28 15:42:53'),
(11, 26, 'just bought one peach at the store. i ate the one peach i bought', '2023-10-28 15:44:31'),
(14, 31, 'today I add a lot of fun at the park!', '2023-10-28 20:40:24'),
(15, 31, 'i love red velvet cookies :D\n', '2023-10-28 20:40:38'),
(16, 32, 'hello! this is my first post everybody :)', '2023-10-30 15:25:05'),
(17, 32, 'just finished my homework today', '2023-10-30 15:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePicPath` varchar(255) NOT NULL DEFAULT 'default.webp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `profilePicPath`) VALUES
(1, 'towmater24', 'admin1234', '653d3b3ed4056.webp'),
(25, 'fluffyMonster', 'admin1234', '653d7224554d8.webp'),
(26, 'cheeseMaster', 'admin1234', '653d729399bb8.webp'),
(29, 'tester', 'asdasdasd', 'default.webp'),
(30, 'butt', 'asdasdasd', 'default.webp'),
(31, 'jellybean', 'admin1234', 'default.webp'),
(32, 'catlover24', 'admin1234', '654010c32c2d4.webp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
