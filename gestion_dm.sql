-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 juil. 2023 à 20:40
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_dm`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL DEFAULT 'user',
  `email` varchar(100) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `cin` varchar(20) DEFAULT NULL,
  `telephone` bigint(20) DEFAULT NULL,
  `profile_image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usertype`, `email`, `nom`, `prenom`, `matricule`, `cin`, `telephone`, `profile_image`) VALUES
(4, 'helloo', '1234', 'user', 'Karim.hail@oncf.ma', 'karims', 'qsdqsd', 'mad24456', 'Bk4452', 689308537, 0x70726f66696c655f696d616765732f37633836343934322d333539302d343432632d626530352d3666393262306263633364332e6a7067),
(5, 'Mehdi', '1234', 'admin', 'Mehdi.hail@oncf.ma', 'EL MEHDI', 'HAIL', 'metc1442', 'BF968', 689308536, 0x70726f66696c655f696d616765732f36666434363134342d393731382d343661332d613063312d3064303565326162373831642e4a504547),
(6, 'khalid', '1234', 'super_admin', 'here@oncf.ma', 'khalid', 'hail', 'sdk55', '55dqs', 85158, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
