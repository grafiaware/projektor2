<?php

/*
* První část IP (v rozsahu 1-2 strany A4) – která bude obsahovat:
charakteristiku účastníka (klientovy nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o dalším pracovním zařazení atd.),
plán účasti v projektu (doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce, zjištění zájmu a doporučení pro eventuální zařazení do některého rekvalifikačního kurzu organizovaného a hrazeného mimo tento projekt, apod.).
První část IP je předběžný plán průběhu účasti v projektu, který se může během projektu vyvíjet, tento vývoj bude zachycen ve druhé části IP.
Druhou část IP zpracuje poradce s klientem při ukončení účasti v projektu. Tato část bude obsahovat:
vyhodnocení účasti klienta v projektu (případné změny oproti první části IP, shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem).
Obě části IP budou podepsány poradcem i klientem. Kopie IP budou předány spolu s měsíční zprávou o realizaci Zadavateli a také vysílajícímu KoP.

*/
/**
* Description of Projektor2_View_PDF_HelpPlanIP1
*
* @author pes2704
*/
class Projektor2_View_PDF_Formular_IP1 extends Projektor2_View_PDF_Common {
    const MODEL_DOTAZNIK = "dotaznik->";
    const MODEL_PLAN = "plan->";

    public function createPDFObject() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $signPlan = Projektor2_Controller_Formular_FlatTable::PLAN_FT;
        $prefixPlan = $signPlan.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;        
        
        
        $textPaticky = "Individuální plán účastníka v projektu „{$this->sessionStatus->getUserStatus()->getProjekt()->text}“ - část 1 - plán aktivit  ".$this->context["file"]; //!!
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 1 - plán aktivit";
        $textyNadpisu[] = "Projekt „{$this->sessionStatus->getUserStatus()->getProjekt()->text}“";
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************
        $this->tiskniOsobniUdaje();
        //********************************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");
            $blok->PridejOdstavec("Plán aktivit obsahuje plán konkrétních aktivit klienta v projektu členěný podle plánovaných aktivit.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);
        //##################################################################################################
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Individuální plán projektu členěný podle absolvovaných aktivit");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);

        $count = count($this->context['aktivityPlan']);
        $dolniokrajAPaticka = 25;
        $mistoDatumPodpisy = 60;
        if ($count) {
            $counter = 0;
            foreach($this->context['aktivityPlan'] as $aktivitaPlan) {
                /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
//                $kurzPlan = new Projektor2_Model_KurzPlan();
                if (isset($aktivitaPlan->sKurz) AND $aktivitaPlan->sKurz->isRealCourse()) {
                    $counter++;
                    $yPositionBefore = $this->pdf->getY();
                    $kurzSadaBunek = new Projektor2_PDF_SadaBunek();
                    $kurzSadaBunek->SpustSadu(true);
                    $kurzSadaBunek->Nadpis($aktivitaPlan->nadpisAktivity); // prohledaz podle kurz_druh
                    $kurzSadaBunek->MezeraPredNadpisem(0);
                    $kurzSadaBunek->ZarovnaniNadpisu("L");
                    $kurzSadaBunek->VyskaPismaNadpisu(11);
                    $kurzSadaBunek->MezeraPredSadouBunek(0);
                    $kurzSadaBunek->PridejBunku("Název kurzu: ",$aktivitaPlan->sKurz->kurz_nazev, 1);
                    $kurzSadaBunek->PridejBunku("Termín konání: ", $this->datumBezNul($aktivitaPlan->sKurz->date_zacatek).' - '. $this->datumBezNul($aktivitaPlan->sKurz->date_konec), 1);
                    $this->pdf->TiskniSaduBunek($kurzSadaBunek);
                    if ($counter == $count-1) {
                        $potrebneMisto = $dolniokrajAPaticka+$mistoDatumPodpisy;
                    } else {
                        $potrebneMisto = $dolniokrajAPaticka;
                    }
                    if (($this->pdf->h - $potrebneMisto - $this->pdf->getY()) < ($this->pdf->getY() - $yPositionBefore)) {
                        $this->pdf->AddPage();
                    }
                }
            }
        } else {
            $bezAktivit = new Projektor2_PDF_Blok();
            $bezAktivit->Odstavec("Účastník nemá naplánovány žádné konkrétní aktivity projektu.");
            $this->pdf->TiskniBlok($bezAktivit);
        }

        //##################################################################################################
        $this->pdf->Ln(5);
        $this->tiskniMistoDatum($this->context[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT][Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR."datum_vytvor_smlouvy"]);
        $this->tiskniPodpisy(Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT);
    }
}