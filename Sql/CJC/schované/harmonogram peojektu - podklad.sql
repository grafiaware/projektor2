/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 16. 12. 2022
 */

SELECT
projekt_kod,
kurz_druh,
                GROUP_CONCAT(DISTINCT kurz_nazev
                    ORDER BY kurz_nazev ASC
                    SEPARATOR ' / ') AS kurzy,
min(date_zacatek), max(date_konec),
min(concat_ws("/", year(date_zacatek), LPAD(month(date_zacatek), 2, '0'))) AS start,
max(concat_ws("/", year(date_konec), LPAD(month(date_konec), 2, '0'))) AS finish,
dodavatel,
                GROUP_CONCAT(DISTINCT dodavatel
                    ORDER BY dodavatel ASC
                    SEPARATOR ' / ') AS dodavatele
FROM
projektor_2_cjc.s_kurz

WHERE
projekt_kod="MB"
GROUP BY kurz_druh 