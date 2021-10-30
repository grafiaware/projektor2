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
                        $dbh = new Framework_Database_HandlerSqlMysql_Neon();
                    } else {
                        $dbh = new Framework_Database_HandlerSqlMysql_Localhost();
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
     * @param Projektor2_Model_ZajemceRegistrace $zajemceRegistrace
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_ZajemceRegistrace
     * @throws UnexpectedValueException
     */
    public static function setSkupiny(Projektor2_Model_ZajemceRegistrace $zajemceRegistrace, Projektor2_Model_Db_Zajemce $zajemce) {
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_ap_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';

                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_ap_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_ap_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_ap_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //IP1
                if ($user->tl_ap_ip1) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_ip1_uc';
                    $modelTlacitko->text = 'IP1';
                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_ap_ip1', $modelTlacitko);
                }
                //plán
                if ($user->tl_ap_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
//                    $skupina->setMenuTlacitko('tl_ap_porad', $modelTlacitko);
//                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_ap_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_ap_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'ap_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal('zamestnani', $modelSignal);
                }

                break;
            case 'HELP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_he_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_he_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_he_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_he_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_ap_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
//                //IP1
//                if ($user->tl_he_ip1) {
//                    $modelTlacitko = new Projektor2_Model_Tlacitko();
//                    $modelTlacitko->form = 'he_ip1_uc';
//                    $modelTlacitko->text = 'IP1';
//                    $modelTlacitko->title = 'První část plánu kurzů a aktivit';
//                    $modelTlacitko->status = 'print';
//                    $zajemceRegistrace->setTlacitko('tl_he_ip1', $modelTlacitko);
//                }
                //plán
                if ($user->tl_he_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_he_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'he_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_he_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
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
//                    $zajemceRegistrace->setTlacitko('tl_he_zam', $modelTlacitko);
//                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
//                }


                break;
            case 'SJZP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_sj_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sj_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_sj_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_sj_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_sj_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_sj_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sj_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjzp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sj_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                }

                break;
            case 'VZP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_vz_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vzp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vz_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_vz_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vzp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vz_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_vz_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vzp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vz_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;
            case 'SJPK':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_sp_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sp_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sp_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_sp_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_sp_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sp_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_sp_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sp_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_sp_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sp_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sp_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpk_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sp_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal('zamestnani', $modelSignal);
                }
                break;

            case 'ZPM':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_zpm_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'zpm_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_zpm_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_zpm_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'zpm_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_zpm_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_zpm_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'zpm_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_zpm_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;

            case 'SPP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_spp_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'spp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_spp_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_spp_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'spp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_spp_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_spp_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'spp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_spp_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;

            case 'RP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_rp_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'rp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_rp_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_rp_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'rp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_rp_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_rp_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'rp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_rp_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;

            case 'SJPO':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_so_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_so_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_so_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_so_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_so_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_so_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_so_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_so_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_so_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_so_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_so_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjpo_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_so_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal('zamestnani', $modelSignal);
                }
                break;

            case 'SJLP':
                 // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_sl_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sl_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_sl_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_sl_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_sl_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sl_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_sl_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sl_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
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
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_sl_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sl_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_sl_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'sjlp_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_sl_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal('zamestnani', $modelSignal);
                }
                break;
            case 'VDTP':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_vdtp_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vdtp_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vdtp_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_vdtp_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vdtp_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vdtp_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_vdtp_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'vdtp_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_vdtp_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;
            case 'PDU':
                // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_pdu_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'pdu_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_pdu_sml', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_pdu_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'pdu_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_pdu_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }

                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_pdu_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'pdu_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_pdu_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }

                break;
            case 'MB':
                 // skupina dotaznik
                $skupina = new Projektor2_Model_Menu_Skupina();
                //smlouva
                if ($user->tl_mb_sml) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_sml_uc';
                    $modelTlacitko->text = 'Smlouva';
                    $modelTlacitko->title = 'Úprava údajů smlouvy';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_mb_sml', $modelTlacitko);
                }
                //souhlas se zpracováním osobních údajů
                if ($user->tl_mb_souhlas) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_souhlas_uc';
                    $modelTlacitko->text = 'Souhlas';
                    $modelTlacitko->title = 'Tisk souhlasu se zpracováním osobních údajů';
                    $modelTlacitko->status = 'print';
                    $skupina->setMenuTlacitko('tl_mb_souhlas', $modelTlacitko);
                }
                //dotazník
                if ($user->tl_mb_dot) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_reg_dot';
                    $modelTlacitko->text = 'Dotazník';
                    $modelTlacitko->title = 'Úprava údajů dotazníku účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_mb_dot', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('dotaznik', $skupina);
                }

                // skupina plan
                $skupina = new Projektor2_Model_Menu_Skupina();
                //plán
                if ($user->tl_mb_plan) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_plan_uc';
                    $modelTlacitko->text = 'Plán kurzů';
                    $modelTlacitko->title = 'Úprava údajů plánu kurzů a aktivit';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_mb_plan', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('plan', $skupina);
                    $kolekceAktivityPlan = Projektor2_Model_AktivityPlanMapper::findAll($sessionStatus, $zajemce);
                    if ($kolekceAktivityPlan) {
                        foreach ($kolekceAktivityPlan as $aktivitaPlan) {
//                            $aktivitaPlan = new Projektor2_Model_AktivitaPlan();  // jen pro našeptávání
                            $modelSignal = new Projektor2_Model_Menu_Signal_Plan();
                            $modelSignal->setByAktivitaPlan($aktivitaPlan);
                            $skupina->setMenuSignal($aktivitaPlan->indexAktivity, $modelSignal);
                        }
                    }
                }
                // skupina ukonceni
                $skupina = new Projektor2_Model_Menu_Skupina();
                //ukončení
                if ($user->tl_mb_ukon) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_ukonceni_uc';
                    $modelTlacitko->text = 'Ukončení a IP2';
                    $modelTlacitko->title = 'Dokončení plánu kurzů a aktivit a ukončení účasti v projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_mb_ukon', $modelTlacitko);
                }
