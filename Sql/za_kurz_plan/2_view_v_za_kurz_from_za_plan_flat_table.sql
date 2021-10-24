CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `v_za_kurz` AS
    SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_zztp_FK` AS `id_s_kurz_FK`,
        'zztp' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`zztp_text` AS `text`,
        `za_plan_flat_table`.`zztp_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`zztp_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`zztp_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`zztp_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`zztp_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_kom_FK` AS `id_s_kurz_FK`,
        'kom' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`kom_text` AS `text`,
        `za_plan_flat_table`.`kom_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`kom_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`kom_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`kom_duvod_neukonceni` AS `duvod_neukonceni`,
        '' AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_mot_FK` AS `id_s_kurz_FK`,
        'mot' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`mot_text` AS `text`,
        `za_plan_flat_table`.`mot_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`mot_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`mot_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`mot_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`mot_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_fg_FK` AS `id_s_kurz_FK`,
        'fg' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`fg_text` AS `text`,
        `za_plan_flat_table`.`fg_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`fg_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`fg_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`fg_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`fg_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_pc1_FK` AS `id_s_kurz_FK`,
        'pc' AS `kurz_typ_fk`,
        1 AS `poradi`,
        `za_plan_flat_table`.`pc1_text` AS `text`,
        `za_plan_flat_table`.`pc1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`pc1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`pc1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`pc1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`pc1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_pc2_FK` AS `id_s_kurz_FK`,
        'pc' AS `kurz_typ_fk`,
        2 AS `poradi`,
        `za_plan_flat_table`.`pc2_text` AS `text`,
        `za_plan_flat_table`.`pc2_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`pc2_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`pc2_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`pc2_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`pc2_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_bidi_FK` AS `id_s_kurz_FK`,
        'bidi' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`bidi_text` AS `text`,
        `za_plan_flat_table`.`bidi_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`bidi_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`bidi_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`bidi_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`bidi_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_prdi_FK` AS `id_s_kurz_FK`,
        'prdi' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`prdi_text` AS `text`,
        `za_plan_flat_table`.`prdi_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`prdi_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`prdi_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`prdi_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`prdi_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_praxe_FK` AS `id_s_kurz_FK`,
        'praxe' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`praxe_text` AS `text`,
        `za_plan_flat_table`.`praxe_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`praxe_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`praxe_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`praxe_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`praxe_datum_ukonceni` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_prof1_FK` AS `id_s_kurz_FK`,
        'prof' AS `kurz_typ_fk`,
        1 AS `poradi`,
        `za_plan_flat_table`.`prof1_text` AS `text`,
        `za_plan_flat_table`.`prof1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`prof1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`prof1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`prof1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`prof1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_prof2_FK` AS `id_s_kurz_FK`,
        'prof' AS `kurz_typ_fk`,
        2 AS `poradi`,
        `za_plan_flat_table`.`prof2_text` AS `text`,
        `za_plan_flat_table`.`prof2_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`prof2_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`prof2_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`prof2_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`prof2_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_prof3_FK` AS `id_s_kurz_FK`,
        'prof' AS `kurz_typ_fk`,
        3 AS `poradi`,
        `za_plan_flat_table`.`prof3_text` AS `text`,
        `za_plan_flat_table`.`prof3_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`prof3_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`prof3_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`prof3_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`prof3_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_prof4_FK` AS `id_s_kurz_FK`,
        'prof' AS `kurz_typ_fk`,
        4 AS `poradi`,
        `za_plan_flat_table`.`prof4_text` AS `text`,
        `za_plan_flat_table`.`prof4_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`prof4_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`prof4_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`prof4_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`prof4_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_odb1_FK` AS `id_s_kurz_FK`,
        'odb' AS `kurz_typ_fk`,
        1 AS `poradi`,
        `za_plan_flat_table`.`odb1_text` AS `text`,
        `za_plan_flat_table`.`odb1_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`odb1_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`odb1_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`odb1_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`odb1_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_im_FK` AS `id_s_kurz_FK`,
        'im' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`im_text` AS `text`,
        `za_plan_flat_table`.`im_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`im_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`im_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`im_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`im_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_spp_FK` AS `id_s_kurz_FK`,
        'spp' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`spp_text` AS `text`,
        `za_plan_flat_table`.`spp_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`spp_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`spp_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`spp_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`spp_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_sebas_FK` AS `id_s_kurz_FK`,
        'sebas' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`sebas_text` AS `text`,
        `za_plan_flat_table`.`sebas_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`sebas_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`sebas_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`sebas_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`sebas_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`
    UNION ALL SELECT
        `za_plan_flat_table`.`id_zajemce` AS `id_zajemce`,
        `za_plan_flat_table`.`id_s_kurz_forpr_FK` AS `id_s_kurz_FK`,
        'forpr' AS `kurz_typ_fk`,
        NULL AS `poradi`,
        `za_plan_flat_table`.`forpr_text` AS `text`,
        `za_plan_flat_table`.`forpr_poc_abs_hodin` AS `poc_abs_hodin`,
        `za_plan_flat_table`.`forpr_duvod_absence` AS `duvod_absence`,
        `za_plan_flat_table`.`forpr_dokonceno` AS `dokonceno`,
        `za_plan_flat_table`.`forpr_duvod_neukonceni` AS `duvod_neukonceni`,
        `za_plan_flat_table`.`forpr_datum_certif` AS `datum_certif`
    FROM
        `za_plan_flat_table`