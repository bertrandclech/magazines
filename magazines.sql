-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 26 fév. 2022 à 15:36
-- Version du serveur : 8.0.28
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `magazines`
--

-- --------------------------------------------------------

--
-- Structure de la table `editeur`
--

CREATE TABLE `editeur` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `editeur`
--

INSERT INTO `editeur` (`id`, `nom`) VALUES
(1, 'Pressefactory'),
(2, 'Nuxos Publishing Technologies'),
(3, 'KUNAN PRODUCTION'),
(4, 'Éditions Larivière');

-- --------------------------------------------------------

--
-- Structure de la table `magazine`
--

CREATE TABLE `magazine` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `editeur_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `magazine`
--

INSERT INTO `magazine` (`id`, `nom`, `description`, `prix`, `image`, `editeur_id`) VALUES
(1, 'iCreate', 'Le magazine des utilisateurs Mac. ...', '6.00', 'images/icreate_1.jpg', 2),
(2, 'Micro pratique', 'Le magazine Micro Pratique décrypte toutes les nouveautés matérielles et logicielles, et axe son contenu sur l’assistance, le dépannage et la mise en œuvre de solutions personnelles.', '6.50', 'images/micropratique_2.jpeg', 4),
(3, 'VTT magazine', 'La revue Bike s\'adresse à tous les mordus du VTT, quelle que soit la discipline : compétition, rando, descente, cross-country, freeride...', '6.95', 'images/vttmagazine_3.jpg', 4),
(4, 'vumètre', 'VUmètre est un magazine qui traite de \r\nla haute-fidélité sonore sous toutes ses formes, de manière experte, haut de gamme, ludique et parfois décalée.', '10.00', 'images/vumetre_4.jpg', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `editeur`
--
ALTER TABLE `editeur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `magazine`
--
ALTER TABLE `magazine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `editeur_id` (`editeur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `editeur`
--
ALTER TABLE `editeur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `magazine`
--
ALTER TABLE `magazine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `magazine`
--
ALTER TABLE `magazine`
  ADD CONSTRAINT `magazine_ibfk_1` FOREIGN KEY (`editeur_id`) REFERENCES `editeur` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
