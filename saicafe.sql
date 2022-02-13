-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2022 at 12:47 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saicafe`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_order` (IN `order_id` INT(11))  BEGIN
	SELECT orh.orh_refcode AS reference_code, CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name, s.s_name AS shop_name,f.f_name AS food_name,ord.ord_buyprice AS buy_price, ord.ord_amount AS amount ,ord.ord_note AS order_note, orh.orh_ordertime AS order_time , orh.orh_pickuptime AS pickup_time
    FROM order_header orh 
    INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE orh.orh_id = order_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_order_history` (IN `customer_id` INT(11))  BEGIN
	SELECT orh.orh_refcode AS reference_code, CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name,
    s.s_name AS shop_name, orh.orh_ordertime AS order_time, orh.orh_pickuptime AS pickup_time,
    p.p_amount AS order_cost, orh.orh_orderstatus AS order_status
    FROM order_header orh INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN payment p ON orh.p_id = p.p_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE c.c_id = customer_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shop_alltime_revenue` (IN `shop_id` INT(11))  BEGIN
	SELECT SUM(ord.ord_amount*ord.ord_buyprice) AS alltime_revenue 
    FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id INNER JOIN shop s ON s.s_id = orh.s_id
    WHERE s.s_id = shop_id AND orh.orh_orderstatus = 'FNSH';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shop_menu_revenue` (IN `shop_id` INT(11))  BEGIN
	SELECT f.f_name AS food_name, SUM(ord.ord_amount*ord.ord_buyprice) AS menu_revenue
    FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    WHERE orh.s_id = shop_id AND orh.orh_orderstatus = 'FNSH'
    GROUP BY ord.f_id ORDER BY menu_revenue DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ct_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ct_amount` int(11) NOT NULL,
  `ct_note` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `c_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_pwd` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'M for Male, F for Female',
  `c_type` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Type of customer in this canteen (STD for student, INS for instructor, STF for staff, GUE for guest, ADM for admin, OTH for other)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_username`, `c_pwd`, `c_firstname`, `c_lastname`, `c_email`, `c_gender`, `c_type`) VALUES
(2, 'keerthi', 'keerthi', 'keerthi', 'G', 'keerthi@gmail.com', 'F', 'STD'),
(3, 'magesh', '123', 'Magesh', 'K', 'magesh@gmail.com', 'M', 'STD'),
(4, 'admin', '12345678', 'Admin', 'sai', 'admin_sai@gmail.com', 'M', 'ADM'),
(11, 'selva', '123', 'Selva', 'Narayanan', 'someone@email.com', 'N', 'GUE'),
(16, 'Selvanarayanan', '123', 'Selvanarayanan', 'A', 'selva@gmail.com', 'M', 'STD'),
(19, 'dharani', '123', 'dharani', 'S', 'dharani@gmail.com', 'M', 'GUE'),
(20, 'johndoe', '123', 'John', 'G', 'john@gmail.com', 'F', 'STF');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `f_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_price` decimal(6,2) NOT NULL,
  `f_todayavail` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Food is available to order or not',
  `f_preorderavail` tinyint(4) NOT NULL DEFAULT 1,
  `f_pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`f_id`, `s_id`, `f_name`, `f_price`, `f_todayavail`, `f_preorderavail`, `f_pic`) VALUES
