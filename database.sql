-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 12:38 AM
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
-- Database: `petshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `status`, `created_at`, `user_email`) VALUES
(9, 1, 3, 1, 2, '2026-04-15 20:46:57', ''),
(11, 1, 9, 1, 2, '2026-04-15 22:30:06', ''),
(13, 1, 5, 1, 1, '2026-04-15 22:31:49', '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_price` int(11) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','shipped') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('pet','accessory') NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `species` varchar(50) DEFAULT NULL,
  `food` varchar(100) DEFAULT NULL,
  `trained` tinyint(1) DEFAULT 0,
  `price` int(11) NOT NULL,
  `stock` int(11) DEFAULT 1,
  `img` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `breed`, `species`, `food`, `trained`, `price`, `stock`, `img`, `description`, `created_at`) VALUES
(1, 'Dog', 'pet', 'Labrador', NULL, 'Meat', 1, 15000, 1, 'https://images.unsplash.com/photo-1558788353-f76d92427f16', 'Friendly dog', '2026-04-15 18:52:51'),
(2, 'Cat', 'pet', 'Persian', NULL, 'Fish', 0, 12000, 1, 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131', 'Cute cat', '2026-04-15 18:52:51'),
(3, 'Parrot', 'pet', 'Macaw', NULL, 'Seeds', 1, 8000, 1, 'https://images.unsplash.com/photo-1552728089-57bdde30beb3', 'Colorful bird', '2026-04-15 18:52:51'),
(4, 'Hamster', 'pet', 'Syrian', NULL, 'Grains', 0, 4000, 1, 'https://images.unsplash.com/photo-1548767797-d8c844163c4c', 'Small pet', '2026-04-15 18:52:51'),
(5, 'Dog Food', 'accessory', NULL, NULL, NULL, NULL, 3000, 1, 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1', 'Pet food', '2026-04-15 18:52:51'),
(6, 'Cat Toy', 'accessory', NULL, NULL, NULL, NULL, 800, 1, 'https://images.unsplash.com/photo-1592194996308-7b43878e84a6', 'Toy for cats', '2026-04-15 18:52:51'),
(7, 'Dog', 'pet', 'German Shepherd', NULL, 'Meat & Rice', 1, 20000, 1, 'https://images.unsplash.com/photo-1601758124510-52d02ddb7cbd', 'Strong and intelligent', '2026-04-15 18:52:51'),
(8, 'Dog', 'pet', 'Husky', NULL, 'Protein diet', 0, 22000, 1, 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e', 'Energetic snow dog', '2026-04-15 18:52:51'),
(9, 'Dog', 'pet', 'Golden Retriever', NULL, 'Chicken & Rice', 1, 18000, 1, 'https://images.unsplash.com/photo-1552053831-71594a27632d', 'Friendly family dog', '2026-04-15 18:52:51'),
(10, 'Cat', 'pet', 'British Shorthair', NULL, 'Fish & Chicken', 0, 14000, 1, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba', 'Calm and fluffy', '2026-04-15 18:52:51'),
(11, 'Cat', 'pet', 'Maine Coon', NULL, 'Meat & Fish', 0, 16000, 1, 'https://images.unsplash.com/photo-1533743983669-94fa5c4338ec', 'Large gentle cat', '2026-04-15 18:52:51'),
(12, 'Cat', 'pet', 'Siamese', NULL, 'Light protein diet', 0, 15000, 1, 'https://images.unsplash.com/photo-1573865526739-10659fec78a5', 'Active and vocal', '2026-04-15 18:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `user_id`, `product_id`, `rating`, `created_at`) VALUES
(1, 1, 2, 5, '2026-04-15 21:26:10'),
(2, 1, 10, 5, '2026-04-15 21:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `address` text DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`, `mobile`, `created_at`) VALUES
(1, 'AB', 'ab@gmail.com', 'ab', 'user', 'ABc', '01638925945', '2026-04-15 18:30:43'),
(2, 'Admin', 'admin@gmail.com', 'admin', 'admin', NULL, NULL, '2026-04-15 19:52:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
