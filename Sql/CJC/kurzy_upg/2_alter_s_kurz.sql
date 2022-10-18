/**
 * Author:  pes2704
 * Created: 1. 9. 2022
 */

ALTER TABLE `s_kurz`
ADD INDEX `c_projekt_kod_idx` (`projekt_kod` ASC),
ADD INDEX `c_kancelar_kod_idx` (`kancelar_kod` ASC);
ALTER TABLE `projektor_2`.`s_kurz`
ADD CONSTRAINT `c_projekt_kod`
  FOREIGN KEY (`projekt_kod`)
  REFERENCES `projektor_2`.`c_projekt` (`kod`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `c_kancelar_kod`
  FOREIGN KEY (`kancelar_kod`)
  REFERENCES `projektor_2`.`c_kancelar` (`kod`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `s_kurz`
CHANGE COLUMN `kurz_obsah` `kurz_obsah` VARCHAR(3000) CHARACTER SET 'utf8' COLLATE 'utf8_czech_ci' NULL DEFAULT NULL ;

ALTER TABLE `s_kurz`
ADD COLUMN `kurz_pracovni_cinnost` VARCHAR(120) NULL DEFAULT NULL AFTER `kurz_nazev`,
ADD COLUMN `kurz_akreditace` VARCHAR(120) NULL DEFAULT NULL AFTER `kurz_pracovni_cinnost`,
ADD COLUMN `pocet_hodin_distancne` INT(10) NULL DEFAULT NULL AFTER `pocet_hodin`,
ADD COLUMN `pocet_hodin_praxe` INT(10) NULL DEFAULT NULL AFTER `pocet_hodin_distancne`;
