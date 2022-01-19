-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 sep. 2021 à 05:53
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `backend1`
--

-- --------------------------------------------------------

--
-- Structure de la table `blinderie`
--

DROP TABLE IF EXISTS `blinderie`;
CREATE TABLE IF NOT EXISTS `blinderie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie1`
--

DROP TABLE IF EXISTS `categorie1`;
CREATE TABLE IF NOT EXISTS `categorie1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie1`
--

INSERT INTO `categorie1` (`id`, `type`) VALUES
(1, 'Insonoriée'),
(2, 'Familiale');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie1_id_id` int(11) NOT NULL,
  `femmeid_id` int(11) NOT NULL,
  `codech` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prixjournalier` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_menage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_menage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C509E4FFA8D3EF4A` (`categorie1_id_id`),
  KEY `IDX_C509E4FF6957B746` (`femmeid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id`, `categorie1_id_id`, `femmeid_id`, `codech`, `prixjournalier`, `statut`, `photo`, `capacite`, `state_menage`, `heure_menage`) VALUES
(1, 1, 1, 'C001', 30000, 'occupe', '026d2649f0dfaf753e3719c6e2f0e141.jpeg', '3 personnes', 'true', '10:05'),
(2, 2, 2, 'C002', 30000, 'disponible', '70b93b80507da06df01fd6c9cd7fce6e.jpeg', '5 personnes', 'true', '09:01'),
(3, 1, 1, 'C003', 35000, 'occupe', 'ac474684783916f1448ef947fe16d658.jpeg', '2 personnes', 'false', '09:10');

-- --------------------------------------------------------

--
-- Structure de la table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cliente`
--

INSERT INTO `cliente` (`id`, `nom`, `prenom`, `adresse`, `age`, `sexe`, `civil`, `telephone`, `national`, `categorie`) VALUES
(1, 'RANDRIA', 'zaza', 'Betania', '52', 'homme', 'Marié', '(032) 556-6666', 'Malagasy', 'Temporaire'),
(2, 'RASOLO', 'Nrina', 'Maninday', '30', 'homme', 'Marié', '(032) 222-2228', 'Malagasy', 'Abonné'),
(3, 'HUGUE', 'Daniel', 'Tsianaloka', '36', 'homme', 'Celibataire', '(020) 225-8877', 'Français', 'Temporaire'),
(4, 'ZAZA', 'Titi', 'Mangabe', '36', 'femme', 'Mriée', '(034) 558-9988', 'Français', 'Temporaire');

-- --------------------------------------------------------

--
-- Structure de la table `dateday`
--

DROP TABLE IF EXISTS `dateday`;
CREATE TABLE IF NOT EXISTS `dateday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daytoday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dateday`
--

INSERT INTO `dateday` (`id`, `daytoday`) VALUES
(1, '2021-09-30');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210925120736', '2021-09-30 05:11:59', 6216);

-- --------------------------------------------------------

--
-- Structure de la table `femme_chambre`
--

DROP TABLE IF EXISTS `femme_chambre`;
CREATE TABLE IF NOT EXISTS `femme_chambre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `femme_chambre`
--

INSERT INTO `femme_chambre` (`id`, `nom`, `prenom`, `adresse`, `telephone`) VALUES
(1, 'RANDRIANIRINA', 'Roseline', 'Betania', '(032) 665-8897'),
(2, 'HELEME', 'Marie', 'Ankenta', '(032) 589-9888');

-- --------------------------------------------------------

--
-- Structure de la table `heberge`
--

DROP TABLE IF EXISTS `heberge`;
CREATE TABLE IF NOT EXISTS `heberge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numcli_id` int(11) NOT NULL,
  `numchambre_id` int(11) NOT NULL,
  `dateentre` datetime NOT NULL,
  `nbjours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `compagne` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datesortie` datetime NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D217B48071F5BF5A` (`numcli_id`),
  KEY `IDX_D217B480A455AA95` (`numchambre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `heberge`
--

INSERT INTO `heberge` (`id`, `numcli_id`, `numchambre_id`, `dateentre`, `nbjours`, `compagne`, `montant`, `datesortie`, `statut`, `payement`) VALUES
(1, 2, 3, '2021-08-09 07:41:00', '5', '3 personnes', '175000', '2021-08-13 07:41:00', 'ok', 'Chèque'),
(2, 1, 1, '2021-09-29 07:40:00', '3', '2 personnes', '90000', '2021-10-01 07:40:00', 'ko', 'Espèce'),
(3, 1, 2, '2021-09-15 07:42:00', '2', '3 personnes', '60000', '2021-09-16 07:42:00', 'ok', 'Espèce'),
(4, 3, 3, '2021-09-30 07:43:00', '10', '2 personnes', '350000', '2021-10-09 07:43:00', 'ko', 'Chèque'),
(5, 4, 2, '2021-08-08 07:50:00', '3', '2 personnes', '90000', '2021-08-10 07:50:00', 'ok', 'Espèce'),
(6, 1, 2, '2021-07-22 07:50:00', '3', '2 personnes', '90000', '2021-07-24 07:50:00', 'ok', 'Chèque');

-- --------------------------------------------------------

--
-- Structure de la table `pucture`
--

DROP TABLE IF EXISTS `pucture`;
CREATE TABLE IF NOT EXISTS `pucture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(16, 'UserApplication', 'useradmin@gmail.com', '$2y$13$o8tQ3WBSGePmGcTyNWAUkeJIn.QB31TXt/GrS0/ZJ0vYywTDlKvSS');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `FK_C509E4FF6957B746` FOREIGN KEY (`femmeid_id`) REFERENCES `femme_chambre` (`id`),
  ADD CONSTRAINT `FK_C509E4FFA8D3EF4A` FOREIGN KEY (`categorie1_id_id`) REFERENCES `categorie1` (`id`);

--
-- Contraintes pour la table `heberge`
--
ALTER TABLE `heberge`
  ADD CONSTRAINT `FK_D217B48071F5BF5A` FOREIGN KEY (`numcli_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `FK_D217B480A455AA95` FOREIGN KEY (`numchambre_id`) REFERENCES `chambre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
