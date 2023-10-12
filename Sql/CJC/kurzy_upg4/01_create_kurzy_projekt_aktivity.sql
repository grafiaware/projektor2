/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 11. 10. 2023
 */

DROP TABLE `kurz` IF EXISTS;
DROP TABLE `kurz_druh` IF EXISTS;
DROP TABLE `kurz_typ_kvalifikace` IF EXISTS;
DROP TABLE `kancelar` IF EXISTS;
DROP TABLE `projekt` IF EXISTS;

/**
 * CREATE
 */
CREATE TABLE `projekt` (
  `kod` char(20) NOT NULL,
  `razeni` int(11) NOT NULL,
  `text` varchar(200) DEFAULT NULL,
  `plny_text` varchar(500) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`kod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `kancelar` (
  `id_c_kancelar` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_c_projekt_FK` int(10) unsigned DEFAULT NULL,
  `razeni` int(10) NOT NULL,
  `kod` char(20) CHARACTER SET utf8 NOT NULL DEFAULT '""',
  `text` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `plny_text` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `valid` tinyint(1) DEFAULT '1',
  `projekt_kod` char(20) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_c_kancelar`),
  KEY `in_id_c_projkekt` (`id_c_projekt_FK`),
  KEY `kod` (`kod`),
  KEY `projekt_kod_fk2` (`projekt_kod`),
  CONSTRAINT `projekt_kod_fk2` FOREIGN KEY (`projekt_kod`) REFERENCES `projekt` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `kurz_druh` (
  `druh` char(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`druh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `kurz_typ_kvalifikace` (
  `typ` char(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`typ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `kurz` (
  `id_s_kurz` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `razeni` int(11) NOT NULL DEFAULT '1',
  `projekt_kod` char(20) DEFAULT NULL,
  `kancelar_kod` char(20) DEFAULT NULL,
  `kurz_druh` varchar(20) DEFAULT NULL,
  `kurz_cislo` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `beh_cislo` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_lokace` varchar(5) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_zkratka` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_typ_kvalifikace` varchar(45) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_nazev` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_pracovni_cinnost` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_akreditace` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `kurz_obsah` varchar(3000) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `pocet_hodin` int(10) DEFAULT NULL,
  `pocet_hodin_distancne` int(10) DEFAULT NULL,
  `certifikat_kurz_rada_FK` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `pocet_hodin_praxe` int(10) DEFAULT NULL,
  `date_zacatek` date DEFAULT NULL,
  `date_konec` date DEFAULT NULL,
  `date_zaverecna_zkouska` date DEFAULT NULL,
  `dodavatel` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `info_cas_konani` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `info_misto_konani` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `info_lektor` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `harmonogram_filename` varchar(256) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_s_kurz`),
  KEY `c_kancelar_kod_idx` (`kancelar_kod`),
  KEY `certifikat_kurz_rada_ibfk_1_idx` (`certifikat_kurz_rada_FK`),
  KEY `projekt_kod_fk1` (`projekt_kod`),
  CONSTRAINT `projekt_kod_fk1` FOREIGN KEY (`projekt_kod`) REFERENCES `projekt` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
