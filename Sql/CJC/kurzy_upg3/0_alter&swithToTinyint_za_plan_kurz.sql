/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 31. 10. 2022
 */

ALTER TABLE `projektor_2_cjc`.`za_plan_kurz`
ADD COLUMN `zahajeno` TINYINT(2) NULL DEFAULT NULL AFTER `text`,
ADD COLUMN `dokonceno2` TINYINT(1) NULL DEFAULT NULL AFTER `dokonceno`;


-- Ano ->1, Ne->0, prázdné->NULL, NULL zůstanou NULL
UPDATE `projektor_2_cjc`.`za_plan_kurz` SET `dokonceno2` = if(dokonceno="Ano", 1, if(dokonceno="Ne", 0, NULL));

ALTER TABLE `projektor_2_cjc`.`za_plan_kurz`
DROP COLUMN `dokonceno`;

ALTER TABLE `projektor_2_cjc`.`za_plan_kurz`
CHANGE COLUMN `dokonceno2` `dokonceno` TINYINT(1) NULL DEFAULT NULL ;
