
/**
 * Author:  pes2704
 * Created: 4. 12. 2022
 */

/**
 * 
 * údaj potřebný pro certifikát akreditovaných kurzů
 */

ALTER TABLE `projektor_2_cjc`.`za_flat_table`
ADD COLUMN `misto_narozeni` VARCHAR(50) NULL DEFAULT NULL AFTER `datum_narozeni`;
