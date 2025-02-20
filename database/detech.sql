-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 12:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `detech`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `mileage` int(11) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `image1` blob DEFAULT NULL,
  `image2` blob DEFAULT NULL,
  `image3` blob DEFAULT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `price` int(255) NOT NULL,
  `license_plate` varchar(7) NOT NULL,
  `is_reserved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `brand`, `model`, `year`, `mileage`, `color`, `image1`, `image2`, `image3`, `fuel_type`, `price`, `license_plate`, `is_reserved`) VALUES
(5753, 'Toyota', 'Fortuenr', 2019, 87500, 'White', 0x75706c6f6164732f666f727475656e7220323031392e706e67, 0x75706c6f6164732f666f727475656e7220323031392e706e67, 0x75706c6f6164732f666f727475656e7220323031392e706e67, 'Gas', 343, 'ABC 123', 0),
(7586, 'Lucid', 'Air 1', 2024, 3000, 'Black', 0x75706c6f6164732f4c757369642e6a7067, 0x75706c6f6164732f4c757369642e6a7067, 0x75706c6f6164732f4c757369642e6a7067, 'Electric', 1700, 'A 1', 0),
(238732, 'Toyota', 'FJ Cruiser', 2007, 250000, 'Grey', 0x75706c6f6164732f464a2e706e67, 0x75706c6f6164732f464a2e706e67, 0x75706c6f6164732f464a2e706e67, 'GAS', 270, 'BCA 123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `car_notes`
--

CREATE TABLE `car_notes` (
  `note_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `current_mileage` int(11) NOT NULL,
  `return_mileage` int(11) NOT NULL,
  `miles_used` int(11) GENERATED ALWAYS AS (`return_mileage` - `current_mileage`) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL,
  `damage_before` text DEFAULT NULL,
  `damage_after` text DEFAULT NULL,
  `damage_count_before` int(11) DEFAULT NULL,
  `damage_count_after` int(11) DEFAULT NULL,
  `front_photo_before` blob DEFAULT NULL,
  `right_photo_before` blob DEFAULT NULL,
  `back_photo_before` blob DEFAULT NULL,
  `left_photo_before` blob DEFAULT NULL,
  `front_photo_after` blob DEFAULT NULL,
  `right_photo_after` varchar(255) DEFAULT NULL,
  `back_photo_after` varchar(255) DEFAULT NULL,
  `left_photo_after` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('pending','approved','declined','delivered','returned') NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone_number`, `password`, `role`) VALUES
(6, 'admin', 'admin@admin.com', '0555555555', '$2y$10$u0ukvYlGIYrtxSTWGfpJjuGvNjMFgbb8s6GvuINjmahyfyezFDZCW', 'admin'),
(8, 'customer', 'customer@customer.com', '0555555559', '$2y$10$YH11RKNTrqaU7m8tmSxeduzBlFuwsKiKNfUff4b5kIUls1AVVF1su', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `car_notes`
--
ALTER TABLE `car_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2222346;

--
-- AUTO_INCREMENT for table `car_notes`
--
ALTER TABLE `car_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_notes`
--
ALTER TABLE `car_notes`
  ADD CONSTRAINT `car_notes_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
