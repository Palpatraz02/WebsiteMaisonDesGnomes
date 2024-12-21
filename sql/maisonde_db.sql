-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: May 04, 2024 at 07:40 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maisonde_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` text NOT NULL,
  `short_descr` varchar(200) NOT NULL,
  `tumbnail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`id`, `title`, `descr`, `short_descr`, `tumbnail`) VALUES
(1, 'Appartamento con dehor privato', 'Alloggio al piano terra, di 40 m<sup>2</sup> circa con 4 posti letto (1 letto matrimoniale + 1 divano letto in soggiorno), dotato di un ampio dehors privato, con sedie, tavolo e sdraio. All\'interno è stato installato un sistema di ricircolo dell\'aria, con filtraggio dei pollini (<a href=\"https://www.inventer.eu/\">inVENTer</a>). Inoltre dispone delle <a href=\"https://maisondesgnomes.it/struttura\">dotazioni standard riguardanti tutti gli appartamenti</a>.', 'Alloggio di 40 m<sup>2</sup> con 4 posti letto, un bagno e un dehors privato.', 'Copertina1.jpg'),
(2, 'Appartamento grande a due piani', 'lloggio di 60 m<sup>2</sup> circa con 4 posti letto (1 letto matrimoniale + 2 letti singoli sul soppalco) ed un ampio balcone con vista panoramica sulle montagne. Inoltre dispone delle <a href=\"https://maisondesgnomes.it/struttura\">dotazioni standard riguardanti tutti gli appartamenti</a>.', 'Alloggio di 60 m<sup>2</sup> con 4 posti letto di cui 2 sul soppalco, un bagno ed un balcone con vista panoramica.', 'Copertina2.jpg'),
(3, 'Appartamento grande a tre piani', 'Alloggio di 70 m<sup>2</sup> circa con 4 posti letto (1 letto matrimoniale + 2 letti singoli sul soppalco), e due balconi. Inoltre dispone delle <a href=\"https://maisondesgnomes.it/struttura\">dotazioni standard riguardanti tutti gli appartamenti</a>.', 'Alloggio di 70 m<sup>2</sup> con 4 posti letto di cui 2 sul soppalco, un bagno e due balconi.\r\n', 'Copertina3.jpg'),
(4, 'Appartamento affaciato sul giardino', 'Alloggio di 40 m<sup>2</sup> circa con 4 posti letto (1 letto matrimoniale + 1 divano letto in soggiorno, dotato di un ampio balcone con vista sull\'area verde in comune ed accesso diretto alla medesima. Inoltre dispone delle <a href=\"https://maisondesgnomes.it/struttura\">dotazioni standard riguardanti tutti gli appartamenti</a>.', 'Alloggio di 40 m<sup>2</sup> con 4 posti letto, un bagno e un balcone.', 'Copertina4.jpg'),
(5, 'Appartamento vista giardino', 'Alloggio di 40 m<sup>2</sup> circa con 4 posti letto (1 letto matrimoniale + 1 divano letto in soggiorno, dotato di un ampio balcone con vista sull\'area verde in comune. Inoltre dispone delle <a href=\"https://maisondesgnomes.it/struttura\">dotazioni standard riguardanti tutti gli appartamenti</a>.', 'Alloggio di 40 m<sup>2</sup> con 4 posti letto, un bagno e un balcone.', 'Copertina5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apartment` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`email`, `apartment`, `start_date`, `end_date`) VALUES
('fabyd02@outlook.com', 1, '2024-05-05', '2024-05-07'),
('fabyd02@outlook.com', 1, '2024-05-25', '2024-05-27'),
('fabyd02@outlook.com', 3, '2024-05-22', '2024-05-31'),
('fabyd02@outlook.com', 4, '2024-05-05', '2024-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id_img` int NOT NULL,
  `src` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `titolo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descr` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_id` int DEFAULT NULL,
  `objective` enum('apartment','structure','slideshow') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id_img`, `src`, `titolo`, `descr`, `app_id`, `objective`) VALUES
(6, 'img6.jpg', 'Giardino roccioso', '', NULL, 'structure'),
(7, 'img7.jpg', 'Giardino in comune', '', NULL, 'structure'),
(8, 'img8.jpg', 'Giardino in comune', '', NULL, 'structure'),
(9, 'img9.jpg', 'Barbecue', '', NULL, 'structure'),
(10, 'img10.jpg', 'Giardino in comune', '', NULL, 'structure'),
(12, 'img12.jpg', 'Giardino in comune', '', NULL, 'structure'),
(13, 'img13.jpg', 'Giardino in comune', '', NULL, 'structure'),
(14, 'img14.jpg', 'Giardino in comune', '', NULL, 'structure'),
(16, 'img16.jpg', 'Piante aromatiche', '', NULL, 'structure'),
(17, 'img17.jpg', 'Dehors', '', 1, 'apartment'),
(18, 'img18.jpg', 'Dehors', '', 1, 'apartment'),
(19, 'img19.jpg', 'Soggiorno', '', 1, 'apartment'),
(20, 'img20.jpg', 'Soggiorno', '', 1, 'apartment'),
(21, 'img21.jpg', 'Cucina', '', 1, 'apartment'),
(22, 'img22.jpg', 'Cucina', '', 1, 'apartment'),
(23, 'img23.jpg', 'Zona giorno', '', 1, 'apartment'),
(24, 'img24.jpg', 'Camera matrimoniale', '', 1, 'apartment'),
(25, 'img25.jpg', 'Camera matrimoniale', '', 1, 'apartment'),
(26, 'img26.jpg', 'Bagno', '', 1, 'apartment'),
(27, 'img27.jpg', 'Bagno', '', 1, 'apartment'),
(28, 'img28.jpg', 'Giardino in comune', 'La struttura è dotata di un ampio giardino in comune, dotato di sdraio, tavoli, sedie e barbecue', NULL, 'slideshow'),
(29, 'img29.jpg', 'Appartamenti', 'Ogni appartamento è dotato di cucina-soggiorno, bagno, e camera da letto', NULL, 'slideshow'),
(30, 'img30.jpg', 'Vista dalla casa', 'Da qui è possibile ammirare e raggiungere le montagne circostanti', NULL, 'slideshow'),
(31, 'img31.jpg', 'Vista dal balcone', '', 2, 'apartment'),
(39, 'img39.jpg', 'Bagno', '', 2, 'apartment'),
(40, 'img40.jpg', 'Bagno', '', 2, 'apartment'),
(41, 'img41.jpg', 'Zona giorno', '', 3, 'apartment'),
(42, 'img42.jpg', 'Zona giorno', '', 3, 'apartment'),
(43, 'img43.jpg', 'Vista dal balcone', '', 3, 'apartment'),
(44, 'img44.jpg', 'Terrazzino', '', 3, 'apartment'),
(45, 'img45.jpg', 'Soppalco', '', 3, 'apartment'),
(46, 'img46.jpg', 'Soppalco', '', 3, 'apartment'),
(47, 'img47.jpg', 'Cucina', '', 3, 'apartment'),
(48, 'img48.jpg', 'Camera matrimoniale', '', 3, 'apartment'),
(49, 'img49.jpg', 'Camera matrimoniale', '', 3, 'apartment'),
(50, 'img50.jpg', 'Bagno', '', 3, 'apartment'),
(56, 'img56.jpg', 'Camera matrimoniale', '', 4, 'apartment'),
(57, 'img57.jpg', 'Camera matrimoniale', '', 4, 'apartment'),
(58, 'img58.jpg', 'Camera matrimoniale (armadio)', '', 4, 'apartment'),
(59, 'img59.jpg', 'Cucina', '', 4, 'apartment'),
(60, 'img60.jpg', 'Soggiorno', '', 4, 'apartment'),
(61, 'img61.jpg', 'Soggiorno', '', 4, 'apartment'),
(62, 'img62.jpg', 'Finestra finta (soggiorno)', '', 4, 'apartment'),
(63, 'img63.jpg', 'Cucina', '', 4, 'apartment'),
(64, 'img64.jpg', 'Divano letto', '', 4, 'apartment'),
(65, 'img65.jpg', 'Bagno', '', 4, 'apartment'),
(66, 'img66.jpg', 'Camera matrimoniale', '', 4, 'apartment'),
(67, 'img67.jpg', 'Bagno', '', 4, 'apartment'),
(69, 'img69.jpg', 'Balcone', '', 4, 'apartment'),
(70, 'img70.jpg', 'Gnomo con neve', '', NULL, 'structure'),
(71, 'img71.jpg', 'Giardino inverno', '', NULL, 'structure'),
(72, 'img72.jpg', 'Giardino inverno', '', NULL, 'structure'),
(74, 'img74.jpg', 'Vista in inverno', '', 3, 'apartment'),
(75, 'img75.jpg', 'Vista dalla finestra', '', 3, 'apartment'),
(76, 'img76.jpg', 'Balcone in inverno', '', 3, 'apartment'),
(78, 'img78.jpg', 'Soggiorno e cucina', '', 2, 'apartment'),
(79, 'img79.jpg', 'Soppalco con letti singoli', '', 2, 'apartment'),
(80, 'img80.jpg', 'Soppalco con letti singoli', '', 2, 'apartment'),
(81, 'img81.jpg', 'Soppalco con letti singoli', '', 2, 'apartment'),
(82, 'img82.jpg', 'Soppalco con letti singoli', '', 2, 'apartment'),
(83, 'img83.jpg', 'Soppalco con letti singoli', '', 2, 'apartment'),
(84, 'img84.jpg', 'Soggiorno', '', 2, 'apartment'),
(85, 'img85.jpg', 'Soggiorno', '', 2, 'apartment'),
(86, 'img86.jpg', 'Cucina', '', 2, 'apartment'),
(87, 'img87.jpg', 'Soggiorno e cucina', '', 2, 'apartment'),
(88, 'img88.jpg', 'Soppalco', '', 2, 'apartment'),
(89, 'img89.jpg', 'Camera matrimoniale', '', 2, 'apartment'),
(90, 'img90.jpg', 'Camera matrimoniale', '', 2, 'apartment'),
(91, 'img91.jpg', 'Camera matrimoniale', '', 2, 'apartment'),
(92, 'img92.jpg', 'Armadi camera matrimoniale', '', 2, 'apartment'),
(93, 'img93.jpg', 'Camera matrimoniale', '', 2, 'apartment'),
(94, 'img94.jpg', 'Camera matrimoniale', '', 2, 'apartment'),
(95, 'img95.jpg', 'Corridoio', '', 2, 'apartment'),
(102, 'img102.jpg', 'Corridoio', '', 5, 'apartment'),
(104, 'img104.jpg', 'Bagno', '', 5, 'apartment'),
(110, 'img110.jpg', 'Balcone', '', 5, 'apartment'),
(111, 'img111.jpg', 'Bagno', '', 5, 'apartment'),
(112, 'img112.jpg', 'Balcone', '', 2, 'apartment'),
(113, 'img113.jpg', 'Balcone', '', 2, 'apartment'),
(114, 'img114.jpg', 'Balcone', '', 2, 'apartment'),
(115, 'img115.jpg', 'Soggiorno e cucina', '', 5, 'apartment'),
(116, 'img116.jpg', 'Soggiorno', '', 5, 'apartment'),
(117, 'img117.jpg', 'Soggiorno', '', 5, 'apartment'),
(118, 'img118.jpg', 'Soggiorno e cucina', '', 5, 'apartment'),
(119, 'img119.jpg', 'Soggiorno e cucina', '', 5, 'apartment'),
(120, 'img120.jpg', 'Soggiorno', '', 5, 'apartment'),
(121, 'img121.jpg', 'Soggiorno e cucina', '', 5, 'apartment'),
(122, 'img122.jpg', 'Camera matrimoniale', '', 5, 'apartment'),
(123, 'img123.jpg', 'Camera matrimoniale', '', 5, 'apartment'),
(124, 'img124.jpg', 'Guardaroba', '', 5, 'apartment'),
(125, 'img125.jpg', 'Camera matrimoniale', '', 5, 'apartment'),
(126, 'img126.jpg', 'Finestra sul giardino', '', 5, 'apartment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `password` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `surname`, `password`, `admin`) VALUES
('a@a.a', 'AA', 'AA', '$2y$10$hhkGM61bM4pNx2ohW0wca.m4HGOLYrSp8uD06e8DtmmocjEmH1lG.', 1),
('fabyd02@outlook.com', 'Fabien', 'Dufour', '$2y$10$LSk19oMRIlBrheh9QAhEY.AnD6BGQ4KfgZuVAce8bW5apSOJ3DIeC', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`email`,`apartment`,`start_date`,`end_date`),
  ADD KEY `email` (`email`),
  ADD KEY `apartment` (`apartment`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `apartaments_link` (`app_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id_img` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings-apartments` FOREIGN KEY (`apartment`) REFERENCES `apartments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bookings-users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `apartaments_link` FOREIGN KEY (`app_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
