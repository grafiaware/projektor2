/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 18. 7. 2025
 */
ALTER TABLE `projektor_2_cjc`.`s_kurz` 
ADD COLUMN `kurz_garant` VARCHAR(100) NULL DEFAULT NULL AFTER `kurz_obsah`;

