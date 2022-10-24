<?php
/**
 * Kontejner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Projektor2_AppContext
{

############# DATABÁZE #############
    const DEFAULT_DB_NICK = 'projektor';

    /**
     * @var Framework_Database_HandlerSqlInterface
     */
    private static $db = array();

    public static function version() {
        return "projektor - verze cjc";
    }

    /**
     * Metoda vrací objekt pro přístup k databázi. Metoda se podle označení databáze (nick) zadaném jako prametr rozhoduje,
     * který objekt pro přístup k databázi vytvoří. Ke každé databázi vytváří jednu instanci objektu.
     * @param string $nick Označení databáze používané v tomto projektu
     * @return Framework_Database_HandlerSqlInterface
     * @throws UnexpectedValueException
     */
    public static function getDb($nick = self::DEFAULT_DB_NICK) {
        switch ($nick) {
            case 'projektor':
                if(!isset(self::$db['projektor']) OR !isset(self::$db['projektor'])) {
                    if (self::isRunningOnProductionMachine()) {
                        $dbh = new Projektor2_DB_Mysql_NeonProjektor2cjc();
                    } else {
                        $dbh = new Projektor2_DB_Mysql_LocalhostCjc();
                    }
                    self::$db['projektor'] = $dbh;
                }
                return self::$db['projektor'];

                break;

            default:
                throw new UnexpectedValueException('Neznámy název databáze '.$nick.'.');
        }
    }

    /**
     * Informuje, zda skript běží na produkčním stroji.
     * @return boolean
     */
    private static function isRunningOnProductionMachine() {
        return (strpos(strtolower(gethostname()), 'projektor')===0) ? TRUE : FALSE;
    }

    /**
     * Vrací defaulní označení (nick) databáze. Jedná se o označení používané v rámci aplikace, nikoli o skutečný název
     * databáze v databázovém stroji.
     * @return string
     */
    public static function getDefaultDatabaseName() {
        return 'projektor';
    }

############# LOGOVÁNÍ #######################
    /**
     * Cesta ke složce pro ukládání logů. Relativní cesta k indexu, končí lomítkem.
     *
     * @return string
     */
    public static function getLogsPath() {
        return $_SERVER['DOCUMENT_ROOT'].'/_LogsProjektor/'; // absolutní - podsložka dovument root -> složka _LogsProjektor je v kořenovém adresáři (htdocs)
    }

