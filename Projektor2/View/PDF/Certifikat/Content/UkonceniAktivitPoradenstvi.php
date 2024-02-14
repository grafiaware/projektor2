<?php
use Pdf\Model\Block;
use Pdf\Renderer\Renderer;

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
    public static function prepareHeaderFooter(
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,             
            $context, 
            $cislovani=TRUE
        ) {
    }
    public static function createContent(
//            Renderer $pdf, 
//            Projektor2_Model_Status $sessionStatus,            
//            Projektor2_Model_Db_SKurz $sKurz, 
//            Projektor2_Model_Db_CertifikatKurz $certifikat,                      
//            $context, 
//            $caller)            
            $pdf, $context, $caller, $dolniokrajAPaticka, $mistoDatumPodpisy) {
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
