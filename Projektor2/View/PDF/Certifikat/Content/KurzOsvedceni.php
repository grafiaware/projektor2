<?php
use Pdf\Renderer\Renderer;
use Pdf\Model\Block;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KurzOsvedceni
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Certifikat_Content_KurzOsvedceni extends Projektor2_View_PDF_Certifikat_Content_Base {
    
    public static function prepareHeaderFooter(
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,             
            $context, 
            $cislovani=TRUE
        ) {
        $texts = Config_Certificates::getCertificateTexts($sessionStatus);
        $filepath = $context['file'] ?? '';
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                self::completeHeader( "./img/loga/loga_AP_BW.png", 0, 5, 165,14 );
                self::completeFooter( "{$texts['text_paticky']} $filepath"
                                    . "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'AGP':
                self::completeHeader( "./img/loga/logo_agp_bw.png", 0, 5, 165,26 );
                self::completeFooter( "{$texts['text_paticky']} $filepath" , $cislovani);
                break;
            case 'HELP':
                self::completeHeader("./img/loga/loga_HELP50+_BW.png", 0, 5, 165,11);
                self::completeFooter( "{$texts['text_paticky']} $filepath"
                                    . "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'SJZP':
                self::completeHeader("./img/loga/loga_OPLZZ_BW.jpg", 0, 5, 125,18);
                self::completeFooter( "{$texts['text_paticky']} $filepath"
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
//                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 0, 5, 110, 16, 'L');
                self::completeHeader("./img/loga/loga_OP_Z&UP_BW_2023_09.jpg", 0, 5, 110, 16, 'L');
                self::completeFooter( "{$texts['text_paticky']} $filepath", $cislovani);
                break;
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                self::completeHeader("./img/loga/logo_OPZ.png", 0, 5, 60, 22, 'L');
                self::completeFooter( "{$texts['text_paticky']} $filepath" . $texts['financovan'], $cislovani);
                break;
            case 'CJC':
                // nez proj. loga - akreditované kurzy
//                self::completeHeader( "./img/loga/logo_CJC_BW.png", 0, 5, 165,26 );
                self::completeFooter( "{$texts['text_paticky']} $filepath" , $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
        }
    }
    
    public static function createContent(
            Renderer $pdf, 
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat, 
            $context, 
            $caller, 
            $radkovani=1            
            ) {
            
        $sKurz = $aktivitaPlan->sKurz;
        // background
        $odsazeniPozadiShora = 28;
        $vyskaObrazku = 287;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $pdf->Image(Config_Certificates::getCertificateoriginalBackgroundImageFilepath($sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);

        // content
        $pdf->SetXY(0,60);
        $blokCentered = new \Pdf\Model\Block();
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
            $blokCentered->Radkovani($radkovani);
        $blokCentered28_13 = clone $blokCentered;
            $blokCentered28_13->VyskaPismaNadpisu(28);
            $blokCentered28_13->VyskaPismaTextu(13);
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
        $blokLeftMargin = new Block;
            $blokLeftMargin->ZarovnaniNadpisu('L');
            $blokLeftMargin->ZarovnaniTextu('L');
            $blokLeftMargin->Radkovani($radkovani);
        $blokLeftMargin28_13 = clone $blokLeftMargin;
            $blokLeftMargin28_13->VyskaPismaNadpisu(28);
            $blokLeftMargin28_13->VyskaPismaTextu(13);
        $blokLeftMargin20_11 = clone $blokLeftMargin;
            $blokLeftMargin20_11->VyskaPismaNadpisu(20);
            $blokLeftMargin20_11->VyskaPismaTextu(11);

        /** @var Block $blok */

        $blok = clone $blokCentered28_13;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň');
            $blok->PridejOdstavec('IČ: 477 14 620');
            $blok->PridejOdstavec('');
            $blok->PridejOdstavec('uděluje');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis("CERTIFIKÁT");
            $blok->PridejOdstavec('č. '.$certifikat->identifikator);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->PridejOdstavec('o absolutoriu kurzu');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis($sKurz->kurz_nazev);
            $blok->PridejOdstavec($context['v_projektu']);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec($context['financovan']);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis(self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
        if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
            $abs = 'absolvoval';
        } else {
            $abs = 'absolvovala';
        }

        if ($aktivitaPlan->datumZacatkuReal AND $aktivitaPlan->datumKonceReal){
            if ($aktivitaPlan->datumZacatkuReal == $aktivitaPlan->datumKonceReal) {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz dne '.self::datumBezNul($aktivitaPlan->datumZacatkuReal));
            } else {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz od '.self::datumBezNul($aktivitaPlan->datumZacatkuReal)
                                        .' do '.self::datumBezNul($aktivitaPlan->datumKonceReal));
            }
        } else {
            $blok->PridejOdstavec('úspěšně '.$abs.' kurz');
        }

        if ($sKurz->pocet_hodin) {
            $blok->PridejOdstavec('s plánovaným rozsahem '.$sKurz->pocet_hodin.' hodin');
        }
        $pdf->renderBlock($blok);

//        $blok->PridejOdstavec('v rozsahu '.$context[$caller::MODEL_PLAN .$druh.'_poc_abs_hodin'].' hodin');
        $blok = clone $blokCentered20_11;
        if ($sKurz->kurz_obsah) {
            $blok->PridejOdstavec('Obsah kurzu: ');
            $odstavceObsah = explode('\r\n', $sKurz->kurz_obsah);
            foreach ($odstavceObsah as $bodObsahu) {
                $blok->PridejOdstavec($bodObsahu);
            }
        }
        $pdf->renderBlock($blok);

        }

}
