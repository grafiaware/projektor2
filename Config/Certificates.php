<?php
/**
 * Kontejner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Config_Certificates
{

############# CERTIFIKÁTY #############

    /**
     * Vrací pole s texty pro certifikáty
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getCertificateTexts(Projektor2_Model_Status $sessionStatus) {
        $texts = array();
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Karlovarském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Karlovarském kraji“ ";
                $texts['financovan'] = "\nProjekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
                break;
        ######## VZP #################
            case 'VZP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'administrator programu';
                $texts['v_projektu'] = 'v projektu „Vzdělávání a dovednosti pro trh práce II“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu Vykroč za prací projektu „Vzdělávání a dovednosti pro trh práce II“ ";
                $texts['financovan'] = "\nProjekt Vzdělávání a dovednosti pro trh práce II reg.č.CZ.03.1.48/0.0/0.0/15_121/0000597"
                        . "\nje spolufinancovaný z prostředků Evropského sociálního fondu, "
                        . "\nresp. Operačního programu Zaměstnanost a státního rozpočtu České republiky.";
                break;
         ######## SJZP PK KK #################
            case 'SJPK':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Plzeňském a Karlovarském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Plzeňském a Karlovarském kraji“ ";
                $texts['financovan'] = "\nProjekt S jazyky za prací v Plzeňském a Karlovarském kraji CZ.03.1.48/0.0/0.0/15_040/0002665 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
           ######## ZPM #################
            case 'ZPM':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Záruky pro mladé v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Záruky pro mladé v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Záruky pro mladé v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_004/0000006 je spolufinancován "
                                  . "z Evropského sociálního fondu prostřednictvím Operačního programu Zaměstnanost a ze státního rozpočtu České republiky.";
                break;
           ######## SPP #################
            case 'SPP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Šance pro padesátníky v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Šance pro padesátníky v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Šance pro padesátníky v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_010/0000035 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;

            ######## RP #################
            case 'RP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Rodina i práce v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Rodina i práce v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Rodina i práce v Plzeňském kraji CZ.03.1.48/0.0/0.0/15_010/0000036 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu České republiky.";
                break;
        ######## SJPO V PLZNI A OKOLÍ #################
            case 'SJPO':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Plzni a okolí“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Plzni a okolí“ ";
                $texts['financovan'] = "\nS jazyky za prací v Plzni a okolí CZ.03.1.48/0.0/0.0/16_045/0009267 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
        ######## SJLP PRO LEPŠÍ PRÁCI #################
            case 'SJLP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky pro lepší práci“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky pro lepší práci“ ";
                $texts['financovan'] = "\nS jazyky pro lepší práci CZ.03.1.48/0.0/0.0/17_075/0009252 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";
                break;
           ######## VDTP #################
            case 'VDTP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Vzdělávání a dovednosti pro trh práce II“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Vzdělávání a dovednosti pro trh práce II“ ";
                $texts['financovan'] = "\nProjekt Vzdělávání a dovednosti pro trh práce II CZ.03.1.48/0.0/0.0/15_121/0000597 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;
           ######## PDU #################
            case 'PDU':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání“ ";
                $texts['financovan'] = "\nProjekt Podpora zaměstnanosti dlouhodobě nezaměstnaných uchazečů o zaměstnání CZ.03.1.48/0.0/0.0/15_121/0010247 je spolufinancován "
                                    . "z Evropského sociálního fondu, konkrétně z Operačního programu Zaměstnanost, a státního rozpočtu ČR.";
                break;
        ######## MB MOJE BUDOUCNOST #################
            case 'MB':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „Moje budoucnost“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Moje budoucnost“ ";
                $texts['financovan'] = "\nProjekt Rozvoj nabídky služeb zaměstnosti Moje budoucnost CZ.03.1.48/0.0/0.0/16_045/0015019 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OPZ a ze státního rozpočtu ČR.";    // DOPLNIT
                break;
        ######## MB MOJE BUDOUCNOST #################
            case 'CJC':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Čeština pro cizince“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Čeština pro cizince“ ";
                $texts['financovan'] = "\n";    // DOPLNIT
                break;
           ######## CKP #################
            case 'CKP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Cesta k práci“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Cesta k práci“ ";
                $texts['financovan'] = "\n";
                break;
           ######## PKP #################
            case 'PKP':
                $texts['signerName'] = $sessionStatus->getUserStatus()->getUser()->name;
                $texts['signerPosition'] = 'pracovník sekce vzdělávání';
                $texts['v_projektu'] = 'v programu „Poradenství k podnikání“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v programu „Poradenství k podnikání“ ";
                $texts['financovan'] = "\n";
                break;
            default:
                throw new UnexpectedValueException('Nejsou definovány texty pro certifikát v projektu '.$kod.'.');
        }

            return $texts;
    }

    public static function getCertificateOriginalBackgroundImageFilepath(Projektor2_Model_Status $sessionStatus) {
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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
                throw new UnexpectedValueException('Není definován soubor s orázkem na pozadí pro certifikát v projektu '.$sessionStatus->getUserStatus()->getProjekt()->kod.'.');
        }
        return $filePath;
    }

    public static function getCertificatePseudocopyBackgroundImageFilepath(Projektor2_Model_Status $sessionStatus) {
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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
                throw new UnexpectedValueException('Není definován soubor s obrázkem na pozadí pro certifikát v projektu '.$sessionStatus->getUserStatus()->getProjekt()->kod.'.');
        }
        return $filePath;
    }

    public static function getCertificatePmsBackgroundImageFilepath(Projektor2_Model_Status $sessionStatus) {
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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
                throw new UnexpectedValueException('Není definován soubor s obrázkem na pozadí pro certifikát v projektu '.$sessionStatus->getUserStatus()->getProjekt()->kod.'.');
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
//        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
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

}