(1, 1, 'Chicken Noodles', '90.00', 1, 0, '1_1.jpg'),
(2, 1, 'Veg Fried Rice', '55.00', 1, 1, '2_1.jpg'),
(3, 1, 'Chappathi', '35.00', 1, 1, '3_1.jfif'),
(4, 1, 'Chicken Biryani', '90.00', 1, 1, '4_1.jpg'),
(5, 1, 'Chicken Fried Rice', '80.00', 1, 1, '5_1.jpg'),
(6, 1, 'Paneer Fried Rice', '65.00', 1, 1, '6_1.jpg'),
(9, 1, 'Shawarma', '70.00', 1, 1, '9_1.jpg'),
(12, 2, 'Chicken Biryani', '90.00', 1, 1, '12_2.jpg'),
(13, 2, 'Veg Fried Rice', '65.00', 1, 1, '13_2.jpg'),
(14, 2, 'Paneer Fried Rice', '75.00', 1, 1, '14_2.jpg'),
(15, 2, 'Chicken Noodles', '80.00', 1, 1, '15_2.jpg'),
(19, 2, 'Chappathi', '35.00', 1, 1, '19_2.jfif'),
(20, 2, 'Chicken Fried Rice', '85.00', 1, 1, '20_2.jpg'),
(21, 3, 'Chicken Noodles', '75.00', 1, 1, '21_3.jpg'),
(22, 3, 'Chicken Biryani', '90.00', 1, 1, '22_3.jpg'),
(23, 3, 'Veg Fried Rice', '65.00', 1, 1, '23_3.jpg'),
(28, 3, 'Chappathi', '35.00', 1, 1, '28_3.jfif'),
(29, 3, 'Paneer Fried Rice', '75.00', 1, 1, '29_3.jpg'),
(30, 3, 'Chicken Fried Rice', '80.00', 1, 1, '30_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `ord_id` int(11) NOT NULL,
  `orh_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ord_amount` int(11) NOT NULL,
  `ord_buyprice` decimal(6,2) NOT NULL COMMENT 'To keep the snapshot of selected menu cost at the time of the purchase.',
  `ord_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`ord_id`, `orh_id`, `f_id`, `ord_amount`, `ord_buyprice`, `ord_note`) VALUES
(25, 22, 28, 2, '40.00', ''),
(26, 22, 22, 1, '30.00', ''),
(27, 23, 13, 1, '30.00', ''),
(28, 23, 14, 1, '30.00', ''),
(29, 24, 22, 1, '30.00', 'No veggie'),
(30, 25, 29, 3, '10.00', ''),
(31, 26, 1, 1, '40.00', ''),
(32, 26, 3, 1, '40.00', ''),
(33, 27, 9, 1, '40.00', ''),
(34, 27, 2, 1, '55.00', ''),
(35, 28, 12, 2, '30.00', ''),
(36, 28, 13, 2, '30.00', ''),
(37, 29, 13, 3, '30.00', ''),
(38, 30, 22, 1, '30.00', ''),
(39, 31, 1, 3, '40.00', ''),
(40, 32, 14, 1, '30.00', ''),
(41, 33, 1, 3, '40.00', ''),
(42, 34, 4, 5, '30.00', ''),
(43, 35, 12, 3, '30.00', ''),
(44, 36, 14, 5, '30.00', ''),
(45, 37, 1, 6, '40.00', ''),
(46, 38, 13, 3, '30.00', ''),
(47, 39, 13, 5, '30.00', ''),
(48, 40, 13, 1, '30.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_header`
--

CREATE TABLE `order_header` (
  `orh_id` int(11) NOT NULL,
  `orh_refcode` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `orh_ordertime` timestamp NOT NULL DEFAULT current_timestamp(),
  `orh_pickuptime` datetime NOT NULL,
  `orh_orderstatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orh_finishedtime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_header`
--

INSERT INTO `order_header` (`orh_id`, `orh_refcode`, `c_id`, `s_id`, `p_id`, `orh_ordertime`, `orh_pickuptime`, `orh_orderstatus`, `orh_finishedtime`) VALUES
(22, '202110280000022', 16, 3, 20, '2021-10-28 18:25:53', '2021-10-29 08:30:00', 'FNSH', '2021-11-09 01:55:19'),
(23, '202110290000023', 16, 2, 21, '2021-10-28 19:13:22', '2021-10-29 12:00:00', 'FNSH', '2021-11-14 16:44:32'),
(24, '202110290000024', 16, 3, 22, '2021-10-29 05:22:06', '2021-10-29 13:00:00', 'FNSH', '2021-11-15 12:42:47'),
(25, '202110290000025', 19, 3, 23, '2021-10-29 07:57:07', '2021-10-29 15:00:00', 'FNSH', '2021-11-15 12:17:21'),
(26, '202112290000026', 2, 1, 24, '2021-12-29 04:53:43', '2021-12-29 11:52:00', 'FNSH', '2021-12-29 11:55:21'),
(27, '202112290000027', 2, 1, 25, '2021-12-29 08:37:59', '2021-12-30 12:00:00', 'FNSH', '2021-12-29 16:01:52'),
(28, '202112290000028', 2, 2, 26, '2021-12-29 09:45:47', '2021-12-29 16:45:00', 'FNSH', '2021-12-29 17:04:00'),
(29, '202112290000029', 2, 2, 27, '2021-12-29 10:02:28', '2021-12-29 17:01:00', 'FNSH', '2021-12-30 13:10:29'),
(30, '202112290000030', 2, 3, 28, '2021-12-29 10:06:31', '2021-12-30 12:30:00', 'ACPT', NULL),
(31, '202112300000031', 3, 1, 29, '2021-12-30 05:58:56', '2021-12-30 12:58:00', 'FNSH', '2021-12-30 13:00:00'),
(32, '202112300000032', 16, 2, 30, '2021-12-30 06:09:09', '2021-12-30 13:08:00', 'FNSH', '2021-12-30 13:10:33'),
(33, '202112300000033', 3, 1, 31, '2021-12-30 06:22:04', '2021-12-30 13:19:00', 'FNSH', '2021-12-30 13:26:34'),
(34, '202112300000034', 3, 1, 32, '2021-12-30 06:43:37', '2021-12-30 13:42:00', 'FNSH', '2021-12-30 13:47:24'),
(35, '202112300000035', 16, 2, 33, '2021-12-30 09:03:07', '2021-12-30 16:01:00', 'FNSH', '2021-12-30 16:04:31'),
(36, '202112300000036', 3, 2, 34, '2021-12-30 09:13:55', '2021-12-30 16:12:00', 'FNSH', '2021-12-30 16:15:17'),
(37, '202112310000037', 2, 1, 35, '2021-12-31 06:10:06', '2021-12-31 13:09:00', 'FNSH', '2021-12-31 13:12:44'),
(38, '202201030000038', 11, 2, 36, '2022-01-03 10:14:06', '2022-01-03 17:13:00', 'ACPT', NULL),
(39, '202202120000039', 3, 2, 37, '2022-02-12 10:49:38', '2022-02-13 08:00:00', 'ACPT', NULL),
(40, '202202120000040', 3, 2, 38, '2022-02-12 11:29:56', '2022-02-13 08:00:00', 'ACPT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `p_type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_amount` decimal(7,2) NOT NULL,
  `p_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `c_id`, `p_type`, `p_amount`, `p_detail`) VALUES
(20, 16, 'CRDC', '110.00', 'Visa [*4242]'),
(21, 16, 'CRDC', '60.00', 'Visa [*4242]'),
(22, 16, 'CRDC', '30.00', 'Visa [*4242]'),
(23, 19, 'CRDC', '30.00', 'Visa [*4242]'),
(24, 2, 'CRDC', '80.00', 'Visa [*4343]'),
(25, 2, 'CRDC', '95.00', 'Visa [*2350]'),
(26, 2, 'CRDC', '120.00', 'Visa [*2350]'),
(27, 2, 'CRDC', '90.00', 'Visa [*2350]'),
(28, 2, 'CRDC', '30.00', 'Visa [*2350]'),
(29, 3, 'CRDC', '120.00', 'Visa [*3671]'),
(30, 16, 'CRDC', '30.00', 'Visa [*3671]'),
(31, 3, 'CRDC', '120.00', 'Visa [*3671]'),
(32, 3, 'CRDC', '150.00', 'Visa [*3671]'),
(33, 16, 'DBTC', '90.00', 'Visa [*7229]'),
(34, 3, 'DBTC', '150.00', 'Visa [*7229]'),
(35, 2, 'CRDC', '240.00', 'Visa [*8716]'),
(36, 11, 'CRDC', '90.00', 'Visa [*0403]'),
(37, 3, 'DBTC', '150.00', 'MasterCard [*9256]'),
(38, 3, 'DBTC', '30.00', 'Visa [*6055]');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `s_id` int(11) NOT NULL,
  `s_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_pwd` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_openhour` time NOT NULL,
  `s_closehour` time NOT NULL,
  `s_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Shop ready for taking an order or not (True for open, False for close)',
  `s_preorderStatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Shop is ready for tomorrow pre-order or not',
  `s_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_phoneno` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`s_id`, `s_username`, `s_pwd`, `s_name`, `s_location`, `s_openhour`, `s_closehour`, `s_status`, `s_preorderStatus`, `s_email`, `s_phoneno`, `s_pic`) VALUES
(1, 'sec', '123', 'Engineering', 'Unit #2', '07:30:00', '14:30:00', 1, 1, 'sec@gmail.com', '0900001234', 'shop1.jpeg'),
(2, 'sit', '123', 'Institute', 'Unit #1', '08:00:00', '17:30:00', 1, 1, 'sit@gmail.com', '0900000002', NULL),
(3, 'siddha', '123', 'Medical', 'Unit #3', '08:30:00', '16:00:00', 1, 1, 'siddha@gmail.com', '0901234567', 'shop3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ct_id`),
  ADD KEY `fk_ct_c_idx` (`c_id`),
  ADD KEY `fk_ct_s_idx` (`s_id`),
  ADD KEY `fk_ct_f_idx` (`f_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_username` (`c_username`),
  ADD UNIQUE KEY `c_email` (`c_email`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `food_shop_s_id_idx` (`s_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `fk_orh_ord_idx` (`orh_id`),
  ADD KEY `fk_f_ord_idx` (`f_id`);

--
-- Indexes for table `order_header`
--
ALTER TABLE `order_header`
  ADD PRIMARY KEY (`orh_id`),
  ADD KEY `fk_orh_idx` (`c_id`),
  ADD KEY `fk_s_orh_idx` (`s_id`),
  ADD KEY `fk_p_orh_idx` (`p_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_c_fk_idx` (`c_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `order_header`
--
ALTER TABLE `order_header`
  MODIFY `orh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_ct_c` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ct_f` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ct_s` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_food_shop_id` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_f_ord` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`),
  ADD CONSTRAINT `fk_orh_ord` FOREIGN KEY (`orh_id`) REFERENCES `order_header` (`orh_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_header`
--
ALTER TABLE `order_header`
  ADD CONSTRAINT `fk_c_orh` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_p_orh` FOREIGN KEY (`p_id`) REFERENCES `payment` (`p_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_s_orh` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_p_c` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
