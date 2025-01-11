-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 07:02 AM
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
(1, 3, 'Help Build a School', 'Negombo', 'We are raising funds to build a new school in Springfield to provide quality education to underprivileged children. Your support can make a difference!', 50000.00, 'Education', '2023-10-01', '2023-12-12', '..\\uploads\\school.jpg', '../uploads/1734625834_doc_document.jpeg', 'Atheek', '0781234567', 'atheek@gmail.com', '2024-12-07 10:11:37', 'Accepted', 10000.00),
(2, 3, 'Education for All', 'Colombo', 'Providing education resources for children.', 500000.00, 'Education', '2024-01-01', '2024-03-01', '../uploads/1733843040_blog-3.jpg', '../uploads/1734625834_doc_document.jpeg', 'Atheek', '0781234567', 'atheek@gmail.com', '2024-12-10 15:04:00', 'Accepted', 187000.00),
(3, 2, 'Clean Water Initiative', 'Galle', 'Ensuring clean drinking water for villages.', 1000000.00, 'Environment', '2025-02-05', '2025-05-05', '../uploads/1733843266_slide-2.jpg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Arshak', '0772111464', 'MohamedArshak48@gmail.com', '2024-12-10 15:07:46', 'Accepted', 6000.00),
(4, 4, 'Emergency Health Support', 'Kandy', 'Supporting emergency health services.', 750000.00, 'Health', '2025-03-05', '2025-08-05', '../uploads/1733843483_about.jpg', '../uploads/1734625834_doc_document.jpeg', 'Fathima', '0771234567', 'fathi@gmail.com', '2024-12-10 15:11:23', 'Accepted', 750000.00),
(5, 4, 'Medical Aid for the Uninsured', 'Kandy', 'Support our mission to provide medical assistance to uninsured families. Donations will be used to cover basic check-ups, emergency care, and medications for those in need.', 25000.00, 'Health', '2025-01-15', '2025-04-10', '../uploads/1734163032_WhatsApp Image 2024-12-13 at 23.03.30_808ac906.jpg', '../uploads/1734625834_doc_document.jpeg', 'Fathima', '0771234567', 'fathi@gmail.com', '2024-12-14 07:57:12', 'Accepted', 0.00),
(7, 3, 'Save The Sea Turtles', 'Galle', 'Protecting sea turtles and preserving their habitats in Galle.', 60000.00, 'Health', '2025-01-25', '2025-03-25', '../uploads/1734289697_about.jpg', '../uploads/1734625834_doc_document.jpeg', 'Atheek', '0781234567', 'atheek@gmail.com', '2024-12-15 19:08:17', 'Accepted', 0.00),
(8, 2, 'Clean Drinking Water for Rural Villages', 'Anuradhapura', 'This campaign aims to provide clean and safe drinking water to underserved villages in Anuradhapura. Funds will be used to install water purification systems and wells to ensure access to clean water.', 750000.00, 'Environment', '2025-02-15', '2025-02-15', '../uploads/1734290330_slide1.jpg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Arshak', '0772111464', 'MohamedArshak48@gmail.com', '2024-12-15 19:18:50', 'Accepted', 0.00),
(9, 3, 'Save The Sea Turtles Sri Lanka', 'Galle, Sri Lanka', 'Join us in our mission to protect and conserve sea turtles in Sri Lanka by ensuring a safe habitat for them.', 500000.00, 'Environment', '2025-01-10', '2025-03-20', '../uploads/1734339176_turtle.jpeg', '../uploads/1734625834_doc_document.jpeg', 'Atheek', '0781234567', 'atheek@gmail.com', '2024-12-16 08:52:56', 'Accepted', 28000.00),
(10, 2, 'Treatment Fund for Children', 'Colombo, Sri Lanka', 'Raising funds for medical treatment and care for children diagnosed with cancer at Apeksha Hospital in Maharagama.', 500000.00, 'Health', '2025-02-05', '2025-05-05', '../uploads/1734356728_image_children.jpeg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Arshak', '0772111464', 'MohamedArshak48@gmail.com', '2024-12-16 13:45:28', 'Rejected', 0.00),
(11, 2, 'Rebuild Homes for Flood Victims in Gampaha', 'Gampaha District, Sri Lanka', 'Providing shelter and essential resources for families affected by severe floods in Gampaha, Sri Lanka.', 500000.00, 'Disaster Relief', '2025-02-03', '2025-04-03', '../uploads/1734357934_flood.jpeg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Arshak', '0772111464', 'MohamedArshak48@gmail.com', '2024-12-16 14:05:34', 'Rejected', 0.00),
(13, 3, 'Clean Drinking Water Project', 'Monaragala District, Sri Lanka', 'Providing clean and safe drinking water to rural families in Monaragala District, Sri Lanka.', 500000.00, 'Environment', '2024-12-25', '2025-03-25', '../uploads/1734364609_cleanwater.jpg', '../uploads/1734625834_doc_document.jpeg', 'Atheek', '0781234567', 'atheek@gmail.com', '2024-12-16 15:56:49', 'Rejected', 10000.00),
(14, 1, 'Digital Learning for Schools', 'Badulla District', 'This campaign focuses on bridging the digital divide in rural schools by providing laptops, projectors, and internet connectivity. Empowering students with modern learning tools will improve their access to quality education and opportunities.', 500000.00, 'Education', '2025-01-20', '2025-02-20', '../uploads/digital_learning.jpg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Aathif', '0769183535', 'Mhdathi124@gmail.com', '2024-12-16 16:04:09', 'Accepted', 0.00),
(15, 6, 'Help Build a School', 'Mawanella, Srilanka', 'Providing education resources for children.', 750000.00, 'Education', '2025-01-15', '2025-03-25', '../uploads/1734516061_school.jpeg', '../uploads/1734625834_doc_document.jpeg', 'Mohamed Afras', '0775846789', 'Mhdappu@gmail.com', '2024-12-18 10:01:02', 'Rejected', 0.00),
(16, 7, 'Help Hidden Leaf Rebuild', 'Konoha (Hidden Leaf Village)', 'The Hidden Leaf Village has suffered massive destruction during recent battles. This campaign aims to rebuild our beloved village, provide support to the ninja families, and restore our vibrant community. Every donation counts toward the future of Konoha!', 100000.00, 'Disaster Relief', '2025-01-25', '2025-03-25', '../uploads/1734625089_naruto.jpeg', '../uploads/1734625834_doc_document.jpeg', 'Itachi Uchiha', '0771234567', 'itachiuchiha@gmail.com', '2024-12-19 16:18:09', 'Rejected', 5000.00),
(18, 7, 'Homes for Flood Victims', 'Colombo, Sri Lanka', 'Providing shelter and basic necessities to families affected by floods in Colombo, Sri Lanka.', 15000.00, 'Health', '2025-01-17', '2024-12-11', '../uploads/1734625834_cleanwater.jpg', '../uploads/1734625834_doc_document.jpeg', 'Itachi Uchiha', '0771234567', 'itachiuchiha@gmail.com', '2024-12-19 16:30:34', 'Accepted', 0.00);

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
  `province` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `location` varchar(200) GENERATED ALWAYS AS (concat(`province`,', ',`district`)) STORED,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `campaign_id`, `donor_name`, `email`, `phone`, `address`, `province`, `district`, `amount`, `payment_type`, `donation_date`) VALUES
