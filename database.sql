-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 23, 2020 at 12:42 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `authtokens`
--

CREATE TABLE `authtokens` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `selector` text COLLATE utf8_polish_ci NOT NULL,
  `validatorhash` text COLLATE utf8_polish_ci NOT NULL,
  `expires` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colorpurchase`
--

CREATE TABLE `colorpurchase` (
  `id` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL,
  `colorid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `colorname` text COLLATE utf8_polish_ci NOT NULL,
  `hex` text COLLATE utf8_polish_ci DEFAULT NULL,
  `colorclass` text COLLATE utf8_polish_ci NOT NULL,
  `adminonly` tinyint(1) NOT NULL DEFAULT 0,
  `redaktoronly` tinyint(1) NOT NULL DEFAULT 0,
  `cost` int(11) NOT NULL DEFAULT 1000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `colorname`, `hex`, `colorclass`, `adminonly`, `redaktoronly`, `cost`) VALUES
(1, 'Styl domyślny', NULL, 'NormalNameStyle', 0, 0, 0),
(2, 'Admin', '#FF69B4', 'AdminNameStyle', 1, 0, 0),
(3, 'Redaktor', '#BDB76B', 'RedaktorNameStyle', 0, 1, 0),
(4, 'Niebieski', '#0000FF', 'BlueNameStyle', 0, 0, 10),
(5, 'Incognito', '#000000', 'BlackNameStyle', 0, 0, 100),
(6, 'Głęboki kolor nieba', '#00BFFF', 'DeepSkyBlueNameStyle', 0, 0, 20),
(7, 'Wiosenny Zielony', '#00FF7F', 'SpringGreenNameStyle', 0, 0, 20),
(8, 'Zielony', '#008000', 'GreenNameStyle', 0, 0, 10),
(9, 'Czerwony', '#FF0000', 'RedNameStyle', 0, 0, 10),
(10, '#0BACA0', '#0BACA0', 'BacaNameStyle', 0, 0, 100),
(11, 'Amarantowy', '#E61C66', 'AmarantowyNameStyle', 0, 0, 50),
(12, 'Autorski', NULL, 'SkopiowanyZInternetu', 1, 0, 0),
(14, 'Słoneczna Pomarańcza', '#ff8000', 'FruitOrange', 0, 0, 30),
(15, 'Gęsta trawa', '#517F19', 'GrassGreen', 0, 0, 30),
(16, 'Dojrzały banan', '#FFC100', 'BananaYellow', 0, 0, 30),
(17, 'Dorodna śliwka', '#884EA0', 'PlumPurple', 0, 0, 30),
(18, 'Szumiący Strumień', '#195EA5', 'StreamBlue', 0, 0, 30),
(19, 'Plażowy Krab', '#ED3333', 'CrabRed', 0, 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `cytaty`
--

CREATE TABLE `cytaty` (
  `id` int(11) NOT NULL,
  `autor` text COLLATE utf8_polish_ci NOT NULL,
  `cytat` text COLLATE utf8_polish_ci NOT NULL,
  `uploaderid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memelikes`
--

CREATE TABLE `memelikes` (
  `id` int(11) NOT NULL,
  `person` int(11) NOT NULL,
  `memeid` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memy`
--

CREATE TABLE `memy` (
  `id` int(11) NOT NULL,
  `authorid` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `file` text COLLATE utf8_polish_ci NOT NULL,
  `ponadczasowy` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `text` text COLLATE utf8_polish_ci NOT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor` int(11) NOT NULL,
  `colorclass` text COLLATE utf8_polish_ci NOT NULL,
  `expirydate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlisty`
--

CREATE TABLE `playlisty` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `autor` int(11) NOT NULL,
  `zawartosc` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotelikes`
--

CREATE TABLE `quotelikes` (
  `id` int(11) NOT NULL,
  `personid` int(11) NOT NULL,
  `quoteid` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` text COLLATE utf8_polish_ci NOT NULL,
  `user_pass` text COLLATE utf8_polish_ci NOT NULL,
  `user_nrwdzienniku` int(11) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 0,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  `redaktor` tinyint(1) NOT NULL DEFAULT 0,
  `color` int(11) NOT NULL DEFAULT 1,
  `RakCoins` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zadania`
--

CREATE TABLE `zadania` (
  `id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `link` text COLLATE utf8_polish_ci NOT NULL,
  `date` date DEFAULT NULL DEFAULT 0,
  `accepted` int(11) NOT NULL DEFAULT 0 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authtokens`
--
ALTER TABLE `authtokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `colorpurchase`
--
ALTER TABLE `colorpurchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyerid` (`buyerid`),
  ADD KEY `colorid` (`colorid`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cytaty`
--
ALTER TABLE `cytaty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaderid` (`uploaderid`);

--
-- Indexes for table `memelikes`
--
ALTER TABLE `memelikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person` (`person`),
  ADD KEY `memeid` (`memeid`);

--
-- Indexes for table `memy`
--
ALTER TABLE `memy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorid` (`authorid`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorid` (`autor`);

--
-- Indexes for table `playlisty`
--
ALTER TABLE `playlisty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Indexes for table `quotelikes`
--
ALTER TABLE `quotelikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quoteid` (`quoteid`),
  ADD KEY `personid` (`personid`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color` (`color`);

--
-- Indexes for table `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authtokens`
--
ALTER TABLE `authtokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `colorpurchase`
--
ALTER TABLE `colorpurchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `cytaty`
--
ALTER TABLE `cytaty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `memelikes`
--
ALTER TABLE `memelikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `memy`
--
ALTER TABLE `memy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `playlisty`
--
ALTER TABLE `playlisty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `quotelikes`
--
ALTER TABLE `quotelikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `zadania`
--
ALTER TABLE `zadania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authtokens`
--
ALTER TABLE `authtokens`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `colorpurchase`
--
ALTER TABLE `colorpurchase`
  ADD CONSTRAINT `buyerid` FOREIGN KEY (`buyerid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `colorid` FOREIGN KEY (`colorid`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cytaty`
--
ALTER TABLE `cytaty`
  ADD CONSTRAINT `uploaderid` FOREIGN KEY (`uploaderid`) REFERENCES `users` (`id`);

--
-- Constraints for table `memelikes`
--
ALTER TABLE `memelikes`
  ADD CONSTRAINT `memeid` FOREIGN KEY (`memeid`) REFERENCES `memy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `person` FOREIGN KEY (`person`) REFERENCES `users` (`id`);

--
-- Constraints for table `memy`
--
ALTER TABLE `memy`
  ADD CONSTRAINT `authorid` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `owner` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `autorid` FOREIGN KEY (`autor`) REFERENCES `users` (`id`);

--
-- Constraints for table `playlisty`
--
ALTER TABLE `playlisty`
  ADD CONSTRAINT `autor` FOREIGN KEY (`autor`) REFERENCES `users` (`id`);

--
-- Constraints for table `quotelikes`
--
ALTER TABLE `quotelikes`
  ADD CONSTRAINT `personid` FOREIGN KEY (`personid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quoteid` FOREIGN KEY (`quoteid`) REFERENCES `cytaty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `color` FOREIGN KEY (`color`) REFERENCES `colors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
