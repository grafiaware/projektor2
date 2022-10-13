/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pes2704
 * Created: 25.2.2019
 */

-- prof4 není KEY
-- prof1 prof4 není FOREIGN KEY

-- ALTER TABLE za_plan_flat_table ADD KEY `id_prof4_FK` (`id_prof4_FK`);

-- ALTER TABLE za_plan_flat_table ADD CONSTRAINT `za_plan_flat_table_ibfk_22` FOREIGN KEY (`id_prof1_FK`) REFERENCES `s_kurz` (`id`);
-- ALTER TABLE za_plan_flat_table ADD CONSTRAINT `za_plan_flat_table_ibfk_23` FOREIGN KEY (`id_prof4_FK`) REFERENCES `s_kurz` (`id`);

-- a přidání dalšího typu:

ALTER TABLE za_plan_flat_table ADD COLUMN `id_odb1_FK` int(10) unsigned DEFAULT NULL AFTER prof4_datum_certif;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_text` varchar(120) COLLATE utf8_czech_ci DEFAULT NULL AFTER id_odb1_FK;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_poc_abs_hodin` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL AFTER odb1_text;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_duvod_absence` varchar(120) COLLATE utf8_czech_ci DEFAULT NULL AFTER odb1_poc_abs_hodin;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_dokonceno` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL AFTER odb1_duvod_absence;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_duvod_neukonceni` varchar(120) COLLATE utf8_czech_ci DEFAULT NULL AFTER odb1_dokonceno;
ALTER TABLE za_plan_flat_table ADD COLUMN `odb1_datum_certif` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL AFTER odb1_duvod_neukonceni;
ALTER TABLE za_plan_flat_table ADD KEY `id_odb1_FK` (`id_odb1_FK`);
ALTER TABLE za_plan_flat_table ADD CONSTRAINT `za_plan_flat_table_ibfk_24` FOREIGN KEY (`id_odb1_FK`) REFERENCES `s_kurz` (`id`);

