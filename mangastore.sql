-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 07 nov. 2020 à 23:45
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mangastore`
--

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(1, 'Araki Hirohiko'),
(2, 'Masahi Kishimoto'),
(3, 'Akira Toriyama'),
(4, 'Riichiro Inagaki'),
(5, 'Yuusuke Murata'),
(6, 'Kohji Kumeta'),
(7, 'Tamiki Wakaki'),
(8, 'Boichi'),
(9, 'Ryôji Minagawa'),
(10, 'Eichiro Oda'),
(11, 'Tsukasa Hojo'),
(12, 'Shinobu Kaitani'),
(13, 'Hiromu Arakawa'),
(14, 'Tsugumi Oba'),
(15, 'ONE'),
(16, 'Kentaro Miura'),
(17, 'Hajime Isayama'),
(18, 'Sui Ishida'),
(19, 'Tite Kubo'),
(20, 'Kohei Horikoshi'),
(21, 'Hiro Mashima'),
(22, 'Inio Asano'),
(23, 'Yoshitoki Oima'),
(32, 'Hayashida Q');

-- --------------------------------------------------------

--
-- Structure de la table `authors_series`
--

CREATE TABLE `authors_series` (
  `serie_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `authors_series`
--

INSERT INTO `authors_series` (`serie_id`, `author_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 4),
(7, 8),
(8, 9),
(9, 10),
(10, 11),
(11, 12),
(12, 13),
(13, 14),
(14, 15),
(15, 16),
(16, 17),
(17, 18),
(18, 19),
(19, 20),
(20, 21),
(21, 22),
(22, 23),
(30, 32);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_parent`) VALUES
(1, 'Action', 6),
(2, 'Aventure', 6),
(3, 'Combat', 6),
(4, 'Romance', 7),
(5, 'Seinen', NULL),
(6, 'Shonen', NULL),
(7, 'Shoujo', NULL),
(8, 'Fantaisie', 6),
(9, 'Sport', 6),
(10, 'Comédie', 6),
(11, 'Horreur', 5);

-- --------------------------------------------------------

--
-- Structure de la table `editors`
--