//                if (count($skupina->getMenuTlacitkaAssoc())) {
//                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
//                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('ukonceni', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Ukonceni();
                    $modelSignal->setByUkonceni(new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce), Projektor2_AppContext::getUkonceniProjektu($sessionStatus->projekt->kod));
                    $skupina->setMenuSignal('ukonceni', $modelSignal);
                }
                // skupina zamestnani
                $skupina = new Projektor2_Model_Menu_Skupina();
                //zaměstnání
                if ($user->tl_mb_zam) {
                    $modelTlacitko = new Projektor2_Model_Menu_Tlacitko();
                    $modelTlacitko->form = 'mb_zamestnani_uc';
                    $modelTlacitko->text = 'Zaměstnání';
                    $modelTlacitko->title = 'Údaje o zaměstnání účastníka projektu';
                    $modelTlacitko->status = 'edit';
                    $skupina->setMenuTlacitko('tl_mb_zam', $modelTlacitko);
                }
                if (count($skupina->getMenuTlacitkaAssoc())) {
                    $zajemceRegistrace->setSkupina('zamestnani', $skupina);
                    $modelSignal = new Projektor2_Model_Menu_Signal_Zamestnani();
                    $modelSignal->setByZamestnani(new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce));
                    $skupina->setMenuSignal('zamestnani', $modelSignal);
                }
                break;
            default:
                    throw new UnexpectedValueException('Nelze nastavit tlačítka. Neznámý kód projektu '.$kod);
                break;

        }

        return $zajemceRegistrace;
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
            default:
                throw new UnexpectedValueException('Není definováno pole s hodnotami pro ukončení projektu '.$kod);
        }
    }

    public static function getAktivityProjektuTypu($kod=NULL, $typ=NULL) {
        $kurzyProjektu = array();
        foreach (self::getAktivityProjektu($kod) as $druhAktivity => $aktivita) {
            if ($aktivita['typ']==$typ) {
                $kurzyProjektu[$druhAktivity] = $aktivita;
            }
        }
        return $kurzyProjektu;
    }

############# AKTIVITY PROJEKTU #############

