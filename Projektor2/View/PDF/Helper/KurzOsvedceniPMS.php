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
class Projektor2_View_PDF_Helper_KurzOsvedceniPMS extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller) {
        $pdf->SetXY(0,45);

        $blokCentered = new Projektor2_PDF_Blok;
            $blokCentered->Font('Arial');
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
        $blokCentered40_14 = clone $blokCentered;
            $blokCentered40_14->VyskaPismaNadpisu(40);
            $blokCentered40_14->VyskaPismaTextu(14);
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);

        $blokLeft = new Projektor2_PDF_Blok;
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
        $pdf->TiskniBlok($blok);

        $pdf->Ln(15);

        $blok = clone $blokCentered40_14;
            $blok->Nadpis("OSVĚDČENÍ");
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis('Jméno a příjmení: '.self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
            $blok->PridejOdstavec('Datum narození: '.self::datumBezNul($context[$caller::MODEL_DOTAZNIK]->datum_narozeni));
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
                $abs = 'absolvoval';
            } else {
                $abs = 'absolvovala';
            }
            $blok->PridejOdstavec($abs);
            if ($context['sKurz']->date_konec){
                $blok->PridejOdstavec('dne '.self::datumBezNul($context['sKurz']->date_konec));
            }
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec(strtolower($context['sKurz']->nadpis));
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis('Poradenský program');
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Nadpis($context['sKurz']->kurz_nazev);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            $blok->PridejOdstavec('v rozsahu '.$context['sKurz']->pocet_hodin.' vyučovacích hodin');
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->Style('I');
            if ($context['sKurz']->date_zacatek == $context['sKurz']->date_konec) {
                $blok->PridejOdstavec('Termín poradenského programu: '.self::datumBezNul($context['sKurz']->date_zacatek));
            } else {
                $blok->PridejOdstavec('Termín poradenského programu: '.self::datumBezNul($context['sKurz']->date_zacatek)
                                        .' - '.self::datumBezNul($context['sKurz']->date_konec));
            }
            $blok->PridejOdstavec('Obsah poradenského programu: '.$context['sKurz']->kurz_obsah);
        $pdf->TiskniBlok($blok);

}

}
