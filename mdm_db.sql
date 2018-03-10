-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 10, 2018 at 05:12 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `association_table`
--

CREATE TABLE IF NOT EXISTS `association_table` (
  `id` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `id_baseline` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `id` int(11) NOT NULL,
  `component_name` char(40) NOT NULL,
  `subsystem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id_doc` int(11) NOT NULL,
  `id_document_language` int(11) NOT NULL,
  `id_document_version` int(11) NOT NULL,
  `id_document_reference` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_language`
--

CREATE TABLE IF NOT EXISTS `document_language` (
  `id_entry` int(11) NOT NULL,
  `language` varchar(60) NOT NULL,
  `project` varchar(60) NOT NULL,
  `translator` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_reference`
--

CREATE TABLE IF NOT EXISTS `document_reference` (
  `id_ref` int(11) NOT NULL DEFAULT '0',
  `name` char(255) NOT NULL DEFAULT 'To be defined',
  `subject` char(255) NOT NULL DEFAULT 'To be defined',
  `initial_language` char(2) NOT NULL DEFAULT 'EN',
  `previous_doc` char(255) NOT NULL,
  `product` int(11) NOT NULL,
  `component` int(11) NOT NULL,
  `installation` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `x_link` char(255) NOT NULL,
  `aec_link` char(255) NOT NULL,
  `ftp_link` char(255) NOT NULL,
  `sharepoint_vbn_link` char(255) NOT NULL,
  `sharepoint_blq_link` char(255) NOT NULL,
  `different_AEC` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_version`
--

CREATE TABLE IF NOT EXISTS `document_version` (
  `id_version` int(11) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT 'tbd',
  `site` varchar(3) NOT NULL,
  `pic` varchar(60) NOT NULL,
  `availability_x` tinyint(1) NOT NULL DEFAULT '0',
  `availability_aec` tinyint(1) NOT NULL DEFAULT '0',
  `availability_ftp` tinyint(1) NOT NULL DEFAULT '0',
  `availability_sharepoint_vbn` tinyint(1) NOT NULL DEFAULT '0',
  `availability_sharepoint_blq` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` varchar(100) NOT NULL DEFAULT 'peuplé par défaut',
  `working_field_1` char(20) NOT NULL,
  `working_field_2` char(20) NOT NULL,
  `working_field_3` char(20) NOT NULL,
  `working_field_4` char(20) NOT NULL,
  `status` enum('Public','Internal','Draft','Future','Obsolete') NOT NULL DEFAULT 'Draft'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `etcs_subsystem`
--

CREATE TABLE IF NOT EXISTS `etcs_subsystem` (
  `id` int(11) NOT NULL,
  `subsystem_name` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gatc_baseline`
--

CREATE TABLE IF NOT EXISTS `gatc_baseline` (
  `id_baseline` int(11) NOT NULL,
  `GATC_baseline` char(20) NOT NULL,
  `UNISIG_baseline` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL,
  `last_name` char(50) NOT NULL,
  `first_name` char(30) NOT NULL,
  `password` char(20) NOT NULL DEFAULT 'Alstom$Gest',
  `status` enum('Internal','External','Manager','Administrator','Forbidden') NOT NULL DEFAULT 'External',
  `language` char(2) NOT NULL DEFAULT 'EN',
  `isConnected` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `last_name`, `first_name`, `password`, `status`, `language`, `isConnected`) VALUES
(1, 'test', 'test', 'test', 'Administrator', 'EN', 1),
(3, 'jean', 'jean', 'jean', 'Administrator', 'EN', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `association_table`
--
ALTER TABLE `association_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_doc` (`id_doc`),
  ADD KEY `id_baseline` (`id_baseline`),
  ADD KEY `id_doc_2` (`id_doc`),
  ADD KEY `id_baseline_2` (`id_baseline`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subsystem` (`subsystem`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id_doc`),
  ADD KEY `id_document_language` (`id_document_language`),
  ADD KEY `id_document_version` (`id_document_version`),
  ADD KEY `id_document_reference` (`id_document_reference`);

--
-- Indexes for table `document_language`
--
ALTER TABLE `document_language`
  ADD PRIMARY KEY (`id_entry`);

--
-- Indexes for table `document_reference`
--
ALTER TABLE `document_reference`
  ADD PRIMARY KEY (`id_ref`),
  ADD KEY `product` (`product`),
  ADD KEY `component` (`component`);

--
-- Indexes for table `document_version`
--
ALTER TABLE `document_version`
  ADD PRIMARY KEY (`id_version`);

--
-- Indexes for table `etcs_subsystem`
--
ALTER TABLE `etcs_subsystem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gatc_baseline`
--
ALTER TABLE `gatc_baseline`
  ADD PRIMARY KEY (`id_baseline`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `association_table`
--
ALTER TABLE `association_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document_language`
--
ALTER TABLE `document_language`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document_version`
--
ALTER TABLE `document_version`
  MODIFY `id_version` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `etcs_subsystem`
--
ALTER TABLE `etcs_subsystem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gatc_baseline`
--
ALTER TABLE `gatc_baseline`
  MODIFY `id_baseline` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `association_table`
--
ALTER TABLE `association_table`
  ADD CONSTRAINT `FK_id_baseline` FOREIGN KEY (`id_baseline`) REFERENCES `gatc_baseline` (`id_baseline`),
  ADD CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_doc`) REFERENCES `document` (`id_doc`);

--
-- Constraints for table `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `FK_id_subsystem` FOREIGN KEY (`subsystem`) REFERENCES `etcs_subsystem` (`id`);

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `FK_id_document_language` FOREIGN KEY (`id_document_language`) REFERENCES `document_language` (`id_entry`),
  ADD CONSTRAINT `FK_id_document_reference` FOREIGN KEY (`id_document_reference`) REFERENCES `document_reference` (`id_ref`),
  ADD CONSTRAINT `FK_id_document_version` FOREIGN KEY (`id_document_version`) REFERENCES `document_version` (`id_version`);

--
-- Constraints for table `document_reference`
--
ALTER TABLE `document_reference`
  ADD CONSTRAINT `FK_component` FOREIGN KEY (`component`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `FK_product` FOREIGN KEY (`product`) REFERENCES `etcs_subsystem` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
