-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2020 at 09:29 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `studentuserid` int(11) NOT NULL,
  `staffuserid` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `meetingtype` int(11) NOT NULL,
  `confirmed` int(1) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `departmentname` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `departmentname`, `deleted`) VALUES
(1, 'Computer Science', 0),
(2, 'Business', 0),
(3, 'Psychology', 1),
(4, 'Sport Science', 0),
(5, 'Primary Education', 1),
(6, 'Biology', 0),
(7, 'Computer Networks and Cybersecurity', 0),
(8, 'Environmental Science', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meetingtype`
--

CREATE TABLE `meetingtype` (
  `id` int(11) NOT NULL,
  `meetingname` varchar(255) NOT NULL,
  `meetingdescription` text NOT NULL,
  `staffid` int(11) NOT NULL,
  `duration` int(255) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meetingtype`
--

INSERT INTO `meetingtype` (`id`, `meetingname`, `meetingdescription`, `staffid`, `duration`, `deleted`) VALUES
(2, 'Project Meeting', 'Meeting to discuss either undergraduate dissertation or post graduate projects', 8, 30, 0),
(3, '1 Hour Meeting', 'An Hour Meeting', 8, 60, 0),
(4, 'Project Meeting', 'A Meeting specifically for my Project students', 11, 30, 0),
(5, '1 Hour Meeting', '1 Hour Meeting, can be to discuss anything', 11, 60, 0),
(6, '30 Minute Meeting', 'Meeting can be about anything', 11, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staffschedule`
--

CREATE TABLE `staffschedule` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffday` int(1) NOT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `active` int(1) NOT NULL,
  `away` int(1) NOT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staffschedule`
--

INSERT INTO `staffschedule` (`id`, `staffid`, `staffday`, `starttime`, `endtime`, `active`, `away`, `startdate`, `enddate`, `deleted`) VALUES
(1, 11, 1, '10:00:00', '12:00:00', 1, 0, NULL, NULL, 0),
(2, 11, 1, '09:23:00', '14:27:00', 1, 0, NULL, NULL, 1),
(3, 11, 2, '15:08:00', '16:08:00', 1, 0, NULL, NULL, 1),
(4, 11, 0, '08:57:00', '12:02:00', 0, 1, '2020-12-16', '2020-12-30', 0),
(6, 11, 1, '14:00:00', '16:00:00', 1, 0, NULL, NULL, 0),
(7, 11, 1, '12:02:00', '13:03:00', 1, 0, NULL, NULL, 1),
(11, 11, 1, '12:02:00', '13:03:00', 1, 0, NULL, NULL, 1),
(12, 11, 1, '10:06:00', '13:08:00', 1, 0, NULL, NULL, 1),
(13, 11, 0, '09:00:00', '10:00:00', 0, 1, NULL, NULL, 1),
(14, 11, 0, '09:00:00', '10:00:00', 0, 1, '2020-12-22', '2020-12-11', 1),
(15, 11, 0, '09:00:00', '10:00:00', 0, 1, '2020-12-22', '2020-12-11', 0),
(16, 11, 0, '09:00:00', '10:00:00', 0, 1, '2020-12-22', '2020-12-11', 0),
(17, 11, 0, '09:00:00', '10:00:00', 0, 1, '2020-12-22', '2020-12-11', 1),
(18, 11, 0, '09:00:00', '10:00:00', 0, 1, '2020-12-22', '2020-12-11', 0),
(19, 8, 1, '10:25:00', '12:00:00', 1, 0, NULL, NULL, 0),
(20, 8, 0, '09:00:00', '17:00:00', 0, 1, '2021-01-01', '2021-01-05', 0),
(21, 8, 0, '09:00:00', '15:55:00', 0, 1, '2021-01-02', '2021-01-09', 0),
(22, 8, 0, '12:05:00', '17:00:00', 0, 1, '2021-01-01', '2021-01-22', 0),
(23, 8, 0, '00:00:00', '00:00:00', 0, 1, '2021-01-23', '2021-01-30', 0),
(24, 8, 2, '08:00:00', '15:00:00', 1, 0, NULL, NULL, 0),
(25, 8, 3, '05:00:00', '08:00:00', 1, 0, NULL, NULL, 0),
(26, 8, 1, '14:00:00', '15:00:00', 1, 0, NULL, NULL, 0),
(27, 11, 2, '10:00:00', '11:00:00', 1, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userinformation`
--

CREATE TABLE `userinformation` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` int(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `userlocation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userinformation`
--

INSERT INTO `userinformation` (`userid`, `fullname`, `phone`, `photo`, `department`, `bio`, `userlocation`) VALUES
(8, 'Alex Tuersley', 0, '', 0, '', ''),
(9, 'Alex Tuersley', 78934234, NULL, 0, 'Uni Student', ''),
(11, 'John Smith', 0, '', 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `userlevel` int(1) NOT NULL,
  `activated` int(1) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `userpassword`, `userlevel`, `activated`, `deleted`) VALUES
(8, 'amt-county@live.co.uk', 'AlexT', '$2y$12$Vi9TvHKE5y2qCE1I79ztTucvxD0DUz5K8YGCRboa9bnqtpKlAGULq', 3, 1, 0),
(9, 'alexander.tuersley@northumbria.ac.uk', 'Alex', '$2y$12$Vi9TvHKE5y2qCE1I79ztTucvxD0DUz5K8YGCRboa9bnqtpKlAGULq', 1, 1, 0),
(11, 'johnsmith@gmail.com', 'test', '$2y$12$kaYESus1mkzizLGBq.yzxeJToOI0dEpOiq5h2t0M9zK.IXgcf7Rae', 2, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetingtype`
--
ALTER TABLE `meetingtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffschedule`
--
ALTER TABLE `staffschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinformation`
--
ALTER TABLE `userinformation`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meetingtype`
--
ALTER TABLE `meetingtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staffschedule`
--
ALTER TABLE `staffschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;