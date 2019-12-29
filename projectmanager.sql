-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2019 at 09:34 PM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `completedtask`
--

CREATE TABLE `completedtask` (
  `TaskID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `completedtask`
--

INSERT INTO `completedtask` (`TaskID`, `StartDate`, `EndDate`) VALUES
(12, '2019-12-17', '2019-12-31'),
(19, '2019-12-18', '2019-12-31'),
(26, '2019-12-26', '2019-12-30'),
(18, '2020-01-06', '2020-01-07'),
(27, '2019-12-25', '2020-02-20'),
(29, '2019-12-31', '2020-01-24'),
(28, '2019-12-18', '2020-02-04');

-- --------------------------------------------------------

--
-- Table structure for table `deliverable`
--

CREATE TABLE `deliverable` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text,
  `ProjectID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliverable`
--

INSERT INTO `deliverable` (`ID`, `Name`, `Description`, `ProjectID`) VALUES
(1, 'First Deliverable', 'Cool dlierveal', 7),
(2, 'Second Deliverable', '', 7),
(3, 'Third Deliverable', 'dfadsfasfd', 7),
(4, 'Deliverable With No Description', '', 7),
(5, 'aweaweawe', 'waeewaaew', 8),
(6, 'First Deliverable', 'waeewaaew', 8),
(7, 'working garage', 'working garage with bicycles', 13);

-- --------------------------------------------------------

--
-- Table structure for table `dependson`
--

CREATE TABLE `dependson` (
  `DependentID` int(11) NOT NULL,
  `DependencyID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dependson`
--

INSERT INTO `dependson` (`DependentID`, `DependencyID`) VALUES
(21, 10),
(21, 11),
(22, 10),
(22, 11),
(28, 27);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `WorkingHoursPerDay` int(11) DEFAULT '8',
  `Cost` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `DueDate` date NOT NULL,
  `StartingDayOfTheWeek` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ID`, `Name`, `WorkingHoursPerDay`, `Cost`, `StartDate`, `DueDate`, `StartingDayOfTheWeek`) VALUES
(5, 'name', 10, 10, '1999-10-10', '2000-10-10', 2),
(6, 'First Project', 10, 8, '2019-12-01', '2019-12-28', 0),
(7, 'Second Project', 8, 200000, '2019-12-25', '2019-12-31', 5),
(8, 'Third Project', 10, 500000, '2019-12-01', '2019-12-31', 0),
(9, 'Fourth Project', 10, 24125412, '2019-12-15', '2019-12-31', 5),
(10, 'Fifth Project', 10, 214, '2019-12-01', '2019-12-31', 5),
(11, '21341', 12, 12, '2019-12-01', '2019-12-19', 4),
(12, 'Test Double Value', 11, 16, '2019-12-25', '2019-12-31', 0),
(13, 'Bicycle Renting', 8, 1000000, '2019-12-12', '2020-06-24', 0),
(14, 'fci', 8, 1000000, '2019-12-01', '2020-03-12', 5);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `WorkingDaysNeeded` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `ParentTask` int(11) DEFAULT NULL,
  `isMilestone` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `Name`, `WorkingDaysNeeded`, `StartDate`, `ProjectID`, `ParentTask`, `isMilestone`) VALUES
(1, 'Task 1', 2, '2019-12-24', 8, NULL, 0),
(2, 'Task 2', 3, '2019-12-10', 8, NULL, 0),
(3, 'Task 3', 5, '2019-12-16', 8, NULL, 0),
(4, 'Task 4', 4, '2019-12-17', 8, NULL, 0),
(8, 'tasj', 10, '2019-12-09', 8, NULL, 0),
(9, 'testste', 10, '2019-12-09', 8, NULL, 0),
(10, 'First Task', 3, '2019-12-26', 7, NULL, 0),
(11, 'SecondTask', 3, '2019-12-26', 7, NULL, 0),
(12, 'first subtask', 1, '2019-12-26', 7, NULL, 0),
(13, 'FirstSubTaskreally', 1, '2019-12-26', 7, NULL, 0),
(14, 'subtaskba2a', 1, '2019-12-27', 7, 10, 0),
(15, 'Ew3a el subtask hierarchy', 2, '2019-12-27', 7, 10, 0),
(16, 'Gamed Gamed', 1, '2019-12-27', 7, 14, 0),
(17, 'Task With dependencies', 3, '2019-12-25', 7, NULL, 0),
(18, 'Task With Dependencies el marady', 1, '2019-12-29', 7, NULL, 0),
(19, 'testing dependncy', 1, '2019-12-30', 7, NULL, 0),
(20, 'testing dependncy again', 1, '2019-12-30', 7, NULL, 0),
(21, 'testing dependncy again23', 1, '2019-12-30', 7, NULL, 0),
(22, 'testing dependncy 2452', 1, '2019-12-30', 7, NULL, 0),
(23, 'testing workson', 2, '2019-12-26', 7, NULL, 0),
(24, 'testing workson2', 2, '2019-12-26', 7, NULL, 0),
(25, 'testing workson3', 2, '2019-12-26', 7, NULL, 0),
(26, 'A Milestone task', 1, '2019-12-26', 7, NULL, 1),
(27, 'Software Analysis', 20, '2019-12-25', 13, NULL, 0),
(28, 'Software Design', 50, '2020-01-29', 13, NULL, 1),
(30, 'requirements gathering', 5, '2020-01-09', 13, 27, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teammember`
--

CREATE TABLE `teammember` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `ProjectID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teammember`
--

INSERT INTO `teammember` (`ID`, `Name`, `Title`, `ProjectID`) VALUES
(20170292, 'Mostafa Omar', 'Best Guy in Project', 7),
(2015, 'Luka', 'Malosh Lazma', 7),
(1, 'Ahmed', 'Developer', 13),
(2, 'KHaled', 'tester', 13),
(3, 'Rashad', 'Designer', 13);

-- --------------------------------------------------------

--
-- Table structure for table `workson`
--

CREATE TABLE `workson` (
  `TeamMemberID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL,
  `CommittedWorkingHours` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workson`
--

INSERT INTO `workson` (`TeamMemberID`, `TaskID`, `CommittedWorkingHours`) VALUES
(20170292, 25, 10),
(2015, 25, 15),
(20170292, 26, 7),
(1, 27, 10),
(1, 28, 10),
(2, 28, 20),
(3, 28, 80);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `completedtask`
--
ALTER TABLE `completedtask`
  ADD PRIMARY KEY (`TaskID`);

--
-- Indexes for table `deliverable`
--
ALTER TABLE `deliverable`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `dependson`
--
ALTER TABLE `dependson`
  ADD PRIMARY KEY (`DependentID`,`DependencyID`),
  ADD KEY `DependencyID` (`DependencyID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProjectID` (`ProjectID`),
  ADD KEY `ParentTask` (`ParentTask`);

--
-- Indexes for table `teammember`
--
ALTER TABLE `teammember`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `workson`
--
ALTER TABLE `workson`
  ADD PRIMARY KEY (`TeamMemberID`,`TaskID`),
  ADD KEY `TaskID` (`TaskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliverable`
--
ALTER TABLE `deliverable`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `teammember`
--
ALTER TABLE `teammember`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20170293;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
