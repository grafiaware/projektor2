/**
 * Author:  pes2704
 * Created: 6. 10. 2022
 */

    SELECT
        `zajemce`.`id_zajemce` AS `id_zajemce`,
        `zajemce`.`cislo_zajemce` AS `cislo_zajemce`,
        `zajemce`.`identifikator` AS `identifikator`,
        `zajemce`.`znacka` AS `znacka`,
        `c_projekt`.`kod` AS `kod_projektu`,
        `c_projekt`.`text` AS `nazev_projektu`,
        `s_beh_projektu`.`text` AS `beh_projektu`,
        `c_kancelar`.`plny_text` AS `plny_text`,
        `za_flat_table`.`prijmeni` AS `prijmeni`,
        `za_flat_table`.`jmeno` AS `jmeno`,
        `za_flat_table`.`titul` AS `titul`,
        `za_flat_table`.`datum_narozeni` AS `datum_narozeni`,
        `za_flat_table`.`ulice` AS `ulice`,
        `za_flat_table`.`mesto` AS `mesto`,
        `za_flat_table`.`ulice2` AS `ulice2`,
        `za_flat_table`.`mesto2` AS `mesto2`,
        `za_flat_table`.`z_up` AS `z_up`,
        `za_flat_table`.`stav` AS `stav`,
        `za_flat_table`.`datum_vytvor_smlouvy` AS `datum_vytvor_smlouvy`
    FROM
        ((((`zajemce`
        JOIN `c_kancelar` ON ((`zajemce`.`id_c_kancelar_FK` = `c_kancelar`.`id_c_kancelar`)))
        JOIN `s_beh_projektu` ON ((`zajemce`.`id_s_beh_projektu_FK` = `s_beh_projektu`.`id_s_beh_projektu`)))
        JOIN `c_projekt` ON ((`zajemce`.`id_c_projekt_FK` = `c_projekt`.`id_c_projekt`)))
        LEFT JOIN `za_flat_table` ON ((`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)))
    WHERE
        (`zajemce`.`id_c_projekt_FK` = {{idProjekt}})
    ORDER BY `zajemce`.`id_s_beh_projektu_FK` , `zajemce`.`id_c_kancelar_FK` , `zajemce`.`znacka`