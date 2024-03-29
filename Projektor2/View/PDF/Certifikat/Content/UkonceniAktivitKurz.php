<?php
use Pdf\Model\Block;
use Pdf\Model\SadaBunek;
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
class Projektor2_View_PDF_Certifikat_Content_UkonceniAktivitKurz extends Projektor2_View_PDF_Certifikat_Content_Base {
    
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
            $context, $dolniokrajAPaticka, $mistoDatumPodpisy) {
        $signUkonceni = Projektor2_Controller_Formular_FlatTable::UKONC_FT;
        $prefixUkonceni = $signUkonceni.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        
        $count = count($context['aktivityPlan']);
        if ($count) {
            $counter = 0;
            foreach($context['aktivityPlan'] as $aktivita) {
//                    $kurzPlan = new Projektor2_Model_KurzPlan();
                if (isset($aktivita->sKurz) AND $aktivita->sKurz->isRealCourse()) {
                    $counter++;
                    $yPositionBefore = $pdf->getY(); 
                    $kurzSadaBunek = new SadaBunek();
                    $kurzSadaBunek->SpustSadu(true);
                    $kurzSadaBunek->Nadpis($aktivita->nadpisAktivity);
                    $kurzSadaBunek->MezeraPredNadpisem(4);
                    $kurzSadaBunek->ZarovnaniNadpisu("L");
                    $kurzSadaBunek->VyskaPismaNadpisu(11);
                    $kurzSadaBunek->MezeraPredSadouBunek(1);
//                        $kurzSadaBunek->PridejBunku("Název kurzu: ",$context[$druh.'_kurz']->kurz_nazev, 1);
//                        $kurzSadaBunek->PridejBunku("Termín konání: ",$context[$druh.'_kurz']->date_zacatek.' - '.$context[$druh.'_kurz']->date_konec, 1);
                    $kurzSadaBunek->PridejBunku("Název kurzu: ",$aktivita->sKurz->kurz_nazev, 1);
                    $kurzSadaBunek->PridejBunku("Termín konání: ", self::datumBezNul($aktivita->sKurz->date_zacatek).' - '.self::datumBezNul($aktivita->sKurz->date_konec), 1);
                    $kurzSadaBunek->PridejBunku("Počet absolvovaných hodin: ", $aktivita->pocAbsHodin,1);
                    if ($aktivita->duvodAbsence) {
                        $kurzSadaBunek->PridejBunku("Důvod absence: ", $aktivita->duvodAbsence, 1);
                    }
                    $kurzSadaBunek->PridejBunku("Dokončeno úspěšně: ", $aktivita->dokoncenoUspesne,1);
                    if ($aktivita->dokoncenoUspesne == "Ne") {
                        $kurzSadaBunek->PridejBunku("Důvod neúspěšného ukončení: ", $aktivita->duvodNeuspechu,1);
                    }
                    $pdf->renderCellGroup($kurzSadaBunek); 
                    if ($aktivita->dokoncenoUspesne == "Ano" AND $aktivita->aktivitaSCertifikatem) {
                        $vyhodnoceni = new Block();
                        $vyhodnoceni->Nadpis('Osvědčení o absolvování kurzu v projektu');
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec("Účastníkovi bylo vydáno osvědčení dne: ".self::datumBezNul($aktivita->datumCertif));
                        $pdf->renderBlock($vyhodnoceni);
                    }
                    if ($context[$prefixUkonceni.$aktivita->indexAktivity.'_hodnoceni']) {
                        $vyhodnoceni = new Block();
                        $vyhodnoceni->Nadpis('Hodnocení');
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec($context[$prefixUkonceni.$aktivita->indexAktivity.'_hodnoceni']);
                        $pdf->renderBlock($vyhodnoceni);
                    }                        
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
