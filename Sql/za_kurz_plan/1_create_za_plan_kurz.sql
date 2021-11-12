/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pes2704
 * Created: 14. 10. 2021
 */

CREATE TABLE `za_plan_kurz` (
  `id_za_plan_kurz` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_zajemce` int(10) unsigned DEFAULT NULL,
  `id_s_kurz_FK` int(10) unsigned DEFAULT NULL,
  `kurz_druh_fk` varchar(45) DEFAULT NULL,
  `aktivita` varchar(45) DEFAULT NULL,
  `text` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `poc_abs_hodin` varchar(10) DEFAULT NULL,
  `duvod_absence` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `dokonceno` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `duvod_neukonceni` varchar(120) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_certif` varchar(20) DEFAULT NULL,
  `datum_vytvor_dok_plan` varchar(20) DEFAULT NULL,
  `datum_upravy_dok_plan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_za_plan_kurz`),
  KEY `id_s_kurz_FK` (`id_s_kurz_FK`),
  KEY `za_plan_kurz_fk1` (`id_zajemce`),
  CONSTRAINT `za_plan_kurz_fk1` FOREIGN KEY (`id_zajemce`) REFERENCES `zajemce` (`id_zajemce`),
  CONSTRAINT `za_plan_kurz_fk2` FOREIGN KEY (`id_s_kurz_FK`) REFERENCES `s_kurz` (`id_s_kurz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
