/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : corporate

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2025-03-20 16:57:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for adapter
-- ----------------------------
DROP TABLE IF EXISTS `adapter`;
CREATE TABLE `adapter` (
  `AdapterID` int(11) NOT NULL AUTO_INCREMENT,
  `AdapterSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`AdapterID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for assettype
-- ----------------------------
DROP TABLE IF EXISTS `assettype`;
CREATE TABLE `assettype` (
  `AssetTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `AssetTypeName` varchar(250) DEFAULT '',
  PRIMARY KEY (`AssetTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `BranchID` int(11) NOT NULL AUTO_INCREMENT,
  `BranchName` varchar(250) DEFAULT '',
  PRIMARY KEY (`BranchID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for brand
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `BrandID` int(5) NOT NULL AUTO_INCREMENT,
  `BrandName` varchar(250) DEFAULT '',
  PRIMARY KEY (`BrandID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for computer
-- ----------------------------
DROP TABLE IF EXISTS `computer`;
CREATE TABLE `computer` (
  `ComputerID` int(11) NOT NULL AUTO_INCREMENT,
  `ComputerName` varchar(250) DEFAULT '',
  `ComputerSN` varchar(250) DEFAULT NULL,
  `IPAddress` varchar(250) DEFAULT '',
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `StatusID` int(5) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT '0',
  `UserRespNickname` varchar(250) DEFAULT '',
  `OSID` int(11) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`ComputerID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `DepartmentID` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(250) DEFAULT '',
  PRIMARY KEY (`DepartmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for drive
-- ----------------------------
DROP TABLE IF EXISTS `drive`;
CREATE TABLE `drive` (
  `DriveID` int(11) NOT NULL AUTO_INCREMENT,
  `DriveSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(255) DEFAULT NULL,
  `Detail` varchar(255) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`DriveID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for harddisk
-- ----------------------------
DROP TABLE IF EXISTS `harddisk`;
CREATE TABLE `harddisk` (
  `HarddiskID` int(11) NOT NULL AUTO_INCREMENT,
  `HarddiskSN` varchar(250) DEFAULT NULL,
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`HarddiskID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for ipad
-- ----------------------------
DROP TABLE IF EXISTS `ipad`;
CREATE TABLE `ipad` (
  `iPadID` int(11) NOT NULL AUTO_INCREMENT,
  `iPadSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`iPadID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for keyboard
-- ----------------------------
DROP TABLE IF EXISTS `keyboard`;
CREATE TABLE `keyboard` (
  `KeyboardID` int(11) NOT NULL AUTO_INCREMENT,
  `KeyboardSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`KeyboardID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for monitor
-- ----------------------------
DROP TABLE IF EXISTS `monitor`;
CREATE TABLE `monitor` (
  `MonitorID` int(11) NOT NULL AUTO_INCREMENT,
  `MonitorSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`MonitorID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for mouse
-- ----------------------------
DROP TABLE IF EXISTS `mouse`;
CREATE TABLE `mouse` (
  `MouseID` int(11) NOT NULL AUTO_INCREMENT,
  `MouseSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`MouseID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for notebook
-- ----------------------------
DROP TABLE IF EXISTS `notebook`;
CREATE TABLE `notebook` (
  `NotebookID` int(11) NOT NULL AUTO_INCREMENT,
  `NotebookSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`NotebookID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for officesuite
-- ----------------------------
DROP TABLE IF EXISTS `officesuite`;
CREATE TABLE `officesuite` (
  `OfficeSuiteID` int(11) NOT NULL AUTO_INCREMENT,
  `OfficeSuiteName` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`OfficeSuiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `OrderID` int(5) NOT NULL DEFAULT 0,
  `AssetTypeID` int(5) DEFAULT 0,
  `OrderDate` date DEFAULT NULL,
  `BranchID` int(5) DEFAULT NULL,
  `DepartmentID` int(5) DEFAULT NULL,
  `UserUsername` varchar(250) DEFAULT '',
  `ReceiptDate` date DEFAULT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for os
-- ----------------------------
DROP TABLE IF EXISTS `os`;
CREATE TABLE `os` (
  `OSID` int(11) NOT NULL AUTO_INCREMENT,
  `OSName` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`OSID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for other
-- ----------------------------
DROP TABLE IF EXISTS `other`;
CREATE TABLE `other` (
  `OtherID` int(11) NOT NULL AUTO_INCREMENT,
  `OtherSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`OtherID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for printer
-- ----------------------------
DROP TABLE IF EXISTS `printer`;
CREATE TABLE `printer` (
  `PrinterID` int(11) NOT NULL AUTO_INCREMENT,
  `PrinterSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`PrinterID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for repair
-- ----------------------------
DROP TABLE IF EXISTS `repair`;
CREATE TABLE `repair` (
  `RepairID` int(11) NOT NULL AUTO_INCREMENT,
  `AssetTypeID` int(11) DEFAULT NULL,
  `EquipmentID` int(11) DEFAULT NULL,
  `RepairDate` date DEFAULT NULL,
  `Problem` varchar(250) DEFAULT NULL,
  `Solution` varchar(250) DEFAULT NULL,
  `StatusID` int(11) DEFAULT NULL,
  `Repairer` varchar(250) DEFAULT NULL,
  `RepairCost` decimal(10,0) DEFAULT NULL,
  `CompleteDate` date DEFAULT NULL,
  `Note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`RepairID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for router
-- ----------------------------
DROP TABLE IF EXISTS `router`;
CREATE TABLE `router` (
  `RouterID` int(11) NOT NULL AUTO_INCREMENT,
  `RouterSN` varchar(250) DEFAULT '',
  `StatusID` varchar(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`RouterID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for speaker
-- ----------------------------
DROP TABLE IF EXISTS `speaker`;
CREATE TABLE `speaker` (
  `SpeakerID` int(11) NOT NULL AUTO_INCREMENT,
  `SpeakerSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`SpeakerID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `StatusID` int(11) NOT NULL,
  `StatusName` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`StatusID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for switchhub
-- ----------------------------
DROP TABLE IF EXISTS `switchhub`;
CREATE TABLE `switchhub` (
  `SwitchHubID` int(11) NOT NULL AUTO_INCREMENT,
  `SwitchHubSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`SwitchHubID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for ups
-- ----------------------------
DROP TABLE IF EXISTS `ups`;
CREATE TABLE `ups` (
  `UpsID` int(11) NOT NULL AUTO_INCREMENT,
  `UpsSN` varchar(250) DEFAULT '',
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`UpsID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for usb
-- ----------------------------
DROP TABLE IF EXISTS `usb`;
CREATE TABLE `usb` (
  `USBID` int(11) NOT NULL AUTO_INCREMENT,
  `USBSN` varchar(250) DEFAULT NULL,
  `StatusID` int(5) DEFAULT NULL,
  `ComputerID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `UserResp` varchar(250) DEFAULT NULL,
  `UserRespNickname` varchar(250) DEFAULT NULL,
  `Detail` varchar(250) DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`USBID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserID` int(5) NOT NULL AUTO_INCREMENT,
  `UserUsername` varchar(250) DEFAULT '',
  `UserPassword` varchar(250) DEFAULT '',
  `UserName` varchar(250) DEFAULT '',
  `UserShortname` varchar(250) DEFAULT '',
  `UserStatus` varchar(250) DEFAULT '',
  `UserPosition` varchar(250) DEFAULT '',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
