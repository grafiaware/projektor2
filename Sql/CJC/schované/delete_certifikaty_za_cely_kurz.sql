/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 16. 12. 2022
 */

DELETE FROM projektor_2_cjc.certifikat_kurz
WHERE certifikat_kurz.id_zajemce_FK IN
(
SELECT * FROM
(
SELECT id_zajemce_FK
FROM
projektor_2_cjc.certifikat_kurz
WHERE
certifikat_kurz.id_s_kurz_FK=1668
)
AS c
)