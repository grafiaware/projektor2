/**
 * Author:  pes2704
 * Created: 18. 11. 2022
 */
    SELECT
        `s_kurz`.`id_s_kurz` AS `id_s_kurz`,
        `s_kurz`.`razeni` AS `razeni`,
        `s_kurz`.`projekt_kod` AS `projekt_kod`,
        `s_kurz`.`kancelar_kod` AS `kancelar_kod`,
        `s_kurz`.`kurz_druh` AS `kurz_druh`,
        `s_kurz`.`kurz_cislo` AS `kurz_cislo`,
        `s_kurz`.`beh_cislo` AS `beh_cislo`,
        `s_kurz`.`kurz_lokace` AS `kurz_lokace`,
        `s_kurz`.`kurz_zkratka` AS `kurz_zkratka`,
        `s_kurz`.`kurz_nazev` AS `kurz_nazev`,
        `s_kurz`.`kurz_pracovni_cinnost` AS `kurz_pracovni_cinnost`,
        `s_kurz`.`kurz_akreditace` AS `kurz_akreditace`,
--        `s_kurz`.`kurz_obsah` AS `kurz_obsah`,
        `s_kurz`.`pocet_hodin` AS `pocet_hodin`,
        `s_kurz`.`pocet_hodin_distancne` AS `pocet_hodin_distancne`,
        `s_kurz`.`certifikat_kurz_rada_FK` AS `certifikat_kurz_rada_FK`,
        `s_kurz`.`pocet_hodin_praxe` AS `pocet_hodin_praxe`,
        `s_kurz`.`date_zacatek` AS `date_zacatek`,
        `s_kurz`.`date_konec` AS `date_konec`,
        `s_kurz`.`dodavatel` AS `dodavatel`,
        `s_kurz`.`info_cas_konani` AS `info_cas_konani`,
        `s_kurz`.`info_misto_konani` AS `info_misto_konani`,
        `s_kurz`.`info_lektor` AS `info_lektor`,
        `s_kurz`.`harmonogram_filename` AS `harmonogram_filename`,
        `s_kurz`.`valid` AS `valid`
    FROM
        `s_kurz`
    WHERE
        (`s_kurz`.`kancelar_kod`={{kancelarKod}})