CREATE TABLE `editors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `editors`
--

INSERT INTO `editors` (`id`, `name`) VALUES
(1, 'Glénat'),
(2, 'Kana'),
(3, 'Kazé'),
(4, 'Ki-oon'),
(5, 'Pika édition'),
(6, 'Tonkam'),
(7, 'Panini'),
(8, 'Kurokawa'),
(9, 'Soleil');

-- --------------------------------------------------------

--
-- Structure de la table `mangas`
--

CREATE TABLE `mangas` (
  `id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mangas`
--

INSERT INTO `mangas` (`id`, `serie_id`, `volume`, `stock`, `image`, `release_date`) VALUES
(1, 1, 1, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-1.jpg', '2013-01-23'),
(2, 1, 2, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-2.jpg', '2013-02-27'),
(3, 2, 1, 50, 'naruto/naruto-1.jpg', '2002-03-09'),
(4, 3, 1, 10, 'dragon-ball/dragon-ball-1.jpeg', '1993-05-24'),
(5, 4, 1, 30, 'eyeshield-21/eyeshield-21-1.jpg', '2005-03-16'),
(6, 5, 1, 15, 'sayonara-monsieur-desespoir/sayonara-monsieur-desespoir-1.jpg', '2009-03-18'),
(7, 6, 1, 1, 'que-sa-volonte-soit-faite/que-sa-volonte-soit-faite-1.jpg', '2011-03-04'),
(8, 7, 1, 10, 'dr-stone/dr-stone-1.jpg', '2018-04-04'),
(9, 8, 1, 0, 'peacemaker/peacemaker-1.jpg', '2011-09-21'),
(10, 9, 1, 10, 'one-piece/one-piece-1.jpg', '2013-07-03'),
(11, 9, 2, 10, 'one-piece/one-piece-2.jpg', '2013-07-03'),
(12, 9, 3, 10, 'one-piece/one-piece-3.jpg', '2013-07-03'),
(13, 9, 4, 10, 'one-piece/one-piece-4.jpg', '2013-07-03'),
(14, 9, 5, 10, 'one-piece/one-piece-5.jpg', '2013-07-13'),
(15, 9, 6, 10, 'one-piece/one-piece-6.jpg', '2013-07-03'),
(16, 9, 7, 10, 'one-piece/one-piece-7.jpg', '2013-07-03'),
(17, 9, 8, 10, 'one-piece/one-piece-8.jpg', '2013-07-03'),
(18, 10, 1, 20, 'city-hunter/city-hunter-1.jpg', '2005-10-27'),
(19, 10, 2, 20, 'city-hunter/city-hunter-2.jpg', '2005-12-01'),
(20, 10, 3, 20, 'city-hunter/city-hunter-3.jpg', '2006-02-09'),
(21, 11, 1, 10, 'liar-game/liar-game-1.jpg', '2010-06-30'),
(22, 1, 3, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-3.jpg', '2013-04-17'),
(23, 1, 4, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-4.jpg', '2013-04-17'),
(24, 1, 5, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-5.jpg', '2013-06-26'),
(25, 1, 6, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-6.jpg', '2013-06-26'),
(26, 1, 7, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-7.jpg', '2013-08-21'),
(27, 1, 8, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-8.jpg', '2013-09-04'),
(28, 1, 9, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-9.jpg', '2013-10-02'),
(29, 1, 10, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-10.jpg', '2013-11-13'),
(30, 1, 11, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-11.jpg', '2014-01-15'),
(31, 1, 12, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-12.jpg', '2014-03-26'),
(32, 1, 13, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-13.jpg', '2014-04-23'),
(33, 1, 14, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-14.jpg', '2014-05-21'),
(34, 1, 15, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-15.jpg', '2014-06-25'),
(35, 1, 16, 30, 'jojos-bizarre-adventure-stardust-crusaders/jojos-bizarre-adventure-stardust-crusaders-16.jpg', '2014-07-02'),
(36, 7, 2, 10, 'dr-stone/dr-stone-2.jpg', '2018-07-04'),
(37, 7, 3, 10, 'dr-stone/dr-stone-3.jpg', '2018-10-03'),
(38, 7, 4, 10, 'dr-stone/dr-stone-4.jpg', '2019-01-16'),
(39, 7, 5, 10, 'dr-stone/dr-stone-5.jpg', '2019-03-20'),
(40, 7, 6, 10, 'dr-stone/dr-stone-6.jpg', '2019-05-15'),
(41, 7, 7, 10, 'dr-stone/dr-stone-7.jpg', '2019-07-03'),
(42, 7, 8, 10, 'dr-stone/dr-stone-8.jpg', '2019-10-02'),
(43, 7, 9, 10, 'dr-stone/dr-stone-9.jpg', '2020-01-15'),
(44, 7, 10, 10, 'dr-stone/dr-stone-10.jpg', '2020-05-27'),
(45, 7, 11, 10, 'dr-stone/dr-stone-11.jpg', '2020-07-01'),
(46, 7, 12, 10, 'dr-stone/dr-stone-12.jpg', '2020-09-02'),
(47, 7, 13, 10, 'dr-stone/dr-stone-13.jpg', '2020-11-18'),
(48, 12, 1, 40, 'fullmetal-alchemist/fullmetal-alchemist-1.jpg', '2005-09-08'),
(49, 12, 2, 40, 'fullmetal-alchemist/fullmetal-alchemist-2.jpg', '2005-09-08'),
(50, 12, 3, 40, 'fullmetal-alchemist/fullmetal-alchemist-3.jpg', '2005-11-10'),
(51, 12, 4, 40, 'fullmetal-alchemist/fullmetal-alchemist-4.jpg', '2006-01-12'),
(52, 12, 5, 40, 'fullmetal-alchemist/fullmetal-alchemist-5.jpg', '2006-03-09'),
(53, 12, 6, 40, 'fullmetal-alchemist/fullmetal-alchemist-6.jpg', '2006-05-11'),
(54, 12, 7, 40, 'fullmetal-alchemist/fullmetal-alchemist-7.jpg', '2006-07-13'),
(55, 12, 8, 40, 'fullmetal-alchemist/fullmetal-alchemist-8.jpg', '2006-09-14'),
(56, 12, 9, 40, 'fullmetal-alchemist/fullmetal-alchemist-9.jpg', '2006-11-09'),
(57, 12, 10, 40, 'fullmetal-alchemist/fullmetal-alchemist-10.jpg', '2007-01-11'),
(58, 12, 11, 40, 'fullmetal-alchemist/fullmetal-alchemist-11.jpg', '2007-03-08'),
(59, 12, 12, 40, 'fullmetal-alchemist/fullmetal-alchemist-12.jpg', '2007-05-10'),
(60, 12, 13, 40, 'fullmetal-alchemist/fullmetal-alchemist-13.jpg', '2007-07-12'),
(61, 12, 14, 40, 'fullmetal-alchemist/fullmetal-alchemist-14.jpg', '2007-09-13'),
(62, 12, 15, 40, 'fullmetal-alchemist/fullmetal-alchemist-15.jpg', '2007-11-08'),
(63, 12, 16, 40, 'fullmetal-alchemist/fullmetal-alchemist-16.jpg', '2008-03-11'),
(64, 12, 17, 40, 'fullmetal-alchemist/fullmetal-alchemist-17.jpg', '2008-05-15'),
(65, 12, 18, 40, 'fullmetal-alchemist/fullmetal-alchemist-18.jpg', '2008-09-11'),
(66, 12, 19, 40, 'fullmetal-alchemist/fullmetal-alchemist-19.jpg', '2008-12-11'),
(67, 12, 20, 40, 'fullmetal-alchemist/fullmetal-alchemist-20.jpg', '2009-04-09'),
(68, 12, 21, 40, 'fullmetal-alchemist/fullmetal-alchemist-21.jpg', '2009-07-02'),
(69, 12, 22, 40, 'fullmetal-alchemist/fullmetal-alchemist-22.jpg', '2009-11-12'),
(70, 12, 23, 40, 'fullmetal-alchemist/fullmetal-alchemist-23.jpg', '2010-04-08'),
(71, 12, 24, 40, 'fullmetal-alchemist/fullmetal-alchemist-24.jpg', '2010-09-09'),
(72, 12, 25, 40, 'fullmetal-alchemist/fullmetal-alchemist-25.jpg', '2011-01-13'),
(73, 12, 26, 40, 'fullmetal-alchemist/fullmetal-alchemist-26.jpg', '2011-04-14'),
(74, 12, 27, 40, 'fullmetal-alchemist/fullmetal-alchemist-27.jpg', '2011-07-07'),
(75, 9, 9, 10, 'one-piece/one-piece-9.jpg', '2013-07-03'),
(76, 9, 10, 10, 'one-piece/one-piece-10.jpg', '2013-07-03'),
(77, 9, 11, 10, 'one-piece/one-piece-11.jpg', '2013-07-03'),
(78, 9, 12, 10, 'one-piece/one-piece-12.jpg', '2013-07-03'),
(79, 9, 13, 10, 'one-piece/one-piece-13.jpg', '2013-07-03'),
(80, 9, 14, 10, 'one-piece/one-piece-14.jpg', '2013-07-03'),
(81, 9, 15, 10, 'one-piece/one-piece-15.jpg', '2013-07-03'),
(82, 9, 16, 10, 'one-piece/one-piece-16.jpg', '2013-07-03'),
(83, 9, 17, 10, 'one-piece/one-piece-17.jpg', '2013-07-03'),
(84, 9, 18, 10, 'one-piece/one-piece-18.jpg', '2013-07-03'),
(85, 9, 19, 10, 'one-piece/one-piece-19.jpg', '2013-07-03'),
(86, 9, 20, 10, 'one-piece/one-piece-20.jpg', '2013-07-03'),
(87, 9, 21, 10, 'one-piece/one-piece-21.jpg', '2014-01-01'),
(88, 13, 1, 10, 'death-note/death-note-1.jpg', '2007-01-19'),
(89, 13, 2, 10, 'death-note/death-note-2.jpg', '2007-02-02'),
(90, 13, 3, 10, 'death-note/death-note-3.jpg', '2007-04-06'),
(91, 13, 4, 10, 'death-note/death-note-4.jpg', '2007-06-01'),
(92, 13, 5, 10, 'death-note/death-note-5.jpg', '2007-06-01'),
(93, 13, 6, 10, 'death-note/death-note-6.jpg', '2007-10-05'),
(94, 13, 7, 10, 'death-note/death-note-7.jpg', '2007-12-07'),
(95, 13, 8, 10, 'death-note/death-note-8.jpg', '2008-02-15'),
(96, 13, 9, 10, 'death-note/death-note-9.jpg', '2008-04-11'),
(97, 13, 10, 10, 'death-note/death-note-10.jpg', '2008-06-06'),
(98, 13, 11, 10, 'death-note/death-note-11.jpg', '2008-07-04'),
(99, 13, 12, 10, 'death-note/death-note-12.jpg', '2008-10-03'),
(100, 14, 1, 10, 'one-punch-man/one-punch-man-1.jpg', '2016-01-14'),
(101, 15, 1, 10, 'berserk/berserk-1.jpg', '2004-10-06'),
(102, 16, 1, 10, 'lattaque-des-titans/lattaque-des-titans-1.jpg', '2013-06-26'),
(103, 17, 1, 10, 'tokyo-ghoul/tokyo-ghoul-1.jpg', '2013-08-28'),
(104, 18, 1, 10, 'bleach/bleach-1.jpg', '2003-07-11'),
(105, 19, 1, 10, 'my-hero-academia/my-hero-academia-1.jpg', '2016-04-14'),
(106, 20, 1, 10, 'fairy-tail/fairy-tail-1.jpg', '2008-09-10'),
(107, 21, 1, 10, 'bonne-nuit-punpun/bonne-nuit-punpun-1.jpg', '2016-04-14'),
(108, 22, 1, 10, 'a-silent-voice/a-silent-voice-1.jpg', '2015-01-22'),
(111, 30, 1, 1, 'dorohedoro/dorohedoro-1.jpg', '2003-08-08'),
(112, 4, 2, 9, 'eyeshield-21/eyeshield-21-2.jpg', '2005-05-04');

-- --------------------------------------------------------

--
-- Structure de la table `orderlines`
--

CREATE TABLE `orderlines` (
  `order_id` int(11) NOT NULL,
  `manga_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orderlines`
--

INSERT INTO `orderlines` (`order_id`, `manga_id`, `quantity`) VALUES
(5, 19, 1),
(5, 104, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `total_order_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_order_price`, `status`) VALUES
(5, 1, '2020-11-03', '16.89', 'Shipped');

-- --------------------------------------------------------

--
-- Structure de la table `prices`
--

CREATE TABLE `prices` (
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `editor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prices`
--

INSERT INTO `prices` (`code`, `price`, `editor_id`) VALUES
('AS05', '6.79', 3),
('AS10', '6.89', 3),
('GL10', '6.90', 1),
('GL15', '7.60', 1),
('GL20', '9.15', 1),
('GL25', '9.60', 1),
('KA1', '6.85', 2),
('KA2', '7.45', 2),
('KA3', '8.75', 2),
('KA31', '9.90', 2),
('KA4', '10.20', 2),
('KN10', '6.60', 4),
('KN15', '6.90', 4),
('KN20', '7.65', 4),
('KN25', '7.90', 4),
('KN30', '8.65', 4),
('KN40', '9.65', 4),
('KUR02', '6.60', 8),
('KUR03', '6.80', 8),
('PK03', '6.95', 5),
('PK04', '7.50', 5),
('PK05', '8.20', 5),
('PK06', '8.50', 5),
('PK31', '7.20', 5),
('PK41', '7.75', 5),
('PM01', '6.99', 7),
('PM02', '8.99', 7),
('PM03', '9.99', 7),
('SM16', '11.95', 9),
('TK01', '6.99', 6),
('TK02', '7.99', 6),
('TK03', '9.35', 6),
('TK04', '10.95', 6),
('TK21', '7.99', 6);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `serie_id`, `rating`, `content`, `user_id`) VALUES
(2, 18, 4, NULL, 1),
(3, 4, 5, NULL, 1),
(4, 18, 4, NULL, 5),
(5, 22, 4, NULL, 5),
(6, 15, 4, NULL, 5),
(7, 9, 5, NULL, 5),
(8, 1, 5, NULL, 5),
(10, 13, 4, NULL, 5),
(11, 7, 4, NULL, 5),
(12, 3, 5, NULL, 5),
(13, 12, 5, NULL, 5),
(14, 20, 3, NULL, 5),
(15, 10, 4, NULL, 5),
(16, 16, 4, NULL, 5),
(17, 11, 3, NULL, 5),
(18, 19, 4, NULL, 5),
(19, 8, 3, NULL, 5),
(20, 14, 4, NULL, 5),
(21, 22, 4, 'Trop bien', 1),
(22, 2, 4, NULL, 5),
(23, 6, 4, NULL, 5),
(24, 5, 4, NULL, 5),
(25, 17, 3, NULL, 5),
(26, 22, 3, NULL, 8),
(27, 22, 1, 'Nul c\'est imprimé à l\'envers', 10),
(28, 15, 5, NULL, 1),
(29, 12, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` int(11) NOT NULL,
  `price_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `series`
--

INSERT INTO `series` (`id`, `name`, `editor_id`, `price_code`) VALUES
(1, 'Jojo\'s Bizarre Adventure: Stardust Crusaders', 6, 'TK01'),
(2, 'Naruto', 2, 'KA1'),
(3, 'Dragon Ball ', 1, 'GL10'),
(4, 'Eyeshield 21', 1, 'GL10'),
(5, 'Sayonara monsieur désespoir', 5, 'PK03'),
(6, 'Que sa volonté soit faite', 2, 'KA1'),
(7, 'Dr Stone', 1, 'GL10'),
(8, 'Peacemaker', 1, 'GL15'),
(9, 'One Piece', 1, 'GL10'),
(10, 'City Hunter', 7, 'PM03'),
(11, 'Liar Game', 6, 'TK02'),
(12, 'Fullmetal Alchemist', 8, 'TK02'),
(13, 'Death Note', 2, 'KA1'),
(14, 'One Punch Man', 8, 'KUR03'),
(15, 'Berserk', 1, 'GL10'),
(16, 'L\'attaque des Titans', 5, 'PK03'),
(17, 'Tokyo Ghoul', 1, 'GL10'),
(18, 'Bleach', 1, 'GL10'),
(19, 'My Hero Academia', 4, 'KN10'),
(20, 'Fairy Tail', 5, 'PK03'),
(21, 'Bonne nuit Punpun', 2, 'KA2'),
(22, 'A Silent Voice', 4, 'KN10'),
(30, 'Dorohedoro', 9, 'SM16');

-- --------------------------------------------------------

--
-- Structure de la table `series_categories`
--

CREATE TABLE `series_categories` (
  `category_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `series_categories`
