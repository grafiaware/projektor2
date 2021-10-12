<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Mb_Smlouva extends Projektor2_View_PDF_Common {
    const MODEL_SMLOUVA = "smlouva->";   //--vs

    public function createPDFObject() {
        $nazevProjektu = '„Moje budoucnost“';
        $textPaticky = "Dohoda o účasti v projektu $nazevProjektu ".$this->context["file"];
        $this->setHeaderFooter($textPaticky);
        $this->initialize();  // vytvoří $this->pdf
        //*****************************************************
        $textyNadpisu[] = "DOHODA O ÚČASTI V PROJEKTU ";
        $textyNadpisu[] = $nazevProjektu;
//        $this->tiskniTitul($textyNadpisu, TRUE);
        //*****************************************************
        $this->pdf->Ln(15);
        $strany = new Projektor2_PDF_Blok;
        $strany->Nadpis("S t r a n y   d o h o d y ");
        $strany->MezeraPredNadpisem(0);
        $strany->ZarovnaniNadpisu("L");
        $strany->VyskaPismaNadpisu(11);
        $this->pdf->TiskniBlok($strany);
        $this->pdf->Ln(2);

        $this->tiskniGrafiaUdaje();
        $this->pdf->Ln(2);

        $a = new Projektor2_PDF_Blok();
        $a->Odstavec("a        ");
        $this->pdf->TiskniBlok($a);
        $this->pdf->Ln(2);

        $this->tiskniOsobniUdaje(self::MODEL_SMLOUVA);  //--vs
        $this->pdf->Ln(2);

        $spolecneUzaviraji = new Projektor2_PDF_Blok;
        $spolecneUzaviraji->Odstavec("Příjemce a Účastník společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“) uzavírají níže uvedeného dne, měsíce a roku tuto dohodu:" );
        $this->pdf->TiskniBlok($spolecneUzaviraji);
        $this->pdf->Ln(10);
        $this->tiskniTitul($textyNadpisu, FALSE);

        //********************************************************
        $odsazeniTextuZleva = 0;
        $sirkaCisla = 3;

        $defaultBlok = new Projektor2_PDF_Blok;
        $defaultBlok->OdsazeniZleva($odsazeniTextuZleva);

        $defaultBlokCislovani1 = clone $defaultBlok;
        $defaultBlokCislovani1->Predsazeni($sirkaCisla);

        $odsazenyBlokCislovani1 = clone $defaultBlok;
        $odsazenyBlokCislovani1->OdsazeniZleva($defaultBlokCislovani1->odsazeniZleva + $sirkaCisla);

        $defaultBlokCislovani2 = clone $defaultBlok;
        $defaultBlokCislovani2->Predsazeni($defaultBlokCislovani1->predsazeni + $sirkaCisla);

        $odsazenyBlokCislovani2 = clone $defaultBlok;
        $odsazenyBlokCislovani2->OdsazeniZleva($odsazenyBlokCislovani1->odsazeniZleva + $sirkaCisla);

        $defaultBlokCislovani3 = clone $defaultBlok;
        $defaultBlokCislovani3->predsazeni($defaultBlokCislovani2->predsazeni + $sirkaCisla);

        $odsazenyBlokCislovani3 = clone $defaultBlok;
        $odsazenyBlokCislovani3->OdsazeniZleva($odsazenyBlokCislovani2->odsazeniZleva + $sirkaCisla);
        //********************************************************
        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("1. PREAMBULE");
            $blok->Odstavec("1.1 Účelem dohody uzavírané dle občanského zákoníku a zákona č. 435/2004 Sb., o zaměstnanosti je úprava vzájemného vztahu mezi účastníkem a Příjemcem při provádění aktivit projektu pro fyzické osoby účastnící se grantového projektu implementovaném v Operačním programu zaměstnanost: $nazevProjektu.");
// ??
            $blok->PridejOdstavec("1.2 Hlavním cílem projektu je zvýšit kvalifikaci nezaměstnaným osobám a pomoci jim získat adekvátní pracovní uplatnění. Realizován bude v PMO - Plzeňské metropolitní oblast - na celém jejím území.");
            $blok->PridejOdstavec("1.3 Dílčími cíli jsou aktivizace a motivace, posílení sebevědomí účastníků, sebepoznání a nalezení dovedností účastníků uplatnitelných na trhu práce, lepší porozumění trhu práce posílení stávajících obecných dovednost pro trh práce a jejich rozvoj - komunikační a sociální dovednosti, PC dovednosti, podnikavost, schopnost týmové práce, získání nových profesních dovedností prostřednictvím rekvalifikace, popř. dalších odborných kurzů a intenzívních kurzů odborné angličtiny a němčiny. Jedná se o kurz profesního odborného jazyka ve vazbě na odborné vzdělávání, nalezení vhodného zaměstnání, posílení uplatnitelnost účastníků na trhu práce. Projekt zacílí na úzký kontakt se zaměstnavateli, aby mohl reagovat na aktuální situaci na trhu práce, např. také tím, že rekvalifikace klientů budou v oborech chybějících na trhu práce.");
            $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("2. Předmět dohody");
            $blok->Odstavec("2.1 Předmětem dohody je stanovení podmínek účasti Účastníka na aktivitách projektu $nazevProjektu a úprava práv a povinností Stran dohody při realizaci těchto aktivit.");
        $this->pdf->TiskniBlok($blok);

        $this->pdf->Ln(20);


        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("3. Povinnosti a práva účastníka projektu $nazevProjektu");
            $blok->Odstavec("3.1 Účastník potvrzuje, že se účastnil výběrové schůzky, kde byl seznámen s prezentací projektu $nazevProjektu.");
            $blok->PridejOdstavec("3.2 Účastník se osobně dostavil do poradenského centra, kde poskytl své osobní údaje, údaje o svém vzdělání a předchozích zaměstnáních a další údaje na jejichž základě mu bude vypracován Individuální plán. Účastník se zavazuje, že poskytne Příjemci v maximální míře kopie dokladů osvědčujících uváděné skutečnosti, zejména doklady o ukončeném vzdělání, kurzech a předchozích zaměstnáních.");
            $blok->PridejOdstavec("3.3 Individuální plán se skládá ze dvou částí:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) První část individuálního plánu obsahuje charakteristiku účastníka, která zahrnuje jeho nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o jeho dalším pracovním zařazení atd.");
            $blok->PridejOdstavec("b) Další část individuálního plánu bude dle vyhodnocení první části sestavený plán účasti v projektu, tedy doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce atd.");
            $blok->PridejOdstavec("c) Individuální plán se bude na schůzkách účastníka s poradcem v Konzultačním centru průběžně aktualizovat, doplňovat anebo měnit.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.4 Účastník se zavazuje informovat Příjemce o všech skutečnostech, souvisejících s jeho účastí na projektu, zejména o důvodech absence a o překážkách bránících mu v účasti na aktivitách projektu.");
            $blok->PridejOdstavec("3.5 Účastník se zavazuje k tomu, že veškeré absence na aktivitách, jichž se dle Individuálního plánu má účastnit, do 3 dnů řádně omluví, a to dokladem prokazujícím nemoc, návštěvu lékaře, ošetřování člena rodiny, případně jiným dokladem prokazujícím důvod absence.");
            $blok->PridejOdstavec("3.6 Účastník se zavazuje potvrzovat Příjemci podpisy v Prezenčních listinách nebo v Návštěvní knize svou účast (případně informace o nenastoupení) ve všech aktivitách projektu.");
            $blok->PridejOdstavec("3.7 Účastník se rovněž zavazuje:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) docházet do příslušného poradenského centra na dohodnuté schůzky a spolupracovat s konzultanty projektu v této kanceláři a dalšími pracovníky projektu");
            $blok->PridejOdstavec("b) účastnit se doporučených aktivit uvedených v jednotlivých částech a dodatcích Individuálního plánu");
            $blok->PridejOdstavec("c) účastnit se kurzů projektu $nazevProjektu.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.8 Účastník souhlasí se svým uvedením v seznamu účastníků zařazených do rekvalifikace.");
            $blok->PridejOdstavec("3.9 Účastník, který získal zaměstnání anebo se sebezaměstnal v průběhu své účasti v projektu anebo do 2 měsíců od ukončení účasti:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) zavazuje se informovat do 3 pracovních dnů Příjemce o této skutečnosti");
            $blok->PridejOdstavec("b) souhlasí se svým uvedením v seznamu osob, které získaly ve stanovené době zaměstnání anebo se sebezaměstnaly");
            $blok->PridejOdstavec("c) účastník, který získal zaměstnání, se zavazuje dodat Příjemci kopii své uzavřené pracovní smlouvy");
            $blok->PridejOdstavec("d) účastník, který se sebezaměstnal, doloží Příjemci písemné potvrzení Úřadu práce o ukončení evidence účastníka na vlastní žádost a prohlášení účastníka o podnikání kroků k zahájení podnikání, výpis nebo kopii výpisu z Živnostenského rejstříku potvrzující jeho oprávnění k podnikání.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.10 Účastník se zavazuje podrobit se závěrečnému ověření získaných znalostí a dovedností v každé aktivitě, která to předpokládá.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("4. Ukončení účasti účastníka v projektu");
            $blok->Odstavec("4.1 K ukončení účasti účastníka v projektu $nazevProjektu dojde v následujících případech:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani3;
            $blok->Odstavec("4.1.1 Uplynutím doby určené pro účast účastníka v projektu v případě řádného absolvování projektu účastníkem.");
            $blok->PridejOdstavec("4.1.2 Předčasným ukončením účasti ze strany účastníka:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani3;
            $blok->Odstavec("a) nástupem účastníka do pracovního poměru anebo zahájením podnikání účastníka (sebezaměstnáním), k ukončení dojde nejpozději dnem předcházejícím dnu nástupu účastníka do pracovního poměru anebo dnu sebezaměstnání účastníka (dnu zahájení podnikání)");
            $blok->PridejOdstavec("b) výpovědí této Dohody o účasti v projektu účastníkem z jiného důvodu než nástupu do zaměstnání, k ukončení dojde v den, kdy byla výpověď doručena Příjemci.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani3;
            $blok->Odstavec("4.1.3 Předčasným ukončením účasti ze strany Příjemce, jestliže účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) anebo jiným závažným způsobem maří účel účasti v projektu.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("4.2 V případě, že tato Dohoda bude ze strany Příjemce vypovězena, platí, že vypovězením této Dohody zanikají veškeré závazky Příjemce vůči účastníkovi plynoucí z této Dohody s výjimkou závazku uhradit platby přímé podpory za dobu účastni účastníka v projektu. K ukončení účasti dojde dnem, kdy byla výpověď účastníkovi doručena nebo třicátý den od odeslání.");
            $blok->PridejOdstavec("4.3 Účastník se zavazuje, že se dostaví do Konzultačního centra a podepíše doklad o ukončení účasti účastníka v projektu $nazevProjektu pokud nebude dohodnuto jinak. Přílohou tohoto dokladu bude například kopie pracovní smlouvy, kopie výpovědi, atd.");
            $blok->PridejOdstavec("4.4 Po ukončení účasti účastníka v projektu $nazevProjektu řádným způsobem anebo z důvodu nástupu do zaměstnání získá účastník Osvědčení o absolvování projektu $nazevProjektu.");
            $blok->PridejOdstavec("4.5 Po absolvování Kurzu dovedností pro práce, PC kurzy a jazykových kurzů Příjemce zajistí, že účastník obdrží Osvědčení o absolvování kurzu.");
            $blok->PridejOdstavec("4.6 Po ukončení rekvalifikačního kurzu (zahrnujícího rekvalifikační kurzy a kurzy obsluhy PC) Příjemce zajistí, že rekvalifikační zařízení zhotoví a předá účastníkovi, který kurz úspěšně absolvoval, Osvědčení o rekvalifikaci (případně jiné doklady, například průkazy atd.).");
//            $blok->PridejOdstavec("4.7 Příjemce založí každému účastníkovi jeho Osobní složku, do které bude zakládat, počínaje touto Dohodou o účasti v projektu a Souhlasem s poskytnutím a zpracováním osobních údajů, všechny dokumenty vztahující se k jeho účasti v projektu. Osobní složky budou uloženy po dobu trvání plnění projektu v příslušném Konzultačním centru projektu. Osobní složka každého účastníka projektu bude pro konkrétního účastníka přístupná v době dohodnuté konzultační schůzky v Konzultačním centru.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("5. Doprovodná opatření – druhy přímé podpory pro účastníky:");
// ??
            $blok->Odstavec("5.1. Účastníkovi mohou být při účasti na aktivitách projektu poskytovány příspěvky na náhradu některých nákladů souvisejících s účastí v projektu (tzv. přímá podpora), a to za podmínek stanovených projektem $nazevProjektu. Jedná se o tyto příspěvky:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) příspěvek na cestovné a ubytování");
            $blok->Odstavec("b) příspěvek na péči o dítě a další závislé osoby");
            $blok->PridejOdstavec("c) příspěvek na zapracování");
            $blok->PridejOdstavec("d) příspěvek na zabezpečení jiných výdajů souvisejících s projektem");
        $this->pdf->TiskniBlok($blok);

// ??
//        $blok = clone $defaultBlokCislovani2;
//            $blok->Odstavec("5.2. Bližší specifikace uvedených druhů přímé podpory je uvedena v dokumentu Základní informace účastníka projektu $nazevProjektu.");
//        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("6.  Povinnosti Příjemce");
            $blok->Odstavec("6.1 Příjemce se zavazuje poskytnout Účastníkovi zdarma aktivity projektu. Příjemce je povinen vyvinout úsilí k tomu, aby zabezpečil účastníkovi absolvování aktivit doporučených v Individuálním plánu.");
            $blok->PridejOdstavec("6.2 Příjemce musí informovat účastníka o všech podmínkách účasti v kurzu (například potvrzení od lékaře, nutné očkování) a umožnit mu jejich obstarání.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("7.  Ochrana osobních údajů účastníků");
            $blok->Odstavec("7.1 Účastník souhlasil s poskytnutím a zpracováváním svých osobních údajů v rozsahu, pro účel a na dobu uvedenou v písemném souhlasu, který je samostatným dokumentem. Účastník souhlasí s tím, že neposkytnutí nebo odvolání souhlasu ke zpracování osobních údajů pro účel zprostředkování zaměstnání způsobí omezení nebo vyloučení aktivit příjemce v oblasti zprostředkování zaměstnání účastníka. Tuto skutečnost účastník potvrzuje podpisem této Dohody.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("8. Závěrečná ustanovení");
            $blok->Odstavec("8.1 Tuto Dohodu lze měnit či doplňovat pouze po dohodě smluvních stran formou písemných a číslovaných dodatků");
            $blok->PridejOdstavec("8.2 Tato Dohoda je sepsána ve třech vyhotoveních s platností originálu, přičemž Účastník obdrží jedno a Příjemce dvě vyhotovení.");
            $blok->PridejOdstavec("8.3 Tato Dohoda nabývá platnosti a účinnosti dnem jejího podpisu oběma smluvními stranami; tímto dnem jsou její účastníci svými projevy vázáni.");
            $blok->PridejOdstavec("8.4 Příjemce i Účastník shodně prohlašují, že si tuto Dohodu před jejím podpisem přečetli, že byla uzavřena podle jejich pravé a svobodné vůle, určitě, vážně a srozumitelně, nikoliv v tísni za nápadně nevýhodných podmínek. Smluvní strany potvrzují autentičnost této Dohody svým podpisem.");
        $this->pdf->TiskniBlok($blok);

        //##################################################################################################
        $this->pdf->Ln(5);
        $this->tiskniMistoDatum(self::MODEL_SMLOUVA, $this->context[self::MODEL_SMLOUVA ."datum_vytvor_smlouvy"]);
        $this->tiskniPodpisy(self::MODEL_SMLOUVA);
    }
}

?>
