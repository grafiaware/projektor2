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
                $context['nadpis'] = $sessionStatus->projekt->kod.'  PROJEKT DOSUD NEBYL PLNĚ NASTAVEN';
                $context['src'] = "logo_Projektu.png";
                $context['alt'] = "Logo projektu dosud nebylo zadáno.";
                break;
        }
        return $context;
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
           ######## CKP #################
            case 'CKP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Cesta k práci“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Cesta k práci“ ";
                $texts['financovan'] = "\n";
                break;
           ######## PKP #################
            case 'PKP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Cesta k práci“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Cesta k práci“ ";
                $texts['financovan'] = "\n";
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
            case 'CKP':
            case 'PKP':
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
            case 'CKP':
            case 'PKP':
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
            case 'CKP':
            case 'PKP':
                // jedno pozadí
                $filePath = "img/pozadi/pozadi_osvedceni_pms.png";   // parte rámeček
                break;
            default:
                throw new UnexpectedValueException('Není definován soubor s obrázkem na pozadí pro certifikát v projektu '.$sessionStatus->projekt->kod.'.');
        }
        return $filePath;
    }

    /**
     * Volá se v Projektor2_Model_File_CertifikatKurzMapper
     *
     * @param type $certificateVersion
     * @return string
     * @throws UnexpectedValueException
     */
    public static function getCertificateVersionFolder($certificateVersion) {
//        switch ($sessionStatus->projekt->kod) {
        switch ($certificateVersion) {
            case 'original':
                // jedno pozadí
                $filePath = "certifikaty_kurz/";   // pro Grafii original
                break;
            case 'pseudokopie':
                // jedno pozadí
                $filePath = "certifikaty_kurz_pseudokopie/";   // pro Grafii pseudokopie
                break;
            case 'monitoring':
                // jedno pozadí
                $filePath = "certifikaty_kurz_pro_monitoring/";   // pro up
                break;
            default:
                throw new UnexpectedValueException('neznámá verze certifikátu. Verze: '.$certificateVersion);
        }
        return $filePath;
    }

    /**
     * Vrací řetězec identifikátoru certifikátu. Ve formátu PR/čtyřmístné číslo roku/ctyřmístné pořadové číslo certifikátu, např: PR/2015/0012
     * @param type $rok
     * @param type $cislo
     * @return type
     */
    public static function getCertificateKurzIdentificator($certifikatRada, $rok, $cislo) {
        if (trim($rok)<="2014") {
            return $rok.'/'.$cislo;            // v roce 2014 byla první várka očíslována takto, dodržuji tedy číslování 2014
        } else {
            switch ($certifikatRada) {
                case 'PR':
                    $certIdentifikator = sprintf("PR/%04d/%04d", $rok, $cislo);     // projektový certifikát
                    break;
                case 'MO':
                    $certIdentifikator = sprintf("MO/%04d/%04d", $rok, $cislo);     // certifikát pro monitoring
                    break;
                case 'RK':
                    $certIdentifikator = sprintf("RKP/%04d/%04d", $rok, $cislo);     // certifikát pro čistou rekvalifikaci
                    break;
                case 'PrK':
                    $certIdentifikator = sprintf("PRKP/%04d/%04d", $rok, $cislo);     // potvrzení účasti pro profesní kvalifikaci
                    break;
                default:
                    throw new UnexpectedValueException('Neznámá řada certifikátu pro generování identifikátoru. Řada: '.$certifikatRada);
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
        return $_SERVER['DOCUMENT_ROOT'].'/'.self::getFileSubfolder();
    }

    public static function getHttpFileBasePath() {
        return 'http://'.$_SERVER['HTTP_HOST'].'/'.self::getFileSubfolder();
    }

    /**
     * Relativní cesta ke složce pro ukládání (a download pomocí http) souborů.
     * @return string
     */
    private static function getFileSubfolder() {
        return '_ExportProjektor/';
    }

    /**
     * Vrací cestu ke kořenovému adresáři pro ukládání souborů (zejména pro file mappery)
     * @param type $kod
     * @return type
     * @throws UnexpectedValueException
     */
    public static function getRelativeFilePath($kod=NULL) {
                switch ($kod) {
            case 'AP':
            case 'HELP':
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
            case 'CKP':
            case 'PKP':
                return "$kod/";
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
        ######## CKP PKP #################
            case 'CKP':
            case 'PKP':
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