############# LOGO PROJEKTU #######################
    public static function getLogoContext(Projektor2_Model_SessionStatus $sessionStatus) {
        $context = array();
        switch ($sessionStatus->projekt->kod) {
            case "NSP":
                $context['nadpis'] = 'PROJEKT NAJDI SI PRÁCI V PLZEŇSKÉM KRAJI';
                $context['src'] = "logoNSP.gif";
                $context['alt'] = "Logo projektu Najdi si práci";
                break;
            case "PNP":
                $context['nadpis'] = 'PROJEKT PŘÍPRAVA NA PRÁCI V PLZEŇSKÉM KRAJI';
                $context['src'] = "logoPNP.gif";
                $context['alt'] = "Logo projektu Příprava na práci";
                break;
            case "SPZP":
                $context['nadpis'] = 'PROJEKT S POMOCÍ ZA PRACÍ';
                $context['src'] = "logo_spzp.jpg";
                $context['alt'] = "Logo projektu S pomocí za prací";
                break;
            case "RNH":
                $context['nadpis'] = 'PROJEKT RODINA NENÍ HANDICAP';
                $context['src'] = "logo_rnh.jpg";
                $context['alt'] = "Logo projektu Rodina není handicap";
                break;
            case "AGP":
                $context['nadpis'] = 'AGENTURA PRÁCE';
                $context['src'] = "logo_agp.png";
                $context['alt'] = "Logo Personal Service";
                break;
            case "HELP":
                $context['nadpis'] = 'PROJEKT HELP50+';
                $context['src'] = "logo_Help50.png";
                $context['alt'] = "Logo projektu Help50+";
                break;
            case "AP":
                $context['nadpis'] = 'PROJEKT ALTERNATIVNÍ PRÁCE';
                $context['src'] = "logo_AP.png";
                $context['alt'] = "Logo projektu Alternativní práce v Plzeňském kraji";
                break;
            case "SJZP":
                $context['nadpis'] = 'PROJEKT S JAZYKY ZA PRACÍ';
                $context['src'] = "logo_S_JAZYKY_ZA_PRACI.png";
                $context['alt'] = "Logo projektu S jazyky za prací";
                break;
            case "VZP":
                $context['nadpis'] = 'PROGRAM Vykroč za prací';
                $context['src'] = "logo_VYKROC_ZA_PRACI.png";
                $context['alt'] = "Logo programu Vykroč za prací projektu „Vzdělávání a dovednosti pro trh práce II“ ";
                break;
            case "SJPK":
                $context['nadpis'] = 'PROJEKT S JAZYKY ZA PRACÍ V PLZEŇSKÉM A KARLOVARSKÉM KRAJI';
                $context['src'] = "logo_S_JAZYKY_ZA_PRACI.png";
                $context['alt'] = "Logo projektu S jazyky za prací v Plzeňském a Karlovarském kraji";
                break;
            case "ZPM":
                $context['nadpis'] = 'PROJEKT ZÁRUKY PRO MLADÉ V PLZEŇSKÉM KRAJI';
                $context['src'] = "logo_ZARUKY_PRO_MLADE.png";
                $context['alt'] = "Logo projektu Záruky pro mladé v Plzeňském kraji";
                break;
            case "SPP":
                $context['nadpis'] = 'PROJEKT ŠANCE PRO PADESÁTNÍKY V PLZEŇSKÉM KRAJI';
                $context['src'] = "logo_SANCE_PRO_PADESATNIKY.png";
                $context['alt'] = "Logo projektu Šance pro padesátníky v Plzeňském kraji";
                break;
            case "RP":
                $context['nadpis'] = 'PROJEKT RODINA I PRÁCE V PLZEŇSKÉM KRAJI';
                $context['src'] = "logo_RODINA_I_PRACE.png";
                $context['alt'] = "Logo projektu Rodina i práce v Plzeňském kraji";
                break;
            case "SJPO":
                $context['nadpis'] = 'PROJEKT S JAZYKY ZA PRACÍ V PLZNI A OKOLÍ';
                $context['src'] = "logo_S_JAZYKY_ZA_PRACI.png";
                $context['alt'] = "Logo projektu S jazyky za prací v Plzni a okolí";
                break;
            case "SJLP":
                $context['nadpis'] = 'PROJEKT S JAZYKY PRO LEPŠÍ PRÁCI';
                $context['src'] = "logo_2018_S_JAZYKY_SJLP.png";
                $context['alt'] = "Logo projektu S jazyky pro lepší práci";
                break;
            case "VDTP":
                $context['nadpis'] = 'PROJEKT Vzdělávání a dovednosti pro trh práce II';
                $context['src'] = "logo_Vzdělávání a dovednosti pro trh práce II.png";
                $context['alt'] = "Logo projektu Vzdělávání a dovednosti pro trh práce II";
                break;
            case "PDU":
                $context['nadpis'] = 'PROJEKT Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání';
                $context['src'] = "logo_PDU Přidejte se k nám, má to smysl.png";
                $context['alt'] = "Logo projektu PDU Přidejte se k nám, má to smysl";
                break;
            case "MB":
                $context['nadpis'] = 'PROJEKT MOJE BUDOUCNOST';
                $context['src'] = "logo_Moje_Budoucnost.png";
                $context['alt'] = "Logo projektu Moje Budoucnost.";
                break;
            case "CJC":
                $context['nadpis'] = 'ČEŠTINA PRO CIZINCE';
                $context['src'] = "logo_CJC.png";
                $context['alt'] = "Logo Čeština pro cizince.";
                break;

            default:
                $context['nadpis'] = 'PROJEKT DOSUD NEBYL PLNĚ NASTAVEN';
                $context['src'] = "logo_Projektu.png";
                $context['alt'] = "Logo projektu dosud nebylo zadáno.";
                break;
        }
        return $context;
    }

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
                    $modelTlacitko->osoba = 'sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_mb_souhlas) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko($modelTlacitko);
                }
                //dotazník
                if ($user->tl_mb_dot) {
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoOsoba();
                    $modelTlacitko->osoba = 'reg_dot';
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
                    $modelTlacitko->osoba = 'plan_uc';
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
                    $modelTlacitko->osoba = 'ukonceni_uc';
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
                    $modelTlacitko->osoba = 'zamestnani_uc';
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
                    $modelTlacitko->osoba = 'plan_uc';
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
                    $modelTlacitko->osoba = 'ukonceni_uc';
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
                    $modelTlacitko->osoba = 'zamestnani_uc';
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

    /**
     * Nastaví skupiny tlačítek ke kurzu
     *
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return type
     * @throws UnexpectedValueException
     */
    public static function setSkupinyKurz(Projektor2_Viewmodel_Kurz $viewmodelKurz, Projektor2_Model_Db_SKurz $sKurz) {
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $user = $sessionStatus->user;

                //kurz
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'detail_kurzu';
                    $modelTlacitko->text = 'Detail kurzu';
                    $modelTlacitko->title = 'Úprava údajů kurzu';

                    $modelTlacitko->status = 'edit';
                $skupina->setMenuTlacitko($modelTlacitko);
                if (count($skupina->getMenuTlacitka())) {
                    $viewmodelKurz->setSkupina('detail', $skupina);
                }
                //účastníci
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'ucastnici_kurzu';
                    $modelTlacitko->text = 'Účastníci';
                    $modelTlacitko->title = 'Seznam účastníků kurzu';
                    $modelTlacitko->status = 'print';
                $skupina->setMenuTlacitko($modelTlacitko);


                if (count($skupina->getMenuTlacitka())) {
                    $viewmodelKurz->setSkupina('ucastnici', $skupina);
//                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
//                    if ($kolekceAktivityPlan) {
//                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
////                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
//                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
//                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
//                            $skupina->setMenuSignal($modelSignal);
//                        }
//                    }
                }


        return $viewmodelKurz;
    }

############# CERTIFIKÁTY #############

    /**
     * Vrací pole s texty pro certifikáty
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getCertificateTexts(Projektor2_Model_SessionStatus $sessionStatus) {
        $texts = array();
        switch ($sessionStatus->projekt->kod) {
        ######## AP #################
            case 'AP':
                $texts['signerName'] = 'Mgr. Milada Kolářová';
                $texts['signerPosition'] = 'manažer projektu';
                $texts['v_projektu'] = 'v projektu „Alternativní práce v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Alternativní práce v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
                break;
        ######## SJZP #################
            case 'SJZP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Karlovarském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Karlovarském kraji“ ";
                $texts['financovan'] = "\nProjekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
                break;
        ######## VZP #################
            case 'VZP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'administrator programu';
                $texts['v_projektu'] = 'v projektu „Vzdělávání a dovednosti pro trh práce II“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu Vykroč za prací projektu „Vzdělávání a dovednosti pro trh práce II“ ";
                $texts['financovan'] = "\nProjekt Vzdělávání a dovednosti pro trh práce II reg.č.CZ.03.1.48/0.0/0.0/15_121/0000597"
                        . "\nje spolufinancovaný z prostředků Evropského sociálního fondu, "
                        . "\nresp. Operačního programu Zaměstnanost a státního rozpočtu České republiky.";
                break;
         ######## SJZP PK KK #################
            case 'SJPK':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Plzeňském a Karlovarském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Plzeňském a Karlovarském kraji“ ";
                $texts['financovan'] = "\nProjekt S jazyky za prací v Plzeňském a Karlovarském kraji CZ.03.1.48/0.0/0.0/15_040/0002665 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
           ######## ZPM #################
            case 'ZPM':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Záruky pro mladé v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Záruky pro mladé v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Záruky pro mladé v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_004/0000006 je spolufinancován "
                                  . "z Evropského sociálního fondu prostřednictvím Operačního programu Zaměstnanost a ze státního rozpočtu České republiky.";
                break;
           ######## SPP #################
            case 'SPP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Šance pro padesátníky v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Šance pro padesátníky v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Šance pro padesátníky v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_010/0000035 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;

            ######## RP #################
            case 'RP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Rodina i práce v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Rodina i práce v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Rodina i práce v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_010/0000036 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu České republiky.";
                break;
        ######## SJPO V PLZNI A OKOLÍ #################
            case 'SJPO':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Plzni a okolí“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Plzni a okolí“ ";
                $texts['financovan'] = "\nS jazyky za prací v Plzni a okolí CZ.03.1.48/0.0/0.0/16_045/0009267 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
        ######## SJLP PRO LEPŠÍ PRÁCI #################
            case 'SJLP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky pro lepší práci“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky pro lepší práci“ ";
                $texts['financovan'] = "\nS jazyky pro lepší práci CZ.03.1.48/0.0/0.0/17_075/0009252 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
           ######## VDTP #################
            case 'VDTP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Vzdělávání a dovednosti pro trh práce II“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Vzdělávání a dovednosti pro trh práce II“ ";
                $texts['financovan'] = "\nProjekt Vzdělávání a dovednosti pro trh práce II CZ.03.1.48/0.0/0.0/15_121/0000597 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;
           ######## PDU #################
            case 'PDU':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání“ ";
                $texts['financovan'] = "\nProjekt Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání CZ.03.1.48/0.0/0.0/15_121/0010247 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;
        ######## MB MOJE BUDOUCNOST #################
            case 'MB':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Moje budoucnost“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Moje budoucnost“ ";
                $texts['financovan'] = "\nProjekt Rozvoj nabídky služeb zaměstnosti Moje budoucnost CZ.03.1.48/0.0/0.0/16_045/0015019 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";    // DOPLNIT
                break;
        ######## MB MOJE BUDOUCNOST #################
            case 'CJC':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Čeština pro cizince“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Čeština pro cizince“ ";
                $texts['financovan'] = "\n";    // DOPLNIT
                break;

            default:
                throw new UnexpectedValueException('Nejsou definovány texty pro certifikát v projektu '.$kod.'.');
        }

            return $texts;
    }

    public static function getCertificateOriginalBackgroundImageFilepath(Projektor2_Model_SessionStatus $sessionStatus) {
        switch ($sessionStatus->projekt->kod) {
            case 'AP':
                $filePath = "img/pozadi/certifikat_pozadi.jpg";   //certifikat_pozadi.jpg je obrázek včetně log, zobrazuje se od horní hrany strányk, překrývá hlavičku
                break;

            case 'SJZP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
            case 'CJC':
                $filePath = "img/pozadi/pozadi_osvedceni.png";   // pozadi.jpg je bez log, zobrazuje se niže na stránce, loga jsou v hlavičce
                break;

            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
                $filePath = "img/pozadi/pozadi_osvedceni.png";   // pozadi.jpg je bez log, zobrazuje se niže na stránce, loga jsou v hlavičce
                break;


            default:
                throw new UnexpectedValueException('Není definován soubor s orázkem na pozadí pro certifikát v projektu '.$sessionStatus->projekt->kod.'.');
        }
        return $filePath;
    }

    public static function getCertificatePseudocopyBackgroundImageFilepath(Projektor2_Model_SessionStatus $sessionStatus) {
        switch ($sessionStatus->projekt->kod) {
            case 'AP':
                // náhodný výběr ze 4 možných pozadí
                $number = intval(rand(1, 4.99));
                $filePath = "img/pozadi/komplet_pozadi".$number.".jpg";
                break;

            case 'SJZP':
            case 'VZP':
            case 'SJPK':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'SJPO':
            case 'SJLP':
            case 'VDTP':
            case 'PDU':
            case 'MB':
            case 'CJC':
                // jedno pozadí - stejné jako originál (bez podpisu)
                $filePath = self::getCertificateOriginalBackgroundImageFilepath($sessionStatus);
                break;
            default:
                throw new UnexpectedValueException('Není definován soubor s obrázkem na pozadí pro certifikát v projektu '.$sessionStatus->projekt->kod.'.');
        }
        return $filePath;
    }

    public static function getCertificatePmsBackgroundImageFilepath(Projektor2_Model_SessionStatus $sessionStatus) {
        switch ($sessionStatus->projekt->kod) {
            case 'AP':
            case 'SJZP':
            case 'VZP':
            case 'SJPK':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'SJPO':
            case 'SJLP':
            case 'VDTP':
            case 'PDU':
            case 'MB':
            case 'CJC':
                // jedno pozadí
                $filePath = "img/pozadi/pozadi_osvedceni_pms.png";   // parte rámeček
                break;
            default:
                throw new UnexpectedValueException('Není definován soubor s obrázkem na pozadí pro certifikát v projektu '.$sessionStatus->projekt->kod.'.');
        }
        return $filePath;
    }

    public static function getCertificateTypeFolder($certificateType) {
//        switch ($sessionStatus->projekt->kod) {
        switch ($certificateType) {
            case 1:
                // jedno pozadí
                $filePath = "certifikaty_kurz/";   // pro Grafii original
                break;
            case 2:
                // jedno pozadí
                $filePath = "certifikaty_kurz_pseudokopie/";   // pro Grafii pseudokopie
                break;
            case 3:
                // jedno pozadí
                $filePath = "certifikaty_kurz_pro_monitoring/";   // pro up
                break;
            case 4:
                // jedno pozadí
                $filePath = "certifikaty_kurz_akreditovany/";   // pro akreditované kurzy
                break;
            default:
                throw new UnexpectedValueException('neznámý typ certifikátu. Typ: '.$certificateType);
        }
        return $filePath;
    }

    /**
     * Vrací řetězec identifikátoru certifikátu. Ve formátu PR/čtyřmístné číslo roku/ctyřmístné pořadové číslo certifikátu, např: PR/2015/0012
     * @param type $rok
     * @param type $cislo
     * @return type
     */
    public static function getCertificateKurzIdentificator($certificateType, $rok, $cislo) {
        if (trim($rok)<="2014") {
            return $rok.'/'.$cislo;            // v roce 2014 byla první várka očíslována takto, dodržuji tedy číslování 2014
        } else {
            switch ($certificateType) {
                case 1:
                    $certIdentifikator = sprintf("PR/%04d/%04d", $rok, $cislo);     // projektový certifikát
                    break;
                case 3:
                    $certIdentifikator = sprintf("MO/%04d/%04d", $rok, $cislo);     // certifikát pro monitoring
                    break;
                case 4:
                    $certIdentifikator = sprintf("AKP/%04d/%04d", $rok, $cislo);     // certifikát pro akreditovaný kurz
                    break;
                default:
                    throw new UnexpectedValueException('Neznámý typ certifikátu pro generování identifikátoru. Typ: '.$certificateType);
                    break;
            }
            return $certIdentifikator;
        }
    }

    /**
     * Vrací řetězec identifikátoru certifikátu. Ve formátu PR/čtyřmístné číslo roku/ctyřmístné pořadové číslo certifikátu, např: PR/2015/0012
     * @param type $rok
     * @param type $cislo
     * @return type
     */
    public static function getCertificateProjektIdentificator($rok, $cislo) {
        return sprintf("ABS/%04d/%04d", $rok, $cislo);
    }

    /**
     * Maximální doba běhu skriptu použitá pro generování a export certifikátů
     * @return int
     */
    public static function getExportCertifMaxExucutionTime() {
        return 360;
    }

############# EXPORTY #############
    /**
     * Vrací cestu ke kořenovému adresáři pro ukládání souborů (zejména pro file mappery). Jde vždy o cestu relativní vůči
     * kočenové složce dokument§ serveru - DOCUMENT_ROOT
     * @param type $kod
     * @return type
     * @throws UnexpectedValueException
     */
    public static function getFileBaseFolder() {
        $fileBaseFolder = '_ExportProjektor/';
        return $fileBaseFolder;
    }
    /**
     * Vrací cestu ke kořenovému adresáři pro ukládání souborů (zejména pro file mappery)
     * @param type $kod
     * @return type
     * @throws UnexpectedValueException
     */
    public static function getRelativeFilePath($kod=NULL) {
                switch ($kod) {
        ######## AP ###################
            case 'AP':
                return 'AP/';
                break;
        ######## HELP #################
            case 'HELP':
                return 'HELP/';
                break;
        ######## SJZP #################
            case 'SJZP':
                return 'SJZP/';
                break;
        ######## VZP #################
            case 'VZP':
                return 'VZP/';
                break;
        ######## SJZP #################
            case 'SJPK':
                return 'SJPK/';
                break;
        ######## ZPM #################
            case 'ZPM':
                return 'ZPM/';
                break;
       ######## SPP #################
            case 'SPP':
                return 'SPP/';
                break;
       ######## RP #################
            case 'RP':
                return 'RP/';
                break;
       ######## SJPO #################
            case 'SJPO':
                return 'SJPO/';
                break;
       ######## SJLP #################
            case 'SJLP':
                return 'SJLP/';
                break;
       ######## VDTP #################
            case 'VDTP':
                return 'VDTP/';
                break;
       ######## PDU #################
            case 'PDU':
                return 'PDU/';
                break;
       ######## MB #################
            case 'MB':
                return 'MB/';
                break;
       ######## CJC #################
            case 'CJC':
                return 'CJC/';
                break;
            default:
                throw new UnexpectedValueException('Není definována cesta pro dokumenty projektu '.$kod);
        }
    }

############# ZNAČKA NOVÉHO ZÁJEMCE #############
    public function getZnacka($nove_cislo_ucastnika, $beh, $kancelar) {
        $retezec = strval($nove_cislo_ucastnika);
        $retezec = str_pad($retezec, 3, "0", STR_PAD_LEFT); // doplní zleva nulami na 3 místa
        $znacka = $beh->oznaceni_turnusu.'-'.$kancelar->kod.'-'.$retezec;
    }

############# UKONČENÍ PROJEKTU #############
    /**
     * Vrací pole pro formulář ukončení projektu
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getUkonceniProjektu($kod) {
        switch ($kod) {
        ######## AP #################
            case 'AP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>TRUE
                    );
                break;
        ######## HELP #################
            case 'HELP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJZP #################
            case 'SJZP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## VZP #################
            case 'VZP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJZP PK KK #################
            case 'SJPK':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## ZPM #################
            case 'ZPM':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SPP #################
            case 'SPP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## RP #################
            case 'RP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJPO #################
            case 'SJPO':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJLP #################
            case 'SJLP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## VDTP #################
            case 'VDTP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## PDU #################
            case 'PDU':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## MB #################
            case 'MB':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
            case 'CJC':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
            default:
                throw new UnexpectedValueException('Není definováno pole s hodnotami pro ukončení projektu '.$kod);
        }
    }
}