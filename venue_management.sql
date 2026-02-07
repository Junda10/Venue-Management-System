-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-07-06 16:59:07
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

CREATE DATABASE IF NOT EXISTS test;
USE test;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `venue_management`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_num` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `a_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`admin_id`, `first_name`, `last_name`, `email`, `phone_num`, `password`, `a_image`) VALUES
('A001', 'Chia', 'Chin Tat', 'chiachintat10@gmail.com', '0167969432', '12341234', 'uploads/Decrypt.jpeg'),
('A002', 'Law', 'Hou Wen', 'haowenliu4@gmail.com', '01155069903', '11111111', 'uploads/1297693.jpg'),
('A003', 'Sim', 'Xin Yi', 'xinyi7009@gmail.com', '01966359658', 'qwertyuiop', 'uploads/alamak.jpg'),
('A004', 'Poon', 'Wee Feng', 'weefeng2003@gmail.com', '0147893365', 'weefeng123', 'uploads/wf.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `faculty_types`
--

CREATE TABLE `faculty_types` (
  `faculty_id` int(11) NOT NULL,
  `faculty_code` varchar(7) NOT NULL,
  `faculty_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `faculty_types`
--

INSERT INTO `faculty_types` (`faculty_id`, `faculty_code`, `faculty_name`) VALUES
(1, 'FIST', 'Faculty of Science and Technology'),
(2, 'FOL', 'Faculty of Law'),
(3, 'FET', 'Faculty of Engineering and Technology'),
(4, 'FOB', 'Faculty of Business');

-- --------------------------------------------------------

--
-- 表的结构 `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `venue_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `slot_id` varchar(10) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `venue_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `reservations`
--

INSERT INTO `reservations` (`id`, `venue_id`, `user_id`, `date`, `slot_id`, `purpose`, `status_id`, `venue_name`) VALUES
(1, '2', '1211101262', '2024-07-03', 'A', 'Project Meeting', 1, 'Lecture Hall MNCR0002'),
(2, '7', '1211101262', '2024-07-03', 'C', 'Use for MMUBC campaign', 1, 'Exam Hall A'),
(3, '11', '1211102419', '2024-07-20', 'D', 'Project Discussion', 1, 'Classroom MNBR0013'),
(4, '14', '1211102419', '2024-07-12', 'E', 'FIST PHD talk', 1, 'Main Hall YK'),
(5, '16', '1211100564', '2024-07-16', 'E', 'Used for basketball training purpose.', 1, 'Basketball Court A'),
(6, '15', '1211102966', '2024-07-13', 'E', 'Use for Movie Project', 1, 'Main Hall YJ'),
(7, '16', '1211102966', '2024-07-13', 'B', 'Use for basketball competition', 1, 'Basketball Court A');

-- --------------------------------------------------------

--
-- 表的结构 `reservation_statuses`
--

CREATE TABLE `reservation_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `reservation_statuses`
--

INSERT INTO `reservation_statuses` (`id`, `status_name`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Rejected');

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Student'),
(2, 'Lecturer');

-- --------------------------------------------------------

--
-- 表的结构 `term_types`
--

CREATE TABLE `term_types` (
  `term_id` int(11) NOT NULL,
  `term_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `term_types`
--

INSERT INTO `term_types` (`term_id`, `term_name`) VALUES
(1, '17/18'),
(2, '18/19'),
(3, '19/20'),
(4, '20/21'),
(5, '21/22'),
(6, '22/23'),
(7, '23/24');

-- --------------------------------------------------------

--
-- 表的结构 `time_slots`
--

CREATE TABLE `time_slots` (
  `slot_id` varchar(10) NOT NULL,
  `time_slots` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `time_slots`
--

INSERT INTO `time_slots` (`slot_id`, `time_slots`) VALUES
('A', '0800 - 1000'),
('B', '1000 - 1200'),
('C', '1200 - 1400'),
('D', '1400 - 1600'),
('E', '1600 - 1800'),
('F', '1800 - 2000'),
('G', '2000 - 2200');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `phone_num` varchar(20) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `u_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role_id`, `phone_num`, `faculty_id`, `term_id`, `u_image`) VALUES
('1211100564', 'Pretty', 'Sim', '1211100564@student.mmu.edu.my', 'iampretty', 1, 103317009, 2, 2, 'uploads/sm.jpg'),
('1211101262', 'Terry', 'Chia', '1211101262@student.mmu.edu.my', '12345678', 2, 166936946, 3, 4, 'uploads/1.jpg'),
('1211102419', 'Jacky', 'Law', '1211102419@student.mmu.edu.my', '87654321', 1, 1155069903, 1, 1, 'uploads/Jackie.png'),
('1211102966', 'Poon', 'Andy', '1211102966@student.mmu.edu.my', '12341234', 1, 182274546, 1, 5, 'uploads/wf.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `images` varchar(50) NOT NULL,
  `venue_description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `venues`
--

INSERT INTO `venues` (`id`, `name`, `type_id`, `images`, `venue_description`) VALUES
(2, 'Lecture Hall MNCR0002', 1, 'L2.jpg', '250 Participants'),
(4, 'Lecture Hall MNR00100', 1, 'L4.jpg', '20 Participants'),
(5, 'Lecture Hall MNCR0005', 1, 'L5.jpg', '250 Participants'),
(6, 'Lecture Hall MNCR0006', 1, 'L6.jpg', '200 Participants'),
(7, 'Exam Hall A', 2, 'E3.jpg', '730 Participants'),
(8, 'Exam Hall C', 2, 'E2.jpg', '850 Participants'),
(9, 'Classroom MNBR0011', 3, 'C1.jpg', '50 Participants'),
(10, 'Classroom MNBR0012', 3, 'C2.jpg', '50 Participants'),
(11, 'Classroom MNBR0013', 3, 'C3.jpg', '35 Participants'),
(12, 'Classroom MNBR0014', 3, 'C4.jpg', '40 Participants'),
(13, 'Classroom MNBR0015', 3, 'C5.jpg', '40 Participants'),
(14, 'Main Hall YK', 4, 'M4.jpg', '500 Participants'),
(15, 'Main Hall YJ', 4, 'M2.jpg', '500 Participants'),
(16, 'Basketball Court A', 5, 'S4.jpg', 'Half Court Only'),
(17, 'FootBall Court A', 5, 'S6.jpg', 'Full Court');

-- --------------------------------------------------------

--
-- 表的结构 `venue_remark`
--

CREATE TABLE `venue_remark` (
  `id` int(100) NOT NULL,
  `venue_name` varchar(50) NOT NULL,
  `report_dates` date NOT NULL,
  `report_status` varchar(20) NOT NULL,
  `venue_type` varchar(20) NOT NULL,
  `comment` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `venue_remark`
--

INSERT INTO `venue_remark` (`id`, `venue_name`, `report_dates`, `report_status`, `venue_type`, `comment`) VALUES
(1, '9', '2024-07-01', 'Solved', 'CLASSROOM', 'Air conditioning leaking'),
(2, '7', '2024-07-18', 'Solved', 'EXAM HALL', 'Problem with screen projection'),
(3, '10', '2024-07-02', 'Solved', 'CLASSROOM', 'Mic Problem\r\n'),
(4, '9', '2024-07-02', 'Progress', 'CLASSROOM', 'Problem with the computer speakers');

-- --------------------------------------------------------

--
-- 表的结构 `venue_types`
--

CREATE TABLE `venue_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `venue_types`
--

INSERT INTO `venue_types` (`id`, `type`) VALUES
(1, 'LECTURE HALL\r\n'),
(2, 'EXAM HALL'),
(3, 'CLASSROOM'),
(4, 'MAIN HALL\r\n'),
(5, 'SPORT FACILITY');

--
-- 转储表的索引
--

--
-- 表的索引 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- 表的索引 `faculty_types`
--
ALTER TABLE `faculty_types`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `faculty_code` (`faculty_code`);

--
-- 表的索引 `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venue_id` (`venue_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- 表的索引 `reservation_statuses`
--
ALTER TABLE `reservation_statuses`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `term_types`
--
ALTER TABLE `term_types`
  ADD PRIMARY KEY (`term_id`),
  ADD UNIQUE KEY `term_name` (`term_name`);

--
-- 表的索引 `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`slot_id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `term_id` (`term_id`);

--
-- 表的索引 `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- 表的索引 `venue_remark`
--
ALTER TABLE `venue_remark`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `venue_types`
--
ALTER TABLE `venue_types`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `faculty_types`
--
ALTER TABLE `faculty_types`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- 使用表AUTO_INCREMENT `reservation_statuses`
--
ALTER TABLE `reservation_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `term_types`
--
ALTER TABLE `term_types`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `venue_remark`
--
ALTER TABLE `venue_remark`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `venue_types`
--
ALTER TABLE `venue_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
