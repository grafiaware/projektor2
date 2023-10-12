<?php
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
class Projektor2_View_PDF_Certifikat_Content_UkonceniAktivitPoradenstvi extends Projektor2_View_PDF_Certifikat_Content_Base {

    public static function createContent($pdf, $context, $caller, $dolniokrajAPaticka, $mistoDatumPodpisy) {
        $count = count($context['aktivityProjektuTypuPoradenstvi']);
        if ($count) {
            $counter = 0;
            foreach($context['aktivityProjektuTypuPoradenstvi'] as $indexAktivity=>$aktivita) {
//                    $kurzPlan = new Projektor2_Model_KurzPlan();
                if ($context[$caller::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']) {
                    $counter++;
                    $yPositionBefore = $pdf->getY();  

                    $vyhodnoceni=new Block();
                    $vyhodnoceni->Nadpis($aktivita['nadpis']);
                    $vyhodnoceni->vyskaPismaNadpisu(11);
                    $vyhodnoceni->Odstavec($context[$caller::MODEL_UKONCENI.'vyhodnoceni']);                        
                    $vyhodnoceni->PridejOdstavec($context[$caller::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']);
                    $pdf->renderBlock($vyhodnoceni);

                    if ($counter == $count-1) {
                        $potrebneMisto = $dolniokrajAPaticka+$mistoDatumPodpisy;                        
                    } else {
                        $potrebneMisto = $dolniokrajAPaticka;
                    }
                    if (($pdf->h - $potrebneMisto - $pdf->getY()) < ($pdf->getY() - $yPositionBefore)) {
                        $pdf->AddPage();
                    }                        
                }               
            }
            if (!$counter) {
                $bezAktivit = new Block();
                $bezAktivit->Odstavec("Účastníkovi nebyly naplánovány žádné aktivity.");
                $pdf->renderBlock($bezAktivit);  
            }                
        } else {
            $bezAktivit = new Block();
            $bezAktivit->Odstavec("V projektu nelze plánovat žádné aktivity.");
            $pdf->renderBlock($bezAktivit);                      
        }        
        
}
    
}
