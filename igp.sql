-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 02:08 PM
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
-- Database: `igp`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(255) NOT NULL,
  `billing_stall` int(255) NOT NULL,
  `rent_bal` varchar(150) NOT NULL,
  `water_bal` varchar(150) NOT NULL,
  `electricity_bal` varchar(150) NOT NULL,
  `other_bal` varchar(150) NOT NULL,
  `amount` varchar(150) NOT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `date_filed` datetime NOT NULL DEFAULT current_timestamp(),
  `billing_note` text DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `c_receipt` varchar(255) DEFAULT NULL,
  `date_pay` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `billing_stall`, `rent_bal`, `water_bal`, `electricity_bal`, `other_bal`, `amount`, `amount_paid`, `date_filed`, `billing_note`, `status`, `c_receipt`, `date_pay`) VALUES
(1, 1, '1234', '1234', '1234', '1234', '4936', '4000', '2023-12-04 10:31:33', '', '1', '020420240332.jpg', '2024-01-04'),
(2, 1, '1234', '1234', '1234', '1234', '4936', '4936', '2024-01-04 10:37:48', '', '1', '020420240408.jpg', '2024-02-04');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `emp_type` enum('part-time','regular','','') NOT NULL,
  `department` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `first_name`, `middle`, `last_name`, `emp_type`, `department`, `datetime`) VALUES
(1, 'Aljon', 'L', 'Abines', 'regular', 'Engineering', '2024-01-16 12:25:29'),
(2, 'Jude Michael', '', 'Badajos', 'regular', 'Engineering', '2024-01-16 12:26:18'),
(3, 'Greg', 'S', 'Campos', 'regular', 'Engineering', '2024-01-16 12:26:32'),
(4, 'Catherine', 'B', 'Catindoy', 'regular', 'Engineering', '2024-01-16 12:26:43'),
(5, 'Samuel', 'S', 'Sudario', 'regular', 'Engineering', '2024-01-16 12:26:54'),
(6, 'John Paul', '', 'Villanueva', 'regular', 'Engineering', '2024-01-16 12:27:57'),
(7, 'Jasten Keneth', 'D', 'Treceñe', 'regular', 'Engineering', '2024-01-16 12:28:17'),
(8, 'Marites', 'M', 'Bardelas', 'regular', 'Engineering', '2024-01-16 12:28:37'),
(9, 'Michael', 'B', 'Batan', 'regular', 'Engineering', '2024-01-16 12:28:46'),
(10, 'Ira Gem', 'A', 'Albasin-Lacaba', 'regular', 'Education', '2024-01-16 12:29:39'),
(11, 'Medeliza', 'P', 'Avenir', 'regular', 'Education', '2024-01-16 12:29:57'),
(12, 'Mary Ann', 'A', 'Balagasay', 'regular', 'Education', '2024-01-16 12:30:10'),
(13, 'Belinda', 'R', 'Basas', 'regular', 'Education', '2024-01-16 12:30:21'),
(14, 'Sofio Rocky', 'T', 'Caminoc', 'regular', 'Education', '2024-01-16 12:30:50'),
(15, 'Joseph', '', 'Cervantes', 'regular', 'Education', '2024-01-16 12:31:07'),
(16, 'Eduardo Edu', 'C', 'Cornillez, Jr.', 'regular', 'Education', '2024-01-16 12:31:30'),
(17, 'Emelita', 'Y', 'Eguillos', 'regular', 'Education', '2024-01-16 12:31:43'),
(18, 'Ma. Chona', '', 'Fabre', 'regular', 'Education', '2024-01-16 12:31:56'),
(19, 'Ramelito', 'R', 'Paler', 'regular', 'Education', '2024-01-16 12:32:09'),
(20, 'Teodora', 'S', 'Picson', 'regular', 'Education', '2024-01-16 12:32:22'),
(21, 'Jerome', 'S', 'Tilana', 'regular', 'Education', '2024-01-16 12:32:32'),
(22, 'James', 'R', 'Pedrera', 'regular', 'Education', '2024-01-16 12:32:45'),
(23, 'Meldrid', 'B', 'Miranda', 'regular', 'Education', '2024-01-16 12:32:57'),
(24, 'Jerico Ralph', 'P', 'Abides', 'regular', 'Technology', '2024-01-16 12:33:25'),
(25, 'Paul Mikie', 'Q', 'Alcober', 'regular', 'Technology', '2024-01-16 12:33:44'),
(26, 'Doretta Cleofe', 'D', 'Aniñon', 'regular', 'Technology', '2024-01-16 12:34:06'),
(27, 'Rex Vincent', 'F', 'Enderio', 'regular', 'Technology', '2024-01-16 12:34:50'),
(28, 'Bryan Dino Lester', 'M', 'Garnica', 'regular', 'Technology', '2024-01-16 12:35:08'),
(29, 'Nikki', 'J', 'Malquisto', 'regular', 'Technology', '2024-01-16 12:35:23'),
(30, 'Aiza', 'P', 'Meniano', 'regular', 'Technology', '2024-01-16 12:35:34'),
(31, 'Cathy Faye', 'P', 'Pedrosa', 'regular', 'Technology', '2024-01-16 12:35:46'),
(32, 'Deolito', 'V', 'Legaspi', 'regular', 'Technology', '2024-01-16 12:36:06'),
(33, 'Cecil', 'B', 'Abucot', 'regular', 'BEM', '2024-01-16 12:36:31'),
(34, 'Melissa', 'A', 'Dela Cruz', 'regular', 'BEM', '2024-01-16 12:36:42'),
(35, 'Grace', 'N', 'Dumrigue', 'regular', 'BEM', '2024-01-16 12:37:01'),
(36, 'Erap', 'M', 'Gultian', 'regular', 'BEM', '2024-01-16 12:37:14'),
(37, 'Zosilyn', 'M', 'Malate', 'regular', 'BEM', '2024-01-16 12:37:25'),
(38, 'Meg Anne', 'M', 'Villero', 'regular', 'BEM', '2024-01-16 12:37:37'),
(39, 'Reynalyn', '', 'Barbosa', 'regular', 'BEM', '2024-01-16 12:37:54'),
(40, 'Yolanda', '', 'Cabo', 'regular', 'BEM', '2024-01-16 12:38:04'),
(41, 'Marilou', 'G', 'Perez', 'regular', 'BEM', '2024-01-16 12:38:17'),
(42, 'Jeffrey', 'B', 'Negros', 'regular', 'BEM', '2024-01-16 12:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(255) NOT NULL,
  `project_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `qty_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `project_id`, `date`, `qty_added`) VALUES
