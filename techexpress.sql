-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Nov 27, 2014 at 03:23 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `techexpress`
--
CREATE DATABASE IF NOT EXISTS `techexpress` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `techexpress`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
`categoryID` int(3) NOT NULL,
  `categoryName` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Uncategorized'),
(2, 'Video Cards'),
(3, 'Motherboards'),
(4, 'Cases'),
(5, 'Power Supplies'),
(6, 'CPUs'),
(7, 'Cooling');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
`departmentID` int(3) NOT NULL,
  `departmentName` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`) VALUES
(1, 'administrator'),
(2, 'General Staff');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
`employeeID` int(3) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salary` double(9,2) NOT NULL,
  `departmentID` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeID`, `username`, `password`, `salary`, `departmentID`) VALUES
(1, 'admin', 'admin', 1000000.00, 1),
(5, 'tony', 'tiger', 400.00, 2),
(6, 'carlton', 'banks', 7800.99, 1),
(7, 'robert', 'barone', 10.50, 2),
(8, 'george', 'costanza', 0.99, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
`orderID` int(3) NOT NULL,
  `employeeID` int(3) NOT NULL,
  `orderDate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderID`, `employeeID`, `orderDate`) VALUES
(3, 1, '2014-11-24'),
(9, 1, '2014-11-24'),
(11, 1, '2014-11-25'),
(12, 8, '2014-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
`orderItemID` int(3) NOT NULL,
  `orderID` int(3) NOT NULL,
  `quantity` int(3) NOT NULL,
  `productID` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderItemID`, `orderID`, `quantity`, `productID`) VALUES
