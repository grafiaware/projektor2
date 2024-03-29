/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pes2704
 * Created: 1. 8. 2023
 */

    SELECT 
        min(`za_flat_table`.`id_za_flat_table`) AS `min_id_za_flat_table`,
        min(`za_flat_table`.`id_zajemce`) AS `min_id_zajemce`,
        concat(prijmeni, ' ',jmeno) AS prijmeni_jmeno,
        count(`za_flat_table`.`titul`) AS `titul`,
        count(`za_flat_table`.`titul_za`) AS `titul_za`,
        count(`za_flat_table`.`jmeno`) AS `jmeno`,
        count(`za_flat_table`.`prijmeni`) AS `prijmeni`,
        count(`za_flat_table`.`pohlavi`) AS `pohlavi`,
        count(`za_flat_table`.`rodne_cislo`) AS `rodne_cislo`,
        count(`za_flat_table`.`z_up`) AS `z_up`,
        count(`za_flat_table`.`prac_up`) AS `prac_up`,
        count(`za_flat_table`.`stav`) AS `stav`,
        count(`za_flat_table`.`zam_osvc_neaktivni`) AS `zam_osvc_neaktivni`,
        count(`za_flat_table`.`datum_poradenstvi_zacatek`) AS `datum_poradenstvi_zacatek`,
        count(`za_flat_table`.`mesto`) AS `mesto`,
        count(`za_flat_table`.`ulice`) AS `ulice`,
        count(`za_flat_table`.`psc`) AS `psc`,
        count(`za_flat_table`.`pevny_telefon`) AS `pevny_telefon`,
        count(`za_flat_table`.`mesto2`) AS `mesto2`,
        count(`za_flat_table`.`ulice2`) AS `ulice2`,
        count(`za_flat_table`.`psc2`) AS `psc2`,
        count(`za_flat_table`.`pevny_telefon2`) AS `pevny_telefon2`,
        count(`za_flat_table`.`mobilni_telefon`) AS `mobilni_telefon`,
        count(`za_flat_table`.`dalsi_telefon`) AS `dalsi_telefon`,
        count(`za_flat_table`.`popis_telefon`) AS `popis_telefon`,
        count(`za_flat_table`.`mail`) AS `mail`,
        count(`za_flat_table`.`nazev_skoly1`) AS `nazev_skoly1`,
        count(`za_flat_table`.`obor1`) AS `obor1`,
        count(`za_flat_table`.`rok_ukonceni_studia1`) AS `rok_ukonceni_studia1`,
        count(`za_flat_table`.`vzdelani1`) AS `vzdelani1`,
        count(`za_flat_table`.`zaverecna_zkouska1`) AS `zaverecna_zkouska1`,
        count(`za_flat_table`.`popis1`) AS `popis1`,
        count(`za_flat_table`.`dolozeno1`) AS `dolozeno1`,
        count(`za_flat_table`.`nazev_skoly2`) AS `nazev_skoly2`,
        count(`za_flat_table`.`obor2`) AS `obor2`,
        count(`za_flat_table`.`rok_ukonceni_studia2`) AS `rok_ukonceni_studia2`,
        count(`za_flat_table`.`vzdelani2`) AS `vzdelani2`,
        count(`za_flat_table`.`zaverecna_zkouska2`) AS `zaverecna_zkouska2`,
        count(`za_flat_table`.`popis2`) AS `popis2`,
        count(`za_flat_table`.`dolozeno2`) AS `dolozeno2`,
        count(`za_flat_table`.`nazev_skoly3`) AS `nazev_skoly3`,
        count(`za_flat_table`.`obor3`) AS `obor3`,
        count(`za_flat_table`.`rok_ukonceni_studia3`) AS `rok_ukonceni_studia3`,
        count(`za_flat_table`.`vzdelani3`) AS `vzdelani3`,
        count(`za_flat_table`.`zaverecna_zkouska3`) AS `zaverecna_zkouska3`,
        count(`za_flat_table`.`popis3`) AS `popis3`,
        count(`za_flat_table`.`dolozeno3`) AS `dolozeno3`,
        count(`za_flat_table`.`nazev_skoly4`) AS `nazev_skoly4`,
        count(`za_flat_table`.`obor4`) AS `obor4`,
        count(`za_flat_table`.`rok_ukonceni_studia4`) AS `rok_ukonceni_studia4`,
        count(`za_flat_table`.`vzdelani4`) AS `vzdelani4`,
        count(`za_flat_table`.`zaverecna_zkouska4`) AS `zaverecna_zkouska4`,
        count(`za_flat_table`.`popis4`) AS `popis4`,
        count(`za_flat_table`.`dolozeno4`) AS `dolozeno4`,
        count(`za_flat_table`.`nazev_skoly5`) AS `nazev_skoly5`,
        count(`za_flat_table`.`obor5`) AS `obor5`,
        count(`za_flat_table`.`rok_ukonceni_studia5`) AS `rok_ukonceni_studia5`,
        count(`za_flat_table`.`vzdelani5`) AS `vzdelani5`,
        count(`za_flat_table`.`zaverecna_zkouska5`) AS `zaverecna_zkouska5`,
        count(`za_flat_table`.`popis5`) AS `popis5`,
        count(`za_flat_table`.`dolozeno5`) AS `dolozeno5`,
        count(`za_flat_table`.`nazev_skoleni1`) AS `nazev_skoleni1`,
        count(`za_flat_table`.`popis_skoleni1`) AS `popis_skoleni1`,
        count(`za_flat_table`.`rok_ukonceni1`) AS `rok_ukonceni1`,
        count(`za_flat_table`.`doba_skoleni1`) AS `doba_skoleni1`,
        count(`za_flat_table`.`popis_dokladu1`) AS `popis_dokladu1`,
        count(`za_flat_table`.`hrazeno1`) AS `hrazeno1`,
        count(`za_flat_table`.`dolozeno_skoleni1`) AS `dolozeno_skoleni1`,
        count(`za_flat_table`.`nazev_skoleni2`) AS `nazev_skoleni2`,
        count(`za_flat_table`.`popis_skoleni2`) AS `popis_skoleni2`,
        count(`za_flat_table`.`rok_ukonceni2`) AS `rok_ukonceni2`,
        count(`za_flat_table`.`doba_skoleni2`) AS `doba_skoleni2`,
        count(`za_flat_table`.`popis_dokladu2`) AS `popis_dokladu2`,
        count(`za_flat_table`.`hrazeno2`) AS `hrazeno2`,
        count(`za_flat_table`.`dolozeno_skoleni2`) AS `dolozeno_skoleni2`,
        count(`za_flat_table`.`nazev_skoleni3`) AS `nazev_skoleni3`,
        count(`za_flat_table`.`popis_skoleni3`) AS `popis_skoleni3`,
        count(`za_flat_table`.`rok_ukonceni3`) AS `rok_ukonceni3`,
        count(`za_flat_table`.`doba_skoleni3`) AS `doba_skoleni3`,
        count(`za_flat_table`.`popis_dokladu3`) AS `popis_dokladu3`,
        count(`za_flat_table`.`hrazeno3`) AS `hrazeno3`,
        count(`za_flat_table`.`dolozeno_skoleni3`) AS `dolozeno_skoleni3`,
        count(`za_flat_table`.`nazev_skoleni4`) AS `nazev_skoleni4`,
        count(`za_flat_table`.`popis_skoleni4`) AS `popis_skoleni4`,
        count(`za_flat_table`.`rok_ukonceni4`) AS `rok_ukonceni4`,
        count(`za_flat_table`.`doba_skoleni4`) AS `doba_skoleni4`,
        count(`za_flat_table`.`popis_dokladu4`) AS `popis_dokladu4`,
        count(`za_flat_table`.`hrazeno4`) AS `hrazeno4`,
        count(`za_flat_table`.`dolozeno_skoleni4`) AS `dolozeno_skoleni4`,
        count(`za_flat_table`.`nazev_skoleni5`) AS `nazev_skoleni5`,
        count(`za_flat_table`.`popis_skoleni5`) AS `popis_skoleni5`,
        count(`za_flat_table`.`rok_ukonceni5`) AS `rok_ukonceni5`,
        count(`za_flat_table`.`doba_skoleni5`) AS `doba_skoleni5`,
        count(`za_flat_table`.`popis_dokladu5`) AS `popis_dokladu5`,
        count(`za_flat_table`.`hrazeno5`) AS `hrazeno5`,
        count(`za_flat_table`.`dolozeno_skoleni5`) AS `dolozeno_skoleni5`,
        count(`za_flat_table`.`specializace_v_praxi`) AS `specializace_v_praxi`,
        count(`za_flat_table`.`aj_uroven`) AS `aj_uroven`,
        count(`za_flat_table`.`aj_schopnosti`) AS `aj_schopnosti`,
        count(`za_flat_table`.`nj_uroven`) AS `nj_uroven`,
        count(`za_flat_table`.`nj_schopnosti`) AS `nj_schopnosti`,
        count(`za_flat_table`.`rj_uroven`) AS `rj_uroven`,
        count(`za_flat_table`.`rj_schopnosti`) AS `rj_schopnosti`,
        count(`za_flat_table`.`dalsi_jazyk1_jmeno`) AS `dalsi_jazyk1_jmeno`,
        count(`za_flat_table`.`dalsi_jazyk1_jmeno_uroven`) AS `dalsi_jazyk1_jmeno_uroven`,
        count(`za_flat_table`.`dalsi_jazyk1_schopnosti`) AS `dalsi_jazyk1_schopnosti`,
        count(`za_flat_table`.`dalsi_jazyk2_jmeno`) AS `dalsi_jazyk2_jmeno`,
        count(`za_flat_table`.`dalsi_jazyk2_jmeno_uroven`) AS `dalsi_jazyk2_jmeno_uroven`,
        count(`za_flat_table`.`dalsi_jazyk2_schopnosti`) AS `dalsi_jazyk2_schopnosti`,
        count(`za_flat_table`.`pc_office_uroven`) AS `pc_office_uroven`,
        count(`za_flat_table`.`PC_ERP`) AS `PC_ERP`,
        count(`za_flat_table`.`PC_ERP_nazev`) AS `PC_ERP_nazev`,
        count(`za_flat_table`.`PC_CAD`) AS `PC_CAD`,
        count(`za_flat_table`.`PC_CAD_nazev`) AS `PC_CAD_nazev`,
        count(`za_flat_table`.`PC_GRA`) AS `PC_GRA`,
        count(`za_flat_table`.`PC_GRA_nazev`) AS `PC_GRA_nazev`,
        count(`za_flat_table`.`PC_IT`) AS `PC_IT`,
        count(`za_flat_table`.`PC_popis`) AS `PC_popis`,
        count(`za_flat_table`.`ridic_sk1`) AS `ridic_sk1`,
        count(`za_flat_table`.`ridic_sk2`) AS `ridic_sk2`,
        count(`za_flat_table`.`ridic_sk3`) AS `ridic_sk3`,
        count(`za_flat_table`.`ridic_sk4`) AS `ridic_sk4`,
        count(`za_flat_table`.`ridic_rok1`) AS `ridic_rok1`,
        count(`za_flat_table`.`ridic_rok2`) AS `ridic_rok2`,
        count(`za_flat_table`.`ridic_rok3`) AS `ridic_rok3`,
        count(`za_flat_table`.`ridic_rok4`) AS `ridic_rok4`,
        count(`za_flat_table`.`zamestnani_od1`) AS `zamestnani_od1`,
        count(`za_flat_table`.`zamestnani_do1`) AS `zamestnani_do1`,
        count(`za_flat_table`.`zamestnani_zamestnavatel1`) AS `zamestnani_zamestnavatel1`,
        count(`za_flat_table`.`zamestnani_pozice1`) AS `zamestnani_pozice1`,
        count(`za_flat_table`.`zamestnani_popis1`) AS `zamestnani_popis1`,
        count(`za_flat_table`.`kzam`) AS `kzam`,
        count(`za_flat_table`.`KZAM_cislo1`) AS `KZAM_cislo1`,
        count(`za_flat_table`.`zamestnani_od2`) AS `zamestnani_od2`,
        count(`za_flat_table`.`zamestnani_do2`) AS `zamestnani_do2`,
        count(`za_flat_table`.`zamestnani_zamestnavatel2`) AS `zamestnani_zamestnavatel2`,
        count(`za_flat_table`.`zamestnani_pozice2`) AS `zamestnani_pozice2`,
        count(`za_flat_table`.`zamestnani_popis2`) AS `zamestnani_popis2`,
        count(`za_flat_table`.`KZAM_cislo2`) AS `KZAM_cislo2`,
        count(`za_flat_table`.`zamestnani_od3`) AS `zamestnani_od3`,
        count(`za_flat_table`.`zamestnani_do3`) AS `zamestnani_do3`,
        count(`za_flat_table`.`zamestnani_zamestnavatel3`) AS `zamestnani_zamestnavatel3`,
        count(`za_flat_table`.`zamestnani_pozice3`) AS `zamestnani_pozice3`,
        count(`za_flat_table`.`zamestnani_popis3`) AS `zamestnani_popis3`,
        count(`za_flat_table`.`KZAM_cislo3`) AS `KZAM_cislo3`,
        count(`za_flat_table`.`zamestnani_od4`) AS `zamestnani_od4`,
        count(`za_flat_table`.`zamestnani_do4`) AS `zamestnani_do4`,
        count(`za_flat_table`.`zamestnani_zamestnavatel4`) AS `zamestnani_zamestnavatel4`,
        count(`za_flat_table`.`zamestnani_pozice4`) AS `zamestnani_pozice4`,
        count(`za_flat_table`.`zamestnani_popis4`) AS `zamestnani_popis4`,
        count(`za_flat_table`.`KZAM_cislo4`) AS `KZAM_cislo4`,
        count(`za_flat_table`.`zamestnani_od5`) AS `zamestnani_od5`,
        count(`za_flat_table`.`zamestnani_do5`) AS `zamestnani_do5`,
        count(`za_flat_table`.`zamestnani_zamestnavatel5`) AS `zamestnani_zamestnavatel5`,
        count(`za_flat_table`.`zamestnani_pozice5`) AS `zamestnani_pozice5`,
        count(`za_flat_table`.`zamestnani_popis5`) AS `zamestnani_popis5`,
        count(`za_flat_table`.`KZAM_cislo5`) AS `KZAM_cislo5`,
        count(`za_flat_table`.`zamestnani_konec_posledniho`) AS `zamestnani_konec_posledniho`,
        count(`za_flat_table`.`zamestnani_zpukonceni`) AS `zamestnani_zpukonceni`,
        count(`za_flat_table`.`pozadavky_povolani`) AS `pozadavky_povolani`,
        count(`za_flat_table`.`pozadavky_KZAM1`) AS `pozadavky_KZAM1`,
        count(`za_flat_table`.`pozadavky_KZAM2`) AS `pozadavky_KZAM2`,
        count(`za_flat_table`.`pozadavky_KZAM3`) AS `pozadavky_KZAM3`,
        count(`za_flat_table`.`pozadavky_hleda1`) AS `pozadavky_hleda1`,
        count(`za_flat_table`.`pozadavky_hleda2`) AS `pozadavky_hleda2`,
        count(`za_flat_table`.`pozadavky_hleda3`) AS `pozadavky_hleda3`,
        count(`za_flat_table`.`pozadavky_hleda4`) AS `pozadavky_hleda4`,
        count(`za_flat_table`.`pozadavky_hleda5`) AS `pozadavky_hleda5`,
        count(`za_flat_table`.`pozadavky_hleda6`) AS `pozadavky_hleda6`,
        count(`za_flat_table`.`pozadavky_hleda7`) AS `pozadavky_hleda7`,
        count(`za_flat_table`.`pozadavky_hleda8`) AS `pozadavky_hleda8`,
        count(`za_flat_table`.`pozadavky_hleda9`) AS `pozadavky_hleda9`,
        count(`za_flat_table`.`pozadavky_hleda10`) AS `pozadavky_hleda10`,
        count(`za_flat_table`.`pozadavky_hleda11`) AS `pozadavky_hleda11`,
        count(`za_flat_table`.`pozadavky_hleda12`) AS `pozadavky_hleda12`,
        count(`za_flat_table`.`pozadavky_hleda13`) AS `pozadavky_hleda13`,
        count(`za_flat_table`.`pozadavky_odmita1`) AS `pozadavky_odmita1`,
        count(`za_flat_table`.`pozadavky_odmita2`) AS `pozadavky_odmita2`,
        count(`za_flat_table`.`pozadavky_odmita3`) AS `pozadavky_odmita3`,
        count(`za_flat_table`.`pozadavky_odmita4`) AS `pozadavky_odmita4`,
        count(`za_flat_table`.`pozadavky_odmita5`) AS `pozadavky_odmita5`,
        count(`za_flat_table`.`pozadavky_odmita6`) AS `pozadavky_odmita6`,
        count(`za_flat_table`.`pozadavky_odmita7`) AS `pozadavky_odmita7`,
        count(`za_flat_table`.`pozadavky_odmita8`) AS `pozadavky_odmita8`,
        count(`za_flat_table`.`pozadavky_odmita9`) AS `pozadavky_odmita9`,
        count(`za_flat_table`.`pozadavky_odmita10`) AS `pozadavky_odmita10`,
        count(`za_flat_table`.`pozadavky_odmita11`) AS `pozadavky_odmita11`,
        count(`za_flat_table`.`pozadavky_odmita12`) AS `pozadavky_odmita12`,
        count(`za_flat_table`.`pozadavky_odmita13`) AS `pozadavky_odmita13`,
        count(`za_flat_table`.`pozadavky_nastup`) AS `pozadavky_nastup`,
        count(`za_flat_table`.`pozadavky_plat`) AS `pozadavky_plat`,
        count(`za_flat_table`.`pozadavky_prace`) AS `pozadavky_prace`,
        count(`za_flat_table`.`pece_o_zav_osoby`) AS `pece_o_zav_osoby`,
        count(`za_flat_table`.`zdrav_stav`) AS `zdrav_stav`,
        count(`za_flat_table`.`ZPS`) AS `ZPS`,
        count(`za_flat_table`.`zdravotni_znevyhodneni`) AS `zdravotni_znevyhodneni`,
        count(`za_flat_table`.`doba_evidence`) AS `doba_evidence`,
        count(`za_flat_table`.`kolikrat_ev`) AS `kolikrat_ev`,
        count(`za_flat_table`.`prostredky_p_p`) AS `prostredky_p_p`,
        count(`za_flat_table`.`pp_v_hotovosti`) AS `pp_v_hotovosti`,
        count(`za_flat_table`.`predcisli`) AS `predcisli`,
        count(`za_flat_table`.`cislo`) AS `cislo`,
        count(`za_flat_table`.`banka`) AS `banka`,
        count(`za_flat_table`.`B1`) AS `B1`,
        count(`za_flat_table`.`datum_reg`) AS `datum_reg`,
        count(`za_flat_table`.`datum_narozeni`) AS `datum_narozeni`,
        count(`za_flat_table`.`misto_narozeni`) AS `misto_narozeni`,
        count(`za_flat_table`.`datum_vytvor_smlouvy`) AS `datum_vytvor_smlouvy`,
        count(`za_flat_table`.`datum_vytvor_dotazniku`) AS `datum_vytvor_dotazniku`
    FROM
        `za_flat_table`
	GROUP BY
        concat(prijmeni, ' ',jmeno)
	ORDER BY prijmeni, jmeno ASC 