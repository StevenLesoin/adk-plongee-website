-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 22 avr. 2020 à 21:43
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
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `titre` text NOT NULL,
  `date_evt` date NOT NULL,
  `heure_evt` time NOT NULL,
  `date_lim` date NOT NULL,
  `heure_lim` time NOT NULL,
  `niveau_min` text NOT NULL,
  `lieu` text NOT NULL,
  `remarques` text NOT NULL,
  `pseudo` text NOT NULL,
  `date_publi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `type`, `titre`, `date_evt`, `heure_evt`, `date_lim`, `heure_lim`, `niveau_min`, `lieu`, `remarques`, `pseudo`, `date_publi`) VALUES
(1, 'Plongée', 'Sortie de nuit !', '2020-04-25', '00:00:01', '2020-04-24', '19:00:00', 'N1', 'Mer', 'Lampe obligatoire', 'Vide', 'Vide'),
(2, 'Plongée', 'Plongée 2', '2020-04-26', '00:00:01', '2020-04-25', '17:00:00', 'N2', 'Mer', 'Du bord :-(', 'Vide', 'Vide'),
(3, 'Plongée', 'Test 20:00', '2020-05-12', '00:00:01', '2020-05-12', '19:00:00', 'N1', 'Mer', '', 'Vide', 'Vide'),
(4, 'Plongée', 'Plongée de l\'année sur le Kleber', '2020-07-01', '08:15:00', '2020-06-30', '21:00:00', 'N3', 'Mer', 'Pour ceux préparés aux profondes avant', 'Vide', 'Vide'),
(5, 'Plongée', 'er', '2020-02-02', '20:00:00', '2020-02-02', '20:20:00', 'N1', 'Mer', '', 'Vide', 'Vide');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_evt` int(11) NOT NULL,
  `id_adhérent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_evt`, `id_adhérent`) VALUES
(1, 1),
(1, 2),
(2, 1),
(1, 3),
(3, 1);

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
