
DROP TABLE IF EXISTS `document_language`;


CREATE TABLE `document_language` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(60) NOT NULL,
  `project` varchar(60) NOT NULL,
  `translator` varchar(60) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;


INSERT INTO document_language VALUES
("56","EN","Sunshine","Lambert"),
("57","FR","Umbrella","Med"),
("58","NL","Mitsui","M. Dupont"),
("59","DN","Illusion","Medor"),
("60","","",""),
("61","EN","Mitsubishi","Roger"),
("62","JP","TOPINF","S. Sueur");



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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;


INSERT INTO document_reference VALUES
("33","4RDUKP5396","TRAINBORNE MAINTENANCE BOX - MANUEL UTILISATEUR","EN","","Tools","ODE","0","1","","","","","","1"),
("34","5.0300.091","TRU SEHERON TELOC 1550 SYSTEM DESCRIPTION","DE","","TRU","TELOC 1550","1","0","","","","","","1"),
("35","CMD_CRL_DESG_0056","Cold Movement Detector - Installation Constraints","JP","","CMD","","1","0","C:\\Desktop","","","","","1"),
("36","NEWDOC","Cold Movement Detector - Installation Constraints","JP","","CMD","","1","1","C:\\Desktop","","","","","1"),
("37","Test_document","To be defined","EN","","NewProduct","NewComponent","1","1","","","","","","1");



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
  `remarks` varchar(100) NOT NULL DEFAULT 'peuplÃƒÂ© par dÃƒÂ©faut',
  `working_field_1` varchar(20) NOT NULL DEFAULT '',
  `working_field_2` varchar(20) NOT NULL DEFAULT '',
  `working_field_3` varchar(20) NOT NULL DEFAULT '',
  `working_field_4` varchar(20) NOT NULL DEFAULT '',
  `status` enum('Public','Internal','Draft','Future','Obsolete') NOT NULL DEFAULT 'Draft',
  PRIMARY KEY (`id_version`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;


INSERT INTO document_version VALUES
("51","A01","VBN","M. Dem.","0","0","0","0","0","peuplÃƒÂ© par dÃƒÂ©faut","allo","meh","","","Public"),
("52","A02","VBN","M. Dem.","0","0","0","0","0","peuplÃƒÂ© par dÃƒÂ©faut","uh","meh","","","Public"),
("53","10.2C","CRL","C. Bac.","0","0","0","0","0","Needs to be reviewed","Working","field","","","Draft"),
("54","TBD","CRL","C. Bac.","0","0","0","0","0","Needs to be reviewed","test","recette","","","Draft"),
("55","1.0","CRL","","1","0","0","0","0","peuplÃƒÂ© par dÃƒÂ©faut","","","","","Future"),
("56","3.0","CRL","C. Bac.","1","0","0","0","0","peuplÃƒÂ© par dÃƒÂ©faut","","","","","Draft"),
("57","1.0","CRL","M. Kubiak","1","0","0","0","0","peuplÃƒÂ© par dÃƒÂ©faut","","","","","Public");



DROP TABLE IF EXISTS `gatc_baseline`;


CREATE TABLE `gatc_baseline` (
  `id_baseline` int(11) NOT NULL AUTO_INCREMENT,
  `GATC_baseline` char(20) NOT NULL,
  `UNISIG_baseline` char(20) NOT NULL,
  PRIMARY KEY (`id_baseline`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;


INSERT INTO gatc_baseline VALUES
("23","5.6.0","2"),
("24","5.7.0","2");



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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


INSERT INTO users VALUES
("1","test","test","test","Administrator","FR","1"),
("13","external","external","external","External","EN","0"),
("14","internal","internal","internal","Internal","FR","0"),
("15","manager1","manager1","manager1","Manager","FR","0"),
("16","forbidden","forbidden","forbidden","Forbidden","EN","0"),
("17","manager2","manager2","manager2","Manager","EN","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;


INSERT INTO document VALUES
("79","56","51","33"),
("80","56","52","33"),
("81","57","52","33"),
("82","58","53","34"),
("83","56","53","34"),
("84","59","51","33"),
("85","58","54","34"),
("86","60","55","35"),
("87","61","56","36"),
("88","62","57","37");



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
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;


INSERT INTO association_table VALUES
("79","79","23"),
("80","80","24"),
("81","81","24"),
("82","82","23"),
("83","83","23"),
("84","84","24"),
("85","85","23"),
("86","86","23"),
("87","87","23"),
("88","88","24");


