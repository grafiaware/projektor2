CREATE TABLE `za_cizinec_flat_table` (
  `id_za_cizinec_flat_table` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_zajemce` int(10) unsigned DEFAULT NULL,
  `datum_reg_zajemce` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_reg_uchazec` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `titul` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `titul_za` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `jmeno` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `pohlavi` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_narozeni` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `rodne_cislo` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `z_up` varchar(40) COLLATE utf8_czech_ci DEFAULT NULL,
  `prac_up` varchar(40) COLLATE utf8_czech_ci DEFAULT NULL,
  `stav` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `zam_osvc_neaktivni` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_poradenstvi_zacatek` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `mesto` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `ulice` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `psc` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `mesto2` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `ulice2` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `psc2` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `mobilni_telefon` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `dalsi_telefon` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `popis_telefon` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `pozadavky_kurz` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_vytvor_smlouvy` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_vytvor_dotazniku` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `B1` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_za_cizinec_flat_table`),
  KEY `fk_id_zajemce` (`id_zajemce`),
  CONSTRAINT `za_cizinec_flat_table_ibfk_1` FOREIGN KEY (`id_zajemce`) REFERENCES `zajemce` (`id_zajemce`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='InnoDB free: 9216 kB';