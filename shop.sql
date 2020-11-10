-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2020 at 02:51 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Cat_ID` int(6) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf32 NOT NULL,
  `Description` text NOT NULL,
  `perant` int(11) NOT NULL,
  `Ordring` int(11) DEFAULT NULL,
  `Visibiity` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Commect` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_ID`, `Name`, `Description`, `perant`, `Ordring`, `Visibiity`, `Allow_Commect`, `Allow_Ads`) VALUES
(41, 'cat1', 'descraption cat1', 0, 1, 0, 0, 0),
(42, 'cat2', 'descraption cat2', 0, 2, 0, 0, 0),
(43, 'cat3', 'descraption cat3', 0, 3, 0, 0, 0),
(44, 'cat4', 'descraption cat4', 0, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Com_ID` int(11) NOT NULL,
  `Comment` text CHARACTER SET utf8 NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 0,
  `Com_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_miade` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Tages` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_miade`, `Image`, `State`, `Rating`, `Approve`, `Cat_ID`, `User_ID`, `Tages`) VALUES
(133, 'item1', 'descraption item1', '120', '2020-11-10', 'egy', 'download.png', '1', 1, 0, 41, 1, 'asd,fan,grp');

-- --------------------------------------------------------

--
-- Table structure for table `usres`
--

CREATE TABLE `usres` (
  `UserID` int(11) NOT NULL COMMENT 'to idntfiy user',
  `Username` varchar(255) NOT NULL COMMENT 'username to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) NOT NULL COMMENT 'email to login',
  `Fullname` varchar(255) NOT NULL COMMENT 'fullname to login',
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identfiy user Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'pending Approval',
  `RegusterDate` date NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usres`
--

INSERT INTO `usres` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `GroupID`, `TrustStatus`, `RegStatus`, `RegusterDate`, `Avatar`) VALUES
(1, 'ayman', '597c9f131f74f61cab01178d7ac30a5666d0ff14', 'ayman@yahoo.com', 'ayman', 1, 0, 0, '2020-10-31', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `usres`
--
ALTER TABLE `usres`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Cat_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `usres`
--
ALTER TABLE `usres`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to idntfiy user', AUTO_INCREMENT=181;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `usres` (`UserID`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `usres` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`Cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
