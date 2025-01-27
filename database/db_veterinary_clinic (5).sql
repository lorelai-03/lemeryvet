-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 11:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_veterinary_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$gMfEcbl7O7PPT7Qr2CQ2JeUIJMx6MQ.SCWTDb9IVgzP6ALI3tcjye');

-- --------------------------------------------------------

--
-- Table structure for table `canceled_appointments`
--

CREATE TABLE `canceled_appointments` (
  `id` int(11) NOT NULL,
  `original_appointment_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `canceled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `canceled_appointments`
--

INSERT INTO `canceled_appointments` (`id`, `original_appointment_id`, `patient_name`, `appointment_date`, `reason`, `canceled_at`) VALUES
(9, 29, 'Olga Montenegro', '2024-09-21 09:01:00', 'Appointment canceled by user', '2024-09-14 13:03:23'),
(10, 32, 'Olga Montenegro', '2024-09-14 09:04:00', 'Appointment canceled by user', '2024-09-14 13:06:53'),
(11, 31, 'Olga Montenegro', '2024-09-14 09:04:00', 'Appointment canceled by user', '2024-09-14 13:06:55'),
(12, 30, 'Olga Montenegro', '2024-09-21 09:01:00', 'Appointment canceled by user', '2024-09-14 13:06:56'),
(13, 33, 'Olga Montenegro', '2024-09-15 09:34:00', 'Appointment canceled by user', '2024-09-15 01:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_info`
--

CREATE TABLE `clinic_info` (
  `id` int(11) NOT NULL,
  `business_permit_no` varchar(50) NOT NULL,
  `clinic_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `line_of_business` varchar(100) NOT NULL,
  `clinic_image` varchar(255) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_info`
--

INSERT INTO `clinic_info` (`id`, `business_permit_no`, `clinic_name`, `address`, `line_of_business`, `clinic_image`, `latitude`, `longitude`) VALUES
(20, '2024-0401012000-0788', 'Lemery Pet Haus & Veterinary Products', 'Palanas Lemery, Batangas', 'Veterinary Clinic', 'uploads/images.png', 13.895200, 120.906502),
(21, '2024-0401012000-0310', 'B.V Seda Animal Care Clinic and Veterinary Supplies', 'St. Francis BLDG. Atienza St. Cor. Burgos St. Bagong Sikat, Lemery, Batangas', 'Retailer of Agriculturist/Farm Supplies/Equipment, Veterinary Clinic, Veterinary Supplies', 'uploads/images (1).jfif', 13.882900, 120.917633);

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `email`, `otp`, `expiry`) VALUES
(45, 'lemeryvets@gmail.com', '331653', '2024-12-08 14:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `medical_products`
--

CREATE TABLE `medical_products` (
  `id` int(11) NOT NULL,
  `medical_name` varchar(255) NOT NULL,
  `medical_description` text NOT NULL,
  `medical_price` decimal(10,2) NOT NULL,
  `medical_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `veterinary_id` int(11) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_products`
--

INSERT INTO `medical_products` (`id`, `medical_name`, `medical_description`, `medical_price`, `medical_image`, `created_at`, `veterinary_id`, `original_price`) VALUES
(17, 'Lorems', 'Nunc malesuada quis nisi non dignissim. Nam mi sem, venenatis vitae metus eu, fringilla placerat risus. Suspendisse vehicula neque sed nisl tempor, vel cursus mi vulputate. Morbi mollis cursus dictum. Nulla iaculis diam quis vehicula gravida. Aenean blandit mi et velit volutpat rutrum', 242.25, 'uploads/medical_product/pngegg (19).png', '2024-08-22 02:29:14', 6, NULL),
(18, 'Lorem', 'Vivamus pellentesque porttitor tortor, et rhoncus quam vestibulum vitae. Maecenas bibendum a sem at fermentum. Nulla facilisis fringilla quam. Phasellus mollis nunc ac consequat laoreet. ', 86.21, 'uploads/medical_product/pngegg (16).png', '2024-08-22 02:31:47', 6, NULL),
(19, 'Lorem Ipsum', 'Donec molestie rutrum risus eu auctor. Donec augue mauris, consectetur et ornare non, auctor ut massa. Proin eu turpis sit amet libero cursus rutrum. ', 165.30, 'uploads/medical_product/pngegg (18).png', '2024-08-22 02:32:41', 6, NULL),
(22, 'Lorem', 'Nunc malesuada quis nisi non dignissim. Nam mi sem, venenatis vitae metus eu, fringilla placerat risus. Suspendisse vehicula neque sed nisl tempor, vel cursus mi vulputate. Morbi mollis cursus dictum. Nulla iaculis diam quis vehicula gravida. Aenean blandit mi et velit volutpat rutrum', 320.00, 'uploads/medical_product/pngegg (15).png', '2024-08-26 12:42:07', 5, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `medical_product_percentage`
--

CREATE TABLE `medical_product_percentage` (
  `id` int(11) NOT NULL,
  `veterinary_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_product_percentage`
--

INSERT INTO `medical_product_percentage` (`id`, `veterinary_id`, `percentage`) VALUES
(1, 5, 50),
(2, 5, 0),
(3, 5, 90),
(4, 5, 0),
(5, 5, 60);

-- --------------------------------------------------------

--
-- Table structure for table `pet_products`
--

CREATE TABLE `pet_products` (
  `id` int(11) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `pet_description` text NOT NULL,
  `pet_price` decimal(10,2) NOT NULL,
  `pet_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `veterinary_id` int(11) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_products`
--

INSERT INTO `pet_products` (`id`, `pet_name`, `pet_description`, `pet_price`, `pet_image`, `created_at`, `veterinary_id`, `original_price`) VALUES
(1, 'Loremdd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor. ', 509.00, 'uploads/pet_products/pngegg (18).png', '2024-08-22 04:32:47', 5, NULL),
(3, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor.', 121.00, 'uploads/pet_products/pngegg (16).png', '2024-08-22 13:28:30', 6, NULL),
(4, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor.', 234.00, 'uploads/pet_products/pngegg (15).png', '2024-08-22 13:29:21', 6, NULL),
(5, 'Ipsum Lorem', 'Nunc malesuada quis nisi non dignissim. Nam mi sem, venenatis vitae metus eu, fringilla placerat risus. Suspendisse vehicula neque sed nisl tempor, vel cursus mi vulputate. Morbi mollis cursus dictum. Nulla iaculis diam quis vehicula gravida. Aenean blandit mi et velit volutpat rutrum', 222.00, 'uploads/pet_products/pngegg (19).png', '2024-08-26 12:21:24', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pet_product_percentage`
--

CREATE TABLE `pet_product_percentage` (
  `id` int(11) NOT NULL,
  `veterinary_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_product_percentage`
--

INSERT INTO `pet_product_percentage` (`id`, `veterinary_id`, `percentage`) VALUES
(1, 5, 80),
(2, 5, 0),
(3, 5, 90);

-- --------------------------------------------------------

--
-- Table structure for table `phone_verifications`
--

CREATE TABLE `phone_verifications` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_services`
--

CREATE TABLE `products_services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `veterinaryId` varchar(255) NOT NULL,
  `medicalName` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `phone_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `phone_number`, `password`, `verified`, `phone_verified`, `created_at`, `full_name`, `address`, `dob`, `gender`, `user_image`, `status`) VALUES
(51, 'lemeryvets@gmail.com', '09297064431', '$2y$10$eqIV9EEB7/eynjhUJ8II8ucQRhBkjD8pXzP3v4B5CQ/5IcLfTd3R2', 1, 1, '2024-12-08 14:09:38', 'Olga Montenegro', 'Quiapo Manila', '2024-12-18', 'Male', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `veterinarians`
--

CREATE TABLE `veterinarians` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `dob` date NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `vet_license` varchar(255) DEFAULT NULL,
  `business_permit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'unverified',
  `vet_image` varchar(255) DEFAULT NULL,
  `stats` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinarians`
--

INSERT INTO `veterinarians` (`id`, `fullname`, `gender`, `dob`, `clinic_name`, `address`, `email`, `password`, `vet_license`, `business_permit`, `created_at`, `status`, `vet_image`, `stats`) VALUES
(5, 'Tanggol Dimaguiba Montenegro', 'Male', '2024-09-09', 'Don Facundo Clinic', 'Av. dos Andradas, 3000', 'lemeryvets@gmail.com', '$2y$10$iSjc3Gj18Iwqj.I.8AjzLuEOXvyWqdEL4vi1Tgn80OO1EjVUEPIUq', 'uploads/test 1.pdf', 'uploads/test 2.pdf', '2024-09-03 15:56:58', 'verified', 'uploads/vet_images/1727187237_djhbr36ifof71.jpg', 'active'),
(6, 'Joses Mari Chan', '', '0000-00-00', 'Jose Clinic', 'Av. dos Andradas, 3000', '', '', NULL, NULL, '2024-09-14 11:53:23', 'unverified', 'uploads/vet_images/1725541016_wallpaperflare.com_wallpaper.jpg', 'active'),
(7, 'Ding Dong Dantes', '', '0000-00-00', 'Majestic Veterinary Clinic', 'Av. dos Andradas, 3000', 'dingdong@gmail.com', '', NULL, NULL, '2024-09-14 11:54:42', 'unverified', 'uploads/vet_images/1725541016_wallpaperflare.com_wallpaper.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `veterinary_services`
--

CREATE TABLE `veterinary_services` (
  `id` int(11) NOT NULL,
  `veterinary_name` varchar(255) NOT NULL,
  `veterinary_description` text NOT NULL,
  `veterinary_price` decimal(10,2) NOT NULL,
  `veterinary_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `veterinary_id` int(11) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinary_services`
--

INSERT INTO `veterinary_services` (`id`, `veterinary_name`, `veterinary_description`, `veterinary_price`, `veterinary_image`, `created_at`, `veterinary_id`, `original_price`) VALUES
(2, 'loremss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor. ', 37.50, 'uploads/veterinary_services/pngegg (19).png', '2024-08-22 03:09:21', 5, 150.00),
(3, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor. ', 1211.00, 'uploads/veterinary_services/pngegg (19).png', '2024-08-22 03:10:28', 6, NULL),
(4, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ligula magna, consectetur a lorem sed, dignissim vulputate velit. Aliquam in congue enim, eu luctus lorem. Praesent placerat tristique porttitor.', 2332.00, 'uploads/veterinary_services/pngegg (18).png', '2024-08-22 13:27:24', 6, NULL),
(5, 'Lorem Ipsum Test', 'Nunc malesuada quis nisi non dignissim. Nam mi sem, venenatis vitae metus eu, fringilla placerat risus. Suspendisse vehicula neque sed nisl tempor, vel cursus mi vulputate. Morbi mollis cursus dictum. Nulla iaculis diam quis vehicula gravida. Aenean blandit mi et velit volutpat rutrum', 30.00, 'uploads/veterinary_services/pngegg (18).png', '2024-08-26 12:20:50', 5, 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `veterinary_services_percentage`
--

CREATE TABLE `veterinary_services_percentage` (
  `id` int(11) NOT NULL,
  `veterinary_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinary_services_percentage`
--

INSERT INTO `veterinary_services_percentage` (`id`, `veterinary_id`, `percentage`) VALUES
(1, 5, 70),
(2, 5, 0),
(3, 5, 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `canceled_appointments`
--
ALTER TABLE `canceled_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic_info`
--
ALTER TABLE `clinic_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `medical_products`
--
ALTER TABLE `medical_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_product_percentage`
--
ALTER TABLE `medical_product_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_products`
--
ALTER TABLE `pet_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_product_percentage`
--
ALTER TABLE `pet_product_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_number` (`phone_number`);

--
-- Indexes for table `products_services`
--
ALTER TABLE `products_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `veterinarians`
--
ALTER TABLE `veterinarians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `veterinary_services`
--
ALTER TABLE `veterinary_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veterinary_services_percentage`
--
ALTER TABLE `veterinary_services_percentage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `canceled_appointments`
--
ALTER TABLE `canceled_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `clinic_info`
--
ALTER TABLE `clinic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `medical_products`
--
ALTER TABLE `medical_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medical_product_percentage`
--
ALTER TABLE `medical_product_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pet_products`
--
ALTER TABLE `pet_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pet_product_percentage`
--
ALTER TABLE `pet_product_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `products_services`
--
ALTER TABLE `products_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `veterinarians`
--
ALTER TABLE `veterinarians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `veterinary_services`
--
ALTER TABLE `veterinary_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `veterinary_services_percentage`
--
ALTER TABLE `veterinary_services_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  ADD CONSTRAINT `phone_verifications_ibfk_1` FOREIGN KEY (`phone_number`) REFERENCES `users` (`phone_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
