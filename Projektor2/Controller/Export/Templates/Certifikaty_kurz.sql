/**
 * Author:  pes2704
 * Created: 19. 11. 2022
 */

    SELECT
        `certifikat_kurz`.`identifikator` AS `identifikator`,
        `certifikat_kurz`.`filename` AS `filename`,
        `certifikat_kurz`.`date` AS `date`,
        `certifikat_kurz`.`creating_time` AS `creating_time`,
        `certifikat_kurz`.`creator` AS `creator`,
        `zajemce`.`identifikator` AS `identifikator_zajemce`,
        `zajemce`.`znacka` AS `znacka`,
        `c_projekt`.`kod` AS `projekt_kod`,
        `s_beh_projektu`.`beh_cislo` AS `beh`,
        `c_kancelar`.`kod` AS `kancelar_kod`,
        `za_flat_table`.`jmeno` AS `jmeno`,
        `za_flat_table`.`prijmeni` AS `prijmeni`,
        `s_kurz`.`kurz_nazev` AS `nazev_kurzu`,
        `s_kurz`.`date_zacatek` AS `date_zacatek`,
        `s_kurz`.`date_konec` AS `date_konec`
    FROM
        ((((((`certifikat_kurz`
        JOIN `zajemce` ON ((`certifikat_kurz`.`id_zajemce_FK` = `zajemce`.`id_zajemce`)))
        JOIN `za_flat_table` ON ((`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)))
        JOIN `s_kurz` ON ((`certifikat_kurz`.`id_s_kurz_FK` = `s_kurz`.`id_s_kurz`)))
        JOIN `c_projekt` ON ((`c_projekt`.`id_c_projekt` = `zajemce`.`id_c_projekt_FK`)))
        JOIN `c_kancelar` ON ((`c_kancelar`.`id_c_kancelar` = `zajemce`.`id_c_kancelar_FK`)))
        JOIN `s_beh_projektu` ON ((`s_beh_projektu`.`id_s_beh_projektu` = `zajemce`.`id_s_beh_projektu_FK`)))
    WHERE
        (`s_kurz`.`id_s_kurz` = {{idSKurz}})
    ORDER BY `certifikat_kurz`.`identifikator`