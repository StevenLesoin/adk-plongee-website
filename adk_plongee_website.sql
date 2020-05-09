-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 08 mai 2020 à 16:21
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adk_plongee_website`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
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
  `date_publi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `type`, `titre`, `date_evt`, `heure_evt`, `date_lim`, `heure_lim`, `niveau_min`, `lieu`, `max_part`, `remarques`, `pseudo`, `date_publi`) VALUES
(14, 'Plongée', 'Test liste attente', '2020-06-25', '12:00:00', '2020-06-24', '21:00:00', '0', 'Mer', 3, 'Test liste attente', 'MAHE Clément', 'Thu-30/04/2020 11:10:28'),
(12, 'Théorie', 'Séance Nitrox Confirmé', '2020-05-15', '20:00:00', '2020-05-15', '18:00:00', '0', 'Club', 12, 'Apporter de quoi noter', 'MAHE Clément', 'Sat-25/04/2020 18:58:15'),
(13, 'Plongée', 'Dellec', '2020-05-11', '15:00:00', '2020-05-11', '15:00:00', '8', 'Mer', 12, 'Pour remettre la tête sous l\'eau après le confinement', 'MAHE Clément', 'Sat-25/04/2020 18:58:55'),
(11, 'Plongée', 'Katingo Baby', '2020-05-20', '08:15:00', '2020-05-19', '21:00:00', '3', 'Mer', 12, 'Ca va envoyer ! ', 'MAHE Clément', '25-04-2020 14:57:24'),
(10, 'Vie du Club', 'AG 2021', '2021-02-02', '19:00:00', '2021-02-02', '19:00:00', '1', 'Locaux_sociaux', 99, 'Pot à l\'issue de l\'AG', 'Vide', 'Vide');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_evt` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `time_inscr` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `commentaire` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_evt`, `id_membre`, `time_inscr`, `commentaire`) VALUES
(14, 5, '2020-04-30 11:32:01', ''),
(12, 4, '2020-04-25 18:59:47', ' '),
(12, 2, '2020-04-25 19:06:00', 'Attention aux oreilles'),
(10, 2, '2020-04-25 19:06:00', 'Yo'),
(13, 1, '2020-04-25 19:05:22', ''),
(13, 4, '2020-04-25 19:08:11', 'C\'est une plongée qui vaut le coup quand même'),
(11, 4, '2020-04-25 19:08:48', ' '),
(13, 2, '2020-04-30 13:56:26', ''),
(14, 2, '2020-04-30 11:15:15', ''),
(14, 4, '2020-04-30 11:31:24', ' ');

-- --------------------------------------------------------

--
-- Structure de la table `invites`
--

CREATE TABLE `invites` (
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

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `privilege` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `oubli_mdp` int(11) NOT NULL DEFAULT 0,
  `niv_plongeur` int(11) NOT NULL DEFAULT 0,
  `niv_encadrant` int(11) NOT NULL DEFAULT 0,
  `actif_saison` int(11) NOT NULL DEFAULT 0,
  `certif_med` date NOT NULL DEFAULT '1000-01-01',
  `inscription_valide` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `privilege`, `oubli_mdp`, `niv_plongeur`, `niv_encadrant`, `actif_saison`, `certif_med`, `inscription_valide`) VALUES
(1, 'sle', '$2y$10$V8bLw1HtqNcr8GJiBJwZIeQcT9SRqAm1QXbrJhrPpzPikhz9h/1BW', 'Lesoin', 'Steven', 'steven.lesoin@gmail.com', 'administrateur', 0, 3, 1, 1, '2020-01-01', 1),
(2, 'luc', '$2y$10$MZfLQpeF4261c5dxrGqqOeXcwYrdZZJKBhcmMpJ3iDDeoT0SNYCeO', 'Carof', 'Lucie', 'lucie.carof@yahoo.fr', 'membre', 0, 1, 0, 0, '2020-04-01', 0),
(4, 'Clément', '$2y$10$JqgVEXm2grkEBHnGP62bi.g5tju76L8eCwPJCafjaT1CNqWSZNoMC', 'MAHE', 'Clément', 'clement.mahe@gmail.com', 'administrateur', 0, 5, 3, 0, '2020-04-15', 1),
(5, 'test', '$2y$10$BOD6sfjFVi18BJdMIc.A9.7E4KKLnVTt0a2eULEiUYKxCsNuCR8Ym', 'tutu', 'toto', 'test@test.com', 'membre', 1, 1, 0, 0, '2020-04-01', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
