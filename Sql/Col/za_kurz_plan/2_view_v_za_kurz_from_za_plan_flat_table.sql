CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `v_za_kurz` AS
    SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_zztp_FK` AS `id_s_kurz_FK`,
        'ZZTP' AS `kurz_druh_fk`,
        'zztp' AS `aktivita`,
        `za_plan_flat_table_old_full`.`zztp_text` AS `text`,
        `za_plan_flat_table_old_full`.`zztp_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`zztp_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`zztp_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`zztp_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`zztp_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_zztp_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_kom_FK` AS `id_s_kurz_FK`,
        'KOM' AS `kurz_druh_fk`,
        'kom' AS `aktivita`,
        `za_plan_flat_table_old_full`.`kom_text` AS `text`,
        `za_plan_flat_table_old_full`.`kom_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`kom_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`kom_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`kom_duvod_neukonceni` AS `duvod_neukonceni`,
        '' AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_kom_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_mot_FK` AS `id_s_kurz_FK`,
        'MOT' AS `kurz_druh_fk`,
        'mot' AS `aktivita`,
        `za_plan_flat_table_old_full`.`mot_text` AS `text`,
        `za_plan_flat_table_old_full`.`mot_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`mot_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`mot_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`mot_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`mot_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_mot_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_fg_FK` AS `id_s_kurz_FK`,
        'FG' AS `kurz_druh_fk`,
        'fg' AS `aktivita`,
        `za_plan_flat_table_old_full`.`fg_text` AS `text`,
        `za_plan_flat_table_old_full`.`fg_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`fg_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`fg_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`fg_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`fg_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_fg_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_pc1_FK` AS `id_s_kurz_FK`,
        'PC' AS `kurz_druh_fk`,
        'pc1' AS `aktivita`,
        `za_plan_flat_table_old_full`.`pc1_text` AS `text`,
        `za_plan_flat_table_old_full`.`pc1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`pc1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`pc1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`pc1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`pc1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_pc1_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_pc2_FK` AS `id_s_kurz_FK`,
        'PC' AS `kurz_druh_fk`,
        'pc2' AS `aktivita`,
        `za_plan_flat_table_old_full`.`pc2_text` AS `text`,
        `za_plan_flat_table_old_full`.`pc2_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`pc2_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`pc2_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`pc2_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`pc2_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_pc2_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_bidi_FK` AS `id_s_kurz_FK`,
        'BIDI' AS `kurz_druh_fk`,
        'bidi' AS `aktivita`,
        `za_plan_flat_table_old_full`.`bidi_text` AS `text`,
        `za_plan_flat_table_old_full`.`bidi_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`bidi_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`bidi_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`bidi_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`bidi_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_bidi_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_prdi_FK` AS `id_s_kurz_FK`,
        'PRDI' AS `kurz_druh_fk`,
        'prdi' AS `aktivita`,
        `za_plan_flat_table_old_full`.`prdi_text` AS `text`,
        `za_plan_flat_table_old_full`.`prdi_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`prdi_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`prdi_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`prdi_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`prdi_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_prdi_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_praxe_FK` AS `id_s_kurz_FK`,
        'PRAXE' AS `kurz_druh_fk`,
        'praxe' AS `aktivita`,
        `za_plan_flat_table_old_full`.`praxe_text` AS `text`,
        `za_plan_flat_table_old_full`.`praxe_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`praxe_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`praxe_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`praxe_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`praxe_datum_ukonceni` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_praxe_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_prof1_FK` AS `id_s_kurz_FK`,
        'PROF' AS `kurz_druh_fk`,
        'prof1' AS `aktivita`,
        `za_plan_flat_table_old_full`.`prof1_text` AS `text`,
        `za_plan_flat_table_old_full`.`prof1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`prof1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`prof1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`prof1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`prof1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_prof1_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_prof2_FK` AS `id_s_kurz_FK`,
        'PROF' AS `kurz_druh_fk`,
        'prof2' AS `aktivita`,
        `za_plan_flat_table_old_full`.`prof2_text` AS `text`,
        `za_plan_flat_table_old_full`.`prof2_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`prof2_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`prof2_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`prof2_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`prof2_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_prof2_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_prof3_FK` AS `id_s_kurz_FK`,
        'PROF' AS `kurz_druh_fk`,
        'prof3' AS `aktivita`,
        `za_plan_flat_table_old_full`.`prof3_text` AS `text`,
        `za_plan_flat_table_old_full`.`prof3_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`prof3_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`prof3_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`prof3_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`prof3_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_prof3_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_prof4_FK` AS `id_s_kurz_FK`,
        'PROF' AS `kurz_druh_fk`,
        'prof4' AS `aktivita`,
        `za_plan_flat_table_old_full`.`prof4_text` AS `text`,
        `za_plan_flat_table_old_full`.`prof4_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`prof4_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`prof4_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`prof4_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`prof4_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_prof4_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_odb1_FK` AS `id_s_kurz_FK`,
        'ODB' AS `kurz_druh_fk`,
        'odb1' AS `aktivita`,
        `za_plan_flat_table_old_full`.`odb1_text` AS `text`,
        `za_plan_flat_table_old_full`.`odb1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`odb1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`odb1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`odb1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`odb1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_odb1_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_im_FK` AS `id_s_kurz_FK`,
        'IM' AS `kurz_druh_fk`,
        'im' AS `aktivita`,
        `za_plan_flat_table_old_full`.`im_text` AS `text`,
        `za_plan_flat_table_old_full`.`im_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`im_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`im_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`im_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`im_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_im_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_spp_FK` AS `id_s_kurz_FK`,
        'SPP' AS `kurz_druh_fk`,
        'spp' AS `aktivita`,
        `za_plan_flat_table_old_full`.`spp_text` AS `text`,
        `za_plan_flat_table_old_full`.`spp_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`spp_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`spp_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`spp_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`spp_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_spp_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_sebas_FK` AS `id_s_kurz_FK`,
        'SEBAS' AS `kurz_druh_fk`,
        'sebas' AS `aktivita`,
        `za_plan_flat_table_old_full`.`sebas_text` AS `text`,
        `za_plan_flat_table_old_full`.`sebas_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`sebas_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`sebas_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`sebas_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`sebas_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_sebas_FK` IS NOT NULL)
    UNION ALL SELECT
        `za_plan_flat_table_old_full`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table_old_full`.`id_s_kurz_forpr_FK` AS `id_s_kurz_FK`,
        'FORPR' AS `kurz_druh_fk`,
        'forpr' AS `aktivita`,
        `za_plan_flat_table_old_full`.`forpr_text` AS `text`,
        `za_plan_flat_table_old_full`.`forpr_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table_old_full`.`forpr_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table_old_full`.`forpr_dokonceno` AS `dokonceno`,
        `za_plan_flat_table_old_full`.`forpr_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table_old_full`.`forpr_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table_old_full`
    WHERE
        (`za_plan_flat_table_old_full`.`id_s_kurz_forpr_FK` IS NOT NULL)