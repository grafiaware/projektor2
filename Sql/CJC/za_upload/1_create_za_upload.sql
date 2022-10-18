CREATE TABLE `za_upload` (
  `id_zajemce_FK` int(11) unsigned NOT NULL,
  `id_upload_type_FK` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `filename` varchar(256) COLLATE utf8_czech_ci DEFAULT NULL,
  `creating_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creator` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `service` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `db_host` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_zajemce_FK`,`id_upload_type_FK`),
  KEY `upload_fk_1` (`id_zajemce_FK`),
  KEY `upload_fk_2` (`id_upload_type_FK`),
  CONSTRAINT `upload_ibfk_2` FOREIGN KEY (`id_upload_type_FK`) REFERENCES `za_upload_type` (`type`) ON UPDATE CASCADE,
  CONSTRAINT `za_upload_ibfk_1` FOREIGN KEY (`id_zajemce_FK`) REFERENCES `zajemce` (`id_zajemce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
