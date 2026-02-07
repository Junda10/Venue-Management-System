-- Venue Management System SQL Schema (TiDB Optimized)
-- Consolidates PRIMARY KEY and AUTO_INCREMENT into CREATE TABLE blocks

CREATE DATABASE IF NOT EXISTS test;
USE test;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";

-- --------------------------------------------------------
-- Table structure for `admins`
-- --------------------------------------------------------

CREATE TABLE `admins` (
  `admin_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_num` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `a_image` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`admin_id`, `first_name`, `last_name`, `email`, `phone_num`, `password`, `a_image`) VALUES
('A001', 'Chia', 'Chin Tat', 'chiachintat10@gmail.com', '0167969432', '12341234', 'uploads/Decrypt.jpeg'),
('A002', 'Law', 'Hou Wen', 'haowenliu4@gmail.com', '01155069903', '11111111', 'uploads/1297693.jpg'),
('A003', 'Sim', 'Xin Yi', 'xinyi7009@gmail.com', '01966359658', 'qwertyuiop', 'uploads/alamak.jpg'),
('A004', 'Poon', 'Wee Feng', 'weefeng2003@gmail.com', '0147893365', 'weefeng123', 'uploads/wf.jpg');

-- --------------------------------------------------------
-- Table structure for `faculty_types`
-- --------------------------------------------------------

CREATE TABLE `faculty_types` (
  `faculty_id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_code` varchar(7) NOT NULL,
  `faculty_name` varchar(50) NOT NULL,
  PRIMARY KEY (`faculty_id`),
  UNIQUE KEY `faculty_code` (`faculty_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `faculty_types` (`faculty_id`, `faculty_code`, `faculty_name`) VALUES
(1, 'FIST', 'Faculty of Science and Technology'),
(2, 'FOL', 'Faculty of Law'),
(3, 'FET', 'Faculty of Engineering and Technology'),
(4, 'FOB', 'Faculty of Business');

-- --------------------------------------------------------
-- Table structure for `reservations`
-- --------------------------------------------------------

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `slot_id` varchar(10) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `venue_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `venue_id` (`venue_id`),
  KEY `user_id` (`user_id`),
  KEY `status_id` (`status_id`),
  KEY `slot_id` (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservations` (`id`, `venue_id`, `user_id`, `date`, `slot_id`, `purpose`, `status_id`, `venue_name`) VALUES
(1, '2', '1211101262', '2024-07-03', 'A', 'Project Meeting', 1, 'Lecture Hall MNCR0002'),
(2, '7', '1211101262', '2024-07-03', 'C', 'Use for MMUBC campaign', 1, 'Exam Hall A'),
(3, '11', '1211102419', '2024-07-20', 'D', 'Project Discussion', 1, 'Classroom MNBR0013'),
(4, '14', '1211102419', '2024-07-12', 'E', 'FIST PHD talk', 1, 'Main Hall YK'),
(5, '16', '1211100564', '2024-07-16', 'E', 'Used for basketball training purpose.', 1, 'Basketball Court A'),
(6, '15', '1211102966', '2024-07-13', 'E', 'Use for Movie Project', 1, 'Main Hall YJ'),
(7, '16', '1211102966', '2024-07-13', 'B', 'Use for basketball competition', 1, 'Basketball Court A');

-- --------------------------------------------------------
-- Table structure for `reservation_statuses`
-- --------------------------------------------------------

CREATE TABLE `reservation_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservation_statuses` (`id`, `status_name`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Rejected');

-- --------------------------------------------------------
-- Table structure for `roles`
-- --------------------------------------------------------

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Student'),
(2, 'Lecturer');

-- --------------------------------------------------------
-- Table structure for `term_types`
-- --------------------------------------------------------

CREATE TABLE `term_types` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `term_name` varchar(50) NOT NULL,
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `term_name` (`term_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `term_types` (`term_id`, `term_name`) VALUES
(1, '17/18'),
(2, '18/19'),
(3, '19/20'),
(4, '20/21'),
(5, '21/22'),
(6, '22/23'),
(7, '23/24');

-- --------------------------------------------------------
-- Table structure for `time_slots`
-- --------------------------------------------------------

CREATE TABLE `time_slots` (
  `slot_id` varchar(10) NOT NULL,
  `time_slots` varchar(20) NOT NULL,
  PRIMARY KEY (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `time_slots` (`slot_id`, `time_slots`) VALUES
('A', '0800 - 1000'),
('B', '1000 - 1200'),
('C', '1200 - 1400'),
('D', '1400 - 1600'),
('E', '1600 - 1800'),
('F', '1800 - 2000'),
('G', '2000 - 2200');

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------

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
  `u_image` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`),
  KEY `faculty_id` (`faculty_id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role_id`, `phone_num`, `faculty_id`, `term_id`, `u_image`) VALUES
('1211100564', 'Pretty', 'Sim', '1211100564@student.mmu.edu.my', 'iampretty', 1, '103317009', 2, 2, 'uploads/sm.jpg'),
('1211101262', 'Terry', 'Chia', '1211101262@student.mmu.edu.my', '12345678', 2, '166936946', 3, 4, 'uploads/1.jpg'),
('1211102419', 'Jacky', 'Law', '1211102419@student.mmu.edu.my', '87654321', 1, '1155069903', 1, 1, 'uploads/Jackie.png'),
('1211102966', 'Poon', 'Andy', '1211102966@student.mmu.edu.my', '12341234', 1, '182274546', 1, 5, 'uploads/wf.jpg');

-- --------------------------------------------------------
-- Table structure for `venues`
-- --------------------------------------------------------

CREATE TABLE `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `images` varchar(50) NOT NULL,
  `venue_description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for `venue_remark`
-- --------------------------------------------------------

CREATE TABLE `venue_remark` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(50) NOT NULL,
  `report_dates` date NOT NULL,
  `report_status` varchar(20) NOT NULL,
  `venue_type` varchar(20) NOT NULL,
  `comment` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `venue_remark` (`id`, `venue_name`, `report_dates`, `report_status`, `venue_type`, `comment`) VALUES
(1, '9', '2024-07-01', 'Solved', 'CLASSROOM', 'Air conditioning leaking'),
(2, '7', '2024-07-18', 'Solved', 'EXAM HALL', 'Problem with screen projection'),
(3, '10', '2024-07-02', 'Solved', 'CLASSROOM', 'Mic Problem\r\n'),
(4, '9', '2024-07-02', 'Progress', 'CLASSROOM', 'Problem with the computer speakers');

-- --------------------------------------------------------
-- Table structure for `venue_types`
-- --------------------------------------------------------

CREATE TABLE `venue_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `venue_types` (`id`, `type`) VALUES
(1, 'LECTURE HALL\r\n'),
(2, 'EXAM HALL'),
(3, 'CLASSROOM'),
(4, 'MAIN HALL\r\n'),
(5, 'SPORT FACILITY');

COMMIT;