--

INSERT INTO `series_categories` (`category_id`, `serie_id`) VALUES
(1, 1),
(1, 2),
(1, 10),
(2, 2),
(2, 3),
(2, 20),
(3, 3),
(3, 20),
(8, 1),
(9, 4),
(10, 4),
(11, 30);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `address`, `password`, `zip_code`, `city`, `country`, `created_at`, `role`) VALUES
(1, 'Toto', NULL, NULL, 'test@exemple.com', NULL, '$2y$10$H54yXA1GuSYbOHJos.C5huaqKTnFDkypTnBWgELoy0NdfL3gTJ6ba', NULL, NULL, NULL, '2020-09-24 22:10:34', 'admin'),
(4, 'Damien', NULL, NULL, 'Test02@gmail.com', NULL, '$2y$10$6pBUjc3xYPLGw9yfQQ/E.usTCyZRvJd9lAeMGHyZcHJIX1tYB.itK', NULL, NULL, NULL, '2020-09-24 23:06:21', NULL),
(5, 'Phantera', NULL, NULL, 'xexemple@hotmail.fr', '30 Rue là bas si jy suis', '$2y$10$j7Dx/UxG/mrhKT3XL7ndE.u7MqeMzGm2hXdcttxv2aMYfXze8Wn5u', '54854', 'Tokyo ', NULL, '2020-09-24 23:54:43', NULL),
(6, 'Test', NULL, NULL, 'test@gmail.com', NULL, '$2y$10$Y0aU9QgYM.ihVUMUF4ByJuqrMp.vQeLsEzOTSPWcTcCibJts3ve3q', NULL, NULL, NULL, '2020-09-25 13:15:33', NULL),
(7, 'fdsfdsfd', NULL, NULL, 'damien.mayeur@gmail.com', NULL, '$2y$10$ofqWjUwWxN2jNUfMsYK60emMnm/BXd0gfgF6wYMDnn06o14.agFL.', NULL, NULL, NULL, '2020-09-25 21:06:23', NULL),
(8, 'Exemple', NULL, NULL, 'exemple.test@example.com', '', '$2y$10$sT2GB2.Wc43MTuIbwsGbcexJnir19Da3fSb2QciwgiBueSBxFjoyS', '', '', NULL, '2020-10-24 15:51:00', NULL),
(9, 'plonk', NULL, NULL, 'theosylvoz@gmail.com', '20 rue tartempion', '$2y$10$noeThv.a9GA.147MjzgfhePHCrgm..40J6hIN7L1iVZlZ.b0D27Qq', '64512', 'Iseféavoir', NULL, '2020-11-02 17:22:49', NULL),
(10, 'Exemple10', NULL, NULL, 'Exemple52@gmail.com', '', '$2y$10$qnMH5x4OlmOzycbusaqGKuytUkgyQtQgsqaBkkhuBhJa5A2cpHS.O', '', '', NULL, '2020-11-07 10:20:15', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `authors_series`
--
ALTER TABLE `authors_series`
  ADD UNIQUE KEY `serie_id_2` (`serie_id`,`author_id`),
  ADD KEY `authors_series_ibfk_1` (`author_id`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_parent` (`category_parent`);

--
-- Index pour la table `editors`
--
ALTER TABLE `editors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mangas`
--
ALTER TABLE `mangas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serie_id` (`serie_id`,`volume`);

--
-- Index pour la table `orderlines`
--
ALTER TABLE `orderlines`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`code`),
  ADD KEY `editor` (`editor_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serie_id` (`serie_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_ibfk_1` (`editor_id`),
  ADD KEY `series_ibfk_2` (`price_code`);

--
-- Index pour la table `series_categories`
--
ALTER TABLE `series_categories`
  ADD UNIQUE KEY `category_id` (`category_id`,`serie_id`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `editors`
--
ALTER TABLE `editors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `mangas`
--
ALTER TABLE `mangas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `authors_series`
--
ALTER TABLE `authors_series`
  ADD CONSTRAINT `authors_series_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `authors_series_ibfk_2` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`category_parent`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `mangas`
--
ALTER TABLE `mangas`
  ADD CONSTRAINT `mangas_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orderlines`
--
ALTER TABLE `orderlines`
  ADD CONSTRAINT `orderlines_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderlines_ibfk_2` FOREIGN KEY (`manga_id`) REFERENCES `mangas` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`editor_id`) REFERENCES `editors` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `series_categories`
--
ALTER TABLE `series_categories`
  ADD CONSTRAINT `series_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `series_categories_ibfk_2` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
