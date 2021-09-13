-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: global_db:3306
-- Czas generowania: 13 Wrz 2021, 15:28
-- Wersja serwera: 8.0.24
-- Wersja PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rakbook_matinf`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `authtokens`
--

CREATE TABLE `authtokens` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `selector` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `validatorhash` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `colorpurchase`
--

CREATE TABLE `colorpurchase` (
  `id` int NOT NULL,
  `buyerid` int NOT NULL,
  `colorid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `colors`
--

CREATE TABLE `colors` (
  `id` int NOT NULL,
  `colorname` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `hex` text CHARACTER SET utf8 COLLATE utf8_polish_ci,
  `colorclass` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `adminonly` tinyint(1) NOT NULL DEFAULT '0',
  `redaktoronly` tinyint(1) NOT NULL DEFAULT '0',
  `cost` int NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cytaty`
--

CREATE TABLE `cytaty` (
  `id` int NOT NULL,
  `autor` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `cytat` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `uploaderid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `maturas`
--

CREATE TABLE `maturas` (
  `id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teacher` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `number` int NOT NULL DEFAULT '1',
  `accepted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `memelikes`
--

CREATE TABLE `memelikes` (
  `id` int NOT NULL,
  `person` int NOT NULL,
  `memeid` int NOT NULL,
  `value` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `memy`
--

CREATE TABLE `memy` (
  `id` int NOT NULL,
  `authorid` int NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `file` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ponadczasowy` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `owner` int NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `autor` int NOT NULL,
  `colorclass` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `expirydate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `playlisty`
--

CREATE TABLE `playlisty` (
  `id` int NOT NULL,
  `nazwa` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `autor` int NOT NULL,
  `zawartosc` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quotelikes`
--

CREATE TABLE `quotelikes` (
  `id` int NOT NULL,
  `personid` int NOT NULL,
  `quoteid` int NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `user_pass` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `user_nrwdzienniku` int NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `redaktor` tinyint(1) NOT NULL DEFAULT '0',
  `color` int NOT NULL DEFAULT '1',
  `RakCoins` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `id` int NOT NULL,
  `category` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `link` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `date` date DEFAULT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `authtokens`
--
ALTER TABLE `authtokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indeksy dla tabeli `colorpurchase`
--
ALTER TABLE `colorpurchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyerid` (`buyerid`),
  ADD KEY `colorid` (`colorid`);

--
-- Indeksy dla tabeli `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `cytaty`
--
ALTER TABLE `cytaty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaderid` (`uploaderid`);

--
-- Indeksy dla tabeli `maturas`
--
ALTER TABLE `maturas`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `memelikes`
--
ALTER TABLE `memelikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person` (`person`),
  ADD KEY `memeid` (`memeid`);

--
-- Indeksy dla tabeli `memy`
--
ALTER TABLE `memy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorid` (`authorid`);

--
-- Indeksy dla tabeli `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorid` (`autor`);

--
-- Indeksy dla tabeli `playlisty`
--
ALTER TABLE `playlisty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Indeksy dla tabeli `quotelikes`
--
ALTER TABLE `quotelikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quoteid` (`quoteid`),
  ADD KEY `personid` (`personid`) USING BTREE;

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color` (`color`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `authtokens`
--
ALTER TABLE `authtokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `colorpurchase`
--
ALTER TABLE `colorpurchase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `cytaty`
--
ALTER TABLE `cytaty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `maturas`
--
ALTER TABLE `maturas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `memelikes`
--
ALTER TABLE `memelikes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `memy`
--
ALTER TABLE `memy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `playlisty`
--
ALTER TABLE `playlisty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `quotelikes`
--
ALTER TABLE `quotelikes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zadania`
--
ALTER TABLE `zadania`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `authtokens`
--
ALTER TABLE `authtokens`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `colorpurchase`
--
ALTER TABLE `colorpurchase`
  ADD CONSTRAINT `buyerid` FOREIGN KEY (`buyerid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `colorid` FOREIGN KEY (`colorid`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `cytaty`
--
ALTER TABLE `cytaty`
  ADD CONSTRAINT `uploaderid` FOREIGN KEY (`uploaderid`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `memelikes`
--
ALTER TABLE `memelikes`
  ADD CONSTRAINT `memeid` FOREIGN KEY (`memeid`) REFERENCES `memy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `person` FOREIGN KEY (`person`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `memy`
--
ALTER TABLE `memy`
  ADD CONSTRAINT `authorid` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `owner` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `autorid` FOREIGN KEY (`autor`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `playlisty`
--
ALTER TABLE `playlisty`
  ADD CONSTRAINT `autor` FOREIGN KEY (`autor`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `quotelikes`
--
ALTER TABLE `quotelikes`
  ADD CONSTRAINT `personid` FOREIGN KEY (`personid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quoteid` FOREIGN KEY (`quoteid`) REFERENCES `cytaty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `color` FOREIGN KEY (`color`) REFERENCES `colors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
