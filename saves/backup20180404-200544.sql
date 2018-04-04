--
-- backup20180404-200544.sql


DROP TABLE IF EXISTS `association_table`;
CREATE TABLE `association_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_doc` int(11) NOT NULL,
  `id_baseline` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_doc` (`id_doc`),
  KEY `id_baseline` (`id_baseline`),
  KEY `id_doc_2` (`id_doc`),
  KEY `id_baseline_2` (`id_baseline`),
  CONSTRAINT `FK_id_baseline` FOREIGN KEY (`id_baseline`) REFERENCES `gatc_baseline` (`id_baseline`),
  CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_doc`) REFERENCES `document` (`id_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

INSERT INTO `association_table` VALUES ('16','16','4');
INSERT INTO `association_table` VALUES ('17','17','4');
INSERT INTO `association_table` VALUES ('18','18','3');
INSERT INTO `association_table` VALUES ('19','19','3');
INSERT INTO `association_table` VALUES ('20','20','4');
INSERT INTO `association_table` VALUES ('21','21','3');
INSERT INTO `association_table` VALUES ('22','22','3');
INSERT INTO `association_table` VALUES ('23','23','3');
INSERT INTO `association_table` VALUES ('24','24','3');


DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_document_language` int(11) NOT NULL,
  `id_document_version` int(11) NOT NULL,
  `id_document_reference` int(11) NOT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `id_document_language` (`id_document_language`),
  KEY `id_document_version` (`id_document_version`),
  KEY `id_document_reference` (`id_document_reference`),
  CONSTRAINT `FK_id_document_language` FOREIGN KEY (`id_document_language`) REFERENCES `document_language` (`id_entry`),
  CONSTRAINT `FK_id_document_reference` FOREIGN KEY (`id_document_reference`) REFERENCES `document_reference` (`id_ref`),
  CONSTRAINT `FK_id_document_version` FOREIGN KEY (`id_document_version`) REFERENCES `document_version` (`id_version`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

INSERT INTO `document` VALUES ('16','10','10','5');
INSERT INTO `document` VALUES ('17','11','10','5');
INSERT INTO `document` VALUES ('18','12','11','6');
INSERT INTO `document` VALUES ('19','10','11','6');
INSERT INTO `document` VALUES ('20','13','10','5');
INSERT INTO `document` VALUES ('21','12','12','6');
INSERT INTO `document` VALUES ('22','14','13','7');
INSERT INTO `document` VALUES ('23','12','14','6');
INSERT INTO `document` VALUES ('24','15','15','8');


DROP TABLE IF EXISTS `document_language`;
CREATE TABLE `document_language` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(60) NOT NULL,
  `project` varchar(60) NOT NULL,
  `translator` varchar(60) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO `document_language` VALUES ('10','EN','Sunshine','Lambert');
INSERT INTO `document_language` VALUES ('11','FR','Umbrella','Med');
INSERT INTO `document_language` VALUES ('12','NL','Mitsui','M. Dupont');
INSERT INTO `document_language` VALUES ('13','DN','Illusion','Medor');
INSERT INTO `document_language` VALUES ('14','','','');
INSERT INTO `document_language` VALUES ('15','EN','Mitsubishi','Roger');


DROP TABLE IF EXISTS `document_reference`;
CREATE TABLE `document_reference` (
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

INSERT INTO `document_reference` VALUES ('5','4RDUKP5396','TRAINBORNE MAINTENANCE BOX - MANUEL UTILISATEUR','EN','','Tools','ODE','0','1','','','','','','1');
INSERT INTO `document_reference` VALUES ('6','5.0300.091','TRU SEHERON TELOC 1550 SYSTEM DESCRIPTION','DE','','TRU','TELOC 1550','1','1','','','','','','1');
INSERT INTO `document_reference` VALUES ('7','CMD_CRL_DESG_0056','Cold Movement Detector - Installation Constraints','JP','','CMD','','1','0','C:\\Desktop','','','','','1');
INSERT INTO `document_reference` VALUES ('8','NEWDOC','Cold Movement Detector - Installation Constraints','JP','','CMD','','0','0','C:\\Desktop','','','','','1');


DROP TABLE IF EXISTS `document_version`;
CREATE TABLE `document_version` (
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

INSERT INTO `document_version` VALUES ('1','A01','VBN','M. Dem.','0','0','0','0','0','peuplé par défaut','uh','meh','','','Public');
INSERT INTO `document_version` VALUES ('2','10.2C','CRL','C. Bac.','0','0','0','0','0','Needs to be reviewed','Working','field','','','Draft');
INSERT INTO `document_version` VALUES ('10','A01','VBN','M. Dem.','0','0','0','0','0','peuplé par défaut','uh','meh','','','Public');
INSERT INTO `document_version` VALUES ('11','10.2C','CRL','C. Bac.','0','0','0','0','0','Needs to be reviewed','Working','field','','','Draft');
INSERT INTO `document_version` VALUES ('12','TBD','CRL','C. Bac.','0','0','0','0','0','Needs to be reviewed','Working','field','','','Draft');
INSERT INTO `document_version` VALUES ('13','1.0','CRL','','1','0','0','0','0','peuplé par défaut','','','','','Future');
INSERT INTO `document_version` VALUES ('14','TBD','CRL','C. Bac.','0','0','0','0','0','Needs to be reviewed','Working','field','','','Draft');
INSERT INTO `document_version` VALUES ('15','3.0','CRL','C. Bac.','1','0','0','0','0','peuplé par défaut','','','','','Draft');


DROP TABLE IF EXISTS `gatc_baseline`;
CREATE TABLE `gatc_baseline` (
  `id_baseline` int(11) NOT NULL AUTO_INCREMENT,
  `GATC_baseline` char(20) NOT NULL,
  `UNISIG_baseline` char(20) NOT NULL,
  PRIMARY KEY (`id_baseline`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `gatc_baseline` VALUES ('3','5.6.0','2');
INSERT INTO `gatc_baseline` VALUES ('4','5.7.0','2');


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` char(50) NOT NULL,
  `first_name` char(30) NOT NULL,
  `password` char(20) NOT NULL DEFAULT 'Alstom$Gest',
  `status` enum('Internal','External','Manager','Administrator','Forbidden') NOT NULL DEFAULT 'External',
  `language` char(2) NOT NULL DEFAULT 'EN',
  `isConnected` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `users` VALUES ('1','test','test','test','Administrator','FR','1');
