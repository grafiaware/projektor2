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
class Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniMonitoring extends Projektor2_View_PDF_Certifikat_Content_Base {
    
    public static function prepareHeaderFooter(
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Model_Db_SKurz $sKurz, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,             
            $context, 
            $cislovani=TRUE
        ) {
        switch ($sessionStatus->getUserStatus()->getProjekt()->kod) {

            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 5, 15, 110, 16, 'L');
                self::completeFooter( $textPaticky, $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
                break;
        }
    }
    
    public static function createContent(
            Renderer $pdf, 
            Projektor2_Model_Status $sessionStatus,                        
            Projektor2_Model_Db_SKurz $sKurz, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,   // v minitorg certifikátu nepoužit
            $context, 
            $caller, 
            $radkovani=1) {
        
        // background
        $odsazeniPozadiShora = 0;
        $vyskaObrazku = 297;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $pdf->Image(Config_Certificates::getCertificatePmsBackgroundImageFilepath($sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);
        
        // content
        $pdf->SetXY(0,45);

        $blokCentered = new Block;
            $blokCentered->Font('Arial');
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
        $blokCentered40_14 = clone $blokCentered;
            $blokCentered40_14->VyskaPismaNadpisu(40);
            $blokCentered40_14->VyskaPismaTextu(14);
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);

        $blokLeft = new Block;
            $blokLeft->Font('Arial');
            $blokLeft->OdsazeniZleva(10);
            $blokLeft->ZarovnaniNadpisu('L');
            $blokLeft->ZarovnaniTextu('L');
        $blokLeft20_11 = clone $blokLeft;
            $blokLeft20_11->VyskaPismaNadpisu(20);
            $blokLeft20_11->VyskaPismaTextu(11);


        $blok = clone $blokLeft20_11;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň');
            $blok->PridejOdstavec('IČ: 477 14 620');
        $pdf->renderBlock($blok);

        $pdf->Ln(15);

        $blok = clone $blokCentered40_14;
            $blok->Nadpis("OSVĚDČENÍ");
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis('Jméno a příjmení: '.self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
            $blok->PridejOdstavec('Datum narození: '.self::datumBezNul($context[$caller::MODEL_DOTAZNIK]->datum_narozeni));
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
                $abs = 'absolvoval';
            } else {
                $abs = 'absolvovala';
            }
            $blok->PridejOdstavec($abs);
            if ($sKurz->date_konec){
                $blok->PridejOdstavec('dne '.self::datumBezNul($sKurz->date_konec));
            }
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec(strtolower($sKurz->nadpis));
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis('Poradenský program');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis($sKurz->kurz_nazev);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            $blok->PridejOdstavec('v rozsahu '.$sKurz->pocet_hodin.' vyučovacích hodin');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            if ($sKurz->date_zacatek == $sKurz->date_konec) {
                $blok->PridejOdstavec('Termín poradenského programu: '.self::datumBezNul($sKurz->date_zacatek));
            } else {
                $blok->PridejOdstavec('Termín poradenského programu: '.self::datumBezNul($sKurz->date_zacatek)
                                        .' - '.self::datumBezNul($sKurz->date_konec));
            }
            $blok->PridejOdstavec('Obsah poradenského programu: '.$sKurz->kurz_obsah);
        $pdf->renderBlock($blok);

}

}
