SET foreign_key_checks = 0;
INSERT INTO za_flat_table (`id_zajemce`, jmeno, prijmeni, datum_vytvor_dotazniku, B1) 
    SELECT 
        `import_uk`.`id` AS `id`,
        `import_uk`.`jmeno` AS `jmeno`,
        `import_uk`.`prijmeni` AS `prijmeni`,
        '2023-03-03' AS `datum_vytvor_dotazniku`,
		'import' AS `B1`
    FROM
        `import_uk`;
        
SET foreign_key_checks = 1;