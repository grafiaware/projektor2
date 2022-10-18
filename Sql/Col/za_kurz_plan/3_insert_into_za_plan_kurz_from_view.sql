/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pes2704
 * Created: 13. 10. 2021
 */

INSERT INTO za_plan_kurz
(
  `id_zajemce`,`id_s_kurz_FK`,`kurz_druh_fk`,`aktivita`,`text`,`poc_abs_hodin`,`duvod_absence`,`dokonceno`,`duvod_neukonceni`,`datum_certif`
)

SELECT
  `id_zajemce`,`id_s_kurz_FK`,`kurz_druh_fk`,`aktivita`,`text`,`poc_abs_hodin`,`duvod_absence`,`dokonceno`,`duvod_neukonceni`,`datum_certif`
FROM
  v_za_kurz

