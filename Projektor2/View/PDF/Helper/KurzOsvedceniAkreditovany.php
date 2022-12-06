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
class Projektor2_View_PDF_Helper_KurzOsvedceniAkreditovany extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller, $radkovani=1) {

        $prefixDotaznik = $caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        // pod logo Grafia
        $pdf->SetXY(0,40);

        $blokCentered = new Projektor2_PDF_Blok;
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
            $blokCentered->Radkovani($radkovani);
        $blokCentered30_14 = clone $blokCentered;
            $blokCentered30_14->VyskaPismaNadpisu(30);
            $blokCentered30_14->VyskaPismaTextu(14);
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
        $blokLeftMargin = new Projektor2_PDF_Blok;
            $blokLeftMargin->ZarovnaniNadpisu('L');
            $blokLeftMargin->ZarovnaniTextu('L');
            $blokLeftMargin->Radkovani($radkovani);
        $blokLeftMargin30_14 = clone $blokLeftMargin;
            $blokLeftMargin30_14->VyskaPismaNadpisu(30);
            $blokLeftMargin30_14->VyskaPismaTextu(14);
        $blokLeftMargin20_11 = clone $blokLeftMargin;
            $blokLeftMargin20_11->VyskaPismaNadpisu(20);
            $blokLeftMargin20_11->VyskaPismaTextu(11);

        /** @var Projektor2_PDF_Blok $blok */

        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň - Jižní předměstí');
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec($context['sKurz']->kurz_akreditace);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
            $blok->Nadpis("OSVĚDČENÍ O REKVALIFIKACI");
            $blok->PridejOdstavec('č. '.$context['certifikat']->identifikator);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec(
                'po úspěšném ukončení vzdělávacího programu rekvalifikačního kurzu podle vyhlášky MŠMT č. 176/2009 Sb.,
                kterou se stanoví náležitosti žádosti o akreditaci vzdělávacího programu,
                organizace vzdělávání v rekvalifikačním zařízení a způsob jeho ukončení.');
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
            $blok->Nadpis(self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
            if ($context[$prefixDotaznik.'pohlavi'] == 'muž') {
                $naroz = 'narozen';
                $absol = 'absolvoval rekvalifikační program: ';
            } else {
                $naroz = 'narozena';
                $absol = 'absolvovala rekvalifikační program: ';
            }
            $blok->PridejOdstavec($naroz.' '.self::datumBezNul($context[$prefixDotaznik.'datum_narozeni'])." ".$context[$prefixDotaznik.'misto_narozeni']);
            $blok->PridejOdstavec($absol);
        $pdf->TiskniBlok($blok);
        $blok = clone $blokCentered30_14;
        $blok->Nadpis($context['sKurz']->kurz_nazev);
        //            $blok->PridejOdstavec($context['v_projektu']);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
        $blok->PridejOdstavec('pro pracovní činnost: '.$context['sKurz']->kurz_pracovni_cinnost);
        $pdf->TiskniBlok($blok);

        if ($context['sKurz']->pocet_hodin) {
            $pdf->Ln(2);
            $blok = clone $blokLeftMargin30_14;
            $blok->OdsazeniZleva(45);
            if ($context['sKurz']->date_zacatek AND $context['sKurz']->date_konec){
                if ($context['sKurz']->date_zacatek == $context['sKurz']->date_konec) {
                    $blok->PridejOdstavec('Kurz proběhl dne '.self::datumBezNul($context['sKurz']->date_zacatek));
                } else {
                    $blok->PridejOdstavec('Kurz proběhl v období od '.self::datumBezNul($context['sKurz']->date_zacatek)
                                            .' do '.self::datumBezNul($context['sKurz']->date_konec));
                }
            }
            $blok->PridejOdstavec('v rozsahu');
            $blok->PridejOdstavec('  - na teorii '.$context['sKurz']->pocet_hodin.' vyučovacích hodin');
            $blok->PridejOdstavec('  - z toho distanční formou '.$context['sKurz']->pocet_hodin_distancne);
            $blok->PridejOdstavec('  - na praxi '.$context['sKurz']->pocet_hodin_praxe.' hodin');
            $pdf->TiskniBlok($blok);
        }


        if ($context['sKurz']->kurz_obsah) {
            $pdf->Ln(2);
            $blok = clone $blokLeftMargin20_11;
            $blok->OdsazeniZleva(45);
            $blok->PridejOdstavec('Vzdělávací program obsahoval tyto tématické celky: ');
            $odstavceObsah = explode('\r\n', $context['sKurz']->kurz_obsah);
            foreach ($odstavceObsah as $bodObsahu) {
                $blok->PridejOdstavec($bodObsahu);
            }
            $pdf->TiskniBlok($blok);
        }

    }

}
