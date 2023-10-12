<?php
use Pdf\Model\Block;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Sjpo_Souhlas extends Projektor2_View_PDF_Common {
    const MODEL_SMLOUVA = "smlouva->";

    public function createPDFObject() {
        $textPaticky = "Souhlas účastníka projektu s poskytováním osobních údajů “ ".$this->context["file"];
        $this->createHeaderFooter($this->sessionStatus->getUserStatus()->getProjekt(), $textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "Souhlas účastníka projektu s poskytováním osobních údajů";
        $textyNadpisu[] = 'Projekt „S jazyky za prací v Plzni a okolí“';
        $this->tiskniTitul($textyNadpisu, FALSE);

        $strana = new Block;
            $strana->Nadpis("Účastník projektu:");
            $strana->ZarovnaniNadpisu("L");
            $strana->VyskaPismaNadpisu(11);
            $this->pdfRenderer->renderBlock($strana);
        $this->tiskniOsobniUdaje(self::MODEL_SMLOUVA);
        $dohoda1 = new Block;
                $dohoda1->Nadpis("Prohlášení");
                $dohoda1->ZarovnaniNadpisu("C");
                $dohoda1->VyskaPismaNadpisu(12);
        $this->pdfRenderer->renderBlock($dohoda1);
        //**********************************************
        $blok = new Block;
            $blok->Odstavec("Tímto výslovně prohlašuji, že souhlasím se zpracováním, užitím a uchováním veškerých mých osobních a citlivých údajů správcem a zpracovatelem údajů, kterým je Grafia, společnost s ručením omezeným, sídlo: Budilova 1511/4, 301 21 Plzeň, IČ: 47714620, získaných při realizaci projektu v rozsahu uvedeném v mnou poskytnuté dokumentaci (Dohoda o účasti v projektu, registrační dotazník, strukturovaný životopis, reference apod.) a v rozsahu mnou osobně sdělených údajů zaznamenaných pracovníkem správce a včetně informací získaných při testování, pohovorech, pracovní diagnostice, zjišťování kulturních, týmových či osobnostních způsobilostí a kompetencí a to pro potřeby realizace projektu a pro účely zprostředkování zaměstnání a pro mou prezentaci potenciálnímu zaměstnavateli jako příjemci údajů.");
            $blok->PridejOdstavec("Konkrétně se jedná o základní osobní údaje (např. jméno a příjmení, datum a místo narození, rodinný stav, občanství, pohlaví, získané tituly), dále jde o údaj o zdravotním stavu v rozsahu nezbytně potřebném pro posouzení nabídky zaměstnání v povoláních vyžadujících zvýšenou fyzickou a psychickou odolnost (konkrétně slovní prohlášení o zdravotním stavu – např. „dobrý“ či „bez omezení“ nebo „s omezením“, informace o skutečnosti zda mám či nemám změněnou pracovní schopnost, informace o invaliditě a jejím stupni), dále jde o informace týkající se kontaktních údajů včetně trvalého bydliště, telefonu a e-mailu a o informace o získaném vzdělání, současném postavení na trhu práce a dosavadní pracovní praxi, znalostech a dovednostech, představách a požadavcích na mnou hledanou práci a dalších souvisejících údajů pro účely realizace projektových aktivit a pro účel zprostředkování zaměstnání.");
            $blok->PridejOdstavec("Výslovně souhlasím s tím, aby mnou poskytnuté osobní údaje byly společností Grafia užity pro řízení a plánování aktivit při realizaci projektu, individuální poradenství pro účely mého pracovního uplatnění a předány potenciálním zaměstnavatelům  v postavení uživatele osobních údajů pro účel zprostředkování zaměstnání. Tento souhlas uděluji společnosti Grafia s.r.o., se sídlem Plzeň, Budilova 4, IČO: 47714620, jakožto správci (dále jen správce), a to na dobu trvání mé účasti v projektu dle této smlouvy a na dobu 12 měsíců po jejím skončení.");
            $blok->PridejOdstavec("Pokud předám svůj životopis, průvodní dopis, dotazník, doklady o vzdělání a praxi, reference, jiné podklady a doklady či jejich kopie, ve kterých budou uvedena osobní data, beru na vědomí, že správce nenese za ochranu v nich uvedených osobních dat žádnou odpovědnost. V případě předání takových podkladů a dokladů či jejich kopií souhlasím s tím, že tyto doklady budou předány potenciálnímu zaměstnavateli nebo budou pro potenciálního zaměstnavatele zhotoveny jejich kopie pro účel zprostředkování zaměstnání.");
            $blok->PridejOdstavec("Byl jsem seznámen se skutečností, že zaměstnanci správce, jiné fyzické osoby, které zpracovávají osobní údaje na základě smlouvy se správcem nebo zpracovatelem, a další osoby, které v rámci plnění zákonem stanovených oprávnění a povinností přicházejí do styku s osobními údaji u správce nebo zpracovatele, jsou povinni zachovávat mlčenlivost o osobních údajích a o bezpečnostních opatřeních, jejichž zveřejnění by ohrozilo zabezpečení osobních údajů.");
            $blok->PridejOdstavec(" Byl jsem informován, že tyto údaje mohou být využívány třetí osobou pověřenou poskytovatelem podpory, event. Evropskou komisí nebo MPSV, a to pouze za účelem kontroly.");
            $blok->PridejOdstavec("Je mi známo, že mohu kdykoli výše uvedené souhlasy odvolat.");
            $blok->Radkovani(1.00);
        $this->pdfRenderer->renderBlock($blok);

        $this->tiskniMistoDatum($this->context[self::MODEL_SMLOUVA ."datum_vytvor_smlouvy"]);
        $this->tiskniPodpisy(self::MODEL_SMLOUVA);
    }
}

?>
