-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 10. led 2022, 18:23
-- Verze serveru: 10.4.21-MariaDB
-- Verze PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `otuzilci`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `hlavni`
--

CREATE TABLE `hlavni` (
  `id` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `klidna_voda` int(11) NOT NULL DEFAULT 0,
  `tekouci_voda` int(11) NOT NULL DEFAULT 0,
  `sprcha` int(11) NOT NULL DEFAULT 0,
  `sauna` int(11) NOT NULL DEFAULT 0,
  `id_jezero` int(11) NOT NULL,
  `id_reka` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `hlavni`
--

INSERT INTO `hlavni` (`id`, `nickname`, `email`, `klidna_voda`, `tekouci_voda`, `sprcha`, `sauna`, `id_jezero`, `id_reka`, `text`) VALUES
(1, 'Radek', 'rosigma@seznam.cz', 1, 1, 1, 0, 2, 2, 'V chladné vodě se hluboce uvolním.'),
(2, 'Mrkoska', 'marcela@gmail.com', 1, 1, 1, 1, 3, 2, 'Díky otužování vypadám dobře.'),
(3, 'Dan', 'danecek@email.cz', 0, 1, 1, 1, 2, 1, 'Cítím se skvěle po otužování.'),
(4, 'Elinka', 'elinka@email.cz', 0, 0, 1, 0, 1, 0, 'Jsem ještě malá holka, proto jen studená sprcha po kolena'),
(5, 'Petan', 'petan@centrum.cz', 0, 0, 0, 1, 2, 3, 'Zatim jen sauna, po saune na par sekund v ledove vode. '),
(7, 'Blonda', 'blonda@post.cz', 0, 0, 1, 1, 3, 1, 'Zatim pomalicku si zvykam na studenou vodu.'),
(11, 'Terka', 'lolita@email.cz', 0, 0, 0, 1, 2, 2, 'Začínám pomaličku se saunováním, pak začnu sprchu.'),
(29, 'Lorenzo', 'lamas@email.cz', 0, 1, 0, 1, 1, 3, 'pokus doma');

-- --------------------------------------------------------

--
-- Struktura tabulky `jezera`
--

CREATE TABLE `jezera` (
  `id` int(11) NOT NULL,
  `nazev` varchar(30) NOT NULL,
  `popis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `jezera`
--

INSERT INTO `jezera` (`id`, `nazev`, `popis`) VALUES
(1, 'KAL', 'Kališok Starý Bohumín'),
(2, 'STE', 'Štěrkovna Hlučín'),
(3, 'VRB', 'Vrbice Bohumín');

-- --------------------------------------------------------

--
-- Struktura tabulky `reky`
--

CREATE TABLE `reky` (
  `id` int(11) NOT NULL,
  `nazev` varchar(30) NOT NULL,
  `popis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `reky`
--

INSERT INTO `reky` (`id`, `nazev`, `popis`) VALUES
(1, 'ODR', 'Odra, splav Svinov'),
(2, 'OST', 'Ostravice, splav Vratimov'),
(3, 'CEL', 'Čeladenka, splav Čeladná');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `hlavni`
--
ALTER TABLE `hlavni`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `jezera`
--
ALTER TABLE `jezera`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `reky`
--
ALTER TABLE `reky`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `hlavni`
--
ALTER TABLE `hlavni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
