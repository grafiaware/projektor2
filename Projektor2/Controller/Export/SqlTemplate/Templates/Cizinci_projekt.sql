/**
 * Author:  pes2704
 * Created: 8. 10. 2022
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
        `za_flat_table`.`rodne_cislo` AS `rodne_cislo`,
        `za_flat_table`.`z_up` AS `z_up`,
        `za_flat_table`.`stav` AS `stav`,
        `za_flat_table`.`datum_vytvor_smlouvy` AS `datum_vytvor_smlouvy`,
        `za_cizinec_flat_table`.`searched_phone` AS `searched_phone`,
        `za_cizinec_flat_table`.`obec_pobytu` AS `obec_pobytu`,
        `za_cizinec_flat_table`.`obec_pro_kurz` AS `obec_pro_kurz`,
        `za_cizinec_flat_table`.`pozadavky_kurz` AS `pozadavky_kurz`,
        `za_cizinec_flat_table`.`faze` AS `faze`,
        `za_cizinec_flat_table`.`datum_reg_zadost_zajemce` AS `datum_reg_zadost_zajemce`,
        `za_cizinec_flat_table`.`datum_reg_zajemce` AS `datum_reg_zajemce`,
        `za_cizinec_flat_table`.`datum_reg_zadost_uchazec` AS `datum_reg_zadost_uchazec`,
        `za_cizinec_flat_table`.`datum_reg_uchazec` AS `datum_reg_uchazec`,
        `za_cizinec_flat_table`.`rk_zadost_1` AS `rk_zadost_1`,
        `za_cizinec_flat_table`.`rk_zadost_2` AS `rk_zadost_2`,
        `za_cizinec_flat_table`.`datum_rk_zadost_1` AS `datum_rk_zadost_1`,
        `za_cizinec_flat_table`.`datum_rk_zadost_2` AS `datum_rk_zadost_2`
    FROM
        (((((`zajemce`
        JOIN `c_kancelar` ON ((`zajemce`.`id_c_kancelar_FK` = `c_kancelar`.`id_c_kancelar`)))
        JOIN `s_beh_projektu` ON ((`zajemce`.`id_s_beh_projektu_FK` = `s_beh_projektu`.`id_s_beh_projektu`)))
        JOIN `c_projekt` ON ((`zajemce`.`id_c_projekt_FK` = `c_projekt`.`id_c_projekt`)))
        LEFT JOIN `za_flat_table` ON ((`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)))
        LEFT JOIN `za_cizinec_flat_table` ON ((`zajemce`.`id_zajemce` = `za_cizinec_flat_table`.`id_zajemce`)))
    WHERE
        (`zajemce`.`id_c_projekt_FK` = {{idProjekt}})
    ORDER BY `zajemce`.`id_s_beh_projektu_FK` , `zajemce`.`id_c_kancelar_FK` , `zajemce`.`znacka`