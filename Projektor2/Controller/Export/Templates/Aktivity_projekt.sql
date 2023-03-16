
/**
 * Author:  pes2704
 * Created: 15. 3. 2023
 */
    SELECT
        `c_projekt`.`text` AS `nazev_projektu`,
        `s_beh_projektu`.`text` AS `beh_projektu`,
        `c_kancelar`.`plny_text` AS `plny_text`,
        `za_flat_table`.`jmeno` AS `jmeno`,
        `za_flat_table`.`prijmeni` AS `prijmeni`,
        `za_plan_kurz`.`id_zajemce` AS `id_zajemce`,
        `za_plan_kurz`.`id_s_kurz_FK` AS `id_s_kurz_FK`,
        `za_plan_kurz`.`kurz_druh_fk` AS `kurz_druh_fk`,
        `za_plan_kurz`.`aktivita` AS `aktivita`,
        `za_plan_kurz`.`text` AS `text`,
        `za_plan_kurz`.`poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_kurz`.`duvod_absence` AS `duvod_absence`,
        `za_plan_kurz`.`dokonceno` AS `dokonceno`,
        `za_plan_kurz`.`duvod_neukonceni` AS `duvod_neukonceni`,
        IF((`za_plan_kurz`.`datum_certif` = ''),
            NULL,
            STR_TO_DATE(TRIM(`za_plan_kurz`.`datum_certif`),
                    '%d.%m.%Y')) AS `datum_certif`
    FROM
        (((((`zajemce`
        JOIN `c_kancelar` ON ((`zajemce`.`id_c_kancelar_FK` = `c_kancelar`.`id_c_kancelar`)))
        JOIN `s_beh_projektu` ON ((`zajemce`.`id_s_beh_projektu_FK` = `s_beh_projektu`.`id_s_beh_projektu`)))
        JOIN `c_projekt` ON ((`zajemce`.`id_c_projekt_FK` = `c_projekt`.`id_c_projekt`)))
        LEFT JOIN `za_flat_table` ON ((`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)))
        LEFT JOIN `za_plan_kurz` ON ((`zajemce`.`id_zajemce` = `za_plan_kurz`.`id_zajemce`)))
    WHERE
        (`zajemce`.`id_c_projekt_FK` = {{idProjekt}} AND `za_plan_kurz`.`id_s_kurz_FK` > 3)