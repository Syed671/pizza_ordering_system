-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 11, 2024 at 02:44 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_ordering_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `final_orders`
--

DROP TABLE IF EXISTS `final_orders`;
CREATE TABLE IF NOT EXISTS `final_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `topping_ids` text,
  `pizza_amout` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
CREATE TABLE IF NOT EXISTS `pizzas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`id`, `name`) VALUES
(1, 'Farmhouse'),
(2, 'Margarita'),
(3, 'Peppy Paneer');

-- --------------------------------------------------------

--
-- Table structure for table `pizzas_details`
--

DROP TABLE IF EXISTS `pizzas_details`;
CREATE TABLE IF NOT EXISTS `pizzas_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_relation` tinyint NOT NULL,
  `size` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizzas_details`
--

INSERT INTO `pizzas_details` (`id`, `name_relation`, `size`, `price`) VALUES
(1, 1, 'Small', 10.56),
(2, 1, 'Medium', 20.53),
(3, 1, 'Large', 30.13),
(4, 2, 'Small', 10.56),
(5, 2, 'Medium', 20.53),
(6, 2, 'Large', 30.13),
(7, 3, 'Small', 10.56),
(8, 3, 'Medium', 20.53),
(9, 3, 'Large', 30.13);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_orders`
--

DROP TABLE IF EXISTS `pizza_orders`;
CREATE TABLE IF NOT EXISTS `pizza_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL DEFAULT '0',
  `pizza_id` int NOT NULL,
  `size_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toppings`
--

DROP TABLE IF EXISTS `toppings`;
CREATE TABLE IF NOT EXISTS `toppings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `toppings`
--

INSERT INTO `toppings` (`id`, `name`, `price`) VALUES
(1, 'Extra Cheese', 1.50),
(2, 'Jalapenos', 1.00),
(3, 'Sweet Corn', 0.75),
(4, 'Extra Veggies', 1.25);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
