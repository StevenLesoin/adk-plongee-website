-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 21 avr. 2020 à 07:14
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `adk_plongee_website`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `type` text NOT NULL,
  `titre` text NOT NULL,
  `date_evt` text NOT NULL,
  `heure_evt` text NOT NULL,
  `date_lim` text NOT NULL,
  `heure_lim` text NOT NULL,
  `niveau_min` text NOT NULL,
  `lieu` text NOT NULL,
  `remarques` text NOT NULL,
  `pseudo` text NOT NULL,
  `date_publi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`type`, `titre`, `date_evt`, `heure_evt`, `date_lim`, `heure_lim`, `niveau_min`, `lieu`, `remarques`, `pseudo`, `date_publi`) VALUES
('Plongée', '0', '', '', '', '2020-05-12', '1', 'Bord', '', '', ''),
('2', '2', '2', '2', '2', '2', '2', '2', '2', 'e', 'e'),
('a', 'a', '2', 'a', '2', '1', '2', 'a', '2', 'Vide', 'Vide'),
('abff', 'a', '2', 'a', '2', '1', '2', 'a', '2', 'Vide', 'Vide'),
('dsd', 'd', 'd', '1', 'd', 'd', 'd', 'd', 'd', 'Vide', 'Vide'),
('Plongée', 'Sortie Mer', '2020-04-05', '1', '2020-04-04', '21:00', 'N1', 'Mer', 'Depart club 15\' après RDV', 'Vide', 'Vide');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `privilege` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `privilege`) VALUES
(1, 'sle', '$2y$10$V8bLw1HtqNcr8GJiBJwZIeQcT9SRqAm1QXbrJhrPpzPikhz9h/1BW', 'Lesoin', 'Steven', 'steven.lesoin@gmail.com', 'administrateur'),
(2, 'luc', '$2y$10$MZfLQpeF4261c5dxrGqqOeXcwYrdZZJKBhcmMpJ3iDDeoT0SNYCeO', 'Carof', 'Lucie', 'lucie.carof@yahoo.fr', 'membre'),
(3, 'Clem', 'test', 'MAHE', 'Clément', 'clement.mahe@gmail.com', 'Administrateur'),
(4, 'tra_ma_sea_rider', '$2y$10$n8lRKzHMTEc9wvRQ1OOteuZoBD2zYn9lS0GkgPzo0oQYdcNPAaB4.', 'MAHE', 'Clément', 'clement.mahe@gmail.com', 'membre');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
