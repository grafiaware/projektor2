/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 11. 10. 2023
 */

/**
 * INSERT
 */

INSERT INTO projekt SELECT `kod`, `razeni`, `text`, `plny_text`, `valid` FROM c_projekt;

INSERT INTO kancelar
    SELECT 
        `c_kancelar`.`id_c_kancelar` AS `id_c_kancelar`,
        `c_kancelar`.`id_c_projekt_FK` AS `id_c_projekt_FK`,
        `c_kancelar`.`razeni` AS `razeni`,
        `c_kancelar`.`kod` AS `kod`,
        `c_kancelar`.`text` AS `text`,
        `c_kancelar`.`plny_text` AS `plny_text`,
        `c_kancelar`.`valid` AS `valid`,
        `c_projekt`.`kod` AS `projekt_kod`
    FROM
        (`c_kancelar`
        JOIN `c_projekt` ON ((`c_kancelar`.`id_c_projekt_FK` = `c_projekt`.`id_c_projekt`)));

INSERT INTO kurz_druh 
SELECT DISTINCT kurz_druh FROM kurz;