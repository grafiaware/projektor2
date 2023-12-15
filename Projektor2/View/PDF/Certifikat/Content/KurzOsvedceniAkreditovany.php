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
class Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniAkreditovany extends Projektor2_View_PDF_Certifikat_Content_Base {
    
    public static function prepareHeaderFooter(
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,             
            $context, 
            $cislovani=TRUE
        ) {
        $texts = Config_Certificates::getCertificateTexts($sessionStatus);
        $filepath = $context['file'] ?? '';
        self::completeFooter( "{$texts['text_paticky']} $filepath" , $cislovani);

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
        $prefixDotaznik = $caller::MODEL_DOTAZNIK.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        // backgound
        $odsazeniPozadiShora = 8;
        $vyskaObrazku = 297;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $pdf->Image(Config_Certificates::getCertificateoriginalBackgroundImageFilepath($sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);
        
        // content
        // pod logo Grafia
        $pdf->SetXY(0,40);

        $blokCentered = new Block;
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
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň - Jižní předměstí');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->PridejOdstavec($sKurz->kurz_akreditace);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
            $blok->Nadpis("OSVĚDČENÍ O REKVALIFIKACI");
            $blok->PridejOdstavec('č. '.$certifikat->identifikator);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec(
                'po úspěšném ukončení vzdělávacího programu rekvalifikačního kurzu podle vyhlášky MŠMT č. 176/2009 Sb.,
                kterou se stanoví náležitosti žádosti o akreditaci vzdělávacího programu,
                organizace vzdělávání v rekvalifikačním zařízení a způsob jeho ukončení.');
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
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
        $pdf->renderBlock($blok);
        $blok = clone $blokCentered28_13;
        $blok->Nadpis($sKurz->kurz_nazev);
        //            $blok->PridejOdstavec($context['v_projektu']);
        $pdf->renderBlock($blok);

        $blok = clone $blokCentered28_13;
        $blok->PridejOdstavec('pro pracovní činnost: '.$sKurz->kurz_pracovni_cinnost);
        $pdf->renderBlock($blok);

        if ($sKurz->pocet_hodin) {
            $pdf->Ln(2);
            $blok = clone $blokLeftMargin28_13;
            $blok->OdsazeniZleva(45);
            if ($aktivitaPlan->datumZacatkuReal AND $aktivitaPlan->datumKonceReal){
                if ($aktivitaPlan->datumZacatkuReal == $aktivitaPlan->datumKonceReal) {
                    $blok->PridejOdstavec('Kurz proběhl dne '.self::datumBezNul($aktivitaPlan->datumZacatkuReal));
                } else {
                    $blok->PridejOdstavec('Kurz proběhl v období od '.self::datumBezNul($aktivitaPlan->datumZacatkuReal)
                                            .' do '.self::datumBezNul($aktivitaPlan->datumKonceReal));
                }
            }
            $blok->PridejOdstavec('v rozsahu');
            // vypisuji plánovaný rozsah kurzu, ne reál
            $blok->PridejOdstavec('  - na teorii '.$sKurz->pocet_hodin.' vyučovacích hodin');
            $blok->PridejOdstavec('  - z toho distanční formou '.$sKurz->pocet_hodin_distancne);
            $blok->PridejOdstavec('  - na praxi '.$sKurz->pocet_hodin_praxe.' hodin');
            $pdf->renderBlock($blok);
        }


        if ($sKurz->kurz_obsah) {
            $pdf->Ln(2);
            $blok = clone $blokLeftMargin20_11;
            $blok->OdsazeniZleva(45);
            $blok->PridejOdstavec('Vzdělávací program obsahoval tyto tématické celky:  Teorie/praxe');
            $odstavceObsah = explode('\r\n', $sKurz->kurz_obsah);
            foreach ($odstavceObsah as $bodObsahu) {
                $blok->PridejOdstavec($bodObsahu);
            }
            $pdf->renderBlock($blok);
        }
        $pdf->Ln(2);
        if ($sKurz->kurz_typ_kvalifikace=='čistá' AND $aktivitaPlan->datumZaverecneZkouskyReal) {  // jen pro typ kvalifikace čistá
            $blok = clone $blokCentered28_13;
            if ($context[$prefixDotaznik.'pohlavi'] == 'muž') {
                $jmeno = 'Jmenovaný vykonal';
            } else {
                $jmeno = 'Jmenovaná vykonala ';
            }
            $blok->PridejOdstavec("$jmeno úspěšně závěrečné zkoušky dne: ".self::datumBezNul($aktivitaPlan->datumZaverecneZkouskyReal));
            $pdf->renderBlock($blok);
        }
    }

}
