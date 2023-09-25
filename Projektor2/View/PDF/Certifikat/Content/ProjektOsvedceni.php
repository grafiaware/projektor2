<?php

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
class Projektor2_View_PDF_Certifikat_Content_ProjektOsvedceni extends Projektor2_View_PDF_Certifikat_Content_Base {

    public static function createContent(\Projektor2_PDF_PdfCreator $pdf, $context, $caller) {
        /** @var Projektor2_Model_Db_SKurz $sKurz */
        $sKurz = $context['sKurz'];
        
        // pozadí
        $odsazeniPozadiShora = 28;
        $vyskaObrazku = 287;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $pdf->Image(Config_Certificates::getCertificateoriginalBackgroundImageFilepath($this->sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);
        
        // content
        $pdf->SetXY(0,60);

        $blokCentered = new Projektor2_PDF_Blok;
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
        $blokCentered30_14 = clone $blokCentered;
            $blokCentered30_14->VyskaPismaNadpisu(30);
            $blokCentered30_14->VyskaPismaTextu(14);
            $blokCentered30_14->ZarovnaniTextu('C');
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
            $blokCentered20_11->ZarovnaniTextu('C');           
        
        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň');
            $blok->PridejOdstavec('IČ: 477 14 620');
            $blok->PridejOdstavec('');
            $blok->PridejOdstavec('uděluje');
        $pdf->renderBlock($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->Nadpis("CERTIFIKÁT");
            $blok->PridejOdstavec('č. '.$context['certifikat']->identifikator);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('o absolutoriu projektu');
        $pdf->renderBlock($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec($context['v_projektu']);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec($context['financovan']);
        $pdf->renderBlock($blok);  
        
        
        
        
        // jméno
        $blok = clone $blokCentered30_14;
            $blok->Nadpis(self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered30_14;
        if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
            $abs = 'absolvoval';
        } else {
            $abs = 'absolvovala';            
        }
        
        $blok->PridejOdstavec('úspěšně '.$abs.' projekt');
        $pdf->Ln(20);
//        $blok->PridejOdstavec('v rozsahu '.$context[$caller::MODEL_PLAN .$druh.'_poc_abs_hodin'].' hodin');
        $pdf->renderBlock($blok);        
                   
        
        
        
}
    
}
