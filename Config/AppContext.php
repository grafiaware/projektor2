<?php
/**
 * Kontejner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Config_AppContext
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
//                        $dbh = new Framework_Database_HandlerSqlMysql_Localhost($dbName, $user, $pass, $dbHost, $dbPort, $charset);
//                        $dbh = new Framework_Database_HandlerSqlMysql("projektor_2", "root", "spravce", "neon");
                        $dbh = new Framework_Database_HandlerSqlMysql("projektor_2_cjc", "root", "spravce", "neon");
                    } else {
//                        $dbh = new Framework_Database_HandlerSqlMysql("projektor_2", "root", "spravce", "localhost");
                        $dbh = new Framework_Database_HandlerSqlMysql("projektor_2_cjc", "root", "spravce", "localhost");
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
     * Informuje, zda skript běží v režimu extenzivního zobrazení dat.
     * @return boolean
     */
    public static function isVerboseMode() {
        return false ? true : false;
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
    public static function getLogoContext(Projektor2_Model_Status $sessionStatus) {
        $context = array();
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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
                $context['nadpis'] = $sessionStatus->getUserStatus()->getProjekt()->kod.'  PROJEKT DOSUD NEBYL PLNĚ NASTAVEN';
                $context['src'] = "logo_Projektu.png";
                $context['alt'] = "Logo projektu dosud nebylo zadáno.";
                break;
        }
        return $context;
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
}