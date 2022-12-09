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
class Projektor2_View_PDF_Helper_KurzOsvedceni extends Projektor2_View_PDF_Helper_Base {

    public static function createContent($pdf, $context, $caller, $radkovani=1) {
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
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis("CERTIFIKÁT");
            $blok->PridejOdstavec('č. '.$context['certifikat']->identifikator);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered28_13;
            $blok->PridejOdstavec('o absolutoriu kurzu');
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis($context['sKurz']->kurz_nazev);
            $blok->PridejOdstavec($context['v_projektu']);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec($context['financovan']);
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis(self::celeJmeno($context[$caller::MODEL_DOTAZNIK]));
        $pdf->TiskniBlok($blok);

        $blok = clone $blokCentered28_13;
        if ($context[$caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'pohlavi'] == 'muž') {
            $abs = 'absolvoval';
        } else {
            $abs = 'absolvovala';
        }

        if ($context['sKurz']->date_zacatek AND $context['sKurz']->date_konec){
            if ($context['sKurz']->date_zacatek == $context['sKurz']->date_konec) {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz dne '.self::datumBezNul($context['sKurz']->date_zacatek));
            } else {
                $blok->PridejOdstavec('úspěšně '.$abs.' kurz od '.self::datumBezNul($context['sKurz']->date_zacatek)
                                        .' do '.self::datumBezNul($context['sKurz']->date_konec));
            }
        } else {
            $blok->PridejOdstavec('úspěšně '.$abs.' kurz');
        }

        if ($context['sKurz']->pocet_hodin) {
            $blok->PridejOdstavec('s plánovaným rozsahem '.$context['sKurz']->pocet_hodin.' hodin');
        }
        $pdf->TiskniBlok($blok);

//        $blok->PridejOdstavec('v rozsahu '.$context[$caller::MODEL_PLAN .$druh.'_poc_abs_hodin'].' hodin');
        $blok = clone $blokCentered20_11;
        if ($context['sKurz']->kurz_obsah) {
            $blok->PridejOdstavec('Obsah kurzu: ');
            $odstavceObsah = explode('\r\n', $context['sKurz']->kurz_obsah);
            foreach ($odstavceObsah as $bodObsahu) {
                $blok->PridejOdstavec($bodObsahu);
            }
        }
        $pdf->TiskniBlok($blok);

        }

}
