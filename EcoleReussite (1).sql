-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 04 oct. 2024 à 15:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `EcoleReussite`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` int(15) NOT NULL,
  `role` varchar(255) NOT NULL,
  `salaire_fixe` int(11) DEFAULT NULL,
  `tarif_horaire` int(11) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `archive` tinyint(1) DEFAULT 0,
  `matricule` varchar(25) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `nom`, `prenom`, `email`, `telephone`, `role`, `salaire_fixe`, `tarif_horaire`, `mot_de_passe`, `archive`, `matricule`, `date_creation`) VALUES
(1, 'Jean', 'Dupont', 'jean.dupont@example.com', 102030405, 'enseignant_primaire', 2000, NULL, '$2y$10$examplehash', 0, '20240001', '2024-10-04 13:08:02'),
(2, 'sk,sk,', 'k,k', 'jkn@qq.qq', 6456556, 'enseignant_secondaire', NULL, 65, '$2y$10$JWn3OC3VR/Jyu7yXcLyxBOmAQV.Pb1F0vVs/OyGBWwmBcEJfQO4Oy', 0, 'ENS20242702', '2024-10-04 13:08:02'),
(4, 'FALL', 'Amdy', 'amdyfall@gmail.com', 773451842, 'directeur', 500000, NULL, '$2y$10$36zTAumqjFgDHIAt9nrHg./s/1NmlG5P/TwxbcD.XuWCbt3btk5hO', 0, 'DIR20242622', '2024-10-04 13:08:02'),
(5, 'ss,d', 'klkk,', 'mmm@dd.dd', 84878, 'directeur', 554545, NULL, '$2y$10$INM8NI70/azKOtB.uTfogOmAADDcP.OQvXTF1junfk4cJGQGPFLbe', 0, 'DIR20241818', '2024-10-04 13:08:02'),
(6, 'THIAM', 'Mor', 'morthiam@gmail.com', 77854544, 'enseignant_primaire', 55000, NULL, '$2y$10$eR9iKmH6FjK5O4xqfVdk4eFwAvheogprR5W540hhNMGelA.iZi2gG', 0, 'ENS20240387', '2024-10-04 13:08:02'),
(7, 'dcsqs', 'jjkn', 'kk@ssj.ss', 755451, 'directeur', 5415, NULL, '$2y$10$NtPNlh6mlfZQ0ETt3zsgHuWcl89kIcTow0JedUCUFKoL8I8GY7Bly', 0, 'DIR20246981', '2024-10-04 13:08:02'),
(8, 'Mbaye', 'Mor', 'djbdj@dsds.dd', 445556622, 'directeur', 5451561, NULL, '$2y$10$Lj3dnobVc1YJi3LNKMvAB.mmDjGSFsbIWekq4gvEsxt8Unz8Q3S6i', 0, 'DIR20241266', '2024-10-04 13:08:02'),
(10, 'dfsdds', 'hvhh', 'kdd@xn--s-4ga.sss', 86454, 'directeur', 544, NULL, '$2y$10$h8KwcSOR7CfwkRbEKuWjKehnXZ84Ir2OHBcu5aODcMA7hN6yjuIkS', 0, 'DIR20245981', '2024-10-04 13:08:02'),
(11, 's sn', 'ss', 'jsn@dd.dd', 8454, 'directeur', 545, NULL, '$2y$10$/cyqlNpsiIabrHkQC2FHs.8kNjPZPDca4Blvi8iaLkUwa5ONd1hLm', 0, 'DIR20241103', '2024-10-04 13:08:02'),
(12, 'Dieng', 'Moustapha', 'moustaphadieng@gmail.com', 778945612, 'surveillant_classe', 150000, NULL, '$2y$10$gI5wIHmMoGPrTXB5TY/heOVELIPIrUvse33bH5tXbGtV4MuJ8ey4C', 0, 'SUR20242526', '2024-10-04 13:08:02'),
(13, 'Ba', 'Etienne', 'etienneba@gmail.com', 774561328, 'surveillant_general', 250000, NULL, '$2y$10$duLiCFE.UaAFebxHDI2eB.HkcmBLakPfw8CiUWBnAWuefFS2uDE/W', 0, 'SUR20246976', '2024-10-04 13:08:02'),
(14, 'Sane', 'Binta', 'bintasane@gmail.com', 773651248, 'comptable', 250000, NULL, '$2y$10$Gb39jMOQkVewVpEcxQu.DeJGcDnAzeW1hsTdC09V6LGRDFFbOB/Re', 0, 'COM20242118', '2024-10-04 13:08:02'),
(15, 'zaazkj', 'ijkj', 'kjszjsq@zg.xn--zaaz-j4a', 956584, 'directeur', 9565, NULL, '$2y$10$ooi2/Js4JDaBcplAnWQw9um4Kr3WlOJSIK6GZhdbLuo4jVZqw2tGi', 0, 'DIR20249205', '2024-10-04 13:08:02'),
(16, 'SJHQSJH', 'JKJKJK', 'taphisllefa@gmail.com', 5545, 'directeur', 5144, NULL, '$2y$10$Yavsnoraw4tEwbbkxjU.AOAH5iozvWgTzy93DoRPLTrLiAOIwExva', 0, 'DIR20246857', '2024-10-04 13:08:02'),
(17, 'dssd', 'dss', 'jhghjn@aaa.aaa', 8484854, 'enseignant_secondaire', NULL, 56565, '$2y$10$Fs2uYMXQ48KDIzZGEZEUuO6jPBiuEekqFzZz1FzzMZTdJf2WyYC4S', 0, 'ENS20247517', '2024-10-04 13:08:02'),
(18, 'jjnjn', 'dieye', 'jqkjk@sss.sokop', 66565, 'enseignant_primaire', 6655956, NULL, '$2y$10$xFfqSbPB.lDDKnTLdlBm5.uzpF5S/q0q5CwWyKDECxjH6UoYASsze', 0, 'ENS20243649', '2024-10-04 13:08:02'),
(22, 'qsklj', 'kljkj', 'kljk@jhk.juj', 554656, 'comptable', 1, NULL, '$2y$10$QMlqs9gvwt6UQ4oX978OsOxmgm7IRVsmqGBAhnLgxvkCh9gojgKLK', 0, 'COM20241496', '2024-10-04 13:08:02'),
(23, 'Niang', 'Matar', 'matar.niang@gmail.com', 789652317, 'comptable', 200000, NULL, '$2y$10$OVzHFLvPMvA0MLasaE2km.cSLGrr5yXhmCKm8u9aZsOV8P2tSPFtu', 0, 'COM20247124', '2024-10-04 13:08:02'),
(24, 'Mbengue', 'Mame', 'mamembengue@gmail.com', 774561236, 'comptable', 275000, NULL, 'Amdyfall-97', 1, 'COMP20241567', '2024-10-04 13:08:02'),
(25, 'test', 'test', 'test@test.test', 48484, 'directeur', 844, NULL, '$2y$10$Ebax9eX8I7NOuJe84WEJke.XUDBux3yI86Xzr0YYvIZiIluFr8ECe', 0, 'DIR20243467', '2024-10-04 13:08:02'),
(26, 'njnj', 'njnj', 'jnn@ss.ss', 45454, 'directeur', 5545, NULL, '$2y$10$gL3ynfgI7BjmVaBM2Cf2zOLpOt4Rrvbpqs1Ihh23w22SXN6utoz1K', 0, 'DIR20247389', '2024-10-04 13:08:02'),
(27, 'testbt', 'tbt', 'bt@bt.bt', 445545, 'directeur', 454545, NULL, '$2y$10$3NbCwKsBEnf/TsJPmRM9tuvVeFb0ccwuUdGIjz5ptQDlhUleL.e2q', 0, 'DIR20243602', '2024-10-04 13:08:02'),
(28, 'tttttt', 'ffffff', 'a@a.com', -12, 'directeur', -16, NULL, '$2y$10$nTaAC5GqyCeCYbFxZNa0feFUXzJjzJew/mn4KPe0mHTL5rxxZDIBO', 0, 'DIR20245644', '2024-10-04 13:08:02');

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id` int(11) NOT NULL,
  `nom_classe` varchar(10) NOT NULL,
  `id_cycle` int(11) DEFAULT NULL,
  `seuil_max` int(11) DEFAULT 25,
  `is_annexe` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id`, `nom_classe`, `id_cycle`, `seuil_max`, `is_annexe`) VALUES
(2, 'CE1', 3, 25, 0);

-- --------------------------------------------------------

--
-- Structure de la table `classe_matiere`
--

CREATE TABLE `classe_matiere` (
  `id` int(11) NOT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_matiere` int(11) DEFAULT NULL,
  `id_enseignant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe_matiere`
