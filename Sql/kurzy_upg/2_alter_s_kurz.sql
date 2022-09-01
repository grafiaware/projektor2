/**
 * Author:  pes2704
 * Created: 1. 9. 2022
 */

ALTER TABLE `projektor_2`.`s_kurz`
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