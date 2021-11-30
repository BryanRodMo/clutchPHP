-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2021 at 11:32 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinecourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', '2020-01-24 16:21:18', '01-12-2021 03:46:30 AM');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `courseCode` varchar(255) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `courseUnit` varchar(255) NOT NULL,
  `noofSeats` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `courseCode`, `courseName`, `courseUnit`, `noofSeats`, `creationDate`, `updationDate`) VALUES
(1, '4019', 'Intro a PHP', '4', 50, '2021-11-30 20:40:14', ''),
(2, '4075', 'Software Engineering', '4', 2, '2021-11-30 22:16:56', '');

-- --------------------------------------------------------

--
-- Table structure for table `courseenrolls`
--

CREATE TABLE `courseenrolls` (
  `id` int(11) NOT NULL,
  `studentRegno` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `session` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `enrollDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courseenrolls`
--

INSERT INTO `courseenrolls` (`id`, `studentRegno`, `pincode`, `session`, `department`, `level`, `semester`, `course`, `enrollDate`) VALUES
(1, 'bryan.rodriguez', '953740', 1, 1, 1, 1, 1, '2021-11-30 20:40:34'),
(2, 'yadiel.cruzado', '717873', 1, 1, 1, 1, 2, '2021-11-30 22:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `creationDate`) VALUES
(1, 'CCOM', '2021-11-30 20:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`, `creationDate`) VALUES
(1, 'Level 1', '2020-06-03 14:03:20'),
(2, 'Level 2', '2020-06-03 14:03:20'),
(3, 'Level 3', '2020-06-03 14:03:32'),
(4, 'Level 4', '2020-06-03 14:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `creationDate`, `updationDate`) VALUES
(1, 'C12', '2021-11-30 20:39:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `session`, `creationDate`) VALUES
(1, 'This is a Test 1', '2021-11-30 20:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentRegno` varchar(255) NOT NULL,
  `studentPhoto` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `studentName` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `cgpa` decimal(10,2) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentRegno`, `studentPhoto`, `password`, `studentName`, `pincode`, `session`, `department`, `semester`, `cgpa`, `creationdate`, `updationDate`) VALUES
('bryan.rodriguez', '', '25d55ad283aa400af464c76d713c07ad', 'Bryan', '705900', '', '', '', '4.00', '2021-11-30 21:05:50', ''),
('elian.acevedo', NULL, '25d55ad283aa400af464c76d713c07ad', 'Elian', '101434', '', '', '', '0.00', '2021-11-30 21:07:47', ''),
('eliud.rivas', NULL, '25d55ad283aa400af464c76d713c07ad', 'Eliud', '888404', '', '', '', '0.00', '2021-11-30 21:15:28', ''),
('ixan.melendez', NULL, '25d55ad283aa400af464c76d713c07ad', 'Ixan', '693509', '', '', '', '0.00', '2021-11-30 21:04:44', ''),
('jamilette.alvelo', NULL, '25d55ad283aa400af464c76d713c07ad', 'Jamilette', '651295', '', '', '', '0.00', '2021-11-30 21:13:07', ''),
('steven.maldonado', NULL, '25d55ad283aa400af464c76d713c07ad', 'steven', '651073', '', '', '', '0.00', '2021-11-30 21:18:05', ''),
('yadiel.cruzado', NULL, '25d55ad283aa400af464c76d713c07ad', 'Yadiel', '717873', '', '', '', '0.00', '2021-11-30 21:27:33', ''),
('yamil.galan', NULL, '25d55ad283aa400af464c76d713c07ad', 'Yamil', '790600', '', '', '', '0.00', '2021-11-30 21:16:27', '');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `studentRegno` varchar(255) NOT NULL,
  `userip` binary(16) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `studentRegno`, `userip`, `loginTime`, `logout`, `status`) VALUES
(1, 'bryan.rodriguez', 0x3a3a3100000000000000000000000000, '2021-11-30 20:38:53', '01-12-2021 02:37:14 AM', 1),
(2, '', 0x3a3a3100000000000000000000000000, '2021-11-30 21:24:58', '', 1),
(3, '', 0x3a3a3100000000000000000000000000, '2021-11-30 21:25:40', '', 1),
(4, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 21:27:43', '01-12-2021 02:57:55 AM', 1),
(5, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 21:33:52', '', 1),
(6, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 21:37:24', '', 1),
(7, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 21:40:12', '01-12-2021 03:38:10 AM', 1),
(8, 'bryan.rodriguez', 0x3a3a3100000000000000000000000000, '2021-11-30 22:08:16', '01-12-2021 03:38:26 AM', 1),
(9, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 22:08:31', '01-12-2021 03:43:41 AM', 1),
(10, 'bryan.rodriguez', 0x3a3a3100000000000000000000000000, '2021-11-30 22:13:47', '01-12-2021 03:45:50 AM', 1),
(11, 'yadiel.cruzado', 0x3a3a3100000000000000000000000000, '2021-11-30 22:15:57', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courseenrolls`
--
ALTER TABLE `courseenrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentRegno`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courseenrolls`
--
ALTER TABLE `courseenrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
