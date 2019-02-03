-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 09, 2017 at 06:01 PM
-- Server version: 5.7.15-log
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `expiringmedicines`
-- (See below for the actual view)
--
CREATE TABLE `expiringmedicines` (
`id` int(10)
,`brandName` varchar(50)
,`expiryDate` date
,`quantity` int(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(10) NOT NULL,
  `medicine_id` int(10) NOT NULL,
  `expiryDate` date NOT NULL,
  `quantity` int(30) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `medicine_id`, `expiryDate`, `quantity`) VALUES
(1, 1, '2017-09-24', 1),
(2, 2, '2017-11-17', 8),
(3, 2, '2017-11-02', 20),
(4, 3, '2017-09-28', 4),
(5, 3, '2017-08-23', 10);

-- --------------------------------------------------------

--
-- Stand-in structure for view `inventorylist`
-- (See below for the actual view)
--
CREATE TABLE `inventorylist` (
`id` int(10)
,`medicine_id` int(10)
,`brandName` varchar(50)
,`expiryDate` date
,`quantity` int(30)
,`price` float
);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicine_id` int(10) NOT NULL,
  `genericName` varchar(50) NOT NULL,
  `brandName` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `genericName`, `brandName`, `price`, `supplier_id`, `type`) VALUES
(1, 'panadol', 'panadol', 1, 1, 'pain'),
(2, 'amindazol', 'amindazol', 2, 2, 'immune system'),
(3, 'spritezona', 'sprite', 3, 3, 'consciousness');

-- --------------------------------------------------------

--
-- Stand-in structure for view `medicinelist`
-- (See below for the actual view)
--
CREATE TABLE `medicinelist` (
`medicine_id` int(10)
,`genericName` varchar(50)
,`brandName` varchar(50)
,`price` float
,`type` varchar(50)
,`supplier_name` varchar(50)
,`supplier_id` int(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthlyprofit`
-- (See below for the actual view)
--
CREATE TABLE `monthlyprofit` (
`month` int(2)
,`year` int(4)
,`profit` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthtransaction`
-- (See below for the actual view)
--
CREATE TABLE `monthtransaction` (
`transaction_id` int(10)
,`brandName` varchar(50)
,`date` date
,`quantity` int(30)
,`userName` varchar(30)
,`Price` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `smallquantitymedicines`
-- (See below for the actual view)
--
CREATE TABLE `smallquantitymedicines` (
`id` int(10)
,`brandName` varchar(50)
,`expiryDate` date
,`quantity` int(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(10) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `phone`, `email`) VALUES
(1, 'xpharma', '0912345685', 'xpharma@xpharma.com'),
(2, 'pharmaZ', '0912345685', 'pharmaZ@pharmaZ.com'),
(3, 'afarma', '0912345685', 'afarma@afarma.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `todaytransaction`
-- (See below for the actual view)
--
CREATE TABLE `todaytransaction` (
`transaction_id` int(10)
,`brandName` varchar(50)
,`date` date
,`quantity` int(30)
,`userName` varchar(30)
,`Price` double
);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `quantity` int(30) NOT NULL DEFAULT '1',
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `id`, `date`, `quantity`, `user_id`) VALUES
(2, 2, '2017-09-23', 2, 2),
(3, 1, '2017-09-23', 2, 2),
(4, 1, '2017-09-23', 1, 2),
(5, 3, '2017-09-23', 2, 2),
(6, 4, '2017-09-23', 7, 2),
(7, 1, '2017-09-23', 4, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `transactionslist`
-- (See below for the actual view)
--
CREATE TABLE `transactionslist` (
`transaction_id` int(10)
,`brandName` varchar(50)
,`medicine_id` int(10)
,`date` date
,`quantity` int(30)
,`userName` varchar(30)
,`Price` double
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstName`, `lastName`, `userName`, `password`, `role`) VALUES
(1, 'root', 'toor', 'root', '123456789', 'admin'),
(2, 'wifag', 'osama', 'wiva', '1234', 'pharmacist');

-- --------------------------------------------------------

--
-- Structure for view `expiringmedicines`
--
DROP TABLE IF EXISTS `expiringmedicines`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expiringmedicines`  AS  select `inventorylist`.`id` AS `id`,`inventorylist`.`brandName` AS `brandName`,`inventorylist`.`expiryDate` AS `expiryDate`,`inventorylist`.`quantity` AS `quantity` from `inventorylist` where ((`inventorylist`.`expiryDate` >= cast(now() as date)) and (`inventorylist`.`expiryDate` <= (cast(now() as date) + interval 2 week)) and (`inventorylist`.`quantity` > 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `inventorylist`
--
DROP TABLE IF EXISTS `inventorylist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventorylist`  AS  select `inventory`.`id` AS `id`,`medicine`.`medicine_id` AS `medicine_id`,`medicine`.`brandName` AS `brandName`,`inventory`.`expiryDate` AS `expiryDate`,`inventory`.`quantity` AS `quantity`,`medicine`.`price` AS `price` from (`inventory` join `medicine`) where ((`inventory`.`medicine_id` = `medicine`.`medicine_id`) and (`inventory`.`quantity` > 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `medicinelist`
--
DROP TABLE IF EXISTS `medicinelist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `medicinelist`  AS  select `medicine`.`medicine_id` AS `medicine_id`,`medicine`.`genericName` AS `genericName`,`medicine`.`brandName` AS `brandName`,`medicine`.`price` AS `price`,`medicine`.`type` AS `type`,`supplier`.`supplier_name` AS `supplier_name`,`supplier`.`supplier_id` AS `supplier_id` from (`medicine` join `supplier`) where (`medicine`.`supplier_id` = `supplier`.`supplier_id`) ;

-- --------------------------------------------------------

--
-- Structure for view `monthlyprofit`
--
DROP TABLE IF EXISTS `monthlyprofit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `monthlyprofit`  AS  select month(`transactionslist`.`date`) AS `month`,year(`transactionslist`.`date`) AS `year`,sum(`transactionslist`.`Price`) AS `profit` from `transactionslist` group by year(`transactionslist`.`date`),month(`transactionslist`.`date`) ;

-- --------------------------------------------------------

--
-- Structure for view `monthtransaction`
--
DROP TABLE IF EXISTS `monthtransaction`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `monthtransaction`  AS  select `transactionslist`.`transaction_id` AS `transaction_id`,`transactionslist`.`brandName` AS `brandName`,`transactionslist`.`date` AS `date`,`transactionslist`.`quantity` AS `quantity`,`transactionslist`.`userName` AS `userName`,`transactionslist`.`Price` AS `Price` from `transactionslist` where (month(`transactionslist`.`date`) = month(curdate())) ;

-- --------------------------------------------------------

--
-- Structure for view `smallquantitymedicines`
--
DROP TABLE IF EXISTS `smallquantitymedicines`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `smallquantitymedicines`  AS  select `inventorylist`.`id` AS `id`,`inventorylist`.`brandName` AS `brandName`,`inventorylist`.`expiryDate` AS `expiryDate`,`inventorylist`.`quantity` AS `quantity` from `inventorylist` where (`inventorylist`.`quantity` <= 25) ;

-- --------------------------------------------------------

--
-- Structure for view `todaytransaction`
--
DROP TABLE IF EXISTS `todaytransaction`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `todaytransaction`  AS  select `transactionslist`.`transaction_id` AS `transaction_id`,`transactionslist`.`brandName` AS `brandName`,`transactionslist`.`date` AS `date`,`transactionslist`.`quantity` AS `quantity`,`transactionslist`.`userName` AS `userName`,`transactionslist`.`Price` AS `Price` from `transactionslist` where (`transactionslist`.`date` = curdate()) ;

-- --------------------------------------------------------

--
-- Structure for view `transactionslist`
--
DROP TABLE IF EXISTS `transactionslist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transactionslist`  AS  select `transactions`.`transaction_id` AS `transaction_id`,`inventorylist`.`brandName` AS `brandName`,`inventorylist`.`medicine_id` AS `medicine_id`,`transactions`.`date` AS `date`,`transactions`.`quantity` AS `quantity`,`user`.`userName` AS `userName`,(`transactions`.`quantity` * `inventorylist`.`price`) AS `Price` from ((`transactions` join `inventorylist`) join `user`) where ((`transactions`.`id` = `inventorylist`.`id`) and (`transactions`.`user_id` = `user`.`user_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicine_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `medicine_id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicine_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`medicine_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine`
--
ALTER TABLE `medicine`
  ADD CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
