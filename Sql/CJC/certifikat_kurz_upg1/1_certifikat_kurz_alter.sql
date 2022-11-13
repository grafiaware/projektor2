/*
 * přidán sloupec pro verzi (bez constraint a non null)
 */
ALTER TABLE `projektor_2_cjc`.`certifikat_kurz`
ADD COLUMN `certifikat_kurz_cerze_FK` VARCHAR(20) NULL AFTER `db_host`;
-- a oprava
ALTER TABLE `projektor_2_cjc`.`certifikat_kurz`
CHANGE COLUMN `certifikat_kurz_cerze_FK` `certifikat_kurz_verze_FK` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_czech_ci' NULL DEFAULT NULL AFTER `certifikat_kurz_rada_FK`;

/*
 * hodnoty sloupce pro verzi
 */
UPDATE `projektor_2_cjc`.`certifikat_kurz`
SET `certifikat_kurz_verze_FK` = 'original'
WHERE certifikat_kurz_rada_FK='PR';

UPDATE `projektor_2_cjc`.`certifikat_kurz`
SET `certifikat_kurz_verze_FK` = 'monitoring'
WHERE certifikat_kurz_rada_FK='MO';

/*
 * hodnoty do certifikat_kurz_verze
 */
INSERT INTO `projektor_2_cjc`.`certifikat_kurz_verze`
(`verze`,
`popis`)
VALUES
('original',
'originál certifikátu Grafia');
INSERT INTO `projektor_2_cjc`.`certifikat_kurz_verze`
(`verze`,
`popis`)
VALUES
('monitoring',
'verze certifikátu pro monitoring');
INSERT INTO `projektor_2_cjc`.`certifikat_kurz_verze`
(`verze`,
`popis`)
VALUES
('pseudokopie',
'pseudokopie certifikátu Grafia - s naskenovaným podpisem');

/*
 * nastaveno not null a constaint
 */
ALTER TABLE `projektor_2_cjc`.`certifikat_kurz`
CHANGE COLUMN `certifikat_kurz_verze_FK` `certifikat_kurz_verze_FK` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_czech_ci' NOT NULL ,
ADD INDEX `certifikat_kurz_ibfk_4_idx` (`certifikat_kurz_verze_FK` ASC);
ALTER TABLE `projektor_2_cjc`.`certifikat_kurz`
ADD CONSTRAINT `certifikat_kurz_ibfk_4`
  FOREIGN KEY (`certifikat_kurz_verze_FK`)
  REFERENCES `projektor_2_cjc`.`certifikat_kurz_verze` (`verze`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

/*
 * přidán unique klíč - kandidát na PRIMARY
 */
ALTER TABLE `projektor_2_cjc`.`certifikat_kurz`
ADD UNIQUE INDEX `certifikat_kurz_unique` (`id_zajemce_FK` ASC, `id_s_kurz_FK` ASC, `certifikat_kurz_rada_FK` ASC, `certifikat_kurz_verze_FK` ASC);
