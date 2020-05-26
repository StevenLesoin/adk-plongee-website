-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 13 mai 2020 à 18:06
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
  `max_part` int(11) NOT NULL,
  `remarques` text NOT NULL,
  `pseudo` text NOT NULL,
  `date_publi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `type`, `titre`, `date_evt`, `heure_evt`, `date_lim`, `heure_lim`, `niveau_min`, `lieu`, `max_part`, `remarques`, `pseudo`, `date_publi`) VALUES
(14, 'Plongée', 'Test liste attente', '2020-06-25', '12:00:00', '2020-06-24', '21:00:00', '0', 'Mer', 3, 'Test liste attente', 'MAHE Clément', 'Thu-30/04/2020 11:10:28'),
(12, 'Théorie', 'Séance Nitrox Confirmé', '2020-05-17', '21:00:00', '2020-05-14', '19:00:00', '0', 'Club', 12, 'Apporter de quoi noter', 'MAHE Clément', 'Sat-25/04/2020 18:58:15'),
(13, 'Plongée', 'Dellec', '2020-05-11', '15:00:00', '2020-05-11', '15:00:00', '8', 'Mer', 12, 'Pour remettre la tête sous l\'eau après le confinement', 'MAHE Clément', 'Sat-25/04/2020 18:58:55'),
(11, 'Plongée', 'Katingo Baby', '2020-05-20', '08:15:00', '2020-05-19', '21:00:00', '3', 'Mer', 12, 'Ca va envoyer ! ', 'MAHE Clément', '25-04-2020 14:57:24'),
(10, 'Vie du Club', 'AG 2021', '2021-02-02', '19:00:00', '2021-02-02', '19:00:00', '1', 'Locaux_sociaux', 99, 'Pot à l\'issue de l\'AG', 'Vide', 'Vide'),
(15, 'Plongée', 'Portsall Epave ou tombant', '2020-05-14', '17:45:00', '2020-05-11', '21:00:00', '2', 'Mer', 4, 'Amoco ou tombant à tester ou autre épave. Rdv à la cale de Trémazan à 17:45 pour départ bateau à 18h. L\'étale sur site sera autour de 19h15', 'MAHE Clément', '2020-05-03 21:27:07'),
(17, 'Plongée', 'Portsall Matinale', '2020-05-16', '08:00:00', '2020-05-11', '21:00:00', '2', 'Mer', 4, 'Rendez vous sur la cale de Tremazan à 8H00 pour départ à 8h15. Etale de marée sur site vers 9H00', 'MAHE Clément', '2020-05-03 21:32:57'),
(18, 'Plongée', 'Portsall Epave ou tombant', '2020-05-16', '13:30:00', '2020-05-11', '21:00:00', '2', 'Mer', 4, 'Amoco ou tombant à tester ou autre épave. Rdv à la cale de Trémazan à 13:30 pour départ bateau à 13h45. L\'étale sur site sera autour de 15h00', 'MAHE Clément', '2020-05-03 22:39:24'),
(19, 'Plongée', 'Portsall Epave ou tombant', '2020-05-17', '08:45:00', '2020-05-11', '21:00:00', '2', 'Mer', 4, 'Plongée sur Amoco ou Tombant à tester ou autre épave. Etale sur site à 10H -&gt; 09H00 sur site soit RDV à la cale de Trémazan à 08H45', 'MAHE Clément', '2020-05-03 22:43:35'),
(20, 'Plongée', 'Plongée lointaine Test date lim', '2020-07-30', '08:00:00', '2020-05-03', '21:00:00', '0', 'Mer', 12, ' ', 'MAHE Clément', '2020-05-04 22:36:04');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_evt` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `time_inscr` timestamp NOT NULL DEFAULT current_timestamp(),
  `commentaire` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_evt`, `id_membre`, `time_inscr`, `commentaire`) VALUES
(14, 5, '2020-04-30 11:32:01', ''),
(12, 2, '2020-04-25 19:06:00', 'Attention aux oreilles'),
(10, 2, '2020-04-25 19:06:00', 'Yo'),
(13, 1, '2020-04-25 19:05:22', ''),
(13, 4, '2020-04-25 19:08:11', 'C\'est une plongée qui vaut le coup quand même'),
(11, 4, '2020-04-25 19:08:48', ' '),
(13, 2, '2020-04-30 13:56:26', ''),
(14, 2, '2020-04-30 11:15:15', ''),
(14, 4, '2020-05-13 17:59:22', 'Houhou'),
(12, 4, '2020-05-12 19:40:04', ' '),
(14, 1, '2020-05-10 10:19:56', '');

-- --------------------------------------------------------

--
-- Structure de la table `invites`
--

DROP TABLE IF EXISTS `invites`;
CREATE TABLE IF NOT EXISTS `invites` (
  `id_evt` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `niveau` text NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `invites`
--

INSERT INTO `invites` (`id_evt`, `nom`, `prenom`, `niveau`, `commentaire`) VALUES
(13, 'Capitaine', 'Michel', 'E2', 'Invité par MAHE Clément à 25-04-2020 19:07:22 : Il n\'a pas pris sa licence cette année'),
(14, 'Prieur', 'Didier', 'E3', 'Invité par MAHE Clément à 30-04-2020 11:14:30 : Copain'),
(11, 'Marteau', 'Jean Paul', 'E4', 'Invité par MAHE Clément à 25-04-2020 19:00:15 : Pour faire DP Trimix');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `privilege` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `oubli_mdp` int(11) NOT NULL,
  `niv_plongeur` int(11) NOT NULL DEFAULT 0,
  `niv_encadrant` int(11) NOT NULL DEFAULT 0,
  `actif_saison` int(11) NOT NULL DEFAULT 0,
  `certif_med` date NOT NULL,
  `inscription_valide` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `privilege`, `oubli_mdp`, `niv_plongeur`, `niv_encadrant`, `actif_saison`, `certif_med`, `inscription_valide`) VALUES
(1, 'sle', '$2y$10$V8bLw1HtqNcr8GJiBJwZIeQcT9SRqAm1QXbrJhrPpzPikhz9h/1BW', 'Lesoin', 'Steven', 'steven.lesoin@gmail.com', 'administrateur', 0, 3, 1, 0, '2020-01-01', 1),
(2, 'luc', '$2y$10$MZfLQpeF4261c5dxrGqqOeXcwYrdZZJKBhcmMpJ3iDDeoT0SNYCeO', 'Carof', 'Lucie', 'lucie.carof@yahoo.fr', 'membre', 0, 1, 0, 0, '2019-04-01', 0),
(4, 'Clément', '$2y$10$JqgVEXm2grkEBHnGP62bi.g5tju76L8eCwPJCafjaT1CNqWSZNoMC', 'MAHE', 'Clément', 'clement.mahe@gmail.com', 'administrateur', 0, 5, 3, 1, '2020-04-15', 1),
(5, 'test', '$2y$10$BOD6sfjFVi18BJdMIc.A9.7E4KKLnVTt0a2eULEiUYKxCsNuCR8Ym', 'tutu', 'toto', 'test@test.com', 'membre', 1, 1, 0, 0, '2020-04-01', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
