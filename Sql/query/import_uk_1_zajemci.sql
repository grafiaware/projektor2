SET foreign_key_checks = 0;
INSERT INTO zajemce (`id_zajemce`, `cislo_zajemce`, `identifikator`, `znacka`, `id_c_projekt_FK`, `id_s_beh_projektu_FK`, `id_c_kancelar_FK`, updated, valid) 
    SELECT 
        `import_uk`.`id` AS `id`,
        `import_uk`.`cislo` AS `cislo`,
        `import_uk`.`identifikator` AS `identifikator`,
        `import_uk`.`znacka` AS `znacka`,
        `import_uk`.`id_projekt` AS `id_projekt`,
        `import_uk`.`beh` AS `beh`,
        `import_uk`.`id_kancelar` AS `id_kancelar`,
        0, 
        1
    FROM
        `import_uk`;
        
SET foreign_key_checks = 1;