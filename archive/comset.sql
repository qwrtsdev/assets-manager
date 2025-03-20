-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 04:59 AM
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
-- Database: `comset`
--

-- --------------------------------------------------------

--
-- Table structure for table `adapter`
--

CREATE TABLE `adapter` (
  `Adapter_ID` int(5) NOT NULL,
  `Adapter_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `Branch_ID` int(5) NOT NULL,
  `Branch_name` varchar(5) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`Branch_ID`, `Branch_name`) VALUES
(1, 'HY'),
(2, 'LR'),
(3, 'UC'),
(4, 'ST'),
(5, 'SD'),
(6, 'SK'),
(7, 'NT'),
(8, 'SS'),
(9, 'BYD');

-- --------------------------------------------------------

--
-- Table structure for table `computer`
--

CREATE TABLE `computer` (
  `Com_ID` int(5) NOT NULL,
  `Com_name` varchar(30) DEFAULT NULL,
  `Com_sn` varchar(30) DEFAULT NULL,
  `IPaddress` char(50) DEFAULT '',
  `Branch_ID` int(5) DEFAULT NULL,
  `Department_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `Os` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `computer`
--

INSERT INTO `computer` (`Com_ID`, `Com_name`, `Com_sn`, `IPaddress`, `Branch_ID`, `Department_ID`, `Stat_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`, `Os`) VALUES
(1, 'SD-EoneSlipt01', '6LBM862', '10.26.14.106', 5, 11, 2, 'อุไรวรรณ แซ่หลอ', 'อุไรวรรณ', '-', '2025-03-10 00:00:00', 'win 7pro'),
(2, 'SD-SELL02', '5HFRQ12', '10.26.14.98', 5, 11, 2, 'ศตานันท์  หน่อทองแดง', 'ศตานันท์', '-', '2025-03-10 00:00:00', 'win 7pro'),
(3, 'SD-SALE-DFFICER01', 'GW36F22', '10.26.14.96', 5, 1, 2, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00', 'win 7pro'),
(4, 'SD-SA02', 'FHFRQ12', '10.26.14.33', 5, 2, 2, 'ปัทมวรรณ สองไทย', 'ปัทมวรรณ', '-', '2025-03-10 00:00:00', 'win 7pro'),
(5, 'SD-SA03', '2GFRQ12', '10.26.14.34', 5, 2, 2, 'วิชรญาน์ กุลธนาพิชญ์', 'วิชรญาน์', '-', '2025-03-10 00:00:00', 'win 7pro'),
(6, 'SD-CASH01', '6GFRQ12', '10.26.14.61', 5, 2, 2, 'มนปรียา คงปล้อง', 'มนปรียา', '-', '2025-03-10 00:00:00', 'win 7pro');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Department_ID` int(5) NOT NULL,
  `Department_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Department_ID`, `Department_name`) VALUES
(1, 'ขาย'),
(2, 'บริการ'),
(3, 'อะไหล่'),
(4, 'ตัวถังและสี'),
(5, 'คอมพิวเตอร์'),
(6, 'ประกันภัย'),
(7, 'ตรวจสอบ'),
(8, 'บุคคล'),
(9, 'การตลาด'),
(10, 'บัญชี'),
(11, 'การเงิน-ขาย'),
(12, 'การเงิน-ศูนย์บริการ'),
(13, 'ชัวร์'),
(14, 'คาร์สปา'),
(15, 'Accessory'),
(16, 'ลูกค้าสัมพันธ์'),
(17, 'คอลเซ็นเตอร์'),
(18, 'ศูนย์ฝึกอบรม'),
(19, 'สหกรณ์'),
(20, 'STOCK รถใหม่'),
(21, 'บริหาร'),
(22, 'อาคารฯ'),
(23, 'อื่นๆ');

-- --------------------------------------------------------

--
-- Table structure for table `flashdrive`
--

CREATE TABLE `flashdrive` (
  `Flash_ID` int(5) NOT NULL,
  `Flash_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harddisk`
--

CREATE TABLE `harddisk` (
  `HDD_ID` int(5) NOT NULL,
  `HDD_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keyboard`
--

CREATE TABLE `keyboard` (
  `Key_ID` int(5) NOT NULL,
  `Key_SN` char(50) DEFAULT '',
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `keyboard`
--

INSERT INTO `keyboard` (`Key_ID`, `Key_SN`, `Com_ID`, `Stat_ID`, `Branch_ID`, `Department_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`) VALUES
(1, 'CN-OP7022-71581-42L-01AQ-A01', 1, 2, 5, 11, 'อุไรวรรณ แซ่หลอ', 'อุไรวรรณ', '-', '2025-03-10 00:00:00'),
(2, 'CN-OP7022-71581-41F-OC50-A01', 2, 2, 5, 11, 'ศตานันท์  หน่อทองแดง', 'ศตานันท์', '-', '2025-03-10 00:00:00'),
(3, 'CN-OP7022-71581-45R-007A-A01', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00'),
(4, '2334MR1132F8', 4, 2, 5, 2, 'ปัทมวรรณ สองไทย', 'ปัทมวรรณ', '-', '2025-03-10 00:00:00'),
(5, '2313MR14FCF8', 5, 2, 5, 2, 'วิชรญาน์ กุลธนาพิชญ์', 'วิชรญาน์', '-', '2025-03-10 00:00:00'),
(6, 'CN-OP7022-71581-641-02UB-AO1', 6, 2, 5, 2, 'มนปรียา คงปล้อง', 'มนปรียา', '-', '2025-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `monitor`
--

CREATE TABLE `monitor` (
  `Monitor_ID` int(5) NOT NULL,
  `Monitor_SN` char(50) DEFAULT '',
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `monitor`
--

INSERT INTO `monitor` (`Monitor_ID`, `Monitor_SN`, `Com_ID`, `Stat_ID`, `Branch_ID`, `Department_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`) VALUES
(1, '-', 1, 2, 5, 11, 'อุไรวรรณ แซ่หลอ', 'อุไรวรรณ', '-', '2025-03-10 00:00:00'),
(2, 'CN-022ROT-72872-446-AF1M', 2, 2, 5, 11, 'ศตานันท์  หน่อทองแดง', 'ศตานันท์', '-', '2025-03-10 00:00:00'),
(3, 'CN-022ROT-72872-446-C2DM', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00'),
(4, 'CN-OXOT4K-72872-488-D15M', 4, 2, 5, 2, 'ปัทมวรรณ สองไทย', 'ปัทมวรรณ', '-', '2025-03-10 00:00:00'),
(5, '189Q2HA003359', 5, 2, 5, 2, 'วิชรญาน์ กุลธนาพิชญ์', 'วิชรญาน์', '-', '2025-03-10 00:00:00'),
(6, 'CN-022ROT-72872-446-A4DM', 6, 2, 5, 2, 'มนปรียา คงปล้อง', 'มนปรียา', '-', '2025-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mouse`
--

CREATE TABLE `mouse` (
  `Mouse_ID` int(5) NOT NULL,
  `Mouse_SN` char(50) DEFAULT '',
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mouse`
--

INSERT INTO `mouse` (`Mouse_ID`, `Mouse_SN`, `Com_ID`, `Stat_ID`, `Branch_ID`, `Department_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`) VALUES
(1, '2318HS014R08', 1, 2, 5, 11, 'อุไรวรรณ แซ่หลอ', 'อุไรวรรณ', '-', '2025-03-10 00:00:00'),
(2, 'CN-09RRC7-48729-3C6-OH2Q', 2, 2, 5, 11, 'ศตานันท์  หน่อทองแดง', 'ศตานันท์', '-', '2025-03-10 00:00:00'),
(3, 'CN-09RRC7-48729-3C8-OZF8', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00'),
(4, 'CN-09RRC7-48729-3C6-100R', 4, 2, 5, 2, 'ปัทมวรรณ สองไทย', 'ปัทมวรรณ', '-', '2025-03-10 00:00:00'),
(5, '2318HS014QX8', 5, 2, 5, 2, 'วิชรญาน์ กุลธนาพิชญ์', 'วิชรญาน์', '-', '2025-03-10 00:00:00'),
(6, 'CN-09RRC7-48729-3C6-OZDF', 6, 2, 5, 2, 'มนปรียา คงปล้อง', 'มนปรียา', '-', '2025-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notebook`
--

CREATE TABLE `notebook` (
  `NB_ID` int(5) NOT NULL,
  `NB_SN` char(15) DEFAULT NULL,
  `IPaddress` char(50) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `Os` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `powersup`
--

CREATE TABLE `powersup` (
  `Power_ID` int(5) NOT NULL,
  `Power_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(5) DEFAULT NULL,
  `Department_ID` int(5) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `powersup`
--

INSERT INTO `powersup` (`Power_ID`, `Power_SN`, `Com_ID`, `Stat_ID`, `Branch_ID`, `Department_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`) VALUES
(1, '3B2022X63909', 2, 2, 5, 11, 'ศตานันท์  หน่อทองแดง', 'ศตานันท์', '-', '2025-03-10 00:00:00'),
(2, '3B2022X63916', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00'),
(3, '3B2022X63443', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00'),
(4, 'USA0324080199', 4, 2, 5, 2, 'ปัทมวรรณ สองไทย', 'ปัทมวรรณ', '-', '2025-03-10 00:00:00'),
(5, '4B1241P07351', 5, 2, 5, 2, 'วิชรญาน์ กุลธนาพิชญ์', 'วิชรญาน์', '-', '2025-03-10 00:00:00'),
(6, 'USA0323040251', 6, 2, 5, 2, 'มนปรียา คงปล้อง', 'มนปรียา', '-', '2025-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `printer`
--

CREATE TABLE `printer` (
  `Printer_ID` int(5) NOT NULL,
  `Printer_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `printer`
--

INSERT INTO `printer` (`Printer_ID`, `Printer_SN`, `Com_ID`, `Stat_ID`, `Branch_ID`, `Department_ID`, `UserResp`, `ShortNameResp`, `Detail`, `DateAdd`) VALUES
(1, 'MK5Y017928', 3, 2, 5, 1, 'ณัฎฐ์ณรัณ วิลัยพงษ์', 'ณัฎฐ์ณรัณ', '-', '2025-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `repair_history`
--

CREATE TABLE `repair_history` (
  `repair_id` int(11) NOT NULL,
  `equipment_type` varchar(20) NOT NULL,
  `equipment_id` varchar(50) NOT NULL,
  `repair_date` date NOT NULL,
  `problem` varchar(6) DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `Stat_ID` int(20) NOT NULL,
  `repairer` varchar(100) NOT NULL,
  `repair_cost` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Branch_id` int(11) DEFAULT NULL,
  `Department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `speaker`
--

CREATE TABLE `speaker` (
  `Speaker_ID` int(5) NOT NULL,
  `Speaker_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `Stat_ID` int(5) NOT NULL,
  `Stat_name` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stat`
--

INSERT INTO `stat` (`Stat_ID`, `Stat_name`) VALUES
(1, 'เสร็จสิ้น '),
(2, 'ปกติ'),
(3, 'กำลังซ่อม'),
(4, 'รอการซ่อม '),
(5, ' รออะไหล่'),
(6, 'ส่งซ่อมภายนอก'),
(7, 'ซ่อมไม่ได้'),
(8, 'ยกเลิกการซ่อม');

-- --------------------------------------------------------

--
-- Table structure for table `switch`
--

CREATE TABLE `switch` (
  `Switch_ID` int(5) NOT NULL,
  `Switch_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tablet`
--

CREATE TABLE `tablet` (
  `Tablet_ID` int(5) NOT NULL,
  `Tablet_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wifi`
--

CREATE TABLE `wifi` (
  `Wifi_ID` int(5) NOT NULL,
  `Wifi_SN` char(15) DEFAULT NULL,
  `Com_ID` int(5) DEFAULT NULL,
  `Stat_ID` int(5) DEFAULT NULL,
  `Branch_ID` int(11) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `ShortNameResp` varchar(250) DEFAULT NULL,
  `Detail` varchar(500) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adapter`
--
ALTER TABLE `adapter`
  ADD PRIMARY KEY (`Adapter_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`Branch_ID`);

--
-- Indexes for table `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `Branch_ID` (`Branch_ID`),
  ADD KEY `Department_ID` (`Department_ID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Department_ID`);

--
-- Indexes for table `flashdrive`
--
ALTER TABLE `flashdrive`
  ADD PRIMARY KEY (`Flash_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `harddisk`
--
ALTER TABLE `harddisk`
  ADD PRIMARY KEY (`HDD_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `keyboard`
--
ALTER TABLE `keyboard`
  ADD PRIMARY KEY (`Key_ID`);

--
-- Indexes for table `monitor`
--
ALTER TABLE `monitor`
  ADD PRIMARY KEY (`Monitor_ID`);

--
-- Indexes for table `mouse`
--
ALTER TABLE `mouse`
  ADD PRIMARY KEY (`Mouse_ID`),
  ADD KEY `Com_ID` (`Com_ID`) USING BTREE;

--
-- Indexes for table `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`NB_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`);

--
-- Indexes for table `powersup`
--
ALTER TABLE `powersup`
  ADD PRIMARY KEY (`Power_ID`);

--
-- Indexes for table `printer`
--
ALTER TABLE `printer`
  ADD PRIMARY KEY (`Printer_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `repair_history`
--
ALTER TABLE `repair_history`
  ADD PRIMARY KEY (`repair_id`);

--
-- Indexes for table `speaker`
--
ALTER TABLE `speaker`
  ADD PRIMARY KEY (`Speaker_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`Stat_ID`);

--
-- Indexes for table `switch`
--
ALTER TABLE `switch`
  ADD PRIMARY KEY (`Switch_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `tablet`
--
ALTER TABLE `tablet`
  ADD PRIMARY KEY (`Tablet_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- Indexes for table `wifi`
--
ALTER TABLE `wifi`
  ADD PRIMARY KEY (`Wifi_ID`),
  ADD KEY `Stat_ID` (`Stat_ID`),
  ADD KEY `Com_ID` (`Com_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adapter`
--
ALTER TABLE `adapter`
  MODIFY `Adapter_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `Branch_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `computer`
--
ALTER TABLE `computer`
  MODIFY `Com_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Department_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `flashdrive`
--
ALTER TABLE `flashdrive`
  MODIFY `Flash_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harddisk`
--
ALTER TABLE `harddisk`
  MODIFY `HDD_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keyboard`
--
ALTER TABLE `keyboard`
  MODIFY `Key_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `monitor`
--
ALTER TABLE `monitor`
  MODIFY `Monitor_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mouse`
--
ALTER TABLE `mouse`
  MODIFY `Mouse_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `NB_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `powersup`
--
ALTER TABLE `powersup`
  MODIFY `Power_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `printer`
--
ALTER TABLE `printer`
  MODIFY `Printer_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repair_history`
--
ALTER TABLE `repair_history`
  MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speaker`
--
ALTER TABLE `speaker`
  MODIFY `Speaker_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `Stat_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `switch`
--
ALTER TABLE `switch`
  MODIFY `Switch_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tablet`
--
ALTER TABLE `tablet`
  MODIFY `Tablet_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wifi`
--
ALTER TABLE `wifi`
  MODIFY `Wifi_ID` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
