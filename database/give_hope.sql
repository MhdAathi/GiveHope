-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 09:09 PM
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
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `goal` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
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

INSERT INTO `campaigns` (`id`, `user_id`, `title`, `location`, `description`, `goal`, `category`, `start_date`, `end_date`, `image`, `document`, `organizer_name`, `contact`, `email`, `created_at`, `status`, `raised`) VALUES
(1, NULL, 'Help Build a School', 'Negombo', 'We are raising funds to build a new school in Springfield to provide quality education to underprivileged children. Your support can make a difference!', 50000.00, 'Education', '2023-10-01', '2023-12-12', 'uploads\\1733566297_3924733_12633.jpg', NULL, 'Joe Doe', '+1 (555) 123-4567', 'johndoe@example.com', '2024-12-07 10:11:37', 'Accepted', 10000.00),
(2, NULL, 'Education for All', 'Colombo', 'Providing education resources for children.', 500000.00, 'Education', '2024-01-01', '2024-03-01', 'uploads/1733843040_blog-3.jpg', NULL, 'Mohamed Aathif', '0769183535', 'aathief01@gmail.com', '2024-12-10 15:04:00', 'Accepted', 1000.00),
(3, 2, 'Clean Water Initiative', 'Galle', 'Ensuring clean drinking water for villages.', 1000000.00, 'Environment', '2025-02-05', '2025-05-05', 'uploads/1733843266_slide-2.jpg', NULL, 'Jane Smith', '07714572157', 'janesmith@example.com', '2024-12-10 15:07:46', 'Accepted', 6000.00),
(4, NULL, 'Emergency Health Support', 'Kandy', 'Supporting emergency health services.', 750000.00, 'Health', '2025-03-05', '2025-08-05', 'uploads/1733843483_about.jpg', NULL, 'Mark Johnson', '0778413114', 'markjohnson@example.com', '2024-12-10 15:11:23', 'Accepted', 750000.00),
(5, NULL, 'Medical Aid for the Uninsured', 'Kandy', 'Support our mission to provide medical assistance to uninsured families. Donations will be used to cover basic check-ups, emergency care, and medications for those in need.', 25000.00, 'Health', '2025-01-15', '2025-04-10', 'uploads/1734163032_WhatsApp Image 2024-12-13 at 23.03.30_808ac906.jpg', NULL, 'Jane Smith', '+1-555-987-6543', 'jane.smith@example.com', '2024-12-14 07:57:12', 'Accepted', 0.00),
(6, NULL, 'Help Build a Library', 'Colombo, Sri Lanka', 'We aim to build a community library in Colombo to support underprivileged students with free access to books and learning materials. Your contributions will go towards construction, furniture, and stocking the library with books', 500000.00, 'Education', '2024-12-25', '2025-02-15', 'uploads/1734181547_blog-inside-post.jpg', 'uploads/1734181547_doc_Campaign-Planning-Templates-2023.pdf', 'Mohamed  Raazim', '0776754323', 'raazimramzan@gmail.com', '2024-12-14 13:05:47', 'Accepted', 0.00),
(7, NULL, 'Medical Aid for the Uninsured', 'Galle', 'Providing essential medical aid to uninsured families in rural areas of Galle. The funds will be used to purchase medicines, conduct medical camps, and support local healthcare initiatives.', 60000.00, 'Health', '2025-01-25', '2025-03-25', 'uploads/1734289697_about.jpg', 'uploads/1734289697_doc_Ahamed Asrak Mohamed Aathif- Software Engineer Intern.pdf.pdf', 'Nimal Perera', '077 123 4567', 'nimal.perera@example.com', '2024-12-15 19:08:17', 'Accepted', 0.00),
(8, 2, 'Clean Drinking Water for Rural Villages', 'Anuradhapura', 'This campaign aims to provide clean and safe drinking water to underserved villages in Anuradhapura. Funds will be used to install water purification systems and wells to ensure access to clean water.', 750000.00, 'Environment', '2025-02-15', '2025-02-15', 'uploads/1734290330_slide1.jpg', 'uploads/1734290330_doc_AhamedAsrakMohamedAathifSoftwareEngineerIntern.pdf.pdf', 'Kavindu  Fernando', '076 345 6789', 'kavindu.fernando@example.com', '2024-12-15 19:18:50', 'Accepted', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `donor_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `card_security_code` varchar(50) DEFAULT NULL,
  `card_expiration_month` varchar(2) DEFAULT NULL,
  `card_expiration_year` varchar(4) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `campaign_id`, `donor_name`, `email`, `phone`, `address`, `amount`, `payment_type`, `card_number`, `card_security_code`, `card_expiration_month`, `card_expiration_year`, `paypal_email`, `donation_date`) VALUES
(6, 1, 'aaar', 'Mhdaathi124@gmail.com', '0769183535', '34/A,danagama,mawanella', 0.00, 'credit_card', '1212 1212 1212 1211', '212', '08', '2023', '', '2024-12-13 16:11:56'),
(7, 1, 'aaar', 'Mhdaathi124@gmail.com', '0769183535', '34/A,danagama,mawanella', 0.00, 'credit_card', '1212 1212 1212 1211', '212', '08', '2023', '', '2024-12-13 16:21:10'),
(14, 2, 'aathif', 'aathi@gmail.com', '0769183535', '34/A,danagama,mawanella', 1000.00, 'credit_card', '2121 2121 2121 2121', '212', '08', '2024', '', '2024-12-14 07:39:59'),
(16, 3, 'aadhil', 'aadhilm@gmail.com', '0769183535', '34/A,danagama,mawanella', 5000.00, 'credit_card', '2121 1212 1212 1212', '212', '06', '2025', NULL, '2024-12-14 07:44:55'),
(17, 1, 'mohamed', 'MohamedArshak48@gmail.com', '0769183535', '34/A, Danagama Mawanella Danagama', 10000.00, 'credit_card', '2121 2112 1121 2121', '212', '09', '2026', NULL, '2024-12-14 07:52:11'),
(18, 3, 'rahmath', 'ramath@gmail.com', '0769183535', '34/A, Danagama Mawanella Danagama', 1000.00, 'credit_card', '2121 2121 1212 1212', '123', '08', '2023', NULL, '2024-12-15 15:46:38');

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
(2, 'Mhd Arshak', 'MohamedArshak48@gmail.com', '111', 0, '2024-12-10 18:19:40'),
(3, 'Atheek', 'atheek@gmail.com', '111', 0, '2024-12-16 00:41:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