(1, '1', '2023-12-11', '121');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(255) NOT NULL,
  `log` varchar(255) NOT NULL,
  `quantity` int(255) DEFAULT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `userid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `log`, `quantity`, `updated`, `userid`) VALUES
(1, 'Sold a stock of', 25, '2024-01-17 07:33:03', '1'),
(2, 'Added a Product Named Test Booklet with an Initial Stock of', 150, '2024-02-09 18:31:52', '1'),
(7, 'Sold a stock of', 50, '2024-02-19 09:05:36', '1'),
(8, 'Sold a stock of', 50, '2024-02-19 09:05:52', '7'),
(9, 'Sold a stock of', 50, '2024-02-19 09:05:57', '7'),
(10, 'Sold a stock of', 20, '2024-02-19 09:26:02', '7'),
(11, 'Sold a stock of', 30, '2024-02-27 20:41:53', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `type`, `description`, `department`, `stock`, `updated`) VALUES
(9, 'Module', '', 'Technology', 15, '2023-12-28 16:18:35'),
(10, 'Test Booklet', 'somethinga adi', 'Engineering', 100, '2024-01-13 20:44:32'),
(11, 'Module', 'somethingy', 'BEM', 50, '2024-01-15 11:33:56'),
(12, 'Test Booklet', 'dsadasdsa', 'Education', 100, '2024-02-09 18:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `total`, `date`) VALUES
(1, 'MODULE', '121', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `remarks_complaint`
--

CREATE TABLE `remarks_complaint` (
  `id` int(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(255) NOT NULL,
  `billing_stall` int(255) NOT NULL,
  `rent_bal` varchar(255) NOT NULL,
  `water_bal` varchar(255) NOT NULL,
  `electricity_bal` varchar(255) NOT NULL,
  `other_bal` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `amount_paid` varchar(255) NOT NULL,
  `date_filed` datetime NOT NULL,
  `date_pay` date NOT NULL,
  `date_approved` datetime NOT NULL DEFAULT current_timestamp(),
  `c_receipt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `billing_stall`, `rent_bal`, `water_bal`, `electricity_bal`, `other_bal`, `amount`, `amount_paid`, `date_filed`, `date_pay`, `date_approved`, `c_receipt`) VALUES