--

INSERT INTO `classe_matiere` (`id`, `id_classe`, `id_matiere`, `id_enseignant`) VALUES
(1, 2, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `cycle`
--

CREATE TABLE `cycle` (
  `id` int(11) NOT NULL,
  `nom_cycle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cycle`
--

INSERT INTO `cycle` (`id`, `nom_cycle`) VALUES
(2, 'ssqsq'),
(3, 'primaire');

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `moyenne_generale` decimal(4,2) DEFAULT NULL,
  `tuteur_email` varchar(100) NOT NULL,
  `archive` tinyint(1) DEFAULT 0,
  `mot_de_passe` text NOT NULL,
  `genre` varchar(50) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numero_tuteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emploi_temps`
--

CREATE TABLE `emploi_temps` (
  `id` int(11) NOT NULL,
  `id_classe_matiere` int(11) DEFAULT NULL,
  `jour_semaine` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `mois` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id` int(11) NOT NULL,
  `nom_matiere` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id`, `nom_matiere`) VALUES
(1, 'Observation');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(11) NOT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `id_matiere` int(11) DEFAULT NULL,
  `note_semestre_1` decimal(5,2) DEFAULT NULL,
  `note_semestre_2` decimal(5,2) DEFAULT NULL,
  `annee_scolaire` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement_eleve`
--

CREATE TABLE `paiement_eleve` (
  `id` int(11) NOT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `mois` varchar(20) NOT NULL,
  `annee` int(11) NOT NULL,
  `montant_paye` decimal(10,2) NOT NULL,
  `date_paiement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement_enseignant`
--

CREATE TABLE `paiement_enseignant` (
  `id` int(11) NOT NULL,
  `id_administrateur` int(11) DEFAULT NULL,
  `mois` varchar(20) NOT NULL,
  `annee` int(11) NOT NULL,
  `heures_travaillees` int(11) DEFAULT 0,
  `salaire` decimal(10,2) NOT NULL,
  `date_paiement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

CREATE TABLE `presence` (
  `id` int(11) NOT NULL,
  `id_classe_matiere` int(11) DEFAULT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `id_enseignant` int(11) DEFAULT NULL,
  `date_cours` date NOT NULL,
  `heure_cours` time NOT NULL,
  `presence_eleve` tinyint(1) DEFAULT 0,
  `presence_enseignant` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telephone` (`telephone`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`,`telephone`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cycle` (`id_cycle`);

--
-- Index pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_matiere` (`id_matiere`),
  ADD KEY `id_enseignant` (`id_enseignant`);

--
-- Index pour la table `cycle`
--
ALTER TABLE `cycle`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tuteur_email` (`tuteur_email`),
  ADD UNIQUE KEY `tuteur_email_2` (`tuteur_email`),
  ADD UNIQUE KEY `numero_tuteur` (`numero_tuteur`),
  ADD KEY `id_classe` (`id_classe`);

--
-- Index pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe_matiere` (`id_classe_matiere`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id_eleve` (`id_eleve`),
  ADD KEY `id_matiere` (`id_matiere`);

--
-- Index pour la table `paiement_eleve`
--
ALTER TABLE `paiement_eleve`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_eleve` (`id_eleve`);

--
-- Index pour la table `paiement_enseignant`
--
ALTER TABLE `paiement_enseignant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_administrateur` (`id_administrateur`);

--
-- Index pour la table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe_matiere` (`id_classe_matiere`),
  ADD KEY `id_eleve` (`id_eleve`),
  ADD KEY `id_enseignant` (`id_enseignant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cycle`
--
ALTER TABLE `cycle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement_eleve`
--
ALTER TABLE `paiement_eleve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement_enseignant`
--
ALTER TABLE `paiement_enseignant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `presence`
--
ALTER TABLE `presence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`id_cycle`) REFERENCES `cycle` (`id`);

--
-- Contraintes pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD CONSTRAINT `classe_matiere_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`),
  ADD CONSTRAINT `classe_matiere_ibfk_2` FOREIGN KEY (`id_matiere`) REFERENCES `matiere` (`id`),
  ADD CONSTRAINT `classe_matiere_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `administrateur` (`id`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`);

--
-- Contraintes pour la table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD CONSTRAINT `emploi_temps_ibfk_1` FOREIGN KEY (`id_classe_matiere`) REFERENCES `classe_matiere` (`id`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_matiere`) REFERENCES `matiere` (`id`);

--
-- Contraintes pour la table `paiement_eleve`
--
ALTER TABLE `paiement_eleve`
  ADD CONSTRAINT `paiement_eleve_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id`);

--
-- Contraintes pour la table `paiement_enseignant`
--
ALTER TABLE `paiement_enseignant`
  ADD CONSTRAINT `paiement_enseignant_ibfk_1` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id`);

--
-- Contraintes pour la table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `presence_ibfk_1` FOREIGN KEY (`id_classe_matiere`) REFERENCES `classe_matiere` (`id`),
  ADD CONSTRAINT `presence_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `presence_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `administrateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
