-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 05:05 PM
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
-- Database: `car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `license_number` varchar(200) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`booking_id`, `user_id`, `car_id`, `start_date`, `end_date`, `license_number`, `amount`) VALUES
(1, 7, 2, '2023-04-20', '2023-04-22', '987654321', 6000),
(2, 12, 1, '2024-02-13', '2024-02-29', 'fahadkk', 48000);

-- --------------------------------------------------------

--
-- Table structure for table `car_details`
--

CREATE TABLE `car_details` (
  `car_id` int(11) NOT NULL,
  `model_id` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `make` varchar(100) NOT NULL,
  `passenger_capacity` int(11) NOT NULL,
  `luggage_capacity` varchar(100) NOT NULL,
  `cost_per_day` double NOT NULL,
  `year` varchar(20) NOT NULL,
  `color` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `street` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_details`
--

INSERT INTO `car_details` (`car_id`, `model_id`, `model`, `make`, `passenger_capacity`, `luggage_capacity`, `cost_per_day`, `year`, `color`, `status`, `location_name`, `street`, `city`, `image`) VALUES
(1, 'E150', 'Corolla', 'Toyota', 6, 'Small', 3000, '2018', 'White', 'Already Booked', 'Kay Rental', 'Street 5', 'Washington', '16818969512010_Toyota_Corolla_CE,_Front_Left.jpg'),
(2, 'E150', 'Corolla', 'Toyota', 6, 'Small', 3000, '2018', 'White', 'Already Booked', 'Kay Rental', 'Street 5', 'Washington', '16818972452010_Toyota_Corolla_CE,_Front_Left.jpg'),
(3, 'E140', 'Corolla', 'Toyota', 6, 'Medium', 3000, '2020', 'Blue', 'Available', 'Kay Rental', 'Street 5', 'Washington', '16818975332010_Toyota_Corolla_CE,_Front_Left.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_login_id` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `user_role` varchar(15) NOT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_login_id`, `user_email`, `user_pass`, `user_role`, `user_created_at`) VALUES
(7, 'Salman Khan A', 'salmanlogin', 'salmankhanserai@gmail.com', '$2y$10$WfPipQOEwriDyzCYi0oSJ..xezrO0jGG8tb3V1/XGIcOPDowQzOLq', 'admin', '2023-04-17 20:08:23'),
(11, 'user', 'userlogin', 'user@gmail.com', '$2y$10$vAQLAWQ0uEMoSn7UxrICe.pEQmJd9WkfsM9QtNkItFgvaexHcSNYa', 'user', '2023-04-19 09:54:11'),
(12, 'Fahad Ullah', 'fahad', 'fahad@gmail.com', '$2y$10$RAkiik7yCoHlCPrvtwTxb.ew7Gk1qQtd5CS/xoE1hN6X25FyA68Ra', 'admin', '2024-02-13 15:34:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `car_details`
--
ALTER TABLE `car_details`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_login_id` (`user_login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `car_details`
--
ALTER TABLE `car_details`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car_details` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