(1, 1, '1234', '1234', '1234', '1234', '4936', '4000', '2023-12-04 10:31:33', '2024-01-04', '2024-01-04 10:33:47', '020420240332.jpg'),
(2, 1, '1234', '1234', '1234', '1234', '4936', '4936', '2024-01-04 10:37:48', '2024-02-04', '2024-02-04 11:09:01', '020420240408.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(255) NOT NULL,
  `product` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `product`, `user_id`, `stock`, `datetime`) VALUES
(1, 12, 1, 30, '2024-02-27 20:42:02'),
(2, 10, 1, 30, '2024-02-27 20:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `req_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`id`, `user_id`, `req_name`, `file_name`, `date`) VALUES
(1, 2, 'Mayor\'s business permit', 'img_20191011_073704.jpg', '2024-01-10 12:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `stalls`
--

CREATE TABLE `stalls` (
  `stall_id` int(11) NOT NULL,
  `stall_name` varchar(255) NOT NULL,
  `stall_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stalls`
--

INSERT INTO `stalls` (`stall_id`, `stall_name`, `stall_desc`) VALUES
(1, 'Stall 1', 'Test'),
(2, 'Stall 2', 'Test'),
(3, 'Stall 3', 'Test'),
(4, 'Stall 4', 'Test'),
(5, 'Stall 5', 'Test'),
(6, 'Stall 6', 'Test'),
(7, 'Stall 7', 'Test'),
(8, 'Stall 8', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenant_id` int(255) NOT NULL,
  `stall_id` int(255) NOT NULL,
  `user` int(255) NOT NULL,
  `date_assigned` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `stall_id`, `user`, `date_assigned`) VALUES
(1, 1, 2, '2023-11-26'),
(6, 6, 7, '2023-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `stall_id` int(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `faculty_id` int(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `phone`, `user_type`, `stall_id`, `profile_picture`, `faculty_id`, `first_name`, `middle`, `last_name`, `username`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', '09123456789', 'Administrator', 0, NULL, NULL, 'Administrator', '', 'something', 'admin'),
(2, 'baf6d30b26892427652771dda7e898a5', '09565945151', 'Concessionaires', 1, NULL, NULL, 'Jerose', '', 'something', 'jerose'),
(7, 'baf6d30b26892427652771dda7e898a5', '09595626323', 'Concessionaires', 6, 'img_avatar.png', NULL, 'Charles', '', 'Mijares', 'Mijares'),
(10, 'baf6d30b26892427652771dda7e898a5', '09531267413', 'Faculty', 0, NULL, 1, '', '', '', 'aljon'),
(11, 'baf6d30b26892427652771dda7e898a5', '09859821416', 'Faculty', 0, NULL, 7, '', '', '', 'jasten'),
(12, 'baf6d30b26892427652771dda7e898a5', '09656134854', 'Faculty', 0, NULL, 3, '', '', '', 'tc_eng_gsc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remarks_complaint`
--
ALTER TABLE `remarks_complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stalls`
--
ALTER TABLE `stalls`
  ADD PRIMARY KEY (`stall_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `stall_id` (`stall_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remarks_complaint`
--
ALTER TABLE `remarks_complaint`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stalls`
--
ALTER TABLE `stalls`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
