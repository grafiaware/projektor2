CREATE TABLE `certifikat_kurz_verze` (
  `verze` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `popis` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`verze`),
  KEY `verze_idx` (`verze`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;