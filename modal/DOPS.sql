-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 09:35 PM
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
-- Database: `timesheets`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(6) NOT NULL,
  `client_name` varchar(85) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`) VALUES
(408, 'Goromonzi'),
(409, 'Zvimba');

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `disease_id` int(11) NOT NULL,
  `disease_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`disease_id`, `disease_name`) VALUES
(1, 'Cholera'),
(2, 'Malaria');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `resettoken` varchar(50) DEFAULT NULL,
  `resettokenexpired` date DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `pwd_updated` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = NO (User have not updated pwd yet)\r\n1 = YES(Updated)',
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `email`, `password`, `resettoken`, `resettokenexpired`, `position_id`, `is_admin`, `pwd_updated`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 'Aneley', 'Nyongwana', 'dev1@innov8ivess.com', '$2y$10$KPk.fTZS4sP8NelUuX35JOOlbQtgBd9vuQgJ9geVPxzYAvQp1eruG', NULL, NULL, 6, 1, 1, NULL, NULL, '2023-08-16 09:17:18'),
(26, 'Makomborero', 'Busu', 'makosbush@gmail.com', '$2y$10$ecckE5Hy0GLgVgTNoWNlNO3x8DRHgmAkcIUhFq9Lhrq7RHtw6YZhG', '2107603d5c4a51d4379a5e05d2ef0fa7', '2024-04-04', 9, 0, 0, NULL, NULL, '2024-03-08 04:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `employee_project_rate`
--

CREATE TABLE `employee_project_rate` (
  `rate_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_project_rate`
--

INSERT INTO `employee_project_rate` (`rate_id`, `employee_id`, `project_id`) VALUES
(1, 9, 8),
(2, 10, 8),
(3, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position`) VALUES
(6, 'Admin '),
(8, 'Doctor '),
(9, 'Nurse Aid ');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(164) DEFAULT NULL,
  `start_date` varchar(16) DEFAULT NULL,
  `end_date` varchar(16) DEFAULT NULL,
  `client_id` varchar(9) DEFAULT NULL,
  `employee_id` varchar(10) DEFAULT NULL,
  `status_id` varchar(10) DEFAULT NULL,
  `disease_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `start_date`, `end_date`, `client_id`, `employee_id`, `status_id`, `disease_id`) VALUES
(426, 'Mako', '2024-03-08', '2024-03-22', '408', '', '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_users`
--

CREATE TABLE `project_users` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `rate` double DEFAULT NULL,
  `date_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_users`
--

INSERT INTO `project_users` (`id`, `project_id`, `employee_id`, `rate`, `date_stamp`) VALUES
(49, 426, 26, NULL, '2024-03-08 04:42:17'),
(50, 426, 1, NULL, '2024-03-08 05:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status`) VALUES
(1, 'NOT STARTED'),
(2, 'IN PROGRESS'),
(3, 'COMPLETED'),
(4, 'OVERDUE'),
(5, 'ARCHIVED');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(1000) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `date_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `disease_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `project_id`, `date_stamp`, `disease_id`) VALUES
(225, 'The patient was sick', 426, '2024-03-08 05:06:32', 1),
(227, 'Severe', 426, '2024-03-16 09:00:49', 0),
(229, 'The patient had high fever', 426, '2024-03-20 09:43:10', 2),
(230, 'Very severe headache', 426, '2024-03-20 09:47:23', 0),
(231, 'Aaaaah arwara uyu', 426, '2024-03-20 09:55:19', 2),
(232, 'Mmmmm zveshuwa arwara', 426, '2024-03-20 09:57:31', 0),
(233, 'test', 426, '2024-04-17 19:14:10', 0),
(234, 'test', 426, '2024-04-18 18:44:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `timesheet_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hours` decimal(5,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '\r\n\r\n2 for clear\r\n1 for active\r\n0 for inactive\r\n',
  `timesheet_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`timesheet_id`, `employee_id`, `task_id`, `start`, `end`, `date`, `hours`, `active`, `timesheet_stamp`) VALUES
(225, 1, 225, '10:00:00', '12:00:00', '2024-03-22', 2.00, 1, '2024-03-08 05:06:32'),
(229, 1, 229, '09:00:00', '12:00:00', '2024-03-22', 3.00, 1, '2024-03-20 09:43:10'),
(230, 26, 230, '10:00:00', '13:00:00', '2024-03-21', 3.00, 1, '2024-03-20 09:47:23'),
(231, 1, 231, '10:00:00', '13:00:00', '2024-03-22', 3.00, 1, '2024-03-20 09:55:19'),
(232, 26, 232, '10:00:00', '12:00:00', '2024-03-21', 2.00, 1, '2024-03-20 09:57:31'),
(234, 1, 234, '10:00:00', '12:00:00', '2024-03-22', 2.00, 1, '2024-04-18 18:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `created_at`) VALUES
(1, 'John Snash', 'john@gmail.com', '0000-00-00 00:00:00'),
(2, 'John Doe', 'johndoe@gmail.com', '0000-00-00 00:00:00'),
(3, 'Snash DJ', 'snash@gmail.com', '0000-00-00 00:00:00'),
(4, 'Test', 'test@gmail.com', '0000-00-00 00:00:00'),
(5, 'More test', 'more@gmail.com', '0000-00-00 00:00:00'),
(6, 'Someone', 'someone@gmail.com', '0000-00-00 00:00:00'),
(7, 'Anele', 'anele@gmail.com', '2023-08-15 11:47:58'),
(8, 'Anne', 'anne@gmail.com', '2023-08-15 11:55:50'),
(9, '', '', '2023-08-15 11:56:29'),
(10, '', '', '2023-08-15 12:19:19'),
(11, '', '', '2023-08-15 12:19:40'),
(12, 'hi', 'hi@gmail.com', '2023-08-15 12:24:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`disease_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employees_position` (`position_id`);

--
-- Indexes for table `employee_project_rate`
--
ALTER TABLE `employee_project_rate`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_users`
--
ALTER TABLE `project_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`timesheet_id`),
  ADD KEY `employees_timesheet` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `employee_project_rate`
--
ALTER TABLE `employee_project_rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `project_users`
--
ALTER TABLE `project_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `timesheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `employees_timesheet` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
