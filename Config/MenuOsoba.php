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
     * @param Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Viewmodel_OsobaMenuViewmodel
     * @throws UnexpectedValueException
     */
    public static function setSkupinyZajemce(Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel, Projektor2_Model_Db_Zajemce $zajemce) {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $user = $sessionStatus->getUserStatus()->getUser();
        $kod = $sessionStatus->getUserStatus()->getProjekt()->kod;
        switch ($kod) {
            case 'AP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_ap_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_ap_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_ap_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //IP1
                if ($user->tl_ap_ip1) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_ip1_uc';
                    $modelTlacitko->text = 'IP1';
                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //plán
                if ($user->tl_ap_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_ap_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_ap_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ap_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'HELP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_he_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_he_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_he_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();

                //plán
                if ($user->tl_he_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_he_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'he_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'SJZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sj_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sj_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sj_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sj_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sj_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_sj_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjzp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'VZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_vz_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_vz_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_vz_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'vzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'SJPK':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sp_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sp_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_sp_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpk_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;

            case 'ZPM':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_zpm_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_zpm_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_zpm_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zpm_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;

            case 'SPP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_spp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_spp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_spp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'spp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;

            case 'RP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_rp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_rp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_rp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'rp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;

            case 'SJPO':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_so_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_so_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_so_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_so_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_so_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_so_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjpo_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;

            case 'SJLP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sl_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sl_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_sl_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sl_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sl_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'sjlp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_sl_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zamestnani';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'VDTP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_vdtp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_vdtp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_vdtp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'PDU':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_pdu_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_pdu_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_pdu_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'MB':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_mb_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_mb_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'souhlas';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->addButton($modelTlacitko);
                }
                //dotazník
                if ($user->tl_mb_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'dotaznik';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_mb_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_mb_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_mb_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zamestnani';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                break;
            case 'CJC':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_cj_cizinec) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'cizinec';
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuCizinec($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_cj_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_cj_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);

                // skupina zamestnani
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //zaměstnání
                if ($user->tl_cj_zam) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'zamestnani';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);
                break;

##############
            case 'CKP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_ckp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_ckp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);
                break;
############
            case 'PKP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_pkp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'smlouva';
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_pkp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                self::pridejSkupinuPlan($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce);
                break;

            default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kod);
                break;

        }

        return $osobaMenuViewmodel;
    }

    public static function pridejSkupinuRegistrace($osobaMenuViewmodel, $skupina) {
        if (count($skupina->getButtons())) {
            $osobaMenuViewmodel->addGroup($skupina);
        }
    }
    
    public static function pridejSkupinuCizinec(Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel, $skupina) {
        if (count($skupina->getButtons())) {
            $osobaMenuViewmodel->addGroup($skupina);
            self::addSignalsCizinec($skupina, $osobaMenuViewmodel);
        }
    }
    
    private static function addSignalsCizinec(Projektor2_Viewmodel_Menu_Group $skupina, Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_OsobniUdaje();
        // použij CollectionFlatTable
        $modelSignal->setByOsobaMenuViewmodel(new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce));
        $skupina->addSignal($modelSignal);
    }  
    
    public static function pridejSkupinuPlan($osobaMenuViewmodel, Projektor2_Viewmodel_Menu_Group $skupina, $sessionStatus, $zajemce) {
        if (count($skupina->getButtons())) {
            $osobaMenuViewmodel->addGroup($skupina);
            self::addSignalsPlan($skupina, $sessionStatus, $zajemce);
        }
    }
    
    private static function addSignalsPlan(Projektor2_Viewmodel_Menu_Group $skupina, $sessionStatus, $zajemce) {
        $kolekceAktivityPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
        if ($kolekceAktivityPlan) {
            foreach ($kolekceAktivityPlan as $aktivitaPlan) {
                /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
                $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                $modelSignal->setByAktivitaPlan($aktivitaPlan);
                $skupina->addSignal($modelSignal);
            }
        }        
    }

    public static function pridejSkupinuUkonceni($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce) {
        if (count($skupina->getButtons())) {
            $osobaMenuViewmodel->addGroup($skupina);
            self::addSignalsUkonceni($skupina, $sessionStatus, $zajemce);
        }
    }

    private static function addSignalsUkonceni(Projektor2_Viewmodel_Menu_Group $skupina, $sessionStatus, $zajemce) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
        // použij CollectionFlatTable
        $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Config_Ukonceni::getUkonceniProjektu($sessionStatus->getUserStatus()->getProjekt()->kod));
        $skupina->addSignal($modelSignal);    
    }
    
    public static function pridejSkupinuZamestnani($osobaMenuViewmodel, $skupina, $sessionStatus, $zajemce) {
        if (count($skupina->getButtons())) {
            $osobaMenuViewmodel->addGroup($skupina);
            self::addSignalsZamestnani($skupina, $sessionStatus, $zajemce);
        }
    }
    
    private static function addSignalsZamestnani(Projektor2_Viewmodel_Menu_Group $skupina, $sessionStatus, $zajemce) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
        // použij CollectionFlatTable
        $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
        $skupina->addSignal($modelSignal);
    }    
}
