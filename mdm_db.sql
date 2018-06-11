-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 04 avr. 2018 à 10:57
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mdm_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `association_table`
--

DROP TABLE IF EXISTS `association_table`;
CREATE TABLE IF NOT EXISTS `association_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_doc` int(11) NOT NULL,
  `id_baseline` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_doc` (`id_doc`),
  KEY `id_baseline` (`id_baseline`),
  KEY `id_doc_2` (`id_doc`),
  KEY `id_baseline_2` (`id_baseline`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `association_table`
--


INSERT INTO `association_table` (`id`, `id_doc`, `id_baseline`) VALUES
(16, 16, 4),
(17, 17, 4),
(18, 18, 3),
(19, 19, 3),
(20, 20, 4),
(21, 21, 3),
(22, 22, 3),
(23, 23, 3),
(24, 24, 3);

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_document_language` int(11) NOT NULL,
  `id_document_version` int(11) NOT NULL,
  `id_document_reference` int(11) NOT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `id_document_language` (`id_document_language`),
  KEY `id_document_version` (`id_document_version`),
  KEY `id_document_reference` (`id_document_reference`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document`
--


INSERT INTO `document` (`id_doc`, `id_document_language`, `id_document_version`, `id_document_reference`) VALUES

(16, 10, 10, 5),
(17, 11, 10, 5),
(18, 12, 11, 6),
(19, 10, 11, 6),
(20, 13, 10, 5),
(21, 12, 12, 6),
(22, 14, 13, 7),
(23, 12, 14, 6),
(24, 15, 15, 8);

-- --------------------------------------------------------

--
-- Structure de la table `document_language`
--

DROP TABLE IF EXISTS `document_language`;
CREATE TABLE IF NOT EXISTS `document_language` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(60) NOT NULL,
  `project` varchar(60) NOT NULL,
  `translator` varchar(60) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document_language`
--

INSERT INTO `document_language` (`id_entry`, `language`, `project`, `translator`) VALUES
(10, 'EN', 'Sunshine', 'Lambert'),
(11, 'FR', 'Umbrella', 'Med'),
(12, 'NL', 'Mitsui', 'M. Dupont'),
(13, 'DN', 'Illusion', 'Medor'),
(14, '', '', ''),
(15, 'EN', 'Mitsubishi', 'Roger');

-- --------------------------------------------------------

--
-- Structure de la table `document_reference`
--

DROP TABLE IF EXISTS `document_reference`;
CREATE TABLE IF NOT EXISTS `document_reference` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL DEFAULT 'To be defined',
  `subject` varchar(255) NOT NULL DEFAULT 'To be defined',
  `initial_language` varchar(2) NOT NULL DEFAULT 'EN',
  `previous_doc` varchar(255) NOT NULL DEFAULT '',
  `product` varchar(10) DEFAULT '',
  `component` varchar(40) NOT NULL DEFAULT '',
  `installation` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `x_link` varchar(255) NOT NULL DEFAULT '',
  `aec_link` varchar(255) NOT NULL DEFAULT '',
  `ftp_link` varchar(255) NOT NULL DEFAULT '',
  `sharepoint_vbn_link` varchar(255) NOT NULL DEFAULT '',
  `sharepoint_blq_link` varchar(255) NOT NULL DEFAULT '',
  `different_AEC` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_ref`),
  KEY `product` (`product`),
  KEY `component` (`component`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


--
-- Déchargement des données de la table `document_reference`
--

INSERT INTO `document_reference` (`id_ref`, `reference`, `subject`, `initial_language`, `previous_doc`, `product`, `component`, `installation`, `maintenance`, `x_link`, `aec_link`, `ftp_link`, `sharepoint_vbn_link`, `sharepoint_blq_link`, `different_AEC`) VALUES
(5, '4RDUKP5396', 'TRAINBORNE MAINTENANCE BOX - MANUEL UTILISATEUR', 'EN', '', 'Tools', 'ODE', 0, 1, '', '', '', '', '', 1),
(6, '5.0300.091', 'TRU SEHERON TELOC 1550 SYSTEM DESCRIPTION', 'DE', '', 'TRU', 'TELOC 1550', 1, 1, '', '', '', '', '', 1),
(7, 'CMD_CRL_DESG_0056', 'Cold Movement Detector - Installation Constraints', 'JP', '', 'CMD', '', 1, 0, 'C:\\Desktop', '', '', '', '', 1),
(8, 'NEWDOC', 'Cold Movement Detector - Installation Constraints', 'JP', '', 'CMD', '', 0, 0, 'C:\\Desktop', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `document_version`
--

DROP TABLE IF EXISTS `document_version`;
CREATE TABLE IF NOT EXISTS `document_version` (
  `id_version` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(10) NOT NULL DEFAULT 'TBD',
  `site` varchar(3) NOT NULL DEFAULT '',
  `pic` varchar(60) NOT NULL DEFAULT '',
  `availability_x` tinyint(1) NOT NULL DEFAULT '0',
  `availability_aec` tinyint(1) NOT NULL DEFAULT '0',
  `availability_ftp` tinyint(1) NOT NULL DEFAULT '0',
  `availability_sharepoint_vbn` tinyint(1) NOT NULL DEFAULT '0',
  `availability_sharepoint_blq` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` varchar(100) NOT NULL DEFAULT 'peuplé par défaut',
  `working_field_1` varchar(20) NOT NULL DEFAULT '',
  `working_field_2` varchar(20) NOT NULL DEFAULT '',
  `working_field_3` varchar(20) NOT NULL DEFAULT '',
  `working_field_4` varchar(20) NOT NULL DEFAULT '',
  `status` enum('Public','Internal','Draft','Future','Obsolete') NOT NULL DEFAULT 'Draft',
  PRIMARY KEY (`id_version`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document_version`
--

INSERT INTO `document_version` (`id_version`, `version`, `site`, `pic`, `availability_x`, `availability_aec`, `availability_ftp`, `availability_sharepoint_vbn`, `availability_sharepoint_blq`, `remarks`, `working_field_1`, `working_field_2`, `working_field_3`, `working_field_4`, `status`) VALUES
(10, 'A01', 'VBN', 'M. Dem.', 0, 0, 0, 0, 0, 'peuplé par défaut', 'uh', 'meh', '', '', 'Public'),
(11, '10.2C', 'CRL', 'C. Bac.', 0, 0, 0, 0, 0, 'Needs to be reviewed', 'Working', 'field', '', '', 'Draft'),
(12, 'TBD', 'CRL', 'C. Bac.', 0, 0, 0, 0, 0, 'Needs to be reviewed', 'Working', 'field', '', '', 'Draft'),
(13, '1.0', 'CRL', '', 1, 0, 0, 0, 0, 'peuplé par défaut', '', '', '', '', 'Future'),
(14, 'TBD', 'CRL', 'C. Bac.', 0, 0, 0, 0, 0, 'Needs to be reviewed', 'Working', 'field', '', '', 'Draft'),
(15, '3.0', 'CRL', 'C. Bac.', 1, 0, 0, 0, 0, 'peuplé par défaut', '', '', '', '', 'Draft');

-- --------------------------------------------------------


--
-- Structure de la table `gatc_baseline`
--

DROP TABLE IF EXISTS `gatc_baseline`;
CREATE TABLE IF NOT EXISTS `gatc_baseline` (
  `id_baseline` int(11) NOT NULL AUTO_INCREMENT,
  `GATC_baseline` char(20) NOT NULL,
  `UNISIG_baseline` char(20) NOT NULL,
  PRIMARY KEY (`id_baseline`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gatc_baseline`
--

INSERT INTO `gatc_baseline` (`id_baseline`, `GATC_baseline`, `UNISIG_baseline`) VALUES
(3, '5.6.0', '2'),
(4, '5.7.0', '2');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` char(50) NOT NULL,
  `first_name` char(30) NOT NULL,
  `password` char(250) NOT NULL DEFAULT 'Alstom$Gest',
  `status` enum('Internal','External','Manager','Administrator','Forbidden') NOT NULL DEFAULT 'External',
  `language` char(2) NOT NULL DEFAULT 'EN',
  `isConnected` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `last_name`, `first_name`, `password`, `status`, `language`, `isConnected`) VALUES
(1, 'test', 'test', 'test', 'Administrator', 'EN', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `association_table`
--
ALTER TABLE `association_table`
  ADD CONSTRAINT `FK_id_baseline` FOREIGN KEY (`id_baseline`) REFERENCES `gatc_baseline` (`id_baseline`),
  ADD CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_doc`) REFERENCES `document` (`id_doc`);

--
-- Contraintes pour la table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `FK_id_document_language` FOREIGN KEY (`id_document_language`) REFERENCES `document_language` (`id_entry`),
  ADD CONSTRAINT `FK_id_document_reference` FOREIGN KEY (`id_document_reference`) REFERENCES `document_reference` (`id_ref`),
  ADD CONSTRAINT `FK_id_document_version` FOREIGN KEY (`id_document_version`) REFERENCES `document_version` (`id_version`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