//            'zztp'=>array(
//                'typ'=>'kurz',    // pro výběr v metode self::getAktivityProjektuTypu()
//                'kurz_druh'=>'ZZTP',   // hodnota pro hledání v tabulce s_kurz (Projektor2_Model_Db_SKurzMapper) podle hodnot ve sloupci kurz_druh (velká písmena)
//                'vyberovy'=> 0,   // nepoužito
//                'nadpis'=>'Kurz základních znalostí trhu práce',
//                's_hodnocenim' => FALSE,
//                's_certifikatem' => TRUE,
//                'tiskni_certifikat' => TRUE,
//                'help'=>'Příklady známek a slovního zhodnocení Kurz základních znalostí trhu práce<br>
//    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
//    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
//    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
//                ),



    /**
     * Vrací pole pro formuláře IP projektu
     * @param string $kod Kód projektu
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getAktivityProjektu($kod=NULL) {
        switch ($kod) {
        ######## AP #################
            case 'AP':
    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'ZZTP',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz základních znalostí trhu práce',
                's_hodnocenim' => FALSE,
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz základních znalostí trhu práce<br>
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'fg'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'FG',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz finanční gramotnosti<br>
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'PC',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz komunikace včetně obsluhy PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz komunikace včetně obsluhy PC<br>
    1 = Účastník Kurz komunikace včetně obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz komunikace včetně obsluhy PC.<br>
    5 = Kurz komunikace včetně obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'im'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'IM',
                'vyberovy'=> 1,
                'nadpis'=>'Image poradna',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Image poradna'
                ),
            'spp'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'SPP',
                'vyberovy'=> 1,
                'nadpis'=>'Motivační setkání pro podnikavé',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Motivační setkání pro podnikavé'
                ),
            'sebas'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'SEBAS',
                'vyberovy'=> 1,
                'nadpis'=>'Podpora sebevědomí a asertivita',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Podpora sebevědomí a asertivita'
                ),
            'forpr'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'FORPR',
                'vyberovy'=> 1,
                'nadpis'=>'Moderní formy práce',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Moderní formy práce'
                ),
            'prdi'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'PD',
                'vyberovy'=> 1,
                'nadpis'=>'Pracovní diagnostika',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'
                ),
            'porad'=>array(
                'typ'=>'poradenstvi',
                'vyberovy'=> 0,
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'
                ),
            'klub'=>array(
                'typ'=>'poradenstvi',
                'vyberovy'=> 1,
                'nadpis'=>'Klubová setkání',
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Klubová setkání'
                ),
            'vyhodnoceni'=>array(
                'typ'=>'poradenstvi',
                'vyberovy'=> 0,
                'nadpis'=>'Vyhodnovení účasti při ukončení účasti',
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'
Vyhodnocení účasti klienta v projektu (shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli).<br>'
                ),
            'doporuceni'=>array(
                'typ'=>'poradenstvi',
                'vyberovy'=> 0,
                'nadpis'=>'Doporučení vysílajícímu KoP ÚP při ukončení účasti',
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'
 V případě, že klient nezíská při účasti v projektu zaměstnání, doporučení vysílajícímu KoP pro další práci s klientem)<br>
 Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
                );

                break;
        ######## HELP #################
            case 'HELP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Motivační kurz',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof2'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 3',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'im'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Image poradna',
                'kurz_druh'=>'IM',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Image poradna'
                ),
            'spp'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Setkání pro podnikavé',
                'kurz_druh'=>'SPP',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Setkání pro podnikavé'),
            'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;
        ######## SJZP #################
            case 'SJZP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Motivační kurz',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
        // prof3 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
//            'im'=>array(
//                'typ'=>'kurz',
//                'nadpis'=>'Image poradna',
//                'kurz_druh'=>'IM',
//                's_certifikatem' => FALSE,
//                'tiskni_certifikat' => FALSE,
//                'help'=>'SJZP Image poradna'
//                ),
//            'spp'=>array(
//                'typ'=>'kurz',
//                'nadpis'=>'Setkání pro podnikavé',
//                'kurz_druh'=>'SPP',
//                's_certifikatem' => FALSE,
//                'tiskni_certifikat' => FALSE,
//                'help'=>'SJZP Setkání pro podnikavé'),
            'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Pracovní diagnostika'),
            'bidi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Bilanční diagnostika',
                'kurz_druh'=>'BD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Bilanční diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;
        ######## VZP #################
            case 'VZP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                )
            );
                break;
        ######## SJZP PK KK #################
            case 'SJPK':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof4'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
                'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;
        ######## ZPM #################
            case 'ZPM':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                )
            );
                break;
     ######## SPP #################
            case 'SPP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                )
            );
                break;
     ######## VDTP #################
            case 'VDTP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                )
            );
                break;
     ######## PDU #################
            case 'PDU':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                )
            );
                break;



    ######## RP #################
            case 'RP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení poradenského programu<br>
    1 = Účastník absolvoval kurz poradenského programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz poradenského programu, jeho docházka byla postačující.<br>
    3 = Kurz poranského programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla nedostačující.<br>'
                ),
        // prof1 je použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof1
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Jazykový lurz - jazyk anglickýa',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                )
            );
                break;
        ######## SJPO V PLZNI A OKOLÍ #################
            case 'SJPO':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof4'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'odb1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;
        ######## SJLP Pro LEPŠÍ PRÁCI #################
            case 'SJLP':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof4'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'odb1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
                'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;
        ######## MOJE BUDOUCNOST #################
            case 'MB':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Kurz dovedností pro trh práce a motivační aktivity',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br>
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'fg'=>array(
                'typ'=>'kurz',
                'kurz_druh'=>'FG',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz finanční gramotnosti<br>
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ),
            'pc1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
        // prof2 je v MB použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof2
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Intenzivní kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof3'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prof4'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'odb1'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),
            'prdi'=>array(
                'typ'=>'kurz',
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'),
            );
                break;

            default:
        throw new UnexpectedValueException('Neexistuje konfigurace pro daný kód projektu: ', $kod);
        };
    return $aktivity;
    }
}