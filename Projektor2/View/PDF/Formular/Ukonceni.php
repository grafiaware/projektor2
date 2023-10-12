<?php
use Pdf\Model\Block;
use Pdf\Model\SadaBunek;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Formular_Ukonceni extends Projektor2_View_PDF_Common {
    const MODEL_UKONCENI = "ukonceni->";
    const MODEL_DOTAZNIK = "dotaznik->";

    public function createPDFObject() {
        $nazevProjektu = '„Moje budoucnost“';
        $textPaticky = "Ukončení účasti účastníka v projektu $nazevProjektu ".$this->context["file"];
        $this->createHeaderFooter($this->sessionStatus->getUserStatus()->getProjekt(), $textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "UKONČENÍ ÚČASTI V PROJEKTU";
        $textyNadpisu[] = 'Projekt „Moje budoucnost“';
        $this->tiskniTitul($textyNadpisu, TRUE);
        //*****************************************************
        $this->tiskniOsobniUdaje();
        //**********************************************
        $blok = new Block;
            $blok->Nadpis("Ukončení účasti v projektu");
            $blok->PridejOdstavec("Účastník ukončil účast v projektu $nazevProjektu z dále uvedeného důvodu. "
                    . "Ke dni ukončení účasti skončila účinnost Dohody o účasti v projektu $nazevProjektu.");
            $blok->PridejOdstavec("Účastník bere na vědomí, že dle podmínek projektu byl povinen nejpozději ke dni ukončení účasti v projektu dodat veškeré doklady k přímé podpoře "
                    . "a dále pak do 3 pracovních dnů od ukončení účasti v projektu veškeré doklady k důvodům neúčasti na aktivitách projektu (např. omluvenky) "
                    . "a dále pak k ukončení účasti v projektu (např. kopii pracovní smlouvy).");
        $this->pdfRenderer->renderBlock($blok);
        $ukonceniUcasti = new SadaBunek();
            $ukonceniUcasti->Nadpis("Údaje o účasti v projektu");
    //    	$ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$pdfpole["datum_reg"]);
            $ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$this->context[self::MODEL_DOTAZNIK  . "datum_vytvor_smlouvy"]);
            $ukonceniUcasti->PridejBunku(" Datum ukončení účasti v projektu: ", @$this->context[self::MODEL_UKONCENI . 'datum_ukonceni'], 1);

            $duvod_ukonceni_pole =  explode ("|", @$this->context[self::MODEL_UKONCENI . 'duvod_ukonceni']);
            $ukonceniUcasti->PridejBunku("Důvod ukončení účasti v projektu: ", $duvod_ukonceni_pole[0],1);
            if ( ($duvod_ukonceni_pole[0] == "2b ") or ($duvod_ukonceni_pole[0]== "3a ")  or ($duvod_ukonceni_pole[0] == "3b ")
                  and @$this->context[self::MODEL_UKONCENI . 'popis_ukonceni']
                ) {
                $ukonceniUcasti->PridejBunku("Podrobnější popis důvodu ukončení účasti v projektu: ", " " ,1);
                $ukonceniUcastiPopis = new Block;
                $ukonceniUcastiPopis->Odstavec( @$this->context[self::MODEL_UKONCENI . 'popis_ukonceni']);
            }
        $this->pdfRenderer->renderCellGroup($ukonceniUcasti);
        if ($ukonceniUcastiPopis) $this->pdfRenderer->renderBlock($ukonceniUcastiPopis);
        $pozn = new Block;
            $pozn->Nadpis("Možné důvody:");
            $pozn->Odstavec("1. řádné absolvování projektu");
            $pozn->PridejOdstavec("2. předčasným ukončením účasti ze strany klienta");
            $pozn->VyskaPismaNadpisu(8);
            $pozn->VyskaPismaTextu(8);
        $this->pdfRenderer->renderBlock($pozn);
        $pozn = new Block;
            $pozn->Odstavec("a. dnem předcházejícím nástupu klienta do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)");
            $pozn->PridejOdstavec("b. výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude v den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdfRenderer->renderBlock($pozn);
        $pozn = new Block;
            $pozn->Odstavec("3. předčasným ukončením účasti ze strany dodavatele");
            $pozn->VyskaPismaTextu(8);
        $this->pdfRenderer->renderBlock($pozn);
        $pozn = new Block;
            $pozn->Odstavec("a. pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu");
            $pozn->PridejOdstavec("b. ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdfRenderer->renderBlock($pozn);

        //##################################################################################################
//        $this->tiskniMistoDatum($this->context[self::MODEL_UKONCENI."datum_vytvor_dok_ukonc"]);
        $this->tiskniMistoDatum($this->context[Projektor2_Controller_Formular_FlatTable::UKONC_FT][Projektor2_Controller_Formular_FlatTable::UKONC_FT.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR."datum_vytvor_dok_ukonc"]);
        $this->tiskniPodpisy();
    }
}
