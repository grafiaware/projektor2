<?php
use Pdf\Model\Block;
use Pdf\Model\SadaBunek;

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
* Description of 
*
* @author pes2704
*/
class Projektor2_View_PDF_Ap_IP0 extends Projektor2_View_PDF_Common {
    const MODEL_PLAN     = "plan->";   //--vs
    const MODEL_DOTAZNIK = "dotaznik->";

    public function createPDFObject() {
        $textPaticky = "Individuální plán účastníka v projektu „Alternativní práce v Plzeňském kraji“ - část 1  ".$this->context["file"];      
        $this->createHeaderFooter($this->sessionStatus->getUserStatus()->getProjekt(), $textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 1";
        $textyNadpisu[] = 'Projekt „Alternativní práce v Plzeňském kraji“';
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************
        $this->tiskniOsobniUdaje(self::MODEL_DOTAZNIK);
        //*****************************************************
        $kurzSadaBunek = new SadaBunek();
        $kurzSadaBunek->SpustSadu(true);
        $aktivity = Config_Aktivity::getAktivityProjektu('AP');   
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']==Config_Aktivity::TYP_PORADENSTVI AND $aktivita['vyberovy']==0) {
                $nabidkaPovinnychPoradenskychAktivit .= $nabidkaPovinnychPoradenskychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }
        
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']==Config_Aktivity::TYP_KURZ AND $aktivita['vyberovy']==0) {
                $nabidkaPovinnychKurzovychAktivit .= $nabidkaPovinnychKurzovychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }

        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']==Config_Aktivity::TYP_PORADENSTVI AND $aktivita['vyberovy']==1) {
                $nabidkaVyberovychPoradenskychAktivit .= $nabidkaVyberovychPoradenskychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }
        
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']==Config_Aktivity::TYP_KURZ AND $aktivita['vyberovy']==1) {
                $nabidkaVyberovychKurzovychAktivit .= $nabidkaVyberovychKurzovychAktivit ? ', '.$aktivita['nadpis'] : $aktivita['nadpis'];
            }
        }

        $blok = new Block;
            $blok->Nadpis("Individuální plán");            
            $blok->PridejOdstavec("První část IP je předběžný plán průběhu účasti v projektu, který se bude během projektu vyvíjet, doplňovat a výsledný průběh účasti v projektu bude zachycen v druhé části IP.");
            if($nabidkaPovinnychPoradenskychAktivit) {
            $blok->PridejOdstavec("Účastníkovi projektu jsou naplánovány tyto základních poradenské aktivity: ".$nabidkaPovinnychPoradenskychAktivit.'.');
            }
            if($nabidkaPovinnychKurzovychAktivit) {            
            $blok->PridejOdstavec("Účastníkovi projektu jsou naplánovány tyto základní kurzy, školení: ".$nabidkaPovinnychKurzovychAktivit.'.');
            }
            if($nabidkaVyberovychPoradenskychAktivit AND !$nabidkaVyberovychKurzovychAktivit) {  
            $blok->PridejOdstavec("Účastníkovi projektu mohou být dále naplánovány aktivity vybrané z těchto výběrových poradenských aktivit: ".$nabidkaVyberovychPoradenskychAktivit.'.');
            }
            if(!$nabidkaVyberovychPoradenskychAktivit AND $nabidkaVyberovychKurzovychAktivit) {  
            $blok->PridejOdstavec("Účastníkovi projektu mohou být dále naplánovány aktivity vybrané z těchto výběrových kurzů, školení, setkání a diagnostiky: ".$nabidkaVyberovychKurzovychAktivit.'.');
            }            
            if($nabidkaVyberovychPoradenskychAktivit AND $nabidkaVyberovychKurzovychAktivit) {  
            $blok->PridejOdstavec("Účastníkovi projektu mohou být dále naplánovány aktivity vybrané z těchto výběrových poradenských aktivit, kurzů, školení, setkání a diagnostiky: ".$nabidkaVyberovychPoradenskychAktivit.', '.$nabidkaVyberovychKurzovychAktivit.'.');
            }
            $blok->PridejOdstavec("Účastníkovi projektu mohou být dále naplánovány aktivity vybrané z dalších doplňkových výběrových aktivit.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdfRenderer->renderBlock($blok);        
        //##################################################################################################
        $this->tiskniMistoDatum($this->context[self::MODEL_PLAN ."datum_vytvor_dok_plan"]);
        $this->tiskniPodpisy(self::MODEL_DOTAZNIK);      
    }
}
?>