(11, 9, 2, 3),
(12, 9, 2, 7),
(14, 9, 2, 16),
(15, 3, 3, 3),
(16, 3, 2, 11),
(17, 3, 1, 14),
(26, 9, 3, 8),
(27, 9, 3, 10),
(28, 9, 1, 3),
(29, 9, 1, 13),
(31, 11, 3, 3),
(32, 11, 2, 8),
(33, 11, 1, 15),
(34, 11, 1, 10),
(35, 11, 1, 7),
(36, 12, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
`productID` int(3) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productDescription` varchar(2000) NOT NULL,
  `productPrice` decimal(6,2) NOT NULL,
  `productStock` int(3) NOT NULL,
  `productImage` varchar(200) NOT NULL,
  `soldCount` int(3) NOT NULL,
  `categoryID` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `productDescription`, `productPrice`, `productStock`, `productImage`, `soldCount`, `categoryID`) VALUES
(3, 'Intel Core i7-5820K Haswell-E 6-Core 3.3GHz LGA 2011-v3', 'With previous generation Intel® Core™ i7 processors access multiple applications faster and unleash incredible digital media creation. Experience great performance for everything you do with the combination of Intel® Turbo Boost Technology and Intel® Hyper-Threading Technology (Intel® HT Technology), which maximizes performance to match your workload.', 414.99, 100, '/img/products/546fa1dc10c47.jpg', 5, 6),
(4, 'AMD FX-8350 Black Edition Vishera 8-Core 4.0GHz ', 'We call it the new AMD FX 8-Core Processor Black Edition and it''s unlocked for your overclocking pleasure.Experience unmatched multitasking and pure core performance with the industry''s first 32nm 8-core desktop processor. Get the speed you crave with AMD Turbo CORE Technology to push your core frequencies to the limit when you need it most. Go beyond the limits of maximum speed with easy-to-use AMD OverDrive™ technology and AMD Catalyst™ Control Center™ software suites. But the best part of all', 199.99, 100, '/img/products/FX-8350.jpg', 2, 6),
(5, 'Intel Core i5-4430 Haswell Quad-Core 3.0GHz LGA 1150', 'New 4th generation Intel Core processors give customers power to play, create, entertain, or inspire. Intel''s Core i5 includes powerful integrated graphics and the ability to multi-task with ease.', 194.99, 100, '/img/products/i5-4430.jpg', 12, 6),
(7, 'Corsair Obsidian Series 900D', 'The Corsair 900D is the ideal case for large system building that makes use of water cooling. The 900D has room for tons of radiators and fans to keep your hardware cool.', 299.99, 100, '/img/products/546fb108e291b.png', 13, 4),
(8, 'Fractal Design XL R2', 'Fractal Design builds on the success of its awarding-winning Define XL computer case with the Define XL R2. This updated chassis carries on the family tradition of providing superb cooling and ventilation capabilities with exceptional expandability, in a sleek and stylish Scandinavian form.', 134.99, 100, '/img/products/546fb2e397515.jpg', 33, 4),
(9, 'Noctua NH-D14 120mm & 140mm SSO CPU Cooler', 'Combining a massive six heatpipe dual radiator design with an exquisite NF-P14/NF-P12 dual fan configuration, the NH-D14 is built for ultimate quiet cooling performance. Topped off with a tube of Noctua’s award-winning NT-H1 thermal compound as well as the new SecuFirm2 multi-socket mounting system, the NH-D14 is an elite choice for the highest demands in premium quality quiet cooling.', 84.99, 100, '/img/products/546fb36b35940.jpg', 21, 7),
(10, 'CORSAIR Hydro Series H110 Water Cooler 280mm', 'Say goodbye to a stock air cooler, and upgrade from your bulky air cooler to the efficiency and simplicity of liquid CPU cooling. Enjoy better cooling performance and lower noise, and protect your investment in your CPU with the CORSAIR Hydro Series H110 water cooler.', 108.00, 15, '/img/products/546fb3e873f9d.jpg', 0, 7),
(11, 'MSI X99S GAMING 9 AC', 'MSI GAMING motherboards are designed to provide gamers with best-in-class features and technology. Backed by the imposing looks of MSI Dragon, each motherboard is an engineering masterpiece tailored to gaming perfection.', 479.99, 100, '/img/products/5472bac917b86.png', 6, 3),
(13, 'Asus P8P67', 'The worlds first Dual Intelligent Processors from ASUS pioneered the use of two onboard chips - EPU (Energy Processing Unit) and TPU (TurboV Processing Unit). New generation Dual Intelligent Processors 2 with DIGI+ VRM digital power design launch control into a new era.', 199.99, 100, '/img/products/5472bd2bb6ecd.jpg', 14, 3),
(14, 'NVIDIA Titan Z', 'GeForce GTX TITAN Z is a gaming monster, built to power the most extreme gaming rigs on the planet. It is designed with the highest-grade components to deliver the best experience – incredible speed and cool, quiet performance — all in a stunningly crafted aluminum case. you can game on multi-monitor displays and hyper PCs at high settings and super-fast frame rates and even add a second card and immerse yourself in graphically intense games in full 4K Surround.', 3299.99, 100, '/img/products/5472bde7561b4.jpg', 56, 2),
(15, 'MSI AMD Radeon R9 290X', 'A graphics card is the single most important element for more FPS. As gamers, we understand that not just any graphics card will do. That is why we bring you the best of the best. We dont want to bug you with noise and heat, but we DO want to give you more performance. With MSI GAMING series graphics cards you get just that.', 359.99, 100, '/img/products/5472be993800a.jpg', 18, 2),
(16, 'Corsair RM Series 750 Watt 80PLUS Gold PSU', 'The Corsair RM750 is fully modular and optimized for silence and high efficiency. It is built with low-noise capacitors and transformers, and Zero RPM Fan Mode ensures that the fan does not even spin until the power supply is under heavy load. And with a fan that is custom-designed for low noise operation, it is whisper-quiet even when it is pushed hard. 80 PLUS Gold rated efficiency saves you money on your power bill, and the low-profile black cables are fully modular, so you can enjoy fast, neat builds. ', 119.99, 100, '/img/products/5472bf44067c9.jpg', 35, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale` (
`saleID` int(3) NOT NULL,
  `productID` int(3) NOT NULL,
  `discount` decimal(2,0) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`saleID`, `productID`, `discount`, `startDate`, `endDate`) VALUES
(23, 14, 10, '2014-11-24', '2014-12-31'),
(24, 9, 20, '2014-11-24', '2014-12-03'),
(26, 16, 20, '2014-11-28', '2014-12-01'),
(28, 3, 15, '2014-11-26', '2014-12-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
 ADD PRIMARY KEY (`employeeID`), ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
 ADD PRIMARY KEY (`orderID`), ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
 ADD PRIMARY KEY (`orderItemID`), ADD KEY `orderID` (`orderID`), ADD KEY `productID` (`productID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`productID`), ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
 ADD PRIMARY KEY (`saleID`), ADD KEY `productID` (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `categoryID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `departmentID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
MODIFY `employeeID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `orderID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
MODIFY `orderItemID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `productID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
MODIFY `saleID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
ADD CONSTRAINT `emp_dept_fk` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
ADD CONSTRAINT `order_emp_fk` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
ADD CONSTRAINT `orderitem_order_fk` FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `orderitem_product_fk` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_category_fk` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
ADD CONSTRAINT `sale_product_fk` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
