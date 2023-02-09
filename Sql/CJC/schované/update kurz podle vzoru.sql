/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 16. 12. 2022
 */

UPDATE
    projektor_2_cjc.s_kurz AS cil,
(
SELECT kurz_nazev, kurz_pracovni_cinnost, kurz_akreditace, kurz_obsah, pocet_hodin, pocet_hodin_distancne, pocet_hodin_praxe
FROM projektor_2_cjc.s_kurz
WHERE projekt_kod="CJC" AND kurz_cislo=43
) as vzor
SET
    cil.kurz_nazev=vzor.kurz_nazev,
    cil.kurz_pracovni_cinnost=vzor.kurz_pracovni_cinnost,
    cil.kurz_akreditace=vzor.kurz_akreditace,
    cil.kurz_obsah=vzor.kurz_obsah,
    cil.pocet_hodin=vzor.pocet_hodin,
    cil.pocet_hodin_distancne=vzor.pocet_hodin_distancne,
    cil.pocet_hodin_praxe=vzor.pocet_hodin_praxe

WHERE
projekt_kod="CJC"
AND kurz_zkratka="CJA2"
