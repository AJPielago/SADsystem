-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 01:56 PM
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
-- Database: `saddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_name`, `latitude`, `longitude`) VALUES
(1, 'Building A', 14.55610000, 121.02340000),
(2, 'Building B', 14.55820000, 121.02450000),
(3, 'Building C', 14.55930000, 121.02560000),
(4, 'Grand Hyatt Manila', 14.55672800, 121.05409600),
(5, 'SM Aura Premier', 14.54982000, 121.05697000),
(6, 'Uptown Mall', 14.55460000, 121.05420000),
(7, 'New High Street Tower', 14.55220000, 121.04950000);

-- --------------------------------------------------------

--
-- Table structure for table `collectionroutes`
--

CREATE TABLE `collectionroutes` (
  `route_id` int(11) NOT NULL,
  `assigned_truck` varchar(255) DEFAULT NULL,
  `optimized_path` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_description` text NOT NULL,
  `status` enum('available','claimed') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `feedback_message`, `submitted_at`) VALUES
(1, 8, 'mic check', '2025-03-10 15:35:56'),
(2, 8, 'nyare boss', '2025-03-10 15:36:20'),
(3, 8, 'isa pa', '2025-03-10 15:37:57'),
(4, 8, 'try ulit', '2025-03-10 15:40:06'),
(5, 8, 'try ulit', '2025-03-10 15:40:08'),
(6, 8, 'try ulit', '2025-03-10 15:41:25'),
(7, 8, 'aadasaf', '2025-03-10 15:57:06'),
(8, 8, 'acxvad', '2025-03-10 15:57:54'),
(9, 8, 'aadfad', '2025-03-10 15:58:44'),
(10, 8, 'adfgdg', '2025-03-10 16:02:28'),
(11, 8, 'agafshsfaet', '2025-03-10 16:05:02'),
(12, 8, 'safaefaefaetrag', '2025-03-10 16:09:44'),
(13, 8, 'afadv', '2025-03-10 16:10:36'),
(14, 8, 'tanginaaaaaa', '2025-03-10 16:10:50'),
(15, 8, 'adgadgafgasbsfv', '2025-03-10 16:14:54'),
(16, 8, 'dagdfs', '2025-03-11 02:07:48'),
(17, 8, 'adgfascbsardtafaretawgraj', '2025-03-11 02:09:22'),
(18, 8, 'afafafafaf', '2025-03-11 02:09:32'),
(19, 8, 'advasdgagfs', '2025-03-11 02:12:51'),
(20, 8, 'dfgadga', '2025-03-11 02:16:34'),
(21, 8, 'agag', '2025-03-11 02:21:57'),
(22, 8, 'azgfadgsfrhfds', '2025-03-11 02:23:29'),
(23, 8, 'agftasgsghsrf', '2025-03-11 10:09:29'),
(24, 8, 'jryfujifhdghdfj', '2025-03-11 11:42:55'),
(25, 8, 'sgasfgaradgart', '2025-03-11 11:44:19'),
(26, 8, 'asgbfshsfgadfgtas', '2025-03-11 11:45:12'),
(28, 15, 'Test Feedback', '2025-03-20 11:23:47'),
(29, 13, 'asfadfg', '2025-03-20 11:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `issue_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('open','in_progress','resolved') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`issue_id`, `user_id`, `description`, `photo_url`, `location`, `status`, `created_at`) VALUES
(1, 8, 'asfdad', NULL, '', '', '2025-03-08 08:59:06'),
(2, 8, 'qwreqwtr', 'uploads/1741426663_480791559_1160907325635555_4843043564405451618_n.jpg', '', '', '2025-03-08 09:37:43'),
(3, 8, 'qwreqwtr', 'uploads/1741426778_480791559_1160907325635555_4843043564405451618_n.jpg', '', '', '2025-03-08 09:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickuprequests`
--

CREATE TABLE `pickuprequests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','completed','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `building` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pickuprequests`
--

INSERT INTO `pickuprequests` (`request_id`, `user_id`, `status`, `created_at`, `building`, `latitude`, `longitude`) VALUES
(1, 16, 'approved', '2025-03-19 06:53:05', 'Grand Hyatt Manila', 14.55672800, 121.05409600),
(2, 17, 'approved', '2025-03-19 06:53:38', 'SM Aura Premier', 14.54982000, 121.05697000),
(3, 18, 'approved', '2025-03-19 06:56:02', 'Uptown Mall', 14.55460000, 121.05420000),
(4, 19, 'approved', '2025-03-19 07:22:45', 'New High Street Tower', 14.55220000, 121.04950000);

-- --------------------------------------------------------

--
-- Table structure for table `pickup_schedules`
--

CREATE TABLE `pickup_schedules` (
  `schedule_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `collection_time` time DEFAULT '07:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recyclingcenters`
--

CREATE TABLE `recyclingcenters` (
  `center_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `accepted_materials` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rescheduled_pickups`
--

CREATE TABLE `rescheduled_pickups` (
  `reschedule_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `reschedule_status` enum('Pending','Approved','Denied') DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `old_schedule_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `new_schedule_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedule_requests`
--

CREATE TABLE `reschedule_requests` (
  `reschedule_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Denied') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `reward_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `points_used` int(11) DEFAULT NULL,
  `reward_description` text NOT NULL,
  `redeemed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`reward_id`, `user_id`, `points_used`, `reward_description`, `redeemed_at`) VALUES
(1, 8, 15, 'Eco-Friendly Tote Bag', '2025-03-10 12:29:54'),
(2, 8, 15, 'Eco-Friendly Tote Bag', '2025-03-10 12:30:56'),
(3, 8, 15, 'Eco-Friendly Tote Bag', '2025-03-10 12:33:16'),
(4, 8, 15, 'Eco-Friendly Tote Bag', '2025-03-10 12:34:08'),
(5, 8, 15, 'Eco-Friendly Tote Bag', '2025-03-10 12:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `rewards_info`
--

CREATE TABLE `rewards_info` (
  `reward_id` int(11) NOT NULL,
  `reward_name` varchar(255) NOT NULL,
  `points_required` int(11) NOT NULL,
  `reward_description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards_info`
--

INSERT INTO `rewards_info` (`reward_id`, `reward_name`, `points_required`, `reward_description`, `image`) VALUES
(1, 'Eco-Friendly Tote Bag', 15, 'A reusable eco-friendly tote bag for your daily needs.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `role` enum('resident','admin','collector') DEFAULT 'resident',
  `building` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone_number`, `points`, `role`, `building`) VALUES
(1, 'paul', 'paulrainiel01@gmail.com', '$2y$10$Pc9UyBXrUlftbEq5YoFC5uJ2mIRSa8SEG1a6GZrNVB3erv0RMV8fu', '09770035933', 0, 'admin', ''),
(2, 'patrick', 'patrickrainielsyparrado@gmail.com', '$2y$10$3rMs1N8EF3J0NG35dDRb7eE948dg80Jy8Did6LMqb78qqquxsoU92', '09770035933', 0, 'resident', ''),
(3, 'Decibol', 'deci@gmail', '$2y$10$STOJtXHlt2mzNwI56sJ62ulbDmH6BOLpy1OW3f9rfIszw8pfU5z0.', '0937764257', 0, 'collector', ''),
(4, 'Test Accounts Edit', 'testacc@gmail.com', '$2y$10$YLIk28aY6lcgaGh1zSCjRu6ZO2HMj5qdDT/a0MgyvQsY6/M3Sx6Bu', '0912345', 0, 'resident', ''),
(5, 'AlexJoyous', 'alex@gmail.com', '$2y$10$G0r.kL56g4Os9AxHz7URiOkbvBVI6lJxOE6GA8E6yikUQQgo2WqiK', '09122196781', 0, 'admin', ''),
(6, 'alexx', 'alexx@gmail.com', '$2y$10$4hr9nUAmt9ta9a0iz5y.feaXpdhLX7mh/mc07YE542CtWLN62b9iy', '091222916781', 0, 'admin', ''),
(7, 'alexxx', 'alexxx@gmail.com', '$2y$10$vMBI4Hr2Yq5eEYkcziIf7.i9g72hDwaDWaDuQVlW58LATvTy6/JuG', '0923409823085', 0, 'admin', ''),
(8, 'adi', 'adi@gmail.com', '$2y$10$TA7chBPRx64cFiqySHkikOkbY6ZXAsCq.pOvjEF3xJvT1vaGT/bXi', '0904582', 0, 'resident', ''),
(9, 'enzo', 'enzo@gmail.com', '$2y$10$PqKcB6wupZcLQDvQGVemNuIuE/2cQt.H6tO8i17YruEoEa7ulfcuu', '0946535', 0, 'collector', ''),
(10, 'aga', 'aga@gmail.com', '$2y$10$rCKxeHT9.0hOBt.rea2.l.tWGy3aD..46CFWlNKRDx2dLwcagVG1u', '6474685798', 0, 'collector', ''),
(11, 'user', 'user@gmail.com', '$2y$10$eSZPgUChdn4qKWBvug7oL.Tai9y2TghxhaS7xve8geMRa40/yWumW', '0954252415', 0, 'resident', ''),
(12, 'user3', 'user3@gmail.com', '$2y$10$Oo4imMeiQk3xm/4f2qYRJu.nUrhhuugFlXfxWh6P4j98Kudmj1Md6', '4363653635', 0, 'resident', ''),
(13, 'test', 'test@gmail.com', '$2y$10$2m4vYndvL3eugxNTd29n7OhgedNrumAp4z/iSC4DO9JuS7eaN6qr.', '563463', 0, 'resident', ''),
(15, 'rat', 'rat@gmail.com', '$2y$10$rpdKC4akI0UTFkPW8Sa0bOOqHbNMXcGC84sNxWSDTia4cmBWcImjO', '24235425', 0, 'resident', 'Building C'),
(16, 'bat', 'bat@gmail.com', '$2y$10$Bvah/AcZNLiBGClb.bNmRuk5Cgwfr0Ryi3ufVpA8wj1E.yJWg57l6', '563563', 0, 'resident', 'Grand Hyatt Manila'),
(17, 'dog', 'dog@gmail.com', '$2y$10$BcbKE0.tsl4mynesQnxHo.qP3oeNF.gKa1hwwrLeEWILnLMPMoURu', '14135426524', 0, 'resident', 'SM Aura Premier'),
(18, 'cat', 'cat@gmail.com', '$2y$10$g3pAUUc132pro0Jb6u.ZSOj6oZqXpqfhFJAa1ZM1ynztsFLB11npa', '32542653245', 0, 'resident', 'Uptown Mall'),
(19, 'baby', 'baby@gmail.com', '$2y$10$jljRcd3Fpo7UBtJUIB9CoOIHsm3e3eLa8aRwZh.RenCTySYo4v.yy', '57845746', 0, 'resident', 'New High Street Tower');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `collectionroutes`
--
ALTER TABLE `collectionroutes`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pickuprequests`
--
ALTER TABLE `pickuprequests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `pickuprequests_ibfk_2` (`user_id`);

--
-- Indexes for table `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `recyclingcenters`
--
ALTER TABLE `recyclingcenters`
  ADD PRIMARY KEY (`center_id`);

--
-- Indexes for table `rescheduled_pickups`
--
ALTER TABLE `rescheduled_pickups`
  ADD PRIMARY KEY (`reschedule_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD PRIMARY KEY (`reschedule_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`reward_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rewards_info`
--
ALTER TABLE `rewards_info`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collectionroutes`
--
ALTER TABLE `collectionroutes`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickuprequests`
--
ALTER TABLE `pickuprequests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `recyclingcenters`
--
ALTER TABLE `recyclingcenters`
  MODIFY `center_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rescheduled_pickups`
--
ALTER TABLE `rescheduled_pickups`
  MODIFY `reschedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  MODIFY `reschedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rewards_info`
--
ALTER TABLE `rewards_info`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `pickuprequests`
--
ALTER TABLE `pickuprequests`
  ADD CONSTRAINT `pickuprequests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `pickuprequests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_schedules`
--
ALTER TABLE `pickup_schedules`
  ADD CONSTRAINT `pickup_schedules_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `pickuprequests` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `rescheduled_pickups`
--
ALTER TABLE `rescheduled_pickups`
  ADD CONSTRAINT `rescheduled_pickups_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `pickuprequests` (`request_id`),
  ADD CONSTRAINT `rescheduled_pickups_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `pickup_schedules` (`schedule_id`),
  ADD CONSTRAINT `rescheduled_pickups_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD CONSTRAINT `reschedule_requests_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `pickup_schedules` (`schedule_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reschedule_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
