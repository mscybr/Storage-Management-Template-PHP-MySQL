-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04 فبراير 2022 الساعة 14:58
-- إصدار الخادم: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storage_website`
--

-- --------------------------------------------------------

--
-- بنية الجدول `company`
--

CREATE TABLE `company` (
  `Company_Id` int(255) NOT NULL,
  `Company_Name` text NOT NULL,
  `Company_Thumbnail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `company`
--

INSERT INTO `company` (`Company_Id`, `Company_Name`, `Company_Thumbnail`) VALUES
(9, 'Son of Tzu', 'dragon'),
(10, 'new light', 'moon');

-- --------------------------------------------------------

--
-- بنية الجدول `item`
--

CREATE TABLE `item` (
  `Item_Name` varchar(255) NOT NULL,
  `Item_Id` int(255) NOT NULL,
  `Enter_User_Id` int(255) NOT NULL,
  `Exit_User_Id` int(255) DEFAULT NULL,
  `Storage_Id` int(255) NOT NULL,
  `Enter_Date` datetime DEFAULT current_timestamp(),
  `Exit_Date` datetime NOT NULL,
  `Amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `item`
--

INSERT INTO `item` (`Item_Name`, `Item_Id`, `Enter_User_Id`, `Exit_User_Id`, `Storage_Id`, `Enter_Date`, `Exit_Date`, `Amount`) VALUES
('qweqw', 24, 1026, 1026, 27, '2022-01-23 15:30:45', '2022-01-23 19:12:20', 0),
('weqw', 25, 1026, 1026, 27, '2022-01-23 15:30:54', '2022-01-23 19:07:52', 1231),
('231', 26, 1026, 1026, 27, '2022-01-23 15:31:04', '2022-01-23 15:47:30', 2131),
('wqeqw', 33, 1026, 1026, 27, '2022-01-23 19:48:10', '2022-01-23 20:14:25', 12312),
('12jweqjqw', 34, 0, 0, 35, '2022-01-26 07:53:35', '2022-01-26 07:53:40', 123012),
('item', 37, 0, 0, 35, '2022-01-26 09:08:07', '2022-01-27 12:42:59', 1),
('5', 42, 0, 0, 39, '2022-02-04 14:21:47', '2022-02-04 14:21:49', 5),
('50', 44, 1034, 1034, 39, '2022-02-04 14:29:49', '2022-02-04 14:30:55', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `storage`
--

CREATE TABLE `storage` (
  `Storage_Id` int(255) NOT NULL,
  `Company_Id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `storage`
--

INSERT INTO `storage` (`Storage_Id`, `Company_Id`) VALUES
(35, 9),
(37, 9),
(39, 9),
(40, 9),
(27, 10),
(28, 10);

-- --------------------------------------------------------

--
-- بنية الجدول `user`
--

CREATE TABLE `user` (
  `Name` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `User_Id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `user`
--

INSERT INTO `user` (`Name`, `Password`, `User_Id`) VALUES
('Mohammed', 'Password', 1034);

-- --------------------------------------------------------

--
-- بنية الجدول `user_privilege`
--

CREATE TABLE `user_privilege` (
  `User_Id` int(255) NOT NULL,
  `Storage_Id` int(255) NOT NULL,
  `Item_Edit` tinyint(1) NOT NULL,
  `Item_Exit` tinyint(1) NOT NULL,
  `Item_Enter` tinyint(1) NOT NULL,
  `Privilege_Id` int(255) NOT NULL,
  `Item_Delete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `user_privilege`
--

INSERT INTO `user_privilege` (`User_Id`, `Storage_Id`, `Item_Edit`, `Item_Exit`, `Item_Enter`, `Privilege_Id`, `Item_Delete`) VALUES
(1034, 27, 1, 1, 1, 33, 1),
(1034, 39, 1, 1, 1, 35, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Company_Id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Item_Id`),
  ADD KEY `constraint to storage` (`Storage_Id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`Storage_Id`),
  ADD KEY `constraint1` (`Company_Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_Id`);

--
-- Indexes for table `user_privilege`
--
ALTER TABLE `user_privilege`
  ADD PRIMARY KEY (`Privilege_Id`),
  ADD KEY `to storage` (`Storage_Id`),
  ADD KEY `to user` (`User_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Company_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `Item_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `Storage_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1035;

--
-- AUTO_INCREMENT for table `user_privilege`
--
ALTER TABLE `user_privilege`
  MODIFY `Privilege_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `constraint to storage` FOREIGN KEY (`Storage_Id`) REFERENCES `storage` (`Storage_Id`) ON DELETE CASCADE;

--
-- القيود للجدول `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `constraint1` FOREIGN KEY (`Company_Id`) REFERENCES `company` (`Company_Id`) ON DELETE CASCADE;

--
-- القيود للجدول `user_privilege`
--
ALTER TABLE `user_privilege`
  ADD CONSTRAINT `to storage` FOREIGN KEY (`Storage_Id`) REFERENCES `storage` (`Storage_Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `to user` FOREIGN KEY (`User_Id`) REFERENCES `user` (`User_Id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
