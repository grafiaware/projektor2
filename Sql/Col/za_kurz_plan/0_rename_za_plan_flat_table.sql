/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pes2704
 * Created: 17. 11. 2021
 */

ALTER TABLE `za_plan_flat_table`
RENAME TO `za_plan_flat_table_old_full` ;

CREATE TABLE `za_plan_flat_table` (
  `id_za_plan_flat_table` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_zajemce` int(10) unsigned DEFAULT NULL,
  `datum_vytvor_dok_plan` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_upravy_dok_plan` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `B1` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_za_plan_flat_table`),
  KEY `za_plan_flat_table_ibfk_01` (`id_zajemce`),
  CONSTRAINT `za_plan_flat_table_ibfk_01` FOREIGN KEY (`id_zajemce`) REFERENCES `zajemce` (`id_zajemce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


INSERT INTO za_plan_flat_table
(
  `id_za_plan_flat_table`,`id_zajemce`,`datum_vytvor_dok_plan`,`datum_upravy_dok_plan`,`B1`
)
SELECT
  `id_za_plan_flat_table`,`id_zajemce`,`datum_vytvor_dok_plan`,`datum_upravy_dok_plan`,`B1`
FROM
  za_plan_flat_table_old_full