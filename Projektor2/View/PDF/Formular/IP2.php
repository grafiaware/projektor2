<?php


/**
*
*
* @author pes2704
*/
class Projektor2_View_PDF_Formular_IP2 extends Projektor2_View_PDF_Common {
        
    public function createPDFObject() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $signUkonceni = Projektor2_Controller_Formular_FlatTable::UKONC_FT;
        $prefixUkonceni = $signUkonceni.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        
        $textPaticky = "Individuální plán účastníka v projektu „{$this->sessionStatus->getUserStatus()->getProjekt()->text}“ - část 2 - vyhodnocení aktivit  ".$this->context["file"];
        $this->createHeaderFooter($this->sessionStatus->getUserStatus()->getProjekt(), $textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 2 - vyhodnocení aktivit";
        $textyNadpisu[] = "Projekt „{$this->sessionStatus->getUserStatus()->getProjekt()->text}“";
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************
        $this->tiskniOsobniUdaje();  // osobní údaje z dotaznik 
        //********************************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");
            $blok->PridejOdstavec("Druhá část IP obsahuje vyhodnocení účasti klienta v projektu členěné podle absolvovaných aktivit a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdfCreator->renderBlock($blok);
        //##################################################################################################
        $aktivity = Config_Aktivity::getAktivityProjektu('SJZP');
            $blok = new Projektor2_PDF_Blok;
                $blok->Nadpis("Individuální plán projektu členěný podle absolvovaných aktivit");
                $blok->predsazeni(0);
                $blok->odsazeniZleva(0);
            $this->pdfCreator->renderBlock($blok);
            $dolniokrajAPaticka = 25;
            $mistoDatumPodpisy = 60;
            Projektor2_View_PDF_Certifikat_Content_UkonceniAktivitKurz::createContent($this->pdfCreator, $this->context, $dolniokrajAPaticka, $mistoDatumPodpisy);
        //##################################################################################################
        $this->tiskniMistoDatum($this->context[$signUkonceni][$prefixUkonceni . "datum_vytvor_dok_ukonc"]);
        $this->tiskniPodpisy($signDotaznik);
        return $this->pdfCreator;
    }
}

?>
