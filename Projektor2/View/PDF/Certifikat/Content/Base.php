<?php
/**
 * Description of Base
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Certifikat_Content_Base {
    // formát řetězce obsahujícího datum pro MySQL, shodný s formátem dle RFC3339
    const SQL_FORMAT = "Y-m-d";
    const CS_FORMAT = "d.m.Y";
    const CS_FORMAT_BEZ_NUL = "j. n. Y";
    
    public static function createHeaderFooter(
            Projektor2_Model_Db_Projekt $projekt, 
            Projektor2_Model_Db_SKurz $sKurz, 
            $textPaticky=NULL, 
            $cislovani=TRUE
        ) {
        switch ($projekt->kod) {
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
                $texts = Config_Certificates::getCertificateTexts($this->sessionStatus);
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
    
    protected static function completeHeader($logoFileName=NULL, $x, $y, $sirka, $vyska, $zarovnani='C' ) {
        $pdfhlavicka = Projektor2_PDF_Factory::getHlavicka();
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
        $pdfpaticka = Projektor2_PDF_Factory::getPaticka();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = $cislovani;
        $pdfpaticka->OdsazeniDole(13);
    }
    
    protected static function celeJmeno(Projektor2_Model_Db_Flat_ZaFlatTable $modelSmlouva) {   //--vs
        $celeJmeno = $modelSmlouva->titul." ".$modelSmlouva->jmeno." ".$modelSmlouva->prijmeni;
        if ($modelSmlouva->titul_za) {
            $celeJmeno = $celeJmeno.", ".$modelSmlouva->titul_za;
        }
        return $celeJmeno;
    }

    protected static function celaAdresa($ulice='', $mesto='', $psc='') {
        if ($ulice) {
            $celaAdresa .= $ulice;
            if  ($mesto) {
                $celaAdresa .=  ", ".$mesto;
            }
            if  ($psc) {
                $celaAdresa .= ", ".$psc;
            }
        } else {
            if  ($mesto)  {
                $celaAdresa .= $mesto;
                if  ($psc) {
                    $celaAdresa .= ", " .$psc;
                }
            } else {
                if  ($psc) {
                    $celaAdresa .= $psc;
                }
            }
        }
        return $celaAdresa;
    }

    protected static function datumBezNul($datum) {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $datum);
        if($datum==false) {
            $datum = DateTime::createFromFormat(self::CS_FORMAT, $datum);
        }
        return $datum->format(self::CS_FORMAT_BEZ_NUL);
    }

}
