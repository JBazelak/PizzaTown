-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 27, 2024 at 01:11 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzeria`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `street` varchar(30) NOT NULL,
  `postalCode` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `first_name`, `last_name`, `email`, `city`, `street`, `postalCode`) VALUES
(1, 'Janusz', 'Kowal', 'janusz.kowal@onet.pl', 'Pisz', 'Polna 12', '12-200'),
(2, 'Marek', 'Nowak', 'marek.nowak12@gmail.com', 'Pisz', 'Dworcowa 12/3', '12-200'),
(5, 'Grzegorz', 'Brzęczyszczykiewicz', 'grzesiu@gmail.com', 'Pisz', 'Żytnia 8', '12-200'),
(6, 'Sasza', 'Kowalenko', 'saszauk@interia.pl', 'Pisz', 'Zagłoby 31', '12-200'),
(7, 'Agnieszka', 'Polak', 'aga.p@wp.pl', 'Snopki', 'Żurawia 15', '12-200'),
(8, 'Tomasz', 'Kowalski', 'tomasz.kow@onet.pl', 'Pisz', 'Sienkiewicza 16', '12-200'),
(9, 'Stefan', 'Karasiński', 'karas.stefan@o2.pl', 'Pisz', 'Gdańska 14', '12-200'),
(10, 'Karol', 'Kowalski', 'karol@wp.pl', 'Pisz', 'Wojska Polskiego 20', '12-200'),
(11, 'Arkadiusz', 'Nowicki', 'arek@gmail.com', 'Pisz', 'Dobra 8', '12-200'),
(12, 'Jacek', 'Placek', 'jacek@onet.pl', 'Pisz', 'Leśna 2', '12-200');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `pizza` text NOT NULL,
  `size` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `date` datetime NOT NULL,
  `address` text NOT NULL,
  `notes` text NOT NULL,
  `status` text NOT NULL DEFAULT 'nie zrealizowano'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `pizza`, `size`, `firstname`, `lastname`, `date`, `address`, `notes`, `status`) VALUES
(6, 'Capriciosa', 'mała', 'Marek', 'Nowak', '2024-01-26 00:00:00', 'ul.Dworcowa 12/3 | 12-200 | Pisz', 'dowoz', 'zrealizowano'),
(7, 'Margherita', 'mała', 'Janusz', 'Kowal', '2024-01-26 00:00:00', 'ul.Polna 12 | 12-200 | Pisz', 'miejsce', 'zrealizowano'),
(21, 'Margherita', 'mała', 'Sasza', 'Kowalenko', '2024-01-27 01:02:40', 'ul.Zagłoby 31 | 12-200 | Pisz', 'miejsce', 'zrealizowano');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pizzas`
--

CREATE TABLE `pizzas` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `size` varchar(7) NOT NULL,
  `price` float NOT NULL,
  `ingredients` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`ID`, `name`, `size`, `price`, `ingredients`) VALUES
(1, 'Margherita', 'mała', 20.99, 'sos pomidorowy ser mozzarella oregano'),
(2, 'Margherita', 'duża', 30.99, 'sos pomidorowy mozzarella oregano'),
(3, 'Cappriciosa', 'mała', 25.99, 'sos pomidorowy mozzarella pieczarki szynka'),
(4, 'Cappriciosa', 'duża', 32.99, 'sos pomidorowy ser mozzarella pieczarki szynka'),
(5, 'Salame', 'mała', 25.99, 'sos pomidorowy ser mozzarella salami'),
(6, 'Salame', 'duża', 32.99, 'sos pomidorowy ser mozarella salami');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `rol` varchar(8) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `pass`, `rol`) VALUES
(1, 'jankow1', '$2y$10$CDhTyp973375iX5ghJGooOu6uBwKx.IpAx4K8j/eweFEruG7Rs54i', 'customer'),
(2, 'mar12', '$2y$10$p16t.Qd.YHSBV7/XSWBY8uW60Y8pE.kM2AoF4hn0nOCJbUCOXD7oG', 'customer'),
(5, 'admin', '$2y$10$097T4du5UG60IzansV69W.XxP6I027cCB5GcSwzSL21eA0KxKnYSa', 'admin'),
(6, 'saszka', '$2y$10$Q64iN0RmFH4FqeRfXTRC0ufMhUoaGLm1OTPSmegF3ov9GVHFrQXMy', 'employee'),
(7, 'aga10', '$2y$10$kMhNMw2V85bei61By6ftC.mLo/PzT2mlo4bi4bls3tmL06FwWqz8S', 'employee'),
(8, 'tomk', '$2y$10$x8VrAdCH2ukfXL3gtVinW.gwyJLFiK2IxkyZoU/IMcnjmJ3oh9/Au', 'employee'),
(9, 'karas1', '$2y$10$SdYXdvsmNPa0XC9TfgdImu45CN5aWPepuGA11OAMegYf63lgp2shC', 'employee'),
(10, 'karol', '$2y$10$PxgyaUhef4lWMN.KKgBdU.kO6ARGsdQdjhqYS/tNqkgz1Y2Adr.0e', 'customer'),
(11, 'owner', '$2y$10$meK7lGCsQpnGA.wXem31Hur1rNeHbopTKfeye/AMNLxc31B0UrWkm', 'owner'),
(12, 'employee', '$2y$10$IRkNiu/qUbcuqI7546sBxeQEMRqQ3dF68PhKOIywTR4iHDsS/Ad5.', 'employee');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
