/**
 * Author:  pes2704
 * Created: 19. 10. 2022
 */

-- transformace sloupce s českými datumy na slouec date

-- přidal jsem sloupec datum_certif_date - typu date, do něho pak update
ALTER TABLE `projektor_2_cjc`.`za_plan_kurz`
ADD COLUMN `datum_certif_date` DATE NULL DEFAULT NULL AFTER `datum_upravy_dok_plan`;

-- prázdné řetězce na NULL, varchar s formátem datumů s tečkami na typ date
UPDATE za_plan_kurz AS new
INNER JOIN
(
SELECT
id_za_plan_kurz,
if(datum_certif='', NULL,
	STR_TO_DATE(trim(datum_certif), '%d.%m.%Y')) AS trans_datum_certif FROM za_plan_kurz
) as trans
ON new.id_za_plan_kurz=trans.id_za_plan_kurz
SET new.datum_certif_date=trans.trans_datum_certif

-- pak jsem smazal datum_certif a přejmenoval datum_certif_date na datum_certif


-- za flat_table
INNER JOIN
(
SELECT
id_za_flat_table,
if(datum_reg='', NULL, STR_TO_DATE(trim(datum_reg), '%d.%m.%Y')) AS trans_datum_reg,
if(datum_narozeni='', NULL, STR_TO_DATE(trim(datum_narozeni), '%d.%m.%Y')) AS trans_datum_narozeni,
if(datum_vytvor_smlouvy='', NULL, STR_TO_DATE(trim(datum_vytvor_smlouvy), '%d.%m.%Y')) AS trans_datum_vytvor_smlouvy,
if(datum_vytvor_dotazniku='', NULL, STR_TO_DATE(trim(datum_vytvor_dotazniku), '%d.%m.%Y')) AS trans_datum_vytvor_dotazniku
 FROM za_flat_table
) as trans
ON new.id_za_flat_table=trans.id_za_flat_table
SET new.datum_reg_date=trans.trans_datum_reg,
 new.datum_narozeni_date=trans.trans_datum_narozeni,
 new.datum_vytvor_smlouvy_date=trans.trans_datum_vytvor_smlouvy,
 new.datum_vytvor_dotazniku_date=trans.trans_datum_vytvor_dotazniku