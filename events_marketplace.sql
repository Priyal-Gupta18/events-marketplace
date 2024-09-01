-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 09:10 AM
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
-- Database: `events_marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@example.com', '456');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `contact_number` varchar(20) DEFAULT NULL,
  `status_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `service_id`, `booking_date`, `created_at`, `contact_number`, `status_id`) VALUES
(5, 8, 7, '2024-04-18', '2024-04-06 10:28:59', '7894561230', 1),
(6, 8, 9, '2024-04-14', '2024-04-06 11:48:38', '7418529637', 1),
(7, 8, 9, '2024-04-09', '2024-04-06 12:11:41', '7894561237', 2),
(8, 3, 8, '2024-04-22', '2024-04-06 12:14:42', '7894561230', 3),
(9, 3, 10, '2024-04-17', '2024-04-09 09:09:45', '4567891284', 2),
(10, 8, 11, '2024-04-20', '2024-04-14 16:41:21', '7894566123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking_history`
--

CREATE TABLE `booking_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_history`
--

INSERT INTO `booking_history` (`id`, `user_id`, `service_id`, `booking_date`, `contact_number`) VALUES
(3, 8, 7, '2024-04-18', '7894561230'),
(4, 8, 9, '2024-04-14', '7418529637'),
(5, 8, 9, '2024-04-09', '7894561237'),
(6, 3, 8, '2024-04-22', '7894561230'),
(7, 3, 10, '2024-04-17', '4567891284'),
(8, 8, 11, '2024-04-20', '7894566123');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`) VALUES
(1, 'Decoration', 'uploads/decor.jpg', 'All type of decorations!'),
(2, 'Catering', 'uploads/cater.jpeg', 'All food services!'),
(3, 'Photography', 'uploads/camera.jpeg', 'Photos and videography'),
(4, 'Music', 'uploads/Band.jpg', 'DJ and Instruments available.'),
(5, 'Dance', 'uploads/dancer.jpg', 'Hire Dancers and Dance Teachers!');

-- --------------------------------------------------------

--
-- Table structure for table `seller_categories`
--

CREATE TABLE `seller_categories` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_categories`
--

INSERT INTO `seller_categories` (`id`, `seller_id`, `category_id`) VALUES
(1, 10, 2),
(2, 11, 1),
(3, 12, 1),
(4, 13, 3),
(5, 14, 2),
(7, 18, 2),
(8, 19, 2),
(9, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `seller_id`, `title`, `description`, `price`, `category`, `image`) VALUES
(7, 2, 'best decoration', 'bestesttttt decor of everything!!', 20.00, 'Decoration', NULL),
(8, 6, 'photo', 'grat', 12.00, 'Photography', NULL),
(9, 11, 'flowers', 'freshhhh', 23.00, 'Decoration', NULL),
(10, 6, 'balloons ', 'Apart from counting words and characters, our online editor can help you to improve word choice and writing style, and, optionally, help you to detect grammar mistakes and plagiarism. To check word count, simply place your cursor into the text box above and start typing. You\'ll see the number o', 5000.00, 'Decoration', 'uploads/balloons.jpg'),
(11, 13, 'videos', 'best 4k vedios', 1500.00, 'Photography', NULL),
(12, 12, 'traditional decor', 'best decor for all events\r\n', 500.00, 'Decoration', 'R.jpeg'),
(13, 12, 'tent', 'best tent', 1000.00, 'Decoration', '661bdb9a90bb7_b81dd015794455d7d022ac64ff2635a1.png'),
(15, 20, 'music', 'best dj service', 2000.00, 'Music', 'uploads/dj.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Confirmed'),
(3, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','seller','buyer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`) VALUES
(2, 'abc', 'abc@gmail.com', '$2y$10$6RxCIKs2xketQziY1mWjyelN92AlXkA8F17T.iT9uj2lYCMXaASWm', 'seller'),
(3, 'user1', 'user1@gmail.com', '$2y$10$XwyEieYDxiS15gE7/upqd.0L/7Y5bFHJH0Q1lXgQkkJxNpFGZ18tq', 'buyer'),
(4, 'seller1', 'seller1@gmail.com', '$2y$10$MlGR8ZOu9kc9ob34i3bzb.Q2jD/5m2FTx5sLERXQOH49pzT3hcXWa', 'seller'),
(5, 'seller2', 'seller2@gmail.com', '$2y$10$m.YEymz5eXij80eQmYra2ubDspR1MvxxREA4wNotuahR7mjlwcNf6', 'seller'),
(6, 'zxc', 'zxc@zxc', '$2y$10$mAgQLYlpd9.l.Odf4ARfeOs4.EYAdFFURpAKisFuo22Ig3biiW6BK', 'seller'),
(8, 'Buyer1', 'buyer1@abc', '$2y$10$IjsQ9pcf3978IxGBk2BH9ePR3ZRBZx4H4RDWOqrSSlkRln8tZAXVC', 'buyer'),
(9, 'seller1', 'seller1@abc', '$2y$10$GZLJD7K/tFIwdAZY7NUEiu3Rj.xChq2PXgIvGWBGjp1MoMpN3mwAO', 'seller'),
(10, 'seller1', 'seller1@abc', '$2y$10$rsWSUiEdN2F8RvbKXpaSVulVUS1ZuFftkUOZlgori/npdq1f05UUa', 'seller'),
(11, 'selldecor', 'sell@sell', '$2y$10$oqTOYIyDjPS8s15qo7i5uejbZ30PUppBhGjG9a8TErwKtVoe17tQ.', 'seller'),
(12, 'seller2', 'seller2@sell', '$2y$10$RgRi25Wa1kBLv5pa1JE8tOQeEwfO3ksSiPvs7WBLQ.GqjGJgjkuYS', 'seller'),
(13, 'seller3', 'seller3@zxc', '$2y$10$YKcmcebas.KxZ7kRdVitl.Y1aHiJSj.dEbzm8EO4mDGapFvAIDvf6', 'seller'),
(14, 'shyam', 'shyam@zxc', '$2y$10$Mw8Dcwy1fOxcnBJNjom1xumNR9pR2r8OTrDbw9b5VUyg/Nbpdu2ki', 'seller'),
(15, 'iam', 'iam@zxc', '$2y$10$y9Hy1StHNGO6N5vGZcuC4.VIXSRmxBi5EODe8q9Hpsv5lgLQ52W7i', 'seller'),
(16, 'asd', 'asd@zxc', '$2y$10$lnM9xX20g1T121zkjivgXOa3Rx9jNYLQheRNpqZQYv0kM3Tw3efTa', 'seller'),
(17, 'asd', 'jj@zxc', '$2y$10$67fRMzt/L8uVTLD9uJqCvulCzMExbjDRXE2Yuu4KFbbDpcGgJ/asK', 'buyer'),
(18, 'se34', 'se34@zxc', '$2y$10$7thJbiIifNfGZ4zugZ1uwuvNF98Gthl9/ggFQOorPPEmKDb4GhCSK', 'seller'),
(19, 'karn', 'karn@gmail.com', '$2y$10$wEAOBVIub5kjGKO5BqN7puE3QCIbEfVbpTOm5Xuxrd7mIVqBPrfJi', 'seller'),
(20, 'seller6', 'seller6@zxc', '$2y$10$q/lPo3MQaO3MxTfRh3WvRe6pQVVOl24n9cOVpocpNsjdZquBtkn.i', 'seller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `fk_status` (`status_id`);

--
-- Indexes for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_categories`
--
ALTER TABLE `seller_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller_categories`
--
ALTER TABLE `seller_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_history_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `seller_categories`
--
ALTER TABLE `seller_categories`
  ADD CONSTRAINT `seller_categories_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seller_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
