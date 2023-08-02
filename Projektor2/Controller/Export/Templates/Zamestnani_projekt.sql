/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 2. 8. 2023
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
        `za_zam_flat_table`.`zam_nove_misto` AS `zam_nove_misto`,
        `za_zam_flat_table`.`zam_supm` AS `zam_supm`,
        `za_zam_flat_table`.`zam_forma` AS `zam_forma`,
        `za_zam_flat_table`.`zam_datum_vstupu` AS `zam_datum_vstupu`,
        `za_zam_flat_table`.`zam_nazev` AS `zam_nazev`,
        `za_zam_flat_table`.`zam_mesto` AS `zam_mesto`,
        `za_zam_flat_table`.`zam_ulice` AS `zam_ulice`,
        `za_zam_flat_table`.`zam_psc` AS `zam_psc`,
        `za_zam_flat_table`.`zam_ic` AS `zam_ic`,
        `za_zam_flat_table`.`zam_navazujici_datum_vstupu` AS `zam_navazujici_datum_vstupu`,
        `za_zam_flat_table`.`zam_navazujici_nazev` AS `zam_navazujici_nazev`,
        `za_zam_flat_table`.`zam_navazujici_mesto` AS `zam_navazujici_mesto`,
        `za_zam_flat_table`.`zam_navazujici_ulice` AS `zam_navazujici_ulice`,
        `za_zam_flat_table`.`zam_navazujici_psc` AS `zam_navazujici_psc`,
        `za_zam_flat_table`.`zam_navazujici_ic` AS `zam_navazujici_ic`
    FROM
        (((((`zajemce`
        JOIN `c_kancelar` ON ((`zajemce`.`id_c_kancelar_FK` = `c_kancelar`.`id_c_kancelar`)))
        JOIN `s_beh_projektu` ON ((`zajemce`.`id_s_beh_projektu_FK` = `s_beh_projektu`.`id_s_beh_projektu`)))
        JOIN `c_projekt` ON ((`zajemce`.`id_c_projekt_FK` = `c_projekt`.`id_c_projekt`)))
        LEFT JOIN `za_flat_table` ON ((`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)))
        LEFT JOIN za_zam_flat_table ON ((`zajemce`.`id_zajemce` = `za_zam_flat_table`.`id_zajemce`)))
    WHERE
        (`zajemce`.`id_c_projekt_FK` = {{idProjekt}})
    ORDER BY `zajemce`.`id_s_beh_projektu_FK` , `zajemce`.`id_c_kancelar_FK` , `zajemce`.`znacka`