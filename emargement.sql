-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 05:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emargement`
--

-- --------------------------------------------------------

--
-- Table structure for table `emargement`
--

CREATE TABLE `emargement` (
  `id` int(11) NOT NULL,
  `professeur_id` int(11) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `classe` varchar(50) DEFAULT NULL,
  `ue` varchar(100) DEFAULT NULL,
  `filiere` varchar(100) DEFAULT NULL,
  `date` date DEFAULT curdate(),
  `heure_arrivee` time DEFAULT NULL,
  `heure_depart` time DEFAULT NULL,
  `duree` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emargement`
--

INSERT INTO `emargement` (`id`, `professeur_id`, `nom`, `classe`, `ue`, `filiere`, `date`, `heure_arrivee`, `heure_depart`, `duree`) VALUES
(35, 15, 'OGOU', 'L1', 'MATHÉMATIQUES', 'Télécommunications', '2025-05-15', '02:34:17', '02:34:20', '00:00:03'),
(36, 19, 'OBANDJE', 'L3', 'MATHÉMATIQUES', 'Mathématiques', '2025-05-15', '02:39:49', '02:39:57', '00:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `professeur_id` int(11) DEFAULT NULL,
  `ue` varchar(100) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `date_envoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `professeur_id`, `ue`, `contenu`, `date_envoi`) VALUES
(1, 1, 'ALGORITHME', 'Le professeur ID 1 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-14 23:05:45'),
(2, 1, 'ALGORITHME', 'Le professeur ID 1 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-14 23:06:02'),
(3, 1, 'ALGORITHME', 'Le professeur ID 1 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-14 23:06:08'),
(4, 17, 'GENIE LOGICIEL', 'Le professeur ID 17 a atteint ou approche son quota pour l’UE : GENIE LOGICIEL.', '2025-05-15 01:52:26'),
(5, 18, 'GENIE LOGICIEL', 'Le professeur ID 18 a atteint ou approche son quota pour l’UE : GENIE LOGICIEL.', '2025-05-15 02:01:44'),
(6, 1, 'ALGORITHME', 'Test notification pour professeur 1 sur ALGORITHME', '2025-05-15 02:13:46'),
(7, 2, 'ALGORITHME', 'Le professeur ID 2 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:18:49'),
(8, 4, 'ALGORITHME', 'Le professeur ID 4 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:19:22'),
(9, 2, 'ALGORITHME', 'Le professeur ID 2 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:20:03'),
(10, 2, 'ALGORITHME', 'Le professeur ID 2 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:20:14'),
(11, 2, 'ALGORITHME', 'Le professeur ID 2 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:20:21'),
(12, 2, 'ALGORITHME', 'Le professeur ID 2 a atteint ou approche son quota pour l’UE : ALGORITHME.', '2025-05-15 02:20:41'),
(13, 4, 'RESEAUX MIKROTIK', 'Le professeur ID 4 a atteint ou approche son quota pour l’UE : RESEAUX MIKROTIK.', '2025-05-15 02:21:07'),
(14, 19, 'MATHEMATIQUES', 'Le professeur ID 19 a atteint ou approche son quota pour l’UE : MATHEMATIQUES.', '2025-05-15 02:21:37'),
(15, 19, 'MATHEMATIQUES', 'Le professeur ID 19 a atteint ou approche son quota pour l’UE : MATHEMATIQUES.', '2025-05-15 02:21:47'),
(16, 19, 'MATHEMATIQUES', 'Le professeur ID 19 a atteint ou approche son quota pour l’UE : MATHEMATIQUES.', '2025-05-15 02:21:56'),
(17, 19, 'MATHEMATIQUES', 'Le professeur ID 19 a atteint ou approche son quota pour l’UE : MATHEMATIQUES.', '2025-05-15 02:21:59'),
(18, 17, 'SYSTEMES D\'EXPLOITATION', 'Le professeur BANDAWA (ID 17) a atteint ou approche son quota pour l’UE : SYSTEMES D\'EXPLOITATION.', '2025-05-15 02:30:44'),
(19, 19, 'MATHEMATIQUES', 'Le professeur OBANDJE (ID 19) a atteint ou approche son quota pour l’UE : MATHEMATIQUES.', '2025-05-15 02:41:18');

-- --------------------------------------------------------

--
-- Table structure for table `professeur`
--

CREATE TABLE `professeur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `heures_totales` int(11) NOT NULL DEFAULT 30,
  `heures_effectuees` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professeur`
--

INSERT INTO `professeur` (`id`, `nom`, `email`, `mot_de_passe`, `heures_totales`, `heures_effectuees`) VALUES
(1, 'jo', 'jo@gmail.com', '1234', 30, 0),
(2, 'joo', 'joo@gmail.com', '12345', 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `professeurs`
--

CREATE TABLE `professeurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professeurs`
--

INSERT INTO `professeurs` (`id`, `nom`, `email`, `mot_de_passe`) VALUES
(2, 'jo', 'jo@gmail.com', '$2y$10$r7k/5xkKEMOTRCBNSQdZYOHCqSTVUZ.8763cGJRvrNC6YmJ/GVHGe'),
(4, 'Nom de l\'utilisateur', 'email@example.com', '$2y$10$EJ8t9EFkgxH5i6Jxg0P.c.Bk5qGqdOBiseBaTQsyLrFngIO9oaB4.'),
(13, 'joseph', 'joseph@gmail.com', '$2y$10$7fu3wpmkMGqXtxY6jCJjfeW3.Iad20IqJ/CwYv0NhzO4DdSZH5SIe'),
(14, 'SALAMI', 'salami@gmail.com', '$2y$10$E5dc4I1LITXBTO4Z4B/kfOLjTuSuqNDjrKCnGmE/l/LCi3cKZlrGa'),
(15, 'OGOU', 'ogou@gmail.com', '$2y$10$TwYHMLtr7PDhQrhZ8PLp8uhHQh9cU8y6k.ZAIsLV5nRVkbB68snL.'),
(16, 'OUYAYI', 'ouyayi@gmail.com', '$2y$10$Kfvk4AGWBPff0Sx6UYRrGOMBArRjNPhl/OMI.z4E7iJT63gcxakW.'),
(17, 'BANDAWA', 'bandawa@gmail.com', '$2y$10$nPk/18r0iPWPfncQDR6WJOnmxIXgcHLJU8CEfrx3qtnhn7NQe9DD.'),
(18, 'OGAH', 'ogah@gmail.com', '$2y$10$PY2pITgXyFt2QkSBNQpTdul9yJV0.HTmuv0cErHeeXndGWewujzpu'),
(19, 'OBANDJE', 'obandje@gmail.com', '$2y$10$tzBR67QcC5hb5uEewCJLVON0G2Tqp3IDe6zkWmtgarsnEFA1drOv6'),
(20, 'SEWAVI', 'sewavi@gmail.com', '$2y$10$h4ki5s/PufJW2InXf8pc3./lMiHpTzH0B8ZqUFhGxxAeOaRaE6EZi'),
(21, 'INNOCENTS', 'innocents@gmail.com', '$2y$10$jXIKjTcPNJOQih.RXKLTr.lVKCO/4jRGxR0t8GMKUjS4IUz26Geru'),
(22, 'AYIVI', 'ayivi@gmail.com', '$2y$10$6R.8Cc4jFGAnoLsfIo8lk.DIgqM456cVQnoOaRmJfjQJl3.Fc1M/O'),
(23, 'ABOTSI', 'abotsi@gmail.com', '$2y$10$Cau5zlXfWsalzrNPTDcLK.xcHT9hpYrpfTnmuN6NzHm5.nll3cHKm');

-- --------------------------------------------------------

--
-- Table structure for table `quotas`
--

CREATE TABLE `quotas` (
  `id` int(11) NOT NULL,
  `professeur_id` int(11) NOT NULL,
  `ue` varchar(100) NOT NULL,
  `quota_heures` time NOT NULL,
  `date_attribution` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotas`
--

INSERT INTO `quotas` (`id`, `professeur_id`, `ue`, `quota_heures`, `date_attribution`) VALUES
(31, 2, 'ALGORITHME', '20:00:00', '2025-05-15 02:01:09'),
(32, 4, 'RESEAUX MIKROTIK', '20:00:00', '2025-05-15 02:01:09'),
(33, 13, 'INFOGRAPHIE', '20:00:00', '2025-05-15 02:01:09'),
(34, 14, 'INITIATION SI', '20:00:00', '2025-05-15 02:01:09'),
(35, 15, 'STRUCTURE DE DONNEE', '20:00:00', '2025-05-15 02:01:09'),
(36, 16, 'BASES DE DONNEES', '20:00:00', '2025-05-15 02:01:09'),
(37, 17, 'SYSTEMES D\'EXPLOITATION', '20:00:00', '2025-05-15 02:01:09'),
(38, 18, 'GENIE LOGICIEL', '20:00:00', '2025-05-15 02:01:09'),
(39, 19, 'MATHEMATIQUES', '20:00:00', '2025-05-15 02:01:09'),
(40, 20, 'PHYSIQUE', '20:00:00', '2025-05-15 02:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `ue_prof`
--

CREATE TABLE `ue_prof` (
  `id` int(11) NOT NULL,
  `ue` varchar(100) NOT NULL,
  `professeur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ue_prof`
--

INSERT INTO `ue_prof` (`id`, `ue`, `professeur_id`) VALUES
(3, 'INFOGRAPHIE', 2),
(4, 'INITIATION SI', 2),
(5, 'STRUCTURE DE DONNEE', 2),
(26, 'ALGORITHME', 14),
(27, 'RESEAUX MIKROTIK', 14),
(28, 'INFOGRAPHIE', 15),
(29, 'INITIATION SI', 15),
(30, 'STRUCTURE DE DONNEE', 15),
(31, 'BASE DE DONNEES', 16),
(32, 'PROGRAMMATION JAVA', 16),
(33, 'SYSTEME D\'EXPLOITATION', 17),
(34, 'RESEAUX AVANCES', 17),
(35, 'SECURITE INFORMATIQUE', 18),
(36, 'GENIE LOGICIEL', 18),
(37, 'INTELLIGENCE ARTIFICIELLE', 19),
(38, 'APPRENTISSAGE AUTOMATIQUE', 19),
(39, 'INFORMATIQUE EMBARQUEE', 20),
(40, 'CONCEPTION WEB', 20),
(41, 'ADMINISTRATION SYSTEMES', 21),
(42, 'BIG DATA', 21),
(43, 'CLOUD COMPUTING', 22),
(44, 'DEVOPS', 22),
(45, 'TESTS LOGICIELS', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emargement`
--
ALTER TABLE `emargement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emargement_ibfk_1` (`professeur_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `professeurs`
--
ALTER TABLE `professeurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `quotas`
--
ALTER TABLE `quotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_professeurs` (`professeur_id`);

--
-- Indexes for table `ue_prof`
--
ALTER TABLE `ue_prof`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ue_prof_ibfk_1` (`professeur_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emargement`
--
ALTER TABLE `emargement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `quotas`
--
ALTER TABLE `quotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ue_prof`
--
ALTER TABLE `ue_prof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emargement`
--
ALTER TABLE `emargement`
  ADD CONSTRAINT `emargement_ibfk_1` FOREIGN KEY (`professeur_id`) REFERENCES `professeurs` (`id`);

--
-- Constraints for table `quotas`
--
ALTER TABLE `quotas`
  ADD CONSTRAINT `fk_professeurs` FOREIGN KEY (`professeur_id`) REFERENCES `professeurs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ue_prof`
--
ALTER TABLE `ue_prof`
  ADD CONSTRAINT `ue_prof_ibfk_1` FOREIGN KEY (`professeur_id`) REFERENCES `professeurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
