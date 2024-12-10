-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:44 PM
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
-- Database: `give_hope`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `goal` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `organizer_name` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `raised` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `location`, `description`, `goal`, `category`, `start_date`, `end_date`, `image`, `organizer_name`, `contact`, `email`, `created_at`, `status`, `raised`) VALUES
(1, 'Help Build a School', 'Springfield, USA', 'We are raising funds to build a new school in Springfield to provide quality education to underprivileged children. Your support can make a difference!', 50000.00, 'Education', '2023-10-01', '2023-12-12', 'uploads/1733566297_3924733_12633.jpg', 'Joe Doe', '+1 (555) 123-4567', 'johndoe@example.com', '2024-12-07 10:11:37', 'Accepted', 0.00),
(2, 'Education for All', 'Colombo', 'Providing education resources for children.', 500000.00, 'Education', '2024-01-01', '2024-03-01', 'uploads/1733843040_blog-3.jpg', 'Mohamed Aathif', '0769183535', 'aathief01@gmail.com', '2024-12-10 15:04:00', 'Accepted', 0.00),
(3, 'Clean Water Initiative', 'Galle', 'Ensuring clean drinking water for villages.', 1000000.00, 'Environment', '2025-02-05', '2025-05-05', 'uploads/1733843266_slide-2.jpg', 'Jane Smith', '07714572157', 'janesmith@example.com', '2024-12-10 15:07:46', 'Accepted', 0.00),
(4, 'Emergency Health Support', 'Kandy', 'Supporting emergency health services.', 750000.00, 'Health', '2025-03-05', '2025-08-05', 'uploads/1733843483_about.jpg', 'Mark Johnson', '0778413114', 'markjohnson@example.com', '2024-12-10 15:11:23', 'Accepted', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=user, 1=admin, 2=superadmin',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_as`, `created_at`) VALUES
(1, 'Mhd Aathif', 'Mhdaathi124@gmail.com', '111', 1, '2024-12-06 15:42:55'),
(2, 'Mhd Arshak', 'MohamedArshak48@gmail.com', '111', 0, '2024-12-10 18:19:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
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
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
