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
class Projektor2_View_PDF_Certifikat_Content_KurzOsvedceni extends Projektor2_View_PDF_Certifikat_Content_Base {
    
    public static function createContent(
            Projektor2_PDF_PdfCreator $pdf, 
            Projektor2_Model_Db_SKurz $sKurz, 
            Projektor2_Model_Db_CertifikatKurz $certifikat, 
            $context, 
            $caller, 
            $radkovani=1) {
        // background
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
            $blokCentered->Radkovani($radkovani);
        $blokCentered28_13 = clone $blokCentered;
            $blokCentered28_13->VyskaPismaNadpisu(28);
            $blokCentered28_13->VyskaPismaTextu(13);
            $blokCentered28_13->ZarovnaniTextu('C');
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
            $blokCentered20_11->ZarovnaniTextu('C');


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

        if ($sKurz->date_zacatek AND $sKurz->date_konec){
            if ($sKurz->date_zacatek == $sKurz->date_konec) {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz dne '.self::datumBezNul($sKurz->date_zacatek));
            } else {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz od '.self::datumBezNul($sKurz->date_zacatek)
                                        .' do '.self::datumBezNul($sKurz->date_konec));
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
