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
     * @return \Projektor2_Viewmodel_OsobaMenuViewmodel
     * @throws UnexpectedValueException
     */
    public static function setSkupinyZajemce(Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel) {
       
        $configButtons = self::getConfig();
        
         // skupina dotaznik
        $skupina = new Projektor2_Viewmodel_Menu_Group();
        //smlouva
//        if ($user->tl_mb_sml) {
        if (in_array(Projektor2_Router_Form::CTRL_SMLOUVA, $configButtons)) {
        //smlouva
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
            $modelTlacitko->text = 'Osoba';
            $modelTlacitko->title = 'Úprava osobních údajů';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        //souhlas se zpracováním osobních údajů
        if (in_array(Projektor2_Router_Form::CTRL_SOUHLAS, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = 'souhlas';
            $modelTlacitko->text = 'Souhlas';
            $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
            $modelTlacitko->status = 'print';
            $skupina->addButton($modelTlacitko);
        }
        //dotazník
        if (in_array(Projektor2_Router_Form::CTRL_DOTAZNIK, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = 'dotaznik';
            $modelTlacitko->text = 'Dotazník';
            $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        if ($skupina->getButtons()) {
            $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);
        }
        // skupina cizinec
        $skupina = new Projektor2_Viewmodel_Menu_Group();
        //cizinec
        if (in_array(Projektor2_Router_Form::CTRL_CIZINEC, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_CIZINEC;
            $modelTlacitko->text = 'Registrace';
            $modelTlacitko->title = 'Registrace účastníka programu';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        if ($skupina->getButtons()) {        
            $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_CIZINEC, $skupina);
        }
        
        // skupina plan
        $skupina = new Projektor2_Viewmodel_Menu_Group();
        //plán
        if (in_array(Projektor2_Router_Form::CTRL_PLAN, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = 'plan';
            $modelTlacitko->text = 'Plán kurzů';
            $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        if ($skupina->getButtons()) {        
            $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);
        }

        // skupina ukonceni
        $skupina = new Projektor2_Viewmodel_Menu_Group();
        //ukončení
        if (in_array(Projektor2_Router_Form::CTRL_UKONCENI, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = 'ukonceni';
            $modelTlacitko->text = 'Ukončení a IP2';
            $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        if ($skupina->getButtons()) {        
            $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);
        }

        // skupina zamestnani
        $skupina = new Projektor2_Viewmodel_Menu_Group();
        //zaměstnání
        if (in_array(Projektor2_Router_Form::CTRL_ZAMESTNANI, $configButtons)) {
            $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
            $modelTlacitko->osoba = 'zamestnani';
            $modelTlacitko->text = 'Zaměstnání';
            $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
            $modelTlacitko->status = 'edit';
            $skupina->addButton($modelTlacitko);
        }
        if ($skupina->getButtons()) {        
            $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);
        }

    }
    
    private static function getConfig() {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $username = $sessionStatus->getUserStatus()->getUser()->username;
        $kodProjektu = $sessionStatus->getUserStatus()->getProjekt()->kod;
        $buttons = [];
        switch ($kodProjektu) {
            case 'AP':
            case 'HELP':
            case 'SJZP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                $buttons = [
                    Projektor2_Router_Form::CTRL_SMLOUVA, 
                    Projektor2_Router_Form::CTRL_SOUHLAS, 
                    Projektor2_Router_Form::CTRL_DOTAZNIK,
                    Projektor2_Router_Form::CTRL_PLAN,
                    Projektor2_Router_Form::CTRL_UKONCENI,
                    Projektor2_Router_Form::CTRL_ZAMESTNANI];

                break;

            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
                $buttons = [
                    Projektor2_Router_Form::CTRL_SMLOUVA, 
                    Projektor2_Router_Form::CTRL_PLAN,
                    Projektor2_Router_Form::CTRL_UKONCENI];
                break;

            case 'CJC':
                $buttons = [
                    Projektor2_Router_Form::CTRL_CIZINEC, 
                    Projektor2_Router_Form::CTRL_PLAN,
                    Projektor2_Router_Form::CTRL_UKONCENI,
                    Projektor2_Router_Form::CTRL_ZAMESTNANI];
                break;

            case 'CKP':
            case 'PKP':
                $buttons = [
                    Projektor2_Router_Form::CTRL_SMLOUVA, 
                    Projektor2_Router_Form::CTRL_PLAN];
                break;

            default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kodProjektu);
                break;

        }
        return $buttons;
    }
    
    /**
     * Nastaví skupiny tlačítek objeku zajemceRegistrace
     *
     * @param Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel
     * @return \Projektor2_Viewmodel_OsobaMenuViewmodel
     * @throws UnexpectedValueException
     */
    public static function setSkupinyZajemceOLD(Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel) {

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
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_ap_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;
            case 'HELP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_he_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();

                //plán
                if ($user->tl_he_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_he_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;
            case 'SJZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sj_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sj_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sj_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;
            case 'VZP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_vz_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_vz_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_vz_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;
            case 'SJPK':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;

            case 'ZPM':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_zpm_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_zpm_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_zpm_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;

            case 'SPP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_spp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_spp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_spp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;

            case 'RP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_rp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_rp_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_rp_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;

            case 'SJPO':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_so_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_so_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_so_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;

            case 'SJLP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_sl_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

                // skupina plan
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //plán
                if ($user->tl_sl_plan) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'plan';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

                // skupina ukonceni
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //ukončení
                if ($user->tl_sl_ukon) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'ukonceni';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;
            case 'VDTP':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_vdtp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;
            case 'PDU':
                // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_pdu_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

                break;
            case 'MB':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //smlouva
                if ($user->tl_mb_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);

                break;
            case 'CJC':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_cj_cizinec) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_CIZINEC;
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_CIZINEC, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI, $skupina);
                break;

##############
            case 'CKP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_ckp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);
                break;
############
            case 'PKP':
                 // skupina dotaznik
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                //cizinec
                if ($user->tl_pkp_sml) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = Projektor2_Router_Form::CTRL_SMLOUVA;
                    $modelTlacitko->text = 'Registrace';
                    $modelTlacitko->title = 'Registrace účastníka programu';
                    $modelTlacitko->status = 'edit';
                    $skupina->addButton($modelTlacitko);
                }
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_REGISTRACE, $skupina);

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
                $osobaMenuViewmodel->addGroup(Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN, $skupina);
                break;

            default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kod);
                break;

        }
    }


}
