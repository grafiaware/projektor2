/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 1. 8. 2023
 */

/*
	kontrolní strom všech FT - zájemci s duplicitním příjmením a jménem
*/    
    
    SELECT 
        `zajemce`.`id_zajemce` AS `id_zajemce`,
        `zajemce`.`identifikator` AS `identifikator`,
        `zajemce`.`id_c_projekt_FK` AS `id_c_projekt_FK`,
        `zajemce`.`id_c_kancelar_FK` AS `id_c_kancelar_FK`,
        `zajemce`.`id_s_beh_projektu_FK` AS `id_s_beh_projektu_FK`,
        `zajemce`.`valid` AS `valid`,
        `za_flat_table`.id_za_flat_table AS `id_za_flat_table`,
        `za_flat_table`.jmeno AS `jmeno`,
        `za_flat_table`.`prijmeni` AS `prijmeni`,
        `za_cizinec_flat_table`.id_za_cizinec_flat_table AS id_za_cizinec_flat_table,
        `za_plan_flat_table`.id_za_plan_flat_table AS id_za_plan_flat_table,
        COUNT(`za_plan_kurz`.id_za_plan_kurz) AS COUNT_id_plan_kurz,
        `za_plan_poradenstvi`.id_za_plan_poradenstvi AS id_za_plan_poradenstvi,
        `za_ukonc_flat_table`.id_za_ukonc_flat_table AS id_za_ukonc_flat_table,
        COUNT(`za_upload`.id_zajemce_FK) AS COUNT_id_upload,
        `za_zam_flat_table`.id_za_zam_flat_table AS id_za_zam_flat_table
    FROM
        (`zajemce`
        LEFT JOIN za_cizinec_flat_table ON (`zajemce`.`id_zajemce` = `za_cizinec_flat_table`.`id_zajemce`)
        LEFT JOIN `za_flat_table` ON (`zajemce`.`id_zajemce` = `za_flat_table`.`id_zajemce`)
        LEFT JOIN za_plan_flat_table ON (`zajemce`.`id_zajemce` = `za_plan_flat_table`.`id_zajemce`)
        LEFT JOIN za_plan_kurz ON (`zajemce`.`id_zajemce` = `za_plan_kurz`.`id_zajemce`)
        LEFT JOIN za_plan_poradenstvi ON (`zajemce`.`id_zajemce` = `za_plan_poradenstvi`.`id_zajemce_FK`)
        LEFT JOIN za_ukonc_flat_table ON (`zajemce`.`id_zajemce` = `za_ukonc_flat_table`.`id_zajemce`)
        LEFT JOIN za_upload ON (`zajemce`.`id_zajemce` = `za_upload`.`id_zajemce_FK`)
        LEFT JOIN za_zam_flat_table ON (`zajemce`.`id_zajemce` = `za_zam_flat_table`.`id_zajemce`)
        
        
        )
WHERE 
 concat(`za_flat_table`.`prijmeni`, ' ',`za_flat_table`.`jmeno`)
 IN 
 (
 SELECT 
 concat(prijmeni, ' ',jmeno) AS fullname
 FROM 
 za_flat_table
 GROUP BY 
    fullname
--    mobilni_telefon
--    mail  
HAVING 
 count(*) > 1
 )        
 AND
 `zajemce`.`valid`=1
        GROUP BY `zajemce`.`id_zajemce`
		ORDER BY prijmeni, jmeno, identifikator ASC 