(1, 1, 'Aarav Perera', 'aarav.perera@gmail.com', '0778123456', '34/A, Danagama, Mawanella', 'Sabaragamuwa', 'Kegalle', 1000.00, 'credit_card', '2024-12-13 16:11:56'),
(2, 1, 'Asiri Fernando', 'asiri.fernando@gmail.com', '0779456789', '45/B, Peradeniya Road, Kandy', 'Central', 'Kandy', 3500.00, 'credit_card', '2024-12-13 16:21:10'),
(3, 2, 'Aadhil Mohamed', 'aadhil.mohamed@gmail.com', '0781234567', '23/A, Gampola, Sri Lanka', 'Central', 'Kandy', 1000.00, 'credit_card', '2024-12-14 07:39:59'),
(4, 3, 'Mohamed Arshak', 'aadhilm@gmail.com', '0779145678', '34/A, Danagama, Mawanella', 'Sabaragamuwa', 'Kegalle', 5000.00, 'credit_card', '2024-12-14 07:44:55'),
(5, 1, 'Rahmath Nazeer', 'rahmath.nazeer@gmail.com', '0778312456', '78/C, Kurunegala Road, Mawanella', 'Sabaragamuwa', 'Kegalle', 10000.00, 'credit_card', '2024-12-14 07:52:11'),
(6, 3, 'Irfan Wickramasinghe', 'ramath@gmail.com', '0769123456', '12 Main Street, Hatton, Sri Lanka', 'Sabaragamuwa', 'Kegalle', 1000.00, 'credit_card', '2024-12-15 15:46:38'),
(7, 2, 'Ijan Silva', 'ijansilva@gmail.com', '0789456789', '65/E, Galle Road, Colombo', 'Western', 'Colombo', 5000.00, 'credit_card', '2024-12-16 15:07:33'),
(8, 9, 'Itachi Uchiha', 'itachi.uchiha@gmail.com', '0775123456', '12 Main Street, Hatton, Sri Lanka', 'Central', 'Nuwara Eliya', 20000.00, 'credit_card', '2024-12-16 15:21:32'),
(9, 2, 'J.B. Michael', 'Mhdaathi124@gmail.com', '0776123456', 'Tumbana, Hatharaliyadda, Rambukkana', 'Sabaragamuwa', 'Kegalle', 5000.00, 'credit_card', '2024-12-17 15:06:43'),
(10, 2, 'Ijlan', 'clownnobody9@gmail.com', '0771234568', 'Tumbana,hathariyaladda,rambukkana', 'Western', 'Colombo', 1000.00, 'credit_card', '2024-12-17 17:02:40'),
(11, 9, 'Mohammed Aathif', 'Mhdaathi124@gmail.com', '0769183535', '34/A, Danagama Mawanella Danagama', 'Sabaragamuwa', 'Kegalle', 1000.00, 'paypal', '2024-12-17 17:25:05'),
(12, 16, 'Itachi Uchiha', 'itachi.uchiha@gmail.com', '0775123456', '12 Main Street, Hatton, Sri Lanka', 'Central', 'Nuwara Eliya', 5000.00, 'credit_card', '2024-12-19 16:45:08'),
(13, 2, 'Arshak', 'arshak.unique@gmail.com', '0778211464', '34/A, New Town, Mawanella', 'Sabaragamuwa', 'Kegalle', 5000.00, 'credit_card', '2025-01-10 16:24:12'),
(14, 2, 'Arshak', 'MohamedArshak48@gmail.com', '0769183535', '34/A,danagama,mawanella', 'Sabaragamuwa', 'Kegalle', 5000.00, 'credit_card', '2025-01-10 16:42:32'),
(15, 2, 'JB Micheal', 'lothbrok1311@gmail.com', '0775481674', '12 main street, hatton, srilanka', 'Central', 'Nuwara Eliya', 5000.00, 'credit_card', '2025-01-10 16:48:14'),
(16, 2, 'JB Micheal', 'lothbrok1311@gmail.com', '0775481674', '12 main street, hatton, srilanka', 'Central', 'Nuwara Eliya', 5000.00, 'credit_card', '2025-01-10 16:58:02'),
(17, 2, 'JB Micheal', 'lothbrok1311@gmail.com', '0775481674', '12 main street, hatton, srilanka', 'Central', 'Nuwara Eliya', 5000.00, 'credit_card', '2025-01-10 17:04:10'),
(18, 2, 'JB Micheal', 'lothbrok1311@gmail.com', '0775481674', '12 main street, hatton, srilanka', 'Central', 'Nuwara Eliya', 150000.00, 'credit_card', '2025-01-10 17:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`, `created_at`) VALUES
(1, 'Mohammed Aathif', 'Mhdaathi124@gmail.com', 'User Friendly System!:)', '2024-12-19 15:10:53'),
(2, 'Naruto Uzumaki', 'naruto.uzumaki@example.com', 'This platform is as awesome as my Rasengan! Believe it!', '2024-12-20 11:30:05'),
(3, 'Sasuke Uchiha', 'sasuke.uchiha@example.com', 'Efficient but could use more power... like a Chidori strike.', '2024-12-20 11:30:05'),
(4, 'Sakura Haruno', 'sakura.haruno@example.com', 'The user interface is great, but it could use a healing touch in a few areas.', '2024-12-20 11:30:05'),
(5, 'Kakashi Hatake', 'kakashi.hatake@example.com', 'The platform is as versatile as my Sharingan. Great job!', '2024-12-20 11:30:05'),
(6, 'Shikamaru Nara', 'shikamaru.nara@example.com', 'Pretty solid platform. It’s not troublesome at all to use.', '2024-12-20 11:30:05'),
(7, 'Hinata Hyuga', 'hinata.hyuga@example.com', 'This platform gave me the courage to contribute and help others. Thank you.', '2024-12-20 11:30:05'),
(8, 'Gaara of the Sand', 'gaara.sand@example.com', 'Helping others is my new purpose, and this platform supports that perfectly.', '2024-12-20 11:30:05'),
(9, 'Rock Lee', 'rock.lee@example.com', 'Hard work pays off, and this platform is a great example of that!', '2024-12-20 11:30:05'),
(10, 'Tsunade Senju', 'tsunade.senju@example.com', 'The financial transparency here is commendable. Keep it up!', '2024-12-20 11:30:05'),
(11, 'Jiraiya', 'jiraiya.example@example.com', 'Great work! This platform connects people, just like my stories do.', '2024-12-20 11:30:05'),
(12, 'Aathif', 'Mhdaathi124@gmail.com', 'Good!\r\n', '2025-01-09 16:31:05'),
(13, 'Mohamed Raazim', 'razimramsan01@gmail.com', 'Not Bad!', '2025-01-11 05:33:07'),
(14, 'Mohamed Arshak', 'MohamedArshak48@gmail.com', 'Perfect!', '2025-01-11 05:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=user, 1=admin',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_as`, `created_at`) VALUES
(1, 'Mhd Aathif', 'Mhdaathi124@gmail.com', 'Aathif1.', 1, '2024-12-06 15:42:55'),
(2, 'Mhd Arshak', 'MohamedArshak48@gmail.com', 'Arshak2003.', 0, '2024-12-10 18:19:40'),
(3, 'Atheek', 'atheek@gmail.com', '111', 0, '2024-12-16 00:41:10'),
(4, 'Fathima', 'fathi@gmail.com', '111', 0, '2024-12-16 14:47:06'),
(5, 'Mohamed Ijlan', 'clownnobody9@gmail.com', 'Ijlan2002@', 0, '2024-12-17 22:09:21'),
(6, 'Mohamed Afras', 'Mhdappu@gmail.com', 'Appu2000.', 0, '2024-12-17 22:11:43'),
(7, 'Itachi Uchiha', 'itachiuchiha@gmail.com', 'Itachi123.', 0, '2024-12-19 21:33:48');

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
