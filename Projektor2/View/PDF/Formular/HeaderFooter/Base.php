<?php
use Pdf\Model\Factory;

/**
 * Description of Base
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Formular_HeaderFooter_Base {
    protected static function completeHeader($logoFileName=NULL, $x, $y, $sirka, $vyska, $zarovnani='C' ) {
        $pdfhlavicka = Factory::getHeaderModel();
        $pdfhlavicka->zarovnani($zarovnani);
        $pdfhlavicka->vyskaPisma(14);
        if (isset($logoFileName)) {
            if (is_readable($logoFileName)) {
                $pdfhlavicka->obrazek($logoFileName, $x, $y, $sirka, $vyska);
            } else {
                throw new UnexpectedValueException('Zadán neexistující soubor s obrázkem do hlavičky dokumentu: '.$logoFileName.'.');
            }
        }
    }
    
    protected static function completeFooter( $textPaticky=NULL, $cislovani=TRUE) {
        $pdfpaticka = Factory::getFooterModel();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = $cislovani;
        $pdfpaticka->OdsazeniDole(13);
    }
    
    public static function createHeaderFooter(Projektor2_Model_Status $sessionStatus, $textPaticky=NULL, $cislovani=TRUE) {
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                self::completeHeader( "./img/loga/loga_AP_BW.png", 0, 5, 165,14 );
                self::completeFooter( $textPaticky
                                    . "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'AGP':
                self::completeHeader( "./img/loga/logo_agp_bw.png", 0, 5, 165,26 );
                self::completeFooter( $textPaticky , $cislovani);
                break;
            case 'HELP':
                self::completeHeader("./img/loga/loga_HELP50+_BW.png", 0, 5, 165,11);
                self::completeFooter( $textPaticky
                                    . "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'SJZP':
                self::completeHeader("./img/loga/loga_OPLZZ_BW.jpg", 0, 5, 125,18);
                self::completeFooter( $textPaticky
                                    . "\n Projekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován "
                                    . "z ESF prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 0, 5, 110, 16, 'L');
                self::completeFooter( $textPaticky, $cislovani);
                break;
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                self::completeHeader("./img/loga/logo_OPZ.png", 0, 5, 60, 22, 'L');
                $texts = Config_Certificates::getCertificateTexts($sessionStatus);
                self::completeFooter( $textPaticky . $texts['financovan'], $cislovani);
                break;
            case 'CJC':
                // nez proj. loga - akreditované kurzy
//                self::completeHeader( "./img/loga/logo_CJC_BW.png", 0, 5, 165,26 );
                self::completeFooter( $textPaticky , $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
        }
    }    
}
