/**
 * Author:  pes2704
 * Created: 19. 10. 2022
 */
ALTER TABLE `projektor_2_cjc`.`za_plan_kurz`
CHANGE COLUMN `text` `textQQQ` VARCHAR(120) CHARACTER SET 'utf8' COLLATE 'utf8_czech_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `datum_certif` `datum_certif` DATE NULL DEFAULT NULL ,
CHANGE COLUMN `datum_vytvor_dok_plan` `datum_zahajeni_real` DATE NULL DEFAULT NULL ,
CHANGE COLUMN `datum_upravy_dok_plan` `datum_dokonceni_real` DATE NULL DEFAULT NULL ;
