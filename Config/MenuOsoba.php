<?php
/**
 * Description of MenuOsoba
 *
 * @author pes2704
 */
class Config_MenuOsoba {
############# SKUPINY TLAČÍTEK V ZOBRAZENÍ REGISTRACÍ

    /**
     * Nastaví skupiny tlačítek objeku zajemceRegistrace
     *
     * @param Projektor2_Viewmodel_ZajemceRegistrace $zajemceRegistrace
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Viewmodel_ZajemceRegistrace
     * @throws UnexpectedValueException
     */
    public static function setSkupinyZajemce(Projektor2_Viewmodel_ZajemceRegistrace $zajemceRegistrace, Projektor2_Model_Db_Zajemce $zajemce) {
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $user = $sessionStatus->user;
        $kod = $sessionStatus->projekt->kod;
        switch ($kod) {
            case 'AP':
                // příprava na                     $modelTlacitko->status = 'disabled';
//                $dotaznik = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
//                $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//                $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
//                $zamestnani = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce);

                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_ap_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_ap_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_ap_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //IP1
                if ($user->tl_ap_ip1) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_ip1_uc';
                    $modelTlacitko->text = 'IP1';
                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //plán
                if ($user->tl_ap_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }
//              bez signalu:
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('plan', $skupina);
//                }

//                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_MenuTlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $skupina->setMenuTlacitko($modelTlacitko);
//                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_ap_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_ap_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
//                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;
            case 'HELP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_he_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_he_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_he_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
//                //IP1
//                if ($user->tl_he_ip1) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'he_ip1_uc';
//                    $modelTlacitko->text = 'IP1';
//                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
//                    $modelTlacitko->status = 'print';
//                    $zajemceRegistrace->setTlacitko($modelTlacitko);
//                }
                //plán
                if ($user->tl_he_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }
                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko('tl_ap_porad', $modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_he_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
//                $skupina = new Projektor2_Model_MenuSkupina();
                //zaměstnání
//                if ($user->tl_he_zam) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'he_zamestnani_uc';
//                    $modelTlacitko->text = 'Zaměstnání';
//                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko($modelTlacitko);
//                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
//                }


                break;
            case 'SJZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_sj_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sj_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sj_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_sj_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko($modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_sj_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sj_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                }

                break;
            case 'VZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_vz_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_vz_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_vz_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;
            case 'SJPK':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_sp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sp_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sp_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_sp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko('tl_ap_porad', $modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_sp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sp_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }
                break;

            case 'ZPM':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_zpm_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_zpm_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_zpm_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;

            case 'SPP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_spp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_spp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_spp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;

            case 'RP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_rp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_rp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_rp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;

            case 'SJPO':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_so_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_so_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_so_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_so_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko($modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_so_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_so_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }
                break;

            case 'SJLP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_sl_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sl_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sl_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_sl_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                //poradenství
//                if ($user->tl_ap_porad) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'ap_porad_uc';
//                    $modelTlacitko->text = 'Plán poradenství';
//                    $modelTlacitko->title = 'Úprava údajů plánu poradenských aktivit';
//                    $modelTlacitko->status = 'edit';
//                    $zajemceRegistrace->setTlacitko($modelTlacitko);
//                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_sl_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sl_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }
                break;
            case 'VDTP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_vdtp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vdtp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_vdtp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vdtp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_vdtp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vdtp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;
            case 'PDU':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_pdu_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'pdu_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_pdu_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'pdu_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_pdu_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'pdu_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }

                break;
            case 'MB':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //smlouva
                if ($user->tl_mb_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_mb_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'souhlas';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_mb_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'dotaznik';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_mb_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_mb_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_mb_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zamestnani';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }
                break;
            case 'CJC':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //cizinec
                if ($user->tl_cj_cizinec) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'cizinec';
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                //smlouva
//                if ($user->tl_cj_sml) {
//                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
//                    $modelTlacitko->form = 'cj_sml_uc';
//                    $modelTlacitko->text = 'Smlouva';
//                    $modelTlacitko->title = 'Úprava údajů smlouvy';
//                    $modelTlacitko->status = 'edit';
//                    $skupina->setMenuTlacitko($modelTlacitko);
//                }
//                //souhlas se zpracováním osobních údajů
//                if ($user->tl_cj_souhlas) {
//                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
//                    $modelTlacitko->form = 'cj_souhlas_uc';
//                    $modelTlacitko->text = 'Souhlas';
//                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
//                    $modelTlacitko->status = 'print';
//                    $skupina->setMenuTlacitko($modelTlacitko);
//                }

                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //plán
                if ($user->tl_cj_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
                            /** @var Projektor2_Model_AktivitaPlan $aktivitaPlan */
                            $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($modelSignal);
                        }
                    }
                }
                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //ukončení
                if ($user->tl_cj_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal($modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                //zaměstnání
                if ($user->tl_cj_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zamestnani';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                if (count($skupina->getMenuTlacitka())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal($modelSignal);
                }
                break;

            default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kod);
                break;

        }

        return $zajemceRegistrace;
    }
}
