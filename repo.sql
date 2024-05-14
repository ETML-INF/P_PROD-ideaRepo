-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 04 déc. 2023 à 14:15
-- Version du serveur :  5.7.11
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `repo`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_account`
--

CREATE TABLE `t_account` (
  `acc_id` int(11) NOT NULL,
  `acc_firstname` varchar(50) NOT NULL,
  `acc_name` varchar(50) NOT NULL,
  `acc_mail` varchar(255) NOT NULL,
  `acc_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_account`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_category`
--

CREATE TABLE `t_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_category`
--

INSERT INTO `t_category` (`cat_id`, `cat_name`) VALUES
(1, 'développement'),
(2, 'web');

-- --------------------------------------------------------

--
-- Structure de la table `t_idea`
--

CREATE TABLE `t_idea` (
  `ide_id` int(11) NOT NULL,
  `ide_title` varchar(255) NOT NULL,
  `ide_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ide_description` text NOT NULL,
  `ide_target` varchar(255) NOT NULL,
  `ide_image` varchar(255) NOT NULL,
  `ide_category_fk` int(11) NOT NULL,
  `ide_account_fk` int(11) NOT NULL,
  `ide_state_fk` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_idea`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_state`
--

CREATE TABLE `t_state` (
  `sta_id` int(11) NOT NULL,
  `sta_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_state`
--

INSERT INTO `t_state` (`sta_id`, `sta_name`) VALUES
(1, 'en attente'),
(2, 'validée');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_account`
--
ALTER TABLE `t_account`
  ADD PRIMARY KEY (`acc_id`);

--
-- Index pour la table `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `t_idea`
--
ALTER TABLE `t_idea`
  ADD PRIMARY KEY (`ide_id`),
  ADD KEY `CATEGORY_FK` (`ide_category_fk`),
  ADD KEY `ACCOUNT_FK` (`ide_account_fk`),
  ADD KEY `STATE_FK` (`ide_state_fk`);

--
-- Index pour la table `t_state`
--
ALTER TABLE `t_state`
  ADD PRIMARY KEY (`sta_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_account`
--
ALTER TABLE `t_account`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `t_category`
--
ALTER TABLE `t_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `t_idea`
--
ALTER TABLE `t_idea`
  MODIFY `ide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `t_state`
--
ALTER TABLE `t_state`
  MODIFY `sta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_idea`
--
ALTER TABLE `t_idea`
  ADD CONSTRAINT `ACCOUNT_FK` FOREIGN KEY (`ide_account_fk`) REFERENCES `t_account` (`acc_id`),
  ADD CONSTRAINT `CATEGORY_FK` FOREIGN KEY (`ide_category_fk`) REFERENCES `t_category` (`cat_id`),
  ADD CONSTRAINT `STATE_FK` FOREIGN KEY (`ide_state_fk`) REFERENCES `t_state` (`sta_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
